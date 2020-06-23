FROM composer:latest

RUN apk add --no-cache mysql-client curl
RUN docker-php-ext-install pdo_mysql

# install dbmate for performing migrations
RUN curl -fsSL -o /usr/local/bin/dbmate \
    https://github.com/amacneil/dbmate/releases/download/v1.8.0/dbmate-linux-musl-amd64 \
    && chmod +x /usr/local/bin/dbmate

# install DBDiff for creating migrations from changes in DB
RUN git clone https://github.com/DBDiff/DBDiff.git /dbdiff
WORKDIR /dbdiff
RUN composer install
RUN ln -s /dbdiff/dbdiff /usr/local/bin/dbdiff
RUN ln -s /db/create /usr/local/bin/create

WORKDIR /
CMD ["migrate"]
ENTRYPOINT ["dbmate", "--wait"]
