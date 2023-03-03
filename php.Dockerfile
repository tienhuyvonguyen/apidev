FROM php:7.4.3-apache
RUN docker-php-ext-install mysqli pdo pdo_mysql &&\
        apt update && apt upgrade -y &&\
apt install git -y &&\
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" &&\
php -r "if (hash_file('sha384', 'composer-setup.php') === '55ce33d7678c5a611085589f1f3ddf8b3c52d662cd01d4ba75c0>php composer-setup.php &&\
php -r "unlink('composer-setup.php');" &&\
mv composer.phar /usr/local/bin/composer
COPY ./mysql-init-files/webapp.sql /docker-entrypoint-initdb.d/
