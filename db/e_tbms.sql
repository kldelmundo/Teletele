-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 21, 2020 at 01:35 PM
-- Server version: 5.5.22
-- PHP Version: 5.6.23-1+deprecated+dontuse+deb.sury.org~precise+1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `e_tbms20200610`
--
CREATE DATABASE `e_tbms20200610` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `e_tbms20200610`;

DELIMITER $$
--
-- Functions
--
CREATE DEFINER=`jeth`@`192.168.200.8` FUNCTION `acct_code`(`var` decimal(10,2)) RETURNS decimal(10,2)
    DETERMINISTIC
BEGIN

	RETURN
    CASE WHEN `var` IS NULL THEN 0 ELSE `var` END;


END$$

CREATE DEFINER=`jeth`@`192.168.200.8` FUNCTION `get_payment`(`var_member_id` bigint(20), `var_trans_id` int(10), `var_sales_id` bigint(20), `var_pay_period` date) RETURNS decimal(10,2)
    DETERMINISTIC
BEGIN
	
	DECLARE total_payment DECIMAL(10,2);
  SET total_payment = 0;

	IF var_sales_id IS NOT NULL THEN
		
		SELECT SUM(actual_payment) INTO total_payment
		FROM ar_loans_subs_detail
		LEFT JOIN ar_loans_header USING(sales_id)
		WHERE sales_id = var_sales_id
		AND po_order_status <> 'cancelled'
		AND pay_period = var_pay_period;
		#AND ( (pay_period = var_pay_period AND trans_date IS NULL)
		#OR  (pay_period = var_pay_period AND DATE(trans_date) = var_pay_period));

	ELSE
		
		SELECT SUM(actual_payment) INTO total_payment
		FROM ar_loans_subs_detail
		WHERE trans_id = var_trans_id
		#AND ( (pay_period = var_pay_period AND trans_date IS NULL)
		#OR  (pay_period = var_pay_period AND DATE(trans_date) = var_pay_period))
		AND member_id = var_member_id
		AND pay_period = var_pay_period

;

  END IF;

  RETURN total_payment;
    

END$$

CREATE DEFINER=`jeth`@`192.168.200.8` FUNCTION `zero`(`var` decimal(10,2)) RETURNS decimal(10,2)
    DETERMINISTIC
BEGIN

	RETURN
    CASE WHEN `var` IS NULL THEN 0 ELSE `var` END;


END$$

CREATE DEFINER=`jeth`@`192.168.200.8` FUNCTION `zero_max`(`var` decimal(10,2)) RETURNS decimal(10,2)
    DETERMINISTIC
BEGIN

	RETURN
    CASE WHEN `var` IS NULL THEN 0 ELSE `var` END;


END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `Teamcom`
--

