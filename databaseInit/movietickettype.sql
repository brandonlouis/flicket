-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 16, 2023 at 11:41 AM
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
-- Database: `flicketdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `movietickettype`
--

CREATE TABLE `movietickettype` (
  `id` int(11) NOT NULL,
  `movieId` int(11) NOT NULL,
  `ticketTypeId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `movietickettype`
--
ALTER TABLE `movietickettype`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `movieId` (`movieId`,`ticketTypeId`),
  ADD KEY `mttTicketTypeFK` (`ticketTypeId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `movietickettype`
--
ALTER TABLE `movietickettype`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `movietickettype`
--
ALTER TABLE `movietickettype`
  ADD CONSTRAINT `mttMovieFK` FOREIGN KEY (`movieId`) REFERENCES `movie` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `mttTicketTypeFK` FOREIGN KEY (`ticketTypeId`) REFERENCES `tickettype` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
