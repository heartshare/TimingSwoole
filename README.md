# TimingSwoole
TimingSwoole - 毫秒级定时任务管理系统
### 1\.项目简介

使用swoole开发的毫秒级定时任务管理系统   <br>
为了更加方便快捷的启动程序，	
自定义php数组 用于存储数据

项目没有用到redis 和 mysql，有需要的小伙伴可以自行增加

并将日志存到本地文件夹下

可以通过docker一键启动
``
docker run -it -p 7017:7017 --name Timingswoole-php -d zzyx/timingswoole:v1
``
```
https://XXXXXX:7017/index.html
```
项目的启发：微信企业号机器人，定时发送消息到内部群

项目的功能：目前可以定时执行post请求和shell请求

联系qq:2449028906
如有问题或者有更好的改进意见可以直接联系本人
~~~bash

~~~
