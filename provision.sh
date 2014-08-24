#!/bin/sh

# configure locale
#sudo dpkg-reconfigure locales

# install packages
sudo apt-get update
sudo apt-get upgrade
sudo apt-get install apache2 php5 php5-mysql php5-dev libpcre3-dev gcc make

# install phalcon
mkdir ~/src
cd ~/src
git clone --depth=1 git://github.com/phalcon/cphalcon.git
cd cphalcon/build
sudo ./install
