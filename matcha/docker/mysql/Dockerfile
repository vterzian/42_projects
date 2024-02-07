FROM mysql

ADD app/config/schema.sql /docker-entrypoint-initdb.d
ADD docker/mysql/my.cnf /etc/mysql/conf.d/max.cnf
