-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 22, 2026 at 03:32 AM
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
-- Database: `easybus`
--

-- --------------------------------------------------------

--
-- Table structure for table `accepted_requests`
--
 CREATE DATABASE IF NOT EXISTS easybus;
 USE easybus;

CREATE TABLE `accepted_requests` (
  `id` int(11) NOT NULL,
  `driver_id` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accepted_requests`
--

INSERT INTO `accepted_requests` (`id`, `driver_id`, `message`, `created_at`, `status`) VALUES
(6, 2, 'Driver lansime is coming to pick up passengers.', '2026-05-20 03:46:46', 'completed'),
(7, 2, 'Driver lansime is coming to pick up passengers.', '2026-05-20 03:46:51', 'completed'),
(8, 2, 'Driver lansime is coming to pick up passengers.', '2026-05-20 03:46:53', 'completed'),
(9, 2, 'Driver lansime is coming to pick up passengers.', '2026-05-21 01:23:18', 'completed'),
(10, 2, 'Driver lansime is coming to pick up passengers.', '2026-05-21 01:23:20', 'completed'),
(11, 2, 'Driver lansime is coming to pick up passengers.', '2026-05-21 14:38:24', 'completed'),
(12, 2, 'Driver lansime is coming to pick up passengers.', '2026-05-21 14:42:41', 'completed'),
(13, 2, 'Driver lansime is coming to pick up passengers.', '2026-05-21 14:45:01', 'completed'),
(14, 2, 'Driver lansime is coming to pick up passengers.', '2026-05-21 20:23:20', 'completed'),
(15, 2, 'Driver lansime is coming to pick up passengers.', '2026-05-21 20:24:44', 'completed');

-- --------------------------------------------------------

--
-- Table structure for table `commuters`
--

CREATE TABLE `commuters` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `commuters`
--

INSERT INTO `commuters` (`id`, `username`, `password`) VALUES
(14, 'User1', '$2y$10$GXhnR3dugPX7u2yuOf/3ouzwv5vBEFiw0oy/e2LAWgmfREX/wYihO'),
(15, 'User2', '$2y$10$e5IexTW3fr1MvA.b18F1I.jR01kYQYMw15dWWyljaysGVwCtRFop.'),
(16, 'User3', '$2y$10$3E7IIy/dHG1q8c7wa6ihAug2ASh74Kg16AYC.88vu5/AafktvmTyq'),
(18, 'User5', '$2y$10$cSfoaprzJ/D8rmhX5JZOJ.YzYF4Q3vVkwYqMZSzy71tzSQtlOQQxG'),
(19, 'User4', '$2y$10$BSE1ahiuJbH30smzhJKaU.Cn.Ip.s0GC71M/4KzShAVnzPM3zFOc2');

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE `drivers` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `available` varchar(10) DEFAULT 'yes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `drivers`
--

INSERT INTO `drivers` (`id`, `username`, `password`, `available`) VALUES
(2, 'lansime', '$2y$10$3.12GzTT8QzsVRsR.mC2IugKdXcrDKfc6CGYMtW6Z2UTP5AkD/zWe', 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `id` int(11) NOT NULL,
  `commuter_name` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `zone` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`id`, `commuter_name`, `created_at`, `zone`) VALUES
(57, 'lansime', '2026-05-21 20:24:50', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accepted_requests`
--
ALTER TABLE `accepted_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `driver_id` (`driver_id`);

--
-- Indexes for table `commuters`
--
ALTER TABLE `commuters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accepted_requests`
--
ALTER TABLE `accepted_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `commuters`
--
ALTER TABLE `commuters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `drivers`
--
ALTER TABLE `drivers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accepted_requests`
--
ALTER TABLE `accepted_requests`
  ADD CONSTRAINT `accepted_requests_ibfk_1` FOREIGN KEY (`driver_id`) REFERENCES `drivers` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
