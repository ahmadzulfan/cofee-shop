-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 15, 2025 at 02:30 PM
-- Server version: 11.3.2-MariaDB
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `coffee_shop_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

DROP TABLE IF EXISTS `carts`;
CREATE TABLE IF NOT EXISTS `carts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` int(11) NOT NULL,
  `total` float(11,2) NOT NULL,
  `created_at` time NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

DROP TABLE IF EXISTS `cart_items`;
CREATE TABLE IF NOT EXISTS `cart_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `subtotal` float(11,2) NOT NULL,
  `additional` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `to_cart` (`cart_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category_product`
--

DROP TABLE IF EXISTS `category_product`;
CREATE TABLE IF NOT EXISTS `category_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_category` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category_product`
--

INSERT INTO `category_product` (`id`, `nama_category`, `image`) VALUES
(1, 'Fruits & Veges', 'FoodMart/images/icon-vegetables-broccoli.png'),
(2, 'Breads & Sweets', 'FoodMart/images/icon-bread-baguette.png'),
(3, 'Snacks', 'FoodMart/images/icon-soft-drinks-bottle.png'),
(4, 'Desserts', 'FoodMart/images/icon-wine-glass-bottle.png'),
(5, 'Hazz', 'FoodMart/images/icon-animal-products-drumsticks.png'),
(6, 'Appataizer', 'FoodMart/images/icon-bread-herb-flour.png');

-- --------------------------------------------------------

--
-- Table structure for table `login_histories`
--

DROP TABLE IF EXISTS `login_histories`;
CREATE TABLE IF NOT EXISTS `login_histories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `table_id` int(11) NOT NULL,
  `login_id` varchar(150) NOT NULL,
  `device` varchar(100) DEFAULT NULL,
  `user_agent` varchar(100) DEFAULT NULL,
  `ip_address` varchar(100) DEFAULT NULL,
  `logged_in_at` timestamp NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `login_histories`
--

INSERT INTO `login_histories` (`id`, `table_id`, `login_id`, `device`, `user_agent`, `ip_address`, `logged_in_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'login_67fe33e68b4ea1.09351039', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Sa', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Sa', '::1', '2025-04-15 03:24:38', '2025-04-15 03:24:38', '0000-00-00 00:00:00'),
(2, 1, 'login_67fe34745cbbc4.72549800', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Sa', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Sa', '::1', '2025-04-15 03:27:00', '2025-04-15 03:27:00', '0000-00-00 00:00:00'),
(3, 1, 'login_67fe3592ba3990.13590925', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Sa', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Sa', '::1', '2025-04-15 03:31:46', '2025-04-15 03:31:46', '0000-00-00 00:00:00'),
(4, 1, 'login_67fe37fe164824.47663054', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Sa', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Sa', '::1', '2025-04-15 03:42:06', '2025-04-15 03:42:06', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status` enum('pending','processing','completed','cancelled') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
CREATE TABLE IF NOT EXISTS `payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `payment_method` enum('credit_card','bank_transfer','e-wallet','cash_on_delivery') NOT NULL,
  `payment_status` enum('pending','paid','failed') DEFAULT 'pending',
  `transaction_id` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `transaction_id` (`transaction_id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `price_discount` int(11) DEFAULT NULL,
  `stock` int(11) DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `price_discount`, `stock`, `image`, `category_id`, `created_at`) VALUES
(1, 'Tomato Juice', 'Cappuchino is made from the freshest, organic melons. Enjoy a refreshing, natural taste that\'s perfect for any time of day.', 5000.00, 1, 11, '1744537894_af65ff1b181218df75cc.jpg', 1, '2025-03-03 17:05:59'),
(2, 'Tomato', 'jhgjghj', 3232.00, NULL, 33, '1744537916_d88fbf2a20b5ebb98ef4.jpg', 1, '2025-03-03 17:32:35'),
(3, 'Cappuchino', 'thumb-tomatoes\r\n', 15000.00, 15, 10, '1744537981_ebcb5f69b917789f1b2e.jpg', 6, '2025-03-03 17:44:41'),
(5, 'Jus Stroberry', NULL, 10000.00, NULL, 3, '1744537856_d18edc7f51baff3fbcc6.jpg', 1, '2025-04-13 09:50:56'),
(6, 'Jus Alpukat', NULL, 15000.00, NULL, 3, '1744538041_517a960137ba0b933a23.jpg', 1, '2025-04-13 09:54:01'),
(7, 'Sayur', 'Sayur is made from the freshest, organic melons. Enjoy a refreshing, natural taste that\'s perfect for any time of day.', 10000.00, NULL, 3, '1744544036_499e351e311485acd3d8.jpg', 1, '2025-04-13 11:33:56'),
(8, 'Shish kebab Barbecue Mediterranean cuisine Hamburger', 'Shish kebab Barbecue Mediterranean cuisine Hamburger', 50000.00, 5, 10, 'makanan1.png', NULL, '2025-04-14 14:07:18');

-- --------------------------------------------------------

--
-- Table structure for table `product_banners`
--

DROP TABLE IF EXISTS `product_banners`;
CREATE TABLE IF NOT EXISTS `product_banners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(150) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `product_banners`
--

INSERT INTO `product_banners` (`id`, `product_id`, `name`, `description`, `image`, `created_at`, `updated_at`) VALUES
(1, 1, 'Tomato Juice', 'Cappuchino is made from the freshest, organic melons. Enjoy a refreshing, natural taste that\'s perfect for any time of day.', '501db49fbf32ad3231aada4a6c189030.png', '2025-04-14 06:50:15', '2025-04-14 14:17:22'),
(2, 7, 'Sayur', 'Sayur is made from the freshest, organic melons. Enjoy a refreshing, natural taste that\'s perfect for any time of day.', 'makanan2.png', '2025-04-14 06:51:59', '2025-04-14 14:39:03'),
(3, 8, 'Shish kebab Barbecue Mediterranean cuisine Hamburger', 'Shish kebab Barbecue Mediterranean cuisine Hamburger', 'makanan1.png', '2025-04-14 14:07:56', '2025-04-14 14:08:22');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
CREATE TABLE IF NOT EXISTS `reviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `product_id`, `name`, `rating`, `comment`, `created_at`) VALUES
(1, 1, 'Aulia Rahma', 4, 'Produk segar dan rasa oke banget. Pasti order lagi!', '2025-04-13 15:01:16');

