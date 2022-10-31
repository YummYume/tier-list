FROM php:8.1-fpm-alpine

RUN apk add --no-cache --update \
    icu-dev supervisor && \
    docker-php-ext-install pdo pdo_mysql intl && \
    docker-php-ext-configure intl && \
    docker-php-ext-enable pdo pdo_mysql intl

COPY ./docker/php/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Vanilla
WORKDIR /vanilla

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY ./vanilla .

RUN apk update && apk add -u yarn
RUN yarn install

# jQuery
WORKDIR /jquery

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY ./jquery .

RUN apk update && apk add -u yarn
RUN yarn install

# Stimulus
WORKDIR /stimulus

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY ./stimulus .

RUN apk update && apk add -u yarn
RUN yarn install

WORKDIR /

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
