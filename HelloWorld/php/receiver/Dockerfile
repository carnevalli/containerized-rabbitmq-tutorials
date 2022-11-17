from php:7.4.33-alpine as dev

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions @composer sockets

RUN adduser --disabled-password phpuser

COPY ./src/ /app/

WORKDIR /app

RUN mkdir .composer && chown -R phpuser /app

USER phpuser

RUN composer install

ENTRYPOINT ["php", "receiver.php"]