-- --------------------------------------------------------

--
-- Table structure for table `tables`
--

DROP TABLE IF EXISTS `tables`;
CREATE TABLE IF NOT EXISTS `tables` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `table_number` varchar(10) NOT NULL,
  `status` enum('available','occupied','reserved') DEFAULT 'available',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `table_number` (`table_number`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tables`
--

INSERT INTO `tables` (`id`, `table_number`, `status`, `created_at`, `updated_at`) VALUES
(1, 'T01', 'available', '2025-03-04 08:24:30', '2025-04-15 10:58:02'),
(2, 'T02', 'available', '2025-03-04 08:24:30', '2025-04-15 08:48:38'),
(3, 'T03', 'available', '2025-03-04 08:24:30', '2025-04-15 08:48:41'),
(4, 'T04', 'available', '2025-03-04 08:24:30', '2025-03-04 08:24:30');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `role` enum('customer','admin') DEFAULT 'customer',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `view_counter`
--

DROP TABLE IF EXISTS `view_counter`;
CREATE TABLE IF NOT EXISTS `view_counter` (
  `id` int(11) NOT NULL,
  `total_views` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `view_counter`
--

INSERT INTO `view_counter` (`id`, `total_views`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `website_views`
--

DROP TABLE IF EXISTS `website_views`;
CREATE TABLE IF NOT EXISTS `website_views` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) NOT NULL,
  `user_agent` text DEFAULT NULL,
  `viewed_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `website_views`
--

INSERT INTO `website_views` (`id`, `ip_address`, `user_agent`, `viewed_at`) VALUES
(1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-15 21:29:25');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `to_cart` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
