-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 17, 2024 at 12:15 PM
-- Server version: 8.0.31
-- PHP Version: 8.1.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `barber_booking`
--

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

DROP TABLE IF EXISTS `cities`;
CREATE TABLE IF NOT EXISTS `cities` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name_en` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_ar` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_ur` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state_id` int NOT NULL DEFAULT '0',
  `country_id` int NOT NULL DEFAULT '0',
  `status` int NOT NULL DEFAULT '0',
  `is_delete` int NOT NULL DEFAULT '0' COMMENT '1 => data delete,0 => data not delete',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `name_en`, `name_ar`, `name_ur`, `state_id`, `country_id`, `status`, `is_delete`, `created_at`, `updated_at`) VALUES
(5, 'city 44', 'city 55', 'city 66', 12, 16, 0, 1, '2024-05-16 05:58:46', '2024-05-16 07:05:03');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
CREATE TABLE IF NOT EXISTS `countries` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `shortname` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_en` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_ar` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_ur` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phonecode` int DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0',
  `is_delete` int NOT NULL DEFAULT '0' COMMENT '1 => data delete,0 => data not delete',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `shortname`, `name_en`, `name_ar`, `name_ur`, `phonecode`, `status`, `is_delete`, `created_at`, `updated_at`) VALUES
(18, 'fgh', 'fgh', 'fghfgh', 'fghfgh', 41, 1, 0, '2024-05-17 04:57:45', '2024-05-17 04:57:45'),
(16, 'Ar', 'Saudi Arabia', 'المملكة العربية السعودية', 'سعودی عرب', 11, 1, 0, '2024-05-16 05:56:47', '2024-05-16 05:56:47'),
(17, 'Dexter Blanchard', 'Silas Nash', 'Stephen Sykes', 'Gregory Burton', 54, 1, 0, '2024-05-17 04:43:31', '2024-05-17 04:43:31'),
(15, 'IN', 'India', 'الهند', 'بھارت', 91, 0, 0, '2024-05-16 05:55:56', '2024-05-16 07:12:30');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_05_14_092705_add_field_to_users_table', 1),
(6, '2024_05_15_114723_create_permission_tables', 1),
(8, '2024_05_15_131340_add_field_to_users_table', 2),
(9, '2024_05_16_041856_create_countries_table', 3),
(10, '2024_05_16_063623_create_states_table', 4),
(12, '2024_05_16_083027_create_cities_table', 5),
(14, '2024_05_17_055955_create_modules_table', 6),
(15, '2024_05_17_062239_add_field_to_permissions_table', 7);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE IF NOT EXISTS `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1);

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

DROP TABLE IF EXISTS `modules`;
CREATE TABLE IF NOT EXISTS `modules` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Country', '2024-05-17 00:36:10', '2024-05-17 00:37:34'),
(2, 'State', '2024-05-17 00:36:16', '2024-05-17 00:36:16'),
(4, 'City', '2024-05-17 00:38:21', '2024-05-17 00:38:21'),
(3, 'Role', '2024-05-17 00:36:16', '2024-05-17 00:36:16');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `module_name` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `module_name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'role-list', 'Role', 'web', '2024-05-15 06:29:56', '2024-05-15 06:29:56'),
(2, 'role-create', 'Role', 'web', '2024-05-15 06:29:56', '2024-05-15 06:29:56'),
(3, 'role-edit', 'Role', 'web', '2024-05-15 06:29:56', '2024-05-15 06:29:56'),
(4, 'role-delete', 'Role', 'web', '2024-05-15 06:29:56', '2024-05-15 06:29:56'),
(5, 'country-list', 'Country', 'web', '2024-05-15 06:29:56', '2024-05-15 06:29:56'),
(6, 'country-create', 'Country', 'web', '2024-05-15 06:29:56', '2024-05-15 06:29:56'),
(7, 'country-edit', 'Country', 'web', '2024-05-15 06:29:56', '2024-05-15 06:29:56'),
(8, 'country-delete', 'Country', 'web', '2024-05-15 06:29:56', '2024-05-15 06:29:56');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'web', '2024-05-15 06:29:56', '2024-05-15 06:29:56');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(1, 20),
(1, 21),
(2, 1),
(2, 20),
(2, 21),
(3, 1),
(3, 20),
(3, 21),
(4, 1),
(4, 20),
(4, 21),
(5, 1),
(5, 20),
(5, 21),
(6, 1),
(6, 20),
(6, 21),
(7, 1),
(7, 20),
(7, 21),
(8, 1),
(8, 20),
(8, 21);

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

DROP TABLE IF EXISTS `states`;
CREATE TABLE IF NOT EXISTS `states` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name_en` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_ar` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_ur` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_id` int NOT NULL COMMENT '1 => data delete,0 => data not delete',
  `status` int NOT NULL DEFAULT '0',
  `is_delete` int NOT NULL DEFAULT '0' COMMENT '1 => data delete,0 => data not delete',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `name_en`, `name_ar`, `name_ur`, `country_id`, `status`, `is_delete`, `created_at`, `updated_at`) VALUES
(15, 'panjab', 'panjab', 'panjab', 15, 1, 0, '2024-05-16 05:57:59', '2024-05-16 05:57:59'),
(14, 'gujrat', 'gujrat', 'gujrat', 15, 1, 0, '2024-05-16 05:57:43', '2024-05-16 05:57:43'),
(13, 'State 3', 'State 3', 'State 3', 16, 1, 0, '2024-05-16 05:57:33', '2024-05-16 05:57:33'),
(12, 'State 2', 'State 2', 'State 2', 16, 1, 0, '2024-05-16 05:57:23', '2024-05-16 05:57:23'),
(11, 'State 1', 'State 1', 'State 1', 16, 1, 0, '2024-05-16 05:57:13', '2024-05-16 05:57:13'),
(16, 'tamil nadu', 'tamil nadu', 'tamil nadu', 15, 1, 0, '2024-05-16 05:58:12', '2024-05-16 05:58:12');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_image` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_type` int NOT NULL DEFAULT '4' COMMENT '1 Admin,2 Sub Admin,3 Barber,4 Customer',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_delete` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `profile_image`, `status`, `phone`, `user_type`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `is_delete`) VALUES
(1, 'admin', 'admin@ahjez.com', '1715929033_profile_image.png', '0', '798654654', 1, NULL, '$2y$10$Y4YKN1Qa5O.yMMxjEUUUwuq5EQGskyJxLxuy4MRYnOLT68MOR0QKu', NULL, '2024-05-15 06:29:56', '2024-05-17 01:27:13', '0'),
(3, 'admindfg', 'admdfgn@ahjez.com', NULL, '0', '798654654', 1, NULL, '$2y$10$Y4YKN1Qa5O.yMMxjEUUUwuq5EQGskyJxLxuy4MRYnOLT68MOR0QKu', NULL, '2024-05-15 06:29:56', '2024-05-15 08:07:14', '0'),
(4, 'dfgdfgdfg', 'addfgmdfgn@ahjez.com', NULL, '0', '798654654', 1, NULL, '$2y$10$Y4YKN1Qa5O.yMMxjEUUUwuq5EQGskyJxLxuy4MRYnOLT68MOR0QKu', NULL, '2024-05-15 06:29:56', '2024-05-15 08:07:17', '1');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
