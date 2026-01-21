FROM php:8.2-apache

# 1. Actualizar linux e instalar mysqli
RUN apt-get update && apt-get install -y \
    && docker-php-ext-install mysqli pdo pdo_mysql \
    && docker-php-ext-enable mysqli

# 2. Copiar tu proyecto
COPY . /var/www/html/

# 3. Exponer el puerto
EXPOSE 80