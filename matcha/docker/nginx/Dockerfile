FROM nginx

COPY docker/nginx/conf.d/default.conf /etc/nginx/conf.d/default.conf
COPY docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY docker/nginx/cert.pem etc/nginx/ssl/cert.pem
COPY docker/nginx/cert.key etc/nginx/ssl/cert.key

ADD . /var/www/html
