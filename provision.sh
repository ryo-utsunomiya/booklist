#!/bin/sh

# configure locale
#sudo dpkg-reconfigure locales

# install packages
sudo apt-get update -y
sudo apt-get upgrade -y
sudo apt-get install -y apache2 php5 php5-mysql php5-dev libpcre3-dev gcc make
sudo apt-get install -y vim tree

#sudo debconf-set-selections <<< 'mysql-server mysql-server/root-password password root'
#sudo debconf-set-selections <<< 'mysql-server mysql-server/root-password_admin password root'
#sudo apt-get install -y mysql-server

# install phalcon
cd /tmp
git clone --depth=1 git://github.com/phalcon/cphalcon.git
cd cphalcon/build
sudo ./install

sudo cp /var/www/booklist/server/etc/apache2/sites-available/default /etc/apache2/sites-available/default
sudo cp /var/www/booklist/server/etc/php5/conf.d/30-phalcon.ini /etc/php5/conf.d/30-phalcon.ini
sudo cp /var/www/booklist/server/home/vagrant/.bashrc /home/vagrant/.bashrc

sudo service apache2 restart

mkdir ~/bin && cd ~/bin
curl -s http://getcomposer.org/installer | php
sudo ln -s ~/bin/composer.phar /usr/local/bin/composer
composer require "phalcon/devtools" "dev-master"
sudo ln -s /home/vagrant/bin/vendor/bin/phalcon.php /usr/local/bin/phalcon

# todo
# - MySQLは手動インストールで...
# sudo apt-get install mysql-server
# 
