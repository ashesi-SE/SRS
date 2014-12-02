-- --------------------------------------------------------

--
-- Table structure for table `srs_worker`
--

CREATE TABLE IF NOT EXISTS `srs_worker` (
  `wid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(150) NOT NULL,
  `password` varchar(150) NOT NULL DEFAULT '111111',
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
  `wid` int(11),

  FOREIGN KEY(`wid`) REFERENCES `srs_worker`(`wid`),
  PRIMARY KEY (`rid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `srs_report`
--

INSERT INTO `srs_report` (`rid`, `reporter`, `email`, `location`, `status`, `description`, `votes`) VALUES
(1, 'Te Amo', 'example@example.com', 'LH 219', 'Unresolved', 'Testing this out', 3),
(2, 'Nii Apa', 'abbeyniiapa@yahoo.com', 'Lh 218', 'Unresolved', 'Sleepy and tired.', 2),
(3, 'Random Person', 'randomperson@ashesi.edu.gh', 'LH 218', 'Unresolved', 'This is really long and tiring', 4),
(4, 'Nii Gui', 'niigui@ornaah.edu.gh', 'LH 221', 'Pending', 'Air Conditioner not working properly!', 1);


--
-- Table structure for table `srs_comment`
--

CREATE TABLE IF NOT EXISTS `srs_comment` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `rid` int(11) DEFAULT NULL,
  `name` varchar(150) DEFAULT 'Unknown',
  `comment` varchar(255) NOT NULL,
  PRIMARY KEY (`cid`),
  KEY `rid` (`rid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `srs_comment`
--
ALTER TABLE `srs_comment`
  ADD CONSTRAINT `srs_comment_ibfk_1` FOREIGN KEY (`rid`) REFERENCES `srs_report` (`rid`);


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