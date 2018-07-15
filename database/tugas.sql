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
-- Table structure for table `tugas`
--

CREATE TABLE `tugas` (
  `id` int(11) NOT NULL,
  `nama_tugas` text NOT NULL,
  `untuk` int(11) NOT NULL,
  `target` date NOT NULL,
  `keterangan` text,
  `divisi` int(11) NOT NULL,
  `skor_target` int(11) DEFAULT '0',
  `skor_hasil` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tugas`
--

INSERT INTO `tugas` (`id`, `nama_tugas`, `untuk`, `target`, `keterangan`, `divisi`, `skor_target`, `skor_hasil`) VALUES
(11, 'Satu', 20, '2017-08-14', 'Cepat', 1, 0, 0),
(12, 'Nyahaha', 20, '2017-12-31', 'blabla', 1, 0, 0),
(13, 'Nyahaha', 21, '2017-12-31', 'blabla', 1, 122, 5),
(14, 'botol', 20, '2017-08-25', 'Aqua', 1, 0, 0),
(15, 'Botol', 20, '2017-08-26', 'Cola', 1, 0, 0),
(16, 'Botol', 21, '2017-08-26', 'Cola', 1, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tugas`
--
ALTER TABLE `tugas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tugas`
--
ALTER TABLE `tugas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
