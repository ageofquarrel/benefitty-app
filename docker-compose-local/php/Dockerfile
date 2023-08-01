FROM php:8.1-fpm-alpine

RUN mkdir -p /var/www/app

# suprevisor
COPY docker-compose-local/php/supervisord.conf /etc/supervisord.conf
RUN apk add --no-cache supervisor
RUN mkdir -p "/etc/supervisor/logs"

# composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# php ini
ADD docker-compose-local/php/php.ini /usr/local/etc/php/conf.d/app.ini

# main libs
RUN set -ex \
    	&& apk --no-cache add postgresql-dev nodejs yarn npm zip libzip-dev libpng-dev\
    	&& docker-php-ext-install pdo pdo_pgsql zip gd

WORKDIR /var/www/app

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]

EXPOSE 9000