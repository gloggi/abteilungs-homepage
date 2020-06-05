FROM alpine:3.11
RUN apk add --no-cache mysql-client curl
RUN curl -fsSL -o /usr/local/bin/dbmate https://github.com/amacneil/dbmate/releases/download/v1.8.0/dbmate-linux-musl-amd64
RUN chmod +x /usr/local/bin/dbmate
CMD ["migrate"]
ENTRYPOINT ["dbmate", "--wait"]
