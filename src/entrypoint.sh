#!/bin/bash
set -e

# Функция для безопасного логирования
log_info() {
    echo "[INFO] $(date '+%Y-%m-%d %H:%M:%S') - $1"
}

log_error() {
    echo "[ERROR] $(date '+%Y-%m-%d %H:%M:%S') - $1" >&2
}

# Проверка существования исходной директории
if [ ! -d "/app" ]; then
    log_error "Source directory /app does not exist!"
    exit 1
fi

# Проверка прав доступа к целевой директории
if [ ! -w "/var/www/html" ]; then
    log_error "No write permissions to /var/www/html"
    exit 1
fi

# Синхронизация файлов
if [ -f "/var/www/html/artisan" ]; then
    log_info "Syncing fresh source to mounted volume..."
    # Используем rsync для более эффективной синхронизации (если доступен)
    if command -v rsync >/dev/null 2>&1; then
        rsync -av --update /app/ /var/www/html/
    else
        cp -r -u /app/. /var/www/html/
    fi
else
    log_info "Mounted volume is empty, extracting full contents..."
    cp -r /app/. /var/www/html/
fi

# Проверка успешности копирования
if [ ! -f "/var/www/html/artisan" ]; then
    log_error "Failed to copy application files!"
    exit 1
fi

# Настройка прав доступа для Laravel
if [ -d "/var/www/html/storage" ]; then
    chmod -R 775 /var/www/html/storage
fi

if [ -d "/var/www/html/bootstrap/cache" ]; then
    chmod -R 775 /var/www/html/bootstrap/cache
fi

log_info "Application setup completed successfully"

# Выполнение переданной команды
exec "$@"
