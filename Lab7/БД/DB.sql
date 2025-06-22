-- --------------------------------------------------------
-- Сервер:                       127.0.0.1
-- Версія сервера:               8.4.3 - MySQL Community Server - GPL
-- ОС сервера:                   Win64
-- HeidiSQL Версія:              12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for таблиця sales-mgmt.admins
CREATE TABLE IF NOT EXISTS `admins` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sales-mgmt.admins: ~1 rows (приблизно)
DELETE FROM `admins`;
INSERT INTO `admins` (`id`, `username`, `password`, `created_at`) VALUES
	(1, 'admin', '$2y$10$zJF0jiamOTDlJeA03yclGO2ZCHHQoM4qrk6qb4cts5ETdC/SsQFA2', '2025-06-22 21:14:41');

-- Dumping structure for таблиця sales-mgmt.customers
CREATE TABLE IF NOT EXISTS `customers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sales-mgmt.customers: ~8 rows (приблизно)
DELETE FROM `customers`;
INSERT INTO `customers` (`id`, `name`, `email`, `phone`) VALUES
	(1, 'Владислав', 'Anton.Fedurov@kpnu.edu.ua', '+380991242276'),
	(2, 'Владислав', 'Anton.Fedurov@kpnu.edu.ua', '+380991242276'),
	(3, 'Владислав', 'Anton.Fedurov@kpnu.edu.ua', '+380991242276'),
	(4, 'Максим', 'maks.ss@gmail.com', '+38012345253'),
	(5, 'Волошин Владислав', NULL, NULL),
	(6, 'Волошина Алла Іванівна', NULL, NULL),
	(7, 'Павло', NULL, NULL),
	(8, 'Волошин Владислав', NULL, NULL);

-- Dumping structure for таблиця sales-mgmt.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `order_date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sales-mgmt.orders: ~1 rows (приблизно)
DELETE FROM `orders`;
INSERT INTO `orders` (`id`, `customer_id`, `product_id`, `quantity`, `order_date`) VALUES
	(6, 8, 3, 1, '2025-06-22');

-- Dumping structure for таблиця sales-mgmt.products
CREATE TABLE IF NOT EXISTS `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sales-mgmt.products: ~9 rows (приблизно)
DELETE FROM `products`;
INSERT INTO `products` (`id`, `name`, `price`) VALUES
	(1, 'Банан', 12.01),
	(2, 'Хліб', 20.00),
	(3, 'Картопля', 3.00),
	(4, 'Йогурт', 25.00),
	(5, 'Макарони', 50.00),
	(6, 'Рис', 60.00),
	(7, 'Крупа', 30.00),
	(8, 'Ковбаса', 80.00),
	(9, 'Вода', 15.00);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
