#!/bin/sh
# arranque del contenedor app: deja laravel listo y siembra la bd
set -e

cd /var/www/html

echo "[entrypoint] santa s.l. - arranque de laboratorio"

# .env
if [ ! -f .env ]; then
    echo "[entrypoint] copiando .env.example a .env"
    cp .env.example .env
fi

# dependencias (el primer build necesita internet)
if [ ! -d vendor ]; then
    echo "[entrypoint] composer install"
    composer install --no-interaction --prefer-dist --no-progress
fi

# permisos de escritura de laravel
mkdir -p storage/framework/cache/data \
         storage/framework/sessions \
         storage/framework/views \
         storage/logs \
         bootstrap/cache \
         public/uploads
chmod -R 777 storage bootstrap/cache public/uploads 2>/dev/null || true

# clave de la app
if ! grep -q "^APP_KEY=base64:" .env; then
    echo "[entrypoint] generando APP_KEY"
    php artisan key:generate --force
fi

# esperar a mysql (--skip-ssl porque el cliente rechaza el cert autofirmado del server)
echo "[entrypoint] esperando a mysql en ${DB_HOST:-db}:${DB_PORT:-3306} ..."
until mysqladmin ping -h"${DB_HOST:-db}" -P"${DB_PORT:-3306}" \
        -u"${DB_USERNAME:-santasl}" -p"${DB_PASSWORD:-santasl}" --skip-ssl --silent 2>/dev/null; do
    sleep 2
done
echo "[entrypoint] mysql ok"

# migraciones + datos de prueba
echo "[entrypoint] migrate --seed"
php artisan migrate:fresh --seed --force

# limpiar caches para que respete el .env del lab
php artisan config:clear || true
php artisan route:clear || true
php artisan view:clear || true

echo "[entrypoint] listo, arrancando: $*"
exec "$@"
