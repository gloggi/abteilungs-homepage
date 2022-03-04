#!/bin/sh

ENV_FILE=".env"
if [ ! -f "$ENV_FILE" ]; then
    cp .env.example "$ENV_FILE"
fi

npm install
mkdir -p node_modules/.cache && chmod -R 777 node_modules/.cache
cp -r node_modules/* /node_modules-copy-to-host

npm run serve
