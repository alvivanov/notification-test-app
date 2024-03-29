# Notification test app

### Требования:
- Docker и docker-compose

## Запуск в local окружении
Для запуска необходим docker и docker-compose. Все команды выполняются в корне проекта.

1) Скопировать .env.example в .env
2) В `.env` можно настроить под себя параметры проекта, если указанные порты или ip пересекаются с существующими
3) Выполнить `docker compose up -d`
4) После старта всех контейнеров выполнить миграции основной БД: `docker compose exec app ./yii migrate --interactive=0`
5) После старта всех контейнеров выполнить миграции тестовой БД: `docker compose exec app tests/bin/yii migrate --interactive=0`

Проект по-умолчанию доступен по ссылке [http://127.0.0.1:8700](http://127.0.0.1:8700).

### Запуск PhpCsFixer
`docker compose exec app vendor/bin/php-cs-fixer fix`

### Запуск тестов
`docker compose exec app vendor/bin/codecept run`

### Установка пакетов composer
`docker compose exec composer require {{ package }}`

## Функционал

### Команда для рассылки уведомлений
`./yii notifications/send-pending`

### REST-API уведомлений
- `POST /notifications`
- `GET /notifications`
- `GET /notifications/<id>`
- `PUT /notifications/<id>`
- `DELETE /notifications/<id>`

Для создания и обновления уведомления необходимо указать сообщение и интегратор:

`{
    "content": string,
    "channel": ["sms"|"telegram"]
}`
