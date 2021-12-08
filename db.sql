-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               5.7.29 - MySQL Community Server (GPL)
-- Операционная система:         Win64
-- HeidiSQL Версия:              11.0.0.5958
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Дамп структуры для таблица shop.images
CREATE TABLE IF NOT EXISTS `images` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `product_id` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK_product_image` (`product_id`),
  CONSTRAINT `FK_product_image` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы shop.images: ~4 rows (приблизительно)
/*!40000 ALTER TABLE `images` DISABLE KEYS */;
INSERT INTO `images` (`id`, `name`, `product_id`) VALUES
	(1, 'apple.jpg', 1),
	(2, 'beer.jpg', 2),
	(3, 'water.jpg', 3),
	(4, 'cheese.jpg', 4);
/*!40000 ALTER TABLE `images` ENABLE KEYS */;

-- Дамп структуры для таблица shop.products
CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `price` decimal(10,2) DEFAULT NULL,
  `unit_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы shop.products: ~4 rows (приблизительно)
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` (`id`, `name`, `description`, `price`, `unit_id`) VALUES
	(1, 'apple', 'Delicious sweet red apple grown in farm fields.', 0.30, 0),
	(2, 'beer', 'Light beer has a tart taste.', 2.00, 1),
	(3, 'water', 'Mineral sparkling water from an artesian well 100 m deep.', 1.00, 1),
	(4, 'cheese', 'Delicious cheese with big holes.', 3.74, 2);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;

-- Дамп структуры для таблица shop.product_rating
CREATE TABLE IF NOT EXISTS `product_rating` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) NOT NULL DEFAULT '0',
  `user_id` bigint(20) NOT NULL DEFAULT '0',
  `grade` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK_product_product_raiting` (`product_id`),
  KEY `FK_user_product_raiting` (`user_id`),
  CONSTRAINT `FK_product_product_raiting` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  CONSTRAINT `FK_user_product_raiting` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=146 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы shop.product_rating: ~4 rows (приблизительно)
/*!40000 ALTER TABLE `product_rating` DISABLE KEYS */;
INSERT INTO `product_rating` (`id`, `product_id`, `user_id`, `grade`) VALUES
	(140, 1, 6, 3),
	(141, 2, 6, 4),
	(144, 3, 6, 4),
	(145, 4, 6, 3);
/*!40000 ALTER TABLE `product_rating` ENABLE KEYS */;

-- Дамп структуры для таблица shop.purchases
CREATE TABLE IF NOT EXISTS `purchases` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL DEFAULT '0',
  `shipping_id` bigint(20) NOT NULL DEFAULT '0',
  `user_balance` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_purchase_shipping` (`shipping_id`),
  KEY `FK_purchase_user` (`user_id`),
  CONSTRAINT `FK_purchase_shipping` FOREIGN KEY (`shipping_id`) REFERENCES `shipping` (`id`),
  CONSTRAINT `FK_purchase_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы shop.purchases: ~14 rows (приблизительно)
/*!40000 ALTER TABLE `purchases` DISABLE KEYS */;
INSERT INTO `purchases` (`id`, `user_id`, `shipping_id`, `user_balance`, `created_at`) VALUES
	(25, 6, 1, 100.00, '2021-11-23 23:25:18'),
	(26, 6, 2, 95.00, '2021-11-23 23:34:59'),
	(27, 6, 2, 81.00, '2021-11-23 23:38:16'),
	(28, 6, 1, 67.00, '2021-11-24 10:17:15'),
	(29, 6, 2, 66.00, '2021-11-24 10:21:12'),
	(30, 6, 1, 58.00, '2021-11-24 10:25:38'),
	(31, 6, 1, 56.00, '2021-11-24 10:27:39'),
	(32, 6, 1, 55.00, '2021-11-24 10:30:44'),
	(33, 6, 1, 55.00, '2021-11-24 10:44:29'),
	(34, 6, 2, 54.40, '2021-11-24 10:45:47'),
	(35, 6, 2, 45.06, '2021-11-24 10:47:08'),
	(36, 6, 1, 38.16, '2021-11-25 21:45:37'),
	(37, 6, 1, 33.12, '2021-11-25 21:56:23'),
	(38, 6, 1, 32.12, '2021-11-25 23:36:09'),
	(39, 6, 1, 29.92, '2021-11-25 23:38:36'),
	(40, 6, 1, 27.92, '2021-11-25 23:40:33');
