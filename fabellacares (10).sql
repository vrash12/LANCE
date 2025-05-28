-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2025 at 09:01 AM
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
(6, '', 'asd', '2025-05-16 03:13:46', '2025-05-16 03:13:46'),
(7, 'Hot', 'Hotdog', '2025-05-24 01:48:27', '2025-05-24 01:48:27');

-- --------------------------------------------------------

--
-- Table structure for table `maternal_high_risk_records`
--

CREATE TABLE `maternal_high_risk_records` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `submission_id` bigint(20) UNSIGNED DEFAULT NULL,
  `health_record_no` varchar(100) DEFAULT NULL,
  `assessment_date` date DEFAULT NULL,
  `risks` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`risks`)),
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `fields` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`fields`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `opd_forms`
--

INSERT INTO `opd_forms` (`id`, `name`, `form_no`, `department`, `fields`, `created_at`, `updated_at`) VALUES
(3, 'OPD-OB FORM', 'OPD-F-07', 'OB', '{}', '2025-05-24 21:59:26', '2025-05-24 21:59:26'),
(4, 'Identification of Specific Maternal High Risk', 'OPD-F-09', 'OB', '{}', '2025-05-24 21:59:26', '2025-05-24 21:59:26'),
(5, 'Follow Up Records', 'OPD-F-08', 'OB', '{}', '2025-05-24 21:59:26', '2025-05-24 21:59:26');

-- --------------------------------------------------------

--
-- Table structure for table `opd_submissions`
--

CREATE TABLE `opd_submissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `form_id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED DEFAULT NULL,
  `answers` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`answers`)),
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `opd_submissions`
--

