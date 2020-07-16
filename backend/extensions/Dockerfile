FROM node:12.13.1-alpine

RUN npm install -g @directus/extension-toolkit

WORKDIR /app

ENTRYPOINT ["directus-extensions"]
CMD ["build", "--no-source-maps"]
