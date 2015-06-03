-- phpMyAdmin SQL Dump
-- version 3.4.11.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 17, 2013 at 03:51 AM
-- Server version: 5.5.33
-- PHP Version: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `juliann1_roadworks`
--

-- --------------------------------------------------------

--
-- Table structure for table `roadworks`
--

DROP TABLE IF EXISTS `roadworks`;
CREATE TABLE IF NOT EXISTS `roadworks` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(10) NOT NULL,
  `location` varchar(100) NOT NULL,
  `mapref` varchar(14) NOT NULL,
  `start` date NOT NULL,
  `end` date NOT NULL,
  `delay` varchar(30) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2228 ;

--
-- Dumping data for table `roadworks`
--

INSERT INTO `roadworks` (`id`, `name`, `location`, `mapref`, `start`, `end`, `delay`, `description`) VALUES
(1, 'M1', 'Jct 10 to Jct 13', '501717 230290', '2009-08-01', '2013-12-31', 'Moderate (10 - 30 mins)', '24 hr Various hard shoulder closures, hard shoulder running and speed restrictions 24hrs northbound and southbound due to M1 Jct 10 to Jct 13 Managed motorway and resurfacing scheme.'),
(1096, 'M45', 'Dunchurch (310050)', '447823 270967', '2010-01-26', '2013-12-31', 'Slight (less than 10 mins)', 'Hardshoulder closure 24/7 for essential maintenance.'),
(1107, 'M50', 'Junction 1 to Junction 2, both directions', '385737 236185', '2012-02-27', '2013-11-30', 'Slight (less than 10 mins)', '24hour contraflow (with 40mph speed restriction for reconstruction of Bushley and Ripple Viaducts and repairs to Ripple Rd Overbridge (Total Closures to have seperate SRW''s)'),
(1124, 'M54', 'Junction 3, both directions', '391135 304468', '2012-03-05', '2014-03-31', 'Slight (less than 10 mins)', 'Various hardshoulder or lane 1 closures for I54 developement works (works off line for first 3 months - SRW for whereabouts info only)'),
(1444, 'A3', 'Hindhead Tunnel South Bound', '489401 135582', '2011-08-22', '2013-12-11', 'Moderate (10 - 30 mins)', 'Closed Follow Diversion 2200 to 0600 Tunnel Maintenance'),
(1445, 'A3', 'Hindhead Tunnel North Bound', '489024 135427', '2011-10-03', '2013-11-01', 'Moderate (10 - 30 mins)', 'Closed Follow Diversion 2200 to 0600 Tunnel Maintenance'),
(1917, 'A49', 'The Old Cattle Market, Edgar St jct with Blackfriars St, Hereford', '350788 240353', '2012-03-12', '2013-11-17', 'No Delay', '24hr footway closure for erection of hoarding and scaffolding to facilitate demolition and construction of new development'),
(2199, 'A628', 'Salters Brook Bridge', '413701 400163', '2006-10-23', '2014-03-31', 'No Delay', 'TVCB blocks in place on bridge for bridge repair works (859).');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
