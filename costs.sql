-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 09, 2017 at 09:19 AM
-- Server version: 5.7.9
-- PHP Version: 5.6.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `costs`
--
CREATE DATABASE `costs` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `costs`;

-- --------------------------------------------------------

--
-- Table structure for table `commissions_and_shipping_costs`
--

DROP TABLE IF EXISTS `commissions_and_shipping_costs`;
CREATE TABLE IF NOT EXISTS `commissions_and_shipping_costs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `commission_value` double NOT NULL COMMENT '%',
  `shipping_cost` double NOT NULL COMMENT '$',
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `commissions_and_shipping_costs`
--

INSERT INTO `commissions_and_shipping_costs` (`id`, `commission_value`, `shipping_cost`, `user_id`) VALUES
(1, 5, 0, 1),
(9, 4, 4, 8),
(11, 3, 5, 9),
(12, 0, 0, 10);

-- --------------------------------------------------------

--
-- Table structure for table `costs`
--

DROP TABLE IF EXISTS `costs`;
CREATE TABLE IF NOT EXISTS `costs` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `cost_type` varchar(25) NOT NULL,
  `cost_amount` decimal(16,2) NOT NULL COMMENT '$',
  `description` varchar(80) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `costs`
--

INSERT INTO `costs` (`id`, `cost_type`, `cost_amount`, `description`) VALUES
(12, 'Rubber', '1.50', 'Rubber cost USD/Dozen'),
(13, 'Packing', '0.90', 'Packing cost USD/Dozen'),
(14, 'Other', '700.00', 'Other total monthly expenses/USD'),
(15, 'Profit Percent', '30.00', 'Profit percentage (%) /Dozen '),
(16, 'Production Capacity', '6000.00', 'Total monthly production/Dozens'),
(17, 'Salaries', '2100.00', 'Total monthly Salaries/USD'),
(18, 'Packing Weight', '300.00', 'Packing Grams/Dozen');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(50) NOT NULL,
  `country` varchar(15) NOT NULL,
  `city` varchar(15) NOT NULL,
  `address` varchar(200) NOT NULL,
  `phone` decimal(30,0) NOT NULL,
  `email` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `customer_name`, `country`, `city`, `address`, `phone`, `email`, `user_id`, `deleted`, `created_at`) VALUES
(1, 'Daniel fa', 'France', 'Paris', 'champs elyse, 12', '2147483647', 'Daniel.fa@gmail.com', 1, 0, 0),
(7, 'Firas dado', 'Lebanon', 'Beirut', 'Hamra, 18', '849534884324', 'F.dado@yahoo.com', 1, 0, 1485614033),
(8, 'Toni Vera', 'Turkey', 'Istanbul', 'Marmara, 24', '798458111887', 'RR1972@hotmail.com', 1, 0, 1485629080),
(9, 'Mark Black', 'UK', 'London', 'Bury,8', '798343423511', 'M.Black@yahoo.co.uk', 1, 0, 1485629213);

-- --------------------------------------------------------

--
-- Table structure for table `invoicesheader`
--

DROP TABLE IF EXISTS `invoicesheader`;
CREATE TABLE IF NOT EXISTS `invoicesheader` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `customer_id` int(16) NOT NULL,
  `user_id` int(11) NOT NULL,
  `commission_percent` double NOT NULL,
  `created_at` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `invoicesheader`
--

INSERT INTO `invoicesheader` (`id`, `customer_id`, `user_id`, `commission_percent`, `created_at`) VALUES
(21, 9, 8, 4, 1485635102),
(20, 8, 9, 3, 1485635012),
(19, 1, 10, 0, 1485634927),
(18, 7, 1, 5, 1485634850),
(22, 1, 1, 5, 1488380189);

-- --------------------------------------------------------

--
-- Table structure for table `invoicesitems`
--

DROP TABLE IF EXISTS `invoicesitems`;
CREATE TABLE IF NOT EXISTS `invoicesitems` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `invoice_header_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` decimal(16,0) NOT NULL,
  `price` decimal(16,2) NOT NULL,
  `commission` decimal(16,2) NOT NULL,
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `invoicesitems`
--

INSERT INTO `invoicesitems` (`id`, `invoice_header_id`, `product_id`, `quantity`, `price`, `commission`, `created_at`) VALUES
(43, 21, 5, '23', '11.86', '0.36', 1485635102),
(42, 21, 13, '22', '11.92', '0.36', 1485635102),
(41, 21, 2, '55', '11.72', '0.35', 1485635102),
(40, 21, 3, '45', '9.97', '0.31', 1485635102),
(39, 20, 6, '30', '10.19', '0.23', 1485635012),
(38, 20, 10, '300', '13.30', '0.28', 1485635012),
(37, 19, 6, '50', '7.71', '0.00', 1485634927),
(36, 19, 13, '100', '8.96', '0.00', 1485634927),
(35, 18, 10, '400', '9.84', '0.47', 1485634850),
(34, 18, 3, '330', '8.25', '0.39', 1485634850),
(33, 18, 6, '200', '8.09', '0.39', 1485634850),
(32, 18, 12, '300', '8.96', '0.43', 1485634850),
(31, 17, 1, '8', '11.76', '0.27', 1481907054),
(44, 22, 2, '400', '9.20', '0.44', 1488380189),
(45, 22, 6, '200', '8.09', '0.39', 1488380190),
(46, 22, 5, '100', '9.38', '0.45', 1488380190);

-- --------------------------------------------------------

--
-- Table structure for table `price_list_header`
--

DROP TABLE IF EXISTS `price_list_header`;
CREATE TABLE IF NOT EXISTS `price_list_header` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `customer_id` int(16) NOT NULL,
  `user_id` int(11) NOT NULL,
  `commission_percent` double NOT NULL,
  `created_at` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `price_list_header`
--

INSERT INTO `price_list_header` (`id`, `customer_id`, `user_id`, `commission_percent`, `created_at`) VALUES
(14, 7, 1, 5, 1485635908),
(12, 8, 9, 3, 1485635296),
(11, 1, 10, 0, 1485635236),
(10, 9, 8, 4, 1485635155);

-- --------------------------------------------------------

--
-- Table structure for table `price_list_item`
--

DROP TABLE IF EXISTS `price_list_item`;
CREATE TABLE IF NOT EXISTS `price_list_item` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `price_list_header_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` decimal(16,2) NOT NULL,
  `commission` decimal(16,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=48 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `price_list_item`
--

INSERT INTO `price_list_item` (`id`, `price_list_header_id`, `product_id`, `price`, `commission`) VALUES
(29, 11, 7, '9.08', '0.00'),
(28, 11, 12, '8.53', '0.00'),
(27, 11, 13, '8.96', '0.00'),
(26, 11, 6, '7.71', '0.00'),
(25, 10, 6, '9.82', '0.31'),
(24, 10, 3, '9.97', '0.31'),
(23, 10, 5, '11.86', '0.36'),
(22, 10, 10, '12.67', '0.37'),
(21, 10, 2, '11.72', '0.35'),
(20, 10, 7, '12.04', '0.36'),
(19, 10, 12, '11.19', '0.34'),
(18, 10, 11, '11.72', '0.36'),
(17, 10, 13, '11.92', '0.36'),
(30, 11, 2, '8.77', '0.00'),
(31, 12, 6, '10.19', '0.23'),
(32, 12, 10, '13.30', '0.28'),
(33, 12, 3, '10.35', '0.24'),
(34, 12, 5, '12.41', '0.27'),
(39, 14, 10, '9.84', '0.47'),
(40, 14, 1, '9.96', '0.47'),
(41, 14, 9, '10.71', '0.51'),
(42, 14, 11, '9.37', '0.45'),
(43, 14, 6, '8.09', '0.39'),
(44, 14, 3, '8.25', '0.39'),
(45, 14, 5, '9.38', '0.45');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `availiable` tinyint(1) NOT NULL DEFAULT '1',
  `product_name` varchar(40) NOT NULL,
  `type_id` varchar(25) NOT NULL,
  `outer_yarn_percent` int(16) NOT NULL,
  `outer_yarn_id` varchar(20) NOT NULL,
  `inner_yarn_percent` int(16) NOT NULL,
  `inner_yarn_id` varchar(20) NOT NULL,
  `weight_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `create_date` int(11) NOT NULL,
  `picture` varchar(500) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `availiable`, `product_name`, `type_id`, `outer_yarn_percent`, `outer_yarn_id`, `inner_yarn_percent`, `inner_yarn_id`, `weight_id`, `user_id`, `create_date`, `picture`, `deleted`) VALUES
