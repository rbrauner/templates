FROM php:8.3-fpm-alpine

# args
ARG TZ="Europe/Warsaw"

# envs
ENV TZ=${TZ}

# packages
RUN apk update
RUN apk upgrade
RUN apk add bash tzdata git vim findutils
RUN apk cache clean

# install extensions
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN install-php-extensions opcache

RUN install-php-extensions intl

RUN install-php-extensions pgsql

RUN install-php-extensions pdo_pgsql

# copy config
COPY ./docker/prod/php/php.ini $PHP_INI_DIR/php.ini

# install composer
RUN install-php-extensions @composer

# timezone and localtime
RUN echo $TZ > /etc/timezone
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime

# make sure `/var/www/html` exists
RUN mkdir -p /var/www/html

# working directory
WORKDIR /var/www/html

# make `/var/www/html` safe for git operations
RUN git config --global --add safe.directory /var/www/html
