# Lead Service API

Микросервис для обработки лидов и создания заявок

## Описание

Сервис предоставляет REST API для:
- Создания и обработки лидов
- Управления данными клиентов
- Формирования заявок

## Требования

- PHP 8.1+
- Laravel 10+
- MySQL 8.0+
- Redis (для кеширования и очередей)

## Установка

1. Склонировать репозиторий:
```bash
git clone https://github.com/your-org/lead-service.git
```

2. Установить зависимости:
```bash
composer install
```

3. Настроить окружение:
```bash
cp .env.example .env
php artisan key:generate
```

4. Запустить миграции:
```bash
php artisan migrate --seed
```

## Запуск

Для разработки:
```bash
php artisan serve
```

Для production:
```bash
php artisan octane:start --server=swoole --workers=4 --task-workers=2
```

## API Документация

Документация доступна в формате OpenAPI 3.0:

- Swagger UI: `http://localhost:8000/api/documentation`
- JSON спецификация: `http://localhost:8000/api/docs.json`

Основные эндпоинты:

| Метод | Путь               | Описание                  |
|-------|--------------------|---------------------------|
| POST  | /api/leads         | Создание нового лида      |
| GET   | /api/leads/{id}    | Получение информации о лиде |

## Примеры запросов

**Создание лида:**
```bash
curl -X POST http://localhost:8000/api/leads \
  -H "Authorization: Bearer {token}" \
  -H "Content-Type: application/json" \
  -d '{
    "first_name": "Иван",
    "last_name": "Иванов",
    "phone": "+79161234567",
    "email": "ivan@example.com",
    "amount": 50000,
    "term": 14,
    "policy_agreement": true
  }'
```

## Тестирование

Запуск тестов:
```bash
php artisan test
```

Покрытие тестами:
```bash
php artisan test --coverage-html=storage/coverage
```

## Развертывание

Сервис поставляется в Docker-контейнере:
```bash
docker-compose up -d --build
```

## Конфигурация

Основные настройки в `.env`:
```ini
DB_CONNECTION=mysql
DB_HOST=lead-mysql
DB_PORT=3306
DB_DATABASE=lead_service
DB_USERNAME=user
DB_PASSWORD=password
DB_ROOT_PASSWORD=root
```
