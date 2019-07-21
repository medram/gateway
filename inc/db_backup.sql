-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 21, 2019 at 07:17 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
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
-- Table structure for table `features`
--

CREATE TABLE `features` (
  `id` int(11) NOT NULL,
  `updates_id` int(11) NOT NULL,
  `desc` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `invoice_id` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `transactions_id` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `customers_id` int(11) NOT NULL,
  `plans_id` int(11) NOT NULL,
  `coupons_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



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
  `plans_id` int(11) NOT NULL,
  `invoices_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `plans_coupons`
--

CREATE TABLE `plans_coupons` (
  `id` int(11) NOT NULL,
  `plans_id` int(11) NOT NULL,
  `coupons_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
(3, 'email_support', '', 1),
(4, 'email_sales_support', '', 0),
(5, 'paypal_public_key', '', 0),
(6, 'paypal_secret_key', '', 0),
(7, 'email_method', 'smtp', 0),
(8, 'SMTP_Host', '', 0),
(9, 'SMTP_Port', '465', 0),
(10, 'SMTP_User', '', 0),
(11, 'SMTP_Pass', '', 0),
(12, 'mail_encription', 'ssl', 0),
(13, 'allow_SSL_Insecure_mode', '1', 0),
(14, 'email_from', '', 0),
(15, 'plan_files_allowed_type', 'rar,zip', 0),
(16, 'plan_files_max_size', '204800', 0),
(17, 'site_version', '0.7.1 alfa', 1),
(18, 'thanks_page_analytics_code', '', 0),
(19, 'sandbox', '1', 0),
(20, 'paypal_sandbox_public_key', '', 0),
(21, 'paypal_sandbox_secret_key', '', 0),
(22, 'JVZoo_IPN_KEY', '', 0);

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
(1, 2, 'admin', 'admin@test.com', 'a4a089b5fcb39f80e09732cad6ef38df0f904d1e791aad1805de2395b49a0ff5', 'f0db93efa264a687b221f6133c14285d7e531912e7b9f083bd6cf93b1a4fbf1c', '2018-11-02 14:38:27');


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
  ADD PRIMARY KEY (`id`,`customers_id`,`plans_id`),
  ADD KEY `fk_invoices_customers1_idx` (`customers_id`),
  ADD KEY `fk_invoices_plans1_idx` (`plans_id`),
  ADD KEY `fk_invoices_coupons1_idx` (`coupons_id`);

--
-- Indexes for table `licenses`
--
ALTER TABLE `licenses`
  ADD PRIMARY KEY (`id`,`customers_id`,`products_id`),
  ADD KEY `fk_licenses_products1_idx` (`products_id`),
  ADD KEY `fk_licenses_customers1_idx` (`customers_id`),
  ADD KEY `fk_licenses_plans1_idx` (`plans_id`),
  ADD KEY `fk_licenses_invoices1_idx` (`invoices_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `domains`
--
ALTER TABLE `domains`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;


--
-- AUTO_INCREMENT for table `features`
--
ALTER TABLE `features`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `licenses`
--
ALTER TABLE `licenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `newss`
--
ALTER TABLE `newss`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `payers`
--
ALTER TABLE `payers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `plans_coupons`
--
ALTER TABLE `plans_coupons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `plans_features`
--
ALTER TABLE `plans_features`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `updates`
--
ALTER TABLE `updates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

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
  ADD CONSTRAINT `fk_invoices_plans1` FOREIGN KEY (`plans_id`) REFERENCES `plans` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `licenses`
--
ALTER TABLE `licenses`
  ADD CONSTRAINT `fk_licenses_customers1` FOREIGN KEY (`customers_id`) REFERENCES `customers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_licenses_invoices1` FOREIGN KEY (`invoices_id`) REFERENCES `invoices` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
