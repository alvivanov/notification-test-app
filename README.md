# Notification test app

### Требования:
- Docker и docker-compose

## Запуск в local окружении
Для запуска необходим docker и docker-compose. Все команды выполняются в корне проекта.

1) Скопировать .env.example в .env
2) В `.env` можно настроить под себя параметры проекта, если указанные порты или ip пересекаются с существующими
3) По умолчанию включен xdebug, настроенный под работу на Mac OS. Для работы на Linux надо указать в docker/.env `XDEBUG_CLIENT_HOST={{ ip в локальной сети }}`. Если xdebug не нужен, то в docker/.env указать `XDEBUG=false`
4) Выполнить `docker compose up -d`
5) После старта всех контейнеров выполнить миграции: `docker compose exec app ./yii migrate --interactive=0`

Проект по-умолчанию доступен по ссылке [http://127.0.0.1:8700](http://127.0.0.1:8700).

### Запуск PhpCsFixer
`docker compose exec app vendor/bin/php-cs-fixer fix`

### Запуск тестов
`docker compose exec app vendor/bin/codecept run`

### Установка пакетов composer
`docker compose exec composer require {{ package }}`

