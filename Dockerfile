# Usa la imagen oficial de PHP con Apache
FROM php:7.4-apache

# Habilita los módulos de Apache necesarios
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Copia los archivos del proyecto al contenedor
COPY . /var/www/html/

# Expon el puerto en el que Apache está escuchando
EXPOSE 80
