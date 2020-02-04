-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 04, 2020 at 10:40 PM
-- Server version: 5.7.26
-- PHP Version: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `elogbook`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `admin_id` varchar(30) NOT NULL,
  `admin_lname` varchar(30) NOT NULL,
  `admin_fname` varchar(30) NOT NULL,
  `admin_mname` varchar(30) DEFAULT NULL,
  `admin_uname` varchar(30) NOT NULL,
  `admin_desig` varchar(50) NOT NULL,
  `admin_pswd` varchar(30) NOT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_lname`, `admin_fname`, `admin_mname`, `admin_uname`, `admin_desig`, `admin_pswd`) VALUES
('UI/CS/18/001', 'Ayo', 'Wale', 'Ade', 'adewale', 'Coordinator', '456');

-- --------------------------------------------------------

--
-- Table structure for table `approval`
--

DROP TABLE IF EXISTS `approval`;
CREATE TABLE IF NOT EXISTS `approval` (
  `approv_id` int(10) NOT NULL AUTO_INCREMENT,
  `approv_date` date NOT NULL,
  `approv_comment` varchar(160) NOT NULL,
  `approv_status` varchar(2) NOT NULL,
  `rpt_id` int(250) NOT NULL,
  `super_id` varchar(30) NOT NULL,
  PRIMARY KEY (`approv_id`),
  KEY `approval` (`rpt_id`),
  KEY `appr` (`super_id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `approval`
--

INSERT INTO `approval` (`approv_id`, `approv_date`, `approv_comment`, `approv_status`, `rpt_id`, `super_id`) VALUES
(1, '2019-01-14', 'Well-documented. Keep it up.', '5', 1, 'KO/INT/12'),
(2, '2019-01-14', 'Well-documented. Keep it up.', '5', 4, 'KO/INT/12'),
(3, '2019-01-24', 'Well done', '4', 2, 'KO/INT/12'),
(4, '2019-01-24', 'Well done', '4', 3, 'KO/INT/12'),
(5, '2019-01-24', 'Well done', '4', 5, 'KO/INT/12'),
(6, '2019-01-24', 'Well done', '4', 6, 'KO/INT/12'),
(7, '2019-01-24', 'Well done', '4', 7, 'KO/INT/12'),
(8, '2019-01-24', 'Well done', '4', 8, 'KO/INT/12'),
(9, '2019-01-24', 'Well done', '4', 9, 'KO/INT/12'),
(10, '2019-01-24', 'Well done', '4', 10, 'KO/INT/12'),
(11, '2019-01-24', 'Well done', '4', 11, 'KO/INT/12'),
(12, '2019-01-24', 'Well done', '4', 12, 'KO/INT/12'),
(13, '2019-01-24', 'Well done', '4', 13, 'KO/INT/12'),
(14, '2019-01-24', 'Well done', '4', 14, 'KO/INT/12'),
(15, '2019-01-24', 'Well done', '4', 15, 'KO/INT/12'),
(16, '2019-01-24', 'Well done', '4', 16, 'KO/INT/12'),
(17, '2019-01-24', 'Well done', '4', 17, 'KO/INT/12'),
(18, '2019-01-24', 'Well done', '4', 18, 'KO/INT/12'),
(19, '2019-01-24', 'Well done', '4', 19, 'KO/INT/12'),
(20, '2019-01-24', 'Well done', '4', 20, 'KO/INT/12'),
(21, '2019-01-24', 'Well done', '4', 21, 'KO/INT/12'),
(22, '2019-01-24', 'Well done', '4', 22, 'KO/INT/12'),
(23, '2019-01-24', 'Well done', '4', 23, 'KO/INT/12'),
(24, '2019-01-24', 'Well done', '4', 24, 'KO/INT/12'),
(25, '2019-01-24', 'Well done', '4', 25, 'KO/INT/12'),
(26, '2019-01-24', 'Well done', '4', 26, 'KO/INT/12'),
(27, '2019-01-24', 'Well done', '4', 27, 'KO/INT/12'),
(28, '2019-01-24', 'Well done', '4', 28, 'KO/INT/12'),
(29, '2019-01-24', 'Well done', '4', 29, 'KO/INT/12'),
(30, '2019-01-24', 'Well done', '4', 30, 'KO/INT/12'),
(31, '2019-01-24', 'Well done', '4', 31, 'KO/INT/12'),
(32, '2019-01-24', 'Well done', '4', 32, 'KO/INT/12'),
(33, '2019-01-24', 'Well done', '4', 33, 'KO/INT/12'),
(34, '2019-01-24', 'Well done', '4', 34, 'KO/INT/12'),
(35, '2019-01-24', 'Well done', '4', 35, 'KO/INT/12'),
(36, '2019-01-24', 'Well done', '4', 37, 'KO/INT/12'),
(37, '2019-03-02', 'Well-detailed report', '4', 44, 'KO/INT/12'),
(38, '2019-03-02', 'Well-detailed report', '4', 45, 'KO/INT/12');

