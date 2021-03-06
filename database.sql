-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 05, 2014 at 06:25 PM
-- Server version: 5.1.44
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `database`
--

-- --------------------------------------------------------

--
-- Table structure for table `evaluate`
--

CREATE TABLE IF NOT EXISTS `evaluate` (
  `id_project` mediumint(8) NOT NULL DEFAULT '0',
  `id_user` mediumint(8) NOT NULL DEFAULT '0',
  `c1` tinyint(4) NOT NULL DEFAULT '0',
  `c2` tinyint(4) NOT NULL DEFAULT '0',
  `c3` tinyint(4) NOT NULL DEFAULT '0',
  `c4` tinyint(4) NOT NULL DEFAULT '0',
  `c5` tinyint(4) NOT NULL DEFAULT '0',
  `c6` tinyint(4) NOT NULL DEFAULT '0',
  `c7` tinyint(4) NOT NULL DEFAULT '0',
  `c8` tinyint(4) NOT NULL DEFAULT '0',
  `c9` tinyint(4) NOT NULL DEFAULT '0',
  `c10` tinyint(4) NOT NULL DEFAULT '0',
  `total` tinyint(4) NOT NULL DEFAULT '0',
  `time` int(10) NOT NULL DEFAULT '0',
  UNIQUE KEY `id_project_id_user` (`id_project`, `id_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id_category` mediumint(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id_category`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `online`
--

CREATE TABLE IF NOT EXISTS `online` (
  `id_user` mediumint(8) NOT NULL DEFAULT '0',
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `time` int(10) NOT NULL DEFAULT '0',
  UNIQUE KEY `id_user` (`id_user`),
  KEY `time` (`time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE IF NOT EXISTS `project` (
  `id_project` mediumint(8) NOT NULL AUTO_INCREMENT,
  `id_category` mediumint(8) NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id_project`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id_user` mediumint(8) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `category` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `registered` int(10) NOT NULL DEFAULT '0',
  `admin` tinyint(4) NOT NULL DEFAULT '0',
  `login_count` mediumint(8) NOT NULL DEFAULT '0',
  `last_login` int(10) NOT NULL DEFAULT '0',
  `last_password_change` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_user`),
  KEY `registered` (`registered`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