INSERT INTO `opd_submissions` (`id`, `user_id`, `form_id`, `patient_id`, `answers`, `created_at`, `updated_at`) VALUES
(1, 1, 3, NULL, '{\"date\":\"2025-05-06\",\"time\":\"20:09\",\"record_no\":\"qweqwe\",\"last_name\":\"qweqwe\",\"given_name\":\"q\",\"middle_name\":\"eqweqwe\",\"age\":\"23123\",\"sex\":null,\"maiden_name\":null,\"birth_date\":null,\"place_of_birth\":null,\"civil_status\":null,\"occupation\":null,\"religion\":null,\"address\":null,\"husband_name\":null,\"husband_occupation\":null,\"husband_contact\":null,\"place_of_marriage\":null,\"date_of_marriage\":null,\"present_problems_other\":null,\"danger_signs_other\":null,\"lmp\":null,\"edc\":null,\"gravida\":null,\"parity_t\":null,\"parity_p\":null,\"parity_a\":null,\"parity_l\":null,\"aog_weeks\":null,\"chief_complaint\":\"dasdasd\",\"heent\":\"ad\",\"heart_lungs\":\"asdasd\",\"diagnosis\":\"asd\",\"prepared_by\":\"sad\",\"tetanus\":[{\"date\":null,\"signature\":null},{\"date\":null,\"signature\":null},{\"date\":null,\"signature\":null},{\"date\":null,\"signature\":null},{\"date\":null,\"signature\":null}],\"ob_history\":[{\"date\":null,\"delivery_type\":null,\"outcome\":null,\"cx\":null}],\"physical_exam_log\":[{\"date\":null,\"weight\":null,\"bp\":null}]}', '2025-05-27 04:07:41', '2025-05-27 04:07:41'),
(2, 1, 3, NULL, '{\"date\":\"2025-04-30\",\"time\":\"20:30\",\"record_no\":\"12\",\"last_name\":\"johnjohn\",\"given_name\":\"johnjohn\",\"middle_name\":\"johnjohn\",\"age\":\"2\",\"sex\":\"male\",\"maiden_name\":\"johnjohn\",\"birth_date\":\"2025-05-21\",\"place_of_birth\":\"johnjohn\",\"civil_status\":\"johnjohn\",\"occupation\":\"johnjohn\",\"religion\":\"johnjohn\",\"address\":\"johnjohn\",\"husband_name\":\"johnjohn\",\"husband_occupation\":\"johnjohn\",\"husband_contact\":\"johnjohn\",\"place_of_marriage\":\"johnjohn\",\"date_of_marriage\":null,\"present_problems_other\":\"johnjohn\",\"danger_signs_other\":\"johnjohn\",\"lmp\":null,\"edc\":null,\"gravida\":null,\"parity_t\":null,\"parity_p\":null,\"parity_a\":null,\"parity_l\":null,\"aog_weeks\":null,\"chief_complaint\":null,\"heent\":\"johnjohn\",\"heart_lungs\":null,\"diagnosis\":\"johnjohn\",\"prepared_by\":\"johnjohn\",\"tetanus\":[{\"date\":null,\"signature\":null},{\"date\":null,\"signature\":null},{\"date\":null,\"signature\":null},{\"date\":null,\"signature\":null},{\"date\":null,\"signature\":null}],\"ob_history\":[{\"date\":null,\"delivery_type\":null,\"outcome\":null,\"cx\":null}],\"physical_exam_log\":[{\"date\":null,\"weight\":null,\"bp\":null}]}', '2025-05-27 04:29:26', '2025-05-27 04:29:26'),
(3, 1, 3, 9, '{\"date\":\"2025-05-06\",\"time\":\"23:47\",\"record_no\":\"yyy\",\"last_name\":\"yyy\",\"given_name\":\"yyyyyy\",\"middle_name\":\"yyy\",\"age\":\"2\",\"sex\":\"male\",\"maiden_name\":\"yyy\",\"birth_date\":null,\"place_of_birth\":\"yyy\",\"civil_status\":\"yyy\",\"occupation\":\"yyy\",\"religion\":\"yyy\",\"address\":\"yyy\",\"husband_name\":\"yyy\",\"husband_occupation\":\"yyy\",\"husband_contact\":\"yyy\",\"place_of_marriage\":\"yyy\",\"date_of_marriage\":\"2025-05-20\",\"present_problems_other\":\"yyy\",\"danger_signs_other\":\"yyy\",\"lmp\":null,\"edc\":null,\"gravida\":null,\"parity_t\":null,\"parity_p\":null,\"parity_a\":null,\"parity_l\":null,\"aog_weeks\":null,\"chief_complaint\":\"yyy\",\"heent\":\"yyy\",\"heart_lungs\":null,\"diagnosis\":\"yyy\",\"prepared_by\":\"yyy\",\"tetanus\":[{\"date\":\"2025-05-01\",\"signature\":\"yyy\"},{\"date\":null,\"signature\":null},{\"date\":null,\"signature\":null},{\"date\":null,\"signature\":null},{\"date\":null,\"signature\":null}],\"present_problems\":[\"Goiter\",\"Anemia\"],\"ob_history\":[{\"date\":null,\"delivery_type\":null,\"outcome\":null,\"cx\":null}],\"physical_exam_log\":[{\"date\":null,\"weight\":null,\"bp\":null}]}', '2025-05-27 04:47:43', '2025-05-27 04:47:43'),
(4, 1, 3, NULL, '{\"date\":\"2025-05-02\",\"time\":\"06:31\",\"record_no\":\"dasdasd\",\"last_name\":\"bro\",\"given_name\":\"bro\",\"middle_name\":\"bro\",\"age\":\"23\",\"sex\":\"male\",\"maiden_name\":\"bro\",\"birth_date\":null,\"place_of_birth\":\"bro\",\"civil_status\":\"bro\",\"occupation\":\"bro\",\"religion\":\"bro\",\"address\":\"bro\",\"husband_name\":\"bro\",\"husband_occupation\":\"bro\",\"husband_contact\":\"bro\",\"place_of_marriage\":\"bro\",\"date_of_marriage\":null,\"present_problems_other\":null,\"danger_signs_other\":null,\"lmp\":null,\"edc\":null,\"gravida\":null,\"parity_t\":null,\"parity_p\":null,\"parity_a\":null,\"parity_l\":null,\"aog_weeks\":null,\"chief_complaint\":\"bro\",\"heent\":\"bro\",\"heart_lungs\":null,\"diagnosis\":\"bro\",\"prepared_by\":\"bro\",\"tetanus\":[{\"date\":\"2025-05-06\",\"signature\":\"bro\"},{\"date\":\"2025-05-02\",\"signature\":\"bro\"},{\"date\":null,\"signature\":null},{\"date\":null,\"signature\":null},{\"date\":null,\"signature\":null}],\"ob_history\":[{\"date\":null,\"delivery_type\":null,\"outcome\":null,\"cx\":null}],\"physical_exam_log\":[{\"date\":\"2025-05-13\",\"weight\":\"23\",\"bp\":\"233\"}]}', '2025-05-27 14:30:32', '2025-05-27 14:30:32'),
(5, 1, 3, 11, '{\"date\":\"2025-05-06\",\"time\":\"06:44\",\"record_no\":\"dabest\",\"last_name\":\"dabest\",\"given_name\":\"dabest\",\"middle_name\":\"dabest\",\"age\":\"2\",\"sex\":\"male\",\"maiden_name\":\"dabest\",\"birth_date\":null,\"place_of_birth\":\"dabest\",\"civil_status\":\"dabestdabest\",\"occupation\":\"dabest\",\"religion\":\"dabest\",\"address\":\"dabest\",\"husband_name\":\"dabest\",\"husband_occupation\":\"dabest\",\"husband_contact\":\"dabest\",\"place_of_marriage\":\"dabest\",\"date_of_marriage\":null,\"present_problems_other\":null,\"danger_signs_other\":null,\"lmp\":null,\"edc\":null,\"gravida\":null,\"parity_t\":null,\"parity_p\":null,\"parity_a\":null,\"parity_l\":null,\"aog_weeks\":null,\"chief_complaint\":\"dabest\",\"heent\":\"dabest\",\"heart_lungs\":null,\"diagnosis\":\"dabest\",\"prepared_by\":\"dabest\",\"tetanus\":[{\"date\":null,\"signature\":null},{\"date\":null,\"signature\":null},{\"date\":null,\"signature\":null},{\"date\":null,\"signature\":null},{\"date\":null,\"signature\":null}],\"ob_history\":[{\"date\":null,\"delivery_type\":null,\"outcome\":null,\"cx\":null}],\"physical_exam_log\":[{\"date\":null,\"weight\":null,\"bp\":null}]}', '2025-05-27 14:41:07', '2025-05-27 14:41:07'),
(6, 1, 3, 12, '{\"date\":\"2025-05-26\",\"time\":\"10:32\",\"record_no\":\"233\",\"last_name\":\"Suliva\",\"given_name\":\"Van Rodolf\",\"middle_name\":\"Mauricio\",\"age\":null,\"sex\":null,\"maiden_name\":null,\"birth_date\":null,\"place_of_birth\":\"qwe\",\"civil_status\":\"qweqwe\",\"occupation\":\"ewqe\",\"religion\":\"qweqwe\",\"address\":\"Ramos, Tarlac\",\"husband_name\":\"qwe\",\"husband_occupation\":\"qwe\",\"husband_contact\":\"qwe\",\"place_of_marriage\":\"eqwewqe\",\"date_of_marriage\":\"2025-05-06\",\"present_problems_other\":null,\"danger_signs_other\":\"wqe\",\"lmp\":null,\"edc\":null,\"gravida\":\"1\",\"parity_t\":\"2\",\"parity_p\":\"1\",\"parity_a\":\"1\",\"parity_l\":\"1\",\"aog_weeks\":\"1\",\"chief_complaint\":null,\"heent\":\"dasd\",\"heart_lungs\":\"asd\",\"diagnosis\":\"asdasd\",\"prepared_by\":\"asdasd\",\"tetanus\":[{\"date\":null,\"signature\":null},{\"date\":null,\"signature\":null},{\"date\":null,\"signature\":null},{\"date\":null,\"signature\":null},{\"date\":null,\"signature\":null}],\"present_problems\":[\"Bronchial asthma\",\"Goiter\"],\"danger_signs\":[\"Severe pallor\",\"Fever (body weakness)\"],\"ob_history\":[{\"date\":null,\"delivery_type\":null,\"outcome\":null,\"cx\":null}],\"physical_exam_log\":[{\"date\":null,\"weight\":null,\"bp\":null}]}', '2025-05-27 15:32:27', '2025-05-27 15:32:27'),
(7, 1, 4, NULL, '{\"last_name\":\"Norence Gwapo\",\"given_name\":null,\"middle_name\":null,\"age\":null,\"sex\":null,\"others_med_surg_specify\":null,\"others_generative_specify\":null,\"poor_ob_history_specify\":null,\"others_multiple_specify\":null,\"others_infection_specify\":null,\"risks\":[\"gest_dm\",\"cong_ut_anomaly\",\"elderly_gravida\"]}', '2025-05-27 17:05:08', '2025-05-27 17:05:08'),
(8, 1, 4, NULL, '{\"last_name\":\"Norence Gwapo\",\"given_name\":null,\"middle_name\":null,\"age\":null,\"sex\":null,\"others_med_surg_specify\":null,\"others_generative_specify\":null,\"poor_ob_history_specify\":null,\"others_multiple_specify\":null,\"others_infection_specify\":null,\"risks\":[\"gest_dm\",\"pre_eclampsia\"]}', '2025-05-27 17:08:30', '2025-05-27 17:08:30'),
(9, 1, 4, NULL, '{\"last_name\":\"Suliva\",\"given_name\":\"Van Rodolf\",\"middle_name\":null,\"age\":null,\"sex\":null,\"others_med_surg_specify\":null,\"others_generative_specify\":null,\"poor_ob_history_specify\":null,\"others_multiple_specify\":null,\"others_infection_specify\":null,\"risks\":[\"gest_dm\",\"young_primigravida\"]}', '2025-05-27 17:08:46', '2025-05-27 17:08:46'),
(10, 1, 4, NULL, '{\"patient_id\":\"3\",\"last_name\":\"Norence Gwapo\",\"given_name\":null,\"middle_name\":null,\"age\":null,\"sex\":null,\"others_med_surg_specify\":null,\"others_generative_specify\":null,\"poor_ob_history_specify\":null,\"others_multiple_specify\":null,\"others_infection_specify\":null,\"risks\":[\"overt_dm\",\"bacterial_vaginosis\"]}', '2025-05-27 17:23:08', '2025-05-27 17:23:08'),
(11, 1, 4, NULL, '{\"patient_id\":\"12\",\"last_name\":\"Suliva\",\"given_name\":\"Van Rodolf\",\"middle_name\":null,\"age\":null,\"sex\":null,\"others_med_surg_specify\":null,\"others_generative_specify\":null,\"poor_ob_history_specify\":null,\"others_multiple_specify\":null,\"others_infection_specify\":null,\"risks\":[\"overt_dm\",\"hyperthyroidism\",\"chronic_renal\",\"young_primigravida\",\"young_gravida\",\"tuberculosis\"]}', '2025-05-27 17:28:12', '2025-05-27 17:28:12'),
(12, 1, 3, 13, '{\"date\":\"2025-05-04\",\"time\":\"11:57\",\"record_no\":\"berto\",\"last_name\":\"berto\",\"given_name\":\"berto\",\"middle_name\":\"berto\",\"age\":\"23\",\"sex\":\"male\",\"maiden_name\":\"berto\",\"birth_date\":null,\"place_of_birth\":\"berto\",\"civil_status\":\"berto\",\"occupation\":\"berto\",\"religion\":\"berto\",\"address\":\"berto\",\"husband_name\":\"berto\",\"husband_occupation\":\"berto\",\"husband_contact\":\"berto\",\"place_of_marriage\":\"berto\",\"date_of_marriage\":\"2025-05-14\",\"present_problems_other\":null,\"danger_signs_other\":null,\"family_planning\":\"Injectable\",\"prev_pnc\":\"MD\",\"lmp\":null,\"edc\":null,\"gravida\":null,\"parity_t\":null,\"parity_p\":null,\"parity_a\":null,\"parity_l\":null,\"aog_weeks\":null,\"chief_complaint\":null,\"heent\":\"acasd\",\"heart_lungs\":\"asdasd\",\"diagnosis\":\"dasd\",\"prepared_by\":\"berto\",\"tetanus\":[{\"date\":null,\"signature\":null},{\"date\":null,\"signature\":null},{\"date\":null,\"signature\":null},{\"date\":null,\"signature\":null},{\"date\":null,\"signature\":null}],\"present_problems\":[\"Anemia\",\"TB\"],\"danger_signs\":[\"Severe pallor\",\"Fever (body weakness)\"],\"ob_history\":[{\"date\":null,\"delivery_type\":null,\"outcome\":null,\"cx\":null}],\"physical_exam_log\":[{\"date\":null,\"weight\":null,\"bp\":null}]}', '2025-05-27 17:57:50', '2025-05-27 17:57:50');

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
(1, 9, 'dasd', '2025-05-12', '23', 'qweqwe', '2025-05-16 21:52:47', '2025-05-21 22:45:05'),
(2, 7, 'gian', NULL, NULL, NULL, '2025-05-21 23:43:33', '2025-05-21 23:43:33'),
(3, 8, 'Norence Gwapo', NULL, NULL, NULL, '2025-05-21 23:43:33', '2025-05-21 23:43:33'),
(4, 3, 'Patient User', NULL, NULL, NULL, '2025-05-21 23:43:33', '2025-05-21 23:43:33'),
(5, 9, 'Juan Santos', '1990-02-15', '09171230001', '123 Rizal St., Sampaloc, Manila', '2025-05-22 20:26:08', '2025-05-22 20:26:08'),
(6, 7, 'Maria Reyes', '1995-08-30', '09171230002', '45 Mabini Ave., Quezon City', '2025-05-22 20:26:08', '2025-05-22 20:26:08'),
(7, NULL, 'sdasd', '2025-05-12', 'asdasd', 'qweqweqwe', '2025-05-23 19:30:05', '2025-05-23 19:30:05'),
(8, NULL, 'dinadalaw', '2025-05-04', 'bawat gabi', 'bawat gabi', '2025-05-23 19:30:24', '2025-05-23 19:30:24'),
(9, NULL, 'yyy, yyyyyy', NULL, 'yyy', 'yyy', '2025-05-27 04:47:43', '2025-05-27 04:47:43'),
(11, 1, 'dabest, dabest', NULL, 'dabest', 'dabest', '2025-05-27 14:41:07', '2025-05-27 14:41:07'),
(12, 1, 'Suliva, Van Rodolf', NULL, '233', 'Ramos, Tarlac', '2025-05-27 15:32:27', '2025-05-27 15:32:27'),
(13, 1, 'berto, berto', NULL, 'berto', 'berto', '2025-05-27 17:57:50', '2025-05-27 17:57:50');

