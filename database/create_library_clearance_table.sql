CREATE TABLE `clearance_app`.`library_clearance` ( `id` INT NOT NULL AUTO_INCREMENT , `library_card_image` VARCHAR(255) NOT NULL , `reg_no` VARCHAR(50) NOT NULL , `clearance_status` VARCHAR(100) NOT NULL DEFAULT 'pending' , PRIMARY KEY (`id`) UNIQUE (`reg_no`)) ENGINE = InnoDB;