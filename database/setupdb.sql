create database if not exists 'crmvoid';

CREATE USER 'ucrmvoip'@'%' IDENTIFIED BY '123';
GRANT ALL PRIVILEGES ON *.* TO 'ucrmvoip'@'%';