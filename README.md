**Локальный деплой проекта:**

```
cp .env.example .env
```

```
docker-compose -f docker-compose-local.yml build --no-cache
```
```
docker-compose -f docker-compose-local.yml up -d
```
```
docker exec -it app_php sh
```
```
composer install
```

```
php artisan migrate
```

```
php artisan queue:work
```

**Swagger по адресу:**
```
http://127.0.0.1/swagger
```
