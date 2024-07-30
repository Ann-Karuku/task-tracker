-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 11, 2024 at 09:35 AM
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
  `Password` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `officers`
--

INSERT INTO `officers` (`Officer_Code`, `Officer_Name`, `Officer_Designation`, `Department`, `Officer_Contact`, `Remarks`, `Profile_Pic`, `Password`) VALUES
('001', 'Felix Kinyua', 'Admin', 'ICT', '0712345678', '', 'girl_with_vr_headset-t2.jpg', '7390f1767a571aa815790509019764fe0a526a1c80173bd8c14840b8563f133786315eb12134a1aa85f4c70b842a3853b94322980e9e9c244fc6963bd7ef4250'),
('004', 'Charity Mwangi', 'Officer', 'ICT', '0100000000', '', '6656efc7d59c09.38286005.jpg', '037f118af192c1db14d6a437df58dc39fdd2ea0ef0f739c764'),
('008', 'Sareto', 'Officer', 'ICT', '0712345678', '', '1587159479421.jpg', '469992af7496d5855f5afd158a4862bb698013a487b12fc489a992b07c37ea6a0619ac414b87eb905d2ba4563d1d975f29e8b9c5fe9188ea7cef38ba7858e6a2'),
('009', 'Deity', 'Officer', 'ICT', '01010101001', '', 'Nail001.jpg', 'f8c2f5310dc1b316980c22a86f25beadb30ca6cdd1b9d03eddc2483ddec1583fa3a9564c4cf82560119ea93a2663d018ab6d1111cb173d222a2669f026998040');

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
