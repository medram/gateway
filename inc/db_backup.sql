-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 08, 2019 at 10:42 PM
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
(10, 'Mona', 'ramadan', 'F', 'mona@moakt.ws', '', '01389910df0a19b4dca7afd224e969ab52442e20685b47edbed43abb3425d10d', '2018-11-25 17:05:01'),
(11, 'nabil', 'ramadan', 'M', 'mramouchy@gmail.com', '', '0ae40bef583343ea46540b5650bf694bcb4911e100f4e241583bb6672d67fc17', '2018-11-27 16:31:26'),
(12, 'Mr', 'Med', 'M', 'mramouchy@gmail.com', '', '1ebbb2c5d7ad0aa910d58bb4267e2dac6017ad134538ece173dd55d8f2365cc0', '2018-12-05 16:29:17'),
(13, 'nabil', 'ramadan', 'M', 'nabil@moakt.ws', '', 'd73b12ab91161fde4d5329ba76f9ee93709339f945733efededbdf132fcdb964', '2018-12-05 18:27:24'),
(14, 'nabil', 'ramadan', 'M', 'med@moakt.ws', '', '6130e5bb491e64584d7c7846358827944e5883646aa9e1e9304d2014910fb02b', '2018-12-09 20:21:06'),
(15, 'nabil', 'ramadan', 'M', 'adddddmin@moakt.ws', '', 'bb1d201a8832e3327cb26ada8e9403f3f6b58cfc6890ffa0fd65bef84d7305df', '2019-02-08 16:27:08');

-- --------------------------------------------------------

--
-- Table structure for table `domains`
--

