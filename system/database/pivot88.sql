-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 08, 2022 at 09:56 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pivot88`
--

-- --------------------------------------------------------

--
-- Table structure for table `piv_inspect_mainkind`
--

CREATE TABLE `piv_inspect_mainkind` (
  `fact_no` char(4) NOT NULL,
  `insp_main_no` varchar(2) NOT NULL,
  `insp_main_desc` varchar(50) NOT NULL,
  `stop_mk` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `piv_inspect_mainkind`
--

INSERT INTO `piv_inspect_mainkind` (`fact_no`, `insp_main_no`, `insp_main_desc`, `stop_mk`) VALUES
('0228', '01', 'FTW-Inline', 'N'),
('0228', '02', 'FTW-End of Line Assembly', 'N');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `piv_inspect_mainkind`
--
ALTER TABLE `piv_inspect_mainkind`
  ADD PRIMARY KEY (`fact_no`,`insp_main_no`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
