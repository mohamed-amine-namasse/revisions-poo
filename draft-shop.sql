-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 10, 2025 at 12:45 PM
-- Server version: 8.4.3
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `draft-shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Électronique', 'Produits électroniques divers', '2025-10-06 10:36:52', '2025-10-06 10:36:52'),
(2, 'Fruits', 'L\'ensemble des fruits', '2025-10-06 10:40:15', '2025-10-06 10:40:15'),
(3, 'Voitures', 'L\'ensemble des voitures', '2025-10-06 10:44:23', '2025-10-06 10:44:23'),
(4, 'Vêtements', 'tous les vêtements', '2025-10-08 09:43:39', '2025-10-08 09:43:39');

-- --------------------------------------------------------

--
-- Table structure for table `clothing`
--

CREATE TABLE `clothing` (
  `id` int NOT NULL,
  `size` varchar(100) NOT NULL,
  `color` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `material_fee` int NOT NULL,
  `product_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `clothing`
--

INSERT INTO `clothing` (`id`, `size`, `color`, `type`, `material_fee`, `product_id`) VALUES
(1, 'M', 'violet', '0', 0, 88),
(3, 'L', 'orange', 'coton', 100, 58),
(9, 'S', 'vert', 'coton', 222, 100),
(10, 'S', 'marron', 'coton', 222, 106),
(11, 'S', 'marron', 'coton', 222, 107),
(12, 'S', 'marron', 'coton', 222, 109),
(13, 'S', 'marron', 'coton', 222, 111),
(14, 'S', 'pink', 'coton', 222, 115),
(15, 'S', 'marron', 'coton', 222, 116);

-- --------------------------------------------------------

--
-- Table structure for table `electronic`
--