CREATE TABLE IF NOT EXISTS `Teamcom` (
  `count` int(50) NOT NULL AUTO_INCREMENT,
  `subs_id` int(50) NOT NULL,
  `member_id` int(50) NOT NULL,
  `deduct_bal` int(50) NOT NULL,
  `deduct_def` int(50) NOT NULL,
  `balance` float(50,2) NOT NULL,
  `deferred` float(50,2) NOT NULL,
  PRIMARY KEY (`count`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=63548 ;

-- --------------------------------------------------------

--
-- Table structure for table `ar_collections_d`
--

CREATE TABLE IF NOT EXISTS `ar_collections_d` (
  `d_collection_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `collection_id` bigint(20) DEFAULT NULL,
  `member_id` bigint(20) DEFAULT NULL,
  `emp_id` varchar(20) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `status_d` varchar(255) DEFAULT NULL,
  `over_payment` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`d_collection_id`),
  KEY `collection_id` (`collection_id`),
  KEY `member_id` (`member_id`),
  KEY `emp_id` (`emp_id`),
  KEY `status_d` (`status_d`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1031231 ;

-- --------------------------------------------------------

--
-- Table structure for table `ar_collections_h`
--

CREATE TABLE IF NOT EXISTS `ar_collections_h` (
  `collection_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `file_name` varchar(255) DEFAULT NULL,
  `payroll_date` date DEFAULT NULL,
  `company_id` varchar(255) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `added_by` varchar(255) DEFAULT NULL,
  `payment_type` int(11) DEFAULT NULL COMMENT '0=regular payroll,1=final pay,2=mpl accounts, 3=from dividend',
  `status` varchar(255) DEFAULT NULL,
  `entries_logs` text,
  PRIMARY KEY (`collection_id`),
  KEY `payroll_date` (`payroll_date`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2221 ;

-- --------------------------------------------------------

--
-- Table structure for table `ar_loans_approval`
--

CREATE TABLE IF NOT EXISTS `ar_loans_approval` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `sales_id` bigint(20) DEFAULT NULL,
  `process_id` bigint(20) DEFAULT NULL,
  `process_lvl` varchar(255) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `acted_by` varchar(255) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `process_remarks` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sales_id` (`sales_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=719517 ;

-- --------------------------------------------------------

--
-- Table structure for table `ar_loans_billing`
--

CREATE TABLE IF NOT EXISTS `ar_loans_billing` (
  `billing_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `billing_date` datetime DEFAULT NULL,
  `format_id` int(11) DEFAULT NULL,
  `companies` text,
  `emp_levels` text,
  `file_name` varchar(255) DEFAULT NULL,
  `file_name_d` varchar(255) DEFAULT NULL,
  `pay_period` date DEFAULT NULL,
  `account_type` int(11) DEFAULT NULL COMMENT '1=Payroll Accounts; 3=MPL Accounts',
  `total_billed` decimal(15,2) DEFAULT NULL,
  `generated_by` text,
  PRIMARY KEY (`billing_id`),
  UNIQUE KEY `file_name` (`file_name`),
  KEY `format_id` (`format_id`),
  KEY `pay_period` (`pay_period`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2444 ;

-- --------------------------------------------------------

--
-- Table structure for table `ar_loans_coln_types`
--

CREATE TABLE IF NOT EXISTS `ar_loans_coln_types` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `member_id` bigint(20) unsigned NOT NULL,
  `sales_id` bigint(45) NOT NULL,
  `deduction_type` tinyint(3) unsigned NOT NULL COMMENT '1=payroll; 2=payroll; 3=bonuses',
  `date_append` datetime NOT NULL,
  `username` varchar(45) DEFAULT NULL,
  `requested_by` varchar(45) DEFAULT NULL,
  `remarks` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=88 ;

-- --------------------------------------------------------

--
-- Table structure for table `ar_loans_coln_types_history`
--

CREATE TABLE IF NOT EXISTS `ar_loans_coln_types_history` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `member_id` bigint(20) unsigned NOT NULL,
  `sales_id` bigint(45) NOT NULL,
  `old_deduction_type` tinyint(3) unsigned NOT NULL COMMENT '1=payroll; 2=payroll; 3=bonuses',
  `new_deduction_type` tinyint(3) NOT NULL,
  `username` varchar(45) DEFAULT NULL,
  `requested_by` varchar(45) DEFAULT NULL,
  `remarks` text,
  `date_append` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=81 ;

-- --------------------------------------------------------

--
-- Table structure for table `ar_loans_comakers`
--

CREATE TABLE IF NOT EXISTS `ar_loans_comakers` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `sales_id` bigint(255) NOT NULL,
  `ctr_number` int(11) NOT NULL,
  `member_id` bigint(6) unsigned zerofill NOT NULL,
  `maker_id` bigint(6) unsigned zerofill NOT NULL,
  `date_added` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `member_id` (`member_id`),
  KEY `sales_id` (`sales_id`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=993958 ;

-- --------------------------------------------------------

--
-- Table structure for table `ar_loans_deductions`
--

CREATE TABLE IF NOT EXISTS `ar_loans_deductions` (
  `deduction_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `sales_id` bigint(20) DEFAULT NULL,
  `dedn_sales_id` bigint(20) DEFAULT NULL,
  `trans_id` int(11) DEFAULT NULL,
  `pay_period` date DEFAULT NULL,
  `deduction_type` int(11) DEFAULT NULL COMMENT '1=deferred; 2=end_balance;3=required scs',
  `deduction_amt` decimal(10,2) DEFAULT NULL,
  `rebate` decimal(10,2) DEFAULT NULL,
  `date_added` date DEFAULT NULL,
  `date_applied` datetime DEFAULT NULL,
  PRIMARY KEY (`deduction_id`),
  KEY `sales_id` (`sales_id`),
  KEY `trans_id` (`trans_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=164149 ;

-- --------------------------------------------------------

--
-- Table structure for table `ar_loans_detail`
--

CREATE TABLE IF NOT EXISTS `ar_loans_detail` (
  `sales_detail_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `sales_id` bigint(10) unsigned DEFAULT NULL,
  `item_id` bigint(20) DEFAULT NULL,
  `item_detail_id` varchar(50) DEFAULT NULL,
  `unit_cost` float(10,2) DEFAULT '0.00',
  `acq_cost` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) DEFAULT '0.00',
  `serial_number` varchar(255) DEFAULT NULL,
  `qty` smallint(6) DEFAULT '1',
  `type` tinyint(1) DEFAULT '0' COMMENT '1=loans;2=item with stock;3=item with non stock;4=GC;5=insurance',
  `i_desc` varchar(255) DEFAULT NULL,
  `warranty` tinyint(2) NOT NULL DEFAULT '0' COMMENT 'warranty in months',
  `agent_id` varchar(255) DEFAULT NULL,
  `location` text,
  `released_by` text,
  PRIMARY KEY (`sales_detail_id`),
  KEY `sales_id` (`sales_id`),
  KEY `item_code` (`item_detail_id`),
  KEY `serial_number` (`serial_number`),
  KEY `type` (`type`),
  KEY `item_detail_id` (`item_detail_id`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=482496 ;

-- --------------------------------------------------------

--
-- Table structure for table `ar_loans_header`
--

CREATE TABLE IF NOT EXISTS `ar_loans_header` (
  `sales_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `po_number` varchar(255) DEFAULT NULL,
  `po_date` date DEFAULT NULL,
  `dr_number` varchar(255) DEFAULT NULL,
  `delivery_receipt` varchar(255) DEFAULT NULL,
  `member_id` bigint(20) DEFAULT NULL,
  `prod_id` varchar(255) DEFAULT NULL,
  `collection_type` int(11) DEFAULT NULL COMMENT '1=Regular Payroll; 2=Thru OR/PDC; 3=Bonuses',
  `supplier_code` varchar(255) DEFAULT NULL,
  `down_payment` decimal(10,2) DEFAULT NULL,
  `net_proceeds` decimal(10,2) DEFAULT NULL,
  `gross_amount` decimal(10,2) DEFAULT NULL,
  `current` decimal(10,2) DEFAULT NULL,
  `non_current` decimal(10,2) DEFAULT NULL,
  `actual_amount` decimal(10,2) DEFAULT NULL,
  `income_recognition` int(11) DEFAULT NULL COMMENT '1=spread over terms; 2=point of sales; 3=with 1 year current, else spread',
  `interest` decimal(10,2) DEFAULT NULL,
  `interest_rate` decimal(6,6) DEFAULT NULL,
  `year_interest` decimal(10,2) DEFAULT NULL,
  `commission` decimal(10,2) DEFAULT NULL,
  `commission_rate` decimal(4,4) DEFAULT NULL,
  `insurance` decimal(10,2) DEFAULT NULL,
  `s_fee` decimal(10,2) DEFAULT NULL,
  `s_fee_rate` decimal(4,4) DEFAULT NULL,
  `sc_amort_months` int(5) DEFAULT NULL,
  `semi_amort_w_sc` decimal(10,2) DEFAULT NULL,
  `semi_amort_wo_sc` decimal(10,2) DEFAULT NULL,
  `moratorium` tinyint(1) DEFAULT NULL,
  `moratorium_months` int(2) DEFAULT NULL,
  `moratorium_interest` decimal(10,2) DEFAULT NULL,
  `po_start_date` date DEFAULT NULL,
  `po_end_date` date DEFAULT NULL,
  `monthly_amor` decimal(10,2) DEFAULT NULL,
  `semi_monthly_amor` decimal(10,2) DEFAULT NULL,
  `pay_terms` decimal(6,2) DEFAULT NULL,
  `release_type` tinyint(1) DEFAULT NULL,
  `po_status` tinyint(1) DEFAULT NULL COMMENT '1=noted; 2=verified; 3=recommended; 4=audited; 5=approved; 6=prepared',
  `po_order_status` varchar(20) DEFAULT NULL COMMENT 'approved; disapproved; cancelled;',
  `release_status` varchar(255) DEFAULT NULL COMMENT 'pending,preparation,audit,voucher,for_releasing,released',
  `remarks` varchar(255) DEFAULT NULL,
  `approved_date` date DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  PRIMARY KEY (`sales_id`),
  UNIQUE KEY `po_number` (`po_number`),
  UNIQUE KEY `dr_number` (`dr_number`),
  KEY `member_id` (`member_id`),
  KEY `collection_type` (`collection_type`),
  KEY `po_order_status` (`po_order_status`),
  KEY `approved_date` (`approved_date`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=866933 ;

-- --------------------------------------------------------

--
-- Table structure for table `ar_loans_interest_detail`
--

CREATE TABLE IF NOT EXISTS `ar_loans_interest_detail` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `sales_id` bigint(20) DEFAULT NULL,
  `pay_period` date DEFAULT NULL,
  `date_ctr` int(20) DEFAULT NULL,
  `interest_amount` decimal(10,2) DEFAULT NULL,
  `beg_bal` decimal(10,2) DEFAULT NULL,
  `interest_rebate` decimal(10,2) DEFAULT NULL,
  `semi_amort` decimal(10,2) DEFAULT NULL,
  `dedn_principal` decimal(10,2) DEFAULT NULL,
  `end_bal` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sales_id` (`sales_id`),
  KEY `date_ctr` (`date_ctr`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=979735 ;

-- --------------------------------------------------------

--
-- Table structure for table `ar_loans_online_detail`
--

CREATE TABLE IF NOT EXISTS `ar_loans_online_detail` (
  `online_detail_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `online_id` bigint(10) unsigned DEFAULT NULL,
  `item_id` bigint(20) DEFAULT NULL,
  `item_detail_id` varchar(50) DEFAULT NULL,
  `unit_cost` float(10,2) DEFAULT '0.00',
  `acq_cost` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) DEFAULT '0.00',
  `serial_number` varchar(255) DEFAULT NULL,
  `qty` smallint(6) DEFAULT '1',
  `type` tinyint(1) DEFAULT '0' COMMENT '1=loans;2=item with stock;3=item with non stock;4=GC;5=insurance',
  `i_desc` varchar(255) DEFAULT NULL,
  `warranty` tinyint(2) NOT NULL DEFAULT '0' COMMENT 'warranty in months',
  `agent_id` varchar(255) DEFAULT NULL,
  `location` text,
  `released_by` text,
  PRIMARY KEY (`online_detail_id`),
  KEY `sales_id` (`online_id`),
  KEY `item_code` (`item_detail_id`),
  KEY `serial_number` (`serial_number`),
  KEY `type` (`type`),
  KEY `item_detail_id` (`item_detail_id`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Table structure for table `ar_loans_online_header`
--

CREATE TABLE IF NOT EXISTS `ar_loans_online_header` (
  `online_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `sales_id` bigint(20) DEFAULT NULL,
  `po_date` date DEFAULT NULL,
  `delivery_receipt` varchar(255) DEFAULT NULL,
  `member_id` bigint(20) DEFAULT NULL,
  `prod_id` varchar(255) DEFAULT NULL,
  `collection_type` int(11) DEFAULT NULL COMMENT '1=Regular Payroll; 2=Thru OR/PDC; 3=Bonuses',
  `supplier_code` varchar(255) DEFAULT NULL,
  `down_payment` decimal(10,2) DEFAULT NULL,
  `net_proceeds` decimal(10,2) DEFAULT NULL,
  `gross_amount` decimal(10,2) DEFAULT NULL,
  `current` decimal(10,2) DEFAULT NULL,
  `non_current` decimal(10,2) DEFAULT NULL,
  `actual_amount` decimal(10,2) DEFAULT NULL,
  `income_recognition` int(11) DEFAULT NULL COMMENT '1=spread over terms; 2=point of sales; 3=with 1 year current, else spread',
  `interest` decimal(10,2) DEFAULT NULL,
  `interest_rate` decimal(6,6) DEFAULT NULL,
  `year_interest` decimal(10,2) DEFAULT NULL,
  `commission` decimal(10,2) DEFAULT NULL,
  `commission_rate` decimal(4,4) DEFAULT NULL,
  `insurance` decimal(10,2) DEFAULT NULL,
  `s_fee` decimal(10,2) DEFAULT NULL,
  `s_fee_rate` decimal(4,4) DEFAULT NULL,
  `sc_amort_months` int(5) DEFAULT NULL,
  `semi_amort_w_sc` decimal(10,2) DEFAULT NULL,
  `semi_amort_wo_sc` decimal(10,2) DEFAULT NULL,
  `moratorium` tinyint(1) DEFAULT NULL,
  `moratorium_months` int(2) DEFAULT NULL,
  `moratorium_interest` decimal(10,2) DEFAULT NULL,
  `po_start_date` date DEFAULT NULL,
  `po_end_date` date DEFAULT NULL,
  `monthly_amor` decimal(10,2) DEFAULT NULL,
  `semi_monthly_amor` decimal(10,2) DEFAULT NULL,
  `pay_terms` decimal(6,2) DEFAULT NULL,
  `release_type` tinyint(1) DEFAULT NULL,
  `po_status` tinyint(1) DEFAULT NULL COMMENT '1=noted; 2=verified; 3=recommended; 4=audited; 5=approved; 6=prepared',
  `po_order_status` varchar(20) DEFAULT NULL COMMENT 'approved; disapproved; cancelled;',
  `release_status` varchar(255) DEFAULT NULL COMMENT 'pending,preparation,audit,voucher,for_releasing,released',
  `remarks` varchar(255) DEFAULT NULL,
  `confirm_date` datetime DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `valid_until` datetime DEFAULT NULL,
  `cancel_until` datetime DEFAULT NULL,
  `cancel_date` datetime DEFAULT NULL,
  `valid_key` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`online_id`),
  KEY `member_id` (`member_id`),
  KEY `collection_type` (`collection_type`),
  KEY `po_order_status` (`po_order_status`),
  KEY `approved_date` (`confirm_date`),
  KEY `sales_id` (`sales_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1353 ;

--
-- Triggers `ar_loans_online_header`
--
DROP TRIGGER IF EXISTS `delete_online_detail`;
DELIMITER //
CREATE TRIGGER `delete_online_detail` AFTER DELETE ON `ar_loans_online_header`
 FOR EACH ROW BEGIN
        DELETE FROM ar_loans_online_detail WHERE OLD.online_id = online_id;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `ar_loans_subs_detail`
--

CREATE TABLE IF NOT EXISTS `ar_loans_subs_detail` (
  `subs_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `sales_id` bigint(20) DEFAULT NULL,
  `member_id` bigint(6) unsigned zerofill DEFAULT NULL,
  `trans_id` int(11) DEFAULT NULL,
  `po_number` varchar(255) DEFAULT NULL,
  `trans_date` datetime DEFAULT NULL,
  `beg_bal` decimal(10,2) DEFAULT NULL,
  `billing_dedn` decimal(10,2) DEFAULT NULL,
  `sched_dedn` decimal(10,2) DEFAULT NULL,
  `pay_period` date DEFAULT NULL,
  `semi_mo` decimal(10,2) DEFAULT NULL,
  `actual_payment` decimal(10,2) DEFAULT NULL,
  `deferred_amount` decimal(10,2) DEFAULT NULL,
  `end_bal` decimal(10,2) DEFAULT NULL,
  `trans_type` varchar(15) DEFAULT NULL COMMENT 'NEW, PAYROLL, OR, AR, FP, SAVINGS, SCS,  ADJ, RBT,OTH',
  `remarks` text,
  `billing_id` bigint(20) unsigned DEFAULT NULL,
  `collection_id` bigint(20) DEFAULT NULL,
  `posted_by` varchar(255) DEFAULT NULL,
  `posted_date` datetime DEFAULT NULL,
  PRIMARY KEY (`subs_id`),
  KEY `sales_id` (`sales_id`),
  KEY `po_number` (`po_number`),
  KEY `pay_period` (`pay_period`) USING BTREE,
  KEY `member_id` (`member_id`),
  KEY `payment_type` (`trans_type`),
  KEY `trans_id` (`trans_id`),
  KEY `billing_id` (`billing_id`),
  KEY `collection_id` (`collection_id`),
  KEY `trans_type` (`trans_type`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12371916 ;

-- --------------------------------------------------------

--
-- Table structure for table `ar_mpl_deductions`
--

CREATE TABLE IF NOT EXISTS `ar_mpl_deductions` (
  `mpl_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `member_id` bigint(20) DEFAULT NULL,
  `sales_id` bigint(20) DEFAULT NULL,
  `trans_id` int(11) DEFAULT NULL,
  `billing_dedn` decimal(10,2) DEFAULT NULL,
  `mpl_date` date DEFAULT NULL,
  `billing_id` bigint(20) DEFAULT NULL,
  `added_date` date DEFAULT NULL,
  `added_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`mpl_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29549 ;

-- --------------------------------------------------------

--
-- Table structure for table `ar_subs_forwardings`
--

CREATE TABLE IF NOT EXISTS `ar_subs_forwardings` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pay_period` date DEFAULT NULL,
  `forward_balance` tinyint(4) DEFAULT NULL,
  `forward_date` datetime DEFAULT NULL,
  `cf_payroll` tinyint(4) DEFAULT NULL,
  `cf_payroll_date` datetime DEFAULT NULL,
  `cf_pdc` tinyint(4) DEFAULT NULL,
  `cf_pdc_date` datetime DEFAULT NULL,
  `int_generate` tinyint(4) DEFAULT NULL,
  `int_generate_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=116 ;

-- --------------------------------------------------------

--
-- Table structure for table `ar_subs_overpayment_d`
--

CREATE TABLE IF NOT EXISTS `ar_subs_overpayment_d` (
  `detail_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `over_id` bigint(20) DEFAULT NULL,
  `trans_id` int(11) DEFAULT NULL,
  `sales_id` bigint(20) DEFAULT NULL,
  `over_amt` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`detail_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21865 ;

-- --------------------------------------------------------

--
-- Table structure for table `ar_subs_overpayment_h`
--

CREATE TABLE IF NOT EXISTS `ar_subs_overpayment_h` (
  `over_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `member_id` bigint(20) DEFAULT NULL,
  `pay_period` date DEFAULT NULL,
  `collection_id` bigint(20) DEFAULT NULL,
  `overpayment` decimal(10,2) DEFAULT NULL,
  `status` text COMMENT 'Park, Applied, Refunded',
  `date_posted` datetime DEFAULT NULL,
  `posted_by` text,
  PRIMARY KEY (`over_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7939 ;

--
-- Triggers `ar_subs_overpayment_h`
--
DROP TRIGGER IF EXISTS `ar_subs_overpayment_h`;
DELIMITER //
CREATE TRIGGER `ar_subs_overpayment_h` BEFORE DELETE ON `ar_subs_overpayment_h`
 FOR EACH ROW BEGIN
        DELETE FROM ar_subs_overpayment_d WHERE OLD.over_id = over_id;
    END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `audit_trail`
--

CREATE TABLE IF NOT EXISTS `audit_trail` (
  `audit_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `table` varchar(255) DEFAULT NULL,
  `action` text,
  `user_id` bigint(20) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `ip_address` varchar(100) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `key_action` varchar(45) NOT NULL,
  `module` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`audit_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=809289 ;

-- --------------------------------------------------------

--
-- Table structure for table `e_raffle`
--

CREATE TABLE IF NOT EXISTS `e_raffle` (
  `winner_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` bigint(20) DEFAULT NULL,
  `member_name` varchar(255) DEFAULT NULL,
  `po_number` varchar(255) DEFAULT NULL,
  `place` int(255) DEFAULT NULL,
  PRIMARY KEY (`winner_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

--
-- Table structure for table `gc_test`
--

CREATE TABLE IF NOT EXISTS `gc_test` (
  `item_detail_id` int(255) DEFAULT NULL,
  `item_id` int(255) DEFAULT NULL,
  `order_id` int(255) DEFAULT NULL,
  `po_detail_id` int(255) DEFAULT NULL,
  `acq_cost` float(255,0) DEFAULT NULL,
  `unit_cost` float(255,0) DEFAULT NULL,
  `serial_series` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `date_acquired` date DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `item_flag` varchar(255) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `inv_detailed_history`
--

CREATE TABLE IF NOT EXISTS `inv_detailed_history` (
  `trans_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `item_detail_id` varchar(255) DEFAULT NULL,
  `transaction` varchar(255) DEFAULT NULL,
  `trans_date` date DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `sales_id` varchar(255) DEFAULT NULL,
  `dr_supplier` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`trans_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=728501 ;

-- --------------------------------------------------------

--
-- Table structure for table `inv_gatepass_d`
--

CREATE TABLE IF NOT EXISTS `inv_gatepass_d` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `gp_id` bigint(20) DEFAULT NULL,
  `item_id` bigint(20) DEFAULT NULL,
  `item_detail_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=219216 ;

-- --------------------------------------------------------

--
-- Table structure for table `inv_gatepass_h`
--

CREATE TABLE IF NOT EXISTS `inv_gatepass_h` (
  `gp_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `gp_number` varchar(20) DEFAULT NULL,
  `gp_date` datetime DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `agent_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`gp_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7106 ;

-- --------------------------------------------------------

--
-- Table structure for table `inv_item_detail`
--

CREATE TABLE IF NOT EXISTS `inv_item_detail` (
  `item_detail_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `item_id` bigint(20) DEFAULT NULL,
  `order_id` bigint(20) DEFAULT NULL,
  `po_detail_id` bigint(20) DEFAULT NULL,
  `acq_cost` decimal(10,2) DEFAULT NULL,
  `unit_cost` decimal(10,2) DEFAULT NULL,
  `serial_series` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `date_acquired` date DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `item_flag` varchar(255) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`item_detail_id`),
  KEY `serial_series` (`serial_series`),
  KEY `po_detail_id` (`po_detail_id`),
  KEY `order_id` (`order_id`),
  KEY `item_id` (`item_id`),
  KEY `status` (`status`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=185506 ;

-- --------------------------------------------------------

--
-- Table structure for table `inv_item_requisition_d`
--

CREATE TABLE IF NOT EXISTS `inv_item_requisition_d` (
  `item_req_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `inv_req_trans_no` bigint(20) DEFAULT NULL,
  `item_detail_id` bigint(20) DEFAULT NULL,
  `supplier_id` varchar(255) DEFAULT NULL,
  `acq_cost` decimal(10,0) DEFAULT NULL,
  `qty` bigint(20) DEFAULT NULL,
  `total_cost` decimal(10,2) DEFAULT NULL,
  `return_date` date DEFAULT NULL,
  `return_number` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`item_req_id`),
  KEY `inv_req_trans_no` (`inv_req_trans_no`),
  KEY `item_detail_id` (`item_detail_id`),
  KEY `supplier_id` (`supplier_id`),
  KEY `return_number` (`return_number`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=390457 ;

-- --------------------------------------------------------

--
-- Table structure for table `inv_item_requisition_h`
--

CREATE TABLE IF NOT EXISTS `inv_item_requisition_h` (
  `inv_req_trans_no` bigint(20) NOT NULL AUTO_INCREMENT,
  `agent_id` varchar(25) NOT NULL,
  `inv_req_date` date NOT NULL,
  `inv_req_exchange` varchar(25) NOT NULL,
  `posted_by` varchar(25) DEFAULT NULL,
  `post_date` datetime DEFAULT NULL,
  `total_qty` int(11) DEFAULT NULL,
  `total_cost` decimal(10,2) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`inv_req_trans_no`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5847 ;

-- --------------------------------------------------------

--
-- Table structure for table `inv_items_supplied`
--

CREATE TABLE IF NOT EXISTS `inv_items_supplied` (
  `supplied_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `supplier_id` varchar(20) DEFAULT NULL,
  `item_code` varchar(255) DEFAULT NULL,
  `acq_cost` decimal(10,2) NOT NULL,
  PRIMARY KEY (`supplied_id`),
  KEY `supplier_id` (`supplier_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=858 ;

-- --------------------------------------------------------

--
-- Table structure for table `inv_payment_terms`
--

CREATE TABLE IF NOT EXISTS `inv_payment_terms` (
  `term_id` int(11) NOT NULL AUTO_INCREMENT,
  `term_name` varchar(50) NOT NULL,
  PRIMARY KEY (`term_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Table structure for table `inv_po_detail`
--

CREATE TABLE IF NOT EXISTS `inv_po_detail` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) DEFAULT NULL,
  `item_id` varchar(20) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `warranty` bigint(20) DEFAULT NULL COMMENT 'month/s',
  `free` tinyint(4) DEFAULT NULL COMMENT 'yes or no 1:0',
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3744 ;

-- --------------------------------------------------------

--
-- Table structure for table `inv_po_header`
--

CREATE TABLE IF NOT EXISTS `inv_po_header` (
  `order_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `category` varchar(255) DEFAULT NULL,
  `po_number` varchar(255) DEFAULT NULL,
  `dr_number` varchar(255) DEFAULT NULL,
  `consign_number` varchar(255) DEFAULT NULL,
  `po_date` date DEFAULT NULL,
  `supplier_id` varchar(255) DEFAULT NULL,
  `total_qty` int(11) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `remarks` text,
  `status` varchar(255) DEFAULT NULL,
  `delivery_status` varchar(50) DEFAULT NULL,
  `date_prepared` datetime DEFAULT NULL,
  `prepared_by` varchar(255) DEFAULT NULL,
  `approved_by` varchar(255) DEFAULT NULL,
  `received_by` varchar(100) DEFAULT NULL,
  `date_received` date DEFAULT NULL,
  `received_remarks` varchar(100) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`order_id`),
  UNIQUE KEY `po_number` (`po_number`) USING BTREE,
  UNIQUE KEY `dr_number` (`dr_number`),
  KEY `supplier_id` (`supplier_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1480 ;

-- --------------------------------------------------------

--
-- Table structure for table `inv_price_history`
--

CREATE TABLE IF NOT EXISTS `inv_price_history` (
  `inv_ph_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `item_code` varchar(20) DEFAULT NULL,
  `date_time` datetime DEFAULT NULL,
  `old_price` decimal(10,2) DEFAULT NULL,
  `new_price` decimal(10,2) DEFAULT NULL,
  `change_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`inv_ph_id`),
  KEY `supplied_id` (`item_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1381 ;

-- --------------------------------------------------------

--
-- Table structure for table `inv_prod_items`
--

CREATE TABLE IF NOT EXISTS `inv_prod_items` (
  `item_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `item_code` varchar(50) NOT NULL,
  `category_id` smallint(3) unsigned NOT NULL,
  `item_status_id` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1=active, 2=pull out, 3=phase out',
  `item_short_desc` varchar(100) NOT NULL,
  `item_long_desc` varchar(255) NOT NULL,
  `specs` text,
  `on_hand` int(11) NOT NULL DEFAULT '0',
  `unit_cost` decimal(10,2) NOT NULL,
  `item_flag` varchar(15) NOT NULL DEFAULT '' COMMENT 'serial; series; none',
  `gc_category` varchar(255) DEFAULT NULL,
  `picture` text,
  PRIMARY KEY (`item_id`),
  KEY `item_status_id` (`item_status_id`),
  KEY `gc_category` (`gc_category`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='coop items' AUTO_INCREMENT=539 ;

-- --------------------------------------------------------

--
-- Table structure for table `inv_returns_detail`
--

CREATE TABLE IF NOT EXISTS `inv_returns_detail` (
  `return_detail_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `return_number` bigint(20) NOT NULL,
  `item_id` bigint(20) DEFAULT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `item_detail_id` bigint(20) DEFAULT NULL,
  `returned` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL COMMENT 'fixed or replaced ; for return to member',
  `remarks` varchar(255) DEFAULT NULL COMMENT 'remarks for return to member',
  PRIMARY KEY (`return_detail_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=191754 ;

-- --------------------------------------------------------

--
-- Table structure for table `inv_returns_header`
--

CREATE TABLE IF NOT EXISTS `inv_returns_header` (
  `return_number` mediumint(5) unsigned NOT NULL AUTO_INCREMENT,
  `return_date` date NOT NULL,
  `sales_id` varchar(25) DEFAULT NULL COMMENT 'ar_loans_header sales_id',
  `dr_number` varchar(255) DEFAULT NULL,
  `supplier_id` varchar(25) DEFAULT NULL,
  `agent_id` bigint(20) DEFAULT NULL,
  `posted_by` varchar(25) NOT NULL,
  `posted_date` date NOT NULL,
  `total_cost` decimal(10,2) unsigned NOT NULL COMMENT 'if return by sa = total cost of sold; return by member = cost of item returned;   ',
  `return_type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`return_number`),
  KEY `member_id` (`sales_id`),
  KEY `dr_number` (`dr_number`),
  KEY `supplier_id` (`supplier_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11939 ;

-- --------------------------------------------------------

--
-- Table structure for table `inv_sup_price_history`
--

CREATE TABLE IF NOT EXISTS `inv_sup_price_history` (
  `price_his_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `supplied_id` bigint(20) DEFAULT NULL,
  `date_time` datetime DEFAULT NULL,
  `old_price` decimal(10,2) DEFAULT NULL,
  `new_price` decimal(10,2) DEFAULT NULL,
  `change_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`price_his_id`),
  KEY `supplied_id` (`supplied_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `inv_suppliers`
--

CREATE TABLE IF NOT EXISTS `inv_suppliers` (
  `supplier_id` varchar(25) NOT NULL,
  `supplier_name` varchar(100) DEFAULT NULL,
  `payee_name` varchar(100) DEFAULT NULL,
  `supplier_address` text,
  `supplier_contact_person` varchar(100) DEFAULT NULL,
  `supplier_telno` varchar(30) DEFAULT NULL,
  `supplier_faxno` varchar(30) DEFAULT NULL,
  `supplier_email` varchar(100) DEFAULT NULL,
  `term_id` smallint(1) unsigned NOT NULL,
  `supplier_status` varchar(1) NOT NULL,
  `supplier_stat_rem` varchar(255) DEFAULT NULL,
  `created_by` varchar(20) DEFAULT 'sa',
  `date_created` datetime NOT NULL,
  `updated_by` varchar(20) DEFAULT 'sa',
  `date_updated` datetime NOT NULL,
  `supplier_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1=A,2=NA',
  `is_travel_loan` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '0=no; 1=yes',
  `commission_pct` int(11) DEFAULT NULL,
  PRIMARY KEY (`supplier_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `inv_transaction_history`
--

CREATE TABLE IF NOT EXISTS `inv_transaction_history` (
  `trans_his_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `item_id` bigint(20) NOT NULL,
  `trans_type` varchar(255) DEFAULT NULL,
  `trans_date` datetime DEFAULT NULL,
  `ref_no` varchar(255) DEFAULT NULL,
  `beg_quantity` bigint(20) NOT NULL DEFAULT '0',
  `quantity` bigint(20) NOT NULL DEFAULT '0',
  `stock_on_hand` bigint(20) NOT NULL DEFAULT '0',
  `category` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`trans_his_id`),
  KEY `id` (`item_id`),
  KEY `category_id` (`category`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31073 ;

-- --------------------------------------------------------

--
-- Table structure for table `inv_uom`
--

CREATE TABLE IF NOT EXISTS `inv_uom` (
  `uom_id` smallint(3) unsigned NOT NULL AUTO_INCREMENT,
  `uom_name` varchar(10) NOT NULL,
  PRIMARY KEY (`uom_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Table structure for table `loan_emailer`
--

CREATE TABLE IF NOT EXISTS `loan_emailer` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `member_id` bigint(20) DEFAULT NULL,
  `po_number` varchar(50) DEFAULT NULL,
  `net_proceeds` decimal(10,2) DEFAULT NULL,
  `email_ads` varchar(100) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=52004 ;

-- --------------------------------------------------------

--
-- Table structure for table `mem_account`
--

CREATE TABLE IF NOT EXISTS `mem_account` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `account_no` varchar(20) DEFAULT '',
  `bank_id` smallint(3) DEFAULT NULL,
  `member_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `account_no` (`account_no`),
  KEY `member_id` (`member_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15770 ;

-- --------------------------------------------------------

--
-- Table structure for table `mem_basic_pay`
--

CREATE TABLE IF NOT EXISTS `mem_basic_pay` (
  `emp_id` varchar(20) DEFAULT NULL,
  `basic_pay` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mem_basic_pay_copy1`
--

CREATE TABLE IF NOT EXISTS `mem_basic_pay_copy1` (
  `emp_id` varchar(20) DEFAULT NULL,
  `basic_pay` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mem_ben_rel`
--

CREATE TABLE IF NOT EXISTS `mem_ben_rel` (
  `member_id` bigint(20) unsigned DEFAULT NULL,
  `beneficiary_id` bigint(20) unsigned DEFAULT NULL,
  `rel_id` bigint(20) unsigned DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mem_beneficiaries`
--

CREATE TABLE IF NOT EXISTS `mem_beneficiaries` (
  `beneficiary_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ben_lname` varchar(150) NOT NULL,
  `ben_fname` varchar(255) DEFAULT NULL,
  `ben_affix` varchar(255) NOT NULL DEFAULT '',
  `beneficiary_bday` date NOT NULL,
  `is_member` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `member_id` int(11) DEFAULT NULL,
  `rel_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`beneficiary_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=111124 ;

-- --------------------------------------------------------

--
-- Table structure for table `mem_company_history`
--

CREATE TABLE IF NOT EXISTS `mem_company_history` (
  `company_his_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `member_id` bigint(20) DEFAULT NULL,
  `old_company` bigint(20) DEFAULT NULL,
  `new_company` bigint(20) DEFAULT NULL,
  `his_date` datetime DEFAULT NULL,
  PRIMARY KEY (`company_his_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2576 ;

-- --------------------------------------------------------

--
-- Table structure for table `mem_credit_limit`
--

CREATE TABLE IF NOT EXISTS `mem_credit_limit` (
  `cr_id` int(11) NOT NULL AUTO_INCREMENT,
  `los_from` int(11) DEFAULT NULL,
  `los_to` int(11) DEFAULT NULL,
  `credit_limit` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`cr_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `mem_emplevel`
--

CREATE TABLE IF NOT EXISTS `mem_emplevel` (
  `emp_level_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `emp_level` varchar(255) DEFAULT NULL,
  `max_billing_amt` decimal(20,2) DEFAULT NULL,
  `max_mpl_billing_amt` decimal(20,2) DEFAULT NULL,
  PRIMARY KEY (`emp_level_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `mem_final_pay_billing`
--

CREATE TABLE IF NOT EXISTS `mem_final_pay_billing` (
  `fp_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `member_id` bigint(20) unsigned NOT NULL,
  `type` int(11) DEFAULT NULL,
  `recipient` int(11) DEFAULT NULL,
  `from` bigint(20) DEFAULT NULL,
  `sa_date` date NOT NULL,
  `pay_period` date DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `created_by` varchar(100) DEFAULT ' ',
  `updated_by` varchar(100) DEFAULT ' ',
  `remarks` text,
  PRIMARY KEY (`fp_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1457 ;

-- --------------------------------------------------------

--
-- Table structure for table `mem_final_pay_billing_d`
--

CREATE TABLE IF NOT EXISTS `mem_final_pay_billing_d` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `fp_id` bigint(10) unsigned NOT NULL,
  `member_id` bigint(20) unsigned NOT NULL,
  `sales_id` bigint(20) DEFAULT NULL,
  `trans_id` bigint(20) DEFAULT NULL,
  `amount_billed` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21045 ;

-- --------------------------------------------------------

--
-- Table structure for table `mem_final_pay_comakers`
--

CREATE TABLE IF NOT EXISTS `mem_final_pay_comakers` (
  `detail_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id` bigint(20) NOT NULL,
  `sales_id` bigint(20) DEFAULT NULL,
  `member_id` bigint(10) DEFAULT NULL,
  `new_po_number` varchar(50) DEFAULT NULL,
  `comaker_share` decimal(10,2) DEFAULT NULL,
  `start_dedn` date DEFAULT NULL,
  `end_dedn` date DEFAULT NULL,
  `pay_terms` int(11) DEFAULT NULL,
  PRIMARY KEY (`detail_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=769 ;

-- --------------------------------------------------------

--
-- Table structure for table `mem_final_pay_detail`
--

CREATE TABLE IF NOT EXISTS `mem_final_pay_detail` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `fp_id` bigint(20) NOT NULL,
  `sort_order` int(10) DEFAULT NULL,
  `pay_period` date DEFAULT NULL,
  `sales_id` bigint(20) DEFAULT NULL,
  `trans_id` int(11) DEFAULT NULL,
  `cm_active` int(11) DEFAULT NULL,
  `beg_bal` decimal(10,2) DEFAULT NULL,
  `actual_payment` decimal(10,2) DEFAULT NULL,
  `rebate` decimal(10,2) DEFAULT NULL,
  `end_bal` decimal(10,2) DEFAULT NULL,
  `status_d` varchar(255) DEFAULT '' COMMENT 'pending; posted; for_comakers; transferred;',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4828 ;

-- --------------------------------------------------------

--
-- Table structure for table `mem_final_pay_header`
--

CREATE TABLE IF NOT EXISTS `mem_final_pay_header` (
  `fp_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `member_id` bigint(20) DEFAULT NULL,
  `resign_type` int(11) DEFAULT NULL,
  `fixed_deposit` decimal(10,2) DEFAULT NULL,
  `pay_period` date DEFAULT NULL,
  `tbp` decimal(10,2) DEFAULT NULL,
  `adv_tbp` decimal(10,2) DEFAULT NULL,
  `legal_fee` decimal(10,2) DEFAULT NULL,
  `rbp` decimal(10,2) DEFAULT NULL,
  `savings` decimal(10,2) DEFAULT NULL,
  `overpayment` decimal(10,2) DEFAULT NULL,
  `separation_pay` decimal(10,2) DEFAULT NULL,
  `date_added` date DEFAULT NULL,
  `status` text,
  `remarks` text,
  `prepared_by` varchar(255) DEFAULT NULL,
  `reviewed_by` varchar(255) DEFAULT NULL,
  `approved_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`fp_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1873 ;

-- --------------------------------------------------------

--
-- Table structure for table `mem_members`
--

CREATE TABLE IF NOT EXISTS `mem_members` (
  `member_id` bigint(6) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `company_id` bigint(20) DEFAULT NULL,
  `department_name` varchar(255) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `member_category` int(11) DEFAULT NULL COMMENT '1 - payroll; 2 - non payroll - continuous; 3 - resigned from coop; 4 - resigned from company; 5 - RIP; 6=non payroll - dependent',
  `mem_status_id` int(20) DEFAULT NULL COMMENT '1-pending,2-approve,3-disapprove',
  `mem_lname` varchar(255) DEFAULT NULL,
  `mem_fname` varchar(255) DEFAULT NULL,
  `mem_mname` varchar(255) DEFAULT NULL,
  `mem_bday` date DEFAULT NULL,
  `mem_birthplace` varchar(255) DEFAULT NULL,
  `mem_address` varchar(255) DEFAULT NULL,
  `zip_code` int(11) DEFAULT NULL,
  `mem_telno` varchar(255) DEFAULT NULL,
  `mem_off_telno` varchar(255) DEFAULT NULL,
  `mem_off_fax` varchar(255) DEFAULT NULL,
  `mem_hired_date` date DEFAULT NULL,
  `mem_emp_id` varchar(255) DEFAULT NULL,
  `mem_emp_id2` varchar(255) DEFAULT NULL,
  `mem_email` varchar(255) DEFAULT NULL,
  `mem_joined_date` date DEFAULT NULL,
  `mem_center` varchar(255) DEFAULT NULL,
  `mem_location` varchar(255) DEFAULT NULL,
  `mem_civil_stat` varchar(255) DEFAULT NULL,
  `mem_gender` varchar(255) DEFAULT NULL,
  `emp_level_id` bigint(11) DEFAULT NULL,
  `mem_spouse` varchar(255) DEFAULT NULL,
  `mem_remarks` varchar(255) DEFAULT NULL,
  `membership_fee` decimal(10,2) DEFAULT NULL,
  `scs_contrib` decimal(10,2) DEFAULT NULL,
  `tbp_contrib` decimal(10,2) DEFAULT NULL,
  `rbp_contrib` decimal(10,2) DEFAULT NULL,
  `approved_dt` date DEFAULT NULL,
  `dedn_start_dt` date DEFAULT NULL,
  `comp_resign_dt` date DEFAULT NULL,
  `member_dt_out` date DEFAULT NULL,
  `cont_start_date` date DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  `update_by` varchar(255) DEFAULT NULL,
  `deduct_from` bigint(6) DEFAULT NULL,
  `suspend` int(11) DEFAULT NULL,
  `is_confidential` int(11) DEFAULT NULL,
  `acct_remarks` varchar(100) DEFAULT NULL,
  `board_resolution_no` varchar(255) DEFAULT NULL,
  `board_resolution_no_out` varchar(255) DEFAULT NULL,
  `mem_tin_id` varchar(255) DEFAULT NULL,
  `is_officers` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`member_id`),
  KEY `company_id` (`company_id`),
  KEY `deduct_from` (`deduct_from`),
  KEY `member_category` (`member_category`),
  KEY `mem_status_id` (`mem_status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1000000 ;

-- --------------------------------------------------------

--
-- Table structure for table `mem_members_temp`
--

CREATE TABLE IF NOT EXISTS `mem_members_temp` (
  `temp_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `member_id` bigint(20) unsigned NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`temp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `mem_mrp_computation`
--

CREATE TABLE IF NOT EXISTS `mem_mrp_computation` (
  `mrp_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `member_id` bigint(6) unsigned zerofill DEFAULT NULL,
  `basic_pay` decimal(10,2) DEFAULT NULL,
  `mrp_rate` int(100) DEFAULT NULL,
  `los` int(100) DEFAULT NULL,
  `total_gross` decimal(10,2) DEFAULT NULL,
  `telescoop` decimal(10,2) DEFAULT NULL,
  `pecci` decimal(10,2) DEFAULT NULL,
  `tahanan` decimal(10,2) DEFAULT NULL,
  `new_loan` decimal(10,2) DEFAULT NULL,
  `total_ob` decimal(10,2) DEFAULT NULL,
  `total_net_mrp` decimal(10,2) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`mrp_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=165 ;

-- --------------------------------------------------------

--
-- Table structure for table `mem_mrp_rates`
--

CREATE TABLE IF NOT EXISTS `mem_mrp_rates` (
  `los_from` int(11) DEFAULT NULL,
  `los_to` int(11) DEFAULT NULL,
  `retirement_rate` bigint(20) DEFAULT NULL,
  `mrp_rate` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mem_new_status`
--

CREATE TABLE IF NOT EXISTS `mem_new_status` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `member_id` bigint(20) DEFAULT NULL,
  `member_name` text,
  `email_ads` varchar(50) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `member_id` (`member_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1121 ;

-- --------------------------------------------------------

--
-- Table structure for table `mem_newshell_status`
--

CREATE TABLE IF NOT EXISTS `mem_newshell_status` (
  `id` bigint(20) NOT NULL,
  `member_id` bigint(20) DEFAULT NULL,
  `member_name` text,
  `email_ads` varchar(90) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` tinyint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mem_po_transmittal`
--

CREATE TABLE IF NOT EXISTS `mem_po_transmittal` (
  `po_trans_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `member_id` bigint(6) unsigned zerofill NOT NULL,
  `received_date` date DEFAULT NULL,
  `received_time` varchar(255) DEFAULT NULL,
  `loan_type` varchar(255) DEFAULT NULL,
  `dr_number` varchar(255) DEFAULT NULL,
  `doc_type` varchar(255) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `encoded_by` varchar(255) DEFAULT NULL,
  `is_deleted` int(11) DEFAULT NULL,
  `deleted_by` varchar(255) DEFAULT NULL,
  `deleted_date` date DEFAULT NULL,
  PRIMARY KEY (`po_trans_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=67757 ;

-- --------------------------------------------------------

--
-- Table structure for table `mem_probationary`
--

CREATE TABLE IF NOT EXISTS `mem_probationary` (
  `probi_id` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `probitionary` varchar(50) NOT NULL,
  PRIMARY KEY (`probi_id`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `mem_probi_rel`
--

CREATE TABLE IF NOT EXISTS `mem_probi_rel` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `member_id` bigint(20) NOT NULL,
  `is_probi` smallint(3) NOT NULL,
  `date_regularization` date DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `mem_relationship`
--

CREATE TABLE IF NOT EXISTS `mem_relationship` (
  `rel_id` smallint(3) unsigned NOT NULL AUTO_INCREMENT,
  `rel_desc` varchar(50) NOT NULL,
  PRIMARY KEY (`rel_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Table structure for table `mem_savings_detail`
--

CREATE TABLE IF NOT EXISTS `mem_savings_detail` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `trans_date` datetime NOT NULL,
  `member_id` bigint(20) unsigned NOT NULL,
  `ref_nbr` varchar(255) DEFAULT NULL,
  `beg_balance` decimal(10,2) NOT NULL,
  `trans_type` varchar(45) NOT NULL COMMENT 'CSD=Cash deposit; WDR=Withdrawal; CM=Credit memo; PN=Penalty; RC=Returned Checks; SC=Service charge; WDC=closing transaction',
  `trans_amount` decimal(10,2) NOT NULL,
  `end_balance` decimal(10,2) NOT NULL,
  `teller_id` varchar(45) NOT NULL,
  `gl_account` varchar(45) DEFAULT NULL,
  `remarks` text,
  PRIMARY KEY (`id`),
  KEY `member_id` (`member_id`),
  KEY `ref_nbr` (`ref_nbr`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1268208 ;

-- --------------------------------------------------------

--
-- Table structure for table `mem_savings_interest`
--

CREATE TABLE IF NOT EXISTS `mem_savings_interest` (
  `int_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `savings_date` date DEFAULT NULL,
  `t_interest` decimal(10,2) DEFAULT NULL,
  `date_generated` datetime DEFAULT NULL,
  `generated_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`int_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=68 ;

-- --------------------------------------------------------

--
-- Table structure for table `mem_savings_rate`
--

CREATE TABLE IF NOT EXISTS `mem_savings_rate` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `amount1` decimal(10,2) NOT NULL,
  `amount2` decimal(10,2) NOT NULL,
  `percent` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `mem_savings_remarks`
--

CREATE TABLE IF NOT EXISTS `mem_savings_remarks` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `member_id` int(50) unsigned NOT NULL,
  `remarks` text,
  `added_date` datetime DEFAULT NULL,
  `added_by` varchar(50) DEFAULT NULL,
  `added_by_addr` varchar(50) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_by_addr` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=490 ;

-- --------------------------------------------------------

--
-- Table structure for table `mem_savings_sched`
--

CREATE TABLE IF NOT EXISTS `mem_savings_sched` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `member_id` bigint(20) unsigned NOT NULL,
  `effective_from` date NOT NULL,
  `effective_to` date NOT NULL,
  `savings_amt` decimal(10,2) NOT NULL,
  `created_by` varchar(45) NOT NULL,
  `created_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8895 ;

-- --------------------------------------------------------

--
-- Table structure for table `mem_savings_transtype`
--

CREATE TABLE IF NOT EXISTS `mem_savings_transtype` (
  `trans_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `trans_code` varchar(5) DEFAULT NULL,
  `trans_name` varchar(255) DEFAULT NULL,
  `trans_type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`trans_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

--
-- Table structure for table `mem_scc`
--

CREATE TABLE IF NOT EXISTS `mem_scc` (
  `scc_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `member_id` bigint(20) DEFAULT NULL,
  `scc_no` varchar(255) DEFAULT NULL,
  `no_of_shares` decimal(10,2) DEFAULT NULL,
  `scc_date_given` date DEFAULT NULL,
  PRIMARY KEY (`scc_id`),
  KEY `member_id` (`member_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6226 ;

-- --------------------------------------------------------

--
-- Table structure for table `mem_sem_rel`
--

CREATE TABLE IF NOT EXISTS `mem_sem_rel` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `member_id` bigint(20) unsigned NOT NULL,
  `seminar_id` smallint(3) unsigned NOT NULL,
  `date_attended` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16709 ;

-- --------------------------------------------------------

--
-- Table structure for table `mem_seminars`
--

CREATE TABLE IF NOT EXISTS `mem_seminars` (
  `seminar_id` smallint(3) unsigned NOT NULL AUTO_INCREMENT,
  `seminar_name` varchar(50) NOT NULL,
  PRIMARY KEY (`seminar_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `mem_statuses`
--

CREATE TABLE IF NOT EXISTS `mem_statuses` (
  `mem_status_id` smallint(3) unsigned NOT NULL AUTO_INCREMENT,
  `mem_status_name` varchar(50) NOT NULL,
  PRIMARY KEY (`mem_status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `mem_temp_bank`
--

CREATE TABLE IF NOT EXISTS `mem_temp_bank` (
  `bank_id` smallint(2) NOT NULL AUTO_INCREMENT,
  `bank_name` varchar(50) NOT NULL,
  PRIMARY KEY (`bank_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

-- --------------------------------------------------------

--
-- Table structure for table `or_details`
--

CREATE TABLE IF NOT EXISTS `or_details` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `or_id` bigint(6) unsigned zerofill DEFAULT NULL,
  `account_code` bigint(8) DEFAULT NULL,
  `sales_id` bigint(255) DEFAULT NULL,
  `trans_id` int(11) DEFAULT NULL,
  `pay_period` date NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `rebate` decimal(10,2) DEFAULT NULL,
  `is_fully_paid` int(11) DEFAULT NULL,
  `is_deferred` int(11) DEFAULT NULL,
  `is_advance` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `or_id` (`or_id`),
  KEY `po_num` (`sales_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=294395 ;

-- --------------------------------------------------------

--
-- Table structure for table `or_header`
--

CREATE TABLE IF NOT EXISTS `or_header` (
  `or_id` bigint(6) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `or_date` date NOT NULL,
  `or_number` varchar(20) DEFAULT NULL,
  `pay_period` date NOT NULL,
  `or_from` varchar(255) DEFAULT NULL,
  `member_id` bigint(6) unsigned zerofill NOT NULL,
  `payment_type` tinyint(1) NOT NULL COMMENT '1=cash;2=check; 3=savings; 4=overpayment',
  `or_amount` decimal(12,2) NOT NULL,
  `debit_bank` int(11) NOT NULL,
  `bank` varchar(50) DEFAULT NULL,
  `check_num` varchar(30) DEFAULT NULL,
  `received_by` varchar(30) NOT NULL,
  `received_date` datetime NOT NULL,
  `remarks` text,
  `or_type` smallint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1=member,0=company,2=other',
  `posted_status` smallint(1) unsigned NOT NULL DEFAULT '1' COMMENT '0=pending; 1=posted; 2=cancelled',
  `cancelled_by` varchar(255) DEFAULT NULL,
  `cancelled_date` datetime DEFAULT NULL,
  PRIMARY KEY (`or_id`),
  KEY `member_id` (`member_id`),
  KEY `or_number` (`or_number`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=50621 ;

-- --------------------------------------------------------

--
-- Table structure for table `p_items`
--

CREATE TABLE IF NOT EXISTS `p_items` (
  `item_code` varchar(50) NOT NULL,
  `category_id` smallint(3) unsigned NOT NULL,
  `item_status_id` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1=active, 2=pull out, 3=phase out',
  `item_short_desc` varchar(100) NOT NULL,
  `item_long_desc` varchar(255) NOT NULL,
  `item_srp` float(10,2) NOT NULL,
  `item_discount` decimal(4,2) NOT NULL DEFAULT '0.00',
  `item_reorder_level` bigint(10) NOT NULL,
  `item_serials_flag` tinyint(1) NOT NULL DEFAULT '1',
  `category` int(11) DEFAULT '0' COMMENT '0=items,1=dry ,2=gro',
  PRIMARY KEY (`item_code`),
  KEY `item_status_id` (`item_status_id`),
  KEY `category` (`category`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='coop items';

-- --------------------------------------------------------

--
-- Table structure for table `pdc_detail`
--

CREATE TABLE IF NOT EXISTS `pdc_detail` (
  `detail_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pdc_id` bigint(20) NOT NULL,
  `check_num` varchar(50) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `pdc_date` date NOT NULL,
  `daif` int(11) DEFAULT NULL,
  `closed` int(11) DEFAULT NULL,
  PRIMARY KEY (`detail_id`),
  KEY `pdc_id` (`pdc_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=110536 ;

-- --------------------------------------------------------

--
-- Table structure for table `pdc_header`
--

CREATE TABLE IF NOT EXISTS `pdc_header` (
  `pdc_id` bigint(11) NOT NULL AUTO_INCREMENT,
  `sales_id` varchar(255) NOT NULL,
  `member_id` bigint(11) NOT NULL,
  `bank` varchar(50) NOT NULL,
  `created_by` varchar(10) NOT NULL,
  `created_dt` datetime NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`pdc_id`),
  KEY `po_number` (`sales_id`),
  KEY `member_id` (`member_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5796 ;

-- --------------------------------------------------------

--
-- Table structure for table `shell_driver`
--

CREATE TABLE IF NOT EXISTS `shell_driver` (
  `card_full_number` bigint(20) DEFAULT NULL,
  `driver_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `shell_members`
--

CREATE TABLE IF NOT EXISTS `shell_members` (
  `card_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `card_full_number` bigint(19) NOT NULL DEFAULT '0',
  `member_id` bigint(6) unsigned zerofill NOT NULL DEFAULT '000000',
  `status` int(1) NOT NULL DEFAULT '0',
  `is_blocked` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`card_id`,`card_full_number`),
  KEY `member_id` (`member_id`),
  KEY `card_full_number` (`card_full_number`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12418 ;

-- --------------------------------------------------------

--
-- Table structure for table `shell_members_copy1`
--

CREATE TABLE IF NOT EXISTS `shell_members_copy1` (
  `card_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `card_full_number` bigint(19) NOT NULL DEFAULT '0',
  `member_id` bigint(6) unsigned zerofill NOT NULL DEFAULT '000000',
  `status` int(1) NOT NULL DEFAULT '0',
  `is_blocked` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`card_id`,`card_full_number`),
  KEY `member_id` (`member_id`),
  KEY `card_full_number` (`card_full_number`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6321 ;

-- --------------------------------------------------------

--
-- Table structure for table `shell_members_copy2`
--

CREATE TABLE IF NOT EXISTS `shell_members_copy2` (
  `card_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `card_full_number` bigint(19) NOT NULL DEFAULT '0',
  `member_id` bigint(6) unsigned zerofill NOT NULL DEFAULT '000000',
  `status` int(1) NOT NULL DEFAULT '0',
  `is_blocked` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`card_id`,`card_full_number`),
  KEY `member_id` (`member_id`),
  KEY `card_full_number` (`card_full_number`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12402 ;

-- --------------------------------------------------------

--
-- Table structure for table `shell_members_copy3`
--

CREATE TABLE IF NOT EXISTS `shell_members_copy3` (
  `card_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `card_full_number` bigint(19) NOT NULL DEFAULT '0',
  `member_id` bigint(6) unsigned zerofill NOT NULL DEFAULT '000000',
  `status` int(1) NOT NULL DEFAULT '0',
  `is_blocked` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`card_id`,`card_full_number`),
  KEY `member_id` (`member_id`),
  KEY `card_full_number` (`card_full_number`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12418 ;

-- --------------------------------------------------------

--
-- Table structure for table `shell_products`
--

CREATE TABLE IF NOT EXISTS `shell_products` (
  `product_code` bigint(20) NOT NULL DEFAULT '0',
  `product_type` text,
  `base_discount` decimal(10,2) DEFAULT NULL,
  `member_discount` decimal(10,2) DEFAULT NULL,
  `addtl_discount_if` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`product_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `shell_site_discount`
--

CREATE TABLE IF NOT EXISTS `shell_site_discount` (
  `site_code` bigint(4) unsigned zerofill NOT NULL DEFAULT '0000',
  `site_name` text,
  PRIMARY KEY (`site_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `shell_trans_detail`
--

CREATE TABLE IF NOT EXISTS `shell_trans_detail` (
  `trans_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `receipt_number` bigint(20) NOT NULL DEFAULT '0',
  `invoice_number` varchar(12) NOT NULL,
  `card_full_number` bigint(19) NOT NULL,
  `driver_name` text,
  `delivery_date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `site_code` bigint(4) unsigned zerofill DEFAULT NULL,
  `site_name` text,
  `product_code` bigint(4) unsigned DEFAULT NULL,
  `quantity` decimal(10,2) DEFAULT NULL,
  `pump_price` decimal(10,3) DEFAULT NULL,
  `payable_shell` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`trans_id`),
  KEY `card_full_number` (`card_full_number`),
  KEY `invoice_number` (`invoice_number`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=111676 ;

-- --------------------------------------------------------

--
-- Table structure for table `shell_trans_detail_copy`
--

CREATE TABLE IF NOT EXISTS `shell_trans_detail_copy` (
  `trans_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `receipt_number` bigint(20) NOT NULL DEFAULT '0',
  `invoice_number` varchar(12) NOT NULL,
  `card_full_number` bigint(19) NOT NULL,
  `driver_name` text,
  `delivery_date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `site_code` bigint(4) unsigned zerofill DEFAULT NULL,
  `site_name` text,
  `product_code` bigint(4) unsigned DEFAULT NULL,
  `quantity` decimal(10,2) DEFAULT NULL,
  `pump_price` decimal(10,3) DEFAULT NULL,
  `payable_shell` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`trans_id`),
  KEY `card_full_number` (`card_full_number`),
  KEY `invoice_number` (`invoice_number`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=111312 ;

-- --------------------------------------------------------

--
-- Table structure for table `shell_trans_detail_copy2`
--

CREATE TABLE IF NOT EXISTS `shell_trans_detail_copy2` (
  `trans_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `receipt_number` bigint(20) NOT NULL DEFAULT '0',
  `invoice_number` varchar(12) NOT NULL,
  `card_full_number` bigint(19) NOT NULL,
  `driver_name` text,
  `delivery_date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `site_code` bigint(4) unsigned zerofill DEFAULT NULL,
  `site_name` text,
  `product_code` bigint(4) unsigned DEFAULT NULL,
  `quantity` decimal(10,2) DEFAULT NULL,
  `pump_price` decimal(10,3) DEFAULT NULL,
  `payable_shell` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`trans_id`),
  KEY `card_full_number` (`card_full_number`),
  KEY `invoice_number` (`invoice_number`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=110717 ;

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
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9015 ;

-- --------------------------------------------------------

--
-- Table structure for table `stg_banks`
--

CREATE TABLE IF NOT EXISTS `stg_banks` (
  `bank_id` smallint(3) NOT NULL AUTO_INCREMENT,
  `bank_name` varchar(50) NOT NULL,
  PRIMARY KEY (`bank_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

-- --------------------------------------------------------

--
-- Table structure for table `stg_billing_columns`
--

CREATE TABLE IF NOT EXISTS `stg_billing_columns` (
  `column_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `column_desc` varchar(255) DEFAULT NULL,
  `column_value` varchar(255) DEFAULT NULL,
  `with_ref_table` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`column_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

-- --------------------------------------------------------

--
-- Table structure for table `stg_billing_format_detail`
--

CREATE TABLE IF NOT EXISTS `stg_billing_format_detail` (
  `format_column_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `column_id` smallint(6) NOT NULL,
  `column_title` varchar(255) DEFAULT NULL COMMENT 'if excel only',
  `column_sort` tinyint(4) DEFAULT NULL,
  `format_id` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`format_column_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=319 ;

-- --------------------------------------------------------

--
-- Table structure for table `stg_billing_format_header`
--

CREATE TABLE IF NOT EXISTS `stg_billing_format_header` (
  `format_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `format_name` varchar(255) DEFAULT NULL,
  `file_type` varchar(255) DEFAULT NULL,
  `separator` varchar(255) DEFAULT NULL COMMENT 'if text_file only',
  `date_format` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`format_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

-- --------------------------------------------------------

--
-- Table structure for table `stg_company`
--

CREATE TABLE IF NOT EXISTS `stg_company` (
  `company_id` smallint(3) unsigned NOT NULL AUTO_INCREMENT,
  `company_name` varchar(50) NOT NULL,
  `company_code` varchar(255) DEFAULT NULL,
  `subsidiary` int(11) DEFAULT NULL COMMENT '0=no;1=yes;',
  `cm` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`company_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=41 ;

-- --------------------------------------------------------

--
-- Table structure for table `stg_credit_limit`
--

CREATE TABLE IF NOT EXISTS `stg_credit_limit` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `LOS_from` int(10) unsigned NOT NULL,
  `LOS_to` int(10) unsigned NOT NULL,
  `max_loanable_amt` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Table structure for table `stg_credit_rating`
--

CREATE TABLE IF NOT EXISTS `stg_credit_rating` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rating` varchar(45) NOT NULL,
  `credit_exposure` varchar(255) NOT NULL,
  `approving_authority` varchar(45) NOT NULL,
  `def_from` decimal(10,2) NOT NULL,
  `def_to` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `stg_employee_benefits`
--

CREATE TABLE IF NOT EXISTS `stg_employee_benefits` (
  `benefit_id` int(10) NOT NULL AUTO_INCREMENT,
  `benefit_desc` varchar(50) NOT NULL,
  `benefit_month` smallint(2) unsigned zerofill NOT NULL,
  PRIMARY KEY (`benefit_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `stg_final_pay_recipient`
--

CREATE TABLE IF NOT EXISTS `stg_final_pay_recipient` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `fname` varchar(100) DEFAULT NULL,
  `lname` varchar(100) DEFAULT NULL,
  `mname` varchar(100) DEFAULT NULL,
  `position` varchar(100) DEFAULT NULL,
  `address` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

-- --------------------------------------------------------

--
-- Table structure for table `stg_general_settings`
--

CREATE TABLE IF NOT EXISTS `stg_general_settings` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `rebate_pct` int(11) DEFAULT NULL COMMENT 'percentage',
  `pre_term_pct` int(11) DEFAULT NULL,
  `scs_limit` decimal(10,2) DEFAULT NULL,
  `fine_pct` int(11) DEFAULT NULL,
  `fine_cut_off` int(11) DEFAULT NULL COMMENT 'Cut off days',
  `death_pay` decimal(10,2) DEFAULT NULL,
  `scs_divisor` int(11) DEFAULT NULL,
  `scs_divisor_subs` int(11) DEFAULT NULL,
  `over_auto_offset` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `stg_inv_color`
--

CREATE TABLE IF NOT EXISTS `stg_inv_color` (
  `color_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `color_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`color_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=122 ;

-- --------------------------------------------------------

--
-- Table structure for table `stg_inv_location`
--

CREATE TABLE IF NOT EXISTS `stg_inv_location` (
  `location_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `location` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`location_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

-- --------------------------------------------------------

--
-- Table structure for table `stg_loan_amount`
--

CREATE TABLE IF NOT EXISTS `stg_loan_amount` (
  `amt_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `loan_amount` decimal(10,0) DEFAULT NULL,
  PRIMARY KEY (`amt_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=51 ;

-- --------------------------------------------------------

--
-- Table structure for table `stg_loan_category`
--

CREATE TABLE IF NOT EXISTS `stg_loan_category` (
  `loan_cat_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`loan_cat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Table structure for table `stg_loan_comaker`
--

CREATE TABLE IF NOT EXISTS `stg_loan_comaker` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `line_no` bigint(20) DEFAULT NULL,
  `comaker_type` int(11) DEFAULT NULL COMMENT 'company_id',
  PRIMARY KEY (`id`),
  KEY `comaker_type` (`comaker_type`),
  KEY `line_no` (`line_no`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4592 ;

-- --------------------------------------------------------

--
-- Table structure for table `stg_loan_entries`
--

CREATE TABLE IF NOT EXISTS `stg_loan_entries` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `prod_id` varchar(255) DEFAULT NULL,
  `i_receivable` int(11) DEFAULT NULL,
  `int_income` int(11) DEFAULT NULL,
  `u_income` int(11) DEFAULT NULL,
  `r_income` int(11) DEFAULT NULL,
  `d_income` int(11) DEFAULT NULL,
  `o_income` int(11) DEFAULT NULL,
  `s_fee` int(11) DEFAULT NULL,
  `i_fee` int(11) DEFAULT NULL,
  `c_fee` int(11) DEFAULT NULL,
  `a_payable` int(11) DEFAULT NULL,
  `pre_termination` int(11) DEFAULT NULL,
  `mor_interest` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `prod_id` (`prod_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=60 ;

-- --------------------------------------------------------

--
-- Table structure for table `stg_loan_interest_d`
--

CREATE TABLE IF NOT EXISTS `stg_loan_interest_d` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `int_id` bigint(20) DEFAULT NULL,
  `prod_id2` varchar(255) DEFAULT NULL,
  `amount2` decimal(10,2) DEFAULT NULL,
  `pay_terms2` int(11) DEFAULT NULL,
  `date_ctr` int(20) DEFAULT NULL,
  `interest_amount` decimal(10,2) DEFAULT NULL,
  `beg_bal` decimal(10,2) DEFAULT NULL,
  `interest_rebate` decimal(10,2) DEFAULT NULL,
  `semi_amort` decimal(10,2) DEFAULT NULL,
  `dedn_principal` decimal(10,2) DEFAULT NULL,
  `end_bal` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=570061 ;

-- --------------------------------------------------------

--
-- Table structure for table `stg_loan_interest_d_20190506`
--

CREATE TABLE IF NOT EXISTS `stg_loan_interest_d_20190506` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `int_id` bigint(20) DEFAULT NULL,
  `prod_id2` varchar(255) DEFAULT NULL,
  `amount2` decimal(10,2) DEFAULT NULL,
  `pay_terms2` int(11) DEFAULT NULL,
  `date_ctr` int(20) DEFAULT NULL,
  `interest_amount` decimal(10,2) DEFAULT NULL,
  `beg_bal` decimal(10,2) DEFAULT NULL,
  `interest_rebate` decimal(10,2) DEFAULT NULL,
  `semi_amort` decimal(10,2) DEFAULT NULL,
  `dedn_principal` decimal(10,2) DEFAULT NULL,
  `end_bal` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=459163 ;

-- --------------------------------------------------------

--
-- Table structure for table `stg_loan_interest_d_20190615`
--

CREATE TABLE IF NOT EXISTS `stg_loan_interest_d_20190615` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `int_id` bigint(20) DEFAULT NULL,
  `prod_id2` varchar(255) DEFAULT NULL,
  `amount2` decimal(10,2) DEFAULT NULL,
  `pay_terms2` int(11) DEFAULT NULL,
  `date_ctr` int(20) DEFAULT NULL,
  `interest_amount` decimal(10,2) DEFAULT NULL,
  `beg_bal` decimal(10,2) DEFAULT NULL,
  `interest_rebate` decimal(10,2) DEFAULT NULL,
  `semi_amort` decimal(10,2) DEFAULT NULL,
  `dedn_principal` decimal(10,2) DEFAULT NULL,
  `end_bal` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=514453 ;

-- --------------------------------------------------------

--
-- Table structure for table `stg_loan_interest_h`
--

CREATE TABLE IF NOT EXISTS `stg_loan_interest_h` (
  `int_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `prod_id` varchar(20) DEFAULT NULL,
  `amount` int(20) DEFAULT NULL,
  `pay_terms` int(11) DEFAULT NULL,
  `interest2` decimal(10,3) DEFAULT NULL,
  `interest_value2` smallint(6) DEFAULT NULL,
  `interest_computation2` smallint(6) DEFAULT NULL,
  `rebate_scheme2` smallint(6) DEFAULT NULL,
  `interest_type2` smallint(6) DEFAULT NULL,
  `t_interest` decimal(10,2) DEFAULT NULL,
  `t_interest_rbt` decimal(10,2) DEFAULT NULL,
  `date_generated` date DEFAULT NULL,
  `generated_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`int_id`),
  KEY `prod_id` (`prod_id`),
  KEY `interest2` (`interest2`),
  KEY `pay_terms` (`pay_terms`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6154 ;

--
-- Triggers `stg_loan_interest_h`
--
DROP TRIGGER IF EXISTS `delete_detail`;
DELIMITER //
CREATE TRIGGER `delete_detail` BEFORE DELETE ON `stg_loan_interest_h`
 FOR EACH ROW BEGIN
        DELETE FROM stg_loan_interest_d WHERE OLD.int_id = int_id;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `stg_loan_interest_h_20190506`
--

CREATE TABLE IF NOT EXISTS `stg_loan_interest_h_20190506` (
  `int_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `prod_id` varchar(20) DEFAULT NULL,
  `amount` int(20) DEFAULT NULL,
  `pay_terms` int(11) DEFAULT NULL,
  `interest2` decimal(10,3) DEFAULT NULL,
  `interest_value2` smallint(6) DEFAULT NULL,
  `interest_computation2` smallint(6) DEFAULT NULL,
  `rebate_scheme2` smallint(6) DEFAULT NULL,
  `interest_type2` smallint(6) DEFAULT NULL,
  `t_interest` decimal(10,2) DEFAULT NULL,
  `t_interest_rbt` decimal(10,2) DEFAULT NULL,
  `date_generated` date DEFAULT NULL,
  `generated_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`int_id`),
  KEY `prod_id` (`prod_id`),
  KEY `interest2` (`interest2`),
  KEY `pay_terms` (`pay_terms`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5217 ;

--
-- Triggers `stg_loan_interest_h_20190506`
--
DROP TRIGGER IF EXISTS `delete_detail_copy1`;
DELIMITER //
CREATE TRIGGER `delete_detail_copy1` BEFORE DELETE ON `stg_loan_interest_h_20190506`
 FOR EACH ROW BEGIN
        DELETE FROM stg_loan_interest_d WHERE OLD.int_id = int_id;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `stg_loan_interest_h_20190615`
--

CREATE TABLE IF NOT EXISTS `stg_loan_interest_h_20190615` (
  `int_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `prod_id` varchar(20) DEFAULT NULL,
  `amount` int(20) DEFAULT NULL,
  `pay_terms` int(11) DEFAULT NULL,
  `interest2` decimal(10,3) DEFAULT NULL,
  `interest_value2` smallint(6) DEFAULT NULL,
  `interest_computation2` smallint(6) DEFAULT NULL,
  `rebate_scheme2` smallint(6) DEFAULT NULL,
  `interest_type2` smallint(6) DEFAULT NULL,
  `t_interest` decimal(10,2) DEFAULT NULL,
  `t_interest_rbt` decimal(10,2) DEFAULT NULL,
  `date_generated` date DEFAULT NULL,
  `generated_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`int_id`),
  KEY `prod_id` (`prod_id`),
  KEY `interest2` (`interest2`),
  KEY `pay_terms` (`pay_terms`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5693 ;

--
-- Triggers `stg_loan_interest_h_20190615`
--
DROP TRIGGER IF EXISTS `delete_detail_copy`;
DELIMITER //
CREATE TRIGGER `delete_detail_copy` BEFORE DELETE ON `stg_loan_interest_h_20190615`
 FOR EACH ROW BEGIN
        DELETE FROM stg_loan_interest_d WHERE OLD.int_id = int_id;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `stg_loan_maker`
--

CREATE TABLE IF NOT EXISTS `stg_loan_maker` (
  `line_no` bigint(20) NOT NULL AUTO_INCREMENT,
  `prod_id` varchar(20) DEFAULT NULL,
  `maker_type` int(11) DEFAULT NULL COMMENT ' (company_id)',
  `amt_type` int(11) DEFAULT NULL COMMENT ' (1=min_max,0= specific)',
  `min_loan_amt` decimal(10,2) DEFAULT NULL,
  `max_loan_amt` decimal(10,2) DEFAULT NULL,
  `num_comakers` int(11) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`line_no`),
  KEY `maker_type` (`maker_type`),
  KEY `prod_id` (`prod_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=500 ;

--
-- Triggers `stg_loan_maker`
--
DROP TRIGGER IF EXISTS `delete_details`;
DELIMITER //
CREATE TRIGGER `delete_details` BEFORE DELETE ON `stg_loan_maker`
 FOR EACH ROW BEGIN
        DELETE FROM stg_loan_comaker WHERE OLD.line_no = line_no;
        DELETE FROM stg_loan_maker_pterms WHERE OLD.line_no = line_no;
        DELETE FROM stg_loan_maker_amt WHERE OLD.line_no = line_no;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `stg_loan_maker_amt`
--

CREATE TABLE IF NOT EXISTS `stg_loan_maker_amt` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `line_no` bigint(20) NOT NULL,
  `amt_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2351 ;

-- --------------------------------------------------------

--
-- Table structure for table `stg_loan_maker_pterms`
--

CREATE TABLE IF NOT EXISTS `stg_loan_maker_pterms` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `line_no` bigint(20) DEFAULT NULL,
  `term_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6400 ;

-- --------------------------------------------------------

--
-- Table structure for table `stg_loan_priority`
--

CREATE TABLE IF NOT EXISTS `stg_loan_priority` (
  `loan_priority_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `prod_id` varchar(255) DEFAULT NULL,
  `loan_priority_no` bigint(20) DEFAULT NULL,
  `loan_priority_lvl` varchar(255) DEFAULT NULL COMMENT 'first ,last',
  PRIMARY KEY (`loan_priority_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `stg_loan_process`
--

CREATE TABLE IF NOT EXISTS `stg_loan_process` (
  `process_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `status` varchar(255) DEFAULT NULL,
  `process_lvl_sort` int(11) DEFAULT NULL,
  `process_lvl` varchar(255) DEFAULT NULL,
  `btn_name` varchar(255) DEFAULT NULL,
  `process_desc` varchar(255) DEFAULT NULL,
  `section_id` int(255) DEFAULT NULL,
  `emp_id` int(255) DEFAULT NULL,
  PRIMARY KEY (`process_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `stg_loan_products`
--

CREATE TABLE IF NOT EXISTS `stg_loan_products` (
  `prod_id` varchar(20) NOT NULL,
  `loan_type_id` bigint(20) DEFAULT NULL,
  `loan_cat_id` bigint(20) DEFAULT NULL,
  `trans_id` bigint(20) DEFAULT NULL,
  `prod_name` varchar(255) DEFAULT NULL,
  `prefix_code` varchar(5) DEFAULT NULL,
  `interest` decimal(10,3) DEFAULT NULL,
  `interest_value` smallint(1) DEFAULT NULL COMMENT '0=value,1=percent',
  `interest_computation` smallint(3) DEFAULT NULL COMMENT '1=straight,2=diminishing value',
  `rebate_scheme` smallint(3) DEFAULT NULL COMMENT '1=straight,2=diminishing value',
  `interest_type` smallint(6) DEFAULT NULL COMMENT '1=Add On Interest; 2=Deduct Interest',
  `service_charge` decimal(10,3) DEFAULT NULL,
  `sc_value` smallint(1) DEFAULT NULL COMMENT '0=value,1=percent',
  `comm_value` smallint(1) DEFAULT NULL COMMENT '0=value,1=percent',
  `commission` decimal(10,3) DEFAULT NULL,
  `pmt_computation` tinyint(1) NOT NULL,
  `w_moratorium` tinyint(1) DEFAULT NULL,
  `loan_ratio` int(11) DEFAULT NULL COMMENT '(1:1, 1:many)',
  `sc_deduct` tinyint(4) NOT NULL DEFAULT '0',
  `sc_spread` tinyint(4) NOT NULL DEFAULT '0',
  `sc_spread_mos` int(11) NOT NULL DEFAULT '0',
  `income_recognition` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1=spread over terms; 2=point of sales; 3=with 1 year current, else spread',
  `collection_type` tinyint(4) DEFAULT NULL COMMENT '1=Regular Payroll; 2=Thru OR/PDC; 3=Bonuses',
  `with_rebate` tinyint(4) DEFAULT NULL,
  `is_pre_term` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Is Pre-Termination Computation, 1=Yes; 0=No',
  `created_by` varchar(20) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` varchar(20) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `required_scs` int(255) DEFAULT NULL COMMENT '0=no;1=yes;',
  `loan_status` int(11) NOT NULL DEFAULT '1' COMMENT '0=inactive;1=active;',
  PRIMARY KEY (`prod_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Triggers `stg_loan_products`
--
DROP TRIGGER IF EXISTS `delete_loan_maker`;
DELIMITER //
CREATE TRIGGER `delete_loan_maker` BEFORE DELETE ON `stg_loan_products`
 FOR EACH ROW BEGIN
        DELETE FROM stg_loan_maker WHERE OLD.prod_id = prod_id;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `stg_loan_types`
--

CREATE TABLE IF NOT EXISTS `stg_loan_types` (
  `loan_type_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(255) NOT NULL,
  PRIMARY KEY (`loan_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `stg_loanable_online`
--

CREATE TABLE IF NOT EXISTS `stg_loanable_online` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_name` text,
  `emp_levels` text,
  `cat_desc` text,
  `member_type` varchar(10) DEFAULT '0' COMMENT '1=NonPayroll, 2=Subs, 3=PLDT',
  `company_id` int(11) DEFAULT NULL,
  `LOS_from` int(11) DEFAULT NULL,
  `LOS_to` int(11) DEFAULT NULL,
  `net_stake` text COMMENT 'like "RBP,TBP,SCS"',
  `net_stake_less` text COMMENT 'OB',
  `net_stake_percent` int(11) DEFAULT NULL,
  `net_stake_minimum` decimal(10,2) DEFAULT NULL,
  `standard_loan` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Table structure for table `stg_payment_terms`
--

CREATE TABLE IF NOT EXISTS `stg_payment_terms` (
  `term_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pay_terms` decimal(11,1) DEFAULT NULL,
  PRIMARY KEY (`term_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=54 ;

-- --------------------------------------------------------

--
-- Table structure for table `stg_prod_category`
--

CREATE TABLE IF NOT EXISTS `stg_prod_category` (
  `category_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `category_name` varchar(50) NOT NULL,
  `category_type` smallint(6) NOT NULL DEFAULT '1' COMMENT '1=item,2=gc',
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

-- --------------------------------------------------------

--
-- Table structure for table `stg_retirement_schedule`
--

CREATE TABLE IF NOT EXISTS `stg_retirement_schedule` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `yrs` smallint(2) NOT NULL,
  `rbp` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

-- --------------------------------------------------------

--
-- Table structure for table `stg_sales_agent`
--

CREATE TABLE IF NOT EXISTS `stg_sales_agent` (
  `agent_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `agent_name` varchar(100) NOT NULL,
  `agent_type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`agent_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

-- --------------------------------------------------------

--
-- Table structure for table `stg_telescoop_bank`
--

CREATE TABLE IF NOT EXISTS `stg_telescoop_bank` (
  `bank_id` smallint(3) NOT NULL,
  `accnt_num` varchar(20) NOT NULL,
  `accnt_code` int(11) NOT NULL,
  `address` varchar(250) NOT NULL,
  `branch_head` varchar(50) NOT NULL,
  `branch_name` varchar(50) NOT NULL,
  PRIMARY KEY (`bank_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stg_transaction_types`
--

CREATE TABLE IF NOT EXISTS `stg_transaction_types` (
  `trans_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `acct_code` int(11) NOT NULL,
  `trans_type_sdesc` varchar(10) NOT NULL DEFAULT ' ',
  `trans_type_ldesc` varchar(50) NOT NULL,
  `priority` smallint(3) unsigned NOT NULL,
  `semi_mo_contrib` float(10,2) DEFAULT NULL,
  `operation` varchar(255) DEFAULT NULL COMMENT '(+/-)',
  `created_by` varchar(20) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_by` varchar(20) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  PRIMARY KEY (`trans_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Table structure for table `survey_toto`
--

CREATE TABLE IF NOT EXISTS `survey_toto` (
  `ctr` varchar(255) DEFAULT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `Email Address` varchar(255) DEFAULT NULL,
  `Company Id` varchar(255) DEFAULT NULL,
  `Date of Birth` varchar(255) DEFAULT NULL,
  `Contact Number` varchar(255) DEFAULT NULL,
  `Home Ownership` varchar(255) DEFAULT NULL,
  `Car` varchar(255) DEFAULT NULL,
  `Pick-Up` varchar(255) DEFAULT NULL,
  `Motorbike` varchar(255) DEFAULT NULL,
  `Van` varchar(255) DEFAULT NULL,
  `SUV/AUV` varchar(255) DEFAULT NULL,
  `Others` varchar(255) DEFAULT NULL,
  `Quantity` varchar(255) DEFAULT NULL,
  `Brand` varchar(255) DEFAULT NULL,
  `Q1` varchar(255) DEFAULT NULL,
  `Q2` varchar(255) DEFAULT NULL,
  `Q3` varchar(255) DEFAULT NULL,
  `Q4` varchar(255) DEFAULT NULL,
  `Q5` varchar(255) DEFAULT NULL,
  `Q6` varchar(255) DEFAULT NULL,
  `Q7` varchar(255) DEFAULT NULL,
  `Q8` varchar(255) DEFAULT NULL,
  `Q9` varchar(255) DEFAULT NULL,
  `Q10` varchar(255) DEFAULT NULL,
  `Others1` varchar(255) DEFAULT NULL,
  `New Vehicle` varchar(255) DEFAULT NULL,
  `Foreign Trip` varchar(255) DEFAULT NULL,
  `Local Trip` varchar(255) DEFAULT NULL,
  `Entrainment Package` varchar(255) DEFAULT NULL,
  `Small Business` varchar(255) DEFAULT NULL,
  `Living Room Package` varchar(255) DEFAULT NULL,
  ` Weekend picninc/beach/swimming` varchar(255) DEFAULT NULL,
  `Kitchen Package` varchar(255) DEFAULT NULL,
  `Bedroom Package` varchar(255) DEFAULT NULL,
  `Fancy dinner with partner/friend` varchar(255) DEFAULT NULL,
  `Family Bonding` varchar(255) DEFAULT NULL,
  `Jewelries` varchar(255) DEFAULT NULL,
  `Others2` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `teles_no_survey`
--

CREATE TABLE IF NOT EXISTS `teles_no_survey` (
  `remarks` varchar(255) DEFAULT NULL,
  `survey_id` varchar(255) DEFAULT NULL,
  `member_id` bigint(20) DEFAULT NULL,
  `mem_lname` varchar(255) DEFAULT NULL,
  `mem_fname` varchar(255) DEFAULT NULL,
  `mem_mname` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `teles_survey`
--

CREATE TABLE IF NOT EXISTS `teles_survey` (
  `survey_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `Timestamp` datetime DEFAULT NULL,
  `Username` varchar(255) DEFAULT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `Company ID` varchar(255) DEFAULT NULL,
  `Date of Birth` date DEFAULT NULL,
  `Contact Numbers (Mobile/Landline)` varchar(255) DEFAULT NULL,
  `Home Ownership` varchar(255) DEFAULT NULL,
  `Vehicle Ownership` varchar(255) DEFAULT NULL,
  `Vehicle Ownership (Quantity)` varchar(255) DEFAULT NULL,
  `Vehicle Ownership (Brand)` varchar(255) DEFAULT NULL,
  `Lifestyle [Always go to movie house]` varchar(255) DEFAULT NULL,
  `Lifestyle [Regularly eat in restaurant on weekends]` varchar(255) DEFAULT NULL,
  `Lifestyle [Always go on regular vacation]` varchar(255) DEFAULT NULL,
  `Lifestyle [I love the beach]` varchar(255) DEFAULT NULL,
  `Lifestyle [I love listening to music]` varchar(255) DEFAULT NULL,
  `Lifestyle [I love to stay at home (staycation)]` varchar(255) DEFAULT NULL,
  `Lifestyle [I love to stay overnight in a hotel]` varchar(255) DEFAULT NULL,
  `Lifestyle [I love to shop]` varchar(255) DEFAULT NULL,
  `Lifestyle [I like foreign trip]` varchar(255) DEFAULT NULL,
  `Lifestyle [I prefer local trip]` varchar(255) DEFAULT NULL,
  `Others` varchar(255) DEFAULT NULL,
  `Pick your top three (3) choices [New vehicle]` varchar(255) DEFAULT NULL,
  `Pick your top three (3) choices [Foreign Trip]` varchar(255) DEFAULT NULL,
  `Pick your top three (3) choices [Local Trip]` varchar(255) DEFAULT NULL,
  `Pick your top three (3) choices [Entrainment Package]` varchar(255) DEFAULT NULL,
  `Pick your top three (3) choices [Small Businss]` varchar(255) DEFAULT NULL,
  `Pick your top three (3) choices [Living room package]` varchar(255) DEFAULT NULL,
  `Pick your top three (3) choices [Weekend picnic/beach/swimming]` varchar(255) DEFAULT NULL,
  `Pick your top three (3) choices [Kitchen package]` varchar(255) DEFAULT NULL,
  `Pick your top three (3) choices [Bedroom package]` varchar(255) DEFAULT NULL,
  `Pick your top three (3) choices [Fancy dinner with partner/frien` varchar(255) DEFAULT NULL,
  `Pick your top three (3) choices [Family bonding]` varchar(255) DEFAULT NULL,
  `Pick your top three (3) choices [Jewelries]` varchar(255) DEFAULT NULL,
  `Others1` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`survey_id`),
  KEY `company_id` (`Company ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=351 ;

-- --------------------------------------------------------

--
-- Table structure for table `teles_survey1`
--

CREATE TABLE IF NOT EXISTS `teles_survey1` (
  `survey_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Username` varchar(255) DEFAULT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `Company ID` varchar(255) DEFAULT NULL,
  `Date of Birth` date DEFAULT NULL,
  `Contact Numbers (Mobile/Landline)` varchar(255) DEFAULT NULL,
  `Home Ownership` varchar(255) DEFAULT NULL,
  `Vehicle Ownership` varchar(255) DEFAULT NULL,
  `Vehicle Ownership (Quantity)` varchar(255) DEFAULT NULL,
  `Vehicle Ownership (Brand)` varchar(255) DEFAULT NULL,
  `Lifestyle [Always go to movie house]` varchar(255) DEFAULT NULL,
  `Lifestyle [Regularly eat in restaurant on weekends]` varchar(255) DEFAULT NULL,
  `Lifestyle [Always go on regular vacation]` varchar(255) DEFAULT NULL,
  `Lifestyle [I love the beach]` varchar(255) DEFAULT NULL,
  `Lifestyle [I love listening to music]` varchar(255) DEFAULT NULL,
  `Lifestyle [I love to stay at home (staycation)]` varchar(255) DEFAULT NULL,
  `Lifestyle [I love to stay overnight in a hotel]` varchar(255) DEFAULT NULL,
  `Lifestyle [I love to shop]` varchar(255) DEFAULT NULL,
  `Lifestyle [I like foreign trip]` varchar(255) DEFAULT NULL,
  `Lifestyle [I prefer local trip]` varchar(255) DEFAULT NULL,
  `Others` varchar(255) DEFAULT NULL,
  `Pick your top three (3) choices [New vehicle]` varchar(255) DEFAULT NULL,
  `Pick your top three (3) choices [Foreign Trip]` varchar(255) DEFAULT NULL,
  `Pick your top three (3) choices [Local Trip]` varchar(255) DEFAULT NULL,
  `Pick your top three (3) choices [Entrainment Package]` varchar(255) DEFAULT NULL,
  `Pick your top three (3) choices [Small Businss]` varchar(255) DEFAULT NULL,
  `Pick your top three (3) choices [Living room package]` varchar(255) DEFAULT NULL,
  `Pick your top three (3) choices [Weekend picnic/beach/swimming]` varchar(255) DEFAULT NULL,
  `Pick your top three (3) choices [Kitchen package]` varchar(255) DEFAULT NULL,
  `Pick your top three (3) choices [Bedroom package]` varchar(255) DEFAULT NULL,
  `Pick your top three (3) choices [Fancy dinner with partner/frien` varchar(255) DEFAULT NULL,
  `Pick your top three (3) choices [Family bonding]` varchar(255) DEFAULT NULL,
  `Pick your top three (3) choices [Jewelries]` varchar(255) DEFAULT NULL,
  `Others1` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`survey_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=482 ;

-- --------------------------------------------------------

--
-- Table structure for table `teles_survey2`
--

CREATE TABLE IF NOT EXISTS `teles_survey2` (
  `Timestamp` datetime DEFAULT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `Email Address` varchar(255) DEFAULT NULL,
  `Company Id` varchar(255) DEFAULT NULL,
  `Date of Birth` date DEFAULT NULL,
  `Contact Number` varchar(255) DEFAULT NULL,
  `Home Ownership` varchar(255) DEFAULT NULL,
  `Car` varchar(255) DEFAULT NULL,
  `Pick-Up` varchar(255) DEFAULT NULL,
  `Motorbike` varchar(255) DEFAULT NULL,
  `Van` varchar(255) DEFAULT NULL,
  `SUV/AUV` varchar(255) DEFAULT NULL,
  `Others` varchar(255) DEFAULT NULL,
  `Quantity` varchar(255) DEFAULT NULL,
  `Brand` varchar(255) DEFAULT NULL,
  `Q1` varchar(255) DEFAULT NULL,
  `Q2` varchar(255) DEFAULT NULL,
  `Q3` varchar(255) DEFAULT NULL,
  `Q4` varchar(255) DEFAULT NULL,
  `Q5` varchar(255) DEFAULT NULL,
  `Q6` varchar(255) DEFAULT NULL,
  `Q7` varchar(255) DEFAULT NULL,
  `Q8` varchar(255) DEFAULT NULL,
  `Q9` varchar(255) DEFAULT NULL,
  `Q10` varchar(255) DEFAULT NULL,
  `Others1` varchar(255) DEFAULT NULL,
  `New Vehicle` varchar(255) DEFAULT NULL,
  `Foreign Trip` varchar(255) DEFAULT NULL,
  `Local Trip` varchar(255) DEFAULT NULL,
  `Entrainment Package` varchar(255) DEFAULT NULL,
  `Small Business` varchar(255) DEFAULT NULL,
  `Living Room Package` varchar(255) DEFAULT NULL,
  `Weekend picninc/beach/swimming` varchar(255) DEFAULT NULL,
  `Kitchen Package` varchar(255) DEFAULT NULL,
  `Bedroom Package` varchar(255) DEFAULT NULL,
  `Fancy dinner with partner/friend` varchar(255) DEFAULT NULL,
  `Family Bonding` varchar(255) DEFAULT NULL,
  `Jewelries` varchar(255) DEFAULT NULL,
  `Others2` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `teles_survey2A`
--

CREATE TABLE IF NOT EXISTS `teles_survey2A` (
  `survey_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `Timestamp` datetime DEFAULT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `Email Address` varchar(255) DEFAULT NULL,
  `Company Id` varchar(255) DEFAULT NULL,
  `Date of Birth` date DEFAULT NULL,
  `Contact Number` varchar(255) DEFAULT NULL,
  `Home Ownership` varchar(255) DEFAULT NULL,
  `Car` varchar(255) DEFAULT NULL,
  `Pick-Up` varchar(255) DEFAULT NULL,
  `Motorbike` varchar(255) DEFAULT NULL,
  `Van` varchar(255) DEFAULT NULL,
  `SUV/AUV` varchar(255) DEFAULT NULL,
  `Others` varchar(255) DEFAULT NULL,
  `Quantity` varchar(255) DEFAULT NULL,
  `Brand` varchar(255) DEFAULT NULL,
  `Q1` varchar(255) DEFAULT NULL,
  `Q2` varchar(255) DEFAULT NULL,
  `Q3` varchar(255) DEFAULT NULL,
  `Q4` varchar(255) DEFAULT NULL,
  `Q5` varchar(255) DEFAULT NULL,
  `Q6` varchar(255) DEFAULT NULL,
  `Q7` varchar(255) DEFAULT NULL,
  `Q8` varchar(255) DEFAULT NULL,
  `Q9` varchar(255) DEFAULT NULL,
  `Q10` varchar(255) DEFAULT NULL,
  `Others1` varchar(255) DEFAULT NULL,
  `New Vehicle` varchar(255) DEFAULT NULL,
  `Foreign Trip` varchar(255) DEFAULT NULL,
  `Local Trip` varchar(255) DEFAULT NULL,
  `Entrainment Package` varchar(255) DEFAULT NULL,
  `Small Business` varchar(255) DEFAULT NULL,
  `Living Room Package` varchar(255) DEFAULT NULL,
  `Weekend picninc/beach/swimming` varchar(255) DEFAULT NULL,
  `Kitchen Package` varchar(255) DEFAULT NULL,
  `Bedroom Package` varchar(255) DEFAULT NULL,
  `Fancy dinner with partner/friend` varchar(255) DEFAULT NULL,
  `Family Bonding` varchar(255) DEFAULT NULL,
  `Jewelries` varchar(255) DEFAULT NULL,
  `Others2` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`survey_id`),
  UNIQUE KEY `company_id` (`Company Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=440 ;

-- --------------------------------------------------------

--
-- Table structure for table `teles_survey_final`
--

CREATE TABLE IF NOT EXISTS `teles_survey_final` (
  `survey_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `company_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`survey_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=831 ;

-- --------------------------------------------------------

--
-- Table structure for table `teles_survey_gie`
--

CREATE TABLE IF NOT EXISTS `teles_survey_gie` (
  `survey_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Username` varchar(255) DEFAULT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `Company ID` varchar(255) DEFAULT NULL,
  `Date of Birth` date DEFAULT NULL,
  `Contact Numbers (Mobile/Landline)` varchar(255) DEFAULT NULL,
  `Home Ownership` varchar(255) DEFAULT NULL,
  `Vehicle Ownership` varchar(255) DEFAULT NULL,
  `Vehicle Ownership (Quantity)` varchar(255) DEFAULT NULL,
  `Vehicle Ownership (Brand)` varchar(255) DEFAULT NULL,
  `Lifestyle [Always go to movie house]` varchar(255) DEFAULT NULL,
  `Lifestyle [Regularly eat in restaurant on weekends]` varchar(255) DEFAULT NULL,
  `Lifestyle [Always go on regular vacation]` varchar(255) DEFAULT NULL,
  `Lifestyle [I love the beach]` varchar(255) DEFAULT NULL,
  `Lifestyle [I love listening to music]` varchar(255) DEFAULT NULL,
  `Lifestyle [I love to stay at home (staycation)]` varchar(255) DEFAULT NULL,
  `Lifestyle [I love to stay overnight in a hotel]` varchar(255) DEFAULT NULL,
  `Lifestyle [I love to shop]` varchar(255) DEFAULT NULL,
  `Lifestyle [I like foreign trip]` varchar(255) DEFAULT NULL,
  `Lifestyle [I prefer local trip]` varchar(255) DEFAULT NULL,
  `Others` varchar(255) DEFAULT NULL,
  `Pick your top three (3) choices [New vehicle]` varchar(255) DEFAULT NULL,
  `Pick your top three (3) choices [Foreign Trip]` varchar(255) DEFAULT NULL,
  `Pick your top three (3) choices [Local Trip]` varchar(255) DEFAULT NULL,
  `Pick your top three (3) choices [Entrainment Package]` varchar(255) DEFAULT NULL,
  `Pick your top three (3) choices [Small Businss]` varchar(255) DEFAULT NULL,
  `Pick your top three (3) choices [Living room package]` varchar(255) DEFAULT NULL,
  `Pick your top three (3) choices [Weekend picnic/beach/swimming]` varchar(255) DEFAULT NULL,
  `Pick your top three (3) choices [Kitchen package]` varchar(255) DEFAULT NULL,
  `Pick your top three (3) choices [Bedroom package]` varchar(255) DEFAULT NULL,
  `Pick your top three (3) choices [Fancy dinner with partner/frien` varchar(255) DEFAULT NULL,
  `Pick your top three (3) choices [Family bonding]` varchar(255) DEFAULT NULL,
  `Pick your top three (3) choices [Jewelries]` varchar(255) DEFAULT NULL,
  `Others1` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`survey_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=625 ;

-- --------------------------------------------------------

--
-- Table structure for table `teles_survey_guinmar`
--

CREATE TABLE IF NOT EXISTS `teles_survey_guinmar` (
  `survey_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Username` varchar(255) DEFAULT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `Company ID` varchar(255) DEFAULT NULL,
  `Date of Birth` date DEFAULT NULL,
  `Contact Numbers (Mobile/Landline)` varchar(255) DEFAULT NULL,
  `Home Ownership` varchar(255) DEFAULT NULL,
  `Vehicle Ownership` varchar(255) DEFAULT NULL,
  `Vehicle Ownership (Quantity)` varchar(255) DEFAULT NULL,
  `Vehicle Ownership (Brand)` varchar(255) DEFAULT NULL,
  `Lifestyle [Always go to movie house]` varchar(255) DEFAULT NULL,
  `Lifestyle [Regularly eat in restaurant on weekends]` varchar(255) DEFAULT NULL,
  `Lifestyle [Always go on regular vacation]` varchar(255) DEFAULT NULL,
  `Lifestyle [I love the beach]` varchar(255) DEFAULT NULL,
  `Lifestyle [I love listening to music]` varchar(255) DEFAULT NULL,
  `Lifestyle [I love to stay at home (staycation)]` varchar(255) DEFAULT NULL,
  `Lifestyle [I love to stay overnight in a hotel]` varchar(255) DEFAULT NULL,
  `Lifestyle [I love to shop]` varchar(255) DEFAULT NULL,
  `Lifestyle [I like foreign trip]` varchar(255) DEFAULT NULL,
  `Lifestyle [I prefer local trip]` varchar(255) DEFAULT NULL,
  `Others` varchar(255) DEFAULT NULL,
  `Pick your top three (3) choices [New vehicle]` varchar(255) DEFAULT NULL,
  `Pick your top three (3) choices [Foreign Trip]` varchar(255) DEFAULT NULL,
  `Pick your top three (3) choices [Local Trip]` varchar(255) DEFAULT NULL,
  `Pick your top three (3) choices [Entrainment Package]` varchar(255) DEFAULT NULL,
  `Pick your top three (3) choices [Small Businss]` varchar(255) DEFAULT NULL,
  `Pick your top three (3) choices [Living room package]` varchar(255) DEFAULT NULL,
  `Pick your top three (3) choices [Weekend picnic/beach/swimming]` varchar(255) DEFAULT NULL,
  `Pick your top three (3) choices [Kitchen package]` varchar(255) DEFAULT NULL,
  `Pick your top three (3) choices [Bedroom package]` varchar(255) DEFAULT NULL,
  `Pick your top three (3) choices [Fancy dinner with partner/frien` varchar(255) DEFAULT NULL,
  `Pick your top three (3) choices [Family bonding]` varchar(255) DEFAULT NULL,
  `Pick your top three (3) choices [Jewelries]` varchar(255) DEFAULT NULL,
  `Others1` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`survey_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=413 ;

-- --------------------------------------------------------

--
-- Table structure for table `teles_survey_ok`
--

CREATE TABLE IF NOT EXISTS `teles_survey_ok` (
  `survey_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `Timestamp` datetime DEFAULT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `Email Address` varchar(255) DEFAULT NULL,
  `Company Id` varchar(255) NOT NULL DEFAULT '',
  `Date of Birth` date DEFAULT NULL,
  `Contact Number` varchar(255) DEFAULT NULL,
  `Home Ownership` varchar(255) DEFAULT NULL,
  `Car` varchar(255) DEFAULT NULL,
  `Pick-Up` varchar(255) DEFAULT NULL,
  `Motorbike` varchar(255) DEFAULT NULL,
  `Van` varchar(255) DEFAULT NULL,
  `SUV/AUV` varchar(255) DEFAULT NULL,
  `Others` varchar(255) DEFAULT NULL,
  `Quantity` varchar(255) DEFAULT NULL,
  `Brand` varchar(255) DEFAULT NULL,
  `Q1` varchar(255) DEFAULT NULL,
  `Q2` varchar(255) DEFAULT NULL,
  `Q3` varchar(255) DEFAULT NULL,
  `Q4` varchar(255) DEFAULT NULL,
  `Q5` varchar(255) DEFAULT NULL,
  `Q6` varchar(255) DEFAULT NULL,
  `Q7` varchar(255) DEFAULT NULL,
  `Q8` varchar(255) DEFAULT NULL,
  `Q9` varchar(255) DEFAULT NULL,
  `Q10` varchar(255) DEFAULT NULL,
  `Others1` varchar(255) DEFAULT NULL,
  `New Vehicle` varchar(255) DEFAULT NULL,
  `Foreign Trip` varchar(255) DEFAULT NULL,
  `Local Trip` varchar(255) DEFAULT NULL,
  `Entrainment Package` varchar(255) DEFAULT NULL,
  `Small Business` varchar(255) DEFAULT NULL,
  `Living Room Package` varchar(255) DEFAULT NULL,
  `Weekend picninc/beach/swimming` varchar(255) DEFAULT NULL,
  `Kitchen Package` varchar(255) DEFAULT NULL,
  `Bedroom Package` varchar(255) DEFAULT NULL,
  `Fancy dinner with partner/friend` varchar(255) DEFAULT NULL,
  `Family Bonding` varchar(255) DEFAULT NULL,
  `Jewelries` varchar(255) DEFAULT NULL,
  `Others2` varchar(255) DEFAULT NULL,
  `status` int(255) DEFAULT NULL,
  PRIMARY KEY (`survey_id`),
  UNIQUE KEY `company_id` (`Company Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2946 ;

-- --------------------------------------------------------

--
-- Table structure for table `teles_survey_ok_copy`
--

CREATE TABLE IF NOT EXISTS `teles_survey_ok_copy` (
  `survey_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `Timestamp` datetime DEFAULT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `Email Address` varchar(255) DEFAULT NULL,
  `Company Id` varchar(255) NOT NULL DEFAULT '',
  `Date of Birth` date DEFAULT NULL,
  `Contact Number` varchar(255) DEFAULT NULL,
  `Home Ownership` varchar(255) DEFAULT NULL,
  `Car` varchar(255) DEFAULT NULL,
  `Pick-Up` varchar(255) DEFAULT NULL,
  `Motorbike` varchar(255) DEFAULT NULL,
  `Van` varchar(255) DEFAULT NULL,
  `SUV/AUV` varchar(255) DEFAULT NULL,
  `Others` varchar(255) DEFAULT NULL,
  `Quantity` varchar(255) DEFAULT NULL,
  `Brand` varchar(255) DEFAULT NULL,
  `Q1` varchar(255) DEFAULT NULL,
  `Q2` varchar(255) DEFAULT NULL,
  `Q3` varchar(255) DEFAULT NULL,
  `Q4` varchar(255) DEFAULT NULL,
  `Q5` varchar(255) DEFAULT NULL,
  `Q6` varchar(255) DEFAULT NULL,
  `Q7` varchar(255) DEFAULT NULL,
  `Q8` varchar(255) DEFAULT NULL,
  `Q9` varchar(255) DEFAULT NULL,
  `Q10` varchar(255) DEFAULT NULL,
  `Others1` varchar(255) DEFAULT NULL,
  `New Vehicle` varchar(255) DEFAULT NULL,
  `Foreign Trip` varchar(255) DEFAULT NULL,
  `Local Trip` varchar(255) DEFAULT NULL,
  `Entrainment Package` varchar(255) DEFAULT NULL,
  `Small Business` varchar(255) DEFAULT NULL,
  `Living Room Package` varchar(255) DEFAULT NULL,
  `Weekend picninc/beach/swimming` varchar(255) DEFAULT NULL,
  `Kitchen Package` varchar(255) DEFAULT NULL,
  `Bedroom Package` varchar(255) DEFAULT NULL,
  `Fancy dinner with partner/friend` varchar(255) DEFAULT NULL,
  `Family Bonding` varchar(255) DEFAULT NULL,
  `Jewelries` varchar(255) DEFAULT NULL,
  `Others2` varchar(255) DEFAULT NULL,
  `status` int(255) DEFAULT NULL,
  PRIMARY KEY (`survey_id`),
  UNIQUE KEY `company_id` (`Company Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2920 ;

-- --------------------------------------------------------

--
-- Table structure for table `teles_survey_ok_copy1`
--

CREATE TABLE IF NOT EXISTS `teles_survey_ok_copy1` (
  `survey_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `Timestamp` datetime DEFAULT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `Email Address` varchar(255) DEFAULT NULL,
  `Company Id` varchar(255) NOT NULL DEFAULT '',
  `Date of Birth` date DEFAULT NULL,
  `Contact Number` varchar(255) DEFAULT NULL,
  `Home Ownership` varchar(255) DEFAULT NULL,
  `Car` varchar(255) DEFAULT NULL,
  `Pick-Up` varchar(255) DEFAULT NULL,
  `Motorbike` varchar(255) DEFAULT NULL,
  `Van` varchar(255) DEFAULT NULL,
  `SUV/AUV` varchar(255) DEFAULT NULL,
  `Others` varchar(255) DEFAULT NULL,
  `Quantity` varchar(255) DEFAULT NULL,
  `Brand` varchar(255) DEFAULT NULL,
  `Q1` varchar(255) DEFAULT NULL,
  `Q2` varchar(255) DEFAULT NULL,
  `Q3` varchar(255) DEFAULT NULL,
  `Q4` varchar(255) DEFAULT NULL,
  `Q5` varchar(255) DEFAULT NULL,
  `Q6` varchar(255) DEFAULT NULL,
  `Q7` varchar(255) DEFAULT NULL,
  `Q8` varchar(255) DEFAULT NULL,
  `Q9` varchar(255) DEFAULT NULL,
  `Q10` varchar(255) DEFAULT NULL,
  `Others1` varchar(255) DEFAULT NULL,
  `New Vehicle` varchar(255) DEFAULT NULL,
  `Foreign Trip` varchar(255) DEFAULT NULL,
  `Local Trip` varchar(255) DEFAULT NULL,
  `Entrainment Package` varchar(255) DEFAULT NULL,
  `Small Business` varchar(255) DEFAULT NULL,
  `Living Room Package` varchar(255) DEFAULT NULL,
  `Weekend picninc/beach/swimming` varchar(255) DEFAULT NULL,
  `Kitchen Package` varchar(255) DEFAULT NULL,
  `Bedroom Package` varchar(255) DEFAULT NULL,
  `Fancy dinner with partner/friend` varchar(255) DEFAULT NULL,
  `Family Bonding` varchar(255) DEFAULT NULL,
  `Jewelries` varchar(255) DEFAULT NULL,
  `Others2` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`survey_id`),
  UNIQUE KEY `company_id` (`Company Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2506 ;

-- --------------------------------------------------------

--
-- Table structure for table `teles_survey_ok_copy2`
--

CREATE TABLE IF NOT EXISTS `teles_survey_ok_copy2` (
  `survey_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `Timestamp` datetime DEFAULT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `Email Address` varchar(255) DEFAULT NULL,
  `Company Id` varchar(255) NOT NULL DEFAULT '',
  `Date of Birth` date DEFAULT NULL,
  `Contact Number` varchar(255) DEFAULT NULL,
  `Home Ownership` varchar(255) DEFAULT NULL,
  `Car` varchar(255) DEFAULT NULL,
  `Pick-Up` varchar(255) DEFAULT NULL,
  `Motorbike` varchar(255) DEFAULT NULL,
  `Van` varchar(255) DEFAULT NULL,
  `SUV/AUV` varchar(255) DEFAULT NULL,
  `Others` varchar(255) DEFAULT NULL,
  `Quantity` varchar(255) DEFAULT NULL,
  `Brand` varchar(255) DEFAULT NULL,
  `Q1` varchar(255) DEFAULT NULL,
  `Q2` varchar(255) DEFAULT NULL,
  `Q3` varchar(255) DEFAULT NULL,
  `Q4` varchar(255) DEFAULT NULL,
  `Q5` varchar(255) DEFAULT NULL,
  `Q6` varchar(255) DEFAULT NULL,
  `Q7` varchar(255) DEFAULT NULL,
  `Q8` varchar(255) DEFAULT NULL,
  `Q9` varchar(255) DEFAULT NULL,
  `Q10` varchar(255) DEFAULT NULL,
  `Others1` varchar(255) DEFAULT NULL,
  `New Vehicle` varchar(255) DEFAULT NULL,
  `Foreign Trip` varchar(255) DEFAULT NULL,
  `Local Trip` varchar(255) DEFAULT NULL,
  `Entrainment Package` varchar(255) DEFAULT NULL,
  `Small Business` varchar(255) DEFAULT NULL,
  `Living Room Package` varchar(255) DEFAULT NULL,
  `Weekend picninc/beach/swimming` varchar(255) DEFAULT NULL,
  `Kitchen Package` varchar(255) DEFAULT NULL,
  `Bedroom Package` varchar(255) DEFAULT NULL,
  `Fancy dinner with partner/friend` varchar(255) DEFAULT NULL,
  `Family Bonding` varchar(255) DEFAULT NULL,
  `Jewelries` varchar(255) DEFAULT NULL,
  `Others2` varchar(255) DEFAULT NULL,
  `status` int(255) DEFAULT NULL,
  PRIMARY KEY (`survey_id`),
  UNIQUE KEY `company_id` (`Company Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2920 ;

-- --------------------------------------------------------

--
-- Table structure for table `teles_survey_ok_copy3`
--

CREATE TABLE IF NOT EXISTS `teles_survey_ok_copy3` (
  `survey_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `Timestamp` datetime DEFAULT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `Email Address` varchar(255) DEFAULT NULL,
  `Company Id` varchar(255) NOT NULL DEFAULT '',
  `Date of Birth` date DEFAULT NULL,
  `Contact Number` varchar(255) DEFAULT NULL,
  `Home Ownership` varchar(255) DEFAULT NULL,
  `Car` varchar(255) DEFAULT NULL,
  `Pick-Up` varchar(255) DEFAULT NULL,
  `Motorbike` varchar(255) DEFAULT NULL,
  `Van` varchar(255) DEFAULT NULL,
  `SUV/AUV` varchar(255) DEFAULT NULL,
  `Others` varchar(255) DEFAULT NULL,
  `Quantity` varchar(255) DEFAULT NULL,
  `Brand` varchar(255) DEFAULT NULL,
  `Q1` varchar(255) DEFAULT NULL,
  `Q2` varchar(255) DEFAULT NULL,
  `Q3` varchar(255) DEFAULT NULL,
  `Q4` varchar(255) DEFAULT NULL,
  `Q5` varchar(255) DEFAULT NULL,
  `Q6` varchar(255) DEFAULT NULL,
  `Q7` varchar(255) DEFAULT NULL,
  `Q8` varchar(255) DEFAULT NULL,
  `Q9` varchar(255) DEFAULT NULL,
  `Q10` varchar(255) DEFAULT NULL,
  `Others1` varchar(255) DEFAULT NULL,
  `New Vehicle` varchar(255) DEFAULT NULL,
  `Foreign Trip` varchar(255) DEFAULT NULL,
  `Local Trip` varchar(255) DEFAULT NULL,
  `Entrainment Package` varchar(255) DEFAULT NULL,
  `Small Business` varchar(255) DEFAULT NULL,
  `Living Room Package` varchar(255) DEFAULT NULL,
  `Weekend picninc/beach/swimming` varchar(255) DEFAULT NULL,
  `Kitchen Package` varchar(255) DEFAULT NULL,
  `Bedroom Package` varchar(255) DEFAULT NULL,
  `Fancy dinner with partner/friend` varchar(255) DEFAULT NULL,
  `Family Bonding` varchar(255) DEFAULT NULL,
  `Jewelries` varchar(255) DEFAULT NULL,
  `Others2` varchar(255) DEFAULT NULL,
  `status` int(255) DEFAULT NULL,
  PRIMARY KEY (`survey_id`),
  UNIQUE KEY `company_id` (`Company Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2936 ;

-- --------------------------------------------------------

--
-- Table structure for table `teles_survey_ok_xx`
--

CREATE TABLE IF NOT EXISTS `teles_survey_ok_xx` (
  `survey_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `Timestamp` datetime DEFAULT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `Email Address` varchar(255) DEFAULT NULL,
  `Company Id` varchar(255) NOT NULL DEFAULT '',
  `Date of Birth` date DEFAULT NULL,
  `Contact Number` varchar(255) DEFAULT NULL,
  `Home Ownership` varchar(255) DEFAULT NULL,
  `Car` varchar(255) DEFAULT NULL,
  `Pick-Up` varchar(255) DEFAULT NULL,
  `Motorbike` varchar(255) DEFAULT NULL,
  `Van` varchar(255) DEFAULT NULL,
  `SUV/AUV` varchar(255) DEFAULT NULL,
  `Others` varchar(255) DEFAULT NULL,
  `Quantity` varchar(255) DEFAULT NULL,
  `Brand` varchar(255) DEFAULT NULL,
  `Q1` varchar(255) DEFAULT NULL,
  `Q2` varchar(255) DEFAULT NULL,
  `Q3` varchar(255) DEFAULT NULL,
  `Q4` varchar(255) DEFAULT NULL,
  `Q5` varchar(255) DEFAULT NULL,
  `Q6` varchar(255) DEFAULT NULL,
  `Q7` varchar(255) DEFAULT NULL,
  `Q8` varchar(255) DEFAULT NULL,
  `Q9` varchar(255) DEFAULT NULL,
  `Q10` varchar(255) DEFAULT NULL,
  `Others1` varchar(255) DEFAULT NULL,
  `New Vehicle` varchar(255) DEFAULT NULL,
  `Foreign Trip` varchar(255) DEFAULT NULL,
  `Local Trip` varchar(255) DEFAULT NULL,
  `Entrainment Package` varchar(255) DEFAULT NULL,
  `Small Business` varchar(255) DEFAULT NULL,
  `Living Room Package` varchar(255) DEFAULT NULL,
  `Weekend picninc/beach/swimming` varchar(255) DEFAULT NULL,
  `Kitchen Package` varchar(255) DEFAULT NULL,
  `Bedroom Package` varchar(255) DEFAULT NULL,
  `Fancy dinner with partner/friend` varchar(255) DEFAULT NULL,
  `Family Bonding` varchar(255) DEFAULT NULL,
  `Jewelries` varchar(255) DEFAULT NULL,
  `Others2` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`survey_id`),
  UNIQUE KEY `company_id` (`Company Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1068 ;

-- --------------------------------------------------------

--
-- Table structure for table `teles_survey_toto`
--

CREATE TABLE IF NOT EXISTS `teles_survey_toto` (
  `survey_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Username` varchar(255) DEFAULT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `Company ID` varchar(255) DEFAULT NULL,
  `Date of Birth` date DEFAULT NULL,
  `Contact Numbers (Mobile/Landline)` varchar(255) DEFAULT NULL,
  `Home Ownership` varchar(255) DEFAULT NULL,
  `Vehicle Ownership` varchar(255) DEFAULT NULL,
  `Vehicle Ownership (Quantity)` varchar(255) DEFAULT NULL,
  `Vehicle Ownership (Brand)` varchar(255) DEFAULT NULL,
  `Lifestyle [Always go to movie house]` varchar(255) DEFAULT NULL,
  `Lifestyle [Regularly eat in restaurant on weekends]` varchar(255) DEFAULT NULL,
  `Lifestyle [Always go on regular vacation]` varchar(255) DEFAULT NULL,
  `Lifestyle [I love the beach]` varchar(255) DEFAULT NULL,
  `Lifestyle [I love listening to music]` varchar(255) DEFAULT NULL,
  `Lifestyle [I love to stay at home (staycation)]` varchar(255) DEFAULT NULL,
  `Lifestyle [I love to stay overnight in a hotel]` varchar(255) DEFAULT NULL,
  `Lifestyle [I love to shop]` varchar(255) DEFAULT NULL,
  `Lifestyle [I like foreign trip]` varchar(255) DEFAULT NULL,
  `Lifestyle [I prefer local trip]` varchar(255) DEFAULT NULL,
  `Others` varchar(255) DEFAULT NULL,
  `Pick your top three (3) choices [New vehicle]` varchar(255) DEFAULT NULL,
  `Pick your top three (3) choices [Foreign Trip]` varchar(255) DEFAULT NULL,
  `Pick your top three (3) choices [Local Trip]` varchar(255) DEFAULT NULL,
  `Pick your top three (3) choices [Entrainment Package]` varchar(255) DEFAULT NULL,
  `Pick your top three (3) choices [Small Businss]` varchar(255) DEFAULT NULL,
  `Pick your top three (3) choices [Living room package]` varchar(255) DEFAULT NULL,
  `Pick your top three (3) choices [Weekend picnic/beach/swimming]` varchar(255) DEFAULT NULL,
  `Pick your top three (3) choices [Kitchen package]` varchar(255) DEFAULT NULL,
  `Pick your top three (3) choices [Bedroom package]` varchar(255) DEFAULT NULL,
  `Pick your top three (3) choices [Fancy dinner with partner/frien` varchar(255) DEFAULT NULL,
  `Pick your top three (3) choices [Family bonding]` varchar(255) DEFAULT NULL,
  `Pick your top three (3) choices [Jewelries]` varchar(255) DEFAULT NULL,
  `Others1` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`survey_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
