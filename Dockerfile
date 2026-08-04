FROM php:8.2-apache

# Install MySQLi extension for PHP
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
