<p>docker-compose -f docker-compose-local.yml build --no-cache</p>
docker-compose -f docker-compose-local.yml up -d
docker exec -it app_php sh
composer install
