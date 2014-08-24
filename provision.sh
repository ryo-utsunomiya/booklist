#!/bin/sh

# configure locale
#sudo dpkg-reconfigure locales

# install packages
sudo apt-get update -y
sudo apt-get upgrade -y
sudo apt-get install -y apache2 php5 php5-mysql php5-dev libpcre3-dev gcc make vim tree

# install phalcon
cd /tmp
git clone --depth=1 git://github.com/phalcon/cphalcon.git
cd cphalcon/build
sudo ./install

sudo cp /var/www/booklist/server/etc/apache2/sites-available/default /etc/apache2/sites-available/default
sudo cp /var/www/booklist/server/etc/php5/conf.d/30-phalcon.ini /etc/php5/conf.d/30-phalcon.ini

sudo service apache2 restart