#!/bin/sh

# Hapus container lama jika ada biar tidak bentrok
docker rm -f mysql_case4

# Jalankan container MySQL
# Kita pakai MySQL 5.7 agar paling kompatibel dengan WordPress tanpa config rumit
docker container run \
  -dit \
  --name mysql_case4 \
  -v $(pwd)/dbdata:/var/lib/mysql \
  -e MYSQL_ROOT_PASSWORD=rootpassword \
  -e MYSQL_DATABASE=wordpress_db \
  -e MYSQL_USER=wp_user \
  -e MYSQL_PASSWORD=wp_password \
  mysql:5.7