-- --------------------------------------------------------

--
-- Table structure for table `patient_profiles`
--

CREATE TABLE `patient_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `sex` enum('male','female') DEFAULT NULL,
  `religion` varchar(100) DEFAULT NULL,
  `date_recorded` date DEFAULT NULL,
  `father_name` varchar(255) DEFAULT NULL,
  `father_occupation` varchar(255) DEFAULT NULL,
  `mother_name` varchar(255) DEFAULT NULL,
  `mother_occupation` varchar(255) DEFAULT NULL,
  `place_of_marriage` varchar(255) DEFAULT NULL,
  `date_of_marriage` date DEFAULT NULL,
  `tetanus_t1_date` date DEFAULT NULL,
  `tetanus_t1_signature` varchar(255) DEFAULT NULL,
  `tetanus_t2_date` date DEFAULT NULL,
  `tetanus_t2_signature` varchar(255) DEFAULT NULL,
  `tetanus_t3_date` date DEFAULT NULL,
  `tetanus_t3_signature` varchar(255) DEFAULT NULL,
  `tetanus_t4_date` date DEFAULT NULL,
  `tetanus_t4_signature` varchar(255) DEFAULT NULL,
  `tetanus_t5_date` date DEFAULT NULL,
  `tetanus_t5_signature` varchar(255) DEFAULT NULL,
  `present_health_problems` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`present_health_problems`)),
  `present_problems_other` varchar(255) DEFAULT NULL,
  `danger_signs` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`danger_signs`)),
  `danger_signs_other` varchar(255) DEFAULT NULL,
  `ob_history` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`ob_history`)),
  `family_planning` enum('Pills','IUD','Injectable','Withdrawal','Standard') DEFAULT NULL,
  `prev_pnc` enum('Private','MD','HC','TBA') DEFAULT NULL,
  `lmp` date DEFAULT NULL,
  `edc` date DEFAULT NULL,
  `gravida` tinyint(3) UNSIGNED DEFAULT NULL,
  `parity_t` tinyint(3) UNSIGNED DEFAULT NULL,
  `parity_p` tinyint(3) UNSIGNED DEFAULT NULL,
  `parity_a` tinyint(3) UNSIGNED DEFAULT NULL,
  `parity_l` tinyint(3) UNSIGNED DEFAULT NULL,
  `aog_weeks` tinyint(3) UNSIGNED DEFAULT NULL,
  `chief_complaint` text DEFAULT NULL,
  `physical_exam_log` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`physical_exam_log`)),
  `heent` text DEFAULT NULL,
  `heart_lungs` text DEFAULT NULL,
  `diagnosis` text DEFAULT NULL,
  `prepared_by` varchar(255) DEFAULT NULL,
  `contact_no` varchar(50) DEFAULT NULL,
  `blood_type` varchar(3) DEFAULT NULL,
  `delivery_type` varchar(50) DEFAULT NULL,
  `birth_weight` decimal(5,2) DEFAULT NULL,
  `birth_length` decimal(5,2) DEFAULT NULL,
  `apgar_appearance` tinyint(4) DEFAULT NULL,
  `apgar_pulse` tinyint(4) DEFAULT NULL,
  `apgar_grimace` tinyint(4) DEFAULT NULL,
  `apgar_activity` tinyint(4) DEFAULT NULL,
  `apgar_respiration` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `patient_profiles`
--

INSERT INTO `patient_profiles` (`id`, `patient_id`, `sex`, `religion`, `date_recorded`, `father_name`, `father_occupation`, `mother_name`, `mother_occupation`, `place_of_marriage`, `date_of_marriage`, `tetanus_t1_date`, `tetanus_t1_signature`, `tetanus_t2_date`, `tetanus_t2_signature`, `tetanus_t3_date`, `tetanus_t3_signature`, `tetanus_t4_date`, `tetanus_t4_signature`, `tetanus_t5_date`, `tetanus_t5_signature`, `present_health_problems`, `present_problems_other`, `danger_signs`, `danger_signs_other`, `ob_history`, `family_planning`, `prev_pnc`, `lmp`, `edc`, `gravida`, `parity_t`, `parity_p`, `parity_a`, `parity_l`, `aog_weeks`, `chief_complaint`, `physical_exam_log`, `heent`, `heart_lungs`, `diagnosis`, `prepared_by`, `contact_no`, `blood_type`, `delivery_type`, `birth_weight`, `birth_length`, `apgar_appearance`, `apgar_pulse`, `apgar_grimace`, `apgar_activity`, `apgar_respiration`, `created_at`, `updated_at`) VALUES
(1, 5, 'male', 'Catholic', '2025-05-23', 'Pedro Santos', 'Engineer', 'Maria Santos', 'Teacher', 'San Fernando Church', '2012-11-20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '09171230001', 'A+', 'Normal Spontaneous Delivery', 3.50, 52.00, 2, 2, 2, 2, 2, '2025-05-22 20:26:08', '2025-05-22 20:26:08'),
(2, 6, 'female', 'Iglesia ni Cristo', '2025-05-23', 'Carlos Reyes', 'Businessman', 'Lucia Reyes', 'Nurse', 'Quezon Memorial Chapel', '2018-05-12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '09171230002', 'O−', 'Cesarean Section', 3.20, 50.50, 2, 1, 2, 2, 1, '2025-05-22 20:26:08', '2025-05-22 20:26:08'),
(3, 1, 'male', NULL, '2025-05-23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'A+', 'NSD', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-22 23:01:45', '2025-05-22 23:01:45'),
(4, 2, 'female', NULL, '2025-05-23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'O-', 'CS', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-22 23:01:45', '2025-05-22 23:01:45'),
(5, 9, 'male', 'yyy', NULL, NULL, NULL, NULL, NULL, 'yyy', '2025-05-20', '2025-05-01', 'yyy', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '\"[\\\"Goiter\\\",\\\"Anemia\\\"]\"', 'yyy', '\"[]\"', 'yyy', '\"[{\\\"date\\\":null,\\\"delivery_type\\\":null,\\\"outcome\\\":null,\\\"cx\\\":null}]\"', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'yyy', '\"[{\\\"date\\\":null,\\\"weight\\\":null,\\\"bp\\\":null}]\"', 'yyy', NULL, 'yyy', 'yyy', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-27 04:47:43', '2025-05-27 04:47:43'),
(7, 11, 'male', 'dabest', NULL, NULL, NULL, NULL, NULL, 'dabest', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '\"[]\"', NULL, '\"[]\"', NULL, '\"[{\\\"date\\\":null,\\\"delivery_type\\\":null,\\\"outcome\\\":null,\\\"cx\\\":null}]\"', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'dabest', '\"[{\\\"date\\\":null,\\\"weight\\\":null,\\\"bp\\\":null}]\"', 'dabest', NULL, 'dabest', 'dabest', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-27 14:41:07', '2025-05-27 14:41:07'),
(8, 12, NULL, 'qweqwe', NULL, NULL, NULL, NULL, NULL, 'eqwewqe', '2025-05-06', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '\"[\\\"Bronchial asthma\\\",\\\"Goiter\\\"]\"', NULL, '\"[\\\"Severe pallor\\\",\\\"Fever (body weakness)\\\"]\"', 'wqe', '\"[{\\\"date\\\":null,\\\"delivery_type\\\":null,\\\"outcome\\\":null,\\\"cx\\\":null}]\"', NULL, NULL, NULL, NULL, 1, 2, 1, 1, 1, 1, NULL, '\"[{\\\"date\\\":null,\\\"weight\\\":null,\\\"bp\\\":null}]\"', 'dasd', 'asd', 'asdasd', 'asdasd', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-27 15:32:27', '2025-05-27 15:32:27'),
(9, 13, 'male', 'berto', NULL, NULL, NULL, NULL, NULL, 'berto', '2025-05-14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '\"[\\\"Anemia\\\",\\\"TB\\\"]\"', NULL, '\"[\\\"Severe pallor\\\",\\\"Fever (body weakness)\\\"]\"', NULL, '\"[{\\\"date\\\":null,\\\"delivery_type\\\":null,\\\"outcome\\\":null,\\\"cx\\\":null}]\"', 'Injectable', 'MD', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '\"[{\\\"date\\\":null,\\\"weight\\\":null,\\\"bp\\\":null}]\"', 'acasd', 'asdasd', 'dasd', 'berto', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-27 17:57:50', '2025-05-27 17:57:50');

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
  `shift_start` time DEFAULT NULL,
  `shift_end` time DEFAULT NULL,
  `department` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `shift_start_sunday` time DEFAULT NULL,
  `shift_end_sunday` time DEFAULT NULL,
  `shift_start_monday` time DEFAULT NULL,
  `shift_end_monday` time DEFAULT NULL,
  `shift_start_tuesday` time DEFAULT NULL,
  `shift_end_tuesday` time DEFAULT NULL,
  `shift_start_wednesday` time DEFAULT NULL,
  `shift_end_wednesday` time DEFAULT NULL,
  `shift_start_thursday` time DEFAULT NULL,
  `shift_end_thursday` time DEFAULT NULL,
  `shift_start_friday` time DEFAULT NULL,
  `shift_end_friday` time DEFAULT NULL,
  `shift_start_saturday` time DEFAULT NULL,
  `shift_end_saturday` time DEFAULT NULL,
  `start_day` varchar(20) DEFAULT 'Monday',
  `shift_length` decimal(5,2) DEFAULT 8.50,
  `include_sunday` tinyint(1) NOT NULL DEFAULT 0,
  `include_monday` tinyint(1) NOT NULL DEFAULT 0,
  `include_tuesday` tinyint(1) NOT NULL DEFAULT 0,
  `include_wednesday` tinyint(1) NOT NULL DEFAULT 0,
  `include_thursday` tinyint(1) NOT NULL DEFAULT 0,
  `include_friday` tinyint(1) NOT NULL DEFAULT 0,
  `include_saturday` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`id`, `staff_name`, `role`, `date`, `shift_start`, `shift_end`, `department`, `created_at`, `updated_at`, `shift_start_sunday`, `shift_end_sunday`, `shift_start_monday`, `shift_end_monday`, `shift_start_tuesday`, `shift_end_tuesday`, `shift_start_wednesday`, `shift_end_wednesday`, `shift_start_thursday`, `shift_end_thursday`, `shift_start_friday`, `shift_end_friday`, `shift_start_saturday`, `shift_end_saturday`, `start_day`, `shift_length`, `include_sunday`, `include_monday`, `include_tuesday`, `include_wednesday`, `include_thursday`, `include_friday`, `include_saturday`) VALUES
(1, 'dsf', 'qwewqe', '2025-05-11', '18:05:00', '19:02:00', 'qeqweqwe', '2025-05-22 23:02:42', '2025-05-22 23:02:42', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Monday', 8.50, 0, 0, 0, 0, 0, 0, 0),
(2, 'wqeqwe', 'wqeqwe', '2025-05-11', NULL, NULL, 'dasd', '2025-05-24 00:30:49', '2025-05-24 00:30:49', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Monday', 8.50, 0, 0, 0, 0, 0, 0, 0),
(3, 'gian pogs', 'qweqweqwe', '2025-05-12', NULL, NULL, 'Gynecology', '2025-05-24 00:33:25', '2025-05-24 00:33:25', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Monday', 8.50, 0, 0, 0, 0, 0, 0, 0),
(4, 'lancy', 'wqeqwe', '2025-05-16', NULL, NULL, 'Gynecology', '2025-05-24 00:36:53', '2025-05-24 00:36:53', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Monday', 8.50, 0, 0, 0, 0, 0, 0, 0),
(5, 'johnny sins', 'qwe', '2025-05-15', NULL, NULL, 'dasd', '2025-05-24 00:41:55', '2025-05-24 00:41:55', '11:00:00', '21:00:00', '10:00:00', '20:00:00', '10:00:00', '20:00:00', '10:00:00', '20:00:00', '10:00:00', '20:00:00', '10:00:00', '20:00:00', '10:00:00', '20:00:00', 'Wednesday', 21.50, 1, 1, 1, 0, 0, 0, 0),
(6, 'ge', 'eqwe', '2025-05-06', NULL, NULL, 'Gynecology', '2025-05-24 01:01:15', '2025-05-24 01:01:15', '00:00:00', '22:00:00', '11:00:00', '21:00:00', '10:00:00', '20:00:00', '10:00:00', '20:00:00', '10:00:00', '20:00:00', '10:00:00', '20:00:00', '10:00:00', '20:00:00', 'Wednesday', 8.50, 1, 1, 0, 0, 0, 0, 0),
(7, 'dasdsad', 'asdasd', '2025-05-07', NULL, NULL, 'Gynecology', '2025-05-24 12:31:56', '2025-05-24 12:31:56', '00:00:00', '20:00:00', '11:00:00', '20:00:00', '10:00:00', '20:00:00', '10:00:00', '20:00:00', '10:00:00', '20:00:00', '10:00:00', '20:00:00', '10:00:00', '20:00:00', 'Thursday', 20.50, 1, 1, 0, 0, 0, 0, 0),
(8, 'ros', 'wqeqwe', '2025-05-08', NULL, NULL, 'Gynecology', '2025-05-24 12:32:27', '2025-05-24 12:32:27', '00:00:00', '20:00:00', '02:00:00', '20:00:00', '10:00:00', '20:00:00', '10:00:00', '20:00:00', '10:00:00', '20:00:00', '10:00:00', '20:00:00', '10:00:00', '20:00:00', 'Wednesday', 8.50, 1, 1, 0, 0, 0, 0, 0),
(9, 'lancy', 'lancy', '2025-05-08', NULL, NULL, 'Gynecology', '2025-05-24 13:08:28', '2025-05-24 13:08:28', '06:08:00', '17:09:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Monday', 8.50, 1, 0, 0, 0, 0, 0, 0),
(10, 'asdasd', 'dasd', '2025-05-12', NULL, NULL, 'Gynecology', '2025-05-26 16:40:53', '2025-05-26 16:40:53', '09:40:00', '20:41:00', '09:40:00', '22:40:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Thursday', 8.50, 1, 1, 0, 0, 0, 0, 0),
(11, 'Norency Pie', 'Doktor', '2025-05-14', NULL, NULL, 'Obstetrics', '2025-05-26 16:41:38', '2025-05-26 16:41:38', '00:41:00', '21:41:00', '10:41:00', '20:43:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Wednesday', 8.50, 1, 1, 0, 0, 0, 0, 0),
(12, 'sdasd', 'ewqe', '2025-05-10', NULL, NULL, 'Gynecology', '2025-05-26 16:47:25', '2025-05-26 16:47:25', '09:47:00', '21:47:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Wednesday', 8.50, 1, 0, 0, 0, 0, 0, 0),
(13, 'Johnray Cena', 'Patient', '2025-05-20', NULL, NULL, 'Hotdog', '2025-05-26 16:48:37', '2025-05-26 16:48:37', '08:51:00', '23:48:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Wednesday', 8.50, 1, 0, 0, 0, 0, 0, 0),
(14, 'Mystertio', 'Mystertio', '2025-05-13', NULL, NULL, 'Gynecology', '2025-05-26 16:53:53', '2025-05-26 16:53:53', '11:53:00', '20:53:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Tuesday', 8.50, 1, 0, 0, 0, 0, 0, 0),
(15, 'adrian', 'Patient', '2025-05-23', NULL, NULL, 'Hotdog', '2025-05-26 17:12:56', '2025-05-26 17:12:56', '10:12:00', '21:12:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Monday', 8.50, 1, 0, 0, 0, 0, 0, 0),
(16, 'bos', 'qwe', '2025-04-30', NULL, NULL, 'Gynecology', '2025-05-26 17:27:41', '2025-05-26 17:27:41', '09:27:00', '21:27:00', '09:27:00', '21:27:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Monday', 8.50, 1, 1, 0, 0, 0, 0, 0),
(17, 'myday', 'asdasd', '2025-05-06', NULL, NULL, 'Gynecology', '2025-05-26 17:40:31', '2025-05-26 17:40:31', '09:40:00', '21:41:00', '09:40:00', '21:40:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Thursday', 8.50, 1, 1, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tokens`
--

