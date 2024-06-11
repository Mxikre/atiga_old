-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 29, 2023 at 09:50 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `atiga-db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(10) NOT NULL,
  `user_id` int(5) DEFAULT NULL,
  `product_id` int(5) NOT NULL,
  `variation_id` int(5) NOT NULL,
  `length` int(10) DEFAULT NULL,
  `width` int(10) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `design_file` varchar(255) DEFAULT NULL,
  `total_price` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(5) NOT NULL,
  `category_name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(1, 'Banner'),
(19, 'Print Laser A3'),
(20, 'Sablon Digital'),
(21, 'Kartu Nama');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customers_id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `no_telp` int(15) NOT NULL,
  `address` text NOT NULL,
  `password` char(60) NOT NULL,
  `profile_pics` varchar(255) DEFAULT NULL,
  `user_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customers_id`, `name`, `email`, `no_telp`, `address`, `password`, `profile_pics`, `user_id`) VALUES
(1, 'Febrian', 'febrian@gmail.com', 8976542, 'Desa Larangan, Kab.Indramayu, Provinsi Jawa Barat', '$2y$10$NHe3EAQGu4bcMVcd2wZXnexcF/iI2B5Dl4859thwtFRkRZhm0z2Sm', 'mgYtfVt8Ex.png', 107),
(8, 'man without hat', 'mwh123@gmail.com', 8977777, 'Desa Larangan, Kab.Indramayu, Provinsi Jawa Barat', '$2y$10$nXvZf2PdW6n7KoxVsJrJduV0bRsxfxvTV3SFU3TRsuhJNy60NiUAK', NULL, 108),
(9, 'Trejo', 'trejo12@gmail.com', 81876489, 'Rumah Trejo', '$2y$10$vfoCLnuqSEkugyMEXSAztOCIaJgZZbVY.t5sqiCldS6URmAXCHNhm', NULL, 110),
(10, 'Etgar', 'etgar22@gmail.com', 81191876, 'Rumah Etgar', '$2y$10$mZ8GmAOr6Grd5nNZVCEaJOaFD7GwE6/DfEqLTjwlZaTP1UeXlpnW.', NULL, 111),
(11, 'plastik', 'plastik20@gmail.com', 87654134, 'Rumah plastik', '$2y$10$xqz.xNsncoq7Wi4sfmPfW.A0rTnY4UntOxxqaDV7n7QW5qppXBm8K', NULL, 112),
(12, 'bryan', 'bryan55@gmail.com', 8657245, 'Rumah Bryan', '$2y$10$vn2O1z4V54X7S7RsfNPeou3gs4EE0hzG6orbGMCyvgmLf85.ZNnEu', NULL, 113),
(13, 'Geralt', 'geraltRivia@gmail.com', 2147483647, 'Kaer Morhen', '$2y$10$QuEtQYszNyDMbezv4Vo4KeDoTIgzzJPqWPP8c8dvMDzpxpJHnHNNy', NULL, 114),
(18, 'curry30', 'scurry30@gmail.com', 1603030, 'Polhemus Ave, Atherton, CA 94027', '$2y$10$riiWkL/scHM6scRTQKjVweJ6E6DW38AVBhtVywuloExH9IjevWrGS', '95NuhxBgMT.png', 119);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(5) NOT NULL,
  `user_id` int(5) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `order_date` date NOT NULL,
  `status_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `total_amount`, `order_date`, `status_id`) VALUES
(21, 107, '150000.00', '2023-12-26', 4),
(22, 107, '84000.00', '2023-12-26', 1),
(23, 107, '4000.00', '2023-12-26', 6),
(24, 107, '154000.00', '2023-12-26', 4),
(25, 115, '20000.00', '2023-12-27', 1);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(5) NOT NULL,
  `order_id` int(5) NOT NULL,
  `product_id` int(5) NOT NULL,
  `variation_id` int(5) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `design_file` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `product_id`, `variation_id`, `quantity`, `price`, `design_file`) VALUES
(21, 21, 9, 41, 1, '150000.00', 'vsmOiapefr.png'),
(22, 22, 18, 49, 12, '7000.00', '8dZUQVvkml.png'),
(23, 23, 18, 49, 12, '7000.00', 'DhSAcmfhHW.png'),
(24, 24, 18, 49, 12, '4000.00', 'xWjIsO3I0W.png'),
(25, 24, 9, 41, 1, '150000.00', 'BybLjD933X.png'),
(26, 25, 10, 43, 1, '20000.00', 'a8zHIHCWUK.png');

-- --------------------------------------------------------

--
-- Table structure for table `order_statuses`
--

CREATE TABLE `order_statuses` (
  `status_id` int(5) NOT NULL,
  `status_name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_statuses`
--

INSERT INTO `order_statuses` (`status_id`, `status_name`) VALUES
(1, 'Dipesan'),
(2, 'Diproses'),
(3, 'Dikirim'),
(4, 'Selesai'),
(6, 'Dibatalkan');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(5) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `category_id` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `description`, `image`, `category_id`) VALUES
(9, 'Roll Banner', 'Roll banner merupakan solusi promosi yang praktis dan gaya. Ideal untuk meningkatkan brand awareness pada acara pameran atau kegiatan promosi. ', 'qFvAwHT69v.png', 1),
(10, 'Banner Horizontal', 'Promosikan bisnis anda atau rayakan momen khusus dengan Banner horizontal berkualitas tinggi.', 'ugNzy8oRft.png', 1),
(17, 'X Banner', 'X-Banner ini ditujukan untuk memberikan sentuhan modern pada pameran, acara, atau ruang bisnis Anda.', 'V3xxiCGduc.png', 1),
(18, 'Print Kertas dan Sticker', 'Cetak kertas dan stiker kami hadir dengan kualitas tajam, memperkuat pesan dan brand Anda secara efisien. Pilihlah kebermaknaan visual untuk setiap desain.', 'TzXf5W9tpv.jpg', 19),
(19, 'Kaos Custom', 'Sablon kaos custom adalah cara kreatif untuk personalisasi pakaian.', '12YtweZqHw.png', 20),
(20, 'Namecard', 'Kartu nama bagus', 'dFLf9ITRTf.png', 21);

-- --------------------------------------------------------

--
-- Table structure for table `product_types`
--

CREATE TABLE `product_types` (
  `type_id` int(3) NOT NULL,
  `type_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_types`
--

INSERT INTO `product_types` (`type_id`, `type_name`) VALUES
(19, 'Flexy Korea 460'),
(29, 'Roll Up Banner 60x160 280gsm'),
(30, 'Roll Up Banner 60x160 440gsm'),
(31, 'Flexy China 280gsm'),
(32, 'Flexy Korea 440gsm'),
(33, 'X Banner 60x160 280gsm'),
(34, 'X Banner 60x160 440gsm'),
(35, 'X Banner 80x180 280gsm'),
(36, 'X Banner 80x180 440gsm'),
(37, 'HVS 80 - 100 gram'),
(38, 'Art Paper 150 gram'),
(39, 'Art Carton 260 gram'),
(40, 'Sticker Kromo/HVS/Craft'),
(41, 'Sticker Vinyl/Transparan'),
(42, 'Sticker Silver/Gold'),
(43, 'Concored/BW/Jasmine/Linen'),
(44, 'Kaos Katun Combed 30s - DTF A6'),
(45, 'Kaos Katun Combed 30s - DTF A5'),
(46, 'Kaos Katun Combed 30s - DTF A4'),
(47, 'Kaos Katun Combed 30s - DTF A3'),
(48, 'Kaos Katun Combed 24s - DTF A6'),
(49, 'Kaos Katun Combed 24s - DTF A5'),
(50, 'Kaos Katun Combed 24s - DTF A4'),
(51, 'Kaos Katun Combed 24s - DTF A3');

-- --------------------------------------------------------

--
-- Table structure for table `product_variations`
--

CREATE TABLE `product_variations` (
  `variation_id` int(5) NOT NULL,
  `product_id` int(5) NOT NULL,
  `type_id` int(5) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_variations`
