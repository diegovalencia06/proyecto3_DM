# 1. Imagen base
FROM php:8.2-apache

# 2. INSTALAR LA EXTENSIÓN MYSQLI (¡Esta es la línea que te falta!)
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# 3. Copiar tus archivos
COPY . /var/www/html/

# 4. Exponer puerto
EXPOSE 80