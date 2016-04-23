DROP DATABASE IF EXISTS blog;
CREATE DATABASE blog;
USE blog;

CREATE TABLE b_comment
(
comment_id int NOT NULL AUTO_INCREMENT,
commented_date date NOT NULL,
content varchar(50) NOT NULL,
PRIMARY KEY (comment_id)
);

CREATE TABLE b_post
(
post_id int NOT NULL AUTO_INCREMENT,
comment_id int NOT NULL,
posted_date date NOT NULL,
title varchar(20) NOT NULL ,
content varchar(50) NOT NULL,
PRIMARY KEY (post_id),
FOREIGN KEY (comment_id) REFERENCES b_comment(comment_id)
);

CREATE TABLE b_user(
user_id int NOT NULL AUTO_INCREMENT,
post_id int,
comment_id int,
username varchar(20) NOT NULL,
email varchar(50) NOT NULL,
passwd varchar(20) NOT NULL,

PRIMARY KEY (user_id),
FOREIGN KEY (post_id) REFERENCES b_post(post_id),
FOREIGN KEY (comment_id) REFERENCES b_comment(comment_id)
);