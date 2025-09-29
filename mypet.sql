-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 29, 2025 at 08:20 AM
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
  `email` varchar(72) DEFAULT NULL,
  `phone_number` varchar(21) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `photo` varchar(512) DEFAULT NULL,
  PRIMARY KEY (`pet_id`),
  KEY `fk_pet_user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pet`
--

INSERT INTO `pet` (`pet_id`, `name`, `type`, `breed`, `date_of_birth`, `information`, `owner`, `address`, `email`, `phone_number`, `user_id`, `photo`) VALUES
(1, 'Джилда', 'куче', 'пинчер', '2009-04-21', 'Най-доброто куче! Кафяв пинчер.', 'Николай Николов', 'Пловдив', 'niki@abv.bg', '0885123456', 2, 'uploads/Джилда.APTSKH9mdjGAj2L-kz64otVtI1IvvA-y.jpg'),
(2, 'Johni', 'куче', 'питбул', '2021-05-05', '', 'Васил Петров', 'Пловдив', '', '', 3, 'uploads/Johni.2-received_2233678586673129.jpeg'),
(3, 'Джеси', 'куче', 'чихуахуа и померан', '2023-06-19', 'Бяло-кафяво.', 'Христина Щерева', 'Пловдив', '', '', 5, 'uploads/Джеси-Messenger_creation_55a104ad-baac-4667-9034-b3931cd85a1e.jpg'),
(5, 'Тери', 'куче', 'померан', '2021-09-09', 'кафяв померан', 'Вики Петрова', 'Пловдив', 'vikip@abv.bg', '0888789156', 4, 'uploads/Тери.5-puppy-3.png'),
(6, 'Johni+BDKQb', 'dog', 'pincher', '2021-05-05', 'Information+pMImO', 'Nikolai Nikolov', 'Plovdiv', 'user+sntzU@abv.bg', '0888123456', 9, 'uploads/Johni+BDKQb.r_rZ6sQ5TvJNbSCJG8yPVuWC3oA69y1o.jpeg'),
(9, 'асд', 'асд', '', NULL, '', '', '', '', '', 9, 'uploads/асд.VGMkxLo_09rSrAIcJkE9ftFDDBmvN08o.jpeg'),
(11, 'Jerry', 'dog', '', NULL, '', '', '', '', '', 9, 'uploads/Jerry.11-dog-and-hedgehog.png');

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
  `notes` varchar(2009) DEFAULT NULL,
  PRIMARY KEY (`pet_vaccine_id`),
  KEY `fk_pet_vaccine_vaccine` (`vaccine_id`),
  KEY `fk_pet_vaccine_pet` (`pet_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pet_vaccine`
--

INSERT INTO `pet_vaccine` (`pet_vaccine_id`, `pet_id`, `vaccine_id`, `date_given`, `notes`) VALUES
(2, 5, 1, '2025-01-01', 'qwe'),
(3, 5, 2, '2025-09-09', 'тест'),
(4, 1, 1, '2009-06-17', 'Първа ваксина.'),
(5, 1, 2, '2009-07-10', 'Втора ваксина.'),
(6, 1, 3, '2009-07-25', 'Трета ваксина.');

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
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `password`, `role`) VALUES
(1, 'admin', '$2y$13$1gwxL5yE.GkGQpk3i4dp7OfqLmuMEHFoPXLkwGjvYjBdquYAIg.9.', 'admin'),
(2, 'NikolayLN', '$2y$13$.JJrZDBwlyt.G.S9CY1VW.R99LECPOWxLNkA8lVxGBVfxOAO7tZuC', 'admin'),
(3, 'demo', '$2y$13$Knpo58u3c.YYA9fmLSEfLe8uOsyT/4FDuodiR8Xm9w3sfFRrll1SK', 'user'),
(4, 'Petar', '$2y$13$9yEAolLIvQ90pRsA7tjk5.1quttfUFtnKr7I4QqlQlsDKWp66iwrW', 'user'),
(5, 'Hrisi', '$2y$13$tvqgJa3WXxTxZ56ozn/fkejvVWr.pqj432LMXTrwYufa8E.dDlPPC', 'admin'),
(6, 'Niki', '$2y$13$3PATTM86zDCfHoY/JRLIT.iGBIB0YJsA.Wlu.5FoQBArErEpLKll6', 'admin'),
(9, 'UserCypress', '$2y$13$Z5geXkkrpcEc6FNFyAn/iuLjEogTccnY9iNoKQn7kMBk4TF.ei1bC', 'user');

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `vaccine`
--

INSERT INTO `vaccine` (`vaccine_id`, `name`, `description`) VALUES
(1, 'First vaccine', 'Description about Vaccine 1.'),
(2, 'Second vaccine', 'Description about Vaccine 2.'),
(3, 'Third vaccine', 'Description about Vaccine 3.'),
(4, 'Yearly vaccine for dogs', 'Description about the vaccine for dogs.'),
(5, 'Yearly vaccine for cats', 'Description about the vaccine for cats.');

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
