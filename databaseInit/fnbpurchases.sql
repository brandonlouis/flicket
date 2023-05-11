-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 10, 2023 at 04:19 PM
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
-- Table structure for table `fnbpurchases`
--

CREATE TABLE `fnbpurchases` (
  `id` int(11) NOT NULL,
  `buyerName` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `fnbItemID` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fnbpurchases`
--

INSERT INTO `fnbpurchases` (`id`, `buyerName`, `email`, `fnbItemID`, `quantity`) VALUES
(1, 'Anne', 'anneRuOK@gmail.com', 1, 1),
(2, 'Ben', 'benbenbenbenben@hotmail.com', 2, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fnbpurchases`
--
ALTER TABLE `fnbpurchases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fnbItemID` (`fnbItemID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fnbpurchases`
--
ALTER TABLE `fnbpurchases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
