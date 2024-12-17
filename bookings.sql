-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 17, 2024 at 02:33 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lensandlightdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `Booking_ID` int(11) NOT NULL,
  `Customer_name` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Service` varchar(255) NOT NULL,
  `Preferred_date` date NOT NULL,
  `Location` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`Booking_ID`, `Customer_name`, `Email`, `Service`, `Preferred_date`, `Location`) VALUES
(21, 'Mariam', 's141535@student.squ.edu.om', 'portrait', '2024-12-20', 'Oman'),
(22, 'Sara', 's155535@student.squ.edu.om', 'commercial', '2024-12-20', 'Muscat'),
(23, 'Mohammed', 's1@gmail.com', 'commercial', '2025-01-04', 'Nizwa'),
(24, 'Ahmed', 'a1@gmail.com', 'event', '2025-01-07', 'Ibri'),
(25, 'Maria', 'h1@gmail.com', 'portrait', '2025-02-07', 'Al-seeb'),
(26, 'Reema', 'r1@gmail.com', 'event', '2025-03-18', 'Izki'),
(27, 'waleeed', 'w1@gmail.com', 'event', '2025-03-31', 'Samael');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`Booking_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `Booking_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
