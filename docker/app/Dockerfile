FROM ubuntu:18.04

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
    && apt-get install -y nginx curl zip unzip git sqlite3 software-properties-common supervisor wget sudo apt-utils \
    && wget -O - https://packagecloud.io/gpg.key | sudo apt-key add - \
    && add-apt-repository -y ppa:ondrej/php \
    && apt-get update \
    && apt-get install -y wget beanstalkd 7.1-fpm 7.1-cli php-memcached \
        7.1-curl 7.1-xdebug \
    && php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer \
    && mkdir /run/php \
    && apt-get remove -y --purge software-properties-common \
    && apt-get -y autoremove \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* \
    && echo "daemon off;" >> /etc/nginx/nginx.conf \
    && ln -sf /dev/stdout /var/log/nginx/access.log \
    && ln -sf /dev/stderr /var/log/nginx/error.log

#RUN sudo apt-get update
#RUN sudo apt-get install -y unzip xvfb libxi6 libgconf-2-4 default-jdk gnupg2
#RUN sudo curl -sS -o - https://dl-ssl.google.com/linux/linux_signing_key.pub | apt-key add
#RUN sudo echo "deb [arch=amd64]  http://dl.google.com/linux/chrome/deb/ stable main" >> /etc/apt/sources.list.d/google-chrome.list
#RUN sudo apt-get -y update
#RUN sudo apt-get -y install google-chrome-stable
#RUN wget https://chromedriver.storage.googleapis.com/73.0.3683.68/chromedriver_linux64.zip
#RUN unzip chromedriver_linux64.zip
#RUN sudo mv chromedriver /usr/bin/chromedriver \
#    && sudo chown root:root /usr/bin/chromedriver \
#    && sudo chmod +x /usr/bin/chromedriver
#RUN wget https://selenium-release.storage.googleapis.com/3.13/selenium-server-standalone-3.13.0.jar
#RUN mv selenium-server-standalone-3.13.0.jar /home/selenium-server-standalone.jar
#RUN wget http://www.java2s.com/Code/JarDownload/testng/testng-6.8.7.jar.zip
#RUN unzip testng-6.8.7.jar.zip

COPY php-fpm.conf /etc/php/7.1/fpm/php-fpm.conf

EXPOSE 80

COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

CMD ["/usr/bin/supervisord"]




