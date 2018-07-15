-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 07, 2017 at 05:49 PM
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
-- Table structure for table `realisasi_tugas`
--

CREATE TABLE `realisasi_tugas` (
  `id` int(11) NOT NULL,
  `id_tugas` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `realisasi` date DEFAULT NULL,
  `keterangan` text NOT NULL,
  `berkas` varchar(255) NOT NULL,
  `skor` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `realisasi_tugas`
--

INSERT INTO `realisasi_tugas` (`id`, `id_tugas`, `id_user`, `realisasi`, `keterangan`, `berkas`, `skor`) VALUES
(6, 13, 21, '2017-08-31', 'The quick brown fox jumps over the lazy dog\r\nThe quick brown fox jumps over the lazy dog\r\nThe quick brown fox jumps over the lazy dog', 'SBMPTN 2015 IPB.pdf', 0),
(7, 16, 21, '2017-08-31', 'Lwk laiu aliej akd akdj adi akdf akjdl  ;dl alid lkajdlkf jld j,dl ajlkdf', 'SBMPTN 2015 IPB.pdf', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `realisasi_tugas`
--
ALTER TABLE `realisasi_tugas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `realisasi_tugas`
--
ALTER TABLE `realisasi_tugas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
