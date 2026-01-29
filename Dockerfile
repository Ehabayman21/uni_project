FROM php:8.0-apache

# تثبيت MySQLi
RUN docker-php-ext-install mysqli
