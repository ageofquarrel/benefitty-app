FROM php:8.1-fpm-alpine

# main libs and suprevisord
RUN set -ex && \
    apk --no-cache add postgresql-dev nodejs yarn npm zip libzip-dev bash nginx wget supervisor libpng-dev &&\
    docker-php-ext-install pdo pdo_pgsql zip gd

# composer
# RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN wget -O - -v https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN mkdir -p /var/www/app
RUN mkdir -p /etc/supervisor/logs

COPY ./docker-compose-local/php/supervisord.conf /etc/supervisord.conf
COPY ./docker-compose/nginx/conf.d/nginx.conf /etc/nginx/http.d/default.conf
COPY ./docker-compose/nginx/nginx.conf /etc/nginx/nginx.conf
COPY . /var/www/app
ADD docker-compose-local/php/php.ini /usr/local/etc/php/conf.d/app.ini


RUN chmod -R a+x /var/www/app/docker-compose/run_service.sh

WORKDIR /var/www/app

ENTRYPOINT ["sh", "/var/www/app/docker-compose/run_service.sh"]

EXPOSE 9000