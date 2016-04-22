DROP DATABASE IF EXISTS blog;
CREATE DATABASE blog;
USE blog;

CREATE TABLE b_comment
(
comment_id varchar(20),
commented_date date,
content varchar(50),
PRIMARY KEY (comment_id)
);

CREATE TABLE b_post
(
post_id varchar(20),
comment_id varchar(20),
posted_date date,
title varchar(20) NOT NULL,
content varchar(50),
PRIMARY KEY (post_id),
FOREIGN KEY (comment_id) REFERENCES b_comment(comment_id)
);

CREATE TABLE b_user(
user_id varchar(20) NOT NULL,
post_id varchar(20),
comment_id varchar(20),
username varchar(20) NOT NULL,
email varchar(50),
passwd varchar(20),

PRIMARY KEY (user_id),
FOREIGN KEY (post_id) REFERENCES b_post(post_id),
FOREIGN KEY (comment_id) REFERENCES b_comment(comment_id)
);


