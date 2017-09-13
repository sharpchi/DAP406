CREATE DATABASE `mydatabase`;

CREATE USER 'mark'@'localhost' IDENTIFIED BY 'mark1234';

GRANT ALL ON `mydatabase`.* TO `mark`@`localhost`;

DROP DATABASE `mydatabase`;