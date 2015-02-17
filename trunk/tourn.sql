-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 17, 2015 at 10:34 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `tourn`
--

-- --------------------------------------------------------

--
-- Table structure for table `auth`
--

CREATE TABLE IF NOT EXISTS `auth` (
  `user_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL DEFAULT '',
  `password` varchar(32) NOT NULL DEFAULT '',
  `access` varchar(15) CHARACTER SET ascii NOT NULL DEFAULT 'public',
  `email` varchar(40) NOT NULL DEFAULT '',
  `represents_id` bigint(20) DEFAULT NULL,
  `title` varchar(10) NOT NULL,
  `first_name` varchar(30) NOT NULL DEFAULT '',
  `last_name` varchar(30) NOT NULL DEFAULT '',
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `last_updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`),
  KEY `password` (`password`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=97 ;

--
-- Dumping data for table `auth`
--

INSERT INTO `auth` (`user_id`, `username`, `password`, `access`, `email`, `represents_id`, `title`, `first_name`, `last_name`, `active`, `last_updated`) VALUES
(1, 'admin', '5f4dcc3b5aa765d61d8327deb882cf99', 'admin', 'address@site.com', 1, 'Mr', 'Firstname', 'Lastname', 1, '2015-02-17 22:30:12');

-- --------------------------------------------------------

--
-- Table structure for table `auth_represents_connection`
--

CREATE TABLE IF NOT EXISTS `auth_represents_connection` (
  `represents_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `tournament_id` int(10) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `auth_represents_connection`
--


-- --------------------------------------------------------

--
-- Table structure for table `competitors`
--

CREATE TABLE IF NOT EXISTS `competitors` (
  `competitor_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `tournament_id` bigint(20) NOT NULL DEFAULT '0',
  `enrolment` varchar(15) NOT NULL DEFAULT '0',
  `title` varchar(10) NOT NULL,
  `first_name` varchar(30) NOT NULL DEFAULT '',
  `middle_name` varchar(30) NOT NULL DEFAULT '',
  `last_name` varchar(30) NOT NULL DEFAULT '',
  `represents_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `DOB` date NOT NULL DEFAULT '0000-00-00',
  `weight` double NOT NULL DEFAULT '0' COMMENT 'the weight that is acutally used for divisioning, note that this is updated on the day at the weighin',
  `height` double NOT NULL DEFAULT '0',
  `rank_id` int(11) NOT NULL DEFAULT '0',
  `phone` varchar(40) NOT NULL DEFAULT '0',
  `gender` varchar(10) NOT NULL DEFAULT '',
  `comments` varchar(200) DEFAULT NULL,
  `last_updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `red_card` int(11) DEFAULT NULL,
  `paid_amount` double NOT NULL DEFAULT '0',
  `competitor_count` int(11) NOT NULL,
  `team_competitor_id1` bigint(20) NOT NULL,
  `team_competitor_id2` bigint(20) NOT NULL,
  `team_competitor_id3` bigint(20) NOT NULL,
  `team_competitor_id4` bigint(20) NOT NULL,
  `team_competitor_id5` bigint(20) NOT NULL,
  `team_competitor_id6` bigint(20) NOT NULL,
  `overall_place` smallint(6) NOT NULL,
  `overall_description` varchar(30) NOT NULL,
  `received_form` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`competitor_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `competitors`
--


-- --------------------------------------------------------

--
-- Table structure for table `competitors_seq`
--

CREATE TABLE IF NOT EXISTS `competitors_seq` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `competitors_seq`
--


-- --------------------------------------------------------

--
-- Table structure for table `competitor_events`
--

CREATE TABLE IF NOT EXISTS `competitor_events` (
  `competitor_id` bigint(20) NOT NULL,
  `event_id` bigint(20) NOT NULL,
  `division_id` bigint(20) NOT NULL,
  `draw_order` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `competitor_events`
--


-- --------------------------------------------------------

--
-- Table structure for table `divisions`
--

CREATE TABLE IF NOT EXISTS `divisions` (
  `division_id` bigint(20) NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL,
  `event_id` bigint(20) NOT NULL,
  `tournament_id` bigint(20) NOT NULL,
  `rounds` int(11) NOT NULL,
  `round_min` double NOT NULL,
  `break_min` double NOT NULL,
  `minor_final` varchar(10) NOT NULL,
  `type` varchar(15) NOT NULL,
  `section_id` int(11) NOT NULL,
  `technique1` varchar(30) NOT NULL,
  `technique2` varchar(30) NOT NULL,
  `technique3` varchar(30) NOT NULL,
  `technique4` varchar(30) NOT NULL,
  `technique5` varchar(30) NOT NULL,
  `sequence` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`division_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `divisions`
--


-- --------------------------------------------------------

--
-- Table structure for table `divisions_seq`
--

CREATE TABLE IF NOT EXISTS `divisions_seq` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `divisions_seq`
--


-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `event_id` bigint(20) NOT NULL,
  `name` varchar(30) NOT NULL,
  `name_abbrev` varchar(5) NOT NULL,
  `max_competitors` smallint(6) NOT NULL,
  PRIMARY KEY (`event_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `events`
--


-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE IF NOT EXISTS `payment` (
  `payment_id` smallint(6) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payment`
--


-- --------------------------------------------------------

--
-- Table structure for table `rank`
--

CREATE TABLE IF NOT EXISTS `rank` (
  `rank_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(10) NOT NULL DEFAULT '',
  `html_display` varchar(100) NOT NULL,
  UNIQUE KEY `rank_id` (`rank_id`,`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rank`
--

INSERT INTO `rank` (`rank_id`, `name`, `html_display`) VALUES
(1, '10th Gup', '<div style=''background-color:white;color:white''><b>|</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>'),
(2, '9th Gup', '<div style=''background-color:white;color:yellow''><b>|</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>'),
(3, '8th Gup', '<div style=''background-color:yellow;color:yellow''><b>|</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>'),
(4, '7th Gup', '<div style=''background-color:yellow;color:green''><b>|</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>'),
(5, '6th Gup', '<div style=''background-color:green;color:green''><b>|</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>'),
(6, '5th Gup', '<div style=''background-color:green;color:blue''><b>|</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>'),
(7, '4th Gup', '<div style=''background-color:blue;color:blue''><b>|</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>'),
(8, '3rd Gup', '<div style=''background-color:blue;color:red''><b>|</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>'),
(9, '2nd Gup', '<div style=''background-color:red;color:red''><b>|</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>'),
(10, '1st Gup', '<div style=''background-color:red;color:black''><b>|</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>'),
(11, 'Junior Dan', '<div style=''background-color:black;color:white''>-----</div>'),
(12, '1st Dan', '<div style=''background-color:black;color:yellow''>I&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>'),
(13, '2nd Dan', '<div style=''background-color:black;color:yellow''>II&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>'),
(14, '3rd Dan', '<div style=''background-color:black;color:yellow''>III&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>'),
(15, '4th Dan', '<div style=''background-color:black;color:yellow''>IV&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>'),
(16, '5th Dan', '<div style=''background-color:black;color:yellow''>V&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>'),
(17, '6th Dan', '<div style=''background-color:black;color:yellow''>VI&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>'),
(18, '7th Dan', '<div style=''background-color:black;color:yellow''>VII&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>'),
(19, '8th Dan', '<div style=''background-color:black;color:yellow''>VIII&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>'),
(20, '9th Dan', '<div style=''background-color:black;color:yellow''>IX&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>');

-- --------------------------------------------------------

--
-- Table structure for table `represents`
--

CREATE TABLE IF NOT EXISTS `represents` (
  `represents_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '',
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `last_updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`represents_id`),
  UNIQUE KEY `represents` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `represents`
--


-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE IF NOT EXISTS `results` (
  `division_id` bigint(20) NOT NULL,
  `round_id` int(11) NOT NULL,
  `competitor_red_id` bigint(20) NOT NULL,
  `competitor_blue_id` bigint(20) NOT NULL,
  `colour_win` char(1) NOT NULL,
  `last_updated` datetime NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `technique1` int(11) NOT NULL,
  `technique2` int(11) NOT NULL,
  `technique3` int(11) NOT NULL,
  `technique4` int(11) NOT NULL,
  `technique5` int(11) NOT NULL,
  `extra1` int(11) NOT NULL,
  `extra2` int(11) NOT NULL,
  `place` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `results`
--


-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE IF NOT EXISTS `sections` (
  `section_id` int(11) NOT NULL,
  `tournament_id` bigint(20) NOT NULL,
  `name` varchar(30) NOT NULL,
  `date` datetime NOT NULL,
  `part` int(11) NOT NULL,
  PRIMARY KEY (`section_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sections`
--


-- --------------------------------------------------------

--
-- Table structure for table `sections_seq`
--

CREATE TABLE IF NOT EXISTS `sections_seq` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `sections_seq`
--


-- --------------------------------------------------------

--
-- Table structure for table `tournaments`
--

CREATE TABLE IF NOT EXISTS `tournaments` (
  `tournament_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) CHARACTER SET ascii NOT NULL DEFAULT '',
  `location` varchar(30) CHARACTER SET ascii NOT NULL DEFAULT '',
  `date_from` date NOT NULL DEFAULT '0000-00-00',
  `date_to` date NOT NULL DEFAULT '0000-00-00',
  `allow_managers_to_edit` tinyint(1) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `last_updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `draws_public` tinyint(4) NOT NULL,
  `payment_id` smallint(6) NOT NULL,
  `due_date` datetime NOT NULL,
  `schedule_html` longtext NOT NULL,
  `participation_signature_html` longtext NOT NULL,
  `tournament_form_pdf` varchar(50) NOT NULL,
  `logo_name` varchar(30) NOT NULL,
  PRIMARY KEY (`tournament_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tournaments`
--


-- --------------------------------------------------------

--
-- Table structure for table `tournament_events`
--

CREATE TABLE IF NOT EXISTS `tournament_events` (
  `tournament_id` bigint(20) NOT NULL,
  `event_id` bigint(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tournament_events`
--


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