CREATE TABLE `tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED DEFAULT NULL,
  `code` varchar(255) NOT NULL,
  `served_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tokens`
--

INSERT INTO `tokens` (`id`, `department_id`, `patient_id`, `code`, `served_at`, `created_at`, `updated_at`) VALUES
(1, 6, NULL, '001', NULL, '2025-05-16 03:33:51', '2025-05-16 03:33:51'),
(2, 6, NULL, '002', NULL, '2025-05-16 03:33:53', '2025-05-16 03:33:53'),
(3, 6, NULL, '003', NULL, '2025-05-16 03:41:28', '2025-05-16 03:41:28'),
(4, 5, NULL, '001', NULL, '2025-05-16 03:51:14', '2025-05-16 03:51:14'),
(5, 6, NULL, '004', NULL, '2025-05-16 17:10:34', '2025-05-16 17:10:34'),
(6, 6, NULL, '005', NULL, '2025-05-16 23:01:36', '2025-05-16 23:01:36'),
(7, 5, NULL, '002', NULL, '2025-05-16 23:01:42', '2025-05-16 23:01:42'),
(8, 5, NULL, 'D003', NULL, '2025-05-16 23:07:39', '2025-05-16 23:07:39'),
(9, 1, NULL, 'O001', '2025-05-21 17:07:31', '2025-05-16 23:14:42', '2025-05-21 17:07:31'),
(10, 2, NULL, 'G001', '2025-05-17 12:49:52', '2025-05-16 23:37:46', '2025-05-17 12:49:52'),
(11, 3, NULL, 'I001', NULL, '2025-05-16 23:37:49', '2025-05-16 23:37:49'),
(12, 6, NULL, '006', NULL, '2025-05-17 12:31:28', '2025-05-17 12:31:28'),
(13, 2, NULL, 'G002', '2025-05-20 17:03:07', '2025-05-17 12:31:32', '2025-05-20 17:03:07'),
(14, 3, NULL, 'I002', NULL, '2025-05-17 12:31:34', '2025-05-17 12:31:34'),
(15, 3, NULL, 'I003', NULL, '2025-05-17 12:35:48', '2025-05-17 12:35:48'),
(16, 6, NULL, '007', NULL, '2025-05-17 12:40:14', '2025-05-17 12:40:14'),
(17, 6, NULL, '008', NULL, '2025-05-20 01:15:03', '2025-05-20 01:15:03'),
(18, 5, NULL, 'D004', NULL, '2025-05-20 02:13:32', '2025-05-20 02:13:32'),
(19, 5, NULL, 'D005', NULL, '2025-05-20 02:15:02', '2025-05-20 02:15:02'),
(20, 6, NULL, 'A009', NULL, '2025-05-20 02:46:32', '2025-05-20 02:46:32'),
(21, 4, NULL, 'P001', '2025-05-21 20:43:33', '2025-05-20 12:38:27', '2025-05-21 20:43:33'),
(22, 4, NULL, 'P002', '2025-05-21 20:43:38', '2025-05-20 12:40:10', '2025-05-21 20:43:38'),
(23, 5, NULL, 'D006', NULL, '2025-05-20 12:45:15', '2025-05-20 12:45:15'),
(24, 5, NULL, 'D007', NULL, '2025-05-20 12:47:40', '2025-05-20 12:47:40'),
(25, 6, NULL, 'A010', NULL, '2025-05-20 12:49:45', '2025-05-20 12:49:45'),
(26, 6, NULL, '011', NULL, '2025-05-20 16:45:37', '2025-05-20 16:45:37'),
(27, 2, NULL, 'G003', '2025-05-20 17:04:08', '2025-05-20 16:45:46', '2025-05-20 17:04:08'),
(28, 2, NULL, 'G004', '2025-05-20 17:04:32', '2025-05-20 17:03:39', '2025-05-20 17:04:32'),
(29, 2, NULL, 'G005', '2025-05-20 17:09:45', '2025-05-20 17:03:46', '2025-05-20 17:09:45'),
(30, 1, NULL, 'O002', '2025-05-21 17:07:41', '2025-05-21 17:05:49', '2025-05-21 17:07:41'),
(31, 1, NULL, 'O003', '2025-05-21 17:07:51', '2025-05-21 17:05:51', '2025-05-21 17:07:51'),
(32, 1, NULL, 'O004', '2025-05-21 17:07:57', '2025-05-21 17:05:52', '2025-05-21 17:07:57'),
(33, 1, NULL, 'O005', '2025-05-21 17:08:05', '2025-05-21 17:05:54', '2025-05-21 17:08:05'),
(34, 1, NULL, 'O006', '2025-05-21 17:08:12', '2025-05-21 17:07:11', '2025-05-21 17:08:12'),
(35, 1, NULL, 'O007', '2025-05-21 17:32:13', '2025-05-21 17:31:25', '2025-05-21 17:32:13'),
(36, 1, NULL, 'O008', '2025-05-21 17:32:14', '2025-05-21 17:31:26', '2025-05-21 17:32:14'),
(37, 1, NULL, 'O009', '2025-05-21 17:32:16', '2025-05-21 17:31:28', '2025-05-21 17:32:16'),
(38, 1, NULL, 'O010', '2025-05-21 17:32:20', '2025-05-21 17:31:29', '2025-05-21 17:32:20'),
(39, 1, NULL, 'O011', '2025-05-21 17:32:23', '2025-05-21 17:31:39', '2025-05-21 17:32:23'),
(40, 1, NULL, 'O012', '2025-05-21 17:40:05', '2025-05-21 17:31:53', '2025-05-21 17:40:05'),
(41, 1, NULL, 'O013', NULL, '2025-05-21 17:40:32', '2025-05-21 17:40:32'),
(42, 1, NULL, 'O014', NULL, '2025-05-21 17:40:36', '2025-05-21 17:40:36'),
(43, 1, NULL, 'O015', NULL, '2025-05-21 17:40:36', '2025-05-21 17:40:36'),
(44, 1, NULL, 'O016', NULL, '2025-05-21 17:40:36', '2025-05-21 17:40:36'),
(45, 1, NULL, 'O017', NULL, '2025-05-21 17:40:37', '2025-05-21 17:40:37'),
(46, 1, NULL, 'O018', NULL, '2025-05-21 17:40:37', '2025-05-21 17:40:37'),
(47, 1, NULL, 'O019', NULL, '2025-05-21 17:40:38', '2025-05-21 17:40:38'),
(48, 1, NULL, 'O020', NULL, '2025-05-21 17:40:45', '2025-05-21 17:40:45'),
(49, 1, NULL, 'O021', NULL, '2025-05-21 19:39:24', '2025-05-21 19:39:24'),
(50, 6, NULL, 'A012', NULL, '2025-05-21 19:46:39', '2025-05-21 19:46:39'),
(51, 2, NULL, 'G006', NULL, '2025-05-21 19:52:00', '2025-05-21 19:52:00'),
(52, 5, NULL, 'D008', NULL, '2025-05-21 19:54:45', '2025-05-21 19:54:45'),
(53, 4, NULL, 'P003', '2025-05-23 01:16:43', '2025-05-21 20:42:35', '2025-05-23 01:16:43'),
(54, 4, NULL, 'P004', '2025-05-23 05:30:39', '2025-05-21 20:43:06', '2025-05-23 05:30:39'),
(55, 1, NULL, 'O022', NULL, '2025-05-21 20:52:02', '2025-05-21 20:52:02'),
(56, 4, NULL, 'P005', '2025-05-23 05:30:40', '2025-05-21 20:52:05', '2025-05-23 05:30:40'),
(57, 4, NULL, 'P006', '2025-05-23 05:30:43', '2025-05-23 01:13:01', '2025-05-23 05:30:43'),
(58, 4, NULL, 'P007', '2025-05-23 05:30:45', '2025-05-23 01:13:04', '2025-05-23 05:30:45'),
(59, 4, NULL, 'P008', '2025-05-23 05:30:47', '2025-05-23 01:13:09', '2025-05-23 05:30:47'),
(60, 4, NULL, 'P009', '2025-05-23 05:30:48', '2025-05-23 01:13:10', '2025-05-23 05:30:48'),
(61, 4, NULL, 'P010', '2025-05-23 05:30:51', '2025-05-23 01:13:22', '2025-05-23 05:30:51'),
(62, 4, NULL, 'P011', '2025-05-23 05:30:53', '2025-05-23 01:14:22', '2025-05-23 05:30:53'),
(63, 4, NULL, 'P012', '2025-05-23 05:30:57', '2025-05-23 01:16:57', '2025-05-23 05:30:57'),
(64, 4, NULL, 'P013', '2025-05-23 05:34:10', '2025-05-23 01:18:25', '2025-05-23 05:34:10'),
(65, 4, NULL, 'P014', '2025-05-23 05:34:13', '2025-05-23 01:20:42', '2025-05-23 05:34:13'),
(66, 4, NULL, 'P015', NULL, '2025-05-23 01:25:37', '2025-05-23 01:25:37'),
(67, 4, NULL, 'P016', NULL, '2025-05-23 01:25:42', '2025-05-23 01:25:42'),
(68, 4, NULL, 'P017', NULL, '2025-05-23 01:41:44', '2025-05-23 01:41:44'),
(69, 4, NULL, 'P018', NULL, '2025-05-23 01:41:55', '2025-05-23 01:41:55'),
(70, 4, NULL, 'P019', NULL, '2025-05-23 02:00:11', '2025-05-23 02:00:11'),
(71, 4, NULL, 'P020', NULL, '2025-05-23 05:30:16', '2025-05-23 05:30:16'),
(72, 1, NULL, 'O023', NULL, '2025-05-27 17:57:50', '2025-05-27 17:57:50');

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
(10, 'enn', 'encode@gmail.com', NULL, '$2y$10$uLLTe/LAAh6eOASpgY3SYOQDeW1RDWndHrqX5A1k2i0jI34szlT/O', 'encoder', NULL, '2025-05-20 01:31:17', '2025-05-20 01:31:17'),
(11, 'gian macho', 'g@gmail.com', NULL, '$2y$10$fgfJEdb9ap3tgYN3Kwdp7eGCopaJSkU31luYXuPBqk20wAb98EkE.', 'encoder', NULL, '2025-05-23 13:24:10', '2025-05-23 13:24:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `maternal_high_risk_records`
--
ALTER TABLE `maternal_high_risk_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mhr_patient_idx` (`patient_id`);

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
  ADD KEY `opd_submissions_user_id_index` (`user_id`),
  ADD KEY `opd_submissions_form_id_index` (`form_id`),
  ADD KEY `opd_submissions_patient_id_index` (`patient_id`);

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
-- Indexes for table `patient_profiles`
--
ALTER TABLE `patient_profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_id` (`patient_id`);

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_start_day` (`start_day`),
  ADD KEY `idx_shift_start` (`shift_start_monday`,`shift_start_tuesday`,`shift_start_wednesday`,`shift_start_thursday`,`shift_start_friday`,`shift_start_saturday`);

