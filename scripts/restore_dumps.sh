#!/bin/bash

set -eo pipefail

ENV_FILE="../.env"

# Function for safely reading variables from .env
read_env_var() {
    local var_name="$1"
    local default_value="$2"

    if [ ! -f "$ENV_FILE" ]; then
        echo "$default_value"
        return
    fi

    local value
    value=$(grep -E "^${var_name}=" "$ENV_FILE" | cut -d= -f2- | sed 's/^[[:space:]]*//;s/[[:space:]]*$//')

    if [ -z "$value" ]; then
        echo "$default_value"
    else
        echo "$value"
    fi
}

# Read variables with default values
MYSQL_USER=$(read_env_var "DB_USERNAME" "root")
MYSQL_PASS=$(read_env_var "DB_PASSWORD" "")
CONTAINER=$(read_env_var "MYSQL_CONTAINER" "mysql-auth")

# Paths
DUMP_DIR="../docker/mysql/dump"
PROCESSED_DIR="$DUMP_DIR/processed"
LOG_FILE="../docker/mysql/logs/mysql_restore.log"

# Create necessary directories
mkdir -p "$PROCESSED_DIR" "$(dirname "$LOG_FILE")"

# Get list of new dump files
mapfile -t new_dumps < <(find "$DUMP_DIR" -maxdepth 1 -name '*.gz' -type f -printf "%f\n")

if [ ${#new_dumps[@]} -eq 0 ]; then
    echo "$(date) - No new dumps to restore" >> "$LOG_FILE"
    exit 0
fi

# Function to restore a single dump
restore_dump() {
    local dump_file="$1"

    echo "$(date) - Starting restore of $dump_file" >> "$LOG_FILE"

    if [ -n "$MYSQL_PASS" ]; then
        gunzip -c "$DUMP_DIR/$dump_file" | docker exec -i "$CONTAINER" mysql -u"$MYSQL_USER" -p"$MYSQL_PASS"
    else
        gunzip -c "$DUMP_DIR/$dump_file" | docker exec -i "$CONTAINER" mysql -u"$MYSQL_USER"
    fi

    if [ $? -eq 0 ]; then
        mv "$DUMP_DIR/$dump_file" "$PROCESSED_DIR/$dump_file"
        echo "$(date) - Successfully restored $dump_file" >> "$LOG_FILE"
    else
        echo "$(date) - Error restoring $dump_file" >> "$LOG_FILE"
        return 1
    fi
}

# Restore all new dump files
for dump in "${new_dumps[@]}"; do
    restore_dump "$dump"
done

echo "$(date) - Dump restoration completed" >> "$LOG_FILE"