CREATE TABLE `domains` (
  `id` int(11) NOT NULL,
  `licenses_id` int(11) NOT NULL,
  `IP` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `domain_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `product_version` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `active` int(1) NOT NULL,
  `total_checks` int(15) NOT NULL,
  `modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci;

--
-- Dumping data for table `domains`
--

INSERT INTO `domains` (`id`, `licenses_id`, `IP`, `domain_name`, `product_version`, `active`, `total_checks`, `modified`, `created`) VALUES
(12, 1, '192.168.53.1', 'bing.com', '1.3', 1, 1, '2018-12-05 13:34:32', '2018-12-05 13:34:32'),
(13, 1, '192.168.53.12', 'google.com', '1.3', 1, 1, '2018-12-05 13:35:15', '2018-12-05 13:35:15'),
(14, 2, '192.168.53.13', 'test.com', '1.3', 1, 3, '2018-12-05 13:37:02', '2018-12-05 13:36:59');

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
  `id` int(11) NOT NULL,
  `updates_id` int(11) NOT NULL,
  `desc` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `features`
--

INSERT INTO `features` (`id`, `updates_id`, `desc`) VALUES
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
(1, 2, 'Coins_Accelerator_v3.2.4(beta).rar', 'C:/xampp/htdocs/test/gateway/inc/uploads/users/ID_1/products/Coins_Accelerator_v3.2.4(beta).rar', 2900180, '2018-11-25 20:25:17'),
(2, 1, 'AdLinker_8.0_alfa.rar', 'C:/xampp/htdocs/test/gateway/inc/uploads/users/ID_1/products/AdLinker_8.0_alfa.rar', 2900180, '2018-11-25 20:25:24'),
(3, 64, 'AdLinker_8.0_alfa_1543179168.rar', 'C:/xampp/htdocs/test/gateway/inc/uploads/users/ID_1/products/AdLinker_8.0_alfa_1543179168.rar', 2900180, '2018-11-25 20:52:48');

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
(1, '#1543177266', 61, 14, 1, NULL, '2018-11-25 20:22:22'),
(2, '#1543177573', 62, 14, 1, NULL, '2018-11-25 20:26:57'),
(3, '#1543177659', 63, 14, 2, NULL, '2018-11-25 20:28:32'),
(4, '#1543177775', 64, 14, 4, NULL, '2018-11-25 20:30:12'),
(5, '#1543179624', 65, 14, 7, NULL, '2018-11-25 21:04:31'),
(6, '#1549639067', 66, 6, 14, NULL, '2019-02-08 16:19:57'),
(7, '#1549639628', 67, 15, 14, NULL, '2019-02-08 16:27:46'),
(8, '#1549658112', 68, 15, 14, NULL, '2019-02-08 21:36:45');

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
  `customers_id` int(11) NOT NULL,
  `plans_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `licenses`
--

INSERT INTO `licenses` (`id`, `license_code`, `activation_num`, `activation_max`, `banned`, `license_type`, `created`, `products_id`, `customers_id`, `plans_id`) VALUES
(1, 'd89fe57566fa4f98d952bf6e3fda3f17142ec96b', 2, 2, 0, 'L', '2018-12-09 20:22:26', 1, 14, 9),
(2, 'dc4cbeebdb7944ac95374488afa1a1238f027ffc', 1, 1, 0, 'L', '2018-12-09 20:22:27', 1, 14, 0),
(3, '2c873105e57e71e1de85fb0bab63c6bb6f517e3a', 0, 1, 0, 'Y', '2018-12-05 19:28:57', 64, 11, 7),
(4, 'b48be7286d858b694766120c2d917762e1defe6d', 0, 1, 0, 'L', '2018-12-05 20:00:54', 1, 14, 1),
(5, 'd378b65e3aeab4d4ca08c79552ce31244a653e43', 0, 1, 0, 'L', '2018-12-05 20:00:55', 1, 14, 1),
(6, '0fb21e908527dd9dbbba94d68cce22d04dc7f383', 0, 1, 0, 'Y', '2018-12-01 20:04:17', 2, 14, 4),
(7, 'e57c0847686607ab69b5f440024214f422ac23ba', 0, 1, 0, 'Y', '2018-12-01 20:04:18', 2, 14, 4),
(8, '0a1c0e6df4a920a6db8bab35ea1994467455cf7a', 0, 1, 0, 'Y', '2018-11-29 20:04:19', 2, 14, 4),
(9, '2757db60d33c52f4da21894707a65be013051007', 0, 1, 0, 'Y', '2018-11-29 20:04:20', 2, 14, 4),
(10, 'e1e976c7d4ecdaa41cd0a01fdac3c0ad0c61bfec', 0, 1, 0, 'Y', '2018-11-29 20:04:21', 2, 14, 4),
(12, '12d65686ddfdd779a76dd25d664ec90e48798798', 0, 1, 0, 'Y', '2018-10-29 20:06:27', 2, 14, 7),
(13, '42438ed42e8b978b2d066fe5cc4115dbc6235ca0', 0, 1, 0, 'Y', '2018-10-29 20:06:28', 2, 14, 7),
(14, '807c797737d6d2b89395a7a28e0a18b6066b9fe0', 0, 1, 0, 'Y', '2018-10-29 20:06:29', 2, 14, 7),
(15, '41a43d6de6bf5ea410ff5c22ae4815f71ab396d5', 0, 1, 0, 'Y', '2018-11-29 20:06:30', 2, 14, 7),
(16, '40b94c640690dbaee0445675f391b340fe92503d', 0, 1, 0, 'Y', '2018-11-29 20:06:31', 2, 14, 7),
(17, '6af3396d92f9ac1030cc1ea3d2fde890743a900d', 0, 1, 0, 'Y', '2018-11-29 20:06:32', 2, 14, 7),
(18, 'd15c2317fbbf37cf53a9b2b47d75cedd8313837c', 0, 1, 0, 'Y', '2018-11-29 20:06:33', 2, 14, 7),
(19, 'ea970b7a11afec45c0926ab77c500aaba2931aa3', 0, 1, 0, 'Y', '2018-11-29 20:06:34', 2, 14, 7),
(20, 'f4befb9681ad08aab2e580d12dbe3335f3734ccb', 0, 1, 0, 'Y', '2018-11-29 20:06:35', 2, 14, 7),
(21, '50e31ddab3dea6d84a1881d5b8c785499d6a6db0', 0, 1, 0, 'L', '2018-11-29 20:06:41', 1, 14, 2),
(23, '4144d8af30de13cda94fc673a5bbb6608edceb71', 0, 2, 0, 'L', '2018-11-29 20:40:57', 2, 11, 11),
(24, '991200e308582f7a8ae94f8cf5b1a1aa3d644aa7', 0, 1, 0, 'Y', '2019-02-08 16:20:03', 1, 6, 14),
(25, '937f561a2ebc49965a542d302d9522c809e250df', 0, 1, 0, 'Y', '2019-02-08 16:27:50', 1, 15, 14);

-- --------------------------------------------------------

--
-- Table structure for table `newss`
--

CREATE TABLE `newss` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `image_URL` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `news_URL` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `products_id` int(11) NOT NULL,
  `created` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `newss`
--

INSERT INTO `newss` (`id`, `title`, `description`, `image_URL`, `news_URL`, `products_id`, `created`) VALUES
(1, 'ADLinker v1.5 coming soon.', 'Be ready, And Make Sure That you Get your Newest Version.', 'http://localhost/ci-copy/img/pexels-1.jpg', 'http://www.mr4web.com/news/ADLinker-v1.5-coming-soon', 1, '2018-11-29 20:04:18'),
(2, 'Earn Coins Calculator - just for $15.', 'Earn Coins Calculator will helps you to save your calculation time, easy to use, fast access and more.', 'http://localhost/ci-copy/img/pexels-2.jpg', 'http://www.mr4web.com/news/Earn-Coins-Calculator-just-for-$15.', 1, '2018-11-29 20:04:18');

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
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '1 = active\n0 = inactive',
  `analytics_code` mediumtext COLLATE utf8_unicode_ci,
  `thanks_page_analytics_code` mediumtext COLLATE utf8_unicode_ci,
  `modified` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`id`, `products_id`, `name`, `desc`, `price`, `old_price`, `plan_type`, `max_licenses`, `status`, `analytics_code`, `thanks_page_analytics_code`, `modified`, `created`) VALUES
(1, 1, '1 License', 'ADLinker v1.2 - Lifetime license.', 0.99, 299.99, 'L', 5, 1, NULL, NULL, '2018-12-07 11:55:39', '2018-10-22 20:25:46'),
(2, 1, '3 License', 'ADLinker v1.2 - Lifetime license.', 140, 201, 'L', 2, 0, NULL, NULL, '2018-11-22 15:39:51', '2018-10-22 20:27:47'),
(3, 1, '10 License', 'ADLinker v1.2 - Lifetime license.', 335, 670, 'L', 2, 1, NULL, NULL, '2018-11-22 15:39:51', '2018-10-22 20:28:32'),
(4, 2, 'Gold', 'cold plan', 99, 200, 'Y', 5, 1, NULL, NULL, '2018-11-18 20:28:08', '2018-11-18 20:28:08'),
(7, 2, 'Selver', 'xflkdfg', 120, 220, 'Y', 10, 1, NULL, NULL, '2018-11-18 20:47:45', '2018-11-18 20:47:45'),
(9, 64, 'Extream', 'dsfsdfsdfgdhdfgh', 195, 299, 'L', 1, 1, NULL, NULL, '2018-11-25 20:53:27', '2018-11-25 20:53:27'),
(10, 2, 'Super', '565sdfsdfsdf', 299, 399, 'Y', 1, 0, NULL, NULL, '2018-11-25 22:20:43', '2018-11-25 22:20:43'),
(11, 2, 'Starter', '54dfgdflkdskj', 99, 199, 'L', 1, 1, NULL, NULL, '2018-11-25 22:21:16', '2018-11-25 22:21:16'),
(14, 1, 'test plan', 'this is just a test plan', 45, 455, 'Y', 1, 1, '<script>\r\nconsole.log(\\''plan Code!\\'');\r\n</script>', '<script>\r\nconsole.log(\\''thanks page plan Code!\\'');\r\n</script>', '2019-02-08 16:07:59', '2019-02-08 16:07:59');

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
(1, 1, 'ADLinker', '1.2', 'Revenue Accelerator', 'adlinker@moakt.ws', '2018-12-09 20:16:16'),
(2, 1, 'CoinLator', '1.0', 'Calculate revenue of coins automatically !', 'coinlator@moakt.ws', '2018-12-05 19:37:46'),
(64, 1, 'tester', '2.3', 'skdjhsdghsdflkj', 'adlinker@moakt.ws', '2018-11-25 20:52:48');

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
(2, 'site_desc', 'small description', 1),
(3, 'email_support', 'support@test.ws', 1),
(4, 'email_sales_support', 'sales@test.ws', 0),
(5, 'paypal_public_key', '', 0),
(6, 'paypal_secret_key', '', 0),
(7, 'email_method', 'smtp', 0),
(8, 'SMTP_Host', 'vps574737.ovh.net', 0),
(9, 'SMTP_Port', '465', 0),
(10, 'SMTP_User', 'contact@mr4web.com', 0),
(11, 'SMTP_Pass', 'medramouchy', 0),
(12, 'mail_encription', 'ssl', 0),
(13, 'allow_SSL_Insecure_mode', '1', 0),
(14, 'email_from', 'contact@mr4web.com', 0),
(15, 'plan_files_allowed_type', 'rar,zip', 0),
(16, 'plan_files_max_size', '204800', 0),
(17, 'site_version', '0.6.1 alfa', 1),
(18, 'thanks_page_analytics_code', '<!-- this is analytics cooooooooode -->\n<script>console.log(\\"general analytics code\\")</script>', 0),
(19, 'sandbox', '1', 0),
(20, 'paypal_sandbox_public_key', 'AcgsfK2G5cFknbH4KUsFjf36OR_TKlZpOKDzk41-GehHNfyVhkRHADzd5UbNo09noCDByXRo1d8Omuj5', 0),
(21, 'paypal_sandbox_secret_key', 'EP6fGV_QT4l8ZhHpEO2RmUb6SQOHH37OQkXoM9oGJoW31oJqyiOJDvwNs-pGDAz6nYmACAOPRNWkjrsW', 0);

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
(61, 1, 14, 6, 'PAY-8J797441CC703244TLP5QIOY', 3.58, 67, 1, 'USD', 'completed', '2018-09-25 20:22:22'),
(62, 1, 14, 6, 'PAY-19T83341XR519292GLP5QK3I', 3.58, 67, 1, 'USD', 'completed', '2018-10-25 20:26:57'),
(63, 1, 14, 6, 'PAY-0VY23844U7689513TLP5QLQQ', 7.19, 140.7, 1, 'USD', 'completed', '2018-11-25 20:28:32'),
(64, 1, 14, 6, 'PAY-9HH47114MY443372CLP5QMNI', 5.15, 99, 1, 'USD', 'completed', '2018-12-05 20:30:12'),
(65, 1, 14, 6, 'PAY-9B52108122722660TLP5Q24A', 6.18, 120, 1, 'USD', 'completed', '2018-12-09 21:04:31'),
(66, 1, 6, 6, 'PAYID-LROZ3JA653685896T0610228', 2.51, 45, 1, 'USD', 'completed', '2019-02-08 16:19:57'),
(67, 1, 15, 6, 'PAYID-LROZ7VA1VC20128K2907315P', 2.51, 45, 1, 'USD', 'completed', '2019-02-08 16:27:46'),
(68, 1, 15, 6, 'PAYID-LRO6QCI3N1226013C0912649', 2.51, 45, 1, 'USD', 'completed', '2019-02-08 21:36:45');

-- --------------------------------------------------------

--
-- Table structure for table `updates`
--

CREATE TABLE `updates` (
  `id` int(11) NOT NULL,
  `paid` int(1) NOT NULL,
  `download_url` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `products_id` int(11) NOT NULL,
  `plans_id` int(11) DEFAULT '0',
  `created` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `updates`
--

INSERT INTO `updates` (`id`, `paid`, `download_url`, `products_id`, `plans_id`, `created`) VALUES
(1, 0, 'http://updates.mr4web.com/test3.zip', 1, 7, '2018-11-29 20:04:18');

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
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token_UNIQUE` (`token`);

--
-- Indexes for table `domains`
--
ALTER TABLE `domains`
  ADD PRIMARY KEY (`id`,`licenses_id`),
  ADD KEY `fk_domains_licenses1_idx` (`licenses_id`);

--
-- Indexes for table `emails`
--
ALTER TABLE `emails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `features`
--
ALTER TABLE `features`
  ADD PRIMARY KEY (`id`),
  ADD KEY `update_ID` (`updates_id`);

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
  ADD PRIMARY KEY (`id`,`customers_id`,`plans_id`,`transactions_id`),
  ADD KEY `fk_invoices_transactions1_idx` (`transactions_id`),
  ADD KEY `fk_invoices_customers1_idx` (`customers_id`),
  ADD KEY `fk_invoices_plans1_idx` (`plans_id`),
  ADD KEY `fk_invoices_coupons1_idx` (`coupons_id`);

--
-- Indexes for table `licenses`
--
ALTER TABLE `licenses`
  ADD PRIMARY KEY (`id`,`plans_id`,`customers_id`,`products_id`),
  ADD KEY `fk_licenses_products1_idx` (`products_id`),
  ADD KEY `fk_licenses_customers1_idx` (`customers_id`),
  ADD KEY `fk_licenses_plans1_idx` (`plans_id`);

--
-- Indexes for table `newss`
--
ALTER TABLE `newss`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_news_products1_idx` (`products_id`);

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
  ADD PRIMARY KEY (`id`,`products_id`),
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
  ADD PRIMARY KEY (`id`,`Plans_id`),
  ADD KEY `fk_features_Plans1_idx` (`Plans_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`,`users_id`),
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
  ADD PRIMARY KEY (`id`,`customers_id`),
  ADD UNIQUE KEY `Tr_ID` (`Tr_ID`),
  ADD KEY `customers_id` (`customers_id`),
  ADD KEY `PM_ID` (`PM_id`),
  ADD KEY `fk_transactions_payers1_idx` (`payers_id`);

--
-- Indexes for table `updates`
--
ALTER TABLE `updates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_updates_products1_idx` (`products_id`),
  ADD KEY `fk_updates_plans1_idx` (`plans_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`,`roles_id`),
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
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `domains`
--
ALTER TABLE `domains`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `emails`
--
ALTER TABLE `emails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `features`
--
ALTER TABLE `features`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `licenses`
--
ALTER TABLE `licenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `newss`
--
ALTER TABLE `newss`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
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
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;
--
-- AUTO_INCREMENT for table `updates`
--
ALTER TABLE `updates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
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
  ADD CONSTRAINT `fk_domains_licenses1` FOREIGN KEY (`licenses_id`) REFERENCES `licenses` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `features`
--
ALTER TABLE `features`
  ADD CONSTRAINT `features_ibfk_1` FOREIGN KEY (`updates_id`) REFERENCES `updates` (`id`);

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
-- Constraints for table `licenses`
--
ALTER TABLE `licenses`
  ADD CONSTRAINT `fk_licenses_customers1` FOREIGN KEY (`customers_id`) REFERENCES `customers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_licenses_plans1` FOREIGN KEY (`plans_id`) REFERENCES `plans` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_licenses_products1` FOREIGN KEY (`products_id`) REFERENCES `products` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `newss`
--
ALTER TABLE `newss`
  ADD CONSTRAINT `fk_news_products1` FOREIGN KEY (`products_id`) REFERENCES `products` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

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
  ADD CONSTRAINT `fk_updates_plans1` FOREIGN KEY (`plans_id`) REFERENCES `plans` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_updates_products1` FOREIGN KEY (`products_id`) REFERENCES `products` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_roles1` FOREIGN KEY (`roles_id`) REFERENCES `roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
