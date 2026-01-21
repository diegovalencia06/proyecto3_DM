# Usar la imagen oficial de PHP con Apache
FROM php:8.2-apache

# Copiar los archivos de tu proyecto a la carpeta pública del servidor
COPY . /var/www/html/

# Decirle a Docker qué puerto vamos a usar (Render usa el 80 por defecto en estos casos)
EXPOSE 80