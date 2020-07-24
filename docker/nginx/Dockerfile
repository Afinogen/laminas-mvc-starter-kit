FROM nginx:1.19.1

ARG SERVER_UID
ARG HOSTNAME
RUN usermod -u $SERVER_UID www-data && groupmod -g $SERVER_UID www-data

COPY ./nginxconfig.io /etc/nginx/nginxconfig.io
COPY ./sites-available/site.local.conf /etc/nginx/conf.d/default.conf
COPY ./snippets /etc/nginx/snippets
COPY ./nginx.conf /etc/nginx
ADD ./ssl/ssl-cert-snakeoil.pem /etc/ssl/certs/ssl-cert-snakeoil.pem
ADD ./ssl/ssl-cert-snakeoil.key /etc/ssl/private/ssl-cert-snakeoil.key
#RUN mkdir -p /etc/nginx/sites-enabled && ls -la /etc/nginx/
#RUN ln -s /etc/nginx/sites-available/site.local.conf /etc/nginx/sites-enabled/$HOSTNAME.conf

#Замена хоста
RUN sed -i -e "s/site.local/$HOSTNAME/g" /etc/nginx/conf.d/default.conf

#RUN apt-get update && apt-get install -y openssl
#RUN openssl dhparam -out /etc/nginx/dhparam.pem 2048

