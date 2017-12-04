FROM php:7.0-fpm


RUN apt-get update && apt-get install -y \
    unzip \
    curl \
    wget \
	libfreetype6-dev \
	libjpeg62-turbo-dev \
	libmcrypt-dev \
	libpng12-dev \
    git \
    zsh


RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version

RUN docker-php-ext-install pdo \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install -j$(nproc) iconv mcrypt \
	&& docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
	&& docker-php-ext-install -j$(nproc) gd \
	&& docker-php-ext-install bcmath

#### XDebug
RUN pecl install xdebug
RUN docker-php-ext-enable xdebug

#### ZSH
RUN chsh -s $(which zsh)
RUN wget https://github.com/robbyrussell/oh-my-zsh/raw/master/tools/install.sh -O - | zsh || true

RUN useradd -ms /bin/zsh simpleapi

RUN apt-get update && apt-get install -y nano

WORKDIR /app
