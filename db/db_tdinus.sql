-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 16, 2026 at 08:56 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_tdinus`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_settings`
--

CREATE TABLE `admin_settings` (
  `id` bigint UNSIGNED NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
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
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `member_settings`
--

CREATE TABLE `member_settings` (
  `id` bigint UNSIGNED NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_03_28_000001_add_role_to_users_table', 1),
(5, '2026_03_28_000002_create_services_table', 1),
(6, '2026_03_28_000003_create_news_table', 1),
(7, '2026_03_28_000004_create_admin_settings_table', 1),
(8, '2026_03_28_000005_create_member_settings_table', 1),
(9, '2026_03_28_000006_add_images_to_services_and_news', 1),
(10, '2026_03_28_000007_add_slug_to_news_table', 1),
(11, '2026_03_28_000008_backfill_news_slugs', 1),
(12, '2026_03_28_000009_create_sliders_table', 2),
(13, '2026_04_13_132503_add_phone_address_selected_services_to_users_table', 3),
(14, '2026_04_15_124941_create_pelatihans_table', 4),
(15, '2026_04_15_124943_create_sertifikats_table', 4),
(16, '2026_04_15_200000_update_sertifikats_status_enum', 5);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `excerpt` text COLLATE utf8mb4_unicode_ci,
  `body` longtext COLLATE utf8mb4_unicode_ci,
  `published_at` date DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title`, `slug`, `category`, `image_path`, `excerpt`, `body`, `published_at`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Kota bima', 'kota-bima', 'Kebersihan', '/uploads/c036bcca-524b-4fcc-aa02-d64755549b69.png', 'awaww', 'sadlas;dk', '2026-03-28', 1, '2026-03-28 03:09:42', '2026-03-28 03:09:42'),
(2, 'Dompu', 'dompu', 'pemilu', '/uploads/cb54758a-73b8-43d3-85d6-d23eac20e78e.jpg', 'asda', 'ini adalah berita', '2026-03-28', 1, '2026-03-28 03:20:17', '2026-03-28 03:20:17'),
(3, 'sada', 's', 'asdas', '/uploads/fe87ece6-dcc9-498c-9dc7-5b645d9c6b20.jpg', 'adsadas', 'asdasdasdas', '2026-03-21', 1, '2026-03-28 03:21:07', '2026-03-28 03:21:07'),
(4, 'slldds;', 'slldds', 'dlsa;dk', '/uploads/ba7a7fe7-b30b-47fd-bab0-da42ced08638.jpg', 'saldkas', 'dl;sadk', '2026-03-21', 1, '2026-03-28 03:21:46', '2026-03-28 03:21:46');

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
-- Table structure for table `pelatihans`
--

CREATE TABLE `pelatihans` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duration` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pelatihans`
--

INSERT INTO `pelatihans` (`id`, `title`, `slug`, `description`, `image_path`, `duration`, `price`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Pelatihan 1', 'sd', 'ksdjkdsj', '/uploads/0db6ab12-c267-42d5-927c-0b733b228c75.jpg', 'sakjlkj', 50000.00, 'active', '2026-04-15 05:09:54', '2026-04-15 05:09:54'),
(2, 'Pelatihan 2', 'dskl', 'l;dsk;lsk', '/uploads/6cc862b0-98b9-4e9b-8872-7b40afcf23e7.jpg', '4', 100000.00, 'active', '2026-04-15 06:37:42', '2026-04-15 06:37:42');

-- --------------------------------------------------------

--
-- Table structure for table `sertifikats`
--

CREATE TABLE `sertifikats` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `pelatihan_id` bigint UNSIGNED NOT NULL,
  `issue_date` date NOT NULL,
  `expiry_date` date DEFAULT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','in_progress','issued','expired','revoked') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sertifikats`
--

INSERT INTO `sertifikats` (`id`, `user_id`, `pelatihan_id`, `issue_date`, `expiry_date`, `file_path`, `status`, `created_at`, `updated_at`) VALUES
(2, 6, 1, '2026-04-15', NULL, '/uploads/sertifikat/2f0fb222-eba7-4c3c-a5ea-ac4e570e509a.pdf', 'issued', '2026-04-15 06:07:46', '2026-04-15 06:35:51'),
(3, 6, 2, '2026-04-15', NULL, NULL, 'issued', '2026-04-15 06:37:54', '2026-04-15 06:40:57');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`, `description`, `image_path`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'pelatihan penulisan ilmiah', 'ini aadalh pelatihan', '/uploads/6d3b47d3-1cdb-4a44-8228-3505a0b24c5b.png', 1, '2026-03-28 04:04:16', '2026-03-28 04:04:16'),
(2, 'aaaaa', 'aaaaa', '/uploads/e7f9de90-ac71-4192-acf5-d393179899e3.jpeg', 1, '2026-03-28 04:05:09', '2026-03-28 04:05:09'),
(3, 'akakkakakak', 'fwhfgwhjgqwfjkqwfj`', '/uploads/129588ac-4aca-4e88-a4e1-b4d4825402d5.jpeg', 1, '2026-03-28 04:06:04', '2026-03-28 04:06:04'),
(4, 'Pelatihan Skill AKademik', 'meningkatkan kualitas', '/uploads/24e43a96-3790-43e0-be47-47b9ac1bb92d.png', 1, '2026-04-15 04:31:15', '2026-04-15 04:31:15');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('KrimP8sgmwJCH6amTREXI2HOkQJqpv7XqOED04B1', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJqTHZsZmU2WkU0TWFJRnQyRU5BNWdhOHlWTHFYWEp2RUNHbzhONTVzIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19', 1776320453),
('lvI4WVlwHt8wU3He5A07cLVKosTEyPDHxSWavcLx', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJHVWdHWU5RdXUyNmx4UmRaRjBuOUlqUEozT1MzdW5CaFdVaTBhdEJWIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19', 1776307457);

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int UNSIGNED NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sliders`
--

INSERT INTO `sliders` (`id`, `title`, `description`, `image_path`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(2, 'TINGKATKAN PUBLIKASI ILMIAH ANDA DENGAN TDINUS', NULL, '/uploads/1f24db26-9a62-48f0-a985-900640e8a64b.jpeg', 1, 1, '2026-03-28 03:52:38', '2026-03-30 05:19:34'),
(3, 'wwewqeqe', 'ewqe', '/uploads/02ddbdf5-d9c5-43fb-8af4-bf0309d60a28.png', 2, 0, '2026-03-28 03:53:01', '2026-03-30 05:20:05'),
(4, 'ldskfkd', 'lkddjsfkl', '/uploads/199b9f51-33a4-4c56-8933-a2fb81eb3b3f.jpg', 3, 0, '2026-03-30 04:34:20', '2026-03-30 05:20:16');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `selected_services` json DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'member',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `address`, `selected_services`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin@admin.com', NULL, NULL, NULL, NULL, '$2y$12$eT5fQD.b20ELCg20.feyeeZXN6pSEmIb9ppS/RFiDRs6gZkuERNm6', 'admin', NULL, '2026-03-28 03:08:14', '2026-03-28 03:37:07'),
(3, 'Test Member', 'test@member.com', '08123456789', 'Jl Test No 123', '[1, 2]', NULL, '$2y$12$tAj3ZRXGI.j2baZlsjQmh.OxsrazbGv.ri1nmotsqPZQT6lyH9/p6', 'member', NULL, '2026-04-13 05:36:34', '2026-04-13 05:36:34'),
(4, 'ojan', 'ojan12809@gmail.com', '081339091828', 'Jl. Kh. Abubakar Husen', '[\"2\"]', NULL, '$2y$12$bKQfRY59Jmp5e48GBA3Ig.AGu5S5RIpmXdijH6VEQQ.K/jWxQr2Iq', 'member', NULL, '2026-04-13 05:44:26', '2026-04-13 05:44:26'),
(5, 'umi', 'ojan@gmail.com', '081339091828', 'Jl. Kh. Abubakar Husen', '[\"1\", \"2\"]', NULL, '$2y$12$/KFUOqCQAl5H0cTLuunK/.6eXLBw0BFLWpkBm84X7j5GTcS7MLf/W', 'member', NULL, '2026-04-13 06:53:09', '2026-04-13 06:53:09'),
(6, 'sutriawan', 'iwan@gmail.com', '081339091828', 'Jl. Kh. Abubakar Husen', '[\"1\", \"3\"]', NULL, '$2y$12$D2Fk5d6AbNMecW4Mx9lzq.uVPeHbo2s2IRgfFFEqIe7QyI3ehiSvK', 'member', NULL, '2026-04-15 04:25:38', '2026-04-15 04:25:38');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_settings`
--
ALTER TABLE `admin_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_settings_key_unique` (`key`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

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
-- Indexes for table `member_settings`
--
ALTER TABLE `member_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `member_settings_key_unique` (`key`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `news_slug_unique` (`slug`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pelatihans`
--
ALTER TABLE `pelatihans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pelatihans_slug_unique` (`slug`);

--
-- Indexes for table `sertifikats`
--
ALTER TABLE `sertifikats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sertifikats_user_id_foreign` (`user_id`),
  ADD KEY `sertifikats_pelatihan_id_foreign` (`pelatihan_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `admin_settings`
--
ALTER TABLE `admin_settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `member_settings`
--
ALTER TABLE `member_settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pelatihans`
--
ALTER TABLE `pelatihans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sertifikats`
--
ALTER TABLE `sertifikats`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `sertifikats`
--
ALTER TABLE `sertifikats`
  ADD CONSTRAINT `sertifikats_pelatihan_id_foreign` FOREIGN KEY (`pelatihan_id`) REFERENCES `pelatihans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sertifikats_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
