FROM php:7.3-apache

EXPOSE 80

WORKDIR /var/www/html

RUN apt-get update && apt-get upgrade -y \
	&& apt-get install -y libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libmcrypt-dev \
        libicu-dev \
	    libxml2-dev \
	    libzip-dev \
	    libc-client-dev \
	    libkrb5-dev \
	    libssl-dev \
	    iputils-ping \
	    git \
	    curl \
	    wget \
	    unzip \
	    nano \
	    cron \
	&& rm -rf /var/lib/apt/lists/*

RUN pecl install mcrypt \
	&& docker-php-ext-configure imap --with-kerberos --with-imap-ssl \
	&& docker-php-ext-install -j$(nproc) mysqli pdo pdo_mysql mbstring gd xml zip imap \
	&& docker-php-ext-enable mysqli pdo pdo_mysql mbstring mcrypt xml gd zip imap \
	&& a2enmod rewrite


# installing php composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
	&& php composer-setup.php install \
	&& php -r "unlink('composer-setup.php');"


COPY --chown=www-data:www-data . .

# Fixing permissions.
RUN chown -R www-data:www-data /var/www/html \
	&& find /var/www/html -type d -exec chmod 775 {} \; \
	&& find /var/www/html -type f -exec chmod 664 {} \;

# creating/switching from root to a user.
USER www-data

#installing dependencies
RUN php composer.phar update && php composer.phar install --no-cache



#USER root
# cronjobs
#RUN chmod 755 .cron && /usr/bin/crontab -u www-data .cron
#CMD cron & apache2-foreground
