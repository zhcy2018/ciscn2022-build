## Docker 环境示例

### 1. Dockerfile样例  

```docker
# 尽量使用能在 hub.docker.com 上查看到 Dockerfile或ubuntu原生镜像
FROM dasctfbase/web_php73_apache_mysql

# 安装（如php apache mysql等
RUN apt update

# 拷贝源码到相应目录下。
COPY src /var/www/html

# 如需操作数据库请将 sql 文件拷贝到 /db.sql
COPY files/db.sql /db.sql

# 如有上传文件等操作请务必将权限设置正确！
# RUN chown www-data:www-data /var/www/html/uploads/

# 修改权限
WORKDIR /var/www/html
RUN chown -R ciscn:ciscn . && \
	chmod -R 750 .

# 启动项
COPY ./start.sh /etc/my_init.d/
RUN chmod u+x /etc/my_init.d/start.sh

# 请声明对外暴露端口
EXPOSE 80
```

### 2. start.sh样例

```sh

#!/bin/bash

# 启动服务，例如apache2
service apache2 start
# 为了适应各种docker版本，mysql的启动命令建议如下（mysqld除外）
find /var/lib/mysql -type f -exec touch {} \; && service mysql start
```
