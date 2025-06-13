# Base image
FROM mysql:8.4.5-oraclelinux9

# Copy custom conf file(s)
COPY ./conf.d/* /etc/mysql/conf.d/

# Make the conf files not writeable so mysql will read them
RUN chmod a-w /etc/mysql/conf.d/*