-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 26, 2014 at 05:40 PM
-- Server version: 5.5.31
-- PHP Version: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `event`
--
CREATE DATABASE IF NOT EXISTS `event` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `event`;

-- --------------------------------------------------------

--
-- Table structure for table `evt_logs`
--

CREATE TABLE IF NOT EXISTS `evt_logs` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(150) NOT NULL,
  `type` varchar(250) NOT NULL,
  `from` varchar(200) NOT NULL,
  `sysdetails` varchar(500) NOT NULL,
  `msg` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`event_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Used to store Log Events' AUTO_INCREMENT=6 ;

--
-- Dumping data for table `evt_logs`
--

INSERT INTO `evt_logs` (`event_id`, `category`, `type`, `from`, `sysdetails`, `msg`, `created_at`, `updated_at`) VALUES
(1, 'template-DataError', 'error', '123', 'localhost', 'test success', '2014-06-04 17:28:34', '2014-06-04 17:28:34'),
(2, 'template-DataError', 'error', '123', '{"ip":[],"user_agent":"Mozilla\\/5.0 (X11; Linux x86_64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/35.0.1916.114 Safari\\/537.36"}', 'test success', '2014-06-04 17:29:17', '2014-06-04 17:29:17'),
(3, 'template-DataError', 'error', '123', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Linux x86_64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/35.0.1916.114 Safari\\/537.36"}', 'test success', '2014-06-04 17:30:04', '2014-06-04 17:30:04'),
(4, 'template-DataError', 'error', '123', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Linux x86_64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/35.0.1916.114 Safari\\/537.36"}', 'test success', '2014-06-04 17:32:59', '2014-06-04 17:32:59'),
(5, 'template-DataError', 'error', '123', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Linux x86_64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/35.0.1916.114 Safari\\/537.36"}', 'test success', '2014-06-04 17:37:40', '2014-06-04 17:37:40');

-- --------------------------------------------------------

--
-- Table structure for table `evt_users`
--

CREATE TABLE IF NOT EXISTS `evt_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_key` varchar(200) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email_id` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `country_id` int(11) NOT NULL,
  `state` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `u_aro_id` int(11) NOT NULL,
  `created` varchar(100) NOT NULL,
  `modified` varchar(100) NOT NULL,
  `language_id` int(11) NOT NULL,
  `is_enabled` tinyint(4) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `evt_users`
--

INSERT INTO `evt_users` (`user_id`, `user_key`, `user_name`, `password`, `first_name`, `last_name`, `email_id`, `avatar`, `address`, `country_id`, `state`, `city`, `u_aro_id`, `created`, `modified`, `language_id`, `is_enabled`) VALUES
(1, '3524356342543', 'test', '', '', '', '', '', '', 0, '', '', 0, '', '', 0, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
