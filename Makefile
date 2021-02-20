up:
	docker-compose -f ./environment/docker-compose.yml up --remove-orphans -d

build: copy-files
	docker-compose -f ./environment/docker-compose.yml build

down:
	docker-compose -f ./environment/docker-compose.yml down --remove-orphans

create-db:
	docker exec -it api-mysql sh -c "mysql -u root -p < /docker-entrypoint-initdb.d/createdb.sql"

install:
	docker exec -it api-php bash -c "composer install"

copy-files:
	cp ./config/.env.local ./web/.env
	cp ./environment/mysql/docker-entrypoint-initdb.d/createdb.sql.example ./environment/mysql/docker-entrypoint-initdb.d/createdb.sql

migrate-db:
	docker exec -it web-php sh -c "php artisan migrate"
