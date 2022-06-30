FROM php:8.0-fpm

RUN apt-get update \
    && apt-get install -y \
    git \
    zip \
    iproute2 \
    nano \
    wget \
    libpq-dev \
    libxml2-dev \
    libxslt1-dev \
    gcc \
    make \
    autoconf \
    libc-dev \
    pkg-config \
    libssl-dev \
    librabbitmq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql soap xsl opcache

RUN apt-get install -y libicu-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl

RUN pecl install amqp-1.11.0beta \
    && docker-php-ext-enable amqp

RUN pecl install xdebug-3.1.0 \
    && docker-php-ext-enable xdebug

RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/ \
    && ln -s /usr/local/bin/composer.phar /usr/local/bin/composer

RUN wget https://get.symfony.com/cli/installer -O - | bash \
    && mv /root/.symfony/bin/symfony /usr/local/bin/symfony

RUN usermod -u 1000 www-data

CMD php-fpm
