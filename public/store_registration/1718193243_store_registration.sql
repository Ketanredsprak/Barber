-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 12, 2024 at 02:01 AM
-- Server version: 10.5.15-MariaDB-cll-lve
-- PHP Version: 8.1.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `redspar6_Ehjez`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_image` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_type` int(11) NOT NULL DEFAULT 4 COMMENT '1 Admin,2 Sub Admin,3 Barber,4 Customer',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_delete` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `profile_image`, `status`, `phone`, `user_type`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `is_delete`) VALUES
(1, 'admin', 'admin@ahjez.com', '1715929033_profile_image.png', '0', '798654654', 1, NULL, '$2y$10$BZTLXCFNH3g9S5i9cFhTg.DQ.yc3YjFKLi/4QI3RhKh35Ke3ppUEC', NULL, '2024-05-15 06:29:56', '2024-06-10 09:48:28', '0'),
(3, 'admindfg', 'admdfgn@ahjez.com', NULL, '1', '798654654', 1, NULL, '$2y$10$Y4YKN1Qa5O.yMMxjEUUUwuq5EQGskyJxLxuy4MRYnOLT68MOR0QKu', NULL, '2024-05-15 06:29:56', '2024-05-15 08:07:14', '0'),
(4, 'dfgdfgdfg', 'addfgmdfgn@ahjez.com', NULL, '1', '798654654', 1, NULL, '$2y$10$Y4YKN1Qa5O.yMMxjEUUUwuq5EQGskyJxLxuy4MRYnOLT68MOR0QKu', NULL, '2024-05-15 06:29:56', '2024-05-15 08:07:17', '1'),
(5, 'Barber', 'barber@ahjez.com', NULL, '1', '798654654', 3, NULL, '$2y$10$wJe2ThFJnNwX.Z6GUddETeYp7g6hoVgK07NBBNmpUqRpdXGYHdqiW', NULL, '2024-05-15 06:29:56', '2024-05-20 03:45:07', '1'),
(6, 'Redspark Barber', 'Redsparkbarber@ahjez.com', NULL, '1', '798654654', 3, NULL, '$2y$10$Y4YKN1Qa5O.yMMxjEUUUwuq5EQGskyJxLxuy4MRYnOLT68MOR0QKu', NULL, '2024-05-15 06:29:56', '2024-05-15 08:07:17', '1'),
(7, 'Alex Barber', 'alex@ahjez.com', NULL, '1', '798654654', 3, NULL, '$2y$10$Y4YKN1Qa5O.yMMxjEUUUwuq5EQGskyJxLxuy4MRYnOLT68MOR0QKu', NULL, '2024-05-15 06:29:56', '2024-05-20 03:45:46', '1'),
(8, 'john special Barber', 'john1@ahjez.com', NULL, '2', '798654654', 3, NULL, '$2y$10$Y4YKN1Qa5O.yMMxjEUUUwuq5EQGskyJxLxuy4MRYnOLT68MOR0QKu', NULL, '2024-05-15 06:29:56', '2024-05-20 03:54:55', '1'),
(9, 'Maxy Barber', 'barber4@ahjez.com', '1716355018_profile_image.png', '2', '798654654', 3, NULL, '$2y$10$GMkmw6tQ.M/s.WI8MBNaSOmIdqoq9atX.MDlauY4c.kV6enoTdmOS', NULL, '2024-05-15 06:29:56', '2024-05-22 09:17:08', '1'),
(10, 'Alex Barber', 'alex4@ahjez.com', NULL, '2', '798654654', 3, NULL, '$2y$10$Y4YKN1Qa5O.yMMxjEUUUwuq5EQGskyJxLxuy4MRYnOLT68MOR0QKu', NULL, '2024-05-15 06:29:56', '2024-05-15 08:07:14', '0'),
(11, 'Romen Barber', 'Romen@ahjez.com', NULL, '2', '798654654', 3, NULL, '$2y$10$Y4YKN1Qa5O.yMMxjEUUUwuq5EQGskyJxLxuy4MRYnOLT68MOR0QKu', NULL, '2024-05-15 06:29:56', '2024-05-15 08:07:14', '0'),
(12, 'Angel one Barber', 'angelone@ahjez.com', NULL, '2', '798654654', 3, NULL, '$2y$10$Y4YKN1Qa5O.yMMxjEUUUwuq5EQGskyJxLxuy4MRYnOLT68MOR0QKu', NULL, '2024-05-15 06:29:56', '2024-05-15 08:07:17', '0'),
(13, 'Stan Barber', 'stan@ahjez.com', NULL, '1', '798654654', 3, NULL, '$2y$10$Y4YKN1Qa5O.yMMxjEUUUwuq5EQGskyJxLxuy4MRYnOLT68MOR0QKu', NULL, '2024-05-15 06:29:56', '2024-05-20 03:56:31', '0'),
(14, 'Tesy Barber', 'tesy@ahjez.com', NULL, '1', '798654654', 3, NULL, '$2y$10$Y4YKN1Qa5O.yMMxjEUUUwuq5EQGskyJxLxuy4MRYnOLT68MOR0QKu', NULL, '2024-05-15 06:29:56', '2024-05-20 00:12:11', '1'),
(15, 'Angel Rock', 'barber@gmail.copm', '1716198243_profile_image.jpg', '2', '0808080808', 4, NULL, '$2y$10$LTpmmidfTsjOXnGQPFYmFuBRLiAS8Kh/P.qiU6QnbLCQ/pihXyQHi', NULL, '2024-05-20 00:03:28', '2024-05-22 09:16:31', '0'),
(16, 'Barber 1', 'barber123@gmail.copm', '1716187106_profile_image.png', '1', '0798898989', 3, NULL, '$2y$10$4gCohZhWBEMJrHxSEQMrDefxgWgePRlgsgPonltXk/XJhLPMtgOnm', NULL, '2024-05-20 00:04:47', '2024-05-20 01:08:47', '1'),
(17, 'Denial', 'Denail@gmail.com', '1716188042_profile_image.jpg', '1', '080808080', 4, NULL, '$2y$10$oNBzpgPwex1yi/3k6xz/lOOZVGdPSL9hv7ANwxp58dtfippWEbVju', NULL, '2024-05-20 01:22:28', '2024-05-20 01:24:07', '1'),
(18, 'ABD', 'abc@gmail.com', '1716188188_profile_image.jpg', '1', '7906444887', 4, NULL, '$2y$10$u/kIfMuoLyMgqFIi.TstIufDKELD3No75Z6/9x5ffPUliol4HiNDy', NULL, '2024-05-20 01:26:28', '2024-05-22 09:15:42', '0'),
(19, 'Bianca Glover', 'tosox@mailinator.com', '1716197137_profile_image.jpg', '1', '7872472629', 3, NULL, '$2y$10$bSJEgsurre7vKYIqW25laeW7FAcZLNdYVwkuX0hcxk1xP9ows8gsS', NULL, '2024-05-20 03:55:37', '2024-05-20 03:55:37', '0'),
(20, 'Leo Cardenas', 'leqibaz@mailinator.com', '1716197959_profile_image.jpg', '1', '777777777', 4, NULL, '$2y$10$8O9KyBM3aB8iQheXI1dekeVdowh.8QFE3ou0wHlJGBZD0WkCIpDVm', NULL, '2024-05-20 04:09:19', '2024-05-20 04:24:04', '1'),
(21, 'sdf', 'sdfg@gmail.com', '1716198768_profile_image.jpg', '1', '789456123', 4, NULL, '$2y$10$b7Dis7epKxkLJuvW6hHnJ.9QiLlQpULSMUk0CEaZoyFFY1kys9IQm', NULL, '2024-05-20 04:22:48', '2024-05-20 04:23:03', '1'),
(22, 'checking', 'dabhi@gmail.com', '1716354931_profile_image.png', '1', '123456789', 4, NULL, '$2y$10$nVEXScA9cbgLB5GmrNHe8.q987tJoL5vNMIDVT898tn.UaDkCFzKe', NULL, '2024-05-22 09:15:31', '2024-05-22 09:15:37', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
