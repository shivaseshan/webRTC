-- phpMyAdmin SQL Dump
-- version 4.2.5
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: Oct 06, 2014 at 09:49 AM
-- Server version: 5.5.38
-- PHP Version: 5.5.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `rtcdatabase`
--

-- --------------------------------------------------------

--
-- Table structure for table `Events`
--

CREATE TABLE `Events` (
`event_id` int(11) NOT NULL,
  `event_name` varchar(256) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `event_description` varchar(1000) DEFAULT NULL,
  `event_room` varchar(256) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `Events`
--

INSERT INTO `Events` (`event_id`, `event_name`, `start_time`, `end_time`, `user_id`, `event_description`, `event_room`) VALUES
(1, 'Tinku', '2014-10-05 22:00:00', '2014-10-05 23:00:00', 5, 'tinku dance', 'tinku'),
(2, 'Music ', '2014-10-06 07:00:00', '2014-10-06 08:00:00', 5, 'classical music training ', 'classical music'),
(3, 'Tinku', '2014-10-05 22:00:00', '2014-10-05 23:00:00', 4, 'tinku dance', 'tinku'),
(4, 'Music ', '2014-10-06 07:00:00', '2014-10-06 08:00:00', 4, 'classical music training ', 'classical music');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
`user_id` int(11) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `first_name` varchar(20) DEFAULT NULL,
  `last_name` varchar(20) DEFAULT NULL,
  `email_id` varchar(30) DEFAULT NULL,
  `age` int(3) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `first_name`, `last_name`, `email_id`, `age`, `password`) VALUES
(1, 'shivaseshan', 'Shiva', 'Ramaseshan', 'shiva@mail.com', 26, '69f404925df883e0e5579d65b7768e7c'),
(2, 'shiva', 'shiva', 'rama', 'shiva@mail.com', 22, '69f404925df883e0e5579d65b7768e7c'),
(3, 'krishnan', 'Krishnan', 'Narayanan', 'kknaraya@asu.edu', 24, 'fea209e251aade9628951d59f6108caa'),
(4, 'aman123', 'amancdddd', '', '', 12, 'd41d8cd98f00b204e9800998ecf8427e'),
(5, 'aman13', 'aman', 'Sardana', 'aman.sardana@asu.edu', 14, '0363212ba373b3a4d56e85b9146ae2a8');

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
  `end` timestamp NULL DEFAULT NULL,
`video_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `video`
--

INSERT INTO `video` (`name`, `source`, `category`, `duration`, `start`, `end`, `video_id`, `user_id`) VALUES
('kristi', 'kristi.mov', 'general', 30, NULL, NULL, 1, 1),
('Bon jovi', 'bonjovi.mp4', 'music', 60, NULL, NULL, 2, 1),
('Bon jovi', 'bonjovi.mp4', 'music', 60, NULL, NULL, 3, 5),
('Bon jovi', 'bonjovi.mp4', 'music', 60, NULL, NULL, 4, 5),
('Bon jovi', 'bonjovi.mp4', 'music', 60, NULL, NULL, 5, 5),
('Bon jovi', 'bonjovi.mp4', 'music', 60, NULL, NULL, 6, 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Events`
--
ALTER TABLE `Events`
 ADD PRIMARY KEY (`event_id`), ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`user_id`), ADD KEY `user_name` (`user_name`);

--
-- Indexes for table `video`
--
ALTER TABLE `video`
 ADD PRIMARY KEY (`video_id`), ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Events`
--
ALTER TABLE `Events`
MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `video`
--
ALTER TABLE `video`
MODIFY `video_id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;