# Guía para Configurar el Proyecto

Sigue estos pasos después de clonar el repositorio para configurar y utilizar el proyecto correctamente:

## 1º Crear un archivo .env:

Crea un archivo .env en la raíz del proyecto y define todas las variables de entorno necesarias. 

## 2º Instalar las dependencias de Composer

**composer install**

## 3º Generar las claves JWT: Como las claves JWT no están en el repositorio, tu compañero necesitará generar las suyas propias.

Si no tienes instalado OPENSSL en el ordenador, instalalo (enlace para windows:)

**Instalar OPENSSL:** https://slproweb.com/products/Win32OpenSSL.html

**php bin/console lexik:jwt:generate-keypair**

Si falla ese comando, hay que crear manualmente la carpeta jwt en config (/config/jwt) y ejecutar lo siguiente:
Durante la generación, se le pedirá que proporcione una frase de contraseña. Esta debe ser la misma que la que se establece en JWT_PASSPHRASE en el archivo .env (Si el comando de arriba funciona esto no es necesario, lo hace automáticamente)

**mkdir config/jwt**

**openssl genrsa -out config/jwt/private.pem -aes256 4096**

**openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem**

## 4º Crear la base de datos y las tablas: Si estás utilizando Doctrine, puedes crear la base de datos y las tablas utilizando los comandos de consola de Doctrine:

**php bin/console doctrine:database:create**

**php bin/console make:migration**

**php bin/console doctrine:migrations:migrate**

## 5º Para permitir CORS con nuestro proyecto de frontend utilizamos nelmio/cors-bundle:

Ese paquete se instala al hacer composer install (ya que lo tenemos previamente en el composer.json)

Y modificamos el fichero /config/packages/nelmio_cors.yaml:

nelmio_cors:
defaults:
origin_regex: false
allow_origin: ['http://localhost:3001']
allow_methods: ['GET', 'OPTIONS', 'POST', 'PUT', 'PATCH', 'DELETE']
allow_headers: ['Content-Type', 'Authorization']
expose_headers: ['Link']
max_age: 3600
paths:
'^/api/': ~

## 6º Finalmente, iniciar el servidor de desarrollo de Symfony:

**symfony server:start**

## Enlace de ayuda:

https://www.binaryboxtuts.com/php-tutorials/symfony-6-json-web-tokenjwt-authentication/

## A funcionar!!
