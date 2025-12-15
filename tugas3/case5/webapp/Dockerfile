FROM webdevops/php-nginx:7.4-alpine
WORKDIR /var/www/html
RUN rm -f /var/www/html/index.html
RUN docker-php-ext-install mysqli pdo pdo_mysql
