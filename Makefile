up:
	docker-compose -f ./environment/docker-compose.yml --env-file ./.env up --remove-orphans -d

build: files-copy
	docker-compose -f ./environment/docker-compose.yml --env-file ./.env build

down:
	docker-compose -f ./environment/docker-compose.yml down --remove-orphans

db-create:
	docker exec -it api-mysql sh -c "mysql -u root < /docker-entrypoint-initdb.d/createdb.sql"

composer-install:
	docker exec -it api-php bash -c "composer install"

composer-update:
	docker exec -it api-php bash -c "composer update"

files-copy:
	cp ./config/.env.local ./.env
	cp ./environment/mysql/docker-entrypoint-initdb.d/createdb.sql.example ./environment/mysql/docker-entrypoint-initdb.d/createdb.sql

db-migrate:
	docker exec -it api-php sh -c "php artisan migrate"

db-seed:
	docker exec -it api-php sh -c "php artisan db:seed"

route-clear:
	docker exec -it api-php sh -c "php artisan route:clear"

config-cache:
	docker exec -it api-php sh -c "php artisan config:cache"

code-coverage:
	docker exec -it api-php sh -c "composer coverage"

nginx-check:
	docker exec -it api-nginx sh -c "nginx -T"
