-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 21, 2020 at 10:32 AM
-- Server version: 5.5.22
-- PHP Version: 5.6.23-1+deprecated+dontuse+deb.sury.org~precise+1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `telescoop_web`
--

-- --------------------------------------------------------

--
-- Table structure for table `bday_messenger`
--

CREATE TABLE IF NOT EXISTS `bday_messenger` (
  `bday_date` date NOT NULL,
  `is_sent` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `challenge_questions`
--

CREATE TABLE IF NOT EXISTS `challenge_questions` (
  `question_id` int(11) NOT NULL AUTO_INCREMENT,
  `question` text,
  PRIMARY KEY (`question_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

--
-- Table structure for table `dividend_2011`
--

CREATE TABLE IF NOT EXISTS `dividend_2011` (
  `bank` varchar(255) DEFAULT NULL,
  `account_number` varchar(255) DEFAULT NULL,
  `idno2` varchar(255) DEFAULT NULL,
  `member_id` varchar(255) DEFAULT NULL,
  `surname` varchar(255) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `int_capital` varchar(255) DEFAULT NULL,
  `Patronage` varchar(255) DEFAULT NULL,
  `Total` varchar(255) DEFAULT NULL,
  `Deduct` varchar(255) DEFAULT NULL,
  `NET_Dividend` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dividend_2012`
--

CREATE TABLE IF NOT EXISTS `dividend_2012` (
  `member_id` varchar(255) DEFAULT NULL,
  `surname` varchar(255) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `int_capital` varchar(255) DEFAULT NULL,
  `Patronage` varchar(255) DEFAULT NULL,
  `Total` varchar(255) DEFAULT NULL,
  `Deduct` varchar(255) DEFAULT NULL,
  `NET_Dividend` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dividend_2013`
--

CREATE TABLE IF NOT EXISTS `dividend_2013` (
  `member_id` varchar(255) DEFAULT NULL,
  `surname` varchar(255) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `int_capital` decimal(10,2) DEFAULT NULL,
  `Patronage` decimal(10,2) DEFAULT NULL,
  `Total` decimal(10,2) DEFAULT NULL,
  `Deduct` decimal(10,2) DEFAULT NULL,
  `NET_Dividend` decimal(10,2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dividend_2014`
--

CREATE TABLE IF NOT EXISTS `dividend_2014` (
  `member_id` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `bank` varchar(255) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `int_capital` varchar(255) DEFAULT NULL,
  `Patronage` varchar(255) DEFAULT NULL,
  `Total` varchar(255) DEFAULT NULL,
  `Deduct` varchar(255) DEFAULT NULL,
  `NET_Dividend` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dividend_2015`
--

CREATE TABLE IF NOT EXISTS `dividend_2015` (
  `member_id` bigint(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `bank` varchar(255) DEFAULT NULL,
  `company_id` varchar(255) DEFAULT NULL,
  `int_capital` varchar(255) DEFAULT NULL,
  `Patronage` varchar(255) DEFAULT NULL,
  `Total` varchar(255) DEFAULT NULL,
  `Deduct` varchar(255) DEFAULT NULL,
  `NET_Dividend` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dividend_2016`
--

CREATE TABLE IF NOT EXISTS `dividend_2016` (
  `member_id` bigint(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `bank` varchar(255) DEFAULT NULL,
  `company_id` varchar(255) DEFAULT NULL,
  `int_capital` varchar(255) DEFAULT NULL,
  `Patronage` varchar(255) DEFAULT NULL,
  `Total` varchar(255) DEFAULT NULL,
  `Deduct` varchar(255) DEFAULT NULL,
  `NET_Dividend` varchar(255) DEFAULT NULL,
  KEY `member_id` (`member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dividend_2017`
--

CREATE TABLE IF NOT EXISTS `dividend_2017` (
  `member_id` bigint(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `bank` varchar(255) DEFAULT NULL,
  `company_id` varchar(255) DEFAULT NULL,
  `int_capital` varchar(255) DEFAULT NULL,
  `Patronage` varchar(255) DEFAULT NULL,
  `Total` varchar(255) DEFAULT NULL,
  `Deduct` varchar(255) DEFAULT NULL,
  `NET_Dividend` varchar(255) DEFAULT NULL,
  KEY `member_id` (`member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dividend_2018`
--

CREATE TABLE IF NOT EXISTS `dividend_2018` (
  `member_id` bigint(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `bank` varchar(255) DEFAULT NULL,
  `company_id` varchar(255) DEFAULT NULL,
  `int_capital` varchar(255) DEFAULT NULL,
  `Patronage` varchar(255) DEFAULT NULL,
  `Total` varchar(255) DEFAULT NULL,
  `Deduct` varchar(255) DEFAULT NULL,
  `NET_Dividend` varchar(255) DEFAULT NULL,
  KEY `member_id` (`member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dividend_2019`
--

CREATE TABLE IF NOT EXISTS `dividend_2019` (
  `member_id` bigint(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `bank` varchar(255) DEFAULT NULL,
  `company_id` varchar(255) DEFAULT NULL,
  `int_capital` varchar(255) DEFAULT NULL,
  `Patronage` varchar(255) DEFAULT NULL,
  `Total` varchar(255) DEFAULT NULL,
  `Deduct` varchar(255) DEFAULT NULL,
  `NET_Dividend` varchar(255) DEFAULT NULL,
  KEY `member_id` (`member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `email_allPLDT042618`
--

CREATE TABLE IF NOT EXISTS `email_allPLDT042618` (
  `id` int(11) DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL,
  `NAME` tinytext,
  `mem_email` varchar(255) DEFAULT NULL,
  `company_name` tinytext,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `email_masterlist(new)`
--

CREATE TABLE IF NOT EXISTS `email_masterlist(new)` (
  `id` smallint(6) DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL,
  `mem_emp_id` varchar(50) DEFAULT NULL,
  `mem_emp_id2` varchar(50) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `email_ads` varchar(255) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `status` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `form_ctrl`
--

CREATE TABLE IF NOT EXISTS `form_ctrl` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `member_id` int(255) DEFAULT NULL,
  `form_no` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `member_questions`
--

CREATE TABLE IF NOT EXISTS `member_questions` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `member_id` bigint(20) DEFAULT NULL,
  `question_id` bigint(20) DEFAULT NULL,
  `question` text,
  `answer` text,
  `date_added` date DEFAULT NULL,
  `date_updated` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12840 ;

-- --------------------------------------------------------

--
-- Table structure for table `member_sys_access`
--

CREATE TABLE IF NOT EXISTS `member_sys_access` (
  `mem_access_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `member_id` bigint(6) unsigned zerofill DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email_add` varchar(255) DEFAULT NULL,
  `mobile_no` bigint(255) DEFAULT NULL,
  `is_notify_sms` varchar(255) DEFAULT NULL,
  `access_levels` varchar(255) DEFAULT NULL,
  `access_status` varchar(255) DEFAULT NULL,
  `date_register` date DEFAULT NULL,
  `date_approved` date DEFAULT NULL,
  `approved_by` varchar(255) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `last_login_mobile` datetime DEFAULT NULL,
  `is_validated` varchar(255) DEFAULT NULL,
  `is_change_password` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`mem_access_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10478 ;

-- --------------------------------------------------------

--
-- Table structure for table `member_sys_access-09-28`
--

CREATE TABLE IF NOT EXISTS `member_sys_access-09-28` (
  `mem_access_id` int(11) DEFAULT NULL,
  `member_id` bigint(20) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email_add` varchar(255) DEFAULT NULL,
  `mobile_no` bigint(20) DEFAULT NULL,
  `is_notify_sms` int(11) DEFAULT NULL,
  `access_levels` int(11) DEFAULT NULL,
  `access_status` int(11) DEFAULT NULL,
  `date_register` date DEFAULT NULL,
  `date_approved` date DEFAULT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `is_validated` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `member_sys_access1`
--

CREATE TABLE IF NOT EXISTS `member_sys_access1` (
  `mem_access_id` varchar(255) DEFAULT NULL,
  `member_id` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email_add` varchar(255) DEFAULT NULL,
  `mobile_no` bigint(255) DEFAULT NULL,
  `is_notify_sms` varchar(255) DEFAULT NULL,
  `access_levels` varchar(255) DEFAULT NULL,
  `access_status` varchar(255) DEFAULT NULL,
  `date_register` date DEFAULT NULL,
  `date_approved` date DEFAULT NULL,
  `approved_by` varchar(255) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `is_validated` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `member_sys_access2`
--

CREATE TABLE IF NOT EXISTS `member_sys_access2` (
  `mem_access_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `member_id` bigint(20) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email_add` varchar(100) DEFAULT NULL,
  `mobile_no` varchar(100) DEFAULT NULL,
  `is_notify_sms` tinyint(5) DEFAULT '0',
  `access_levels` tinyint(4) NOT NULL,
  `access_status` tinyint(4) NOT NULL,
  `date_register` date DEFAULT NULL,
  `date_approved` date DEFAULT NULL,
  `approved_by` varchar(100) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `is_validated` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`mem_access_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2392 ;

-- --------------------------------------------------------

--
-- Table structure for table `member_sys_access_20160408`
--

CREATE TABLE IF NOT EXISTS `member_sys_access_20160408` (
  `mem_access_id` varchar(255) DEFAULT NULL,
  `member_id` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email_add` varchar(255) DEFAULT NULL,
  `mobile_no` bigint(255) DEFAULT NULL,
  `is_notify_sms` varchar(255) DEFAULT NULL,
  `access_levels` varchar(255) DEFAULT NULL,
  `access_status` varchar(255) DEFAULT NULL,
  `date_register` date DEFAULT NULL,
  `date_approved` date DEFAULT NULL,
  `approved_by` varchar(255) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `is_validated` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `member_sys_access_20161123`
--

CREATE TABLE IF NOT EXISTS `member_sys_access_20161123` (
  `mem_access_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `member_id` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email_add` varchar(255) DEFAULT NULL,
  `mobile_no` bigint(255) DEFAULT NULL,
  `is_notify_sms` varchar(255) DEFAULT NULL,
  `access_levels` varchar(255) DEFAULT NULL,
  `access_status` varchar(255) DEFAULT NULL,
  `date_register` date DEFAULT NULL,
  `date_approved` date DEFAULT NULL,
  `approved_by` varchar(255) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `last_login_mobile` datetime DEFAULT NULL,
  `is_validated` varchar(255) DEFAULT NULL,
  `is_change_password` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`mem_access_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3314 ;

-- --------------------------------------------------------

--
-- Table structure for table `member_sys_access_20170216`
--

CREATE TABLE IF NOT EXISTS `member_sys_access_20170216` (
  `mem_access_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `member_id` bigint(6) unsigned zerofill DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email_add` varchar(255) DEFAULT NULL,
  `mobile_no` bigint(255) DEFAULT NULL,
  `is_notify_sms` varchar(255) DEFAULT NULL,
  `access_levels` varchar(255) DEFAULT NULL,
  `access_status` varchar(255) DEFAULT NULL,
  `date_register` date DEFAULT NULL,
  `date_approved` date DEFAULT NULL,
  `approved_by` varchar(255) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `last_login_mobile` datetime DEFAULT NULL,
  `is_validated` varchar(255) DEFAULT NULL,
  `is_change_password` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`mem_access_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3949 ;

-- --------------------------------------------------------

--
-- Table structure for table `member_sys_access_20170719`
--

CREATE TABLE IF NOT EXISTS `member_sys_access_20170719` (
  `mem_access_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `member_id` bigint(6) unsigned zerofill DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email_add` varchar(255) DEFAULT NULL,
  `mobile_no` bigint(255) DEFAULT NULL,
  `is_notify_sms` varchar(255) DEFAULT NULL,
  `access_levels` varchar(255) DEFAULT NULL,
  `access_status` varchar(255) DEFAULT NULL,
  `date_register` date DEFAULT NULL,
  `date_approved` date DEFAULT NULL,
  `approved_by` varchar(255) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `last_login_mobile` datetime DEFAULT NULL,
  `is_validated` varchar(255) DEFAULT NULL,
  `is_change_password` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`mem_access_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4115 ;

-- --------------------------------------------------------

--
-- Table structure for table `member_sys_inquiry`
--

CREATE TABLE IF NOT EXISTS `member_sys_inquiry` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `member_id` bigint(20) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `date_added` datetime NOT NULL,
  `status` int(10) NOT NULL DEFAULT '0' COMMENT '0=unread; 1=read',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1901 ;

-- --------------------------------------------------------

--
-- Table structure for table `ozekimessagein`
--

CREATE TABLE IF NOT EXISTS `ozekimessagein` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender` varchar(30) DEFAULT NULL,
  `receiver` varchar(30) DEFAULT NULL,
  `msg` varchar(160) DEFAULT NULL,
  `senttime` varchar(100) DEFAULT NULL,
  `receivedtime` varchar(100) DEFAULT NULL,
  `operator` varchar(100) DEFAULT NULL,
  `msgtype` varchar(160) DEFAULT NULL,
  `reference` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Table structure for table `ozekimessageout`
--

CREATE TABLE IF NOT EXISTS `ozekimessageout` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender` varchar(30) DEFAULT NULL,
  `receiver` varchar(30) DEFAULT NULL,
  `msg` text,
  `senttime` varchar(100) DEFAULT NULL,
  `receivedtime` varchar(100) DEFAULT NULL,
  `reference` varchar(100) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `msgtype` varchar(160) DEFAULT NULL,
  `operator` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=309 ;

-- --------------------------------------------------------

--
-- Table structure for table `products_services`
--

CREATE TABLE IF NOT EXISTS `products_services` (
  `ps_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `ps_name` varchar(100) DEFAULT NULL,
  `ps_title` varchar(100) DEFAULT NULL,
  `ps_description` text,
  `ps_img_url` varchar(300) DEFAULT NULL,
  `ps_details` text,
  `ps_type` int(2) DEFAULT NULL,
  `ps_datetime` datetime DEFAULT NULL,
  `ps_status` tinyint(1) DEFAULT '1',
  `is_new` tinyint(1) DEFAULT '0',
  `promo_end_date` date DEFAULT NULL,
  PRIMARY KEY (`ps_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=181 ;

-- --------------------------------------------------------

--
-- Table structure for table `products_services_copy`
--

CREATE TABLE IF NOT EXISTS `products_services_copy` (
  `ps_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `ps_name` varchar(100) DEFAULT NULL,
  `ps_title` varchar(100) DEFAULT NULL,
  `ps_description` text,
  `ps_img_url` varchar(300) DEFAULT NULL,
  `ps_details` text,
  `ps_type` int(2) DEFAULT NULL,
  `ps_datetime` datetime DEFAULT NULL,
  `ps_status` tinyint(1) DEFAULT '1',
  `is_new` tinyint(1) DEFAULT '0',
  `promo_end_date` date DEFAULT NULL,
  PRIMARY KEY (`ps_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=67 ;

-- --------------------------------------------------------

--
-- Table structure for table `smart_messagingsuite`
--

CREATE TABLE IF NOT EXISTS `smart_messagingsuite` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `member_id` int(255) DEFAULT NULL,
  `sender` varchar(255) DEFAULT NULL,
  `receiver` varchar(255) DEFAULT NULL,
  `message` varchar(255) DEFAULT NULL,
  `send_date_time` datetime DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4965 ;

-- --------------------------------------------------------

--
-- Table structure for table `update_logs`
--

CREATE TABLE IF NOT EXISTS `update_logs` (
  `update_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `member_id` bigint(6) unsigned zerofill DEFAULT NULL,
  `new_number` varchar(255) DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  PRIMARY KEY (`update_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17814 ;

-- --------------------------------------------------------

--
-- Table structure for table `val_attempt`
--

CREATE TABLE IF NOT EXISTS `val_attempt` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `member_id` int(255) DEFAULT NULL,
  `val_attempt` int(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=726 ;

-- --------------------------------------------------------

--
-- Table structure for table `xozekimessagein_20160520`
--

CREATE TABLE IF NOT EXISTS `xozekimessagein_20160520` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender` varchar(30) DEFAULT NULL,
  `receiver` varchar(30) DEFAULT NULL,
  `msg` varchar(160) DEFAULT NULL,
  `senttime` varchar(100) DEFAULT NULL,
  `receivedtime` varchar(100) DEFAULT NULL,
  `operator` varchar(100) DEFAULT NULL,
  `msgtype` varchar(160) DEFAULT NULL,
  `reference` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=157 ;

-- --------------------------------------------------------

--
-- Table structure for table `xozekimessageout_20160520`
--

CREATE TABLE IF NOT EXISTS `xozekimessageout_20160520` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender` varchar(30) DEFAULT NULL,
  `receiver` varchar(30) DEFAULT NULL,
  `msg` text,
  `senttime` varchar(100) DEFAULT NULL,
  `receivedtime` varchar(100) DEFAULT NULL,
  `reference` varchar(100) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `msgtype` varchar(160) DEFAULT NULL,
  `operator` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=114 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
