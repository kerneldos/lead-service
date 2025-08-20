FROM php:8.2-fpm

ARG APP_NAME
ARG USER_ID=1000
ARG GROUP_ID=1000

WORKDIR /app

# Создаём пользователя и группу
RUN groupadd -g ${GROUP_ID} appuser && \
    useradd -u ${USER_ID} -g appuser -m -d /home/appuser -s /bin/bash appuser

# Установка системных зависимостей
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip git curl && \
    docker-php-ext-install pdo_mysql zip && \
    rm -rf /var/lib/apt/lists/*

# Установка расширений PHP
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions http

# Установка Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Создание рабочих директорий с правильными правами
RUN mkdir -p /var/www/html /app && \
    chown -R ${USER_ID}:${GROUP_ID} /var/www/html /app

# Переключение на пользователя appuser ПЕРЕД копированием файлов
USER ${USER_ID}

# Копирование файлов (теперь под правильным пользователем)
COPY --chown=${USER_ID}:${GROUP_ID} . .

# Установка зависимостей Composer
RUN composer install --no-dev --optimize-autoloader

# Настройка прав для записи (если директории существуют)
RUN if [ -d "storage" ]; then chmod -R 775 storage; fi && \
    if [ -d "bootstrap/cache" ]; then chmod -R 775 bootstrap/cache; fi

# Копирование и подготовка entrypoint скрипта
USER root
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh && \
    chown ${USER_ID}:${GROUP_ID} /entrypoint.sh

# Возврат к пользователю appuser
USER ${USER_ID}

WORKDIR /var/www/html

EXPOSE 9000

ENTRYPOINT ["/entrypoint.sh"]
CMD ["php-fpm"]
