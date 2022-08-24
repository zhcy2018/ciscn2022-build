FROM php:5.6.9-apache

COPY ./src/ /var/www/html/
COPY ./flag /
COPY ./readflag /
COPY conf.ini /usr/local/etc/php/conf.d
RUN chmod 777 -R /var/www/html && chown -R root:www-data /var/www/html

RUN apt update && apt-get install libgmp-dev -y 
RUN ln -s /usr/include/x86_64-linux-gnu/gmp.h /usr/include/gmp.h&& docker-php-ext-install gmp
RUN chmod +x /readflag&&\
    chown root /readflag&&\
    chmod u+s /readflag&&\
    chmod 700 /flag
# RUN apt update
# RUN apt install -y strace
# COPY install-php-extensions /usr/local/bin/
# RUN chmod uga+x /usr/local/bin/install-php-extensions && sync && \
#     install-php-extensions curl
EXPOSE 80