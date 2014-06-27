-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 27, 2014 at 04:06 PM
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Used to store Log Events' AUTO_INCREMENT=73 ;

--
-- Dumping data for table `evt_logs`
--

INSERT INTO `evt_logs` (`event_id`, `category`, `type`, `from`, `sysdetails`, `msg`, `created_at`, `updated_at`) VALUES
(1, 'template-DataError', 'error', '123', 'localhost', 'test success', '2014-06-04 17:28:34', '2014-06-04 17:28:34'),
(2, 'template-DataError', 'error', '123', '{"ip":[],"user_agent":"Mozilla\\/5.0 (X11; Linux x86_64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/35.0.1916.114 Safari\\/537.36"}', 'test success', '2014-06-04 17:29:17', '2014-06-04 17:29:17'),
(3, 'template-DataError', 'error', '123', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Linux x86_64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/35.0.1916.114 Safari\\/537.36"}', 'test success', '2014-06-04 17:30:04', '2014-06-04 17:30:04'),
(4, 'template-DataError', 'error', '123', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Linux x86_64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/35.0.1916.114 Safari\\/537.36"}', 'test success', '2014-06-04 17:32:59', '2014-06-04 17:32:59'),
(5, 'template-DataError', 'error', '123', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Linux x86_64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/35.0.1916.114 Safari\\/537.36"}', 'test success', '2014-06-04 17:37:40', '2014-06-04 17:37:40'),
(6, 'sys-events', 'file-validated', '4', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 'FILEVALIDATEDSUCCESSFile Details are: Size:58992 and File Type: png', '2014-06-27 12:46:53', '2014-06-27 12:46:53'),
(7, 'File-upload', 'success', '4', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 'FILEUPLOADSUCCESS (Original Document).', '2014-06-27 12:46:53', '2014-06-27 12:46:53'),
(8, 'sys-events', 'file-validated', '4', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 'FILEVALIDATEDSUCCESSFile Details are: Size:58992 and File Type: png', '2014-06-27 12:50:40', '2014-06-27 12:50:40'),
(9, 'File-upload', 'success', '4', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 'FILEUPLOADSUCCESS (Original Document).', '2014-06-27 12:50:40', '2014-06-27 12:50:40'),
(10, 'sys-events', 'file-validated', '4', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 'FILEVALIDATEDSUCCESSFile Details are: Size:58992 and File Type: png', '2014-06-27 12:51:32', '2014-06-27 12:51:32'),
(11, 'File-upload', 'success', '4', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 'FILEUPLOADSUCCESS (Original Document).', '2014-06-27 12:51:32', '2014-06-27 12:51:32'),
(12, 'sys-events', 'file-validated', '4', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 'FILEVALIDATEDSUCCESSFile Details are: Size:58992 and File Type: png', '2014-06-27 12:52:17', '2014-06-27 12:52:17'),
(13, 'File-upload', 'success', '4', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 'FILEUPLOADSUCCESS (Original Document).', '2014-06-27 12:52:17', '2014-06-27 12:52:17'),
(14, 'sys-events', 'file-validated', '4', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 'FILEVALIDATEDSUCCESSFile Details are: Size:58992 and File Type: png', '2014-06-27 12:53:07', '2014-06-27 12:53:07'),
(15, 'File-upload', 'success', '4', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 'FILEUPLOADSUCCESS (Original Document).', '2014-06-27 12:53:07', '2014-06-27 12:53:07'),
(16, 'sys-events', 'file-validated', '4', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 'FILEVALIDATEDSUCCESSFile Details are: Size:58992 and File Type: png', '2014-06-27 12:55:03', '2014-06-27 12:55:03'),
(17, 'File-upload', 'success', '4', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 'FILEUPLOADSUCCESS (Original Document).', '2014-06-27 12:55:03', '2014-06-27 12:55:03'),
(18, 'sys-events', 'file-validated', '4', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 'FILEVALIDATEDSUCCESSFile Details are: Size:58992 and File Type: png', '2014-06-27 12:56:04', '2014-06-27 12:56:04'),
(19, 'File-upload', 'success', '4', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 'FILEUPLOADSUCCESS (Original Document).', '2014-06-27 12:56:04', '2014-06-27 12:56:04'),
(20, 'sys-events', 'file-validated', '4', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 'FILEVALIDATEDSUCCESSFile Details are: Size:58992 and File Type: png', '2014-06-27 12:56:30', '2014-06-27 12:56:30'),
(21, 'File-upload', 'success', '4', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 'FILEUPLOADSUCCESS (Original Document).', '2014-06-27 12:56:30', '2014-06-27 12:56:30'),
(22, 'sys-events', 'file-validated', '4', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 'FILEVALIDATEDSUCCESSFile Details are: Size:58992 and File Type: png', '2014-06-27 12:57:25', '2014-06-27 12:57:25'),
(23, 'File-upload', 'success', '4', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 'FILEUPLOADSUCCESS (Original Document).', '2014-06-27 12:57:25', '2014-06-27 12:57:25'),
(24, 'sys-events', 'file-validated', '4', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 'FILEVALIDATEDSUCCESSFile Details are: Size:58992 and File Type: png', '2014-06-27 12:58:53', '2014-06-27 12:58:53'),
(25, 'File-upload', 'success', '4', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 'FILEUPLOADSUCCESS (Original Document).', '2014-06-27 12:58:53', '2014-06-27 12:58:53'),
(26, 'sys-events', 'file-validated', '4', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 'FILEVALIDATEDSUCCESSFile Details are: Size:58992 and File Type: png', '2014-06-27 13:02:42', '2014-06-27 13:02:42'),
(27, 'File-upload', 'success', '4', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 'FILEUPLOADSUCCESS (Original Document).', '2014-06-27 13:02:42', '2014-06-27 13:02:42'),
(28, 'PDF-RECORD', 'success', '4', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 'PDFRECORDSUCCESS (Original Document: 6e3fecd9acd30777.png)', '2014-06-27 13:02:43', '2014-06-27 13:02:43'),
(29, 'sys-events', 'file-validated', '4', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 'FILEVALIDATEDSUCCESSFile Details are: Size:58992 and File Type: png', '2014-06-27 13:06:22', '2014-06-27 13:06:22'),
(30, 'File-upload', 'success', '4', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 'FILEUPLOADSUCCESS (Original Document).', '2014-06-27 13:06:22', '2014-06-27 13:06:22'),
(31, 'PDF-RECORD', 'success', '4', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 'PDFRECORDSUCCESS (Original Document: 73ce9ec9697377c1.png)', '2014-06-27 13:06:23', '2014-06-27 13:06:23'),
(32, 'sys-events', 'file-validated', '4', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 'FILEVALIDATEDSUCCESSFile Details are: Size:58992 and File Type: png', '2014-06-27 13:15:42', '2014-06-27 13:15:42'),
(33, 'File-upload', 'success', '4', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 'FILEUPLOADSUCCESS (Original Document).', '2014-06-27 13:15:42', '2014-06-27 13:15:42'),
(34, 'PDF-RECORD', 'success', '4', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 'PDFRECORDSUCCESS (Original Document: 5d422f41cd9713ec.png)', '2014-06-27 13:15:43', '2014-06-27 13:15:43'),
(35, 'sys-events', 'file-validated', '4', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 'FILEVALIDATEDSUCCESSFile Details are: Size:58992 and File Type: png', '2014-06-27 13:22:33', '2014-06-27 13:22:33'),
(36, 'File-upload', 'success', '4', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 'FILEUPLOADSUCCESS (Original Document).', '2014-06-27 13:22:33', '2014-06-27 13:22:33'),
(37, 'PDF-RECORD', 'success', '4', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 'PDFRECORDSUCCESS (Original Document: 2c2fbe63ba26d8bc.png)', '2014-06-27 13:22:34', '2014-06-27 13:22:34'),
(38, 'sys-events', 'file-validated', '4', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 'FILEVALIDATEDSUCCESSFile Details are: Size:58992 and File Type: png', '2014-06-27 13:23:25', '2014-06-27 13:23:25'),
(39, 'File-upload', 'success', '4', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 'FILEUPLOADSUCCESS (Original Document).', '2014-06-27 13:23:25', '2014-06-27 13:23:25'),
(40, 'PDF-RECORD', 'success', '4', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 'PDFRECORDSUCCESS (Original Document: 16765aa910836bb9.png)', '2014-06-27 13:23:26', '2014-06-27 13:23:26'),
(41, 'sys-events', 'file-validated', '4', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 'FILEVALIDATEDSUCCESSFile Details are: Size:58992 and File Type: png', '2014-06-27 13:23:50', '2014-06-27 13:23:50'),
(42, 'File-upload', 'success', '4', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 'FILEUPLOADSUCCESS (Original Document).', '2014-06-27 13:23:50', '2014-06-27 13:23:50'),
(43, 'PDF-RECORD', 'success', '4', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 'PDFRECORDSUCCESS (Original Document: c83ffc042352c44e.png)', '2014-06-27 13:23:51', '2014-06-27 13:23:51'),
(44, 'sys-events', 'file-validated', '4', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 'FILEVALIDATEDSUCCESSFile Details are: Size:58992 and File Type: png', '2014-06-27 13:24:02', '2014-06-27 13:24:02'),
(45, 'File-upload', 'success', '4', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 'FILEUPLOADSUCCESS (Original Document).', '2014-06-27 13:24:02', '2014-06-27 13:24:02'),
(46, 'PDF-RECORD', 'success', '4', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 'PDFRECORDSUCCESS (Original Document: 842e493dd47c7f6c.png)', '2014-06-27 13:24:03', '2014-06-27 13:24:03'),
(47, 'sys-events', 'file-validated', '4', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 'FILEVALIDATEDSUCCESSFile Details are: Size:58992 and File Type: png', '2014-06-27 13:24:57', '2014-06-27 13:24:57'),
(48, 'File-upload', 'success', '4', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 'FILEUPLOADSUCCESS (Original Document).', '2014-06-27 13:24:57', '2014-06-27 13:24:57'),
(49, 'PDF-RECORD', 'success', '4', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 'PDFRECORDSUCCESS (Original Document: 67dae35826f0f945.png)', '2014-06-27 13:24:58', '2014-06-27 13:24:58'),
(50, 'sys-events', 'file-validated', '4', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 'FILEVALIDATEDSUCCESSFile Details are: Size:58992 and File Type: png', '2014-06-27 13:26:35', '2014-06-27 13:26:35'),
(51, 'File-upload', 'success', '4', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 'FILEUPLOADSUCCESS (Original Document).', '2014-06-27 13:26:35', '2014-06-27 13:26:35'),
(52, 'PDF-RECORD', 'success', '4', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 'PDFRECORDSUCCESS (Original Document: 51fb58e29b80c6cb.png)', '2014-06-27 13:26:36', '2014-06-27 13:26:36'),
(53, 'sys-events', 'file-validated', '4', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 'FILEVALIDATEDSUCCESSFile Details are: Size:58992 and File Type: png', '2014-06-27 13:28:59', '2014-06-27 13:28:59'),
(54, 'File-upload', 'success', '4', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 'FILEUPLOADSUCCESS (Original Document).', '2014-06-27 13:28:59', '2014-06-27 13:28:59'),
(55, 'PDF-RECORD', 'success', '4', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 'PDFRECORDSUCCESS (Original Document: 02f7dc77880df99f.png)', '2014-06-27 13:29:00', '2014-06-27 13:29:00'),
(56, 'sys-events', 'file-validated', '4', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 'FILEVALIDATEDSUCCESSFile Details are: Size:58992 and File Type: png', '2014-06-27 13:33:51', '2014-06-27 13:33:51'),
(57, 'File-upload', 'success', '4', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 'FILEUPLOADSUCCESS (Original Document).', '2014-06-27 13:33:51', '2014-06-27 13:33:51'),
(58, 'PDF-RECORD', 'success', '4', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 'PDFRECORDSUCCESS (Original Document: ff9b39eeb0282c13.png)', '2014-06-27 13:33:52', '2014-06-27 13:33:52'),
(59, 'sys-events', 'file-validated', '4', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 'FILEVALIDATEDSUCCESSFile Details are: Size:58992 and File Type: png', '2014-06-27 13:45:14', '2014-06-27 13:45:14'),
(60, 'File-upload', 'success', '4', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 'FILEUPLOADSUCCESS (Original Document).', '2014-06-27 13:45:14', '2014-06-27 13:45:14'),
(61, 'PDF-RECORD', 'success', '4', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 'PDFRECORDSUCCESS (Original Document: ee399e7570c386bb.png)', '2014-06-27 13:45:15', '2014-06-27 13:45:15'),
(62, 'sys-events', 'file-validated', '4', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 'FILEVALIDATEDSUCCESSFile Details are: Size:58992 and File Type: png', '2014-06-27 13:45:47', '2014-06-27 13:45:47'),
(63, 'File-upload', 'success', '4', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 'FILEUPLOADSUCCESS (Original Document).', '2014-06-27 13:45:47', '2014-06-27 13:45:47'),
(64, 'sys-events', 'file-validated', '4', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 'FILEVALIDATEDSUCCESSFile Details are: Size:214120 and File Type: png', '2014-06-27 13:48:58', '2014-06-27 13:48:58'),
(65, 'File-upload', 'success', '4', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 'FILEUPLOADSUCCESS (Original Document).', '2014-06-27 13:48:59', '2014-06-27 13:48:59'),
(66, 'PDF-RECORD', 'success', '4', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 'PDFRECORDSUCCESS (Original Document: 7f175c325608b69a.png)', '2014-06-27 13:48:59', '2014-06-27 13:48:59'),
(67, 'sys-events', 'file-validated', '4', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 'FILEVALIDATEDSUCCESSFile Details are: Size:58992 and File Type: png', '2014-06-27 13:49:05', '2014-06-27 13:49:05'),
(68, 'File-upload', 'success', '4', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 'FILEUPLOADSUCCESS (Original Document).', '2014-06-27 13:49:05', '2014-06-27 13:49:05'),
(69, 'PDF-RECORD', 'success', '4', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 'PDFRECORDSUCCESS (Original Document: 585fdc19e309b1ae.png)', '2014-06-27 13:49:06', '2014-06-27 13:49:06'),
(70, 'sys-events', 'file-validated', '4', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 'FILEVALIDATEDSUCCESSFile Details are: Size:58992 and File Type: png', '2014-06-27 13:57:43', '2014-06-27 13:57:43'),
(71, 'File-upload', 'success', '4', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 'FILEUPLOADSUCCESS (Original Document).', '2014-06-27 13:57:43', '2014-06-27 13:57:43'),
(72, 'PDF-RECORD', 'success', '4', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 'PDFRECORDSUCCESS (Original Document: 606709cdab53171a.png)', '2014-06-27 13:57:44', '2014-06-27 13:57:44');

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

-- --------------------------------------------------------

--
-- Table structure for table `evt_user_original_docs`
--

CREATE TABLE IF NOT EXISTS `evt_user_original_docs` (
  `oridoc_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_key` varchar(500) NOT NULL,
  `oridoc_key` varchar(500) NOT NULL,
  `oridoc_name` varchar(250) NOT NULL,
  `oridoc_desc` varchar(250) NOT NULL,
  `oridoc_tags` text NOT NULL,
  `oridoc_filename` varchar(250) NOT NULL,
  `system_details` text NOT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0',
  `parent_dockey` varchar(250) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`oridoc_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Holds the User''s Original documents' AUTO_INCREMENT=6 ;

--
-- Dumping data for table `evt_user_original_docs`
--

INSERT INTO `evt_user_original_docs` (`oridoc_id`, `user_key`, `oridoc_key`, `oridoc_name`, `oridoc_desc`, `oridoc_tags`, `oridoc_filename`, `system_details`, `is_deleted`, `parent_dockey`, `created_at`, `updated_at`) VALUES
(1, '4', 'a0554751aa3dfed2d4a97e0be8ec8ee2', 'sales-invoice-png', '', '', 'ee399e7570c386bb.png', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 0, '0', '2014-06-27 13:45:14', '2014-06-27 13:45:14'),
(2, '4', '0b241147faa15a2cc2bd6e5e81a30e2f', 'sales-invoice-png', '', '', '16aed71200f80749.png', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 0, 'a0554751aa3dfed2d4a97e0be8ec8ee2', '2014-06-27 13:45:47', '2014-06-27 13:45:47'),
(3, '4', '6a5450ba5426b93503e96af219aa1950', 'Screenshot-1-png', '', '', '7f175c325608b69a.png', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 0, '0', '2014-06-27 13:48:58', '2014-06-27 13:48:58'),
(4, '4', '3973a1c8cac3fdb28aeb862621476051', 'sales-invoice-png', '', '', '585fdc19e309b1ae.png', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 0, '6a5450ba5426b93503e96af219aa1950', '2014-06-27 13:49:05', '2014-06-27 13:49:05'),
(5, '4', 'd6d0239cf65e66ac2ae3fc90c6fc7b18', 'sales-invoice-png', '', '', '606709cdab53171a.png', '{"ip":"127.0.0.1","user_agent":"Mozilla\\/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko\\/20100101 Firefox\\/30.0"}', 0, '0', '2014-06-27 13:57:43', '2014-06-27 13:57:43');

-- --------------------------------------------------------

--
-- Table structure for table `evt_user_pdf_docs`
--

CREATE TABLE IF NOT EXISTS `evt_user_pdf_docs` (
  `pdfdoc_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_key` varchar(500) NOT NULL,
  `oridoc_key` varchar(500) NOT NULL,
  `converted_docname` varchar(500) NOT NULL,
  `total_pages` int(11) NOT NULL,
  `audit_pages` int(11) NOT NULL,
  `deleted_docno` text NOT NULL COMMENT 'comman separated doc no.',
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`pdfdoc_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Hold converted Documents (PDF)' AUTO_INCREMENT=4 ;

--
-- Dumping data for table `evt_user_pdf_docs`
--

INSERT INTO `evt_user_pdf_docs` (`pdfdoc_id`, `user_key`, `oridoc_key`, `converted_docname`, `total_pages`, `audit_pages`, `deleted_docno`, `is_deleted`, `created_at`, `updated_at`) VALUES
(2, '4', '6a5450ba5426b93503e96af219aa1950', '7f175c325608b69a.png', 2, 0, '0', 0, '2014-06-27 13:48:59', '2014-06-27 13:49:06'),
(3, '4', 'd6d0239cf65e66ac2ae3fc90c6fc7b18', '606709cdab53171a.png', 1, 0, '0', 0, '2014-06-27 13:57:44', '2014-06-27 13:57:44');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
