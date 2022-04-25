FROM php:8.1-apache

RUN apt-get update && apt-get upgrade -y

RUN a2enmod rewrite
