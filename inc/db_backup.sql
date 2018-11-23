-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 23, 2018 at 07:47 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `api_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` int(11) NOT NULL,
  `code` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` int(3) DEFAULT NULL,
  `type` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Valid Values :($,%)',
  `total_valid_time` int(10) DEFAULT '0',
  `valid_time` int(10) DEFAULT '0',
  `expired` int(1) DEFAULT '0' COMMENT 'if the code was exipred on not, and valid values are:\nTRUE\nFALSE',
  `status` int(1) DEFAULT '1' COMMENT '0 = inactive\n1 = Active\n',
  `created` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `value`, `type`, `total_valid_time`, `valid_time`, `expired`, `status`, `created`) VALUES
(6, 'OFFER30%', 30, '%', 3, 2, 0, 1, '2018-10-23 13:14:03'),
(7, 'OFFER40%', 40, '%', 15, 4, 0, 1, '2018-10-23 13:14:22'),
(8, 'OFFER20%', 20, '%', 1, 0, 0, 1, '2018-10-23 13:14:43'),
(9, 'OFFER50%', 50, '%', 1, 0, 0, 0, '2018-10-23 13:15:48'),
(10, 'OFFER70%', 70, '%', 1, 0, 0, 1, '2018-10-23 13:16:02'),
(11, 'OFFER80%', 80, '%', 10, 0, 0, 1, '2018-11-23 18:36:12');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_ID` int(11) NOT NULL,
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `joined` int(15) NOT NULL,
  `updated` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_ID`, `name`, `email`, `joined`, `updated`) VALUES
(1, 'admin', 'admin@moakt.ws', 1537472812, 1537472812);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `fname` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `lname` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `gender` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Valid values:\nM=Male\nF=Female',
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `fname`, `lname`, `gender`, `email`, `password`, `token`, `created`) VALUES
(6, 'nabil', 'ramadan', 'M', 'admin@moakt.ws', '', '32e8dd35b45fd4488aad9d77016dfad33ca1ac1b0b5e5aa723fc013fb033bb22', '2018-10-27 13:26:20'),
(7, 'Ali', 'ramadan', 'M', 'ali@moakt.ws', '', 'e6eddace15937b55b5126a5150926d8c7bf8523ece314e091f88c19a30bb328a', '2018-10-27 13:43:39'),
(8, 'Sara', 'ramadan', 'F', 'sara@moakt.ws', '', 'f528553bc69ec24462afd52848e11d26c65f8aaea969ea6d3c73e5306fbd01c1', '2018-10-27 13:54:48'),
(9, 'Fatima', 'ramadan', 'F', 'fatima@moakt.ws', '', '287d318acfb4993f560be8d18e32fd79c2e8335a6b86e3d8948284d9197e060d', '2018-10-27 14:01:46'),
(10, 'Mona', 'ramadan', 'F', 'mona@moakt.ws', '', '01389910df0a19b4dca7afd224e969ab52442e20685b47edbed43abb3425d10d', '2018-10-27 17:05:01'),
(11, 'nabil', 'ramadan', 'M', 'mramouchy@gmail.com', '', '0ae40bef583343ea46540b5650bf694bcb4911e100f4e241583bb6672d67fc17', '2018-11-14 16:31:26'),
(12, 'Mr', 'Med', 'M', 'mramouchy@gmail.com', '', '1ebbb2c5d7ad0aa910d58bb4267e2dac6017ad134538ece173dd55d8f2365cc0', '2018-11-17 16:29:17'),
(13, 'nabil', 'ramadan', 'M', 'nabil@moakt.ws', '', 'd73b12ab91161fde4d5329ba76f9ee93709339f945733efededbdf132fcdb964', '2018-11-23 18:27:24');

-- --------------------------------------------------------

--
-- Table structure for table `domains`
--

CREATE TABLE `domains` (
  `domain_ID` int(11) NOT NULL,
  `license_ID` int(11) NOT NULL,
  `IP` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `domain_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `listener` varchar(300) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `product_version` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `active` int(1) NOT NULL,
  `created` int(15) NOT NULL,
  `last_modification` int(15) NOT NULL,
  `last_check` int(15) NOT NULL,
  `checks_num` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci;

--
-- Dumping data for table `domains`
--

INSERT INTO `domains` (`domain_ID`, `license_ID`, `IP`, `domain_name`, `listener`, `product_version`, `active`, `created`, `last_modification`, `last_check`, `checks_num`) VALUES
(1, 1, '127.0.0.1', 'localhost', 'http://localhost/ci-copy/MR4Web_Listener_363baea9cba210afac6d7a556fca596e30c46333', '1.1.0', 1, 1537472812, 1537472812, 1537472812, 1);

-- --------------------------------------------------------

--
-- Table structure for table `emails`
--

