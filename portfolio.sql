-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 15, 2024 at 06:53 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `portfolio_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `portfolio`
--

CREATE TABLE `portfolio` (
  `id` int(11) NOT NULL,
  `name` varchar(225) NOT NULL,
  `category` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `imgSrc` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `portfolio`
--

INSERT INTO `portfolio` (`id`, `name`, `category`, `description`, `imgSrc`) VALUES
(1, 'Sarah Al Manji', 'Portrait', 'Sarah is a gifted portrait photographer who is renowned for capturing her subjects\'genuine personalities. She produces personal and emotive photographs that showcase her customer\'s personalities and feelings since she has an excellent eye for detail and a love of telling stories. Sarah\'s art radiates warmth and genuineness, whether it s a family portrait or a business headshot.', 'portrait.jpeg'),
(2, 'Ahmed Al Harthi', 'Landscape', 'Ahmed is a passionate landscape photographer who uses his camera to capture the splendor of the natural world. His artwork frequently captures the ideal lighting and dramatic weather conditions, showcasing breathtaking panoramas ranging from tranquil seascapes to towering mountain ranges. Every photograph he takes reflects his profound love of the outdoors, which makes his work an uplifting ode to nature.', 'landscape.jpeg'),
(3, 'Zaid Al Shamsi', 'Architecture', 'Zaid is a talented architecture photographer who has an excellent sense of symmetry, light and shadow interaction, and detail. Zaid has a passion for portraying the beauty of structures, and his work includes detailed interiors, modern skyscrapers, and historic buildings. By emphasizing angles and views that highlight distinctive elements, his photography captures the uniqueness and beauty of architectural projects. Through his photography, Zaid aims to convey the narrative of every area, highlighting its composition and character.', 'architecture.jpg'),
(5, 'Mia Al Maskari', 'Candid', 'Mia is an enthusiastic candid photographer who focuses on catching unplanned moments in daily life. Her art demonstrates real feelings and spontaneous exchanges, highlighting the beauty of life\'s ephemeral moments. Whether it\'s a happy grin, a contemplative look, or a peaceful moment of introspection, Mia\'s photography captures the moments that are frequently overlooked. Through her photographs, she hopes to celebrate the genuineness of human experiences and arouse sentiments of connection and nostalgia.', 'candid.jpeg'),
(6, 'Reem Al Amri', 'Commercial and Event', 'Reem is an expert in event and commercial photography, assisting companies and brands in using compelling imagery to communicate their messages. Her work ranges widely, from lifestyle photos and advertising campaigns to business events and product launches. Reem\'s strategy ensures that every image appeals to the target audience by fusing creativity with a strong emphasis on brand identity.', 'event.jpeg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `portfolio`
--
ALTER TABLE `portfolio`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `portfolio`
--
ALTER TABLE `portfolio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
