-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 07, 2023 at 12:10 PM
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
-- Table structure for table `deal`
--

CREATE TABLE `fnbpurchases` (
  `id` int(11) NOT NULL,
  `buyerName` varchar(50) NOT NULL,
  `phoneNum` varchar(8) NOT NULL,
  `fnbItemID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `deal`
--

INSERT INTO `fnbpurchases` (`id`, `buyerName`, `phoneNum`, `fnbItemID`) VALUES
(1, 'Anne', 91181859, 1);

INSERT INTO `fnbpurchases` (`id`, `buyerName`, `phoneNum`, `fnbItemID`) VALUES
(2, 'Ben', 82684624, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `deal`
--
ALTER TABLE `fnbpurchases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fnbItemID` (`fnbItemID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `deal`
--
ALTER TABLE `fnbpurchases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
