-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 28, 2023 at 03:53 PM
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
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `id` int(11) NOT NULL,
  `fullName` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phoneNo` int(8) NOT NULL,
  `password` varchar(250) NOT NULL,
  `userType` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`id`, `fullName`, `email`, `phoneNo`, `password`, `userType`) VALUES
(1, 'Adam Tan', 'adamtan@flicket.com', 91234567, '$2y$10$9n5ZbEIiw/RMHmHMTFr5Y.vpDv7/kZcHSEwNEMre6jcIyUCAMNNbu', 'userAdmin'),
(2, 'Alicia Mark', 'aliciam@flicket.com', 81234567, '$2y$10$youlXqZbckUSndkISxUI/eKqjiCk8mcoPRzBgF0EYv8CY2S0epNBy', 'userAdmin'),
(3, 'Bob Ng', 'bobng@flicket.com', 98765432, '$2y$10$SbfdPUEo0Z23mxQ8mpfPeO8Zy6I4u2xeuxiwXA1yDIPw5jYZeVirO', 'cinemaManager'),
(4, 'Bala Gonzales', 'balag@flicket.com', 88765432, '$2y$10$WHhQphuq/rvbDAHnO1Ihte2zamA0xbieyT7i9FVKOx88OYCPh5GQ2', 'cinemaManager'),
(5, 'Caroline Jacobs', 'carolinej@flicket.com', 98761234, '$2y$10$VIHm/goQv4rUdRhNdEol9uk6Tyu82GU6QnLitYqlvhsygM8gb3mk6', 'cinemaOwner'),
(6, 'Calvin Klein', 'calvink@flicket.com', 88761234, '$2y$10$DpFcxoO9zGkseoLeqKabxePq99iL1RFY.K3Hh0BHr3GM5VbEelI7.', 'cinemaOwner'),
(7, 'Zion Faries', 'zionf@gmail.com', 91238765, '$2y$10$d1QTG.D.lRMgzAcAvptivuFhoKVc0arAJhvH2et3SIfu.aFR7yL3m', 'customer'),
(8, 'Zac Efron', 'zace@gmail.com', 81238765, '$2y$10$JSrQzq5w/A5ipcuvMHSkSe2mHiFUOQ6g8bqewZQbUP7Ymfx2UgZrm', 'customer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQUE` (`email`),
  ADD KEY `account_fk` (`userType`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `account`
--
ALTER TABLE `account`
  ADD CONSTRAINT `account_fk` FOREIGN KEY (`userType`) REFERENCES `profile` (`userType`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
