FROM php:fpm-alpine


RUN apk --update --no-cache add git

COPY custom-cmd.sh /usr/bin/custom-cmd

RUN chmod +x /usr/bin/custom-cmd

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /var/www


CMD composer install ; custom-cmd ;  php-fpm 

EXPOSE 9000
