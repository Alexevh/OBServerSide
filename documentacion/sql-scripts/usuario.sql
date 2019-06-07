use observerside;
CREATE TABLE `observerside`.`usuario` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  `apellido` VARCHAR(45) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  `telefono` VARCHAR(45) NOT NULL,
  `status` VARCHAR(45) NOT NULL,
  `created` datetime ,
  `updated` datetime ,
  PRIMARY KEY (`id`)); 