CREATE TABLE `emails` (
  `id` int(11) NOT NULL,
  `name` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `content` mediumtext COLLATE utf8_unicode_ci,
  `isHTML` int(1) DEFAULT '0',
  `created` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `features`
--

CREATE TABLE `features` (
  `feature_ID` int(11) NOT NULL,
  `update_ID` int(11) NOT NULL,
  `feature_desc` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `features`
--

INSERT INTO `features` (`feature_ID`, `update_ID`, `feature_desc`) VALUES
(1, 1, 'Advanced Dashboard & Analytics.'),
(2, 1, 'Includes Supports For 6 Months.'),
(3, 1, 'And More Features Comming SOON.');

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` int(11) NOT NULL,
  `products_id` int(11) NOT NULL,
  `name` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `size` int(11) NOT NULL DEFAULT '0',
  `created` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id`, `products_id`, `name`, `path`, `size`, `created`) VALUES
(40, 60, 'Coins_Accelerator_v3.2.4(beta).rar', 'C:/xampp/htdocs/test/gateway/inc/uploads/users/ID_1/products/Coins_Accelerator_v3.2.4(beta).rar', 2900180, '2018-11-21 16:16:01'),
(43, 1, 'AdLinker_7.0_alfa_1542892728.rar', 'C:/xampp/htdocs/test/gateway/inc/uploads/users/ID_1/products/AdLinker_7.0_alfa_1542892728.rar', 2900180, '2018-11-22 13:18:48'),
(44, 2, 'Coins_Accelerator_v3.2.4(beta)_1542892737.rar', 'C:/xampp/htdocs/test/gateway/inc/uploads/users/ID_1/products/Coins_Accelerator_v3.2.4(beta)_1542892737.rar', 2900180, '2018-11-22 13:18:57'),
(46, 63, 'AdLinker_8.0_alfa.rar', 'C:/xampp/htdocs/test/gateway/inc/uploads/users/ID_1/products/AdLinker_8.0_alfa.rar', 2900180, '2018-11-22 16:03:28'),
(52, 56, 'Coins_Accelerator_v3.2.4(beta)_1542981204.rar', 'C:/xampp/htdocs/test/gateway/inc/uploads/users/ID_1/products/Coins_Accelerator_v3.2.4(beta)_1542981204.rar', 2900180, '2018-11-23 13:53:24');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `invoice_id` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `transactions_id` int(11) NOT NULL,
  `customers_id` int(11) NOT NULL,
  `plans_id` int(11) NOT NULL,
  `coupons_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `invoice_id`, `transactions_id`, `customers_id`, `plans_id`, `coupons_id`, `created`) VALUES
(18, '#1542215681', 35, 11, 1, NULL, '2018-11-14 17:16:40'),
(19, '#1542215892', 36, 11, 1, NULL, '2018-11-14 17:18:49'),
(20, '#1542216167', 37, 11, 1, NULL, '2018-11-14 17:23:24'),
(21, '#1542216289', 38, 11, 1, NULL, '2018-11-14 17:25:25'),
(22, '#1542216373', 39, 11, 1, NULL, '2018-11-14 17:27:29'),
(23, '#1542216504', 40, 11, 1, NULL, '2018-11-14 17:29:03'),
(24, '#1542216877', 41, 11, 1, NULL, '2018-11-14 17:36:08'),
(25, '#1542217071', 42, 11, 1, NULL, '2018-11-14 17:38:32'),
(26, '#1542217163', 43, 11, 1, NULL, '2018-11-14 17:40:01'),
(27, '#1542223158', 44, 11, 1, NULL, '2018-11-14 19:20:17'),
(28, '#1542223259', 45, 11, 1, NULL, '2018-11-14 19:21:54'),
(29, '#1542223940', 46, 11, 1, NULL, '2018-11-14 19:33:04'),
(30, '#1542224467', 47, 11, 1, NULL, '2018-11-14 19:42:04'),
(31, '#1542224976', 48, 11, 1, NULL, '2018-11-14 19:50:22'),
(32, '#1542226093', 49, 11, 1, NULL, '2018-11-14 20:09:10'),
(33, '#1-11-154222797', 50, 11, 1, 7, '2018-11-14 20:40:18'),
(34, '#1-11-154222811', 51, 11, 1, 7, '2018-11-14 20:42:35'),
(35, '#1542228455', 52, 11, 1, NULL, '2018-11-14 20:48:12'),
(36, '#1542472157', 53, 12, 1, 7, '2018-11-17 16:30:55'),
(37, '#1542472432', 54, 12, 1, 7, '2018-11-17 16:34:31'),
(38, '#1542981614', 55, 11, 8, NULL, '2018-11-23 14:01:41'),
(39, '#1542983268', 56, 11, 8, NULL, '2018-11-23 14:28:40'),
(40, '#1542983719', 57, 11, 8, NULL, '2018-11-23 14:35:59'),
(41, '#1542983960', 58, 11, 8, NULL, '2018-11-23 14:39:58'),
(42, '#1542997656', 59, 11, 8, NULL, '2018-11-23 18:29:04'),
(43, '#1542998288', 60, 11, 2, NULL, '2018-11-23 18:39:13');

-- --------------------------------------------------------

--
-- Table structure for table `license`
--

CREATE TABLE `license` (
  `license_ID` int(11) NOT NULL,
  `product_ID` int(11) NOT NULL,
  `customer_ID` int(11) NOT NULL,
  `license_code` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `activation_num` int(11) NOT NULL,
  `activation_max` int(11) NOT NULL,
  `banned` int(1) NOT NULL,
  `created` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `license`
--

INSERT INTO `license` (`license_ID`, `product_ID`, `customer_ID`, `license_code`, `activation_num`, `activation_max`, `banned`, `created`) VALUES
(1, 1, 1, 'AAAAAAAAAA', 1, 1, 0, 1537472812);

-- --------------------------------------------------------

--
-- Table structure for table `licenses`
--

CREATE TABLE `licenses` (
  `id` int(11) NOT NULL,
  `license_code` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `activation_num` int(11) NOT NULL,
  `activation_max` int(11) NOT NULL,
  `banned` int(1) NOT NULL,
  `license_type` varchar(1) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Valid Values:\nM=Month\nY=Year\nL=Lifetime\n',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `products_id` int(11) NOT NULL DEFAULT '0',
  `customers_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `licenses`
--

INSERT INTO `licenses` (`id`, `license_code`, `activation_num`, `activation_max`, `banned`, `license_type`, `created`, `products_id`, `customers_id`) VALUES
(7, '2a84b29ba2e71e28729e580e6004d5774a277ff4', 0, 1, 0, '', '2018-11-12 18:55:33', 1, 7),
(8, 'b97b7b80e60a9041fa7bf383e274ef97d900c294', 0, 1, 0, '', '2018-11-12 18:55:44', 1, 7),
(9, '3548b0b60f3d7ab0650f3d45e2ae3da5b5cd5d12', 0, 1, 0, '', '2018-11-12 18:57:11', 1, 9),
(14, '8c47e8b66050a99cc8924b01ad84f156cb0cb712', 0, 1, 0, 'L', '2018-11-22 15:40:01', 1, 11),
(15, '22a87727589001b80b4e519c2ec2ab6296431ee2', 0, 1, 0, 'L', '2018-11-22 15:40:02', 1, 11);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `news_ID` int(11) NOT NULL,
  `product_ID` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `image_URL` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `news_URL` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`news_ID`, `product_ID`, `title`, `description`, `image_URL`, `news_URL`, `created`) VALUES
