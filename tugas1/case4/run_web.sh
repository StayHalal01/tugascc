#!/bin/sh

# Hapus container lama
docker rm -f wordpress_case4

# Jalankan container WordPress
# Port host kita set ke 8000
docker container run \
  -dit \
  --name wordpress_case4 \
  -p 8000:80 \
  --link mysql_case4:mysql \
  -v $(pwd)/wpdata:/var/www/html \
  -e WORDPRESS_DB_HOST=mysql \
  -e WORDPRESS_DB_USER=wp_user \
  -e WORDPRESS_DB_PASSWORD=wp_password \
  -e WORDPRESS_DB_NAME=wordpress_db \
  wordpress:latest
