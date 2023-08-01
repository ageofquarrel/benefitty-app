FROM php:8.1-fpm-alpine

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN set -ex \
    	&& apk --no-cache add postgresql-dev nodejs yarn npm zip libzip-dev nginx libpng-dev\
    	&& docker-php-ext-install pdo pdo_pgsql zip gd

RUN mkdir -p /var/www/app
ADD ../.. /var/www/app
WORKDIR /var/www/app

RUN composer update --no-scripts
RUN php artisan optimize:clear
RUN composer require maatwebsite/excel
RUN php artisan vendor:publish --provider="Maatwebsite\Excel\ExcelServiceProvider" --tag=config
RUN php artisan migrate:fresh --seed

ENTRYPOINT ["run_service.sh"]
