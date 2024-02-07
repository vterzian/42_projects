
-- phpMyAdmin SQL Dump
-- version 4.8.0-dev
-- https://www.phpmyadmin.net/
--
-- Host: 192.168.30.23
-- Generation Time: Jan 25, 2018 at 08:23 PM
-- Server version: 8.0.3-rc-log
-- PHP Version: 7.0.27-0+deb9u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `matcha`
--

-- --------------------------------------------------------

--
-- Table structure for table `block`
--

CREATE TABLE `block` (
  `blocker_id` int(11) NOT NULL,
  `blocked_id` int(11) NOT NULL,
  `block_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE `chat` (
  `from` int(11) NOT NULL,
  `to` int(11) NOT NULL,
  `content` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `date` datetime NOT NULL,
  `read` int(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `connected`
--

CREATE TABLE `connected` (
  `user_id` int(11) NOT NULL,
  `connect_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fake`
--

CREATE TABLE `fake` (
  `faker_id` int(11) NOT NULL,
  `faked_id` int(11) NOT NULL,
  `fake_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `like_id` int(11) NOT NULL,
  `liked_id` int(11) NOT NULL,
  `like_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `notif`
--

CREATE TABLE `notif` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `img` varchar(125) COLLATE latin1_general_ci NOT NULL,
  `date` datetime NOT NULL,
  `read` int(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

CREATE TABLE `tag` (
  `id` int(11) NOT NULL,
  `name` varchar(125) COLLATE latin1_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `tag`
--

INSERT INTO `tag` (`id`, `name`) VALUES
(1, 'video game'),
(2, 'photography'),
(3, 'travel'),
(4, 'food'),
(5, 'cinema'),
(6, 'computer'),
(7, 'money'),
(8, 'roleplay'),
(9, 'actifact'),
(10, 'art'),
(11, 'music'),
(12, 'books'),
(13, 'magic'),
(14, 'modelism'),
(15, 'box'),
(16, 'football'),
(17, 'piano'),
(18, 'moba'),
(19, 'sport'),
(20, 'decoration'),
(21, 'php'),
(22, 'communism'),
(23, 'shopping'),
(24, 'cooking'),
(25, 'handball'),
(26, 'youtube'),
(27, 'html'),
(28, 'mozart'),
(29, 'singing'),
(30, 'canada'),
(31, 'beauty'),
(32, 'yoga'),
(33, 'right'),
(34, 'capitalism'),
(35, 'orelsan'),
(36, 'violon'),
(37, 'javascript'),
(38, 'twitch'),
(39, 'basketball'),
(40, 'painting'),
(41, 'republic'),
(42, 'programing'),
(43, 'opera'),
(44, 'left'),
(45, 'mysql'),
(46, 'me'),
(47, 'iam'),
(48, 'fitness'),
(49, 'france'),
(50, 'usul');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `first_name` varchar(125) COLLATE latin1_general_ci NOT NULL,
  `last_name` varchar(125) COLLATE latin1_general_ci NOT NULL,
  `username` varchar(125) COLLATE latin1_general_ci NOT NULL,
  `email` varchar(125) COLLATE latin1_general_ci NOT NULL,
  `password` varchar(125) COLLATE latin1_general_ci NOT NULL,
  `birthdate` datetime DEFAULT NULL,
  `gender` int(11) DEFAULT NULL,
  `orientation` int(11) DEFAULT NULL,
  `bio` text COLLATE latin1_general_ci,
  `country` varchar(125) COLLATE latin1_general_ci DEFAULT NULL,
  `state` varchar(125) COLLATE latin1_general_ci DEFAULT NULL,
  `city` varchar(125) COLLATE latin1_general_ci DEFAULT NULL,
  `zip` varchar(125) COLLATE latin1_general_ci DEFAULT NULL,
  `file_1` varchar(125) COLLATE latin1_general_ci DEFAULT NULL,
  `file_2` varchar(125) COLLATE latin1_general_ci DEFAULT NULL,
  `file_3` varchar(125) COLLATE latin1_general_ci DEFAULT NULL,
  `file_4` varchar(125) COLLATE latin1_general_ci DEFAULT NULL,
  `file_5` varchar(125) COLLATE latin1_general_ci DEFAULT NULL,
  `score` int(11) DEFAULT '0',
  `token` varchar(125) COLLATE latin1_general_ci NOT NULL,
  `token_date` datetime NOT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `register` tinyint(1) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_tag`
--

CREATE TABLE `user_tag` (
  `user_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `views`
--

CREATE TABLE `views` (
  `viewer_id` int(11) NOT NULL,
  `viewed_id` int(11) NOT NULL,
  `view_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `notif`
--
ALTER TABLE `notif`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `notif`
--
ALTER TABLE `notif`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tag`
--
ALTER TABLE `tag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;