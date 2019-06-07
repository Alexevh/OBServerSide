use observerside;
CREATE TABLE `observerside`.`categoria` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  `created` DATETIME ,
  `updated` DATETIME,
  PRIMARY KEY (`id`));