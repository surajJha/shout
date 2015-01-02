
-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 02, 2015 at 02:06 AM
-- Server version: 5.1.67
-- PHP Version: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `u804684334_event`
--

-- --------------------------------------------------------

--
-- Table structure for table `area`
--

CREATE TABLE IF NOT EXISTS `area` (
  `area_id` int(11) NOT NULL AUTO_INCREMENT,
  `area_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`area_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=24 ;

--
-- Dumping data for table `area`
--

INSERT INTO `area` (`area_id`, `area_name`) VALUES
(1, 'Malad'),
(2, 'Goregaon'),
(3, 'Jogeshwari'),
(4, 'Andheri'),
(5, 'Vile Parle'),
(6, 'Santacruz'),
(7, 'Khar'),
(8, 'Bandra'),
(9, 'Mahim'),
(10, 'Matunga'),
(11, 'Dadar'),
(12, 'Elphinstone'),
(13, 'Lower Parel'),
(14, 'Mahalakshmi'),
(15, 'Mumbai Central'),
(16, 'Grant Road'),
(17, 'Charni Road'),
(18, 'Marine Lines'),
(19, 'Churchgate'),
(20, 'Kandivali'),
(21, 'Oshiwara'),
(22, 'Versova'),
(23, 'Juhu');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`) VALUES
(1, 'Comedy'),
(2, 'Culture'),
(3, 'Food + Drinks'),
(4, 'Music'),
(5, 'Nightlife'),
(6, 'Sports'),
(7, 'Theatre');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `eventName` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `locName` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `area` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `approved` tinyint(1) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`eventName`, `locName`, `area`, `address`, `description`, `date`, `time`, `approved`, `id`) VALUES
('DJ Party', 'Cafe Madagascar', 'Andheri West', 'Near McD, Lokhandwala', 'Awesome Party', '2014-12-17', '00:00:00', 1, 1),
('Dance night', 'Birdy''s Cake Shop', 'Vile Parle', 'Near Juhu Airport, Vile Parle Station', 'Very Awesome Party', '2014-12-25', '00:00:00', 1, 2),
('Karaoke Lunch Party', 'Dominoes', 'Bandra West', 'Off Linking Road', 'Very Cool Party', '2014-12-30', '00:00:00', 0, 3),
('Yadiasn', 'sncsaj', 'kdsn', 'kdmasl', 'msklam', '2014-12-11', '00:00:00', 1, 4),
('Dance nightdf,d', 'Dominoes', 'knk', 'kdcnskj', 'kvndk', '2014-12-03', '23:20:33', 1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `event_detail`
--

CREATE TABLE IF NOT EXISTS `event_detail` (
  `event_detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `venue_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `event_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `event_overview` text COLLATE utf8_unicode_ci NOT NULL,
  `event_hashtags` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `event_date` date NOT NULL,
  `event_start_time` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `event_end_time` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `event_location` text COLLATE utf8_unicode_ci NOT NULL,
  `event_area` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `event_cost` int(11) NOT NULL,
  `viewer_count` int(11) NOT NULL DEFAULT '0',
  `priority_count` int(11) NOT NULL DEFAULT '0',
  `category_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `event_organizer_id` int(11) NOT NULL,
  `approved` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`event_detail_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `event_detail`
--

INSERT INTO `event_detail` (`event_detail_id`, `venue_name`, `event_name`, `event_overview`, `event_hashtags`, `event_date`, `event_start_time`, `event_end_time`, `event_location`, `event_area`, `event_cost`, `viewer_count`, `priority_count`, `category_name`, `event_organizer_id`, `approved`) VALUES
(1, 'Hard Rock Cafe', 'New Night', 'Located in two prime locations of the city Andheri and Worli, Hard Rock Cafe is known for its enticing band performances and lively music environment. They have started karaoke nights every Wednesday night.', 'music karaoke ', '2014-12-25', '20:00', '23:00', 'Sharyans Audeus, Ground Floor, Opposite Yashraj Studios, Andheri Lokhandwala, Andheri West, Mumbai', '4', 0, 0, 0, '4', 1, 1),
(2, 'IBar', 'New Years Party', 'Located in the heart of Bandra, IBar is usually packed with sports fans. They have started their karaoke nights for every Wednesday Night. There is a shot on the house, for every singer. And in anticipation of the night to begin, there are happy hours til', 'newyears party hot', '2014-10-15', '21:00', NULL, '7/8, Gleki, ONGC Colony Building 2, Reclamation, Bandra West, Mumbai', '8', 1500, 0, 0, '5', 2, 1),
(3, 'New Tryst', 'Vodka Crazy', 'Part of the premium tourist spot in South Mumbai, The local offers night not once, but twice a week. Tuesday being Bollywood nights followed by Thursday with English Music. They have Happy hours in anticipation of the karaoke night to begin.', 'party drinks', '2014-12-27', '21:00', NULL, 'Phoenix Mill Compound, High Street Phoenix, Senapati Bapat Marg, Lower Parel, Mumbai', '13', 0, 0, 0, '5', 3, 1),
(4, 'vjkvbre', 'hejf', 'kjenk', 'jvk,kvjn', '2014-12-30', '32849', '', 'dshj', '4', 100, 0, 0, '0', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `event_image`
--

CREATE TABLE IF NOT EXISTS `event_image` (
  `event_image_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_detail_id` int(11) NOT NULL,
  `event_image_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `primary` tinyint(4) NOT NULL,
  PRIMARY KEY (`event_image_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `event_organizer`
--

CREATE TABLE IF NOT EXISTS `event_organizer` (
  `event_organizer_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_organizer_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `event_organizer_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `event_organizer_password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `event_organizer_phone` int(11) NOT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`event_organizer_id`),
  UNIQUE KEY `event_organizer_email` (`event_organizer_email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `event_organizer`
--

INSERT INTO `event_organizer` (`event_organizer_id`, `event_organizer_name`, `event_organizer_email`, `event_organizer_password`, `event_organizer_phone`, `verified`) VALUES
(1, 'Arun', 'arun@gmail.com', '123456', 1234567890, 1),
(2, 'Rishabh', 'rishabh@gmail.com', '123456', 1234567890, 1),
(3, 'Vishal', 'vishal@gmail.com', '123456', 1234567890, 1);

-- --------------------------------------------------------

--
-- Table structure for table `hashtag`
--

CREATE TABLE IF NOT EXISTS `hashtag` (
  `hashtag_id` int(11) NOT NULL AUTO_INCREMENT,
  `hashtag_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `hashtag_count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`hashtag_id`),
  UNIQUE KEY `hashtag_name` (`hashtag_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `hashtag`
--

INSERT INTO `hashtag` (`hashtag_id`, `hashtag_name`, `hashtag_count`) VALUES
(1, 'music', 1),
(2, 'karaoke', 1),
(3, 'newyears', 1),
(4, 'party', 2),
(5, 'hot', 1),
(6, 'drinks', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
