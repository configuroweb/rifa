-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 12, 2022 at 07:02 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `raffle_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `code`, `name`) VALUES
(2, '6231415', 'Mark Cooper'),
(4, 'WUB93NWW8FG', 'Colton Parsons'),
(5, 'QEJ41PMK1PX', 'Cara Lynn'),
(6, 'SSB06QKY5VF', 'Cameron Black'),
(7, 'URE38IYJ2MT', 'Charissa Anderson'),
(8, 'ERI25DQE5RJ', 'Donovan Walters'),
(9, 'LSF46XXX8HK', 'Angela Vinson'),
(10, 'SSN55RSP2DH', 'Acton Rosales'),
(11, 'NSI93DGR7TL', 'Harding Russo'),
(12, 'CXO32TMQ5PG', 'Norman Lewis'),
(13, 'MTK93IJJ8ZL', 'Jolie Rodriquez'),
(14, 'RRK60JER7LV', 'Joel Mercer'),
(15, 'FPY19DMI5BL', 'Ariel Jacobson'),
(16, 'EWI37NKV7TS', 'Jonah Jarvis'),
(17, 'CNN41HOV6WE', 'Macaulay Byrd'),
(18, 'KAA41ZHZ1MD', 'Marah Knowles');

-- --------------------------------------------------------

--
-- Table structure for table `winners`
--

CREATE TABLE `winners` (
  `id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `draw` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `winners`
--

INSERT INTO `winners` (`id`, `ticket_id`, `draw`) VALUES
(1, 7, 1),
(3, 5, 2),
(4, 5, 3),
(5, 16, 4),
(6, 14, 5),
(7, 15, 6),
(8, 9, 7);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `winners`
--
ALTER TABLE `winners`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_id_fk` (`ticket_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `winners`
--
ALTER TABLE `winners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `winners`
--
ALTER TABLE `winners`
  ADD CONSTRAINT `ticket_id_fk` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;
