-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 21, 2025 at 03:53 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fabellacares`
--

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `short_name` varchar(100) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `short_name`, `name`, `created_at`, `updated_at`) VALUES
(1, 'OB', 'Obstetrics', NULL, NULL),
(2, 'Gyne', 'Gynecology', NULL, NULL),
(3, 'IM', 'Internal Medicine', NULL, NULL),
(4, 'Pedia', 'Pediatrics', NULL, NULL),
(5, '', 'dasd', '2025-05-16 03:04:40', '2025-05-16 03:04:40'),
(6, '', 'asd', '2025-05-16 03:13:46', '2025-05-16 03:13:46');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `opd_forms`
--

CREATE TABLE `opd_forms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `form_no` varchar(100) NOT NULL,
  `department` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `opd_forms`
--

INSERT INTO `opd_forms` (`id`, `name`, `form_no`, `department`, `created_at`, `updated_at`) VALUES
(1, 'qwewe', '12312', 'dasd', '2025-05-18 22:55:33', '2025-05-18 22:55:33');

-- --------------------------------------------------------

--
-- Table structure for table `opd_submissions`
--

CREATE TABLE `opd_submissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `form_id` bigint(20) UNSIGNED NOT NULL,
  `answers` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`answers`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `birth_date` date DEFAULT NULL,
  `contact_no` varchar(50) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `user_id`, `name`, `birth_date`, `contact_no`, `address`, `created_at`, `updated_at`) VALUES
(1, NULL, 'dasd', '2025-05-12', '23', 'qweqwe', '2025-05-16 21:52:47', '2025-05-16 21:52:47');

-- --------------------------------------------------------

--
-- Table structure for table `patient_visits`
--

CREATE TABLE `patient_visits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `visited_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `staff_name` varchar(255) NOT NULL,
  `role` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `shift_start` time NOT NULL,
  `shift_end` time NOT NULL,
  `department` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tokens`
--

