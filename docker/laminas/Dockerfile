FROM php:7.3.20-fpm

#LABEL maintainer="getlaminas.org" \
#    org.label-schema.docker.dockerfile="/Dockerfile" \
#    org.label-schema.name="Laminas MVC Skeleton" \
#    org.label-schema.url="https://docs.getlaminas.org/mvc/" \
#    org.label-schema.vcs-url="https://github.com/laminas/laminas-mvc-skeleton"

## Update package information
RUN apt-get update

##  Install zip libraries and extension
RUN apt-get install --yes git zlib1g-dev libzip-dev unzip
RUN docker-php-ext-install zip

### Configure Apache
#RUN a2enmod rewrite
#RUN sed -i 's!/var/www/html!/var/www/public!g' /etc/apache2/sites-available/000-default.conf
#RUN mv /var/www/html /var/www/public

## Install Composer
#ENV COMPOSER_HOME=/var/www/.compose
RUN curl -sS https://getcomposer.org/installer \
  | php -- --install-dir=/usr/local/bin --filename=composer

###
## Additional PHP extensions.  To use these extensions uncomment the 
## leading `# ` from the RUN commands.  These are provided to show 
## examples of including other libraries into the PHP installation.
###

## Install i18n libraries and extensions
RUN apt-get install --yes libicu-dev
RUN docker-php-ext-configure intl
RUN docker-php-ext-install intl

## Install mbstring for i18n string support
RUN docker-php-ext-install mbstring

## MySQL PDO support
RUN docker-php-ext-install pdo_mysql

## Redis support.  igbinary and libzstd-dev are only needed based on redis 
## pecl options
# RUN pecl install igbinary
# RUN docker-php-ext-enable igbinary
# RUN apt-get install --yes libzstd-dev
# RUN pecl install redis
# RUN docker-php-ext-enable redis

ARG SERVER_UID
ARG ENV

RUN if [ $ENV != "production" ] ; then pecl install xdebug-2.8.1 && docker-php-ext-enable xdebug; fi
ADD xdebug.ini /tmp
RUN if [ $ENV != "production" ] ; then mv /tmp/xdebug.ini $PHP_INI_DIR/conf.d/xdebug.ini; else rm /tmp/xdebug.ini; fi


RUN usermod -d /var/www/html -u $SERVER_UID www-data && groupmod -g $SERVER_UID www-data

WORKDIR /var/www/html
