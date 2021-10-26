-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 07, 2021 at 03:48 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `php_lessons_4tb22`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(100) NOT NULL,
  `password` varchar(64) NOT NULL,
  `name` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `role` varchar(10) NOT NULL,
  `age` tinyint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`, `name`, `lastname`, `role`, `age`) VALUES
('user2', '$2y$10$GUK8f7AZ6alFIrGOs/hp1OvBgG5HyzRlc3gSrewmtwZOLlOPKPOqK', 'Anatol', 'Kozłowski', 'admin', 20),
('user3', '$2y$10$2xIyWLsMbqqUBk8k8ZecZuR21t5fiFLy.9iWWFhvootDlideJEGV6', ' Korneliusz', 'Wójcik', 'user', 21),
('user1', '$2y$10$DuD.MXAWsvuapBm/X9mbyevYJ6u5NxdOLfPcNqLvUivrPMCWIMzEC', 'Konrad', 'Andrzejewski', 'user', 14),
('user4', '$2y$10$iKgrdqrWTOzM67Y5vTFz0eSm.agdsy1Y/3bXmDvLEjEMoSSzwTbO2', 'Gniewomir', 'Kucharski', 'user', 24),
('user5', '$2y$10$BZ41K4kLsVRPVYMwrj7ep.YbKqXO02uZjS3vhG6m7hldk6/DAcLPG', 'Bogumił', 'Zawadzki', 'admin', 25);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
