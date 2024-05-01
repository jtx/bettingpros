FROM php:8.2-cli
WORKDIR /usr/src/myapp
COPY . /usr/src/myapp
ENTRYPOINT [ "php", "./parser.php" ]
CMD []

