FROM php:8.2-apache

# 1. Instalar dependencias del sistema necesarias (git y unzip son obligatorios para Composer)
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    && docker-php-ext-install mysqli pdo pdo_mysql \
    && docker-php-ext-enable mysqli

# 2. Instalar COMPOSER (El gestor de paquetes)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 3. Configurar el directorio de trabajo
WORKDIR /var/www/html

# 4. Copiar SOLO los archivos de definición de librerías primero
COPY composer.json composer.lock ./

# 5. EJECUTAR LA INSTALACIÓN (Esto crea la carpeta vendor perfecta para Linux)
RUN composer install --no-dev --optimize-autoloader --no-interaction

# 6. Copiar el resto de tu proyecto
COPY . .

# 7. Dar permisos a Apache para que pueda leer los archivos
RUN chown -R www-data:www-data /var/www/html

# 8. Exponer el puerto
EXPOSE 80