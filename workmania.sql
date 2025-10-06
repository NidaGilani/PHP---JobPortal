-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 06, 2021 at 10:37 PM
-- Server version: 5.7.31
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `workmania`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_accounts`
--

DROP TABLE IF EXISTS `admin_accounts`;
CREATE TABLE IF NOT EXISTS `admin_accounts` (
  `id` int(25) NOT NULL AUTO_INCREMENT,
  `f_name` varchar(25) DEFAULT NULL,
  `l_name` varchar(25) DEFAULT NULL,
  `user_name` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `gender` varchar(15) DEFAULT NULL,
  `admin_type` varchar(10) NOT NULL,
  `phone` int(15) DEFAULT NULL,
  `series_id` varchar(60) DEFAULT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `expires` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_name` (`user_name`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_accounts`
--

INSERT INTO `admin_accounts` (`id`, `f_name`, `l_name`, `user_name`, `password`, `gender`, `admin_type`, `phone`, `series_id`, `remember_token`, `expires`) VALUES
(8, NULL, NULL, 'admin', '$2y$10$RnDwpen5c8.gtZLaxHEHDOKWY77t/20A4RRkWBsjlPuu7Wmy0HyBu', NULL, 'admin', 0, 'MyG5Xw2I12EWdJeD', '$2y$10$XL/RhpCz.uQoWE1xV77Wje4I4ker.gtg7YV4yqNwLZfzIYnP7E8Na', '2021-08-22 01:12:33'),
(9, 'Nida', 'Shahbaz', 'nida', '$2y$10$eBa6Zl5D/kOS079EPNPgmu.XDPDJXRwU1jR76CTdfsy/FCjG5/boW', 'Female', 'super', 1234567890, 'EdeX4ufdsz73cLHR', '$2y$10$R8PD1RAzERF46TJoAX/zDe97H1gkJ1PUp/lfNtAYIAzdnz4L8R8q2', '2021-01-23 08:05:21'),
(10, NULL, NULL, 'suqi', '$2y$10$kPBvnbnzTTjzr/rJnzSIgekHdwQgrPVyFSAXtgU6eY1aIVhJgK6BG', NULL, 'super', 0, NULL, NULL, NULL),
(11, NULL, NULL, 'iqra', '$2y$10$Cb85cMVcsJWr0szU2XBIOusRaeoEesB/Wqxc2oc2F1X1ExveBpd4C', NULL, 'admin', 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `applicants`
--

DROP TABLE IF EXISTS `applicants`;
CREATE TABLE IF NOT EXISTS `applicants` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `f_name` varchar(25) DEFAULT NULL,
  `l_name` varchar(25) DEFAULT NULL,
  `reg_no` varchar(255) NOT NULL,
  `field` varchar(50) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `gender` varchar(6) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reg_no` (`reg_no`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `applicants`
--

INSERT INTO `applicants` (`id`, `f_name`, `l_name`, `reg_no`, `field`, `img`, `gender`, `address`, `phone`, `date_of_birth`) VALUES
(2, 'Nida', 'Shah', 'nida20210902_210631', 'Software Developer', 'assets/images/happy-professional-arab-businesswoman-brown-hijab-working-home_68339-402.jpg', 'Female', 'gujrat, punjab, pakistan', '1234567890', '1997-08-25'),
(4, 'haider', 'ali', 'haider20210903_225419', 'Designer', 'assets/images/images.jpg', 'Male', 'gujrat, punjab, pakistan', '1234567890', '1991-10-01'),
(5, 'usman', 'ahmad', 'usman20210903_235441', 'Student', 'assets/images/free-profile-photo-whatsapp-4.png', 'Male', 'gujrat', '123456789032', '2004-03-11'),
(6, 'Iqra', 'Rafi', 'iqra20210906_163920', 'Marketing Expert', 'assets/images/b282b6fc1eb5d8540c4e670bd95945c0.png', 'Female', 'Kunjah, Punjab, Pakistan', '1234567890', '1998-10-10'),
(7, 'Ayesha', 'Shah', 'ayesha20210906_163948', 'Manager', 'assets/images/images (1).jpg', 'Female', 'Kharian, Punjab, Pakistan', '1234567890', '1999-07-15'),
(8, 'Mubrra', 'Noor', 'mubrra20210906_164036', 'Teacher', 'assets/images/professional-girl-black-dress.jpg', 'Female', 'Gujrat, punjab, Pakistan', '1234567890', '1996-01-12'),
(9, 'Saqlain', 'Mirza', 'saqlain20210906_165257', 'Freelancer', 'assets/images/OsMsXdM2F.jpeg', 'Male', 'Gujrat, Punjab, Pakistan', '12345678990', '1997-08-06'),
(10, 'Sheraz', 'Ahmad', 'sheraz20210906_165328', 'Engineer', 'assets/images/agent-one.jpg', 'Male', 'Dolat Nagar, Gujrat, Pakistan', '1234567890', '2002-12-19');

-- --------------------------------------------------------

--
-- Table structure for table `applied_jobs`
--

DROP TABLE IF EXISTS `applied_jobs`;
CREATE TABLE IF NOT EXISTS `applied_jobs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `applicant_id` varchar(50) NOT NULL,
  `post_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `applied_jobs`
--

INSERT INTO `applied_jobs` (`id`, `applicant_id`, `post_id`) VALUES
(1, 'nida20210902_210631', 12);

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

DROP TABLE IF EXISTS `cities`;
CREATE TABLE IF NOT EXISTS `cities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `st_id` varchar(50) NOT NULL,
  `city_name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `st_id`, `city_name`) VALUES
(3, '6', 'Lahore'),
(4, '6', 'Gujrat'),
(5, '3', 'Karachi'),
(6, '3', 'Hydarabad'),
(7, '7', 'Peshawar'),
(8, '7', 'Kohat'),
(9, '5', 'Quetta'),
(10, '5', 'Ziarat');

-- --------------------------------------------------------

--
-- Table structure for table `employers`
--

DROP TABLE IF EXISTS `employers`;
CREATE TABLE IF NOT EXISTS `employers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reg_no` varchar(255) NOT NULL,
  `company_name` varchar(30) DEFAULT NULL,
  `tagline` varchar(255) DEFAULT NULL,
  `company_description` varchar(5000) DEFAULT NULL,
  `cReg_no` varchar(40) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `fb_link` varchar(255) DEFAULT NULL,
  `twitter_link` varchar(255) DEFAULT NULL,
  `linkedin_link` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `employers_ibfk_1` (`reg_no`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employers`
--

INSERT INTO `employers` (`id`, `reg_no`, `company_name`, `tagline`, `company_description`, `cReg_no`, `img`, `address`, `phone`, `website`, `fb_link`, `twitter_link`, `linkedin_link`) VALUES
(2, 'hassan20210902_210655', 'Nexthon enterprises', 'We provide Best IT experts', 'When I\'m doing a query, I want to know the description of that accountCompany, how to accomplish this?\r\n\r\nActually I\'m using two tables with duplicated data, I think that is possible to have only one table to do the same. Hope that can be possible.\r\n\r\nThanks...', 'nexthon_it_123456', 'assets/images/png-clipart-purple-and-yellow-logo-iconfinder-icon-cartoon-flame-logo-design-cartoon-character-purple.png', 'gujrat, pakistan', '11234567890', 'https://github.com/ThingEngineer/PHP-MySQLi-Database-Class#join-method', '', 'https://github.com/ThingEngineer/PHP-MySQLi-Database-Class#join-method', ''),
(4, 'ali20210903_214955', 'NetSol Limited', 'we are the best', 'When I\'m doing a query, I want to know the description of that accountCompany, how to accomplish this?\r\n\r\nActually I\'m using two tables with duplicated data, I think that is possible to have only one table to do the same. Hope that can be possible.\r\n\r\nThanks...', 'netsol123456', 'assets/images/free-logos-png-1-Transparent-Images.png', 'gujrat, punjab, pakistan', '0987654321', 'http://localhost/fyp/work_mania/admin/edit_employer.php?employer_id=ali20210903_214955&operation=edit', '', '', ''),
(5, 'hamza20210906_170540', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 'salman20210906_171633', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

DROP TABLE IF EXISTS `feedback`;
CREATE TABLE IF NOT EXISTS `feedback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(25) NOT NULL,
  `date_time` timestamp NOT NULL,
  `message` varchar(5000) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `reg_no` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `user_name`, `date_time`, `message`, `subject`, `reg_no`, `email`) VALUES
(3, 'Haider ali', '2021-09-04 15:10:38', 'When I\'m doing a query, I want to know the description of that accountCompany, how to accomplish this?\r\n\r\nActually I\'m using two tables with duplicated data, I think that is possible to have only one table to do the same. Hope that can be possible.\r\nActually I\'m using two tables with duplicated data, I think that is possible to have only one table to do the same. Hope that can be possible.\r\n\r\nThanks...', 'When I\'m doing a query, I want to know the description of that accountCompany, how to accomplish this?', 'haider20210903_225419', 'haider@email.com');

-- --------------------------------------------------------

--
-- Table structure for table `fvrt_jobs`
--

DROP TABLE IF EXISTS `fvrt_jobs`;
CREATE TABLE IF NOT EXISTS `fvrt_jobs` (
  `fvrt_job_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(50) NOT NULL,
  `post_id` int(11) NOT NULL,
  PRIMARY KEY (`fvrt_job_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fvrt_jobs`
--

INSERT INTO `fvrt_jobs` (`fvrt_job_id`, `user_id`, `post_id`) VALUES
(9, 'hassan20210902_210655', 12),
(10, 'nida20210902_210631', 12);

-- --------------------------------------------------------

--
-- Table structure for table `job_categories`
--

DROP TABLE IF EXISTS `job_categories`;
CREATE TABLE IF NOT EXISTS `job_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(200) NOT NULL,
  `cat_icon` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `job_categories`
--

INSERT INTO `job_categories` (`id`, `cat_name`, `cat_icon`) VALUES
(1, 'Painting and Design', 'assets/images/paint-palette.svg'),
(2, 'Accounting & Finance', 'assets/images/briefcase.svg'),
(3, 'Restaurant & Food', 'assets/images/restaurant.svg'),
(4, 'Code & Development', 'assets/images/coding.svg'),
(5, 'Data & Science', 'assets/images/decrease.svg'),
(6, 'Writing & Translation', 'assets/images/pencil.svg'),
(7, 'Education & Training', 'assets/images/students-cap.svg'),
(8, 'Sales & Marketing', 'assets/images/megaphone.svg');

-- --------------------------------------------------------

--
-- Table structure for table `job_types`
--

DROP TABLE IF EXISTS `job_types`;
CREATE TABLE IF NOT EXISTS `job_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `job_type` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `job_types`
--

INSERT INTO `job_types` (`id`, `job_type`) VALUES
(2, 'Full-time'),
(3, 'Part-time'),
(4, 'Internship'),
(5, 'Contract-based');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

DROP TABLE IF EXISTS `post`;
CREATE TABLE IF NOT EXISTS `post` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `job_title` varchar(255) NOT NULL,
  `loc` varchar(255) NOT NULL,
  `job_region` varchar(255) NOT NULL,
  `job_type` varchar(255) NOT NULL,
  `job_desc` varchar(255) NOT NULL,
  `f_image` varchar(255) DEFAULT NULL,
  `job_cat` mediumtext NOT NULL,
  `job_resp` mediumtext NOT NULL,
  `job_benefit` longtext NOT NULL,
  `gender` longtext NOT NULL,
  `quali` longtext NOT NULL,
  `exper` longtext NOT NULL,
  `vacancy` longtext NOT NULL,
  `deadline` date DEFAULT NULL,
  `salary` longtext NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `website` varchar(255) DEFAULT NULL,
  `fb_link` varchar(255) DEFAULT NULL,
  `twitter_link` varchar(255) DEFAULT NULL,
  `linkedin_link` varchar(255) DEFAULT NULL,
  `phone` varchar(15) NOT NULL,
  `approval` int(2) DEFAULT '0',
  `publish_date` date DEFAULT NULL,
  `author_id` varchar(50) DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `f_image` (`f_image`),
  KEY `loc` (`loc`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `email`, `job_title`, `loc`, `job_region`, `job_type`, `job_desc`, `f_image`, `job_cat`, `job_resp`, `job_benefit`, `gender`, `quali`, `exper`, `vacancy`, `deadline`, `salary`, `company_name`, `website`, `fb_link`, `twitter_link`, `linkedin_link`, `phone`, `approval`, `publish_date`, `author_id`, `updated_at`) VALUES
(12, 'ali@email.com', 'Graphic Designer Internee', 'Punjab', 'Lahore', 'Internship', 'Internees required. This will provide the freshers an ultimate experience with graphics under the supervision and guidance of our experts. Also this job will provide creative and real time experience to new comers to interact with market.                ', 'assets/images/banner-graphic-design.png', 'Painting and Design', 'Internship for graphic designing students. In order to provide experience and real time interaction with market. Bring creativity within your designs.            ', '1. Required system will be provided by company.                ', 'both', 'BSCS', 'None', '5', '2021-09-30', '15000', 'NetSol Limited', 'http://localhost/fyp/work_mania/admin/edit_employer.php?employer_id=ali20210903_214955&operation=edit', '', '', '', '0987654321', 1, '2021-09-06', 'ali20210903_214955', '2021-09-06 12:37:33');

-- --------------------------------------------------------

--
-- Table structure for table `register_user`
--

DROP TABLE IF EXISTS `register_user`;
CREATE TABLE IF NOT EXISTS `register_user` (
  `reg_no` varchar(255) NOT NULL,
  `user_type` varchar(25) NOT NULL,
  `user_name` varchar(25) NOT NULL,
  `email` varchar(25) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `series_id` varchar(60) DEFAULT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `expires` datetime DEFAULT NULL,
  PRIMARY KEY (`reg_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `register_user`
--

INSERT INTO `register_user` (`reg_no`, `user_type`, `user_name`, `email`, `password`, `created_at`, `updated_at`, `series_id`, `remember_token`, `expires`) VALUES
('ali20210903_214955', 'Employer', 'ali', 'ali@email.com', '$2y$10$Lw7Y3eFMBBslqc4vWSecce43N8lO.jC/1TWZZpI.90AwBQ9SS4SBe', '2021-09-03 16:49:55', '2021-09-06 10:50:46', NULL, NULL, NULL),
('ayesha20210906_163948', 'Applicant', 'ayesha', 'ayesha@gmail.com', '$2y$10$TVn068/5Ol.I8KlgXqik6.S6Bay.rf5kiHEFPrDeQrBe/s7IzBWcK', '2021-09-06 11:39:48', '2021-09-06 11:48:45', NULL, NULL, NULL),
('haider20210903_225419', 'Applicant', 'haider', 'haider1@email.com', '$2y$10$Lw7Y3eFMBBslqc4vWSecce43N8lO.jC/1TWZZpI.90AwBQ9SS4SBe', '2021-09-03 17:54:19', '2021-09-06 11:36:19', NULL, NULL, NULL),
('hamza20210906_170540', 'Employer', 'hamza', 'hamza@gmail.com', '$2y$10$NNUaTIyfh7B4ntpzDfSrv.NOiJv/oat1EJs.ycoe0cY2b.4gCmeLC', '2021-09-06 12:05:40', '2021-09-06 17:05:40', NULL, NULL, NULL),
('hassan20210902_210655', 'Employer', 'hassan', 'hassan@email.com', '$2y$10$Lw7Y3eFMBBslqc4vWSecce43N8lO.jC/1TWZZpI.90AwBQ9SS4SBe', '2021-09-02 16:06:55', '2021-09-06 16:07:03', NULL, NULL, NULL),
('iqra20210906_163920', 'Applicant', 'iqra', 'iqrarafi@gmail.com', '$2y$10$.oPsN.kdb91uDJmNYJ6IkuS1MsReWt3NYZ85fSwcxgUvivQ2Hwoci', '2021-09-06 11:39:20', '2021-09-06 11:50:59', NULL, NULL, NULL),
('mubrra20210906_164036', 'Applicant', 'mubrra', 'mubrranoor3@gmail.com', '$2y$10$28ysk32JK3zayBpp4GMPXe2KTUbRDoInzE42qGrIJMSncSMYe0Dwi', '2021-09-06 11:40:36', '2021-09-06 11:42:22', NULL, NULL, NULL),
('nida20210902_210631', 'Applicant', 'nida', 'nida1@email.com', '$2y$10$Lw7Y3eFMBBslqc4vWSecce43N8lO.jC/1TWZZpI.90AwBQ9SS4SBe', '2021-09-02 16:06:31', '2021-09-06 11:38:08', 'ZG9WBsklWTn6xUZf', '$2y$10$ODFN23mtVlwJT3qI9XfMxexruXsfwCsPffT6lFLBmBHmMEGArc4n.', '2021-10-02 21:10:06'),
('salman20210906_171633', 'Employer', 'salman', 'salmandar23@gmail.com', '$2y$10$O6xhW7YTy3C6UFQLuYBdN.uoX87gTVRFnY0XCoEzTsseFgKla/uRS', '2021-09-06 12:16:33', '2021-09-06 17:16:33', NULL, NULL, NULL),
('saqlain20210906_165257', 'Applicant', 'saqlain', 'saqlainmirza212@gmail.com', '$2y$10$iDQyf5WomFIT2pjFoLByoeOA09PxXqKLMMHrKSm8.lobeyEHrpn9.', '2021-09-06 11:52:57', '2021-09-06 11:55:21', NULL, NULL, NULL),
('sheraz20210906_165328', 'Applicant', 'sheraz', 'sherazahmad@gmail.com', '$2y$10$6VQVNYmih.HOcO6zRKDs/.kmHsUUgxl60SZp8A6ksVKWWvbdwAHaG', '2021-09-06 11:53:28', '2021-09-06 11:58:04', NULL, NULL, NULL),
('usman20210903_235441', 'Applicant', 'usman', 'usmanshah301004@gmail.com', '$2y$10$Lw7Y3eFMBBslqc4vWSecce43N8lO.jC/1TWZZpI.90AwBQ9SS4SBe', '2021-09-03 18:54:41', '2021-09-06 11:23:26', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `spam`
--

DROP TABLE IF EXISTS `spam`;
CREATE TABLE IF NOT EXISTS `spam` (
  `report_id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `author_id` varchar(50) NOT NULL,
  `message` varchar(255) NOT NULL,
  `reported_at` datetime NOT NULL,
  PRIMARY KEY (`report_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `spam`
--

INSERT INTO `spam` (`report_id`, `post_id`, `author_id`, `message`, `reported_at`) VALUES
(3, 12, 'ali20210903_214955', 'this is spam', '2021-09-06 20:26:59');

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

DROP TABLE IF EXISTS `states`;
CREATE TABLE IF NOT EXISTS `states` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `state_name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `state_name`) VALUES
(6, 'Punjab'),
(3, 'Sindh'),
(7, 'KPK'),
(5, 'Balochistan'),
(8, 'Gilgit');

-- --------------------------------------------------------

--
-- Table structure for table `upload_resume`
--

DROP TABLE IF EXISTS `upload_resume`;
CREATE TABLE IF NOT EXISTS `upload_resume` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reg_no` varchar(255) NOT NULL,
  `resume` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `upload_resume`
--

INSERT INTO `upload_resume` (`id`, `reg_no`, `resume`, `date`) VALUES
(1, 'nida20210902_210631', 'assets/uploads/504help1.doc', '2021-09-05 05:24:02');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applicants`
--
ALTER TABLE `applicants`
  ADD CONSTRAINT `applicants_ibfk_1` FOREIGN KEY (`reg_no`) REFERENCES `register_user` (`reg_no`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `employers`
--
ALTER TABLE `employers`
  ADD CONSTRAINT `employers_ibfk_1` FOREIGN KEY (`reg_no`) REFERENCES `register_user` (`reg_no`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
