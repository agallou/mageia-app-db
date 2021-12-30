FROM php:7.2-apache

RUN echo "date.timezone=Europe/Paris" >> "/usr/local/etc/php/php.ini"
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install mbstring
RUN echo "Include sites-enabled/" >> /etc/apache2/apache2.conf

RUN a2enmod rewrite

COPY apache.conf /etc/apache2/sites-available/000-default.conf

ARG uid=1008
ARG gid=1008
RUN groupadd -g ${gid} localUser \
    && useradd -u ${uid} -g ${gid} -m -s /bin/bash localUser

RUN usermod -a -G www-data localUser

RUN sed --in-place "s/User \${APACHE_RUN_USER}/User localUser/" /etc/apache2/apache2.conf
RUN sed --in-place  "s/Group \${APACHE_RUN_GROUP}/Group localUser/" /etc/apache2/apache2.conf

