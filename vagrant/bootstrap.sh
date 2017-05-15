#!/usr/bin/env bash

# Debian install scripts

# Install apache2 and create a link between webroot and synced folder.
apt-get update
apt-get install -y apache2

# Install mongo db.
apt-key adv --keyserver hkp://keyserver.ubuntu.com:80 --recv 0C49F3730359A14518585931BC711F9BA15703C6
# Debian
echo "deb http://repo.mongodb.org/apt/debian jessie/mongodb-org/3.4 main" > /etc/apt/sources.list.d/mongodb-org-3.4.list

# Ubuntu 16
echo "deb [ arch=amd64,arm64 ] http://repo.mongodb.org/apt/ubuntu xenial/mongodb-org/3.4 multiverse" > sudo /etc/apt/sources.list.d/mongodb-org-3.4.list

apt-get update
apt-get install -q -y mongodb-org

# Install php.
apt-get install apt-transport-https lsb-release ca-certificates
wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg
echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/php.list
apt-get update
apt-get install -y pkg-config php7.1 php7.1-cli php7.1-dev php-pear
pecl install mongodb

systemctl enable mongod.service

cd /var/www/html
ln -s /vagrant/servers/webserver/public/ lora
