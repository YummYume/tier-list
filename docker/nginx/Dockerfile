FROM nginx:stable

# Log folder (shared)
RUN mkdir -p /logs

# CONF
COPY ./docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY ./docker/nginx/symfony.conf /etc/nginx/symfony.conf

# SSL CERTIFICATES
COPY ./docker/nginx/server.crt /etc/nginx/ssl/server.crt
COPY ./docker/nginx/server.key /etc/nginx/ssl/server.key
