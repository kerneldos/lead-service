#!/bin/bash

# Устанавливаем правильные права для WSL и Docker
USER_ID=$(id -u)
GROUP_ID=$(id -g)

chown -R "$USER_ID":"$GROUP_ID" ../src
find ../src -type d -exec chmod 755 {} \;
find ../src -type f -exec chmod 644 {} \;
chmod -R 775 ../src/storage ../src/bootstrap ../src/database
chmod 640 ../src/.env
echo "✅ Laravel permissions fixed!"
