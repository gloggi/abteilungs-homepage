FROM node:latest
WORKDIR /usr/app
COPY package.json .
RUN npm install --quiet
COPY . .
EXPOSE 8080
ENTRYPOINT bash docker-entrypoint.sh