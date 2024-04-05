#!/bin/bash
set -euo pipefail

### Set default SSH port if not provided
SSH_PORT=${SSH_PORT:-22}


PHP_CMD="${PHP_PATH:-php}"
echo "Using PHP command: $PHP_CMD"

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
sed -ri "s~^MIDATA_CLIENT_ID=.*$~MIDATA_CLIENT_ID=$MIDATA_CLIENT_UID~" .env
sed -ri "s~^MIDATA_CLIENT_SECRET=.*$~MIDATA_CLIENT_SECRET=$MIDATA_CLIENT_SECRET~" .env
sed -ri "s~^MIDATA_REDIRECT_URI=.*$~MIDATA_REDIRECT_URI=$FRONTEND_URL/login~" .env
sed -ri "s~^MIDATA_ID=.*$~MIDATA_ID=$MIDATA_ID~" .env

sed -ri "s~^FRONTEND_URL=.*$~FRONTEND_URL=$FRONTEND_URL~" .env

sed -ri "s~^MAIL_MAILER=.*$~MAIL_MAILER=$MAIL_MAILER~" .env
sed -ri "s~^MAIL_HOST=.*$~MAIL_HOST=$MAIL_HOST~" .env
sed -ri "s~^MAIL_PORT=.*$~MAIL_PORT=$MAIL_PORT~" .env
sed -ri "s~^MAIL_USERNAME=.*$~MAIL_USERNAME=$MAIL_USERNAME~" .env
sed -ri "s~^MAIL_PASSWORD=.*\$~MAIL_PASSWORD=\"$MAIL_PASSWORD\"~" .env
sed -ri "s~^MAIL_ENCRYPTION=.*$~MAIL_ENCRYPTION=$MAIL_ENCRYPTION~" .env
sed -ri "s~^MAIL_FROM_ADDRESS=.*$~MAIL_FROM_ADDRESS=$MAIL_FROM_ADDRESS~" .env
sed -ri "s~^MAIL_FROM_NAME=.*\$~MAIL_FROM_NAME=\"$MAIL_FROM_NAME\"~" .env

sed -ri "s~^DEPLOYMENT_SECRET_KEY=.*\$~DEPLOYMENT_SECRET_KEY=\"$DEPLOYMENT_SECRET_KEY\"~" .env

docker compose run --no-deps --entrypoint "composer install --no-dev" backend

PHP_MIN_VERSION_ID=$(grep -Po '(?<=\(PHP_VERSION_ID >= )[0-9]+(?=\))' vendor/composer/platform_check.php)

cd ..


### FRONTEND PREPARATION

cd frontend

rm -f .env
cp .env.example .env

sed -ri "s~^VITE_BACKEND_URL=.*$~VITE_BACKEND_URL=$BACKEND_URL~" .env
sed -ri "s~^VITE_APP_NAME=.*$~VITE_APP_NAME=$APP_NAME~" .env

docker compose run --rm --no-deps --entrypoint "/bin/sh -c 'npm install && npm run build --no-unsafe-inline'" frontend

cd ..


### DEPLOY ALL FILES

echo "Scanning ssh host keys of \"$SSH_HOST\" on port \"$SSH_PORT\" (showing hashed output only):"
ssh-keyscan -p $SSH_PORT -H $SSH_HOST

echo "Showing configured know_hosts:"
cat ~/.ssh/known_hosts

echo "Checking PHP version:"
ssh -l $SSH_USERNAME -p $SSH_PORT -T $SSH_HOST <<EOF
  set -e
  cd $SSH_BACKEND_DIRECTORY
  ${PHP_CMD} -v -v
  ${PHP_CMD} -r "if(PHP_VERSION_ID<${PHP_MIN_VERSION_ID:-80100}){echo \"Your PHP version is too old\\nYou might be able to use these instructions on your hosting as well: https://www.cyon.ch/support/a/php-standardversion-fur-die-kommandozeile-festlegen\n\";exit(1);}"

  if [ -d "api" ]; then
    cd api
    ${PHP_CMD} artisan down --render=updating
  fi
EOF

echo "Uploading backend files to the server..."
cd api
lftp <<EOF
  set sftp:auto-confirm true
  set dns:order "inet"
  open -u $SSH_USERNAME, sftp://$SSH_HOST -p $SSH_PORT
  cd $SSH_BACKEND_DIRECTORY
  mirror -enRv -x '^\.' -x '^rest-test' -x '^tests' -x '^storage/logs/.*' -x '^storage/app/.*' -x '^storage/framework/maintenance.php$' -x '^storage/framework/down$' -x '^resources/fonts/.*' -x '^resources/js/.*' -x '^resources/css/.*'
  mirror -Rv -f .env
EOF
cd ..
echo "All backend files uploaded to the server."

echo "Uploading frontend files to the server..."
cd frontend/dist
lftp <<EOF
  set sftp:auto-confirm true
  set dns:order "inet"
  open -u $SSH_USERNAME, sftp://$SSH_HOST -p $SSH_PORT
  cd $SSH_FRONTEND_DIRECTORY
  mirror -enRv -x '^\.'
  mirror -Rv -f .htaccess
EOF
cd ..
echo "All frontend files uploaded to the server."

ssh -l $SSH_USERNAME -T $SSH_HOST -p $SSH_PORT <<EOF
  cd $SSH_BACKEND_DIRECTORY

  echo "Executing Laravel deployment commands via secure endpoint..."
  curl -X POST "$BACKEND_URL/api/deploy" \
     -H "Content-Type: application/json" \
     -d "{\"secret_key\":\"$DEPLOYMENT_SECRET_KEY\"}"

  ${PHP_CMD} artisan up
EOF