(1, 1, 'ADLinker v1.5 coming soon.', 'Be ready, And Make Sure That you Get your Newest Version.', 'http://localhost/ci-copy/img/pexels-1.jpg', 'http://www.mr4web.com/news/ADLinker-v1.5-coming-soon', 154651654),
(2, 1, 'Earn Coins Calculator - just for $15.', 'Earn Coins Calculator will helps you to save your calculation time, easy to use, fast access and more.', 'http://localhost/ci-copy/img/pexels-2.jpg', 'http://www.mr4web.com/news/Earn-Coins-Calculator-just-for-$15.', 524651654);

-- --------------------------------------------------------

--
-- Table structure for table `payers`
--

CREATE TABLE `payers` (
  `id` int(11) NOT NULL,
  `payer_id` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fname` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lname` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country_code` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `payers`
--

INSERT INTO `payers` (`id`, `payer_id`, `fname`, `lname`, `email`, `country_code`, `created`) VALUES
(4, 'J2ANWP7EVU698', 'test', 'buyer', 'med-buyer@gmail.com', 'MA', '2018-10-27 13:44:14'),
(5, 'J2ANWP7EVU698', 'test', 'buyer', 'ramouchy-buyer@gmail.com', 'MA', '2018-10-27 14:02:26'),
(6, 'J2ANWP7EVU698', 'test', 'buyer', 'medramouchy-buyer@gmail.com', 'MA', '2018-10-27 17:05:35');

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` int(11) NOT NULL,
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `image_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `name`, `image_url`, `description`, `created`) VALUES
(1, 'PayPal', 'assets/images/paypal_logo.png', 'Pay with paypal easily.', '2018-10-22 17:44:16');

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `id` int(11) NOT NULL,
  `products_id` int(11) NOT NULL,
  `name` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `desc` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `price` float DEFAULT '0',
  `old_price` float DEFAULT '0',
  `plan_type` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Valid Values:\nM=Month\nY=Year\nL=Lifetime\n',
  `max_licenses` int(10) NOT NULL DEFAULT '0',
  `modified` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`id`, `products_id`, `name`, `desc`, `price`, `old_price`, `plan_type`, `max_licenses`, `modified`, `created`) VALUES
(1, 1, '1 License', 'ADLinker v1.2 - Lifetime license.', 67, 0, 'L', 2, '2018-11-22 15:39:51', '2018-10-22 20:25:46'),
(2, 1, '3 License', 'ADLinker v1.2 - Lifetime license.', 140.7, 201, 'L', 2, '2018-11-22 15:39:51', '2018-10-22 20:27:47'),
(3, 1, '10 License', 'ADLinker v1.2 - Lifetime license.', 335, 670, 'L', 2, '2018-11-22 15:39:51', '2018-10-22 20:28:32'),
(4, 2, 'Gold', 'cold plan', 99, 200, 'Y', 5, '2018-11-18 20:28:08', '2018-11-18 20:28:08'),
(7, 2, 'Selver', 'xflkdfg', 120, 220, 'Y', 10, '2018-11-18 20:47:45', '2018-11-18 20:47:45'),
(8, 56, 'Lifetime License', 'Lifetime License 20%OFF', 195, 499, 'L', 1, '2018-11-23 13:54:52', '2018-11-23 13:54:52');

-- --------------------------------------------------------

--
-- Table structure for table `plans_coupons`
--

CREATE TABLE `plans_coupons` (
  `id` int(11) NOT NULL,
  `plans_id` int(11) NOT NULL,
  `coupons_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `plans_coupons`
--

INSERT INTO `plans_coupons` (`id`, `plans_id`, `coupons_id`) VALUES
(36, 2, 9),
(37, 3, 10),
(48, 1, 7),
(49, 2, 11);

-- --------------------------------------------------------

--
-- Table structure for table `plans_features`
--

CREATE TABLE `plans_features` (
  `id` int(11) NOT NULL,
  `Plans_id` int(11) NOT NULL,
  `name` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_ID` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `version` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `price` float NOT NULL,
  `created` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_ID`, `name`, `version`, `price`, `created`) VALUES
(1, 'ADLinker', '1.2', 49, 1536235464);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `name` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `version` varchar(13) COLLATE utf8_unicode_ci DEFAULT NULL,
  `small_desc` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email_support` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `created` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `users_id`, `name`, `version`, `small_desc`, `email_support`, `created`) VALUES
(1, 1, 'ADLinker', '1.2', 'Revenue Accelerator', 'adlinker@moakt.ws', '2018-10-22 20:16:16'),
(2, 1, 'CoinLator', '1.0', 'Calculate revenue of coins automatically !', 'coinlator@moakt.ws', '2018-11-13 19:37:46'),
(3, 1, 'dddd', 'v1.2.', 'qsdqsdqsdqsd', 'adlinker@moakt.ws', '2018-11-19 18:07:28'),
(4, 1, 'nabil ramadan', 'v1.2.', 'Calculate revenue of coins automatically !', 'coinlator@moakt.ws', '2018-11-19 18:25:19'),
(6, 1, 'nabil ramadan', 'v1.2.', 'Calculate revenue of coins automatically !', 'coinlator@moakt.ws', '2018-11-19 18:28:16'),
(8, 1, 'nabil ramadan', 'v1.2.', 'qsdqsdqsdqsd', 'coinlator@moakt.ws', '2018-11-19 18:33:11'),
(9, 1, 'nabil ramadan', 'v1.2.', 'Calculate revenue of coins automatically !', 'coinlator@moakt.ws', '2018-11-19 18:34:23'),
(10, 1, 'nabil ramadan', 'v1.2.', 'Calculate revenue of coins automatically !', 'coinlator@moakt.ws', '2018-11-19 18:37:46'),
(11, 1, 'nabil ramadan', 'v1.2.', 'Calculate revenue of coins automatically !', 'coinlator@moakt.ws', '2018-11-19 18:38:31'),
(12, 1, 'fdsfgdfg', 'v1.0', 'Calculate revenue of coins automatically !', 'coinlator@moakt.ws', '2018-11-19 19:30:15'),
(13, 1, 'fdsfgdfg', 'v1.0', 'Calculate revenue of coins automatically !', 'coinlator@moakt.ws', '2018-11-19 19:36:19'),
(14, 1, 'fdsfgdfg', 'v1.0', 'Calculate revenue of coins automatically !', 'coinlator@moakt.ws', '2018-11-19 19:37:03'),
(15, 1, 'fdsfgdfg', 'v1.0', 'Calculate revenue of coins automatically !', 'coinlator@moakt.ws', '2018-11-19 19:37:33'),
(16, 1, 'fdsfgdfg', 'v1.0', 'Calculate revenue of coins automatically !', 'coinlator@moakt.ws', '2018-11-19 19:38:49'),
(17, 1, 'fdsfgdfg', 'v1.0', 'Calculate revenue of coins automatically !', 'coinlator@moakt.ws', '2018-11-19 19:39:14'),
(18, 1, 'fdsfgdfg', 'v1.0', 'Calculate revenue of coins automatically !', 'coinlator@moakt.ws', '2018-11-19 19:39:32'),
(19, 1, 'qsdqsdqs', 'v1.0', 'Calculate revenue of coins automatically !', 'adlinker@moakt.ws', '2018-11-19 20:02:54'),
(20, 1, 'qsdqsdqs', 'v1.0', 'Calculate revenue of coins automatically !', 'adlinker@moakt.ws', '2018-11-19 20:03:34'),
(21, 1, 'qsdqsdqs', 'v1.0', 'Calculate revenue of coins automatically !', 'adlinker@moakt.ws', '2018-11-19 20:19:10'),
(22, 1, 'qsdqsdqs', 'v1.0', 'Calculate revenue of coins automatically !', 'adlinker@moakt.ws', '2018-11-19 20:20:45'),
(23, 1, 'qsdqsdqs', 'v1.0', 'Calculate revenue of coins automatically !', 'adlinker@moakt.ws', '2018-11-19 20:21:03'),
(24, 1, 'qsdqsdqs', 'v1.0', 'Calculate revenue of coins automatically !', 'adlinker@moakt.ws', '2018-11-19 20:22:41'),
(25, 1, 'qsdqsdqs', 'v1.0', 'Calculate revenue of coins automatically !', 'adlinker@moakt.ws', '2018-11-19 20:24:58'),
(26, 1, 'qsdqsdqs', 'v1.0', 'Calculate revenue of coins automatically !', 'adlinker@moakt.ws', '2018-11-19 20:25:28'),
(27, 1, 'qsdqsdqs', 'v1.0', 'Calculate revenue of coins automatically !', 'adlinker@moakt.ws', '2018-11-19 20:25:54'),
(28, 1, 'qsdqsdqs', 'v1.0', 'Calculate revenue of coins automatically !', 'adlinker@moakt.ws', '2018-11-19 20:26:08'),
(29, 1, 'qsdqsdqs', 'v1.0', 'Calculate revenue of coins automatically !', 'adlinker@moakt.ws', '2018-11-19 20:26:26'),
(31, 1, 'qsdqsdqs', 'v1.0', 'Calculate revenue of coins automatically !', 'adlinker@moakt.ws', '2018-11-19 20:27:29'),
(32, 1, 'qsdqsdqs', 'v1.0', 'Calculate revenue of coins automatically !', 'adlinker@moakt.ws', '2018-11-19 20:27:43'),
(33, 1, 'qsdqsdqs', 'v1.0', 'Calculate revenue of coins automatically !', 'adlinker@moakt.ws', '2018-11-19 20:27:53'),
(34, 1, 'qsdqsdqs', 'v1.0', 'Calculate revenue of coins automatically !', 'adlinker@moakt.ws', '2018-11-19 20:28:33'),
(35, 1, 'qsdqsdqs', 'v1.0', 'Calculate revenue of coins automatically !', 'adlinker@moakt.ws', '2018-11-19 20:28:42'),
(36, 1, 'qsdqsdqs', 'v1.0', 'Calculate revenue of coins automatically !', 'adlinker@moakt.ws', '2018-11-19 20:45:35'),
(37, 1, 'qsdqsdqs', 'v1.0', 'Calculate revenue of coins automatically !', 'adlinker@moakt.ws', '2018-11-19 20:45:47'),
(38, 1, 'qsdqsdqs', 'v1.0', 'Calculate revenue of coins automatically !', 'adlinker@moakt.ws', '2018-11-19 20:46:19'),
(39, 1, 'qsdqsdqs', 'v1.0', 'Calculate revenue of coins automatically !', 'adlinker@moakt.ws', '2018-11-19 20:50:03'),
(40, 1, 'qsdqsdqs', 'v1.0', 'Calculate revenue of coins automatically !', 'adlinker@moakt.ws', '2018-11-19 20:50:11'),
(41, 1, 'nabil ramadan', 'v1.0', 'Calculate revenue of coins automatically !', 'adlinker@moakt.ws', '2018-11-20 16:44:11'),
(42, 1, 'nabil ramadan', 'v1.0', 'Calculate revenue of coins automatically !', 'adlinker@moakt.ws', '2018-11-20 16:44:42'),
(43, 1, 'nabil ramadan', 'v1.0', 'Calculate revenue of coins automatically !', 'adlinker@moakt.ws', '2018-11-20 16:45:32'),
(44, 1, 'nabil ramadan', 'v1.0', 'Calculate revenue of coins automatically !', 'adlinker@moakt.ws', '2018-11-20 16:46:00'),
(45, 1, 'nabil ramadan', 'v1.0', 'Calculate revenue of coins automatically !', 'adlinker@moakt.ws', '2018-11-20 16:48:39'),
(46, 1, 'nabil ramadan', 'v1.0', 'Calculate revenue of coins automatically !', 'adlinker@moakt.ws', '2018-11-20 16:57:55'),
(47, 1, 'nabil ramadan', 'v1.0', 'Calculate revenue of coins automatically !', 'adlinker@moakt.ws', '2018-11-20 16:57:59'),
(48, 1, 'nabil ramadan', 'v1.0', 'Calculate revenue of coins automatically !', 'adlinker@moakt.ws', '2018-11-20 17:07:29'),
(49, 1, 'nabil ramadan', 'v1.0', 'Calculate revenue of coins automatically !', 'adlinker@moakt.ws', '2018-11-20 17:09:59'),
(50, 1, 'nabil ramadan', 'v1.0', 'Calculate revenue of coins automatically !', 'adlinker@moakt.ws', '2018-11-20 17:10:17'),
(51, 1, 'nabil ramadan', 'v1.0', 'Calculate revenue of coins automatically !', 'adlinker@moakt.ws', '2018-11-20 17:10:38'),
(52, 1, 'nabil ramadan', 'v1.0', 'Calculate revenue of coins automatically !', 'adlinker@moakt.ws', '2018-11-20 17:11:49'),
(53, 1, 'nabil ramadan', 'v1.0', 'Calculate revenue of coins automatically !', 'adlinker@moakt.ws', '2018-11-20 17:33:11'),
(54, 1, 'ggggg', 'v1.0', 'Calculate revenue of coins automatically !', 'coinlator@moakt.ws', '2018-11-20 18:41:29'),
(55, 1, 'nabil ramadan', 'v1.0', 'qsdqsdqsdqsd', 'coinlator@moakt.ws', '2018-11-20 20:15:18'),
(56, 1, 'Calculate ', 'v1.0', 'Calculate revenue of coins automatically !', 'coinlator@moakt.ws', '2018-11-20 20:16:41'),
(57, 1, 'Tddd', '2.24', 'sdslksdfg5fgm', 'coinlator@moakt.ws', '2018-11-21 13:47:19'),
(58, 1, 'test2', '3.2', 'description license test', 'coinlator@moakt.ws', '2018-11-21 15:59:03'),
(59, 1, 'test2', '3.5', 'description license test', 'coinlator@moakt.ws', '2018-11-21 16:12:39'),
(60, 1, 'test3', '2.2', 'Calculate revenue of coins automatically !', 'coinlator@moakt.ws', '2018-11-21 16:15:44'),
(63, 1, 'test5', '5.1.3', 'ffffffssddddd', 'coinlator@moakt.ws', '2018-11-22 15:54:58');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(45) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'root'),
(2, 'administrator');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `name` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `autoload` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `value`, `autoload`) VALUES
(1, 'site_name', 'MR4Web Checkout', 1),
(2, 'site_desc', NULL, 1),
(3, 'email_support', 'support@test.ws', 1),
(4, 'email_sales_support', 'sales@test.ws', 0),
(5, 'paypal_secret_key', 'AcgsfK2G5cFknbH4KUsFjf36OR_TKlZpOKDzk41-GehHNfyVhkRHADzd5UbNo09noCDByXRo1d8Omuj5', 0),
(6, 'paypal_public_key', 'EP6fGV_QT4l8ZhHpEO2RmUb6SQOHH37OQkXoM9oGJoW31oJqyiOJDvwNs-pGDAz6nYmACAOPRNWkjrsW', 0),
(7, 'email_method', 'smtp', 0),
(8, 'SMTP_Host', 'vps574737.ovh.net', 0),
(9, 'SMTP_Port', '465', 0),
(10, 'SMTP_User', 'contact@mr4web.com', 0),
(11, 'SMTP_Pass', 'medramouchy', 0),
(12, 'mail_encription', 'ssl', 0),
(13, 'allow_SSL_Insecure_mode', '1', 0),
(14, 'email_from', 'contact@mr4web.com', 0),
(15, 'plan_files_allowed_type', 'rar,zip', 0),
(16, 'plan_files_max_size', '204800', 0);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `PM_id` int(11) NOT NULL COMMENT 'Payment Method id',
  `customers_id` int(11) NOT NULL,
  `payers_id` int(11) NOT NULL,
  `Tr_ID` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Transaction ID',
  `Tr_fee` float DEFAULT '0' COMMENT 'Transaction Fee',
  `amount` float NOT NULL,
  `quantity` int(2) DEFAULT NULL,
  `currency` varchar(4) COLLATE utf8_unicode_ci DEFAULT NULL,
  `state` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `PM_id`, `customers_id`, `payers_id`, `Tr_ID`, `Tr_fee`, `amount`, `quantity`, `currency`, `state`, `created`) VALUES
(17, 1, 10, 6, 'PAY-2KX6303920481142ALPKIZNY', 3.58, 67, 1, 'USD', 'completed', '2018-10-27 17:05:35'),
(18, 1, 6, 6, 'PAY-1N48053266968851ULPKJB3Q', 3.58, 67, 1, 'USD', 'completed', '2018-10-27 17:23:32'),
(19, 1, 6, 6, 'PAY-34502396RA4233920LPLTCLQ', 7.19, 140.7, 1, 'USD', 'completed', '2018-10-29 16:12:44'),
(20, 1, 6, 6, 'PAY-0PG76517PS9962924LPLTFDA', 7.19, 140.7, 1, 'USD', 'completed', '2018-10-29 16:18:13'),
(21, 1, 6, 6, 'PAY-50253282E9304032RLPLVAFI', 5.22, 100.5, 1, 'USD', 'completed', '2018-10-29 18:25:00'),
(22, 1, 6, 6, 'PAY-55T041878J872845HLPLVK2I', 2.6, 46.9, 1, 'USD', 'completed', '2018-10-29 18:47:19'),
(23, 1, 6, 6, 'PAY-0E308442DX913610FLPLVMDQ', 2.6, 46.9, 1, 'USD', 'completed', '2018-10-29 18:49:21'),
(24, 1, 6, 6, 'PAY-7MG80400P8432531KLPLVPDY', 2.6, 46.9, 1, 'USD', 'completed', '2018-10-29 18:55:46'),
(25, 1, 6, 6, 'PAY-64S08422SX4627638LPLVROY', 2.6, 46.9, 1, 'USD', 'completed', '2018-10-29 19:00:49'),
(26, 1, 6, 6, 'PAY-88904969DG632992SLPLVXEY', 2.6, 46.9, 1, 'USD', 'completed', '2018-10-29 19:13:21'),
(27, 1, 6, 6, 'PAY-6AF65030GU153244PLPLV22Y', 2.6, 46.9, 1, 'USD', 'completed', '2018-10-29 19:20:43'),
(28, 1, 6, 6, 'PAY-8BP78753NK9232513LPLV3QA', 2.6, 46.9, 1, 'USD', 'completed', '2018-10-29 19:22:08'),
(29, 1, 6, 6, 'PAY-0RF86772B7825161YLPLV7EQ', 2.6, 46.9, 1, 'USD', 'completed', '2018-10-29 19:30:07'),
(30, 1, 6, 6, 'PAY-0UE137187K0069145LPLWAAQ', 2.6, 46.9, 1, 'USD', 'completed', '2018-10-29 19:32:09'),
(31, 1, 6, 6, 'PAY-7707336960009083ULPLWGCA', 2.6, 46.9, 1, 'USD', 'completed', '2018-10-29 19:44:38'),
(32, 1, 6, 6, 'PAY-7VJ599302F357371JLPLWGQQ', 2.6, 46.9, 1, 'USD', 'completed', '2018-10-29 19:46:11'),
(33, 1, 6, 6, 'PAY-2WJ60265AY644721SLPLWNXQ', 3.58, 67, 1, 'USD', 'completed', '2018-10-29 20:01:54'),
(35, 1, 11, 6, 'PAY-3CU47143CH3629635LPWFQCQ', 3.58, 67, 1, 'USD', 'completed', '2018-11-14 17:16:40'),
(36, 1, 11, 6, 'PAY-61D98791E0411242PLPWFRXA', 3.58, 67, 1, 'USD', 'completed', '2018-11-14 17:18:49'),
(37, 1, 11, 6, 'PAY-6CM88753EF0937210LPWFT4A', 3.58, 67, 1, 'USD', 'completed', '2018-11-14 17:23:24'),
(38, 1, 11, 6, 'PAY-22V78851N9917105ULPWFU2I', 3.58, 67, 1, 'USD', 'completed', '2018-11-14 17:25:25'),
(39, 1, 11, 6, 'PAY-2M553094PG062811JLPWFVPQ', 3.58, 67, 1, 'USD', 'completed', '2018-11-14 17:27:29'),
(40, 1, 11, 6, 'PAY-7X993634P7303881KLPWFWQA', 3.58, 67, 1, 'USD', 'completed', '2018-11-14 17:29:03'),
(41, 1, 11, 6, 'PAY-5PL662015R024412ELPWFZNI', 3.58, 67, 1, 'USD', 'completed', '2018-11-14 17:36:08'),
(42, 1, 11, 6, 'PAY-13N00833GB7786030LPWF25Y', 3.58, 67, 1, 'USD', 'completed', '2018-11-14 17:38:32'),
(43, 1, 11, 6, 'PAY-5C310898LM0740647LPWF3UY', 3.58, 67, 1, 'USD', 'completed', '2018-11-14 17:40:01'),
(44, 1, 11, 6, 'PAY-4PT61796NS771000RLPWHKPY', 3.58, 67, 1, 'USD', 'completed', '2018-11-14 19:20:17'),
(45, 1, 11, 6, 'PAY-6CA740262V3614022LPWHLJA', 3.58, 67, 1, 'USD', 'completed', '2018-11-14 19:21:54'),
(46, 1, 11, 6, 'PAY-30L74959NR181413NLPWHQTY', 3.58, 67, 1, 'USD', 'completed', '2018-11-14 19:33:04'),
(47, 1, 11, 6, 'PAY-57U56996H69245918LPWHUXA', 3.58, 67, 1, 'USD', 'completed', '2018-11-14 19:42:04'),
(48, 1, 11, 6, 'PAY-3T0220344B134061VLPWHYWI', 3.58, 67, 1, 'USD', 'completed', '2018-11-14 19:50:22'),
(49, 1, 11, 6, 'PAY-5GY47561WS998563VLPWIBNQ', 3.58, 67, 1, 'USD', 'completed', '2018-11-14 20:09:10'),
(50, 1, 11, 6, 'PAY-68E83163W11654450LPWIQEA', 2.27, 40.2, 1, 'USD', 'completed', '2018-11-14 20:40:18'),
(51, 1, 11, 6, 'PAY-9MH71237SA6691444LPWIRHY', 2.27, 40.2, 1, 'USD', 'completed', '2018-11-14 20:42:35'),
(52, 1, 11, 6, 'PAY-7DU447609M599801XLPWIT3Y', 3.58, 67, 1, 'USD', 'completed', '2018-11-14 20:48:12'),
(53, 1, 12, 6, 'PAY-72P72528EN0920337LPYED3A', 2.27, 40.2, 1, 'USD', 'completed', '2018-11-17 16:30:54'),
(54, 1, 12, 6, 'PAY-5FE737511L6781309LPYEF6I', 2.27, 40.2, 1, 'USD', 'completed', '2018-11-17 16:34:31'),
(55, 1, 11, 6, 'PAY-00L39853GP1080422LP4AP6A', 9.86, 195, 1, 'USD', 'completed', '2018-11-23 14:01:41'),
(56, 1, 11, 6, 'PAY-0TF81326S1825500ELP4A43A', 9.86, 195, 1, 'USD', 'completed', '2018-11-23 14:28:40'),
(57, 1, 11, 6, 'PAY-40K5559820082722XLP4BAMA', 9.86, 195, 1, 'USD', 'completed', '2018-11-23 14:35:59'),
(58, 1, 11, 6, 'PAY-2PJ340098D726090MLP4BCII', 9.86, 195, 1, 'USD', 'completed', '2018-11-23 14:39:58'),
(59, 1, 11, 6, 'PAY-7FM59446W7338071DLP4ENJQ', 9.86, 195, 1, 'USD', 'completed', '2018-11-23 18:29:04'),
(60, 1, 11, 6, 'PAY-4M283963DM904144CLP4ESFY', 7.19, 140.7, 1, 'USD', 'completed', '2018-11-23 18:39:12');

-- --------------------------------------------------------

--
-- Table structure for table `updates`
--

CREATE TABLE `updates` (
  `update_ID` int(11) NOT NULL,
  `product_ID` int(11) NOT NULL,
  `paid` int(1) NOT NULL,
  `download_url` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `updates`
--

INSERT INTO `updates` (`update_ID`, `product_ID`, `paid`, `download_url`, `created`) VALUES
(1, 1, 0, 'http://updates.mr4web.com/test3.zip', 1536235464);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `roles_id` int(11) NOT NULL,
  `username` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `roles_id`, `username`, `email`, `password`, `token`, `created`) VALUES
(1, 2, 'admin', 'admin@moakt.ws', 'a4a089b5fcb39f80e09732cad6ef38df0f904d1e791aad1805de2395b49a0ff5', 'f0db93efa264a687b221f6133c14285d7e531912e7b9f083bd6cf93b1a4fbf1c', '2018-11-02 14:38:27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code_UNIQUE` (`code`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_ID`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token_UNIQUE` (`token`);

--
-- Indexes for table `domains`
--
ALTER TABLE `domains`
  ADD PRIMARY KEY (`domain_ID`),
  ADD KEY `license_ID` (`license_ID`);

--
-- Indexes for table `emails`
--
ALTER TABLE `emails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `features`
--
ALTER TABLE `features`
  ADD PRIMARY KEY (`feature_ID`),
  ADD KEY `update_ID` (`update_ID`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_files_products1_idx` (`products_id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_invoices_transactions1_idx` (`transactions_id`),
  ADD KEY `fk_invoices_customers1_idx` (`customers_id`),
  ADD KEY `fk_invoices_plans1_idx` (`plans_id`),
  ADD KEY `fk_invoices_coupons1_idx` (`coupons_id`);

--
-- Indexes for table `license`
--
ALTER TABLE `license`
  ADD PRIMARY KEY (`license_ID`),
  ADD KEY `customer_ID` (`customer_ID`),
  ADD KEY `product_ID` (`product_ID`);

--
-- Indexes for table `licenses`
--
ALTER TABLE `licenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_licenses_products1_idx` (`products_id`),
  ADD KEY `fk_licenses_customers1_idx` (`customers_id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`news_ID`),
  ADD KEY `product_ID` (`product_ID`);

--
-- Indexes for table `payers`
--
ALTER TABLE `payers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Plans_Products1_idx` (`products_id`);

--
-- Indexes for table `plans_coupons`
--
ALTER TABLE `plans_coupons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_plans_coupons_plans1_idx` (`plans_id`),
  ADD KEY `fk_plans_coupons_coupons1_idx` (`coupons_id`);

--
-- Indexes for table `plans_features`
--
ALTER TABLE `plans_features`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_features_Plans1_idx` (`Plans_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_ID`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_products_users1_idx` (`users_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Tr_ID` (`Tr_ID`),
  ADD KEY `customers_id` (`customers_id`),
  ADD KEY `PM_ID` (`PM_id`),
  ADD KEY `fk_transactions_payers1_idx` (`payers_id`);

--
-- Indexes for table `updates`
--
ALTER TABLE `updates`
  ADD PRIMARY KEY (`update_ID`),
  ADD KEY `product_ID` (`product_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_users_roles1_idx` (`roles_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `domains`
--
ALTER TABLE `domains`
  MODIFY `domain_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `emails`
--
ALTER TABLE `emails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `features`
--
ALTER TABLE `features`
  MODIFY `feature_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;
--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
--
-- AUTO_INCREMENT for table `license`
--
ALTER TABLE `license`
  MODIFY `license_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `licenses`
--
ALTER TABLE `licenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `news_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `payers`
--
ALTER TABLE `payers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `plans_coupons`
--
ALTER TABLE `plans_coupons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
--
-- AUTO_INCREMENT for table `plans_features`
--
ALTER TABLE `plans_features`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;
--
-- AUTO_INCREMENT for table `updates`
--
ALTER TABLE `updates`
  MODIFY `update_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `domains`
--
ALTER TABLE `domains`
  ADD CONSTRAINT `domains_ibfk_2` FOREIGN KEY (`license_ID`) REFERENCES `license` (`license_ID`);

--
-- Constraints for table `features`
--
ALTER TABLE `features`
  ADD CONSTRAINT `features_ibfk_1` FOREIGN KEY (`update_ID`) REFERENCES `updates` (`update_ID`);

--
-- Constraints for table `files`
--
ALTER TABLE `files`
  ADD CONSTRAINT `fk_files_products1` FOREIGN KEY (`products_id`) REFERENCES `products` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `fk_invoices_coupons1` FOREIGN KEY (`coupons_id`) REFERENCES `coupons` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_invoices_customers1` FOREIGN KEY (`customers_id`) REFERENCES `customers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_invoices_plans1` FOREIGN KEY (`plans_id`) REFERENCES `plans` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_invoices_transactions1` FOREIGN KEY (`transactions_id`) REFERENCES `transactions` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `license`
--
ALTER TABLE `license`
  ADD CONSTRAINT `license_ibfk_1` FOREIGN KEY (`customer_ID`) REFERENCES `customer` (`customer_ID`),
  ADD CONSTRAINT `license_ibfk_2` FOREIGN KEY (`product_ID`) REFERENCES `product` (`product_ID`);

--
-- Constraints for table `licenses`
--
ALTER TABLE `licenses`
  ADD CONSTRAINT `fk_licenses_customers1` FOREIGN KEY (`customers_id`) REFERENCES `customers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_licenses_products1` FOREIGN KEY (`products_id`) REFERENCES `products` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_ibfk_1` FOREIGN KEY (`product_ID`) REFERENCES `product` (`product_ID`);

--
-- Constraints for table `plans`
--
ALTER TABLE `plans`
  ADD CONSTRAINT `fk_Plans_Products1` FOREIGN KEY (`products_id`) REFERENCES `products` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `plans_coupons`
--
ALTER TABLE `plans_coupons`
  ADD CONSTRAINT `fk_plans_coupons_coupons1` FOREIGN KEY (`coupons_id`) REFERENCES `coupons` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_plans_coupons_plans1` FOREIGN KEY (`plans_id`) REFERENCES `plans` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `plans_features`
--
ALTER TABLE `plans_features`
  ADD CONSTRAINT `fk_features_Plans1` FOREIGN KEY (`Plans_id`) REFERENCES `plans` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_products_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `fk_transactions_customers1` FOREIGN KEY (`customers_id`) REFERENCES `customers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_transactions_payers1` FOREIGN KEY (`payers_id`) REFERENCES `payers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`PM_id`) REFERENCES `payment_methods` (`id`);

--
-- Constraints for table `updates`
--
ALTER TABLE `updates`
  ADD CONSTRAINT `updates_ibfk_1` FOREIGN KEY (`product_ID`) REFERENCES `product` (`product_ID`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_roles1` FOREIGN KEY (`roles_id`) REFERENCES `roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
