FROM php:8.0.14-cli

RUN apt-get update && apt-get install -y \
    libxml2-dev \
    zip \
    unzip
RUN docker-php-ext-install bcmath
RUN pecl install pcov && docker-php-ext-enable pcov

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
