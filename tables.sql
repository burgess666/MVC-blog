DROP DATABASE IF EXISTS blog;
CREATE DATABASE blog;
USE blog;

CREATE TABLE b_comment
(
comment_id varchar(20) NOT NULL,
commented_date date NOT NULL,
content varchar(50) NOT NULL,
PRIMARY KEY (comment_id)
);

CREATE TABLE b_post
(
post_id varchar(20) NOT NULL,
comment_id varchar(20) NOT NULL,
posted_date date NOT NULL,
title varchar(20) NOT NULL ,
content varchar(50) NOT NULL,
PRIMARY KEY (post_id),
FOREIGN KEY (comment_id) REFERENCES b_comment(comment_id)
);

CREATE TABLE b_user(
user_id varchar(20) NOT NULL,
post_id varchar(20) NOT NULL,
comment_id varchar(20) NOT NULL,
username varchar(20) NOT NULL,
email varchar(50) NOT NULL,
passwd varchar(20) NOT NULL,

PRIMARY KEY (user_id),
FOREIGN KEY (post_id) REFERENCES b_post(post_id),
FOREIGN KEY (comment_id) REFERENCES b_comment(comment_id)
);