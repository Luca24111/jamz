FROM php:8.1-apache

# Estensioni PHP necessarie per Symfony + MySQL (Doctrine)
RUN apt-get update && apt-get install -y \
    git unzip libicu-dev libzip-dev \
    && docker-php-ext-install pdo pdo_mysql intl opcache \
    && a2enmod rewrite


# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Document root su public/
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

WORKDIR /var/www/html
COPY . .

RUN touch .env

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN composer install --no-dev --prefer-dist --no-interaction --optimize-autoloader

RUN mkdir -p var/cache var/log var/sessions \
    public/assets/documents \
    public/assets/images/board-members \
    public/assets/images/events/covers \
    public/assets/images/events/gallery \
    && chown -R www-data:www-data var public/assets

EXPOSE 8080
RUN sed -i 's/80/8080/g' /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf
