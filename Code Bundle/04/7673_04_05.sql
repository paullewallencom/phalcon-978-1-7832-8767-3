DROP TABLE `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `users_id` int(11) NOT NULL,
  `title` text,
  `body` text,
  `excerpt` text,
  `published` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `pinged` text,
  `to_ping` text,
  PRIMARY KEY (`id`),
  KEY `fk_posts_users` (`users_id`)
);