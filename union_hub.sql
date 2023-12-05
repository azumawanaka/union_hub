-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2023 at 02:38 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `union_hub`
--

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `name`, `email`, `address`, `mobile`, `created_at`, `updated_at`) VALUES
(1, 'Prof. Petra Koepp III', 'herta.kunde@example.com', '44064 Toby Stream Suite 409\nDestineeville, NY 17422-6681', NULL, '2023-11-29 17:24:37', '2023-11-29 17:24:37'),
(2, 'Triston Schaefer I', 'beahan.alda@example.org', '151 Hudson Skyway Apt. 958\nSouth Carolyne, GA 67756', NULL, '2023-11-29 17:24:38', '2023-11-29 17:24:38'),
(3, 'Esteban Haag', 'hagenes.nikolas@example.net', '5566 Kirk Villages\nNorth Elwin, OK 11099-3239', NULL, '2023-11-29 17:24:38', '2023-11-29 17:24:38'),
(4, 'Freeda Harvey', 'shaniya.walsh@example.com', '56859 Viviane Manor Suite 243\nEast Maci, VA 54683-9860', NULL, '2023-11-29 17:24:38', '2023-11-29 17:24:38'),
(5, 'Mr. Arvid Cummings', 'leffler.destany@example.org', '937 Harvey Gateway\nEllenbury, GA 99776', NULL, '2023-11-29 17:24:38', '2023-11-29 17:24:38'),
(32, 'Mr. Rolando Walter II', 'clara90@example.net', '474 Maximillian Lock\nEast Paulaburgh, ID 40044-3635', NULL, '2023-12-02 08:11:31', '2023-12-02 08:11:31');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `max_participants` int(11) NOT NULL DEFAULT 0,
  `status` char(255) NOT NULL DEFAULT 'pending',
  `color` char(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `name`, `description`, `start_date`, `end_date`, `category`, `max_participants`, `status`, `color`, `created_at`, `updated_at`) VALUES
(6, 'Prof. Hildegard Dibbert II', 'Ut aut provident recusandae est excepturi et laborum. Magni et fuga hic accusantium et.', '2023-12-04 13:04:05', '2023-12-04 14:04:05', 'sporting', 0, 'empty', '#11b564', '2023-12-03 05:04:05', '2023-12-03 05:04:05'),
(7, 'Cheyenne Nikolaus', 'Sed et molestiae cum quo et quidem molestiae autem. Quidem laborum ut amet rerum ut voluptas reprehenderit. Perspiciatis quo ipsa et quod dignissimos omnis.', '2023-12-04 13:04:05', '2023-12-04 14:04:05', 'cultural', 0, 'finished', '#2e3a10', '2023-12-03 05:04:05', '2023-12-03 05:04:05'),
(8, 'Ms. Natasha Littel II', 'Labore explicabo eos id quis eos. Quas ut suscipit incidunt ea. Dolore vel exercitationem dolores totam modi eos rerum.', '2023-12-04 13:04:05', '2023-12-04 14:04:05', 'cultural', 0, 'empty', '#efeec0', '2023-12-03 05:04:05', '2023-12-03 05:04:05'),
(9, 'Alexandrea Labadie', 'Quia ipsam aut et nihil. Laboriosam aut ut qui voluptatem totam. Debitis corrupti qui consequuntur voluptatem architecto.', '2023-12-04 13:04:05', '2023-12-04 14:04:05', 'sporting', 0, 'finished', '#a27d64', '2023-12-03 05:04:06', '2023-12-03 05:04:06'),
(10, 'Ceasar Stanton', 'Nostrum ea harum est. Qui quod eos inventore perspiciatis exercitationem repellendus rem. Ea excepturi libero et et ad qui et quam.', '2023-12-04 13:04:05', '2023-12-04 14:04:05', 'sporting', 0, 'cancelled', '#199237', '2023-12-03 05:04:06', '2023-12-03 05:04:06');

-- --------------------------------------------------------

--
-- Table structure for table `event_participants`
--

