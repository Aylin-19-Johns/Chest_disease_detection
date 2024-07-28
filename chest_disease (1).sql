-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 16, 2024 at 05:35 PM
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
-- Database: `chest_disease`
--

-- --------------------------------------------------------

--
-- Table structure for table `doctor_prescribtion`
--

CREATE TABLE `doctor_prescribtion` (
  `ID` int(11) NOT NULL,
  `PAT_ID` int(11) NOT NULL,
  `DOC_ID` int(11) NOT NULL,
  `MESSAGE` text NOT NULL,
  `DATE` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor_prescribtion`
--

INSERT INTO `doctor_prescribtion` (`ID`, `PAT_ID`, `DOC_ID`, `MESSAGE`, `DATE`) VALUES
(1, 1, 2, 'You have to take rest', '2024-03-23'),
(2, 1, 2, 'Nothing to worry about this.', '2024-03-24');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `ID` int(11) NOT NULL,
  `NAME` varchar(30) NOT NULL,
  `MAIL_ID` varchar(50) NOT NULL,
  `PASSWORD` varchar(30) NOT NULL,
  `TYPE` int(11) NOT NULL,
  `APPROVAL` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`ID`, `NAME`, `MAIL_ID`, `PASSWORD`, `TYPE`, `APPROVAL`) VALUES
(1, 'Sreya', 'sreya@gmail.com', 'sreya@123', 2, 1),
(2, 'Jayaraj', 'jayarajmotif@gmail.com', 'Jaya@123', 1, 0),
(3, 'dharun', 'dharun@user.com', '123456', 2, 1),
(4, 'anu', 'anu@gmail.com', 'sreya@123', 2, 1),
(5, 'admin', 'admin@chest.com', 'admin', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `patient_disease`
--

CREATE TABLE `patient_disease` (
  `ID` int(11) NOT NULL,
  `PAT_ID` int(11) NOT NULL,
  `DOC_ID` int(11) NOT NULL,
  `FILE_LOC` varchar(200) NOT NULL,
  `RESULT` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient_disease`
--

INSERT INTO `patient_disease` (`ID`, `PAT_ID`, `DOC_ID`, `FILE_LOC`, `RESULT`) VALUES
(4, 1, 2, 'upload/1711216883_33.jpeg', '\nbacterialpneumonia\n'),
(5, 4, 2, 'upload/1711221294_aug__0_1441.jpg', '\nviralpneumonia\n');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `doctor_prescribtion`
--
ALTER TABLE `doctor_prescribtion`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `MAIL_ID` (`MAIL_ID`);

--
-- Indexes for table `patient_disease`
--
ALTER TABLE `patient_disease`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `doctor_prescribtion`
--
ALTER TABLE `doctor_prescribtion`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `patient_disease`
--
ALTER TABLE `patient_disease`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