CREATE TABLE `tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `served_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tokens`
--

INSERT INTO `tokens` (`id`, `department_id`, `code`, `served_at`, `created_at`, `updated_at`) VALUES
(1, 6, '001', NULL, '2025-05-16 03:33:51', '2025-05-16 03:33:51'),
(2, 6, '002', NULL, '2025-05-16 03:33:53', '2025-05-16 03:33:53'),
(3, 6, '003', NULL, '2025-05-16 03:41:28', '2025-05-16 03:41:28'),
(4, 5, '001', NULL, '2025-05-16 03:51:14', '2025-05-16 03:51:14'),
(5, 6, '004', NULL, '2025-05-16 17:10:34', '2025-05-16 17:10:34'),
(6, 6, '005', NULL, '2025-05-16 23:01:36', '2025-05-16 23:01:36'),
(7, 5, '002', NULL, '2025-05-16 23:01:42', '2025-05-16 23:01:42'),
(8, 5, 'D003', NULL, '2025-05-16 23:07:39', '2025-05-16 23:07:39'),
(9, 1, 'O001', NULL, '2025-05-16 23:14:42', '2025-05-16 23:14:42'),
(10, 2, 'G001', '2025-05-17 12:49:52', '2025-05-16 23:37:46', '2025-05-17 12:49:52'),
(11, 3, 'I001', NULL, '2025-05-16 23:37:49', '2025-05-16 23:37:49'),
(12, 6, '006', NULL, '2025-05-17 12:31:28', '2025-05-17 12:31:28'),
(13, 2, 'G002', '2025-05-20 17:03:07', '2025-05-17 12:31:32', '2025-05-20 17:03:07'),
(14, 3, 'I002', NULL, '2025-05-17 12:31:34', '2025-05-17 12:31:34'),
(15, 3, 'I003', NULL, '2025-05-17 12:35:48', '2025-05-17 12:35:48'),
(16, 6, '007', NULL, '2025-05-17 12:40:14', '2025-05-17 12:40:14'),
(17, 6, '008', NULL, '2025-05-20 01:15:03', '2025-05-20 01:15:03'),
(18, 5, 'D004', NULL, '2025-05-20 02:13:32', '2025-05-20 02:13:32'),
(19, 5, 'D005', NULL, '2025-05-20 02:15:02', '2025-05-20 02:15:02'),
(20, 6, 'A009', NULL, '2025-05-20 02:46:32', '2025-05-20 02:46:32'),
(21, 4, 'P001', NULL, '2025-05-20 12:38:27', '2025-05-20 12:38:27'),
(22, 4, 'P002', NULL, '2025-05-20 12:40:10', '2025-05-20 12:40:10'),
(23, 5, 'D006', NULL, '2025-05-20 12:45:15', '2025-05-20 12:45:15'),
(24, 5, 'D007', NULL, '2025-05-20 12:47:40', '2025-05-20 12:47:40'),
(25, 6, 'A010', NULL, '2025-05-20 12:49:45', '2025-05-20 12:49:45'),
(26, 6, '011', NULL, '2025-05-20 16:45:37', '2025-05-20 16:45:37'),
(27, 2, 'G003', '2025-05-20 17:04:08', '2025-05-20 16:45:46', '2025-05-20 17:04:08'),
(28, 2, 'G004', '2025-05-20 17:04:32', '2025-05-20 17:03:39', '2025-05-20 17:04:32'),
(29, 2, 'G005', '2025-05-20 17:09:45', '2025-05-20 17:03:46', '2025-05-20 17:09:45');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','encoder','patient') NOT NULL DEFAULT 'patient',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin User', 'admin@fabellacares.com', NULL, '$2y$10$MWXyVr5pR9tWTA1Vvo9d7ewzSIyQaDU6s72NJcqenDOHRTNT7mHum', 'admin', NULL, '2025-05-12 06:54:47', '2025-05-15 23:39:40'),
(2, 'En333', 'encoder@fabellacares.com', NULL, '$2y$10$wH8nKMx4ldH0h0VlmX0wzeuZKOpOj8pJmUV6GFMdRrQ6xNgyjV7ZC', 'admin', NULL, '2025-05-12 06:54:47', '2025-05-16 00:36:06'),
(3, 'Patient User', 'patient@fabellacares.com', NULL, '$2y$10$wH8nKMx4ldH0h0VlmX0wzeuZKOpOj8pJmUV6GFMdRrQ6xNgyjV7ZC', 'patient', NULL, '2025-05-12 06:54:48', '2025-05-12 06:54:48'),
(4, 'jdasd', 'ewqe@gmail.com', NULL, '$2y$10$6BbhHLErstNJ4OYgYBsZ7.nkX.Zx1GM2trv8pEsqva2zdL53l09Dm', 'admin', NULL, '2025-05-16 00:12:41', '2025-05-16 00:12:41'),
(6, 'norence pogi', 'pogi@gmail.com', NULL, '$2y$10$zr/1lZGaZ.d2NDJBJtapfuGGJb7rrGY0b/6NXmDcyEJXmkQYEdOJS', 'encoder', NULL, '2025-05-16 22:37:25', '2025-05-16 22:37:25'),
(7, 'gian', 'gian@gmail.com', NULL, '$2y$10$a1du25lGaTX6m31/msvE/.FfhRV5wXj/R1lW4cfug26LZ0zLvYHbu', 'patient', NULL, '2025-05-16 22:37:57', '2025-05-16 22:37:57'),
(8, 'Norence Gwapo', 'nor@gmail.com', NULL, '$2y$10$MWXyVr5pR9tWTA1Vvo9d7ewzSIyQaDU6s72NJcqenDOHRTNT7mHum', 'patient', NULL, '2025-05-19 12:18:22', '2025-05-19 12:18:22'),
(9, 'van', 'van@gmail.com', NULL, '$2y$10$A.0ji9glVJYqeVrwOdtC3.kjwBA.rVUpygr1I.Jf0GGT9K4pmFyMu', 'patient', NULL, '2025-05-20 01:29:10', '2025-05-20 01:29:10'),
(10, 'enn', 'encode@gmail.com', NULL, '$2y$10$uLLTe/LAAh6eOASpgY3SYOQDeW1RDWndHrqX5A1k2i0jI34szlT/O', 'encoder', NULL, '2025-05-20 01:31:17', '2025-05-20 01:31:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `opd_forms`
--
ALTER TABLE `opd_forms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `opd_submissions`
--
ALTER TABLE `opd_submissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `opd_submissions_user_id_foreign` (`user_id`),
  ADD KEY `opd_submissions_patient_id_foreign` (`patient_id`),
  ADD KEY `opd_submissions_form_id_foreign` (`form_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `email` (`email`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patients_user_id_index` (`user_id`);

--
-- Indexes for table `patient_visits`
--
ALTER TABLE `patient_visits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_patient_visits_patient_id` (`patient_id`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tokens_department_id_foreign` (`department_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `opd_forms`
--
ALTER TABLE `opd_forms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `opd_submissions`
--
ALTER TABLE `opd_submissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `patient_visits`
--
ALTER TABLE `patient_visits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tokens`
--
ALTER TABLE `tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `opd_submissions`
--
ALTER TABLE `opd_submissions`
  ADD CONSTRAINT `opd_submissions_form_id_foreign` FOREIGN KEY (`form_id`) REFERENCES `opd_forms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `opd_submissions_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `opd_submissions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `patients`
--
ALTER TABLE `patients`
  ADD CONSTRAINT `patients_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `patient_visits`
--
ALTER TABLE `patient_visits`
  ADD CONSTRAINT `fk_patient_visits_patient_id` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tokens`
--
ALTER TABLE `tokens`
  ADD CONSTRAINT `tokens_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
