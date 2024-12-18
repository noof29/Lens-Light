-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 18, 2024 at 04:41 PM
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
-- Database: `store`
--

-- --------------------------------------------------------

--
-- Table structure for table `orderitems`
--

CREATE TABLE `orderitems` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orderitems`
--

INSERT INTO `orderitems` (`order_item_id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 1, 1, 1, 279.901),
(2, 1, 6, 1, 10.900),
(3, 2, 3, 1, 37.550),
(4, 3, 7, 1, 20.900),
(5, 3, 2, 1, 449.880),
(6, 4, 4, 1, 49.900),
(7, 5, 5, 1, 62.579),
(8, 5, 4, 1, 49.900),
(9, 6, 1, 1, 279.901),
(10, 7, 3, 1, 37.550),
(11, 7, 4, 1, 49.900);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `customer_name` varchar(50) NOT NULL,
  `phone` int(12) NOT NULL,
  `email` varchar(100) NOT NULL,
  `shippingAddress` varchar(100) NOT NULL,
  `total` decimal(10,3) NOT NULL,
  `order_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `customer_name`, `phone`, `email`, `shippingAddress`, `total`, `order_date`) VALUES
(1, 'Shahad Saif', 12345678, 'shahad222@example.com', 'Muscat', 290.801, '2024-12-18'),
(2, 'Sara Ahmed', 25613249, 'saa127rr@example2.com', 'Oman/Sohar', 37.550, '2024-12-18'),
(3, 'Abdullah Rashid', 93472533, 'baa23aa@example3.com', 'Oman/Ibri', 470.780, '2024-12-18'),
(4, 'Fatima Ali', 54472311, 'faa55ma@example4.com', 'AlBuraimi', 49.900, '2024-12-18'),
(5, 'Ahmed Ali', 94512333, 'ahmed12@example5.com', 'Oman/Muscat', 112.479, '2024-12-18'),
(6, 'Marwan Ahmed', 23111177, 'mmmr23m@example6.com', 'Nizwa', 279.901, '2024-12-18'),
(7, 'Maryam Mohammed', 63543433, 'maryam111@example7.com', 'Oman/Muscat', 87.450, '2024-12-18');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `brand` varchar(50) NOT NULL,
  `price` decimal(10,3) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `description`, `brand`, `price`, `image`) VALUES
(1, 'Canon EOS 250D SLR Camera Body Black With EF-S 18-55MM F3.5-5.6 III & EF 75-300MMF4-5.6 III Lens', 'CANON', 279.901, 'p1.jpg'),
(2, 'Nikon Z30 Digital Camera Black With 16-50mm F/3.5-6.3 Vlogger Kit', 'NIKON', 449.880, 'p2.jpg'),
(3, 'Canon Zoemini S2 ZV223 Instant Camera Colour Photo Printer', 'CANON', 37.550, 'p3.jpg'),
(4, 'Canon CP1500BK Photo Printer', 'CANON', 49.900, 'p4.jpg'),
(5, 'Canon EF 50MM F/1.8 STM Camera Lens', 'CANON', 62.579, 'p5.jpg'),
(6, 'Lexar 128GB SDXC Card 1667X Professional', 'LEXAR', 10.900, 'p6.jpg'),
(7, 'Hama 4163 Stativ Star Tripod', 'HAMA', 20.900, 'p7.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orderitems`
--
ALTER TABLE `orderitems`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `fk_orderitems_products` (`product_id`),
  ADD KEY `fk_orderitems_orders` (`order_id`);

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
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
  ADD CONSTRAINT `fk_orderitems_orders` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_orderitems_products` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
