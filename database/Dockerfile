FROM mariadb

ENV MARIADB_MYSQL_LOCALHOST_USER=1


# Menyalin file konfigurasi MariaDB kustom untuk mengaktifkan innodb_use_native_aio
COPY ./conf.d/my.cnf /etc/mysql/my.cnf

# Memastikan izin direktori data MariaDB
RUN chown -R mysql:mysql /var/lib/mysql && chmod -R 755 /var/lib/mysql

# Port default MariaDB
HEALTHCHECK CMD ["docker-healthcheck.sh", "--su=mysql", "--connect", "--innodb_initialized"]

EXPOSE 3306


# Use the default entrypoint and command from the MySQL image
#CMD ["mariadbd","--character-set-server=utf8mb4 --collation-server=utf8mb4_unicode_ci --explicite-defaults-for-timestamp=ON"]
