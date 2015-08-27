-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 24, 2015 at 03:56 PM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `tameras_tasksapp`
--
CREATE DATABASE IF NOT EXISTS `tameras_tasksapp` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `tameras_tasksapp`;

-- --------------------------------------------------------

--
-- Table structure for table `attachments`
--

CREATE TABLE IF NOT EXISTS `attachments` (
  `attach_id` int(11) NOT NULL AUTO_INCREMENT,
  `attach_group_id` int(11) NOT NULL,
  `attach_desc` varchar(255) NOT NULL,
  PRIMARY KEY (`attach_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `comment_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `task_id` int(11) NOT NULL,
  `comment_desc` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment_log` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `attach_group_id` int(11) NOT NULL,
  PRIMARY KEY (`comment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `followers`
--

CREATE TABLE IF NOT EXISTS `followers` (
  `follower_id` int(11) unsigned NOT NULL,
  `job_id` int(11) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `notif_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `notif_desc` text NOT NULL,
  PRIMARY KEY (`notif_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `notification_user`
--

CREATE TABLE IF NOT EXISTS `notification_user` (
  `notif_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `flag` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE IF NOT EXISTS `permissions` (
  `perm_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `perm_desc` varchar(255) NOT NULL,
  `perm_link` varchar(255) NOT NULL,
  `perm_type` int(11) NOT NULL,
  PRIMARY KEY (`perm_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `permission_types`
--

CREATE TABLE IF NOT EXISTS `permission_types` (
  `perm_type_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `perm_type_desc` varchar(255) NOT NULL,
  PRIMARY KEY (`perm_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE IF NOT EXISTS `tasks` (
  `task_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `creator_id` int(11) NOT NULL,
  `assignee_id` int(11) NOT NULL,
  `loc_id` int(11) DEFAULT NULL,
  `start_date` date NOT NULL,
  `due_date` date NOT NULL,
  `repeat` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `desc` text NOT NULL,
  `done_date` date DEFAULT NULL,
  `rating` int(11) unsigned DEFAULT NULL,
  `attach_group_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`task_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
