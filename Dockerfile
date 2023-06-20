FROM php:fpm-alpine3.18

COPY ./ /var/www/html

RUN rm -rf /var/www/html/vendor
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
#RUN cd /var/www/html && composer install --no-dev --no-interaction --no-progress --optimize-autoloader
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress --no-suggest --no-scripts

ENV APP_ENV=prod
