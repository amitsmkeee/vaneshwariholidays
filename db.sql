-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 10, 2023 at 05:29 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vaneshwari`
--

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `id` int(11) NOT NULL,
  `invoiceId` int(11) DEFAULT NULL,
  `buyerName` varchar(255) DEFAULT NULL,
  `buyerAddress` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `companyId` int(11) DEFAULT NULL,
  `sgst` double DEFAULT NULL,
  `cgst` double DEFAULT NULL,
  `totalAmount` double DEFAULT NULL,
  `cBy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`id`, `invoiceId`, `buyerName`, `buyerAddress`, `date`, `companyId`, `sgst`, `cgst`, `totalAmount`, `cBy`) VALUES
(1, 1, 'amit', 'test', '2023-09-11', 1, 5, 5, 100, 1);

-- --------------------------------------------------------

--
-- Table structure for table `invoiceItem`
--

CREATE TABLE `invoiceItem` (
  `id` int(11) NOT NULL,
  `siNo` int(11) NOT NULL,
  `invoiceId` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `hsn` varchar(255) NOT NULL,
  `amount` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoiceItem`
--

INSERT INTO `invoiceItem` (`id`, `siNo`, `invoiceId`, `name`, `hsn`, `amount`) VALUES
(1, 1, 1, 'amit', '12333', 100);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userId` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `companyId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userId`, `username`, `email`, `password`, `companyId`) VALUES
(1, 'abhi', 'abhi', '$2y$13$lOa3ysqu7uMFtJGS7l0tDeajuRi5f/fOvkaWC7BFaOzfs4dmCZdp6', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoiceId_CompanyId` (`invoiceId`,`companyId`);

--
-- Indexes for table `invoiceItem`
--
ALTER TABLE `invoiceItem`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_invoiceId` (`id`,`invoiceId`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userId`),
  ADD UNIQUE KEY `userId_companyId` (`userId`,`companyId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `invoiceItem`
--
ALTER TABLE `invoiceItem`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
