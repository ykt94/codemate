FROM php:8.3-fpm

RUN apt update && apt upgrade -y && apt dist-upgrade -y && apt install -y \
    apt-utils \
    openssl \
    zip unzip \
    libzip-dev \
    libmagickwand-dev \
    libargon2-1 \
    pcre2-utils \
    libxml2 \
    libzstd1 \
    libpq-dev \
    libsodium-dev \
    cron \
    curl \
    supervisor \
    jpegoptim pngquant optipng gifsicle webp libavif-bin \
    postgresql-client \
    --no-install-recommends \
    && apt clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN docker-php-ext-install pdo_pgsql zip exif pcntl intl soap sockets opcache sodium \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ && docker-php-ext-install gd \
    && pecl install imagick && docker-php-ext-enable imagick \
    && pecl install redis && docker-php-ext-enable redis \
    && pecl install ds && docker-php-ext-enable ds \
    && pecl install xdebug && docker-php-ext-enable xdebug

ENV COMPOSER_ALLOW_SUPERUSER 1
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && chmod +x /usr/local/bin/composer

COPY ./docker_dev/app/php.ini /usr/local/etc/php/conf.d/zz-php.ini
COPY ./docker_dev/app/schedule /etc/cron.d/schedule
COPY ./docker_dev/app/supervisor.conf /etc/supervisor/conf.d/supervisor.conf

RUN chmod -R 644 /etc/cron.d \
    && crontab /etc/cron.d/schedule

WORKDIR /var/www

RUN mkdir -p /docker-entrypoint.d
COPY ./docker_dev/app/docker-entrypoint.sh /docker-entrypoint.sh
RUN chmod +x /docker-entrypoint.sh
ENTRYPOINT ["/docker-entrypoint.sh"]

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisor.conf"]

EXPOSE 9000