--

INSERT INTO `product_variations` (`variation_id`, `product_id`, `type_id`, `price`) VALUES
(41, 9, 29, '150000.00'),
(42, 9, 30, '175000.00'),
(43, 10, 31, '20000.00'),
(44, 10, 32, '40000.00'),
(45, 17, 33, '60000.00'),
(46, 17, 34, '80000.00'),
(47, 17, 35, '80000.00'),
(48, 17, 36, '100000.00'),
(49, 18, 37, '7000.00'),
(50, 18, 38, '7500.00'),
(51, 18, 39, '8000.00'),
(52, 18, 40, '9000.00'),
(53, 18, 41, '11000.00'),
(54, 18, 42, '15000.00'),
(55, 18, 43, '8000.00'),
(56, 19, 44, '55000.00'),
(57, 19, 45, '65000.00'),
(58, 19, 46, '70000.00'),
(59, 19, 47, '85000.00'),
(60, 19, 48, '60000.00'),
(61, 19, 49, '70000.00'),
(62, 19, 50, '75000.00'),
(63, 19, 51, '90000.00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(5) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` enum('admin','customer') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `user_type`) VALUES
(1, 'admin', '$2y$10$ynB6rFGpIzQeTa3dvl1ZdutfxXv56kAzI/.EcmHj3BxFiVSu.Hauq', 'admin'),
(107, 'Febrian', '$2y$10$NHe3EAQGu4bcMVcd2wZXnexcF/iI2B5Dl4859thwtFRkRZhm0z2Sm', 'customer'),
(108, 'man without hat', '$2y$10$nXvZf2PdW6n7KoxVsJrJduV0bRsxfxvTV3SFU3TRsuhJNy60NiUAK', 'customer'),
(109, 'Trejo', '$2y$10$/zXaTE5Set0JPu8uKy.oU.Ojx1HbxOn6esxsqiA41SdbxHeFZhyoG', 'customer'),
(110, 'Trejo', '$2y$10$vfoCLnuqSEkugyMEXSAztOCIaJgZZbVY.t5sqiCldS6URmAXCHNhm', 'customer'),
(111, 'Etgar', '$2y$10$mZ8GmAOr6Grd5nNZVCEaJOaFD7GwE6/DfEqLTjwlZaTP1UeXlpnW.', 'customer'),
(112, 'plastik', '$2y$10$xqz.xNsncoq7Wi4sfmPfW.A0rTnY4UntOxxqaDV7n7QW5qppXBm8K', 'customer'),
(113, 'bryan', '$2y$10$vn2O1z4V54X7S7RsfNPeou3gs4EE0hzG6orbGMCyvgmLf85.ZNnEu', 'customer'),
(114, 'Geralt', '$2y$10$QuEtQYszNyDMbezv4Vo4KeDoTIgzzJPqWPP8c8dvMDzpxpJHnHNNy', 'customer'),
(119, 'curry30', '$2y$10$riiWkL/scHM6scRTQKjVweJ6E6DW38AVBhtVywuloExH9IjevWrGS', 'customer');

-- --------------------------------------------------------

--
-- Table structure for table `variation_pricing`
--

CREATE TABLE `variation_pricing` (
  `pricing_id` int(5) NOT NULL,
  `variation_id` int(5) NOT NULL,
  `min_quantity` int(5) NOT NULL,
  `max_quantity` int(5) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `variation_pricing`
--

INSERT INTO `variation_pricing` (`pricing_id`, `variation_id`, `min_quantity`, `max_quantity`, `price`) VALUES
(11, 49, 1, 10, '7000.00'),
(12, 49, 11, 50, '4000.00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_product` (`product_id`),
  ADD KEY `fk_variation_cart` (`variation_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customers_id`),
  ADD UNIQUE KEY `uq_email` (`email`),
  ADD KEY `fk_user` (`user_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `fk_status_id` (`status_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id_fk` (`order_id`),
  ADD KEY `product_id_fk` (`product_id`),
  ADD KEY `variation_product_fk` (`variation_id`);

--
-- Indexes for table `order_statuses`
--
ALTER TABLE `order_statuses`
  ADD PRIMARY KEY (`status_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `fk_category` (`category_id`);

--
-- Indexes for table `product_types`
--
ALTER TABLE `product_types`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `product_variations`
--
ALTER TABLE `product_variations`
  ADD PRIMARY KEY (`variation_id`),
  ADD KEY `fk_product_id` (`product_id`),
  ADD KEY `fk_product_type` (`type_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `variation_pricing`
--
ALTER TABLE `variation_pricing`
  ADD PRIMARY KEY (`pricing_id`),
  ADD KEY `fk_variation` (`variation_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customers_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `order_statuses`
--
ALTER TABLE `order_statuses`
  MODIFY `status_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `product_types`
--
ALTER TABLE `product_types`
  MODIFY `type_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `product_variations`
--
ALTER TABLE `product_variations`
  MODIFY `variation_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT for table `variation_pricing`
--
ALTER TABLE `variation_pricing`
  MODIFY `pricing_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `fk_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`),
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `fk_variation_cart` FOREIGN KEY (`variation_id`) REFERENCES `product_variations` (`variation_id`);

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_status_id` FOREIGN KEY (`status_id`) REFERENCES `order_statuses` (`status_id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_id_fk` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `product_id_fk` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`),
  ADD CONSTRAINT `variation_product_fk` FOREIGN KEY (`variation_id`) REFERENCES `product_variations` (`variation_id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`);

--
-- Constraints for table `product_variations`
--
ALTER TABLE `product_variations`
  ADD CONSTRAINT `fk_product_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`),
  ADD CONSTRAINT `fk_product_type` FOREIGN KEY (`type_id`) REFERENCES `product_types` (`type_id`);

--
-- Constraints for table `variation_pricing`
--
ALTER TABLE `variation_pricing`
  ADD CONSTRAINT `fk_variation` FOREIGN KEY (`variation_id`) REFERENCES `product_variations` (`variation_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
