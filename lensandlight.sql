-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 17, 2024 at 07:43 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lensandlight`
--

-- --------------------------------------------------------

--
-- Table structure for table `orderitems`
--

CREATE TABLE `orderitems` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orderitems`
--

INSERT INTO `orderitems` (`order_item_id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 1, 1, 1, 251.911),
(2, 1, 6, 1, 9.810),
(3, 2, 3, 1, 37.550),
(4, 3, 5, 2, 56.321),
(5, 3, 3, 1, 33.795),
(6, 4, 2, 1, 449.880),
(7, 5, 1, 1, 279.901),
(8, 5, 6, 1, 10.900),
(9, 5, 7, 1, 20.900),
(10, 6, 4, 1, 49.900),
(11, 6, 6, 3, 10.900),
(12, 7, 1, 1, 251.911),
(13, 7, 7, 1, 18.810),
(14, 8, 3, 1, 33.795);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `customerName` varchar(100) DEFAULT NULL,
  `phoneNumber` int(8) DEFAULT NULL,
  `customerStatus` varchar(15) DEFAULT NULL,
  `locationAddress` varchar(30) DEFAULT NULL,
  `orderDate` datetime DEFAULT NULL,
  `totalPrice` decimal(10,3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `customerName`, `phoneNumber`, `customerStatus`, `locationAddress`, `orderDate`, `totalPrice`) VALUES
(1, 'Shahad Saif', 12345678, 's', 'Muscat', '2024-12-17 17:11:01', 261.721),
(2, 'Sara Ahmed', 25613249, 'e', 'AlBatinah', '2024-12-17 17:12:39', 37.550),
(3, 'Maryam Mohammed', 98881322, 's', 'Muscat', '2024-12-17 17:14:00', 146.437),
(4, 'Fatima Ali', 23111177, 'u', 'AlBuraymi', '2024-12-17 17:14:59', 449.880),
(5, 'Ahmed Ali', 93472533, 'e', 'ADakhiliyah', '2024-12-17 17:15:55', 311.701),
(6, 'Abdullah Rashid', 54472311, 'u', 'ADhahirah', '2024-12-17 17:17:04', 82.600),
(7, 'Marwan Ahmed', 32916232, 's', 'AlBuraymi', '2024-12-17 17:18:24', 270.721),
(8, 'Maria Said', 65923331, 's', 'AlBuraymi', '2024-12-17 19:42:48', 33.795);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `brand` varchar(20) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `price` decimal(10,3) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `brand`, `description`, `price`, `image`) VALUES
(1, 'CANON', 'Canon EOS 250D SLR Camera Body Black With EF-S 18-55MM F3.5-5.6 III & EF 75-300MMF4-5.6 III Lens', 279.901, 'p1.jpg'),
(2, 'NIKON', 'Nikon Z30 Digital Camera Black With 16-50mm F/3.5-6.3 Vlogger Kit', 449.880, 'p2.jpg'),
(3, 'CANON', 'Canon Zoemini S2 ZV223 Instant Camera Colour Photo Printer', 37.550, 'p3.jpg'),
(4, 'CANON', 'Canon CP1500BK Photo Printer', 49.900, 'p4.jpg'),
(5, 'CANON', 'Canon EF 50MM F/1.8 STM Camera Lens', 62.579, 'p5.jpg'),
(6, 'LEXAR', 'Lexar 128GB SDXC Card 1667X Professional', 10.900, 'p6.jpg'),
(7, 'HAMA', 'Hama 4163 Stativ Star Tripod', 20.900, 'p7.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orderitems`
--
ALTER TABLE `orderitems`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orderitems`
--
ALTER TABLE `orderitems`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orderitems`
--
ALTER TABLE `orderitems`
  ADD CONSTRAINT `orderitems_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orderitems_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
