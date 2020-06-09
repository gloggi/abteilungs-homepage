#!/bin/sh

ENV_FILE=".env"
if [ ! -f "$ENV_FILE" ]; then
    cp .env.example "$ENV_FILE"
fi

npm install
cp -r node_modules/* /node_modules-copy-to-host

npm run serve
