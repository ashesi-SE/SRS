-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 11, 2014 at 04:28 PM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `srsdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `srs_admin`
--

CREATE TABLE IF NOT EXISTS `srs_admin` (
  `aid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) DEFAULT NULL,
  `password` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`aid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `srs_admin`
--

INSERT INTO `srs_admin` (`aid`, `username`, `password`) VALUES
(1, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `srs_comment`
--

CREATE TABLE IF NOT EXISTS `srs_comment` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `rid` int(11) NOT NULL,
  `username` varchar(120) NOT NULL,
  `comment` varchar(255) NOT NULL,
  PRIMARY KEY (`cid`),
  KEY `rid` (`rid`),
  KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `srs_comment`
--

INSERT INTO `srs_comment` (`cid`, `rid`, `username`, `comment`) VALUES
(1, 1, 'user', 'This is the first comment.'),
(2, 1, 'user', 'Wow'),
(3, 1, 'user', 'Testing..Tired'),
(4, 1, 'user', 'Hungry'),
(5, 1, 'user', 'Hmm...'),
(6, 1, 'user', 'Checking this out'),
(7, 1, 'user', 'You can add comments like...');

-- --------------------------------------------------------

--
-- Table structure for table `srs_report`
--

CREATE TABLE IF NOT EXISTS `srs_report` (
  `rid` int(11) NOT NULL AUTO_INCREMENT,
  `reporter` varchar(100) NOT NULL DEFAULT 'Anonymouse',
  `email` varchar(100) DEFAULT NULL,
  `location` varchar(150) NOT NULL DEFAULT '-',
  `status` set('Unresolved','Pending','Resolved') DEFAULT 'Unresolved',
  `description` varchar(255) DEFAULT 'No Description Provided',
  `votes` int(11) NOT NULL DEFAULT '1',
  `wid` int(11) NOT NULL DEFAULT '0',
  `tags` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`rid`),
  KEY `wid` (`wid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `srs_report`
--

INSERT INTO `srs_report` (`rid`, `reporter`, `email`, `location`, `status`, `description`, `votes`, `wid`, `tags`) VALUES
(1, 'Te Amo', 'example@example.com', 'LH 219', 'Pending', 'Testing this out', 5, 0, 'testing, this'),
(2, 'Nii Apa', 'abbeyniiapa@yahoo.com', 'Lh 218', 'Resolved', 'Sleepy and tired.', 2, 2, 'sleep, fatigue'),
(3, 'Random Person', 'randomperson@ashesi.edu.gh', 'LH 218', 'Unresolved', 'This is really long and tiring', 4, 1, 'long, tiring'),
(4, 'Nii Gui', 'niigui@ornaah.edu.gh', 'LH 221', 'Pending', 'Air Conditioner not working properly!', 1, 1, 'ac, air conditioner, lab'),
(5, 'Nii Apa', 'abbeyniiapa@yahoo.com', 'LH 218', 'Unresolved', 'Project lagging badly', 1, 0, 'projector, 218'),
(6, 'Nii Apa', 'abbeyniiapa@yahoo.com', 'LH 118', 'Unresolved', 'Blh sdsdsd', 1, 0, 'lecture');

-- --------------------------------------------------------

--
-- Table structure for table `srs_user`
--

CREATE TABLE IF NOT EXISTS `srs_user` (
  `username` varchar(120) NOT NULL DEFAULT 'user',
  `password` varchar(120) NOT NULL DEFAULT 'user',
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `srs_user`
--

INSERT INTO `srs_user` (`username`, `password`) VALUES
('user', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `srs_worker`
--

CREATE TABLE IF NOT EXISTS `srs_worker` (
  `wid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(150) NOT NULL,
  `password` varchar(150) NOT NULL DEFAULT '1111111',
  `name` varchar(200) NOT NULL,
  PRIMARY KEY (`wid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `srs_worker`
--

INSERT INTO `srs_worker` (`wid`, `username`, `password`, `name`) VALUES
(0, 'none', '111111', 'None'),
(1, 'hanif.abdulai', '111111', 'Hanif Abdulai'),
(2, 'kingston.coker', '111111', 'Kingston Coker');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `srs_comment`
--
ALTER TABLE `srs_comment`
  ADD CONSTRAINT `srs_comment_ibfk_1` FOREIGN KEY (`rid`) REFERENCES `srs_report` (`rid`),
  ADD CONSTRAINT `srs_comment_ibfk_2` FOREIGN KEY (`username`) REFERENCES `srs_user` (`username`);

--
-- Constraints for table `srs_report`
--
ALTER TABLE `srs_report`
  ADD CONSTRAINT `srs_report_ibfk_1` FOREIGN KEY (`wid`) REFERENCES `srs_worker` (`wid`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
