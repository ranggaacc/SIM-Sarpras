-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 07, 2017 at 05:50 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `biofarmaka`
--

-- --------------------------------------------------------

--
-- Table structure for table `kualitas_kerja`
--

CREATE TABLE `kualitas_kerja` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tahun` int(11) NOT NULL,
  `bulan` int(11) NOT NULL,
  `produktivitas` int(11) DEFAULT NULL,
  `inisiatif` int(11) NOT NULL DEFAULT '0',
  `tanggung_jawab` int(11) NOT NULL DEFAULT '0',
  `ketelitian` int(11) NOT NULL DEFAULT '0',
  `efisiensi` int(11) NOT NULL DEFAULT '0',
  `kerjasama` int(11) NOT NULL DEFAULT '0',
  `kedisiplinan` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kualitas_kerja`
--
ALTER TABLE `kualitas_kerja`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kualitas_kerja`
--
ALTER TABLE `kualitas_kerja`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
