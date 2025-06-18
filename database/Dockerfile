FROM mysql:8.4.5

# Set environment variables for MySQL

# Create the log directory and set permissions
RUN mkdir -p /var/log/mysql && \
    chown mysql:mysql /var/log/mysql && \
    chmod 755 /var/log/mysql

# Ensure the error message directory exists (usually included in the official image)
RUN mkdir -p /usr/share/mysql/english && \
    chown mysql:mysql /usr/share/mysql/english && \
    chmod 755 /usr/share/mysql/english

# Copy a custom MySQL configuration file (optional, if you need specific settings)
COPY ./conf.d/my.cnf /etc/mysql/my.cnf


USER mysql

#RUN mysql -u root -p'123' < ./setupdb.sql
# Expose MySQL port
EXPOSE 3306


# Use the default entrypoint and command from the MySQL image
CMD ["mysqld","--character-set-server=utf8mb4 --collation-server=utf8mb4_unicode_ci --explicite-defaults-for-timestamp=ON"]
