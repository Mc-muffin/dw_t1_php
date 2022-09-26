CREATE DATABASE IF NOT EXISTS `taller_php_1`;

USE `taller_php_1`;

CREATE TABLE IF NOT EXISTS `productos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `precio` float NOT NULL,
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `compras` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fk_id` int NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `fecha_compra` datetime NOT NULL,
  `fin_garantia` date NOT NULL,
  `cantidad` int NOT NULL,
  `impuesto` float NOT NULL,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_id` (`fk_id`),
  CONSTRAINT `fk_id` FOREIGN KEY (`fk_id`) REFERENCES `productos` (`id`)
) DEFAULT CHARSET=utf8mb4;