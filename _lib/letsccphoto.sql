-- phpMyAdmin SQL Dump
-- version 3.4.0
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 15, 2013 at 02:49 AM
-- Server version: 5.1.70
-- PHP Version: 5.3.2-1ubuntu4.21

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `letsccphoto`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `sort` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `sort`) VALUES
(1, '계절 & 자연', 1),
(2, '동,식물 & 생태', 2),
(3, '도시 & 삶', 3),
(4, '유적지 & 문화', 4),
(5, '건축 & 공간', 5),
(6, '사람& 사랑', 6),
(7, '여행', 7),
(8, '예술', 8);

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE IF NOT EXISTS `members` (
  `idx` int(10) NOT NULL AUTO_INCREMENT,
  `nickname` varchar(20) DEFAULT NULL,
  `my_img_o` varchar(200) DEFAULT NULL,
  `my_img_r` varchar(200) DEFAULT NULL,
  `passwd` varchar(40) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `facebook_id` varchar(20) DEFAULT NULL,
  `twitter_id` varchar(20) DEFAULT NULL,
  `level` smallint(1) NOT NULL DEFAULT '9',
  `policy_agree` enum('y','n') NOT NULL DEFAULT 'n',
  `auto_key` varchar(40) DEFAULT NULL,
  `logindate` timestamp NULL DEFAULT NULL,
  `joindate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `is_leave` enum('y','n') NOT NULL DEFAULT 'n',
  `leave_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idx`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- Table structure for table `photos`
--

CREATE TABLE IF NOT EXISTS `photos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_idx` int(11) NOT NULL,
  `cate_id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` text,
  `tags` varchar(200) DEFAULT NULL,
  `ccl` varchar(10) NOT NULL,
  `filename_o` varchar(200) DEFAULT NULL,
  `filename_r` varchar(200) DEFAULT NULL,
  `info` text,
  `recommend` int(11) NOT NULL DEFAULT '0',
  `hits` int(11) NOT NULL DEFAULT '0',
  `createdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `flickr_photoid` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=46 ;

-- --------------------------------------------------------

--
-- Table structure for table `recommend`
--

CREATE TABLE IF NOT EXISTS `recommend` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `photo_id` int(11) NOT NULL,
  `member_idx` int(11) NOT NULL,
  `wdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=46 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
