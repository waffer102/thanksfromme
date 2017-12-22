-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 22, 2017 at 06:58 AM
-- Server version: 5.6.23-cll-lve
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `thanksfr_demo_portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `appreciation`
--

CREATE TABLE `appreciation` (
  `id` int(100) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `receiver_history_id` int(100) NOT NULL,
  `giver_id` int(11) NOT NULL,
  `giver_history_id` int(100) NOT NULL,
  `date_given` datetime NOT NULL,
  `date_approved` datetime DEFAULT NULL,
  `approved_by_id` int(11) DEFAULT NULL,
  `last_edited_by_id` int(11) DEFAULT NULL,
  `last_edited_by_date` datetime DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `point_value` int(11) NOT NULL,
  `paid_out` tinyint(1) NOT NULL,
  `is_public` tinyint(1) NOT NULL,
  `redeem_date` datetime DEFAULT NULL,
  `status_id` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `appreciation`
--

INSERT INTO `appreciation` (`id`, `receiver_id`, `receiver_history_id`, `giver_id`, `giver_history_id`, `date_given`, `date_approved`, `approved_by_id`, `last_edited_by_id`, `last_edited_by_date`, `category_id`, `description`, `point_value`, `paid_out`, `is_public`, `redeem_date`, `status_id`) VALUES
(1, 10, 10, 2, 9, '2017-03-19 22:28:38', '2017-03-20 09:35:23', 2, NULL, NULL, 3, 'Thanks for delivering. It was AWESOME!', 5, 0, 1, NULL, 4),
(2, 12, 12, 2, 9, '2017-03-20 09:50:48', '2017-03-20 09:57:51', 2, NULL, NULL, 10, 'Thanks for testing out the website and giving your feedback...even though these points are not real.', 5, 0, 1, NULL, 4),
(3, 8, 7, 2, 9, '2017-03-20 09:50:48', '2017-03-20 09:57:54', 2, NULL, NULL, 10, 'Thanks for testing out the website and giving your feedback...even though these points are not real.', 5, 0, 1, NULL, 4),
(4, 11, 11, 2, 9, '2017-03-20 09:50:48', '2017-03-20 09:57:56', 2, NULL, NULL, 10, 'Thanks for testing out the website and giving your feedback...even though these points are not real.', 5, 0, 1, NULL, 4),
(5, 15, 15, 2, 9, '2017-03-20 09:50:48', '2017-03-20 09:57:58', 2, NULL, NULL, 10, 'Thanks for testing out the website and giving your feedback...even though these points are not real.', 5, 1, 1, '2017-03-20 12:49:13', 4),
(6, 14, 14, 2, 9, '2017-03-20 09:50:48', '2017-03-20 09:58:01', 2, NULL, NULL, 10, 'Thanks for testing out the website and giving your feedback...even though these points are not real.', 5, 0, 1, NULL, 4),
(7, 16, 16, 2, 9, '2017-03-20 09:50:48', '2017-03-20 09:58:02', 2, NULL, NULL, 10, 'Thanks for testing out the website and giving your feedback...even though these points are not real.', 5, 1, 1, '2017-03-20 10:17:23', 4),
(8, 5, 4, 2, 9, '2017-03-20 09:50:48', '2017-03-20 09:58:05', 2, NULL, NULL, 10, 'Thanks for testing out the website and giving your feedback...even though these points are not real.', 5, 1, 1, '2017-03-20 13:52:49', 4),
(9, 10, 10, 2, 9, '2017-03-20 09:50:48', '2017-03-20 09:58:07', 2, NULL, NULL, 10, 'Thanks for testing out the website and giving your feedback...even though these points are not real.', 5, 0, 1, NULL, 4),
(10, 7, 6, 2, 9, '2017-03-20 09:50:48', '2017-03-20 09:58:09', 2, NULL, NULL, 10, 'Thanks for testing out the website and giving your feedback...even though these points are not real.', 5, 0, 1, NULL, 4),
(11, 4, 3, 2, 9, '2017-03-20 09:50:48', '2017-03-20 09:58:11', 2, NULL, NULL, 10, 'Thanks for testing out the website and giving your feedback...even though these points are not real.', 5, 1, 1, '2017-03-20 13:52:52', 4),
(12, 3, 2, 2, 9, '2017-03-20 09:50:48', '2017-03-20 09:58:12', 2, NULL, NULL, 10, 'Thanks for testing out the website and giving your feedback...even though these points are not real.', 5, 0, 1, NULL, 4),
(13, 13, 13, 2, 9, '2017-03-20 09:50:48', '2017-03-20 09:58:14', 2, NULL, NULL, 10, 'Thanks for testing out the website and giving your feedback...even though these points are not real.', 5, 0, 1, NULL, 4),
(14, 6, 5, 2, 9, '2017-03-20 09:50:48', '2017-03-20 09:58:16', 2, NULL, NULL, 10, 'Thanks for testing out the website and giving your feedback...even though these points are not real.', 5, 0, 1, NULL, 4),
(15, 9, 8, 2, 9, '2017-03-20 09:50:48', '2017-03-20 09:58:18', 2, NULL, NULL, 10, 'Thanks for testing out the website and giving your feedback...even though these points are not real.', 5, 0, 1, NULL, 4),
(16, 2, 9, 12, 12, '2017-03-20 09:55:18', '2017-03-20 09:58:24', 2, NULL, NULL, 1, 'Great job!', 5, 1, 1, '2017-03-24 09:36:51', 4),
(17, 2, 9, 16, 16, '2017-03-20 10:15:45', '2017-03-20 10:40:57', 2, NULL, NULL, 8, 'You know why.', 5, 1, 1, '2017-03-20 12:19:38', 4),
(18, 2, 9, 13, 13, '2017-03-20 10:20:04', '2017-03-20 10:23:20', 2, NULL, NULL, 6, 'I\\\'d like my 5 points please!', 0, 1, 0, NULL, 5),
(19, 13, 13, 16, 16, '2017-03-20 10:22:19', '2017-03-20 11:47:37', 2, NULL, NULL, 2, 'Because you\\\'re the most rad.', 0, 1, 0, NULL, 4),
(20, 2, 9, 13, 13, '2017-03-20 10:26:49', '2017-03-20 10:40:55', 2, NULL, NULL, 3, 'You denied my point request ', 5, 1, 0, '2017-03-24 09:36:49', 4),
(21, 4, 3, 5, 4, '2017-03-20 10:55:05', '2017-03-20 11:46:44', 2, NULL, NULL, 2, 'I believe in you!', 5, 1, 0, '2017-03-20 13:52:55', 4),
(22, 3, 2, 5, 4, '2017-03-20 10:55:56', '2017-03-20 11:46:38', 2, NULL, NULL, 3, 'You delivered a cookie can! Go you!', 5, 0, 1, NULL, 4),
(23, 2, 9, 5, 4, '2017-03-20 10:57:21', '2017-03-20 11:46:45', 2, NULL, NULL, 3, 'For delivering a website! Woohoo!', 5, 0, 1, NULL, 4),
(24, 5, 4, 5, 4, '2017-03-20 10:57:53', '2017-03-20 11:47:28', 2, NULL, NULL, 19, 'Jason Pilege 04/21/1990', 500, 0, 0, NULL, 5),
(25, 5, 4, 5, 4, '2017-03-20 10:58:34', '2017-03-20 11:47:33', 2, NULL, NULL, 20, '04/12/2014', 75, 1, 0, '2017-03-20 13:52:42', 4),
(26, 5, 4, 5, 4, '2017-03-20 10:59:03', '2017-03-20 11:47:35', 2, NULL, NULL, 17, 'KuhlGuyJon', 5, 1, 0, '2017-03-20 13:52:53', 4),
(27, 2, 9, 3, 2, '2017-03-20 12:20:15', '2017-03-20 13:33:15', 2, NULL, NULL, 15, 'Thanks to Chad for trusting me to take his picture.', 5, 1, 1, '2017-03-24 09:36:44', 4),
(28, 7, 6, 3, 2, '2017-03-20 12:20:57', '2017-03-20 13:33:20', 2, NULL, NULL, 3, 'Thanks for covering NY by yourself!', 5, 0, 1, NULL, 4),
(29, 1, 0, 3, 2, '2017-03-20 12:25:08', '2017-03-20 13:34:02', 2, NULL, NULL, 4, 'The Admin User deserves some private recognition for their ambitious work :D', 5, 0, 0, NULL, 5),
(30, 15, 15, 15, 15, '2017-03-20 12:41:59', '2017-03-20 13:34:10', 2, NULL, NULL, 20, '03/20/2017', 75, 1, 0, '2017-03-20 15:07:24', 4),
(31, 15, 15, 15, 15, '2017-03-20 12:43:10', '2017-03-20 13:32:56', 2, NULL, NULL, 17, 'It doesn\\\'t give instructions of what to put in this box. Assuming the name of the candidate you referred, but it might confuse people.', 5, 0, 0, NULL, 5),
(32, 2, 9, 15, 15, '2017-03-20 12:44:13', '2017-03-20 13:34:13', 2, NULL, NULL, 1, 'Thanks for always answering my questions!', 5, 0, 1, NULL, 4),
(33, 14, 14, 15, 15, '2017-03-20 12:48:39', '2017-03-20 13:34:22', 2, NULL, NULL, 15, 'For telling me that you used my coffee creamer!', 5, 0, 1, NULL, 4),
(34, 5, 4, 4, 3, '2017-03-20 13:15:43', '2017-03-20 13:34:19', 2, NULL, NULL, 14, 'Great Teamwork!!!', 0, 1, 0, NULL, 4),
(35, 3, 2, 4, 3, '2017-03-20 13:15:43', '2017-03-20 13:34:25', 2, NULL, NULL, 14, 'Great Teamwork!!!', 0, 1, 0, NULL, 4),
(36, 6, 5, 4, 3, '2017-03-20 13:15:43', '2017-03-20 13:34:27', 2, NULL, NULL, 14, 'Great Teamwork!!!', 0, 1, 0, NULL, 4),
(37, 12, 12, 14, 14, '2017-03-20 15:19:02', '2017-03-20 21:42:50', 2, NULL, NULL, 14, 'Thanks for always being a team player!', 5, 0, 1, NULL, 4),
(38, 2, 9, 14, 14, '2017-03-20 15:19:23', '2017-03-20 21:42:53', 2, NULL, NULL, 14, 'Thanks for being such a good co-worker. You are amazing!', 0, 1, 1, NULL, 4),
(39, 2, 28, 17, 35, '2017-03-23 10:24:59', '2017-03-24 09:34:56', 2, NULL, NULL, 5, 'Wow, this is really great!', 5, 0, 1, NULL, 4),
(40, 2, 28, 10, 25, '2017-03-23 16:47:35', '2017-03-24 09:35:07', 2, NULL, NULL, 3, 'Thanks for creating this website and working so hard on it!', 5, 0, 1, NULL, 5),
(41, 10, 25, 10, 25, '2017-03-23 16:48:15', '2017-03-24 09:34:44', 2, NULL, NULL, 20, 'Neveruary 1, 2011.', 75, 0, 0, NULL, 4),
(42, 10, 25, 10, 25, '2017-03-23 16:49:39', '2017-03-24 09:34:48', 2, NULL, NULL, 17, 'Chad Hauf.', 5, 0, 0, NULL, 4),
(43, 12, 31, 10, 25, '2017-03-23 16:50:53', '2017-03-24 09:34:53', 2, NULL, NULL, 4, 'Because you like applikittens.', 5, 0, 1, NULL, 4),
(44, 10, 25, 2, 28, '2017-03-27 10:20:24', '2017-03-27 11:22:42', 2, NULL, NULL, 10, 'I appreciate that you liked the new letterhead!', 5, 0, 0, NULL, 4),
(45, 12, 31, 2, 28, '2017-04-06 19:20:18', '2017-04-06 19:20:40', 2, NULL, NULL, 1, 'Did you give Rick my number?', 5, 0, 0, NULL, 4),
(46, 14, 34, 2, 41, '2017-09-04 01:17:54', NULL, NULL, NULL, NULL, 14, 'kuh', 5, 0, 0, NULL, 3),
(47, 8, 27, 2, 41, '2017-10-07 20:44:04', NULL, NULL, NULL, NULL, 10, 'hey', 5, 0, 1, NULL, 3),
(48, 6, 37, 2, 41, '2017-10-07 20:44:04', NULL, NULL, NULL, NULL, 10, 'hey', 5, 0, 1, NULL, 3);

-- --------------------------------------------------------

--
-- Table structure for table `appreciation_decline_reasons`
--

CREATE TABLE `appreciation_decline_reasons` (
  `appreciation_id` int(11) NOT NULL,
  `decline_description` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `appreciation_decline_reasons`
--

INSERT INTO `appreciation_decline_reasons` (`appreciation_id`, `decline_description`) VALUES
(18, 'No points for you.'),
(24, 'I don\'t know if you are eligible to get an amazon card for your own birth?'),
(31, 'Instructions have been added! Therefore, denied.'),
(29, 'Admin Users need nothing. Nothing at all.'),
(40, 'I didn\'t work THAT hard.');

-- --------------------------------------------------------

--
-- Table structure for table `business_unit`
--

CREATE TABLE `business_unit` (
  `id` int(11) NOT NULL,
  `business_unit_code` varchar(6) NOT NULL,
  `business_unit_name` varchar(100) NOT NULL,
  `picture_id` varchar(20) NOT NULL,
  `status_id` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `business_unit`
--

INSERT INTO `business_unit` (`id`, `business_unit_code`, `business_unit_name`, `picture_id`, `status_id`) VALUES
(1, 'NFS', 'Super Demo Company', 'NFS.jpg', 1),
(2, 'CLS', 'Investments, LLC', 'CLS.png', 1),
(3, 'OAS', 'Orion, LLC', 'default.jpg', 1),
(4, 'GFS', 'Good, LLC', 'default.jpg', 1),
(5, 'GHF', 'Services, LLC', 'default.jpg', 1),
(6, 'GAF', 'Funds, LLC', 'default.jpg', 1),
(7, 'BLU', 'Giant, LLC', 'default.jpg', 1),
(8, 'NLD', 'Distributors, LLC', 'default.jpg', 1),
(9, 'NLC', 'Northern Services, LLC', 'default.jpg', 1),
(10, 'CTC', 'Star Company', 'default.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `category_description` varchar(2000) NOT NULL,
  `category_value` int(11) NOT NULL,
  `is_reward` tinyint(1) NOT NULL,
  `for_self` tinyint(1) NOT NULL,
  `is_editable` tinyint(1) NOT NULL,
  `status_id` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `category_name`, `category_description`, `category_value`, `is_reward`, `for_self`, `is_editable`, `status_id`) VALUES
(1, 'Accessible', 'Our people are generous with their time, knowledge and expertise. They are always willing to help others succeed by providing prompt, reliable service to internal and external clients.', 5, 0, 0, 0, 1),
(2, 'Believe', 'Believe that working hard and staying focused on a singular goal over time, will get you to greatness. We are not afraid to fail, as failure is on the road to success. We believe that sometimes you win, sometimes you learn.', 5, 0, 0, 0, 1),
(3, 'Deliver', 'Exceed expectations in everything they do. This person sets a high bar for themselves, and then put 100% into everything they put their name next to. Their efforts consistently produce significant results.', 5, 0, 0, 0, 1),
(4, 'Engaged', 'This person has proven to set a goal and reaches that goal through set milestones and commitment. They are steadily making their way to achieving success and personal satisfaction.', 5, 0, 0, 0, 1),
(5, 'Innovate', 'This person embraces industry and emerging trends throughout every aspect of our business. This person challenges him or herself to create game-changing solutions.', 5, 0, 0, 0, 1),
(6, 'Invest', 'This person invests in the systems we use and people we serve. This person\\\'s commitment keeps us on the cutting edge and creates exponential returns for all.', 5, 0, 0, 0, 1),
(7, 'Lead', 'This person embraces industry and emerging trends throughout every aspect of our business. This person challenges him or herself to create game-changing solutions.', 5, 0, 0, 0, 1),
(8, 'Opportunity', 'This person actively looks for ways to expand business relationships. They look for unique and innovative investment solutions and put forth extra time and effort to improve our services.', 5, 0, 0, 0, 1),
(9, 'Own', 'Start to finish, A to Z, this person owns the process, creating breakthroughs and producing results. Our definition of accountability includes ownership of the issue and the solution. This person is accountable to our clients, our company and team.', 5, 0, 0, 0, 1),
(10, 'Partner', 'Refers to both internal & external customer. They are committed to increasing customer happiness, set achievable customer expectations, assume responsibility for solving customer problems, ensure commitments to customers are met and exceeded, solicit opinions and ideas from customers.', 5, 0, 0, 0, 1),
(11, 'Performance', 'This person holds others accountable for the results of our work efforts, whether good or bad.', 5, 0, 0, 0, 1),
(12, 'Relationship', 'This person creates a workplace environment that connects two or more concepts, objects, or people. They are committed to relationships with both internal and external customers and work together to satisfy needs of our partners as well as meet their individual professional goals.', 5, 0, 0, 0, 1),
(13, 'Simplify', 'This individual strives to make our internal business practices streamlined and efficient. They make communication with advisors and clients concise, clear and to-the-point.', 5, 0, 0, 0, 1),
(14, 'Teamwork', 'This individual consistently strives to improve workflow and efficiencies as part of a cohesive team. They coordinate with others to obtain a clear understanding of all areas of our business to better serve internal and external clients.', 5, 0, 0, 0, 1),
(15, 'Trust', 'A relationship is founded on trust. This person communicates with honesty and complete transparency, which supports our foundation of delivering quality and timely results. It is important to continuously build upon our relationship of trust.', 5, 0, 0, 0, 1),
(16, 'CLS Only', 'CLS Only', 5, 0, 0, 0, 1),
(17, 'Candidate Referral', 'Employees who refer a qualified candidate will be rewarded. Enter the name of the candidate and the job they are applying to in the space provided.', 5, 1, 1, 0, 1),
(18, 'Employee Referral', 'Enter the details of the referral.', 500, 1, 0, 0, 1),
(19, 'Birth', 'Employees will be rewarded upon the birth of a baby or adoption of a child (One per pregnancy per family). Enter the name of the child and date of birth in space provided.', 500, 1, 1, 0, 1),
(20, 'Marriage', 'Employees will be rewarded upon a marriage (One per family). Enter the date of marriage in the space provided.', 75, 1, 1, 0, 1),
(21, '$25 Value Card', 'Awarded by our Managers to employees for immediate, on-the-spot recognition for living the values and going above and beyond. Enter the reason for the card in the space provided.', 25, 1, 0, 0, 1),
(22, '$50 Value Card', 'Awarded by our Managers to employees for immediate, on-the-spot recognition for living the values and going above and beyond. Enter the reason for the card in the space provided.', 50, 1, 0, 0, 1),
(23, '$75 Value Card', 'Awarded by our Managers to employees for immediate, on-the-spot recognition for living the values and going above and beyond. Enter the reason for the card in the space provided.', 75, 1, 0, 0, 1),
(24, '$100 Value Card', 'Awarded by our Managers to employees for immediate, on-the-spot recognition for living the values and going above and beyond. Enter the reason for the card in the space provided.', 100, 1, 0, 0, 1),
(25, 'Variable Value Card', 'Awarded by our Managers to employees for immediate, on-the-spot recognition for living the values and going above and beyond. Enter the reason for the card in the space provided.', 10, 1, 0, 1, 1),
(26, '5 Year', '5', 150, 2, 1, 0, 1),
(27, '10 year', '10', 250, 2, 1, 0, 1),
(28, '15 year', '15', 350, 2, 1, 0, 1),
(29, '20 year', '20', 450, 2, 1, 0, 1),
(30, '25 year', '25', 550, 2, 1, 0, 1),
(31, '30 year', '30', 650, 2, 1, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `category_perm_bu`
--

CREATE TABLE `category_perm_bu` (
  `category_id` int(11) NOT NULL,
  `bu_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category_perm_bu`
--

INSERT INTO `category_perm_bu` (`category_id`, `bu_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(1, 9),
(1, 10),
(2, 1),
(2, 2),
(2, 3),
(2, 4),
(2, 5),
(2, 6),
(2, 7),
(2, 8),
(2, 9),
(2, 10),
(3, 1),
(3, 2),
(3, 3),
(3, 4),
(3, 5),
(3, 6),
(3, 7),
(3, 8),
(3, 9),
(3, 10),
(4, 1),
(4, 2),
(4, 3),
(4, 4),
(4, 5),
(4, 6),
(4, 7),
(4, 8),
(4, 9),
(4, 10),
(5, 1),
(5, 2),
(5, 3),
(5, 4),
(5, 5),
(5, 6),
(5, 7),
(5, 8),
(5, 9),
(5, 10),
(6, 1),
(6, 2),
(6, 3),
(6, 4),
(6, 5),
(6, 6),
(6, 7),
(6, 8),
(6, 9),
(6, 10),
(7, 1),
(7, 2),
(7, 3),
(7, 4),
(7, 5),
(7, 6),
(7, 7),
(7, 8),
(7, 9),
(7, 10),
(8, 1),
(8, 2),
(8, 3),
(8, 4),
(8, 5),
(8, 6),
(8, 7),
(8, 8),
(8, 9),
(8, 10),
(9, 1),
(9, 2),
(9, 3),
(9, 4),
(9, 5),
(9, 6),
(9, 7),
(9, 8),
(9, 9),
(9, 10),
(10, 1),
(10, 2),
(10, 3),
(10, 4),
(10, 5),
(10, 6),
(10, 7),
(10, 8),
(10, 9),
(10, 10),
(11, 1),
(11, 2),
(11, 3),
(11, 4),
(11, 5),
(11, 6),
(11, 7),
(11, 8),
(11, 9),
(11, 10),
(12, 1),
(12, 2),
(12, 3),
(12, 4),
(12, 5),
(12, 6),
(12, 7),
(12, 8),
(12, 9),
(12, 10),
(13, 1),
(13, 2),
(13, 3),
(13, 4),
(13, 5),
(13, 6),
(13, 7),
(13, 8),
(13, 9),
(13, 10),
(14, 1),
(14, 2),
(14, 3),
(14, 4),
(14, 5),
(14, 6),
(14, 7),
(14, 8),
(14, 9),
(14, 10),
(15, 1),
(15, 2),
(15, 3),
(15, 4),
(15, 5),
(15, 6),
(15, 7),
(15, 8),
(15, 9),
(15, 10),
(18, 1),
(18, 2),
(18, 3),
(18, 4),
(18, 5),
(18, 6),
(18, 7),
(18, 8),
(18, 9),
(18, 10),
(19, 1),
(19, 2),
(19, 3),
(19, 4),
(19, 5),
(19, 6),
(19, 7),
(19, 8),
(19, 9),
(19, 10),
(20, 1),
(20, 2),
(20, 3),
(20, 4),
(20, 5),
(20, 6),
(20, 7),
(20, 8),
(20, 9),
(20, 10),
(21, 1),
(21, 2),
(21, 3),
(21, 4),
(21, 5),
(21, 6),
(21, 7),
(21, 8),
(21, 9),
(21, 10),
(22, 1),
(22, 2),
(22, 3),
(22, 4),
(22, 5),
(22, 6),
(22, 7),
(22, 8),
(22, 9),
(22, 10),
(23, 1),
(23, 2),
(23, 3),
(23, 4),
(23, 5),
(23, 6),
(23, 7),
(23, 8),
(23, 9),
(23, 10),
(24, 1),
(24, 2),
(24, 3),
(24, 4),
(24, 5),
(24, 6),
(24, 7),
(24, 8),
(24, 9),
(24, 10),
(25, 1),
(25, 2),
(25, 3),
(25, 4),
(25, 5),
(25, 6),
(25, 7),
(25, 8),
(25, 9),
(25, 10),
(26, 1),
(26, 2),
(26, 3),
(26, 4),
(26, 5),
(26, 6),
(26, 7),
(26, 8),
(26, 9),
(26, 10),
(27, 1),
(27, 2),
(27, 3),
(27, 4),
(27, 5),
(27, 6),
(27, 7),
(27, 8),
(27, 9),
(27, 10),
(28, 1),
(28, 2),
(28, 3),
(28, 4),
(28, 5),
(28, 6),
(28, 7),
(28, 8),
(28, 9),
(28, 10),
(29, 1),
(29, 2),
(29, 3),
(29, 4),
(29, 5),
(29, 6),
(29, 7),
(29, 8),
(29, 9),
(29, 10),
(30, 1),
(30, 2),
(30, 3),
(30, 4),
(30, 5),
(30, 6),
(30, 7),
(30, 8),
(30, 9),
(30, 10),
(31, 1),
(31, 2),
(31, 3),
(31, 4),
(31, 5),
(31, 6),
(31, 7),
(31, 8),
(31, 9),
(31, 10),
(17, 1),
(17, 2),
(17, 3),
(17, 4),
(17, 5),
(17, 6),
(17, 7),
(17, 8),
(17, 9),
(17, 10),
(16, 2);

