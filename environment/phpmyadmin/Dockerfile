FROM phpmyadmin/phpmyadmin:latest

RUN echo '' >> /usr/local/etc/php/conf.d/php-phpmyadmin.ini \
 && echo '[PHP]' >> /usr/local/etc/php/conf.d/php-phpmyadmin.ini \
 && echo 'post_max_size = 2G' >> /usr/local/etc/php/conf.d/php-phpmyadmin.ini \
 && echo 'upload_max_filesize = 2G' >> /usr/local/etc/php/conf.d/php-phpmyadmin.ini
