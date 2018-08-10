FROM php:7.2-apache

#RUN apt-get update &&
#    apt-get install wget \
#        nano \

COPY /src/ /var/www/html/