(1, 1, '381', '1', 100, '1', 0, '0', 8, 1, 1481370354, 'uploads/3456d64ad9e6af168a7258d506ebbcd0.jpg', 0),
(2, 1, '515', '2', 50, '1', 50, '2', 2, 8, 1481370379, 'uploads/8d82a016f5cc2b311030ea6049d70c6f.jpg', 0),
(3, 1, '250', '3', 100, '1', 0, '0', 5, 9, 1481370403, 'uploads/41f628d64faa4040c997a3defd674c97.jpg', 0),
(5, 1, '205', '3', 80, '1', 20, '2', 9, 1, 1481709597, 'uploads/7c5d01626d120c83cb7961c7f4b6bc78.jpg', 0),
(6, 1, '270', '3', 75, '1', 25, '4', 5, 9, 1481803459, 'uploads/d92b19112f461f0f45fab2799f32ef21.jpg', 0),
(7, 1, '557', '2', 90, '1', 10, '2', 2, 1, 1481803497, 'uploads/27d5925af1539166a72c95db888638ed.jpg', 0),
(9, 1, '364', '1', 100, '6', 0, '0', 8, 8, 1481803543, 'uploads/47e4edc9c6b13da302943c913c7bfc49.jpg', 0),
(10, 1, '387', '1', 65, '3', 35, '4', 3, 1, 1481803568, 'uploads/0674e4c0e750c346a9f3bd874f7a32ad.jpg', 0),
(11, 1, '328', '1', 100, '1', 0, '1', 1, 10, 1481803602, 'uploads/d072266a58c96a15322cea171b843037.jpg', 0),
(12, 1, '587', '2', 80, '1', 20, '4', 4, 1, 1485603911, 'uploads/0341b928fc714c7aa92f91033d1ebb04.jpg', 0),
(13, 1, '561', '2', 80, '1', 20, '4', 2, 1, 1485604599, 'uploads/85086c96641158168cdb0f887901c661.png', 0);

