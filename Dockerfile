FROM php:8.3-fpm-alpine
RUN apk add --update $PHPIZE_DEPS linux-headers libpq-dev nano \
    && docker-php-ext-install pdo_pgsql bcmath opcache \
    && pecl install apcu && docker-php-ext-enable apcu \
    && pecl clear-cache
ARG xdebug
RUN if [ "$xdebug" = "true" ]; then apk add linux-headers $PHPIZE_DEPS && pecl install xdebug && docker-php-ext-enable xdebug; fi;
