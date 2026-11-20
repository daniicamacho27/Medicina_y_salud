#!/bin/bash
set -e
PORT="${PORT:-80}"
sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i "s/:80>/:${PORT}>/" /etc/apache2/sites-available/000-default.conf

mkdir -p /run/mysqld && chown mysql:mysql /run/mysqld
[ -d /var/lib/mysql/mysql ] || mariadb-install-db --user=mysql --datadir=/var/lib/mysql >/dev/null
mysqld_safe --bind-address=127.0.0.1 --datadir=/var/lib/mysql >/dev/null 2>&1 &
for i in $(seq 1 40); do mysqladmin ping --silent 2>/dev/null && break; sleep 1; done

mysql -uroot <<SQL
CREATE USER IF NOT EXISTS '${DB_USER}'@'localhost' IDENTIFIED BY '${DB_PASS}';
CREATE USER IF NOT EXISTS '${DB_USER}'@'127.0.0.1' IDENTIFIED BY '${DB_PASS}';
SQL

if ! mysql -uroot -e "USE ${DB_NAME}; SELECT 1 FROM articulos LIMIT 1" >/dev/null 2>&1; then
  cd /var/www/html
  mysql -uroot < tp6/schema.sql
  sed -n '1,/^-- READ/p' tp6/consultas.sql | mysql -uroot
  mysql -uroot < tp8/auth.sql
  mysql -uroot < tp9/datos-demo.sql || true
fi
mysql -uroot -e "GRANT ALL ON ${DB_NAME}.* TO '${DB_USER}'@'localhost'; GRANT ALL ON ${DB_NAME}.* TO '${DB_USER}'@'127.0.0.1'; FLUSH PRIVILEGES;"

export APP_ENV=production APP_DEBUG=false
export DB_CONNECTION=mysql DB_PORT=3306 DB_DATABASE="${DB_NAME}" DB_USERNAME="${DB_USER}" DB_PASSWORD="${DB_PASS}"
export SESSION_DRIVER=file CACHE_STORE=file QUEUE_CONNECTION=sync
[ -n "$APP_KEY" ] || export APP_KEY="$(cd /var/www/html/laravel-medsalud && php artisan key:generate --show)"
[ -n "$RENDER_EXTERNAL_URL" ] && export APP_URL="${RENDER_EXTERNAL_URL}/laravel"
printenv | grep -E '^(DB_|APP_|SESSION_|CACHE_|QUEUE_)' | sed 's/^\([^=]*\)=\(.*\)$/SetEnv \1 "\2"/' > /etc/apache2/conf-available/env.conf
a2enconf env >/dev/null

exec apache2-foreground
