-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 17, 2024 at 07:18 PM
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
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `experience` varchar(50) NOT NULL,
  `services` varchar(255) DEFAULT NULL,
  `comments` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `name`, `email`, `experience`, `services`, `comments`) VALUES
(39, 'Fatma', 's14181@gmail.com', 'Excellent', 'Portrait Photography', 'Booking our event through the website was so easy and smooth! The photographer captured every special moment perfectly, and the photos were delivered quickly. Highly recommended for anyone planning events!'),
(40, 'shams', 'shams@gmail.com', 'Excellent', 'Event Photography', 'I had an amazing experience booking a portrait session. The photographer made me feel comfortable and guided me on poses, resulting in stunning, natural-looking photos that I absolutely love!'),
(41, 'Deema', 'Deema@gmail.com', 'Good', 'Commercial Photography', 'We booked the photographer for a commercial shoot, and the quality exceeded our expectations. The attention to detail and professionalism were outstanding. The final images truly elevated our brand.'),
(42, 'Abdullah', 'Abdullah@gmail.com', 'Excellent', 'Portrait Photography, Event Photography', 'he website is very user-friendly, and I easily found the right package for my needs. The booking process was quick, and communication with the photographer was seamless!.'),
(43, 'sultan', 'sotan@gmail.com', 'Excellent', 'Commercial Photography', 'We hired the photographer for product photography for our business. The results were outstanding?high-quality images that showcased our products beautifully. The website made the entire process so simple and organized'),
(44, 'noof', 'noof@gmail.com', 'Excellent', 'Portrait Photography', '\"I booked a portrait session for my family, and the experience was wonderful. The photographer was very professional, patient, and creative. The website gallery made it easy to choose our favorite photos!'),
(45, 'ali', 'ali@gmail.com', 'Excellent', 'Event Photography', '\"The photographer did an exceptional job capturing our corporate event. From candid shots to group photos, everything was perfect. The website also made scheduling and follow-ups effortless!');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
