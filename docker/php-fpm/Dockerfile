FROM php:8.1-fpm

RUN apt-get update
RUN apt-get install -y \
    wget \
    zlib1g-dev \
    libicu-dev \
    libzip-dev \
    libssh-dev \
    gettext-base && apt-get clean

# create docker user
RUN useradd -m docker && echo "docker:docker" | chpasswd

RUN mkdir -p /www/app
RUN cd /www/app && wget https://getcomposer.org/installer && php installer && mv composer.phar /usr/local/bin/composer

RUN pecl install xdebug && docker-php-ext-enable xdebug
RUN docker-php-ext-install zip

COPY ./xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
