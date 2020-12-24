CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `body` text NOT NULL,
  `name` text NOT NULL,
  `email` text NOT NULL,
  `url` text NOT NULL,
  `submitted` datetime NOT NULL,
  `publish` tinyint(1) NOT NULL,
  `posts_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_comments_posts1` (`posts_id`)
);