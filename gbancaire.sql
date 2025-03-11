-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 11, 2025 at 10:32 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gbancaire`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `account_type` enum('courant','epargne') DEFAULT NULL,
  `balance` decimal(10,0) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `acc_status` enum('active','inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `user_id`, `account_type`, `balance`, `created_at`, `updated_at`, `acc_status`) VALUES
(13, 7, 'courant', '413', '2025-01-10 22:17:24', '2025-01-20 08:16:05', 'inactive'),
(15, 7, 'epargne', '10', '2025-01-11 14:49:59', '2025-01-11 14:49:59', 'active'),
(16, 9, 'courant', '519', '2025-01-20 08:16:53', '2025-01-20 08:21:27', 'active'),
(17, 9, 'epargne', '600', '2025-01-20 08:18:36', '2025-01-20 08:21:27', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int NOT NULL,
  `admin_name` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `admin_password` varchar(255) DEFAULT NULL,
  `profile_pic` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `admin_name`, `email`, `admin_password`, `profile_pic`) VALUES
(9, 'Anas Hammaoui', 'admin@gmail.com', '$2y$10$TQ3bPO8Bkicz7TAxB2Srj.Gtrc0uz8nFEAxPyHRBt/Oc5jz6/4bRO', 'img.jpg'),
(10, 'ilyas', 'admin6@gmail.com', '$2y$10$OVQSVqfPJ9pi2WkN3VVB0uiHEiOJ3dOeaCG3zqugd77Off8WVb27q', 'be-software-developer-full-stack-web-developer-php-laravel-developer-react-js.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int NOT NULL,
  `account_id` int NOT NULL,
  `transaction_type` enum('depot','retrait','transfert') NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `beneficiary_account_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `account_id`, `transaction_type`, `amount`, `beneficiary_account_id`, `created_at`) VALUES
(1, 13, 'retrait', '10.00', NULL, '2025-01-11 14:47:14'),
(2, 13, 'depot', '300.00', NULL, '2025-01-11 14:47:48'),
(3, 13, 'transfert', '10.00', 13, '2025-01-11 14:47:59'),
(4, 17, 'retrait', '100.00', NULL, '2025-01-20 08:20:14'),
(5, 17, 'retrait', '10.00', NULL, '2025-01-20 08:20:47'),
(6, 16, 'depot', '600.00', NULL, '2025-01-20 08:21:10'),
(7, 16, 'transfert', '100.00', 17, '2025-01-20 08:21:27');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `client_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `client_password` varchar(255) DEFAULT NULL,
  `profile_pic` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `user_role` enum('admin','user') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `client_name`, `email`, `client_password`, `profile_pic`, `created_at`, `updated_at`, `user_role`) VALUES
(7, 'Anas', 'anas@gmail.com', '$2y$10$oQDse3GMfQBm6AAPu7Lh6.iQ1OnP0EVZSMC9JbhJ9793RDOE32m1W', NULL, '2025-01-10 22:17:24', '2025-01-10 22:17:24', 'user'),
(9, 'MOHA', 'moha@gm.com', '12345678', NULL, '2025-01-20 08:16:53', '2025-01-20 08:16:53', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account_id` (`account_id`),
  ADD KEY `beneficiary_account_id` (`beneficiary_account_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accounts`
--
ALTER TABLE `accounts`
  ADD CONSTRAINT `accounts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`),
  ADD CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`beneficiary_account_id`) REFERENCES `accounts` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
