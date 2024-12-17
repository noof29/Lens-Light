-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2024 at 10:35 PM
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
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `inquiry` text NOT NULL,
  `submission_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `inquiry`, `submission_date`) VALUES
(1, 'Noof Al-shamli', 's141481@student.squ.edu.om', 'Great website !', '2024-12-16 19:58:11'),
(2, 'Noor Al-shamli', 's12345@student.squ.edu.om', 'Do you offer discounts for students or professionals?', '2024-12-16 19:59:59'),
(3, 'Abrar Al-hatmi', 's1234@student.squ.edu.om', 'How can I return a defective lens I received?', '2024-12-16 20:01:10'),
(4, 'Sara Ahmed', 'sara.ahmed@gmail.com', 'I would like to know more about your camera collection.', '2024-12-16 20:02:40'),
(5, 'John Doe', 'john.doe@gmail.com', 'We would love to feature your products on our photography blog', '2024-12-16 20:04:11'),
(6, 'Ali Khan', 'ali.khan@gmail.com', 'How can I contact you?', '2024-12-16 20:06:12'),
(7, 'Linda Brown', 'linda.brown@gmail.com', 'Great website and products! Keep up the good work', '2024-12-16 20:08:23'),
(8, 'Saif ', 'saif@gmail.com', 'please provide more types of Camera :)', '2024-12-16 21:35:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
