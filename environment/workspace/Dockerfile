FROM php:7.3-fpm-stretch

RUN mkdir -p /web

# Install dependencies
RUN apt-get update && apt-get install -y \
    vim \
    git \
    curl

RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
RUN docker-php-ext-configure gd --with-gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ --with-png-dir=/usr/include/
RUN docker-php-ext-install gd

CMD ["php-fpm"]