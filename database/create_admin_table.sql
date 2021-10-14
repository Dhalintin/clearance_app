CREATE TABLE `clearance_app`.`admin` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `username` VARCHAR(255) NOT NULL , `password` VARCHAR(255) NOT NULL , PRIMARY KEY (`id`), UNIQUE (`username`)) ENGINE = InnoDB;

INSERT INTO `admin` (`id`, `username`, `password`) VALUES (NULL, 'adminuser', '$2y$10$QSM80p7h3CvYuH/NIlr/jeu50rhecGtCQWNh.TxvJGnxxzP.tU3mq');