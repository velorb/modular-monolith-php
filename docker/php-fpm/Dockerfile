FROM php:8.4.6-fpm-alpine AS base

RUN apk update && apk upgrade && apk add --no-cache \
    postgresql-dev \
    autoconf \
    shadow

RUN docker-php-ext-install pdo_pgsql

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

FROM base AS dev

RUN apk add --no-cache \
        linux-headers \
        bash \
        make

# Instalacja Xdebug
RUN pecl install xdebug-3.4.2

# Ustawienia konfiguracji Xdebug
ARG XDEBUG_CLIENT_HOST
ARG XDEBUG_CLIENT_PORT

RUN echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini && \
    echo "xdebug.mode=debug,develop,profile,coverage" >> /usr/local/etc/php/conf.d/xdebug.ini && \
    echo "xdebug.force_display_errors=0" >> /usr/local/etc/php/conf.d/xdebug.ini && \
    echo "xdebug.force_error_reporting=0" >> /usr/local/etc/php/conf.d/xdebug.ini && \
    echo "xdebug.start_with_request=trigger" >> /usr/local/etc/php/conf.d/xdebug.ini && \
    echo 'xdebug.output_dir="/var/www/html/app/_ci-cd/reports/dev/profiling"' >> /usr/local/etc/php/conf.d/xdebug.ini && \
    echo "xdebug.profiler_output_name=cachegrind.out.%R.%t" >> /usr/local/etc/php/conf.d/xdebug.ini && \
    echo "xdebug.client_host=${XDEBUG_CLIENT_HOST}" >> /usr/local/etc/php/conf.d/xdebug.ini && \
    echo "xdebug.client_port=${XDEBUG_CLIENT_PORT}" >> /usr/local/etc/php/conf.d/xdebug.ini && \
    echo "xdebug.discover_client_host=0" >> /usr/local/etc/php/conf.d/xdebug.ini && \
    echo "xdebug.idekey=PHPSTORM" >> /usr/local/etc/php/conf.d/xdebug.ini

COPY ./xdebug-enable ./xdebug-disable /usr/local/bin/

ARG HOST_USER_ID
RUN chmod +x /usr/local/bin/xdebug-disable \
    && chmod +x /usr/local/bin/xdebug-enable \
    && usermod -u ${HOST_USER_ID} www-data \
    && groupmod -g ${HOST_USER_ID} www-data

CMD ["php-fpm"]