CREATE TABLE `electronic` (
  `id` int NOT NULL,
  `brand` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `warranty_fee` int NOT NULL,
  `product_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `electronic`
--

INSERT INTO `electronic` (`id`, `brand`, `warranty_fee`, `product_id`) VALUES
(1, 'Yamaha', 10, 89),
(2, 'LG', 100, 90),
(3, 'Sony', 22, 101);

-- --------------------------------------------------------

--
-- Table structure for table `photos`
--

CREATE TABLE `photos` (
  `id` int NOT NULL,
  `filepath` varchar(255) NOT NULL,
  `product_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `photos`
--

INSERT INTO `photos` (`id`, `filepath`, `product_id`) VALUES
(6, 'https://picsum.photos/200/300', 58),
(7, 'https://picsum.photos/230/500', 9),
(8, 'https://picsum.photos/100/300', 59),
(9, 'https://picsum.photos/110/300', 59),
(10, 'https://picsum.photos/700/300', 7),
(11, 'https://picsum.photos/900/300', 7),
(13, 'https://picsum.photos/900/300', 68),
(24, 'https://picsum.photos/957/300', 80),
(25, 'https://picsum.photos/9000/3000', 81),
(31, 'https://picsum.photos/957/300', 87),
(32, 'https://picsum.photos/888/300', 88),
(33, 'https://picsum.photos/778/300', 89),
(34, 'https://picsum.photos/768/300', 90),
(35, 'https://picsum.photos/9000/3000', 92),
(36, 'https://picsum.photos/9000/3000', 100),
(37, 'https://picsum.photos/987/300', 101),
(38, 'https://picsum.photos/957/300', 103),
(39, 'https://picsum.photos/500/3000', 106),
(40, 'https://picsum.photos/500/3000', 107),
(41, 'https://picsum.photos/500/3000', 109),
(42, 'https://picsum.photos/500/3000', 111),
(43, 'https://picsum.photos/957/300', 113),
(44, 'https://picsum.photos/957/300', 114),
(45, 'https://picsum.photos/500/3000', 115),
(46, 'https://picsum.photos/500/3000', 116);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` int NOT NULL,
  `description` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `quantity` int NOT NULL,
  `category_id` int NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `price`, `description`, `quantity`, `category_id`, `created_at`, `updated_at`) VALUES
(7, 'pomme', 400, 'une pomme rouge', 3, 2, '2025-10-06 11:18:35', '2025-10-06 11:18:35'),
(9, 'banane', 400, 'Banane jaune ', 7, 2, '2025-10-06 10:41:21', '2025-10-06 10:41:21'),
(58, 'T-shirt', 800, 'A nice T-shirt', 3, 4, '2025-10-06 10:37:20', '2025-10-06 10:37:20'),
(59, 'Peugeot 308', 17999, 'voiture d\'occasion', 2, 3, '2025-10-06 10:45:19', '2025-10-06 10:45:19'),
(68, 'Milk', 5000, 'A fresh milk', 10, 2, '2025-10-07 15:54:27', '2025-10-07 15:54:27'),
(80, 'Eau', 600, 'A fresh milkshake', 24, 2, '2025-10-08 10:09:01', '2025-10-08 10:09:01'),
(81, 'Milk2', 0, 'A fresher milk', 10, 2, '2025-10-08 10:27:20', '2025-10-08 10:27:20'),
(87, 'Juice', 600, 'Orange Juice', 2, 2, '2025-10-08 10:36:04', '2025-10-08 10:36:04'),
(88, 'Jacket', 200, 'jean classique', 66, 4, '2025-10-08 13:56:32', '2025-10-08 13:56:32'),
(89, 'guitar', 5000, 'guitare électrique', 3, 1, '2025-10-08 14:21:50', '2025-10-08 14:21:50'),
(90, 'Smart TV', 400, 'Grand télé', 1, 1, '2025-10-09 08:43:48', '2025-10-09 08:43:48'),
(92, 'Milk23', 0, 'A fresher milk', 10, 2, '2025-10-09 13:10:48', '2025-10-09 13:10:48'),
(100, 'pyjama', 220, 'pyjama enfant', 2, 4, '2025-10-09 13:45:06', '2025-10-09 13:45:06'),
(101, 'PSP', 1000, 'console', 2, 4, '2025-10-09 13:55:04', '2025-10-09 13:55:04'),
(103, 'Jus', 600, 'Orange Juice', 10, 2, '2025-10-09 14:18:00', '2025-10-09 14:18:00'),
(106, 'tricot', 220, 'tricot enfant', 2, 4, '2025-10-09 14:25:45', '2025-10-09 14:25:45'),
(107, 'Pull', 220, 'pull enfant', 2, 4, '2025-10-09 14:30:37', '2025-10-09 14:30:37'),
(109, 'Pullo', 220, 'pullo enfant', 2, 4, '2025-10-09 14:44:04', '2025-10-09 14:44:04'),
(111, 'Pullon', 220, 'pullon enfant', 2, 4, '2025-10-09 14:50:15', '2025-10-09 14:50:15'),
(113, 'Juicy', 600, 'Orange Juice', 12000, 2, '2025-10-09 15:18:57', '2025-10-09 15:18:57'),
(114, 'Limonade', 600, 'Orange Juice', 33, 2, '2025-10-09 15:20:07', '2025-10-09 15:20:07'),
(115, 'Veste', 220, 'djallaba enfant', 2, 4, '2025-10-09 15:28:16', '2025-10-09 15:28:16'),
(116, 'Djellaba', 220, 'djallaba enfant', 2, 4, '2025-10-09 15:34:18', '2025-10-09 15:34:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clothing`
--
ALTER TABLE `clothing`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `electronic`
--
ALTER TABLE `electronic`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `test` (`category_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `clothing`
--
ALTER TABLE `clothing`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `electronic`
--
ALTER TABLE `electronic`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `photos`
--
ALTER TABLE `photos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `clothing`
--
ALTER TABLE `clothing`
  ADD CONSTRAINT `clothing_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `electronic`
--
ALTER TABLE `electronic`
  ADD CONSTRAINT `electronic_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `photos`
--
ALTER TABLE `photos`
  ADD CONSTRAINT `photos_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `test` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
