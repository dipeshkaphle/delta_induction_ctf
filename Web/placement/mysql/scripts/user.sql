-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Aug 25, 2021 at 11:28 AM
-- Server version: 8.0.25
-- PHP Version: 7.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dctf`
--

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE DATABASE dctf;
USE dctf;

CREATE TABLE `user` (
  `id` int NOT NULL,
  `rollno` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `isadmin` tinyint(1) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `rollno`, `isadmin`, `password`) VALUES
(1, '106119199', 0, 'deltactf'),
(2, '103892572', 0, 'deltactf'),
(3, '153843726', 0, 'deltactf'),
(4, '156842352', 0, 'deltactf'),
(5, '107862542', 1, 'sollamatenpoda'),
(6, '453838539', 0, 'deltactf'),
(7, '8958532183', 0, 'deltactf'),
(8, '654546483', 0, 'deltactf'),
(9, '8651268642', 0, 'deltactf'),
(10, '3436867534', 0, 'deltactf');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

CREATE USER 'dev'@'%' IDENTIFIED WITH mysql_native_password BY 'd5s5s45gv465giehr';
GRANT SELECT ON dctf.* TO 'dev'@'%';ALTER USER 'dev'@'%' REQUIRE NONE WITH 
MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;
