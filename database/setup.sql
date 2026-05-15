-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 25, 2025 at 07:27 PM
-- Server version: 8.0.40-0ubuntu0.24.04.1
-- PHP Version: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `reservations`
--

-- --------------------------------------------------------
-- Create the database
CREATE DATABASE IF NOT EXISTS `reservations1`;
USE `reservations1`;


--
-- Table structure for table `job_applications`
--

CREATE TABLE `job_applications` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `role` varchar(50) NOT NULL,
  `cv_file` varchar(255) NOT NULL,
  `applied_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int NOT NULL,
  `service_id` int NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `reservation_date` date NOT NULL,
  `reservation_time` time NOT NULL,
  `guest_count` int NOT NULL,
  `lead_name` varchar(255) NOT NULL,
  `requirements` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int NOT NULL,
  `service_name` enum('Breakfast','Lunch','Dinner') NOT NULL,
  `day_of_week` enum('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday') NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `total_tables` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `service_name`, `day_of_week`, `start_time`, `end_time`, `total_tables`) VALUES
(1, 'Breakfast', 'Monday', '07:30:00', '10:30:00', 10),
(2, 'Lunch', 'Monday', '12:00:00', '14:30:00', 10),
(3, 'Dinner', 'Monday', '17:00:00', '22:30:00', 10),
(4, 'Breakfast', 'Tuesday', '07:30:00', '10:30:00', 10),
(5, 'Lunch', 'Tuesday', '12:00:00', '14:30:00', 10),
(6, 'Dinner', 'Tuesday', '17:00:00', '22:30:00', 10),
(7, 'Breakfast', 'Wednesday', '07:30:00', '10:30:00', 10),
(8, 'Lunch', 'Wednesday', '12:00:00', '14:30:00', 10),
(9, 'Dinner', 'Wednesday', '17:00:00', '22:30:00', 10),
(10, 'Breakfast', 'Thursday', '07:30:00', '10:30:00', 10),
(11, 'Lunch', 'Thursday', '12:00:00', '14:30:00', 10),
(12, 'Dinner', 'Thursday', '17:00:00', '22:30:00', 10),
(13, 'Breakfast', 'Friday', '07:30:00', '10:30:00', 10),
(14, 'Lunch', 'Friday', '12:00:00', '14:30:00', 10),
(15, 'Dinner', 'Friday', '17:00:00', '22:30:00', 10),
(16, 'Breakfast', 'Saturday', '07:30:00', '10:30:00', 10),
(17, 'Lunch', 'Saturday', '12:00:00', '14:30:00', 10),
(18, 'Dinner', 'Saturday', '17:00:00', '22:30:00', 10),
(19, 'Breakfast', 'Sunday', '07:30:00', '10:30:00', 10),
(20, 'Lunch', 'Sunday', '12:00:00', '14:30:00', 10),
(21, 'Dinner', 'Sunday', '17:00:00', '22:30:00', 10);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('staff','diner') DEFAULT 'diner',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `job_applications`
--
ALTER TABLE `job_applications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `job_applications`
--
ALTER TABLE `job_applications`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
