#!/bin/bash
# This script is used to configure the docker daemon
echo "Listen 9090" >> /etc/apache2/ports.conf
cd /etc/apache2/sites-available
a2ensite admin.conf
service apache2 reload
cd /var/www/admin
composer install