-- --------------------------------------------------------

--
-- Table structure for table `assessment`
--

DROP TABLE IF EXISTS `assessment`;
CREATE TABLE IF NOT EXISTS `assessment` (
  `SUPERVISORsuper_id` varchar(30) NOT NULL,
  `STUDENTstud_id` varchar(6) NOT NULL,
  `assess_id` int(10) NOT NULL AUTO_INCREMENT,
  `assess_date` date NOT NULL,
  `assess_comment` varchar(160) DEFAULT NULL,
  `assess_grade` varchar(3) NOT NULL,
  PRIMARY KEY (`assess_id`),
  KEY `assesses` (`SUPERVISORsuper_id`),
  KEY `accesses` (`STUDENTstud_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `assessment`
--

INSERT INTO `assessment` (`SUPERVISORsuper_id`, `STUDENTstud_id`, `assess_id`, `assess_date`, `assess_comment`, `assess_grade`) VALUES
('COMUI/1993', '192439', 1, '2019-01-11', 'Seen on duty during visitation.', '4'),
('COMUI/1993', '192223', 2, '2019-01-14', 'Met on duty.\r\nGood recommendation from supervisors.', '4'),
('COMUI/1993', '192439', 3, '2019-01-14', 'Well-documented report. ', '4'),
('COMUI/1993', '192439', 4, '2019-01-24', 'FGood one', '4'),
('COMUI/1993', '192223', 5, '2019-03-02', 'Satisfactory', '5');

-- --------------------------------------------------------

--
-- Table structure for table `attachment`
--

DROP TABLE IF EXISTS `attachment`;
CREATE TABLE IF NOT EXISTS `attachment` (
  `attach_id` int(10) NOT NULL AUTO_INCREMENT,
  `attach_file` varchar(100) NOT NULL,
  `DAILY_REPORTrpt_id` int(250) NOT NULL,
  PRIMARY KEY (`attach_id`),
  KEY `contains` (`DAILY_REPORTrpt_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attachment`
--

INSERT INTO `attachment` (`attach_id`, `attach_file`, `DAILY_REPORTrpt_id`) VALUES
(1, 'Plane Flying.jpg', 2),
(2, '59753.jpg', 3),
(3, '687000.jpg', 4),
(4, '200193131-001[2].jpg', 37),
(5, '875364-001[2].jpg', 45),
(6, 'moderncertificateborderacbkdgxdi.jpg', 46),
(7, 'IMG-20190220-WA0007.jpg', 49);

-- --------------------------------------------------------

--
-- Table structure for table `daily_report`
--

DROP TABLE IF EXISTS `daily_report`;
CREATE TABLE IF NOT EXISTS `daily_report` (
  `rpt_id` int(250) NOT NULL AUTO_INCREMENT,
  `rpt_date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `week` varchar(10) NOT NULL,
  `rpt_content` varchar(200) NOT NULL,
  `stud_id` varchar(6) NOT NULL,
  `ind_appr_status` enum('0','1') NOT NULL DEFAULT '0',
  `inst_appr_status` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`rpt_id`),
  KEY `daily_report` (`stud_id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `daily_report`
--

INSERT INTO `daily_report` (`rpt_id`, `rpt_date`, `time`, `week`, `rpt_content`, `stud_id`, `ind_appr_status`, `inst_appr_status`) VALUES
(1, '2019-01-11', '21:35:19', '1', 'Introduction to the company', '192223', '1', '1'),
(2, '2019-01-11', '21:40:14', '1', 'Introduction to Enzymes', '192439', '1', '1'),
(3, '2019-01-12', '08:43:52', '1', 'International Campagne Committee ', '192439', '1', '1'),
(4, '2019-01-12', '21:17:45', '1', 'Introduction to Operating Systems', '192223', '1', '1'),
(5, '2018-12-21', '21:35:19', '1', 'CMS', '192439', '1', '1'),
(6, '2018-12-22', '20:00:00', '1', 'CMS Contd', '192439', '1', '1'),
(7, '2018-12-23', '20:01:00', '1', 'Intro', '192439', '1', '1'),
(8, '2018-12-24', '20:02:00', '1', 'Duction', '192439', '1', '1'),
(9, '2018-12-25', '20:03:00', '1', 'Taofeek', '192439', '1', '1'),
(10, '2018-12-26', '20:04:00', '1', 'Taofeek', '192439', '1', '1'),
(11, '2018-12-27', '20:05:00', '1', 'Taofeek', '192439', '1', '1'),
(12, '2018-12-28', '20:06:00', '2', 'Taofeek', '192439', '1', '1'),
(13, '2018-12-29', '20:07:00', '2', 'Taofeek', '192439', '1', '1'),
(14, '2018-12-30', '20:08:00', '2', 'Taofeek', '192439', '1', '1'),
(15, '2018-12-31', '20:09:00', '2', 'Taofeek', '192439', '1', '1'),
(16, '2019-01-01', '20:10:00', '2', 'Taofeek', '192439', '1', '1'),
(17, '2019-01-02', '20:11:00', '2', 'Taofeek', '192439', '1', '1'),
(18, '2019-01-03', '20:12:00', '2', 'Taofeek', '192439', '1', '1'),
(19, '2019-01-04', '20:13:00', '3', 'Taofeek', '192439', '1', '1'),
(20, '2019-01-05', '20:14:00', '3', 'Taofeek', '192439', '1', '1'),
(21, '2019-01-06', '20:15:00', '3', 'Taofeek', '192439', '1', '1'),
(22, '2019-01-07', '20:16:00', '3', 'Taofeek', '192439', '1', '1'),
(23, '2019-01-08', '20:17:00', '3', 'Taofeek', '192439', '1', '1'),
(24, '2019-01-09', '20:18:00', '3', 'Taofeek', '192439', '1', '1'),
(25, '2019-01-10', '20:19:00', '3', 'Taofeek', '192439', '1', '1'),
(26, '2019-01-11', '20:20:00', '4', 'Taofeek', '192439', '1', '1'),
(27, '2019-01-12', '20:21:00', '4', 'Taofeek', '192439', '1', '1'),
(28, '2019-01-13', '20:22:00', '4', 'Taofeek', '192439', '1', '1'),
(29, '2019-01-14', '20:23:00', '4', 'Taofeek', '192439', '1', '1'),
(30, '2019-01-15', '20:24:00', '4', 'Taofeek', '192439', '1', '1'),
(31, '2019-01-16', '20:25:00', '4', 'Taofeek', '192439', '1', '1'),
(32, '2019-01-17', '20:26:00', '4', 'Taofeek', '192439', '1', '1'),
(33, '2019-01-18', '20:27:00', '4', 'Taofeek', '192439', '1', '1'),
(34, '2019-01-19', '20:28:00', '4', 'Taofeek', '192439', '1', '1'),
(35, '2019-01-20', '20:29:00', '4', 'Taofeek', '192439', '1', '1'),
(37, '2019-01-22', '23:17:58', '4', 'Defense', '192439', '1', '1'),
(44, '2019-01-24', '17:38:46', '2', 'aiofjewioj', '192223', '1', '1'),
(45, '2019-01-25', '11:02:52', '2', 'askljfijw', '192223', '1', '1'),
(46, '2019-02-25', '17:03:55', '1', '', '192443', '0', '0'),
(47, '2019-02-26', '00:08:27', '1', 'Introduction to CISCO', '192443', '0', '0'),
(48, '2019-02-28', '09:21:17', '1', 'Introducion', '192541', '0', '0'),
(49, '2019-04-02', '13:11:46', '1', 'Installation of New Desktop Computers.\r\nIntroduction to Software Documentation', '123321', '0', '0'),
(50, '2019-04-04', '08:57:53', '5', 'Installation of Wired Connection to the North part of Senate building', '111111', '0', '0'),
(51, '2019-04-23', '05:24:27', '14', '', '192223', '0', '0');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

DROP TABLE IF EXISTS `department`;
CREATE TABLE IF NOT EXISTS `department` (
  `dept_id` int(5) NOT NULL AUTO_INCREMENT,
  `dept_desc` varchar(50) NOT NULL,
  `FACULTYfac_id` int(10) NOT NULL,
  PRIMARY KEY (`dept_id`),
  KEY `has` (`FACULTYfac_id`)
) ENGINE=InnoDB AUTO_INCREMENT=129 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`dept_id`, `dept_desc`, `FACULTYfac_id`) VALUES
(1, 'Africa Regional Centre For Information Science', 1),
(2, 'Agricultural Economics', 2),
(3, 'Agricultural Extension And Rural Development', 2),
(4, 'Agriculture', 2),
(5, 'Agronomy', 2),
(6, 'Animal Science', 2),
(7, 'Crop Protection And Environmental Biology', 2),
(8, 'Arabic And Islamic Studies', 3),
(9, 'Archaeology And Anthropology', 3),
(10, 'Classics', 3),
(11, 'Communication And Language Arts', 3),
(12, 'English', 3),
(13, 'European Studies', 3),
(14, 'History', 3),
(15, 'Linguistics And African Languages', 3),
(16, 'Music', 3),
(17, 'Philosophy', 3),
(18, 'Religious Studies', 3),
(19, 'Theatre Arts', 3),
(20, 'Anatomy', 4),
(21, 'Biochemistry', 4),
(22, 'Chemical Pathology', 4),
(23, 'Biomedical Laboratory Science', 4),
(24, 'Pharmacology And Therapeutics', 4),
(25, 'Physiology', 4),
(26, 'Haematology', 4),
(27, 'Medical Microbiology and Parasitology', 4),
(28, 'Pathology', 4),
(29, 'Virology', 4),
(30, 'Centre For Child And Adolescent Mental Health', 5),
(31, 'Centre For Entrepreneurship And Innovation', 6),
(32, 'Centre For Petroleum, Energy Economics And Law', 7),
(33, 'Centre For Sustainable Development', 8),
(34, 'Anaesthesia', 9),
(35, 'Medicine', 9),
(36, 'Nursing', 9),
(37, 'Obstetrics And Gynaecology', 9),
(38, 'Oto-rhino-laryngology', 9),
(39, 'Paediatrics', 9),
(40, 'Physiotherapy', 9),
(41, 'Preventive Medicine And Primary Care', 9),
(42, 'Radiology', 9),
(43, 'Radiotheraphy', 9),
(44, 'Surgery', 9),
(45, 'Ophthalmology', 9),
(46, 'Psychiatry', 9),
(47, 'Institute Of Child Health', 9),
(48, 'Dentistry', 10),
(49, 'Oral and Maxillofacial Surgery', 10),
(50, 'Oral Pathology', 10),
(51, 'Periodontology and Community Dentistry', 10),
(52, 'Restorative Dentistry', 10),
(53, 'Child Oral Health', 10),
(54, 'Economics', 11),
(55, 'Accounting', 11),
(56, 'Business Administration', 11),
(57, 'Adult Education', 12),
(58, 'Arts And Social Sciences Education', 12),
(59, 'Centre For Educational Media Resource Studies', 12),
(60, 'Early Childhood And Educational Foundations', 12),
(61, 'Educational Management', 12),
(62, 'Guidance And Counselling', 12),
(63, 'Human Kinetics And Health Education', 12),
(64, 'Library Archival And Infomation Studies', 12),
(65, 'Library, Archival And Information Studies', 12),
(66, 'Science And Technology Education', 12),
(67, 'Social Work', 12),
(68, 'Special Education', 12),
(69, 'Urban And Regional Planning', 13),
(70, 'Architecture', 13),
(71, 'Estate Management', 13),
(72, 'Building Technology', 13),
(73, 'Institute For Peace And Strategic Studies', 14),
(74, 'Institute Of African Studies', 15),
(75, 'Institute Of Child Health', 16),
(76, 'Institute Of Education', 17),
(77, 'Law', 18),
(78, 'Centre For Drug Discovery, Development And Product', 19),
(79, 'Clinical Pharmacy And Pharmacy Administration', 19),
(80, 'Pharmaceutical Chemistry', 19),
(81, 'Pharmaceutical Microbiology', 19),
(82, 'Pharmaceutics And Industrial Pharmacy', 19),
(83, 'Pharmacognosy', 19),
(84, 'Pharmacy', 19),
(85, 'Institute Of Child Health', 20),
(86, 'Environmental Health Sciences', 20),
(87, 'Epidemiology And Medical Statistics', 20),
(88, 'Health Policy And Management', 20),
(89, 'Health Promotion And Education', 20),
(90, 'Human Nutrition', 20),
(91, 'Preventive Medicine And Primary Care', 20),
(92, 'Aquaculture And Fisheries Management', 21),
(93, 'Forest Production And Products', 21),
(94, 'Social And Environmental Forestry', 21),
(95, 'Wildlife And Ecotourism Management', 21),
(96, 'Wildlife And Fisheries Management', 21),
(97, 'School Of Business', 22),
(98, 'Archaeology And Anthropology', 23),
(99, 'Botany', 23),
(100, 'Chemistry', 23),
(101, 'Computer Science', 23),
(102, 'Geography', 23),
(103, 'Geology', 23),
(104, 'Mathematics', 23),
(105, 'Microbiology', 23),
(106, 'Physics', 23),
(107, 'Statistics', 23),
(108, 'Zoology', 23),
(109, 'Agricultural And Environmental Engineering', 24),
(110, 'Civil Engineering', 24),
(111, 'Electrical And Electronics Engineering', 24),
(112, 'Food Technology', 24),
(113, 'Industrial And Production Engineering', 24),
(114, 'Mechanical Engineering', 24),
(115, 'Petroleum Engineering', 24),
(116, 'Geography', 25),
(117, 'Political Science', 25),
(118, 'Psychology', 25),
(119, 'Sociology', 25),
(120, 'Theriogenology', 26),
(121, 'Veterinary Anatomy', 26),
(122, 'Veterinary Medicine', 26),
(123, 'Veterinary Microbiology And Parasitology', 26),
(124, 'Veterinary Pathology', 26),
(125, 'Veterinary Physiology And Biochemistry and Pharmac', 26),
(126, 'Veterinary Public Health And Preventive Medicine', 26),
(127, 'Veterinary Surgery And Reproduction', 26),
(128, 'Environmental Design and Management', 28);

-- --------------------------------------------------------

--
-- Table structure for table `end_of_siwes`
--

DROP TABLE IF EXISTS `end_of_siwes`;
CREATE TABLE IF NOT EXISTS `end_of_siwes` (
  `id` int(200) NOT NULL AUTO_INCREMENT,
  `file_name` varchar(50) NOT NULL,
  `stud_id` varchar(6) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `end_of_siwes` (`stud_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

DROP TABLE IF EXISTS `faculty`;
CREATE TABLE IF NOT EXISTS `faculty` (
  `fac_id` int(10) NOT NULL AUTO_INCREMENT,
  `fac_desc` varchar(50) NOT NULL,
  PRIMARY KEY (`fac_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`fac_id`, `fac_desc`) VALUES
(1, 'Africa Regional Centre For Information Science'),
(2, 'Agriculture'),
(3, 'Arts'),
(4, 'Basic Medical Sciences'),
(5, 'Centre For Child And Adolescent Mental Health'),
(6, 'Centre For Entrepreneurship And Innovation'),
(7, 'Centre For Petroleum, Energy Economics And Law'),
(8, 'Centre For Sustainable Development'),
(9, 'Clinical Sciences'),
(10, 'Dentistry'),
(11, 'Economics'),
(12, 'Education'),
(13, 'Environmental Design And Management'),
(14, 'Institute For Peace And Strategic Studies'),
(15, 'Institute Of African Studies'),
(16, 'Institute Of Child Health'),
(17, 'Institute Of Education'),
(18, 'Law'),
(19, 'Pharmacy'),
(20, 'Public Health'),
(21, 'Renewable Natural Resources'),
(22, 'School Of Business'),
(23, 'Science'),
(24, 'Technology'),
(25, 'The Social Sciences'),
(26, 'Veterinary Medicine'),
(27, 'Units '),
(28, 'Environmental Design and Management');

-- --------------------------------------------------------

--
-- Table structure for table `inspection`
--

DROP TABLE IF EXISTS `inspection`;
CREATE TABLE IF NOT EXISTS `inspection` (
  `inspection_id` int(11) NOT NULL AUTO_INCREMENT,
  `inspection_date` date NOT NULL,
  `comments` varchar(200) NOT NULL,
  `remarks` varchar(50) NOT NULL,
  `super_id` varchar(30) NOT NULL,
  `stud_id` varchar(6) NOT NULL,
  PRIMARY KEY (`inspection_id`),
  KEY `inspection` (`super_id`),
  KEY `inspection_stud` (`stud_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `organization`
--

DROP TABLE IF EXISTS `organization`;
CREATE TABLE IF NOT EXISTS `organization` (
  `org_id` int(30) NOT NULL AUTO_INCREMENT,
  `org_name` varchar(60) NOT NULL,
  `org_address` varchar(50) NOT NULL,
  `org_city` varchar(30) NOT NULL,
  `org_state` varchar(30) NOT NULL,
  `org_contact_phone` varchar(11) NOT NULL,
  PRIMARY KEY (`org_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `organization`
--

INSERT INTO `organization` (`org_id`, `org_name`, `org_address`, `org_city`, `org_state`, `org_contact_phone`) VALUES
(1, 'E-Z 37 Solutions', 'Old Oyo Road, ', 'Ibadan', 'Oyo ', '08139160110'),
(2, 'Jumia NG', 'Salvation Army', 'Ibadan', 'Oyo ', '06053535353'),
(3, 'University of Ibadan', 'Old Oyo Road,', 'Ibadan', 'Oyo', '01226885'),
(4, 'International Institute of Tropical Agriculture', 'Old Oyo Road', 'Ibadan', 'Oyo', '09088793778'),
(5, 'UI', 'Ibadan', 'Ibadan', 'Oyo', '09088793778'),
(6, 'Totco Computer Institute', 'Orogun', 'Ibadan', 'Oyo', '08177657726');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
CREATE TABLE IF NOT EXISTS `student` (
  `stud_id` varchar(6) NOT NULL,
  `stud_lname` varchar(30) NOT NULL,
  `stud_fname` varchar(30) NOT NULL,
  `stud_mname` varchar(30) NOT NULL,
  `stud_nok` varchar(50) DEFAULT NULL,
  `stud_level` varchar(3) NOT NULL,
  `session` varchar(15) NOT NULL,
  `stud_it_duration` smallint(5) DEFAULT NULL,
  `stud_pswd` varchar(50) NOT NULL,
  `SUPERVISORsuper_id` varchar(30) NOT NULL,
  `DEPARTMENTdept_id` int(5) NOT NULL,
  `org_id` int(30) NOT NULL,
  `it_date` date NOT NULL,
  PRIMARY KEY (`stud_id`),
  KEY `registers` (`SUPERVISORsuper_id`),
  KEY `belongs` (`DEPARTMENTdept_id`),
  KEY `student` (`org_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`stud_id`, `stud_lname`, `stud_fname`, `stud_mname`, `stud_nok`, `stud_level`, `session`, `stud_it_duration`, `stud_pswd`, `SUPERVISORsuper_id`, `DEPARTMENTdept_id`, `org_id`, `it_date`) VALUES
('111111', 'Samuel', 'Gideon', 'Okpara', 'Mr. Okpara', '300', '2017/2018', 2, 'password', 'MY/SU/2019', 10, 1, '2019-02-25'),
('123321', 'Babatunde', 'Olowu', 'Ayinde', 'Mr. Babatunde', '300', '2017/2018', 3, 'password', 'COMUI/1993', 106, 4, '2019-04-01'),
('186755', 'Wahab', 'Azeez', 'Adigun', 'Oluwole', '300', '2018/2019', 1, 'password', '10/1991/8', 2, 6, '2019-01-23'),
('191900', 'Kolade', 'Dimeji', 'Alani', 'Adeola', '300', '2017/2018', 6, '10101010', 'COMUI/1993', 106, 4, '2019-02-20'),
('191919', 'sam', 'wole', 'okpara', 'mr. okpara', '300', '2017/2018', 3, 'password', 'MY/SU/2019', 2, 4, '2019-01-28'),
('192223', 'Ashaolu', 'Ademola', 'Israel', 'Mr. Ademola', '300', '2018/2019', 1, '111111', 'COMUI/1993', 2, 2, '2019-01-10'),
('192439', 'Olalere', 'Taofeek', 'Abiodun', 'Mr. Olalere', '400', '2018/2019', 1, '000000', 'KO/INT/12', 2, 2, '2018-12-21'),
('192443', 'Olukunle', 'Adesola', 'Ajala', 'Mr. Ajala', '300', '2018/2019', 1, '111', 'COMUI/1993', 70, 2, '2019-02-24'),
('192541', 'Olunlade', 'Abidogun', 'Alabi', 'Mr. Olunlade', '400', '2016/2017', 5, '777', 'COMUI/1993', 9, 3, '2019-02-28'),
('192900', 'Kolade', 'Dimeji', 'Alani', 'ADigun', '300', '2017/2018', 3, '11111111', 'COMUI/1993', 106, 4, '2019-02-02'),
('999999', 'Waheed', 'Lateef', 'Kola', 'Akinlabi', '300', '2017/2018', 3, 'password', 'S/UII/2018', 2, 6, '2019-02-25');

-- --------------------------------------------------------

--
-- Table structure for table `stud_passport`
--

DROP TABLE IF EXISTS `stud_passport`;
CREATE TABLE IF NOT EXISTS `stud_passport` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `stud_id` varchar(6) NOT NULL,
  `passport` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `stud_passport` (`stud_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stud_passport`
--

INSERT INTO `stud_passport` (`id`, `stud_id`, `passport`) VALUES
(1, '192223', 'passInec.jpg'),
(2, '192439', 'passInec.jpg'),
(3, '192541', 'see.jpg'),
(4, '192443', 'download.jpeg'),
(5, '192900', 'passInec.jpg'),
(6, '186755', 'topass.jpg'),
(7, '999999', 'army.jpg'),
(8, '191919', 'download.jpg'),
(9, '123321', '12.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `supervisor`
--

DROP TABLE IF EXISTS `supervisor`;
CREATE TABLE IF NOT EXISTS `supervisor` (
  `super_id` varchar(30) NOT NULL,
  `super_lname` varchar(30) NOT NULL,
  `super_fname` varchar(30) NOT NULL,
  `super_mname` varchar(30) DEFAULT NULL,
  `super_uname` varchar(20) NOT NULL,
  `super_status` enum('0','1') NOT NULL,
  `phone_no` varchar(11) NOT NULL,
  `super_sign` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `super_pswd` varchar(30) NOT NULL,
  `org_id` int(30) NOT NULL,
  `ADMINadmin_id` varchar(30) NOT NULL,
  PRIMARY KEY (`super_id`),
  KEY `register` (`ADMINadmin_id`),
  KEY `supervisor` (`org_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supervisor`
--

INSERT INTO `supervisor` (`super_id`, `super_lname`, `super_fname`, `super_mname`, `super_uname`, `super_status`, `phone_no`, `super_sign`, `email`, `super_pswd`, `org_id`, `ADMINadmin_id`) VALUES
('10/1991/8', 'Audu', 'Omoh', 'Kehinde', 'omohkenny', '1', '08049387111', '33419-sign.jpg', 'omohkenny@gmail.com', 'password', 3, 'UI/CS/18/001'),
('1111', 'Oguntunde', 'Toyin', 'Idowu', 't.oguntunde', '0', '09055854451', '94202-download (2).png', 'tantos557@yahoo.com', '12345', 5, 'UI/CS/18/001'),
('12121', 'slkfja', 'oiajwfei', 'poefjawoi', 'ijoiaf', '1', '09090909090', '48401-moderncertificateborderacbkdgxdi.jpg', 'olajuwon@gmail.com', '11111111', 3, 'UI/CS/18/001'),
('1290/55', 'Oludele', 'Obidele', 'Alani', 'alaniolu', '0', '09188272636', '38353-IMG_20190122_224117.jpg', 'alaniolukunle@gmail.com', 'password', 6, 'UI/CS/18/001'),
('223121', 'Ayeola', 'Olufunke', '', 'ajah', '1', '09088541165', '61712-Freegraduationclipartclipartgraduationandart.jpg', 'mymail@mail.com', 'ajaa', 3, 'UI/CS/18/001'),
('353634', 'Kunle', 'Ologundudu', 'Oluwaseun', '', '0', '08139160110', 'IMG_20190122_223745.jpg', 'u2oomuch@gmail.com', '123', 2, 'UI/CS/18/001'),
('55561/11', 'Omikunle', 'Adelabu', 'Alabi', 'alabidanger', '1', '08127736366', '93485-sign.jpg', 'alabidanger@gmail.com', 'password', 3, 'UI/CS/18/001'),
('996/88/10', 'Agodi', 'Alake', 'Arinola', 'arin3456', '1', '09022029928', '91058-sign.jpg', 'arin@gmail.com', 'password', 3, 'UI/CS/18/001'),
('COMUI/1993', 'Adetule', 'Akinjide', 'Alagbe', 'alagbe22', '1', '08055762214', 'IMG_20190122_224117.jpg', 'alagbe22@gmail.com', '111111', 3, 'UI/CS/18/001'),
('KO/INT/12', 'Bashir', 'Yusuf', 'Lekan', 'lowkey', '0', '08139191882', 'IMG_20190122_224122.jpg', 'jayejaye@gmail.com', '000000', 1, 'UI/CS/18/001'),
('MY/SU/2019', 'Adeleke', 'Ademola', 'Alagbe', 'adealagbe', '1', '07065548554', '90983-img.jpg', 'adealagbe@gmail.com', '12345678', 3, 'UI/CS/18/001'),
('S/UII/2018', 'Kolawole', 'Alakija', 'Ayinla', 'ayinlab', '1', '08033992211', 'IMG_20190122_224117.jpg', 'ayinlab@gmail.com', '12345', 3, 'UI/CS/18/001'),
('SMALL/INT', 'Kunle', 'Ayinde', 'Marshall', 'marShall', '0', '08099776655', 'IMG_20190122_223745.jpg', 'marshall@gmail.com', '123456', 4, 'UI/CS/18/001');

-- --------------------------------------------------------

--
-- Table structure for table `supervisor_type`
--

DROP TABLE IF EXISTS `supervisor_type`;
CREATE TABLE IF NOT EXISTS `supervisor_type` (
  `type_id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) NOT NULL,
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supervisor_type`
--

INSERT INTO `supervisor_type` (`type_id`, `type`) VALUES
(0, 'Industry-based'),
(1, 'Institution-based');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `approval`
--
ALTER TABLE `approval`
  ADD CONSTRAINT `appr` FOREIGN KEY (`super_id`) REFERENCES `supervisor` (`super_id`),
  ADD CONSTRAINT `approval` FOREIGN KEY (`rpt_id`) REFERENCES `daily_report` (`rpt_id`);

--
-- Constraints for table `assessment`
--
ALTER TABLE `assessment`
  ADD CONSTRAINT `accesses` FOREIGN KEY (`STUDENTstud_id`) REFERENCES `student` (`stud_id`),
  ADD CONSTRAINT `assesses` FOREIGN KEY (`SUPERVISORsuper_id`) REFERENCES `supervisor` (`super_id`);

--
-- Constraints for table `attachment`
--
ALTER TABLE `attachment`
  ADD CONSTRAINT `contains` FOREIGN KEY (`DAILY_REPORTrpt_id`) REFERENCES `daily_report` (`rpt_id`);

--
-- Constraints for table `daily_report`
--
ALTER TABLE `daily_report`
  ADD CONSTRAINT `daily_report` FOREIGN KEY (`stud_id`) REFERENCES `student` (`stud_id`);

--
-- Constraints for table `department`
--
ALTER TABLE `department`
  ADD CONSTRAINT `has` FOREIGN KEY (`FACULTYfac_id`) REFERENCES `faculty` (`fac_id`);

--
-- Constraints for table `end_of_siwes`
--
ALTER TABLE `end_of_siwes`
  ADD CONSTRAINT `end_of_siwes` FOREIGN KEY (`stud_id`) REFERENCES `student` (`stud_id`);

--
-- Constraints for table `inspection`
--
ALTER TABLE `inspection`
  ADD CONSTRAINT `inspection` FOREIGN KEY (`super_id`) REFERENCES `supervisor` (`super_id`),
  ADD CONSTRAINT `inspection_stud` FOREIGN KEY (`stud_id`) REFERENCES `student` (`stud_id`);

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `belongs` FOREIGN KEY (`DEPARTMENTdept_id`) REFERENCES `department` (`dept_id`),
  ADD CONSTRAINT `registers` FOREIGN KEY (`SUPERVISORsuper_id`) REFERENCES `supervisor` (`super_id`),
  ADD CONSTRAINT `student` FOREIGN KEY (`org_id`) REFERENCES `organization` (`org_id`);

--
-- Constraints for table `stud_passport`
--
ALTER TABLE `stud_passport`
  ADD CONSTRAINT `stud_passport` FOREIGN KEY (`stud_id`) REFERENCES `student` (`stud_id`);

--
-- Constraints for table `supervisor`
--
ALTER TABLE `supervisor`
  ADD CONSTRAINT `register` FOREIGN KEY (`ADMINadmin_id`) REFERENCES `admin` (`admin_id`),
  ADD CONSTRAINT `supervisor` FOREIGN KEY (`org_id`) REFERENCES `organization` (`org_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
