FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
WORKDIR /usr/src/bettingpros
COPY . /usr/src/bettingpros
COPY docker-entrypoint.sh /usr/src/bettingpros/docker-entrypoint.sh
RUN chmod +x /usr/src/bettingpros/docker-entrypoint.sh

ENTRYPOINT ["/usr/src/bettingpros/docker-entrypoint.sh"]
