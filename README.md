# ruang-curhat

docker-compose run --rm -d composer install 

docker-compose run --rm -d npm install 

//CREATE .env : refer ke .env.example

docker-compose run --rm -d artisan key:generate

docker-compose up mysql php

docker-compose run --rm -d artisan migrate


//KALAU KENA ERROR DEPENDENCIES

docker-compose run --rm -d composer dump-autoload
docker-compose run --rm -d composer update --no-scripts
docker-compose run --rm -d composer update
