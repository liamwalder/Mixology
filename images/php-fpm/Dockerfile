FROM php:7.2.3-fpm

## Update and install packages
RUN apt-get update
RUN apt-get install -y libmcrypt-dev ffmpeg gnupg

## Install Node version 9
RUN curl -sL https://deb.nodesource.com/setup_9.x | bash
RUN apt-get install -y nodejs

RUN docker-php-ext-install pdo_mysql

## Installing Git
RUN apt-get -y install git

## Installing ZIP and UNZIP
RUN apt-get -y install zip unzip
RUN apt-get install -y zlib1g-dev
RUN docker-php-ext-install zip

## Installing Yarn
RUN curl -o- -L https://yarnpkg.com/install.sh | bash

## Installing composer
RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer

## Laravel Global Install
RUN composer global require "laravel/installer"