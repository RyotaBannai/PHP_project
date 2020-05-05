FROM php:7.2-fpm

# Install composer
RUN cd /usr/bin && curl -s http://getcomposer.org/installer | php && ln -s /usr/bin/composer.phar /usr/bin/composer
RUN apt-get update \
&& apt-get install -y \
git \
zip \
unzip \
vim

RUN apt-get update \
&& apt-get install -y libpq-dev \
&& docker-php-ext-install pdo_mysql pdo_pgsql \
&& nodejs npm

RUN docker-php-ext-install pcntl

WORKDIR /var/www/html
