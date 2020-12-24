CREATE TABLE IF NOT EXISTS `post_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `posts_id` int(11) NOT NULL,
  `tags_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_post_tags_tags1` (`tags_id`),
  KEY `fk_post_tags_posts1` (`posts_id`)
);