-- --------------------------------------------------------

--
-- Table structure for table `type`
--

DROP TABLE IF EXISTS `type`;
CREATE TABLE IF NOT EXISTS `type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `type`
--

INSERT INTO `type` (`id`, `type_name`) VALUES
(1, 'Men'),
(2, 'Women'),
(3, 'Children');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL DEFAULT '2',
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `auth_key` varchar(255) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `group_id`, `first_name`, `last_name`, `username`, `email`, `password`, `auth_key`, `created_at`, `updated_at`) VALUES
(1, 1, 'Safoh', 'Sassa', 'ms79ms', 'ms79ms@gmail.com', '$2y$13$mn18UxZxj62Z.oJe25DuceEOCp7cFd/SBjEmSyUp9P7PGU6nd6JN.', '', 1478988958, 1481812698),
(8, 2, 'Rani', 'Rava', 'RR', 'rani@yahoo.com', '$2y$13$nmjGSfejhnT3H8JhFud5NuTLBNgPI10nHPMECYXijWgGMOoQE0le.', 'deks_OBrJ5ixDn_6SGisni-gOVNJQ7f-', 1478988958, 1478988958),
(9, 2, 'Maher', 'Masri', 'Mah', 'maher@yahoo.com', '$2y$13$.7qfOh17mv.x.HZD82f0/.WcRZmIGMu/4/98C2lroUmf7USPl5pqS', 'RExDXs1D_T7LqesXAMYGaroReHEE1VLT', 1478988958, 1478988958),
(10, 1, 'Marina', 'brown', 'MA.BR', 'Marin.b@hotmail.com', '$2y$13$DcPdZnP4i1RwsLk7OQyXVuwG0sjZ.PIrd573BKx2DPYFiRzf9zuBS', '8z3JE9cFqeVeroK0L-a_-RIYCFhBI80O', 1478988958, 1485609601);

-- --------------------------------------------------------

--
-- Table structure for table `user_group`
--

DROP TABLE IF EXISTS `user_group`;
CREATE TABLE IF NOT EXISTS `user_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_slug` varchar(255) NOT NULL,
  `group_name` varchar(255) NOT NULL,
  `group_description` varchar(255) NOT NULL,
  `group_created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_group`
--

INSERT INTO `user_group` (`id`, `group_slug`, `group_name`, `group_description`, `group_created_at`) VALUES
(1, 'admin', 'Admin', 'This is administrator of the website. ', 1476889524),
(2, 'user', 'User', 'This is regular user', 1476889524);

-- --------------------------------------------------------

--
-- Table structure for table `weight`
--

DROP TABLE IF EXISTS `weight`;
CREATE TABLE IF NOT EXISTS `weight` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weight_gram` double(16,2) NOT NULL,
  `type_id` int(11) NOT NULL,
  `size` varchar(20) NOT NULL,
  `description` varchar(255) NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `weight`
--

INSERT INTO `weight` (`id`, `weight_gram`, `type_id`, `size`, `description`, `deleted`) VALUES
(1, 460.00, 1, '44', 'short leg', 0),
(2, 500.00, 2, '40', 'Long Leg', 0),
(3, 580.00, 1, '42', 'Long Leg', 0),
(4, 430.00, 2, '42', 'short leg', 0),
(5, 300.00, 3, '4', 'short leg', 0),
(7, 300.00, 3, '2', 'Long leg', 0),
(8, 550.00, 1, '46', 'Long Leg', 0),
(9, 490.00, 3, '6', 'Long Leg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `yarns`
--

DROP TABLE IF EXISTS `yarns`;
CREATE TABLE IF NOT EXISTS `yarns` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `yarn_name` varchar(50) NOT NULL,
  `cost` double(16,2) NOT NULL,
  `description` varchar(300) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `yarns`
--

INSERT INTO `yarns` (`id`, `yarn_name`, `cost`, `description`, `deleted`) VALUES
(1, 'Cotton', 5.00, 'Combed', 0),
(2, 'Lycra', 3.80, '', 0),
(3, 'Wool', 5.19, '', 0),
(4, 'Nylon', 3.50, '', 0),
(6, 'Silk', 6.00, '', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
