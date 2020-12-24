CREATE TABLE IF NOT EXISTS `phalconblog`.`users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `username` VARCHAR(16) NOT NULL ,
  `password` VARCHAR(255) NOT NULL ,
  `name` VARCHAR(255) NOT NULL ,
  `email` TEXT NOT NULL ,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
);