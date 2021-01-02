-- phpMyAdmin SQL Dump
-- version 4.5.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 16, 2018 at 09:49 AM
-- Server version: 5.7.11
-- PHP Version: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `skn_feedback`
--

-- --------------------------------------------------------

--
-- Table structure for table `skn_feedback_admin`
--

CREATE TABLE `skn_feedback_admin` (
  `pass` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `skn_feedback_admin`
--

insert into skn_feedback_`skn_feedback_admin` (`pass`) VALUES
('3a9548634e7f47c385f9a97cb4bcc284');

-- --------------------------------------------------------

--
-- Table structure for table `skn_feedback_practical`
--

CREATE TABLE `skn_feedback_practical` (
  `id` varchar(30) NOT NULL,
  `feedback` varchar(2) NOT NULL,
  `year` varchar(20) NOT NULL,
  `class` varchar(3) NOT NULL,
  `sem` varchar(2) NOT NULL,
  `dept` varchar(10) NOT NULL,
  `division` varchar(2) NOT NULL,
  `batch` varchar(2) NOT NULL,
  `sub_code` varchar(10) NOT NULL,
  `q8` varchar(2) NOT NULL,
  `q9` varchar(2) NOT NULL,
  `q10` varchar(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Table structure for table `skn_feedback_staff`
--

CREATE TABLE `skn_feedback_staff` (
  `name` varchar(30) NOT NULL,
  `subject` varchar(30) NOT NULL,
  `sub_code` varchar(30) NOT NULL,
  `sem` varchar(20) NOT NULL,
  `dept` varchar(20) NOT NULL,
  `division` varchar(2) NOT NULL,
  `batch` varchar(20) NOT NULL,
  `work` varchar(3) NOT NULL,
  `year` varchar(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Table structure for table `skn_feedback_theory`
--

CREATE TABLE `skn_feedback_theory` (
  `id` varchar(30) NOT NULL,
  `feedback` varchar(2) NOT NULL,
  `year` varchar(30) NOT NULL,
  `class` varchar(30) NOT NULL,
  `sem` varchar(10) NOT NULL,
  `dept` varchar(10) NOT NULL,
  `division` varchar(2) NOT NULL,
  `sub_code` varchar(30) NOT NULL,
  `q1` varchar(2) NOT NULL,
  `q2` varchar(2) NOT NULL,
  `q3` varchar(2) NOT NULL,
  `q4` varchar(2) NOT NULL,
  `q5` varchar(2) NOT NULL,
  `q6` varchar(2) NOT NULL,
  `q7` varchar(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Table structure for table `skn_feedback_users`
--

CREATE TABLE `skn_feedback_users` (
  `id` varchar(30) NOT NULL,
  `pass` varchar(50) NOT NULL,
  `active` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


--
-- Indexes for table `skn_feedback_users`
--
ALTER TABLE `skn_feedback_users`
  ADD PRIMARY KEY (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
