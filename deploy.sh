#!/bin/bash

echo "Iniciando despliegue automático de Laravel en el directorio actual..."

# 1. Descargar Composer.phar siempre
echo "Descargando Composer..."
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === 'dac665fdc30fdd8ec78b38b9800061b4150413ff2e3b6f88543c636f7cd84f6db9189d43a81e5503cda447da73c7e5b6') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); exit(1); } echo PHP_EOL;"
php composer-setup.php
if [ $? -ne 0 ]; then
    echo "Error al instalar Composer. Abortando despliegue."
    exit 1
fi
php -r "unlink('composer-setup.php');"

# 2. Instalar dependencias con Composer
echo "Instalando dependencias de Composer..."
php composer.phar update
if [ $? -ne 0 ]; then
    echo "Error al instalar dependencias con Composer. Abortando despliegue."
    exit 1
fi

# 3. Configurar el archivo .env si no existe
if [ ! -f ".env" ]; then
    echo "Archivo .env no encontrado. Copiando .env.example..."
    cp .env.example .env
else
    echo "Archivo .env encontrado."
fi

# 4. Generar la clave de la aplicación
echo "Generando clave de la aplicación..."
php artisan key:generate
if [ $? -ne 0 ]; then
    echo "Error al generar la clave de la aplicación. Abortando despliegue."
    exit 1
fi

# Mensaje final
echo "Despliegue completado. Recuerda configurar la base de datos en el archivo .env y ejecutar las migraciones manualmente si es necesario."
exit 0
