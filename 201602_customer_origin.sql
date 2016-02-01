CREATE TABLE `origin` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `description` VARCHAR(255) NULL,
  PRIMARY KEY (`id`));

CREATE TABLE `customer_has_origin` (
  `id_customer` INT(11) NOT NULL AUTO_INCREMENT,
  `id_origin` INT(11) NOT NULL,
  `description` VARCHAR(255) NULL DEFAULT '',
  `id_connection` INT(11) NULL DEFAULT NULL,
  INDEX `customer_id_has_origin_id_idx` (`id_customer` ASC),
  INDEX `origin_id_reference_to_origin_idx` (`id_origin` ASC),
  CONSTRAINT `customer_id_reference_to_origin`
    FOREIGN KEY (`id_customer`)
    REFERENCES `customers` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `origin_id_reference_to_origin`
    FOREIGN KEY (`id_origin`)
    REFERENCES `origin` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);

INSERT INTO `optomedia`.`origin` (`name`) VALUES ('Google');
INSERT INTO `optomedia`.`origin` (`name`) VALUES ('Radio');
INSERT INTO `optomedia`.`origin` (`name`) VALUES ('TV');

ALTER TABLE `origin` 
ADD COLUMN `id_status` TINYINT NOT NULL AFTER `description`;

ALTER TABLE `customer_has_origin` 
ADD COLUMN `id_status` TINYINT NOT NULL AFTER `id_connection`;