-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 30, 2024 at 09:06 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `task_tracker`
--

-- --------------------------------------------------------

--
-- Table structure for table `officers`
--

CREATE TABLE `officers` (
  `Officer_Code` varchar(25) NOT NULL,
  `Officer_Name` varchar(50) NOT NULL,
  `Officer_Designation` varchar(50) NOT NULL,
  `Department` varchar(50) NOT NULL,
  `Officer_Contact` varchar(50) NOT NULL,
  `Remarks` varchar(100) NOT NULL,
  `Profile_Pic` varchar(256) NOT NULL,
  `Password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `officers`
--

INSERT INTO `officers` (`Officer_Code`, `Officer_Name`, `Officer_Designation`, `Department`, `Officer_Contact`, `Remarks`, `Profile_Pic`, `Password`) VALUES
('001', 'Felix Kinyua', 'Admin', 'ICT', '077777777777', '', '66545b7d791300.58080572.jpg', 'Felix123'),
('003', 'Faith', 'Officer', 'ICT', '0712345678', 'excellent', '66545b7d791300.58080572.jpg', 'Faith123'),
('004', 'Charity Mwangi', 'Officer', 'ICT', '0100000000', '', '6656efc7d59c09.38286005.jpg', '037f118af192c1db14d6a437df58dc39fdd2ea0ef0f739c764'),
('007', 'Brian Rop', 'Officer', 'ICT', '0799999999', '', '6656eff323e168.02194605.jpg', 'd1905252451d2d5d664f7c4d382acd0258c7c076691edad039');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `Task_ID` int(11) NOT NULL,
  `Officer_Code` varchar(50) NOT NULL,
  `Date` date NOT NULL,
  `Support_Request` varchar(256) NOT NULL,
  `Support_Given` varchar(256) NOT NULL,
  `Remarks` varchar(100) NOT NULL,
  `Office_NO` varchar(50) NOT NULL,
  `Department` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`Task_ID`, `Officer_Code`, `Date`, `Support_Request`, `Support_Given`, `Remarks`, `Office_NO`, `Department`) VALUES
(5, '004', '2024-05-27', 'Network issues', 'Network troubleshooting', 'Failed', '1700', 'DIT'),
(7, '004', '2024-05-27', 'Printer Paper Jam', 'Printer fixed', 'Successful', '1417', 'ICT'),
(8, '004', '2024-05-27', 'Internet and network unavailability', 'Cable crimping and reconfiguration', 'Successful', '1411', 'HRM&D');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `officers`
--
ALTER TABLE `officers`
  ADD PRIMARY KEY (`Officer_Code`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`Task_ID`),
  ADD KEY `Officer_Code` (`Officer_Code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `Task_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`Officer_Code`) REFERENCES `officers` (`Officer_Code`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
