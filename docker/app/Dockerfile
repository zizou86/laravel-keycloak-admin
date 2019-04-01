FROM php:7.3-cli

MAINTAINER Maikel van Maurik

RUN apt-get clean && apt-get update && apt-get install -y locales

RUN locale-gen en_US.UTF-8
RUN locale-gen nl_NL.UTF-8

ENV LANG en_US.UTF-8
ENV LANGUAGE en_US:en
ENV LC_ALL en_US.UTF-8

ENV TZ=UTC
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN apt-get update \
    && apt-get install -y gnupg2 curl zip unzip git software-properties-common supervisor wget sudo apt-utils \
    && wget -O - https://packagecloud.io/gpg.key | sudo apt-key add - \
    && add-apt-repository -y ppa:ondrej/php \
    && apt-get update \
    && apt-get install -y wget beanstalkd 7.3-fpm 7.3-cli 7.3-gd \
    && php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer \
    && mkdir /run/php \
    && apt-get remove -y --purge software-properties-common \
    && apt-get -y autoremove \
    && apt-get clean

COPY php-fpm.conf /etc/php/7.3/fpm/php-fpm.conf

EXPOSE 80

COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

CMD ["/usr/bin/supervisord"]
