CREATE  TABLE IF NOT EXISTS `phalconblog`.`tags` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `tag` VARCHAR(255) NOT NULL ,
  PRIMARY KEY (`id`)
  UNIQUE KEY `tag` (`tag`)
);