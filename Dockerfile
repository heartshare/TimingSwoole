FROM php:7.3-alpine3.8

WORKDIR /swoole/html
RUN echo http://mirrors.ustc.edu.cn/alpine/v3.7/main > /etc/apk/repositories \
	&& echo http://mirrors.ustc.edu.cn/alpine/v3.7/community >> /etc/apk/repositories \
    && apk --no-cache add git autoconf gcc g++ make openssl openssl-dev \
    && pecl install swoole \
	&& docker-php-ext-enable swoole
RUN git clone https://github.com/zyx7017/TimingSwoole.git 
RUN chmod -R 777 /swoole/html 
WORKDIR /swoole/html/TimingSwoole
	ENTRYPOINT ["/bin/ash","./.start.sh", "-g", "daemon off;"]
	EXPOSE 7017


	# Run构建镜像       docker build -t Timingswoole:php .   
	# Run启动镜像       docker run -it -p 7017:7017 --name Timingswoole-php -d Timingswoole:php
	# Run这个是alpine命令不是bash       /bin/ash