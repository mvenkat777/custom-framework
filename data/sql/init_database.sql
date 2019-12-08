CREATE DATABASE IF NOT EXISTS `customer`;

USE `customer`;

CREATE TABLE IF NOT EXISTS `customers` (
  `id_customer` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(200) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `phone` VARCHAR(100) NOT NULL,
  `uuid` VARCHAR(36) NOT NULL,
  PRIMARY KEY (`id_customer`),
  UNIQUE KEY `uuid` (`uuid`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  ROW_FORMAT = DYNAMIC;

INSERT INTO customers (id_customer, name, email, phone, uuid) VALUES
(1, 'Emma ben', 'emma.ben@customer.com', '202-555-0143', UUID()),
(2, 'Mia Paul', 'mia.paul@customer.com', '202-555-0188', UUID()),
(3, 'Shani Hannah', 'shani.hannah@customer.com', '202-555-0138', UUID()),
(4, 'Lajuana Leon', 'lajuana.leon@customer.com', '202-555-0103', UUID()),
(5, 'Tatyana finn', 'tatyana.finn@customer.com', '202-555-0178', UUID()),
(6, 'Sofia Wurster', 'sofia.wurster@customer.com', '202-555-0187', UUID()),
(7, 'Ella Coria', 'ella.coria@customer.com', '202-555-0132', UUID()),
(8, 'Clara Swick', 'clara.swick@customer.com', '202-555-0166', UUID()),
(9, 'Johanna Wurster', 'johanna.wurster@customer.com', '202-555-0166', UUID()),
(10, 'Maja Rings', 'tatyana.rings@customer.com', '202-555-0166', UUID());