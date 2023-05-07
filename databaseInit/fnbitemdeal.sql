-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 05, 2023 at 07:06 AM
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
-- Table structure for table `fnbitemdeal`
--

CREATE TABLE `fnbitemdeal` (
  `id` int(11) NOT NULL,
  `fnbItem_id` int(11) NOT NULL,
  `deal_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fnbitemdeal`
--

INSERT INTO `fnbitemdeal` (`id`, `fnbItem_id`, `deal_id`) VALUES
(1, 3, 1),
(2, 3, 2),
(3, 4, 1),
(4, 4, 1),
(5, 1, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fnbitemdeal`
--
ALTER TABLE `fnbitemdeal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fnbItem_id` (`fnbItem_id`),
  ADD KEY `deal_id` (`deal_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fnbitemdeal`
--
ALTER TABLE `fnbitemdeal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `fnbitemdeal`
--
ALTER TABLE `fnbitemdeal`
  ADD CONSTRAINT `fnbitemdeal_ibfk_1` FOREIGN KEY (`fnbItem_id`) REFERENCES `fnbitem` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fnbitemdeal_ibfk_2` FOREIGN KEY (`deal_id`) REFERENCES `deal` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
