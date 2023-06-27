FROM php:8.1-apache
WORKDIR /var/www/html
COPY . /var/www/html
RUN apt-get update -y
RUN apt-get install libyaml-dev -y
RUN  pecl install yaml && echo "extension=yaml.so" > /usr/local/etc/php/conf.d/ext-yaml.ini && docker-php-ext-enable yaml
EXPOSE 80