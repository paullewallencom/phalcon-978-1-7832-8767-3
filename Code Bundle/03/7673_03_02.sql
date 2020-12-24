DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text,
  `body` text,
  `excerpt` text,
  `published` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `pinged` text,
  `to_ping` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;