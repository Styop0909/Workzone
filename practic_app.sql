-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jun 21, 2025 at 01:27 PM
-- Server version: 5.7.39
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `practic_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `receiver_id` bigint(20) UNSIGNED NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_file` tinyint(1) NOT NULL DEFAULT '0',
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `receiver_id`, `message`, `created_at`, `updated_at`, `is_file`, `file_path`) VALUES
(10, 3, 1, 'http://127.0.0.1:8000/jobs/1/show', '2025-06-12 13:03:04', '2025-06-12 13:03:04', 0, NULL),
(11, 2, 1, 'http://127.0.0.1:8000/jobs/1/show', '2025-06-12 13:03:47', '2025-06-12 13:03:47', 0, NULL),
(13, 4, 1, 'Բարև ձեզ ես դիմում եմ 12312312-ի հայտարարության համար', '2025-06-17 12:08:48', '2025-06-17 12:08:48', 0, NULL),
(14, 1, 4, '123', '2025-06-17 12:09:06', '2025-06-17 12:09:06', 0, NULL),
(15, 4, 1, 'laves', '2025-06-17 12:09:19', '2025-06-17 12:09:19', 0, NULL),
(16, 1, 4, 'lav du?😀', '2025-06-17 12:09:34', '2025-06-17 12:09:34', 0, NULL),
(17, 1, 4, '📎 Sending file', '2025-06-17 12:09:47', '2025-06-17 12:09:47', 1, 'chat_files/1750176587_gk4cplcv63v61.webp');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_06_02_184156_create_messages_table', 1),
(5, '2025_06_05_115210_create_workplaces_table', 1),
(6, '2025_06_10_163514_add_is_file_to_messages_table', 2),
(7, '2025_06_15_233023_add_file_path_to_messages_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('GOeLvndp7tI76hg7fhANfw3Mf2AKxeJp4IpYEp5h', 1, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidzBFVmlaVlhpd1pGaDJnbFhXNzlCNzRVWjZrUmVSY3pZUWUzTTdXYSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jaGF0LzQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1750512414),
('Q23nRaVZOWkhJjKb3zkhW28HVBtkGoTtAFtYxCYh', 1, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSkRlM3dDQndyM0R1OXo5T2FCM2h3WU9SYU1ZT1B4WUc4bTE5Zlo5WSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZGRfbmV3X2pvYl9ibGFkZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1750351359),
('R2ZbR02jzUt3CqC0oahKXQtVywmF1KY2rBz9HWyk', 1, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoia1Q2VGM1T1ExaXY4Um1qM0hxSmxicTJsRUl4SEhqeVZtdDRObUVNWSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zZWFyY2hfam9iX2JsYWRlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1750187467);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_role` int(11) NOT NULL DEFAULT '0' COMMENT '0 - User, 1 - Admin',
  `user_type` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `user_role`, `user_type`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, '1', 0, 1, 'armen_khachatryan_02@mail.ru', NULL, '$2y$12$tNICe80.3ntrq5OCkdRFM.x0BeFJRx/Upli5yiR.1aehZcBvKlKjS', NULL, '2025-06-05 07:57:25', '2025-06-05 07:57:25'),
(2, '2', 0, 2, 'aaa@mail.ru', NULL, '$2y$12$X8IQw4IqUVLOCV3Fia2dGub.xifSo9zXl3.CbA9ygz9jv4NaiIYf.', NULL, '2025-06-05 08:04:34', '2025-06-05 08:04:34'),
(3, '3', 0, 2, 'armen_khachat2@mail.ru', NULL, '$2y$12$c05p1nGB/WeKMWyhedIIr.C5CXTU0309C8eldbzD8ELJ2Xsrulbbq', NULL, '2025-06-12 12:50:08', '2025-06-12 12:50:08'),
(4, 'suren_tovmastan_99@mail.ru', 0, 2, 'suren_tovmastan_99@mail.ru', NULL, '$2y$12$dLk2uNO3cKAFArHFyUOzI.nPMHLVo0MyNCRVmjs9/6In6E7aW.Iz2', NULL, '2025-06-17 12:08:21', '2025-06-17 12:08:21');

-- --------------------------------------------------------

--
-- Table structure for table `workplaces`
--

CREATE TABLE `workplaces` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `job_creator_id` bigint(20) UNSIGNED NOT NULL,
  `job_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `employee_level` int(11) NOT NULL,
  `work_experience` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `working_hours` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `work_format` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `workplaces`
--

INSERT INTO `workplaces` (`id`, `job_creator_id`, `job_title`, `employee_level`, `work_experience`, `working_hours`, `work_format`, `created_at`, `updated_at`) VALUES
(1, 1, '12312312', 2, '1', '1', 2, '2025-06-05 08:12:37', '2025-06-07 07:00:39'),
(2, 1, '12312312', 2, '123', '123', 3, '2025-06-05 08:13:22', '2025-06-05 08:13:22'),
(3, 1, '123123', 2, '123123', '12312', 1, '2025-06-05 08:28:14', '2025-06-05 08:28:14'),
(4, 1, '213123', 2, '12312', '132123132', 2, '2025-06-07 06:58:56', '2025-06-07 06:58:56'),
(5, 2, '12312312', 2, '12312312', '12312312', 2, NULL, NULL),
(6, 2, '12312312', 2, '12312312', '12312312', 2, NULL, NULL),
(7, 2, '12312312', 2, '12312312', '12312312', 2, NULL, NULL),
(8, 2, '12312312', 2, '12312312', '12312312', 2, NULL, NULL),
(9, 2, '12312312', 2, '12312312', '12312312', 2, NULL, NULL),
(10, 2, '12312312', 2, '12312312', '12312312', 2, NULL, NULL),
(11, 2, '12312312', 2, '12312312', '12312312', 2, NULL, NULL),
(12, 2, '12312312', 2, '12312312', '12312312', 2, NULL, NULL),
(13, 2, 'Job Title 13', 1, '1 year', '40h/week', 1, '2025-06-21 13:15:29', '2025-06-21 13:15:29'),
(14, 2, 'Job Title 14', 2, '2 years', 'Full-time', 2, '2025-06-21 13:15:29', '2025-06-21 13:15:29'),
(15, 2, 'Job Title 15', 3, '3 years', 'Part-time', 3, '2025-06-21 13:15:29', '2025-06-21 13:15:29'),
(16, 2, 'Job Title 16', 2, '5 months', 'Flexible', 2, '2025-06-21 13:15:29', '2025-06-21 13:15:29'),
(17, 2, 'Job Title 17', 1, '1.5 years', '30h/week', 1, '2025-06-21 13:15:29', '2025-06-21 13:15:29'),
(18, 2, 'Job Title 18', 2, '6 months', 'Remote', 3, '2025-06-21 13:15:29', '2025-06-21 13:15:29'),
(19, 3, 'Job Title 19', 3, '4 years', 'Full-time', 2, '2025-06-21 13:15:29', '2025-06-21 13:15:29'),
(20, 3, 'Job Title 20', 2, '8 months', 'Part-time', 1, '2025-06-21 13:15:29', '2025-06-21 13:15:29'),
(21, 3, 'Job Title 21', 2, '2 years', 'Flexible', 2, '2025-06-21 13:15:29', '2025-06-21 13:15:29'),
(22, 3, 'Job Title 22', 1, '1 year', 'Remote', 3, '2025-06-21 13:15:29', '2025-06-21 13:15:29'),
(23, 3, 'Job Title 23', 3, '3 years', 'Full-time', 2, '2025-06-21 13:15:29', '2025-06-21 13:15:29'),
(24, 3, 'Job Title 24', 2, '2 months', 'Internship', 1, '2025-06-21 13:15:29', '2025-06-21 13:15:29'),
(25, 3, 'Job Title 25', 2, '1.5 years', 'Remote', 2, '2025-06-21 13:15:29', '2025-06-21 13:15:29'),
(26, 3, 'Job Title 26', 1, '4 months', 'Flexible', 3, '2025-06-21 13:15:29', '2025-06-21 13:15:29'),
(27, 4, 'Job Title 27', 3, '6 years', 'Full-time', 2, '2025-06-21 13:15:29', '2025-06-21 13:15:29'),
(28, 4, 'Job Title 28', 2, '5 years', 'Part-time', 1, '2025-06-21 13:15:29', '2025-06-21 13:15:29'),
(29, 4, 'Job Title 29', 2, '7 months', 'Flexible', 3, '2025-06-21 13:15:29', '2025-06-21 13:15:29'),
(30, 4, 'Job Title 30', 1, '2 years', 'Remote', 2, '2025-06-21 13:15:29', '2025-06-21 13:15:29'),
(31, 4, 'Job Title 31', 3, '1 year', 'Internship', 1, '2025-06-21 13:15:29', '2025-06-21 13:15:29'),
(32, 4, 'Job Title 32', 2, '2.5 years', 'Remote', 2, '2025-06-21 13:15:29', '2025-06-21 13:15:29'),
(33, 4, 'Job Title 33', 1, '3 years', 'Full-time', 3, '2025-06-21 13:15:29', '2025-06-21 13:15:29'),
(34, 4, 'Job Title 34', 3, '1 year', 'Flexible', 1, '2025-06-21 13:15:29', '2025-06-21 13:15:29'),
(35, 4, 'Job Title 35', 2, '8 months', 'Part-time', 2, '2025-06-21 13:15:29', '2025-06-21 13:15:29'),
(36, 5, 'Job Title 36', 2, '1.5 years', 'Remote', 3, '2025-06-21 13:15:29', '2025-06-21 13:15:29'),
(37, 5, 'Job Title 37', 1, '3 months', 'Internship', 1, '2025-06-21 13:15:29', '2025-06-21 13:15:29'),
(38, 5, 'Job Title 38', 3, '4.5 years', 'Full-time', 2, '2025-06-21 13:15:29', '2025-06-21 13:15:29'),
(39, 5, 'Job Title 39', 2, '6 months', 'Remote', 1, '2025-06-21 13:15:29', '2025-06-21 13:15:29'),
(40, 5, 'Job Title 40', 2, '1 year', 'Flexible', 3, '2025-06-21 13:15:29', '2025-06-21 13:15:29'),
(41, 5, 'Job Title 41', 3, '2.5 years', 'Full-time', 2, '2025-06-21 13:15:29', '2025-06-21 13:15:29'),
(42, 5, 'Job Title 42', 1, '4 years', 'Remote', 1, '2025-06-21 13:15:29', '2025-06-21 13:15:29'),
(43, 5, 'Job Title 43', 2, '1 year', 'Flexible', 2, '2025-06-21 13:15:29', '2025-06-21 13:15:29'),
(44, 5, 'Job Title 44', 2, '3 months', 'Internship', 3, '2025-06-21 13:15:29', '2025-06-21 13:15:29'),
(45, 5, 'Job Title 45', 3, '1.5 years', 'Remote', 1, '2025-06-21 13:15:29', '2025-06-21 13:15:29'),
(46, 5, 'Job Title 46', 1, '2 years', 'Part-time', 2, '2025-06-21 13:15:29', '2025-06-21 13:15:29'),
(47, 6, 'Job Title 47', 2, '6 months', 'Remote', 3, '2025-06-21 13:15:29', '2025-06-21 13:15:29'),
(48, 6, 'Job Title 48', 3, '4 years', 'Full-time', 2, '2025-06-21 13:15:29', '2025-06-21 13:15:29'),
(49, 6, 'Job Title 49', 2, '2.5 years', 'Flexible', 1, '2025-06-21 13:15:29', '2025-06-21 13:15:29'),
(50, 6, 'Job Title 50', 1, '1 year', 'Remote', 3, '2025-06-21 13:15:29', '2025-06-21 13:15:29'),
(51, 6, 'Job Title 51', 2, '8 months', 'Part-time', 2, '2025-06-21 13:15:29', '2025-06-21 13:15:29'),
(52, 6, 'Job Title 52', 3, '3 years', 'Full-time', 1, '2025-06-21 13:15:29', '2025-06-21 13:15:29'),
(53, 6, 'Job Title 53', 1, '1 year', 'Full-time', 2, '2025-06-21 13:16:25', '2025-06-21 13:16:25'),
(54, 6, 'Job Title 54', 2, '2 years', 'Part-time', 3, '2025-06-21 13:16:25', '2025-06-21 13:16:25'),
(55, 6, 'Job Title 55', 3, '3 years', 'Flexible', 1, '2025-06-21 13:16:25', '2025-06-21 13:16:25'),
(56, 6, 'Job Title 56', 2, '4 years', 'Remote', 2, '2025-06-21 13:16:25', '2025-06-21 13:16:25'),
(57, 6, 'Job Title 57', 1, '5 years', 'Internship', 3, '2025-06-21 13:16:25', '2025-06-21 13:16:25'),
(58, 6, 'Job Title 58', 2, '6 years', 'Full-time', 2, '2025-06-21 13:16:25', '2025-06-21 13:16:25'),
(59, 6, 'Job Title 59', 3, '7 years', 'Remote', 1, '2025-06-21 13:16:25', '2025-06-21 13:16:25'),
(60, 6, 'Job Title 60', 2, '8 months', 'Part-time', 3, '2025-06-21 13:16:25', '2025-06-21 13:16:25'),
(61, 7, 'Job Title 61', 1, '1.5 years', 'Flexible', 2, '2025-06-21 13:16:25', '2025-06-21 13:16:25'),
(62, 7, 'Job Title 62', 2, '2.5 years', 'Remote', 1, '2025-06-21 13:16:25', '2025-06-21 13:16:25'),
(63, 7, 'Job Title 63', 3, '4 months', 'Internship', 2, '2025-06-21 13:16:25', '2025-06-21 13:16:25'),
(64, 7, 'Job Title 64', 1, '6 months', 'Part-time', 3, '2025-06-21 13:16:25', '2025-06-21 13:16:25'),
(65, 7, 'Job Title 65', 2, '1 year', 'Remote', 1, '2025-06-21 13:16:25', '2025-06-21 13:16:25'),
(66, 7, 'Job Title 66', 3, '3.5 years', 'Full-time', 2, '2025-06-21 13:16:25', '2025-06-21 13:16:25'),
(67, 7, 'Job Title 67', 2, '1 year', 'Flexible', 3, '2025-06-21 13:16:25', '2025-06-21 13:16:25'),
(68, 7, 'Job Title 68', 1, '2 years', 'Part-time', 1, '2025-06-21 13:16:25', '2025-06-21 13:16:25'),
(69, 7, 'Job Title 69', 2, '1.5 years', 'Remote', 2, '2025-06-21 13:16:25', '2025-06-21 13:16:25'),
(70, 7, 'Job Title 70', 3, '9 months', 'Full-time', 3, '2025-06-21 13:16:25', '2025-06-21 13:16:25'),
(71, 8, 'Job Title 71', 2, '2 years', 'Remote', 1, '2025-06-21 13:16:25', '2025-06-21 13:16:25'),
(72, 8, 'Job Title 72', 1, '1 year', 'Part-time', 2, '2025-06-21 13:16:25', '2025-06-21 13:16:25'),
(73, 8, 'Job Title 73', 2, '2.5 years', 'Flexible', 3, '2025-06-21 13:16:25', '2025-06-21 13:16:25'),
(74, 8, 'Job Title 74', 3, '4 years', 'Internship', 1, '2025-06-21 13:16:25', '2025-06-21 13:16:25'),
(75, 8, 'Job Title 75', 1, '3 years', 'Remote', 2, '2025-06-21 13:16:25', '2025-06-21 13:16:25'),
(76, 8, 'Job Title 76', 2, '5 years', 'Full-time', 3, '2025-06-21 13:16:25', '2025-06-21 13:16:25'),
(77, 8, 'Job Title 77', 3, '6 months', 'Part-time', 1, '2025-06-21 13:16:25', '2025-06-21 13:16:25'),
(78, 8, 'Job Title 78', 2, '1.5 years', 'Flexible', 2, '2025-06-21 13:16:25', '2025-06-21 13:16:25'),
(79, 8, 'Job Title 79', 1, '2 months', 'Remote', 3, '2025-06-21 13:16:25', '2025-06-21 13:16:25'),
(80, 9, 'Job Title 80', 2, '1 year', 'Internship', 1, '2025-06-21 13:16:25', '2025-06-21 13:16:25'),
(81, 9, 'Job Title 81', 3, '3.5 years', 'Part-time', 2, '2025-06-21 13:16:25', '2025-06-21 13:16:25'),
(82, 9, 'Job Title 82', 2, '1.5 years', 'Flexible', 3, '2025-06-21 13:16:25', '2025-06-21 13:16:25'),
(83, 9, 'Job Title 83', 1, '5 months', 'Remote', 1, '2025-06-21 13:16:25', '2025-06-21 13:16:25'),
(84, 9, 'Job Title 84', 3, '4 years', 'Full-time', 2, '2025-06-21 13:16:25', '2025-06-21 13:16:25'),
(85, 9, 'Job Title 85', 2, '2 years', 'Part-time', 3, '2025-06-21 13:16:25', '2025-06-21 13:16:25'),
(86, 9, 'Job Title 86', 1, '1 year', 'Remote', 1, '2025-06-21 13:16:25', '2025-06-21 13:16:25'),
(87, 9, 'Job Title 87', 3, '6 months', 'Flexible', 2, '2025-06-21 13:16:25', '2025-06-21 13:16:25'),
(88, 9, 'Job Title 88', 2, '1.5 years', 'Internship', 3, '2025-06-21 13:16:25', '2025-06-21 13:16:25'),
(89, 9, 'Job Title 89', 1, '2 years', 'Remote', 1, '2025-06-21 13:16:25', '2025-06-21 13:16:25'),
(90, 9, 'Job Title 90', 2, '3 years', 'Part-time', 2, '2025-06-21 13:16:25', '2025-06-21 13:16:25'),
(91, 9, 'Job Title 91', 3, '4 years', 'Flexible', 3, '2025-06-21 13:16:25', '2025-06-21 13:16:25'),
(92, 9, 'Job Title 92', 2, '6 months', 'Remote', 1, '2025-06-21 13:16:25', '2025-06-21 13:16:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `workplaces`
--
ALTER TABLE `workplaces`
  ADD PRIMARY KEY (`id`),
  ADD KEY `workplaces_job_creator_id_foreign` (`job_creator_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `workplaces`
--
ALTER TABLE `workplaces`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `workplaces`
--
ALTER TABLE `workplaces`
  ADD CONSTRAINT `workplaces_job_creator_id_foreign` FOREIGN KEY (`job_creator_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
