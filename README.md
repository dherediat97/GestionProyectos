# Gestión de Proyectos

## Memoria del proyecto



## Prerequisitos
- XAMP o (Apache/PHP/MySQL)
- Composer
- NodeJS


## Entornos de programación usados

### Deploy
- XAMPP(Servidores de Apache y MySQL)

### Editor de código fuente
- VS Code

### Plantilla usada
- [Easy Admin LTE](https://jeroennoten.github.io/Laravel-AdminLTE/)


# Instalación
Clonar Repositorio:
```
git clone https://github.com/dherediat97/GestionProyectos.git
```
Instalar todas las dependencias de composer del proyecto:
```
composer install
```
Instalar todas las dependencias de node:
```
npm install
```
Añadir este fichero a la raíz del proyecto:
```
APP_NAME=gestion_proyectos
APP_ENV=local
APP_KEY=base64:Ir4suSpbXtwUOeJ9tpn5/glWqxCfqGZgoQXtJWEe1hc=
APP_DEBUG=true
APP_URL=http://localhost:9000/
APP_PROFILE_BASE_URL=https://ui-avatars.com/api/?background=0D8ABC&color=fff&name=
APP_VERSION=1.0.0
LAST_SESSION=23:59:59
APP_COMPANY_NAME="Soluciones Informáticas MJ"
APP_LOCALE=es
APP_FALLBACK_LOCALE=es
APP_FAKER_LOCALE=es

APP_MAINTENANCE_DRIVER=file
# APP_MAINTENANCE_STORE=database

PHP_CLI_SERVER_WORKERS=4

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gestion_proyectos
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

CACHE_STORE=database
# CACHE_PREFIX=

MEMCACHED_HOST=127.0.0.1

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=log
MAIL_SCHEME=null
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

```
Crear todas las tablas de las bases de datos usando artisan:
```
php artisan migrate
```
Insertar algunos datos de prueba:
```
php artisan db:seed
```