/*!40000 ALTER TABLE `purchases` ENABLE KEYS */;

-- Дамп структуры для таблица shop.purchase_product
CREATE TABLE IF NOT EXISTS `purchase_product` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `purchase_id` bigint(20) DEFAULT '0',
  `product_id` bigint(20) NOT NULL DEFAULT '0',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `quantity` decimal(10,3) NOT NULL DEFAULT '0.000',
  PRIMARY KEY (`id`),
  KEY `purchase_id` (`purchase_id`),
  KEY `FK_purchase_product_purchase` (`product_id`),
  CONSTRAINT `FK_products_purchase_products` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  CONSTRAINT `FK_purchase_product_purchase` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы shop.purchase_product: ~28 rows (приблизительно)
/*!40000 ALTER TABLE `purchase_product` DISABLE KEYS */;
INSERT INTO `purchase_product` (`id`, `purchase_id`, `product_id`, `price`, `quantity`) VALUES
	(23, 25, 2, 2.00, 1.000),
	(24, 25, 3, 1.00, 3.000),
	(25, 26, 1, 0.30, 2.000),
	(26, 26, 2, 2.00, 1.000),
	(27, 26, 3, 1.00, 3.000),
	(28, 26, 4, 3.74, 1.000),
	(29, 27, 1, 0.30, 2.000),
	(30, 27, 2, 2.00, 1.000),
	(31, 27, 3, 1.00, 3.000),
	(32, 27, 4, 3.74, 1.000),
	(33, 28, 3, 1.00, 1.000),
	(34, 29, 4, 3.74, 1.000),
	(35, 30, 2, 2.00, 1.000),
	(36, 31, 3, 1.00, 1.000),
	(37, 32, 1, 0.30, 1.000),
	(38, 33, 1, 0.30, 2.000),
	(39, 34, 1, 0.30, 2.000),
	(40, 34, 4, 3.74, 1.000),
	(41, 35, 1, 0.30, 3.000),
	(42, 35, 3, 1.00, 1.000),
	(43, 36, 1, 0.30, 1.000),
	(44, 36, 3, 1.00, 1.000),
	(45, 36, 4, 3.74, 1.000),
	(46, 37, 3, 1.00, 1.000),
	(47, 38, 1, 0.30, 4.000),
	(48, 38, 3, 1.00, 1.000),
	(49, 39, 2, 2.00, 1.000),
	(50, 40, 3, 1.00, 2.000);
/*!40000 ALTER TABLE `purchase_product` ENABLE KEYS */;

-- Дамп структуры для таблица shop.shipping
CREATE TABLE IF NOT EXISTS `shipping` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `delivery_cost` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы shop.shipping: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `shipping` DISABLE KEYS */;
INSERT INTO `shipping` (`id`, `name`, `delivery_cost`) VALUES
	(1, 'self-pickup', 0.00),
	(2, 'UPS', 5.00);
/*!40000 ALTER TABLE `shipping` ENABLE KEYS */;

-- Дамп структуры для таблица shop.units
CREATE TABLE IF NOT EXISTS `units` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `abbreviations` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы shop.units: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `units` DISABLE KEYS */;
INSERT INTO `units` (`id`, `name`, `abbreviations`, `type`) VALUES
	(1, 'bottle', 'bottle', 1),
	(2, 'kilogram', 'kg.', 2);
/*!40000 ALTER TABLE `units` ENABLE KEYS */;

-- Дамп структуры для таблица shop.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` char(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `balance` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы shop.users: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `email`, `name`, `password`, `balance`) VALUES
	(5, 'mail@test.com', 'Test', '25d55ad283aa400af464c76d713c07ad', 100.00),
	(6, 'serg862000@gmail.com', 'Serg', '25d55ad283aa400af464c76d713c07ad', 25.92),
	(7, 'test@mail.com', 'User', 'e10adc3949ba59abbe56e057f20f883e', 100.00);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
