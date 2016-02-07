CREATE TABLE `origin` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL DEFAULT '',
  `description` VARCHAR(255) NULL,
  `id_status` TINYINT(4) NOT NULL DEFAULT 1 COMMENT '1=> new; 2=>deleted;',
  PRIMARY KEY (`id`));

CREATE TABLE `cutomer_has_origin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_customer` int(11) NOT NULL,
  `id_origin` int(11) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `id_connection` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_customer_has_origin_customer_id_idx` (`id_customer`),
  KEY `fk_customer_has_origin_origin_id_idx` (`id_origin`),
  CONSTRAINT `fk_customer_has_origin_customer_id` FOREIGN KEY (`id_customer`) REFERENCES `customers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_customer_has_origin_origin_id` FOREIGN KEY (`id_origin`) REFERENCES `origin` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