-- --------------------------------------------------------

--
-- Table structure for table `category_perm_role`
--

CREATE TABLE `category_perm_role` (
  `category_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category_perm_role`
--

INSERT INTO `category_perm_role` (`category_id`, `role_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(2, 1),
(2, 2),
(2, 3),
(2, 4),
(3, 1),
(3, 2),
(3, 3),
(3, 4),
(4, 1),
(4, 2),
(4, 3),
(4, 4),
(5, 1),
(5, 2),
(5, 3),
(5, 4),
(6, 1),
(6, 2),
(6, 3),
(6, 4),
(7, 1),
(7, 2),
(7, 3),
(7, 4),
(8, 1),
(8, 2),
(8, 3),
(8, 4),
(9, 1),
(9, 2),
(9, 3),
(9, 4),
(10, 1),
(10, 2),
(10, 3),
(10, 4),
(11, 1),
(11, 2),
(11, 3),
(11, 4),
(12, 1),
(12, 2),
(12, 3),
(12, 4),
(13, 1),
(13, 2),
(13, 3),
(13, 4),
(14, 1),
(14, 2),
(14, 3),
(14, 4),
(15, 1),
(15, 2),
(15, 3),
(15, 4),
(18, 3),
(18, 4),
(19, 1),
(19, 2),
(19, 3),
(19, 4),
(20, 1),
(20, 2),
(20, 3),
(20, 4),
(21, 2),
(21, 3),
(21, 4),
(22, 2),
(22, 3),
(22, 4),
(23, 2),
(23, 3),
(23, 4),
(24, 2),
(24, 3),
(24, 4),
(25, 2),
(25, 3),
(25, 4),
(26, 1),
(26, 2),
(26, 3),
(26, 4),
(27, 1),
(27, 2),
(27, 3),
(27, 4),
(28, 1),
(28, 2),
(28, 3),
(28, 4),
(29, 1),
(29, 2),
(29, 3),
(29, 4),
(30, 1),
(30, 2),
(30, 3),
(30, 4),
(31, 1),
(31, 2),
(31, 3),
(31, 4),
(17, 1),
(17, 2),
(17, 3),
(17, 4),
(16, 1),
(16, 2),
(16, 3),
(16, 4);

-- --------------------------------------------------------

--
-- Table structure for table `company_configuration`
--

CREATE TABLE `company_configuration` (
  `id` tinyint(1) NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `company_logo` varchar(20) NOT NULL,
  `auto_service_award` tinyint(1) NOT NULL,
  `auto_service_from` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `company_configuration`
--

INSERT INTO `company_configuration` (`id`, `company_name`, `company_logo`, `auto_service_award`, `auto_service_from`) VALUES
(1, 'Demo Company', 'default.png', 1, 16);

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `id` int(11) NOT NULL,
  `department_code` varchar(6) NOT NULL,
  `department_name` varchar(100) NOT NULL,
  `status_id` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `department_code`, `department_name`, `status_id`) VALUES
(1, 'NFSHRE', 'Operations 130', 1),
(2, 'NFSMIS', 'Information Technology 150', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset`
--

CREATE TABLE `password_reset` (
  `id` int(10) NOT NULL,
  `username` varchar(200) NOT NULL,
  `temp_key` varchar(100) NOT NULL,
  `expiration_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `perm_id` int(11) NOT NULL,
  `perm_name` varchar(50) NOT NULL,
  `perm_type` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`perm_id`, `perm_name`, `perm_type`) VALUES
(1, 'Give Appreciation', 'user'),
(2, 'Give Value Cards', 'user'),
(3, 'Request Rewards', 'user'),
(4, 'Admin Menu', 'admin'),
(5, 'User Management', 'admin'),
(6, 'Business Unit Management', 'admin'),
(7, 'Department Management', 'admin'),
(8, 'Category Management', 'admin'),
(9, 'Role Management', 'admin'),
(10, 'Approve', 'admin'),
(11, 'Reward Management', 'admin'),
(12, 'Service Award Management', 'admin'),
(13, 'Report Management', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `remember_me`
--

CREATE TABLE `remember_me` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `session_token` varchar(200) NOT NULL,
  `expiration_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL,
  `status_id` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`, `status_id`) VALUES
(1, 'Employee', 1),
(2, 'Manager', 1),
(3, 'Human Resources', 1),
(4, 'Administrator', 1);

-- --------------------------------------------------------

--
-- Table structure for table `role_perm`
--

CREATE TABLE `role_perm` (
  `role_id` int(11) NOT NULL,
  `perm_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role_perm`
--

INSERT INTO `role_perm` (`role_id`, `perm_id`) VALUES
(4, 1),
(4, 2),
(4, 3),
(4, 4),
(4, 5),
(4, 6),
(4, 7),
(4, 8),
(4, 9),
(4, 10),
(4, 11),
(4, 12),
(4, 13),
(1, 1),
(1, 3),
(2, 1),
(2, 2),
(2, 3),
(3, 1),
(3, 2),
(3, 3),
(3, 4),
(3, 5),
(3, 6),
(3, 7),
(3, 8),
(3, 10),
(3, 11),
(3, 12),
(3, 13);

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `status_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `status_name`) VALUES
(1, 'Active'),
(2, 'Inactive'),
(3, 'Pending Approval'),
(4, 'Approved'),
(5, 'Declined'),
(6, 'Canceled');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `hire_date` date NOT NULL,
  `employee_id` varchar(100) NOT NULL,
  `email_address` varchar(150) NOT NULL,
  `business_unit_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `manager_id` int(11) NOT NULL,
  `picture_id` varchar(75) NOT NULL,
  `status_id` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `first_name`, `last_name`, `hire_date`, `employee_id`, `email_address`, `business_unit_id`, `department_id`, `manager_id`, `picture_id`, `status_id`) VALUES
(1, 'admin_user', '$2y$10$6LqlaJjb/0TL1o0vhf/sA.hShtxw3zVFIiPQX5I.RKpazYuPfZWwe', 'Admin', 'User', '2017-03-18', '000000', 'admin@test.com', 7, 1, 0, 'default.png', 2),
(2, 'demo', '$2y$10$dWo7hG20bFVgDtMKFwszy.ESKScWhaKh9UdPKApZDZTQXju9zehq.', 'Chad', 'Stevenson', '2011-10-10', '001065', 'demo@test.me', 1, 1, 9, 'ChadStevenson001065.jpg', 1),
(3, 'noemail@thanksfrom.me', '$2y$10$sgcq4UW6An.goNp0U7bD0eJoQ76t8y7CQ7Ut7c7uvngpO16oeCe0y', 'Joe', 'Mill', '2011-06-27', '001017', 'joseph@test.com', 1, 2, 0, 'JoeMill001017.jpg', 1),
(4, 'noemail@thanksfrom.me', '$2y$10$LLad5XrHoM/rgIsYLwCY7usOMaC7jVPo6S90PRkHp/8RnOGqoYh7q', 'Jon', 'Cool', '2015-03-09', '001629', 'jon@test.com', 1, 2, 3, 'default.png', 1),
(5, 'noemail@thanksfrom.me', '$2y$10$tw16WtOYfZMx.XT0Po4olOfLRR9oE1i9hoRURa3LDmrPx1VoylQ/2', 'Jason', 'Pile', '2012-02-27', '001121', 'jason@test.com', 1, 2, 3, 'default.png', 1),
(6, 'noemail@thanksfrom.me', '$2y$10$EXS5uChXS91BmFzuHl6KZuR9Ie8zbqbHuVqJJ91oib5lNTb/LTfZ2', 'Max', 'Berg', '2016-10-31', '001988', 'maxwell@test.com', 1, 2, 3, 'default.png', 1),
(7, 'noemail@thanksfrom.me', '$2y$10$QCM5b/TTIzg/M8LbppflHu.Tf5Dh4A/OO1W8dVU7LVkqDFbwpsNI2', 'John', 'Hillsmith', '2015-12-07', '001789', 'john@test.com', 1, 2, 3, 'JohnHillsmith001789.jpg', 1),
(8, 'noemail@thanksfrom.me', '$2y$10$zV0PUwoodSm1vTJY4GrzOObVqs.EESP4F58b1K/1igV4O2xNonFki', 'Sam', 'Pine', '2011-09-06', '001048', 'aneudys@test.com', 1, 2, 3, 'default.png', 1),
(9, 'noemail@thanksfrom.me', '$2y$10$bqhH1SLgjUoz4J4OSPscCeBfEO.F157uGRehwmcqrWj1zpWx67KWK', 'Sheila', 'Petree', '2006-02-08', '000554', 'sheila@test.com', 1, 1, 18, 'default.png', 1),
(10, 'noemail@thanksfrom.me', '$2y$10$PEHQ9COVgDH4ezpc60.T6ezNM1SraCxLKCfJcR0MqWiby7N1WauCK', 'Jessica', 'Hambone', '2007-05-23', '000716', 'jessica@test.com', 1, 1, 9, 'default.png', 1),
(11, 'noemail@thanksfrom.me', '$2y$10$Lel2thuZSRVJ7NhWl4loVuK2GCfslV8faY5aaWCQIXUtnyrlmcnj.', 'Ann', 'Cornell', '2011-05-16', '000989', 'ann@test.com', 1, 1, 9, 'default.png', 1),
(12, 'noemail@thanksfrom.me', '$2y$10$VYKPcN38t9IAmwJb1VWTduDd6GPtTHlMLd.XLIZ1ziBYcxByYBNVO', 'Allison', 'Hughes', '2014-10-06', '001554', 'allison@test.com', 1, 1, 9, 'AllisonHughes001554.jpg', 1),
(13, 'noemail@thanksfrom.me', '$2y$10$byn6fyyWI5on4LUw98/GfeD3aC6.O7LUBRmUTg1NxmOQzgfeo0T7y', 'Makaila', 'McBurger', '2014-01-27', '001413', 'makaila@test.com', 1, 1, 9, 'default.png', 1),
(14, 'noemail@thanksfrom.me', '$2y$10$Qk7raSIwZaBbOnNhFSxHU.NpqiBmMvvkwtnvU.TWnwLqF0wQTbk6y', 'Bridget', 'Smith', '2015-12-28', '001799', 'bridget@test.com', 1, 1, 9, 'BridgetSmith001799.jpg', 1),
(15, 'noemail@thanksfrom.me', '$2y$10$BzdrJkOwXIqevJeZaedKgOr8xP9laQ/kZP3Te5z/mUgzYiTc65zE2', 'Hairy', 'Henderson', '2017-01-03', '002021', 'ashley@test.com', 1, 1, 9, 'default.png', 1),
(16, 'noemail@thanksfrom.me', '$2y$10$KVe0MTNE/extX9immcG0cu1VX4oh1cWOhnpNelGKeANdDNQDtluGS', 'Christine', 'Franz', '2016-10-17', '001978', 'christy@test.com', 1, 2, 9, 'default.png', 1),
(17, 'noemail@thanksfrom.me', '$2y$10$g4VYjRLUkuIbcaYoyMk5mOPpp5gl5VPytrsJ/1UT2gZSaVwx8X1gq', 'Sylvia', 'Gladstone', '2016-09-12', '001960', 'sylvia@test.com', 1, 1, 9, 'default.png', 1),
(18, 'noemail@thanksfrom.me', '$2y$10$RO.CvvaF0g74gsS0iYZZpOK0NvJENaARWMnx/rFxRD/uXph4dmWRa', 'Julie', 'Ronald', '2017-02-21', '002050', 'Julie@test.com', 1, 1, 0, 'default.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_configuration`
--

CREATE TABLE `user_configuration` (
  `user_id` int(11) NOT NULL,
  `rec_self` tinyint(1) NOT NULL,
  `give_approved` tinyint(1) NOT NULL,
  `give_denied` tinyint(1) NOT NULL,
  `rec_direct_report` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_configuration`
--

INSERT INTO `user_configuration` (`user_id`, `rec_self`, `give_approved`, `give_denied`, `rec_direct_report`) VALUES
(1, 0, 0, 0, 0),
(2, 0, 0, 0, 0),
(3, 0, 0, 0, 0),
(4, 0, 0, 0, 0),
(5, 0, 0, 0, 0),
(6, 0, 0, 0, 0),
(7, 0, 0, 0, 0),
(8, 0, 0, 0, 0),
(9, 0, 0, 0, 0),
(10, 0, 0, 0, 0),
(11, 0, 0, 0, 0),
(12, 0, 0, 0, 0),
(13, 0, 0, 0, 0),
(14, 0, 0, 0, 0),
(15, 0, 0, 0, 0),
(16, 0, 0, 0, 0),
(17, 0, 0, 0, 0),
(18, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_history`
--

CREATE TABLE `user_history` (
  `id` int(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `business_unit_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `manager_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_history`
--

INSERT INTO `user_history` (`id`, `user_id`, `business_unit_id`, `department_id`, `manager_id`) VALUES
(1, 2, 1, 1, 0),
(2, 3, 1, 2, 0),
(3, 4, 1, 2, 3),
(4, 5, 1, 2, 3),
(5, 6, 1, 2, 3),
(6, 7, 1, 2, 3),
(7, 8, 1, 2, 3),
(8, 9, 1, 1, 0),
(9, 2, 1, 1, 9),
(10, 10, 1, 1, 9),
(11, 11, 1, 1, 9),
(12, 12, 1, 1, 9),
(13, 13, 1, 1, 9),
(14, 14, 1, 1, 9),
(15, 15, 1, 1, 9),
(16, 16, 1, 1, 9),
(17, 1, 7, 1, 0),
(18, 10, 1, 1, 9),
(19, 2, 1, 1, 9),
(20, 17, 1, 1, 9),
(21, 16, 1, 2, 9),
(22, 15, 1, 1, 9),
(23, 2, 1, 1, 9),
(24, 2, 1, 1, 9),
(25, 10, 1, 1, 9),
(26, 11, 1, 1, 9),
(27, 8, 1, 2, 3),
(28, 2, 1, 1, 9),
(29, 5, 1, 2, 3),
(30, 13, 1, 1, 9),
(31, 12, 1, 1, 9),
(32, 4, 1, 2, 3),
(33, 7, 1, 2, 3),
(34, 14, 1, 1, 9),
(35, 17, 1, 1, 9),
(36, 16, 1, 2, 9),
(37, 6, 1, 2, 3),
(38, 15, 1, 1, 9),
(39, 18, 1, 1, 0),
(40, 9, 1, 1, 18),
(41, 2, 1, 1, 9);

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`user_id`, `role_id`) VALUES
(1, 4),
(2, 1),
(3, 2),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 2),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appreciation`
--
ALTER TABLE `appreciation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `business_unit`
--
ALTER TABLE `business_unit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_configuration`
--
ALTER TABLE `company_configuration`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset`
--
ALTER TABLE `password_reset`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`perm_id`);

--
-- Indexes for table `remember_me`
--
ALTER TABLE `remember_me`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_history`
--
ALTER TABLE `user_history`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appreciation`
--
ALTER TABLE `appreciation`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
--
-- AUTO_INCREMENT for table `business_unit`
--
ALTER TABLE `business_unit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `company_configuration`
--
ALTER TABLE `company_configuration`
  MODIFY `id` tinyint(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `password_reset`
--
ALTER TABLE `password_reset`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `perm_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `remember_me`
--
ALTER TABLE `remember_me`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `user_history`
--
ALTER TABLE `user_history`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
