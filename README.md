### API Project

It's just a small API project built by Laravel.

### Guidelines:

- Run `make build` to build docker image
- Run `make up` to start all container

### Folder Structure:

- config: contain env file
- environment: contain mysql, nginx, phpmyadmin and php-fpm Dockerfile
- web: contain laravel sourcecode
- web/src: contain all services of laravel app
- web/routes/routes: is primary routing file
- web/tests: contain all the tests writen by PHPUnit
