use blog;
describe b_comment;
describe b_post;
describe b_user;
select * from b_user;
select * from b_post;
select * from b_comment;
insert into b_comment values (1,1,1,"2016-04-26","first comment by kaiqiang");

SELECT b_user.user_id,b_user.username, b_post.post_id, b_post.title, b_post.content, b_post.posted_date
FROM b_post join b_user ON b_post.user_id = b_user.user_id 
WHERE b_user.user_id = 1
ORDER BY b_post.post_id;


SELECT b_post.post_id,b_post.title, b_comment.comment_id, b_comment.content, b_comment.commented_date, b_comment.user_id
FROM b_comment JOIN b_post ON b_comment.post_id = b_post.post_id
WHERE b_post.post_id = 1 
ORDER BY b_comment.comment_id;