CREATE TABLE `event_participants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `event_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
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

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2023_11_13_074551_create_service_types_table', 1),
(7, '2023_11_13_075132_create_clients_table', 1),
(8, '2023_11_13_075952_create_services_table', 1),
(10, '2023_11_13_081019_create_reports_table', 1),
(12, '2023_11_13_081919_create_event_participants_table', 1),
(14, '2023_11_13_080322_create_service_requests_table', 3),
(15, '2023_11_13_081600_create_events_table', 4),
(16, '2023_12_03_073904_add_column_status_updated_at_to_service_requests_table', 5),
(17, '2023_12_03_134434_add_column_max_participants_to_events_table', 6);

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
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `reported_at` datetime NOT NULL DEFAULT '2023-11-25 04:38:15',
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `category` text DEFAULT NULL,
  `attached_file` text DEFAULT NULL,
  `resolution_time` datetime NOT NULL DEFAULT '2023-11-25 04:38:15',
  `note_by_admin` text DEFAULT NULL,
  `status` char(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `service_type_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `added_by` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `preview_img` text DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `service_type_id`, `title`, `added_by`, `description`, `preview_img`, `client_id`, `created_at`, `updated_at`) VALUES
(11, 1, 'Service A', 2, 'test 123', NULL, 5, '2023-12-01 23:41:46', '2023-12-01 23:41:46');

-- --------------------------------------------------------

--
-- Table structure for table `service_requests`
--

CREATE TABLE `service_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `budget` double(8,2) NOT NULL DEFAULT 0.00,
  `preferred_date` date NOT NULL,
  `preferred_time` time NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `status` char(255) NOT NULL DEFAULT 'pending',
  `details` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status_updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_requests`
--

INSERT INTO `service_requests` (`id`, `service_id`, `budget`, `preferred_date`, `preferred_time`, `location`, `user_id`, `status`, `details`, `created_at`, `updated_at`, `status_updated_at`) VALUES
(17, 11, 2500.00, '2023-12-03', '16:11:31', 'Port Vivianville 2', 47, 'approved', 'lorem ipsum dolor sit amet', '2023-12-02 08:11:31', '2023-12-02 23:54:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `service_types`
--

CREATE TABLE `service_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_types`
--

INSERT INTO `service_types` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Beauty', '2023-11-28 17:31:29', '2023-11-28 17:31:29'),
(2, 'Spa and Wellness', '2023-11-28 17:31:29', '2023-11-28 17:31:29');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `gender` char(255) NOT NULL DEFAULT 'none',
  `role` tinyint(4) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `email_verified_at`, `password`, `address`, `mobile`, `gender`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'John', 'Travolta', 'user@example.com', '2023-11-24 20:47:14', '$2y$12$tofSP8QvKxHj0DO6a5jx6eGOIsqgXl90RnuhUt4IIN9cOVBP4NWCe', NULL, NULL, 'none', 0, 'MHmWP6dKdw', '2023-11-24 20:47:14', '2023-11-24 20:47:14'),
(2, 'Admin', 'Agokoy', 'admin@example.com', '2023-11-24 20:47:14', '$2y$12$iq4qPwq0fuyxUzleE4uHguxlWnE.3lzUru4w.yddH.8tKrhtLAuL6', NULL, NULL, 'none', 1, 'rwBYiBvBqpXYjSilQituxVbAaTQc07sboHdnEre3saOHEsum4rgCJdY3GERA', '2023-11-24 20:47:14', '2023-11-24 20:47:14'),
(46, 'Leopold Schowalter', 'Lesly Breitenberg Sr.', 'tillman.emmett@example.net', '2023-12-02 08:11:30', '$2y$12$pcKxpndKpphV7G8E3YStGOzIcEp7R9F5DOKIO/m2kENJM8FoLPri2', NULL, NULL, 'none', 0, 'UNkX4VesGZ', '2023-12-02 08:11:31', '2023-12-02 08:11:31'),
(47, 'Miss Pat Kemmer Sr.', 'Meredith Kassulke', 'larissa.mitchell@example.net', '2023-12-02 08:11:31', '$2y$12$pcKxpndKpphV7G8E3YStGOzIcEp7R9F5DOKIO/m2kENJM8FoLPri2', NULL, NULL, 'none', 0, 'fyyCdYokT4', '2023-12-02 08:11:31', '2023-12-02 08:11:31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_participants`
--
ALTER TABLE `event_participants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_participants_user_id_foreign` (`user_id`),
  ADD KEY `event_participants_event_id_foreign` (`event_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `services_client_id_foreign` (`client_id`);

--
-- Indexes for table `service_requests`
--
ALTER TABLE `service_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_requests_service_id_foreign` (`service_id`);

--
-- Indexes for table `service_types`
--
ALTER TABLE `service_types`
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
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `event_participants`
--
ALTER TABLE `event_participants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `service_requests`
--
ALTER TABLE `service_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `service_types`
--
ALTER TABLE `service_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `event_participants`
--
ALTER TABLE `event_participants`
  ADD CONSTRAINT `event_participants_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `event_participants_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `service_requests`
--
ALTER TABLE `service_requests`
  ADD CONSTRAINT `service_requests_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
