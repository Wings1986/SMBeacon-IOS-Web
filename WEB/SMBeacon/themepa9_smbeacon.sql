-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 13, 2015 at 03:29 PM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `themepa9_smbeacon`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrator`
--

CREATE TABLE IF NOT EXISTS `administrator` (
`idx` int(10) unsigned NOT NULL,
  `fullname` varchar(50) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `aboutme` text,
  `avatar` varchar(255) NOT NULL,
  `facebook` varchar(20) DEFAULT NULL,
  `latitude` varchar(30) DEFAULT NULL,
  `longitude` varchar(30) DEFAULT NULL,
  `membersince` datetime DEFAULT NULL,
  `lastlogin` datetime DEFAULT NULL,
  `lastupdated` datetime DEFAULT NULL,
  `status` enum('Y','N') NOT NULL DEFAULT 'Y',
  `is_admin` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `administrator`
--

INSERT INTO `administrator` (`idx`, `fullname`, `username`, `email`, `password`, `aboutme`, `avatar`, `facebook`, `latitude`, `longitude`, `membersince`, `lastlogin`, `lastupdated`, `status`, `is_admin`) VALUES
(1, 'admin', 'admin', 'admin@gmail.com', 'admin', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, 'Y', '1');

-- --------------------------------------------------------

--
-- Table structure for table `beacon`
--

CREATE TABLE IF NOT EXISTS `beacon` (
`id` int(11) NOT NULL,
  `merchant_id` int(11) NOT NULL,
  `uuid` varchar(200) NOT NULL,
  `offer_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `beacon`
--

INSERT INTO `beacon` (`id`, `merchant_id`, `uuid`, `offer_id`, `created`, `updated`) VALUES
(1, 1, '11111', 1, '2015-03-15 08:51:43', '2015-03-15 08:51:43'),
(3, 1, '33333', 2, '2015-03-15 08:52:04', '2015-03-15 08:52:04'),
(4, 2, '22222', 6, '2015-03-16 08:05:41', '2015-03-16 08:05:41'),
(5, 1, '22222', 5, '2015-03-17 04:22:34', '2015-03-17 04:22:34');

-- --------------------------------------------------------

--
-- Table structure for table `merchant`
--

CREATE TABLE IF NOT EXISTS `merchant` (
`id` int(11) NOT NULL,
  `business_name` varchar(50) NOT NULL,
  `address` varchar(200) NOT NULL,
  `address2` varchar(200) NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(20) NOT NULL,
  `zip` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `logo` varchar(50) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `merchant`
--

INSERT INTO `merchant` (`id`, `business_name`, `address`, `address2`, `city`, `state`, `zip`, `email`, `phone`, `logo`, `created`, `updated`) VALUES
(1, 'merchant', 'address', 'address2', 'city', 'state', '1001', 'kevin.hakans@gmail.com', '123456789', 'pic/merchantlogo/55070fcbd2aab.png', '2015-03-15 08:45:10', '2015-03-16 18:15:55'),
(2, 'Pink Orchid', '10200 Grogans Mill Road', '', 'The Woodlands', 'Texas', '77380', 'info@sayv.com', '877-235-0708', 'pic/merchantlogo/55070fc13aa35.png', '2015-03-16 07:50:12', '2015-03-16 18:15:45');

-- --------------------------------------------------------

--
-- Table structure for table `offer`
--

CREATE TABLE IF NOT EXISTS `offer` (
`id` int(11) NOT NULL,
  `merchant_id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `picture` varchar(50) NOT NULL,
  `original_price` double NOT NULL,
  `offer_price` double NOT NULL,
  `time_limit` int(11) NOT NULL DEFAULT '1',
  `expire_date` datetime NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `code` varchar(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `offer`
--

INSERT INTO `offer` (`id`, `merchant_id`, `title`, `description`, `picture`, `original_price`, `offer_price`, `time_limit`, `expire_date`, `created`, `updated`, `code`) VALUES
(1, 1, 'Buy 1 Flower, Get 2 FREE', 'You can get 1 flower with 2 ones', 'pic/offerpicture/55073b288372f.png', 100, 80, 20, '2015-03-21 00:00:00', '2015-03-15 08:48:39', '2015-03-16 21:20:56', 'srln8K'),
(2, 1, 'Buy Clothes', 'You can buy good clothes only here', 'pic/offerpicture/55073b178893d.png', 300, 200, 30, '2015-03-22 00:00:00', '2015-03-15 08:50:16', '2015-03-16 21:20:39', 'yZM4ip'),
(4, 1, 'Buy great shoes', 'Please buy great shoes', 'pic/offerpicture/55073b0426426.png', 500, 300, 70, '2015-03-28 00:00:00', '2015-03-15 08:51:21', '2015-03-16 21:20:20', 'fh8b8c'),
(5, 1, 'Buy 10, Free 2', 'Please get something kindly', 'pic/offerpicture/55073afa6ae34.png', 100, 90, 70, '2015-03-25 00:00:00', '2015-03-15 08:53:21', '2015-03-16 21:20:10', 'xjL8RX'),
(6, 2, 'Buy One Get One Free - Dozen Roses', 'Send two dozen roses to someone you love, because, with roses like these, they''re sure to love you back.', 'pic/offerpicture/55070fe076cdf.png', 79.95, 39.95, 10, '2015-03-31 00:00:00', '2015-03-16 08:05:04', '2015-03-24 16:22:55', '123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrator`
--
ALTER TABLE `administrator`
 ADD PRIMARY KEY (`idx`);

--
-- Indexes for table `beacon`
--
ALTER TABLE `beacon`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `offeruniq` (`offer_id`);

--
-- Indexes for table `merchant`
--
ALTER TABLE `merchant`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offer`
--
ALTER TABLE `offer`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `offercodeuniq` (`code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administrator`
--
ALTER TABLE `administrator`
MODIFY `idx` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `beacon`
--
ALTER TABLE `beacon`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `merchant`
--
ALTER TABLE `merchant`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `offer`
--
ALTER TABLE `offer`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
