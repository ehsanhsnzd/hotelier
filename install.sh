cp .env.docker .env
docker-compose up -d
docker-compose run --rm --no-deps app composer install
docker-compose run --rm --no-deps app php artisan key:generate
docker-compose run --rm --no-deps app php artisan storage:link
docker-compose run --rm --no-deps app composer dumpautoload
docker-compose run --rm --no-deps app php artisan migrate
docker-compose run --rm --no-deps app php artisan db:seed
