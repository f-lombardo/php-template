ARG COMPOSER_VERSION=2.9.5
ARG PHP_VERSION

FROM composer:$COMPOSER_VERSION AS composer
FROM php:${PHP_VERSION}-fpm

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpq-dev \
    libicu-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    openssl \
    curl \
    && apt-get clean

# UID/GID/CONTAINER_USER passati da docker-compose
ARG UID=1000
ARG GID=1000
ARG CONTAINER_USER=www-data

# Crea gruppo e utente con stessi UID/GID dell'utente host
RUN set -eux; \
    if getent group "${CONTAINER_USER}" > /dev/null; then \
        groupmod -o -g "${GID}" "${CONTAINER_USER}"; \
    elif getent group "${GID}" > /dev/null; then \
        groupmod -n "${CONTAINER_USER}" "$(getent group "${GID}" | cut -d: -f1)"; \
    else \
        groupadd -g "${GID}" "${CONTAINER_USER}"; \
    fi; \
    if id -u "${CONTAINER_USER}" > /dev/null 2>&1; then \
        usermod -o -u "${UID}" -g "${GID}" "${CONTAINER_USER}"; \
    else \
        useradd -m -o -u "${UID}" -g "${GID}" "${CONTAINER_USER}"; \
    fi

# Install Composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Install xdebug-3.2.2 This fixed version solves problems developing on Apple Silicon. Check for future versions
RUN pecl install xdebug-3.5.3 \
&& docker-php-ext-enable xdebug

RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip intl bcmath


COPY php-custom.ini /usr/local/etc/php/conf.d/docker-php-custom.ini
COPY xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

ARG COMPOSE_PROJECT_NAME
WORKDIR /var/${COMPOSE_PROJECT_NAME}

ENV COMPOSER_HOME=/tmp/composer \
    COMPOSER_CACHE_DIR=/tmp/composer/cache

RUN mkdir -p "${COMPOSER_CACHE_DIR}" \
    && chown -R "${UID}:${GID}" /tmp/composer

USER $CONTAINER_USER
