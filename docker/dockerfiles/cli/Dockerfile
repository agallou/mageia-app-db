FROM php:7.2

RUN echo "date.timezone=Europe/Paris" >> "/usr/local/etc/php/php.ini"
RUN docker-php-ext-install pdo_mysql

RUN echo "error_reporting = E_ALL" >> /usr/local/etc/php/php.ini

RUN apt-get update && apt-get install -y libicu-dev zlib1g-dev
RUN docker-php-ext-install zip

RUN apt-get update && apt-get install -y git
RUN apt-get update && apt-get install -y wget unzip
RUN apt-get update && apt-get install -y wget default-mysql-client

ARG uid=1008
ARG gid=1008

RUN groupadd -g ${gid} localUser \
    && useradd -u ${uid} -g ${gid} -m -s /bin/bash localUser

RUN usermod -a -G www-data localUser
