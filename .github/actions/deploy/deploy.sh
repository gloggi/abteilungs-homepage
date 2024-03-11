#!/bin/bash
set -euo pipefail


### BACKEND PREPARATION

cd api

rm -f .env
cp .env.example .env

if [ "$APP_NAME" != "" ]; then
  sed -ri "s~^#APP_NAME=.*$~APP_NAME=$APP_NAME~" .env
fi

sed -ri "s~^APP_ENV=.*$~APP_ENV=$APP_ENV~" .env
sed -ri "s~^APP_KEY=.*$~APP_KEY=$APP_KEY~" .env
sed -ri "s~^APP_DEBUG=.*$~APP_DEBUG=$APP_DEBUG~" .env
sed -ri "s~^APP_URL=.*$~APP_URL=$BACKEND_URL~" .env

sed -ri "s~^DB_HOST=.*$~DB_HOST=$DB_HOST~" .env
sed -ri "s~^DB_DATABASE=.*$~DB_DATABASE=$DB_DATABASE~" .env
sed -ri "s~^DB_USERNAME=.*$~DB_USERNAME=$DB_USERNAME~" .env
sed -ri "s~^DB_PASSWORD=.*$~DB_PASSWORD=$DB_PASSWORD~" .env

sed -ri "s~^SESSION_SECURE_COOKIE=.*$~SESSION_SECURE_COOKIE=true~" .env

sed -ri "s~^MIDATA_BASE_URL=.*$~MIDATA_BASE_URL=$MIDATA_BASE_URL~" .env
sed -ri "s~^MIDATA_CLIENT_UID=.*$~MIDATA_CLIENT_UID=$MIDATA_CLIENT_UID~" .env
sed -ri "s~^MIDATA_CLIENT_SECRET=.*$~MIDATA_CLIENT_SECRET=$MIDATA_CLIENT_SECRET~" .env
sed -ri "s~^MIDATA_REDIRECT_URI=.*$~MIDATA_REDIRECT_URI=$FRONTEND_URL/login~" .env
sed -ri "s~^MIDATA_ID=.*$~MIDATA_ID=$MIDATA_ID~" .env

sed -ri "s~^FRONTEND_URL=.*$~FRONTEND_URL=$FRONTEND_URL~" .env

docker compose run --no-deps --entrypoint "composer install --no-dev" backend

PHP_MIN_VERSION_ID=$(grep -Po '(?<=\(PHP_VERSION_ID >= )[0-9]+(?=\))' vendor/composer/platform_check.php)

cd ..


### FRONTEND PREPARATION

cd frontend

rm -f .env
cp .env.example .env

sed -ri "s~^VITE_BACKEND_URL=.*$~VITE_BACKEND_URL=$BACKEND_URL~" .env

docker compose run --rm --no-deps --entrypoint "/bin/sh -c 'npm install && npm run build --no-unsafe-inline'" frontend

cd ..


### DEPLOY ALL FILES

echo "Scanning ssh host keys of \"$SSH_HOST\" (showing hashed output only):"
ssh-keyscan -H $SSH_HOST

echo "Showing configured know_hosts:"
cat ~/.ssh/known_hosts

echo "Checking PHP version:"
ssh -l $SSH_USERNAME -T $SSH_HOST <<EOF
  set -e
  php -v
  cd $SSH_BACKEND_DIRECTORY
  php -r "if(PHP_VERSION_ID<${PHP_MIN_VERSION_ID:-80100}){echo \"Your PHP version is too old\\nYou might be able to use these instructions on your hosting as well: https://www.cyon.ch/support/a/php-standardversion-fur-die-kommandozeile-festlegen\n\";exit(1);}"

  if [ -d "api" ]; then
    cd api
    php artisan down --render=updating
  fi
EOF

echo "Uploading backend files to the server..."
cd api
lftp <<EOF
  set sftp:auto-confirm true
  set dns:order "inet"
  open -u $SSH_USERNAME, sftp://$SSH_HOST
  cd $SSH_BACKEND_DIRECTORY
  mirror -enRv -x '^\.' -x '^storage/logs/.*' -x '^storage/app/.*' -x '^storage/framework/maintenance.php$' -x '^storage/framework/down$' -x '^resources/fonts/.*' -x '^resources/js/.*' -x '^resources/css/.*'
  mirror -Rv -f .env
EOF
cd ..
echo "All backend files uploaded to the server."

echo "Uploading frontend files to the server..."
cd frontend/dist
lftp <<EOF
  set sftp:auto-confirm true
  set dns:order "inet"
  open -u $SSH_USERNAME, sftp://$SSH_HOST
  cd $SSH_FRONTEND_DIRECTORY
  mirror -enRv -x '^\.'
  mirror -Rv -f .htaccess
EOF
cd ..
echo "All frontend files uploaded to the server."

ssh -l $SSH_USERNAME -T $SSH_HOST <<EOF
  cd $SSH_BACKEND_DIRECTORY
  php artisan storage:link
  php artisan migrate --force

  if [ "$SEED_DB" == "true" ] ; then
    php artisan db:seed --force
  fi

  php artisan thumbnails:copy
  php artisan settings:create

  php artisan config:cache
  php artisan route:cache
  php artisan view:cache

  php artisan up
EOF
