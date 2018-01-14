-- 4. An article has a title, body text, and author name. The maximum length of title, body text, and
-- author name can be limited by reasonable sizes. 
CREATE DATABASE IF NOT EXISTS blog;

USE blog;

CREATE TABLE IF NOT EXISTS post_table(
	id INT NOT NULL AUTO_INCREMENT,
	title VARCHAR(100) NOT NULL,
	body  VARCHAR(1000) NOT NULL,
	author_name VARCHAR(100),
	pswd VARCHAR(100),
    date_time VARCHAR(100),
	PRIMARY KEY ( id )
);

 INSERT INTO post_table (title,body,author_name,pswd,date_time) VALUES ("A post","Yay! A new post.","Kimmy","123","2016-11-29 05:17pm");
 INSERT INTO post_table (title,body,author_name,pswd,date_time) VALUES ("A second post.","Yay! A new post again.","John","321","2016-11-29 03:18pm");

SELECT title,body,author_name,date_time FROM post_table;