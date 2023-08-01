#!/bin/sh
function runnginx() {
    nginx -s quit
    ln -sf /dev/stdout /var/log/nginx/access.log && ln -sf /dev/stderr /var/log/nginx/error.log
    nginx -g "daemon off;"
}

function runphp() {
    nginx -s quit
    composer install --optimize-autoloader --no-dev
    php artisan migrate
    php artisan l5-swagger:generate
    php artisan optimize:clear
    php artisan queue:restart
    php artisan deploy:seed
    #bash -c 'touch storage/logs/{external,laravel,supervisord,order}.log'
    chmod 777 -R storage/
    chmod 777 -R bootstrap/cache
    /usr/bin/supervisord -c /etc/supervisord.conf
}

$1