--
-- Indexes for table `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tokens_department_id_foreign` (`department_id`),
  ADD KEY `tokens_patient_id_foreign` (`patient_id`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `maternal_high_risk_records`
--
ALTER TABLE `maternal_high_risk_records`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `opd_forms`
--
ALTER TABLE `opd_forms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `opd_submissions`
--
ALTER TABLE `opd_submissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `patient_profiles`
--
ALTER TABLE `patient_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `patient_visits`
--
ALTER TABLE `patient_visits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tokens`
--
ALTER TABLE `tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `maternal_high_risk_records`
--
ALTER TABLE `maternal_high_risk_records`
  ADD CONSTRAINT `mhr_patient_fk` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `opd_submissions`
--
ALTER TABLE `opd_submissions`
  ADD CONSTRAINT `opd_submissions_form_id_fk` FOREIGN KEY (`form_id`) REFERENCES `opd_forms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `opd_submissions_patient_id_fk` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `opd_submissions_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `patients`
--
ALTER TABLE `patients`
  ADD CONSTRAINT `patients_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `patient_profiles`
--
ALTER TABLE `patient_profiles`
  ADD CONSTRAINT `patient_profiles_patient_id_fk` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `patient_visits`
--
ALTER TABLE `patient_visits`
  ADD CONSTRAINT `fk_patient_visits_patient_id` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tokens`
--
ALTER TABLE `tokens`
  ADD CONSTRAINT `tokens_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tokens_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
