FROM php:7.0-apache-stretch

# install system tools
RUN apt-get update && \
    apt-get install -y \
        git \
        git-core \
        curl \
        apt-utils \
        gnupg2 \
        openssl \
        openssh-server \
        sshpass \
        ssl-cert \
        sudo \
        unzip \
        vim \
        vim-common \
        vim-runtime \
        vim-gui-common \
        wget \
        zip \
        zsh \
        make \
        fonts-powerline \
        libjpeg-dev \
        libpng-dev \
        libpq-dev \
        libmcrypt-dev \
        libxml2-dev \
        build-essential \
        cmake \
        python-dev \
        debconf \
        locales \
        exuberant-ctags

RUN pecl install apcu
RUN pecl install redis
RUN docker-php-ext-configure gd --with-png-dir=/usr --with-jpeg-dir=/usr && \
    docker-php-ext-configure pdo_mysql --with-pdo-mysql=mysqlnd && \
    docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql && \
    docker-php-ext-configure mysqli --with-mysqli=mysqlnd

RUN docker-php-ext-install calendar && \
    docker-php-ext-install gd && \
    docker-php-ext-install mbstring && \
    docker-php-ext-install mysqli && \
    docker-php-ext-install opcache && \
    docker-php-ext-install pcntl && \
    docker-php-ext-install pdo && \
    docker-php-ext-install pdo_mysql && \
    docker-php-ext-install sockets && \
    docker-php-ext-install zip

RUN docker-php-ext-enable apcu && \
    docker-php-ext-enable redis

RUN sed -i -e 's/# en_US.UTF-8 UTF-8/en_US.UTF-8 UTF-8/' /etc/locale.gen && \
    locale-gen
ENV LANG en_US.UTF-8
ENV LANGUAGE en_US:en
ENV LC_ALL en_US.UTF-8

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN mkdir -p ~/.composer
COPY .composer/auth.json ~/.composer/auth.json
COPY .composer/config.json ~/.composer/config.json

# Install node
RUN wget -qO- https://deb.nodesource.com/setup_8.x | sudo -E bash -
RUN apt-get install -y nodejs
RUN npm install -g csslint jshint jsonlint handlebars

#OH MY ZSH
RUN wget https://github.com/robbyrussell/oh-my-zsh/raw/master/tools/install.sh -O - | zsh || true

RUN echo "alias ll='ls -alh'" >> /root/.zshrc

#wbevim
RUN git clone https://github.com/krampstudio/webvim.git ~/.vim
RUN ln -s ~/.vim/.vimrc ~/.vimrc
RUN ln -s ~/.vim/.tern-project ~/.tern-project

COPY .eslintrc.json ~/
RUN ln -s  ~/.eslintrc.json /var/www/html

COPY ./apache2/taoce.conf /etc/apache2/sites-available/taoce.conf
COPY ./apache2/taoinvalsi.conf /etc/apache2/sites-available/taoinvalsi.conf
COPY ./apache2/taoact.conf /etc/apache2/sites-available/taoact.conf
COPY ./apache2/taonccer.conf /etc/apache2/sites-available/taonccer.conf
COPY ./apache2/taopremium.conf /etc/apache2/sites-available/taopremium.conf
COPY ./apache2/taocentral.conf /etc/apache2/sites-available/taocentral.conf


RUN mkdir -p /etc/ssl
COPY ./apache2/ssl/host.pem /etc/ssl/
COPY ./apache2/ssl/host.key /etc/ssl/

RUN mkdir -p /var/log/tao
RUN chown -R www-data:www-data /var/log/tao

RUN a2enmod headers && \
    a2enmod rewrite && \
    a2enmod ssl && \
    a2dissite 000-default && \
    a2ensite taoce && \
    a2ensite taoinvalsi && \
    a2ensite taoact && \
    a2ensite taonccer && \
    a2ensite taopremium && \
    a2ensite taocentral

WORKDIR /var/www/html

EXPOSE 80
EXPOSE 443
CMD ["apache2-foreground"]
