-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: Sep 23, 2014 at 03:50 AM
-- Server version: 5.5.34
-- PHP Version: 5.5.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `rtcdatabase`
--

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(20) DEFAULT NULL,
  `first_name` varchar(20) DEFAULT NULL,
  `last_name` varchar(20) DEFAULT NULL,
  `email_id` varchar(30) DEFAULT NULL,
  `age` int(3) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `first_name`, `last_name`, `email_id`, `age`, `password`) VALUES
(1, 'shivaseshan', 'Shiva', 'Ramaseshan', 'shiva@mail.com', 26, '69f404925df883e0e5579d65b7768e7c'),
(2, 'shiva', 'shiva', 'rama', 'shiva@mail.com', 22, '69f404925df883e0e5579d65b7768e7c');

-- --------------------------------------------------------

--
-- Table structure for table `video`
--

CREATE TABLE `video` (
  `name` varchar(256) NOT NULL,
  `source` varchar(256) NOT NULL,
  `category` varchar(256) NOT NULL,
  `duration` int(11) NOT NULL,
  `start` timestamp NULL DEFAULT NULL,
  `end` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `video`
--

INSERT INTO `video` (`name`, `source`, `category`, `duration`, `start`, `end`) VALUES
('kristi', 'kristi.mov', 'general', 30, NULL, NULL),
('Bon jovi', 'bonjovi.mp4', 'music', 60, NULL, NULL);
