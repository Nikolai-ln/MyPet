-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 02, 2025 at 09:00 PM
-- Server version: 5.7.21
-- PHP Version: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mypet`
--

-- --------------------------------------------------------

--
-- Table structure for table `pet`
--

DROP TABLE IF EXISTS `pet`;
CREATE TABLE IF NOT EXISTS `pet` (
  `pet_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `type` varchar(55) NOT NULL,
  `breed` varchar(55) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `information` varchar(2009) DEFAULT NULL,
  `owner` varchar(111) DEFAULT NULL,
  `address` varchar(125) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`pet_id`),
  KEY `fk_pet_user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pet_vaccine`
--

DROP TABLE IF EXISTS `pet_vaccine`;
CREATE TABLE IF NOT EXISTS `pet_vaccine` (
  `pet_vaccine_id` int(11) NOT NULL AUTO_INCREMENT,
  `pet_id` int(11) NOT NULL,
  `vaccine_id` int(11) NOT NULL,
  `date_given` date NOT NULL,
  PRIMARY KEY (`pet_vaccine_id`),
  KEY `fk_pet_vaccine_vaccine` (`vaccine_id`),
  KEY `fk_pet_vaccine_pet` (`pet_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `photo`
--

DROP TABLE IF EXISTS `photo`;
CREATE TABLE IF NOT EXISTS `photo` (
  `photo_id` int(11) NOT NULL AUTO_INCREMENT,
  `path` varchar(512) NOT NULL,
  `pet_id` int(11) NOT NULL,
  PRIMARY KEY (`photo_id`),
  KEY `fk_photo_pet` (`pet_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(55) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'user',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `password`, `role`) VALUES
(1, 'admin', '$2y$13$1gwxL5yE.GkGQpk3i4dp7OfqLmuMEHFoPXLkwGjvYjBdquYAIg.9.', 'admin'),
(2, 'NikolayLN', '$2y$13$.JJrZDBwlyt.G.S9CY1VW.R99LECPOWxLNkA8lVxGBVfxOAO7tZuC', 'admin'),
(3, 'demo', '$2y$13$Knpo58u3c.YYA9fmLSEfLe8uOsyT/4FDuodiR8Xm9w3sfFRrll1SK', 'user'),
(4, 'Petar', '$2y$13$9yEAolLIvQ90pRsA7tjk5.1quttfUFtnKr7I4QqlQlsDKWp66iwrW', 'user'),
(5, 'Hrisi', '$2y$13$tvqgJa3WXxTxZ56ozn/fkejvVWr.pqj432LMXTrwYufa8E.dDlPPC', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `vaccine`
--

DROP TABLE IF EXISTS `vaccine`;
CREATE TABLE IF NOT EXISTS `vaccine` (
  `vaccine_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` varchar(2009) DEFAULT NULL,
  PRIMARY KEY (`vaccine_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pet`
--
ALTER TABLE `pet`
  ADD CONSTRAINT `fk_pet_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pet_vaccine`
--
ALTER TABLE `pet_vaccine`
  ADD CONSTRAINT `fk_pet_vaccine_pet` FOREIGN KEY (`pet_id`) REFERENCES `pet` (`pet_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pet_vaccine_vaccine` FOREIGN KEY (`vaccine_id`) REFERENCES `vaccine` (`vaccine_id`) ON UPDATE CASCADE;

--
-- Constraints for table `photo`
--
ALTER TABLE `photo`
  ADD CONSTRAINT `fk_photo_pet` FOREIGN KEY (`pet_id`) REFERENCES `pet` (`pet_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
