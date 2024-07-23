-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 25, 2023 at 08:23 PM
-- Server version: 8.0.34-0ubuntu0.22.04.1
-- PHP Version: 8.1.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `social_media`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint UNSIGNED NOT NULL,
  `commentable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `commentable_id` bigint UNSIGNED NOT NULL,
  `text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `commentable_type`, `commentable_id`, `text`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\Post', 2, ' بسیار زیبا و دلنشین بود 😍', 2, '2023-09-13 07:46:23', '2023-09-13 07:46:23'),
(2, 'App\\Models\\Post', 2, 'لطفا میشه راهنمایی کنید؟ لطفا میشه راهنمایی کنید؟ لطفا میشه راهنمایی کنید؟ لطفا میشه راهنمایی کنید؟', 2, '2023-09-13 07:46:23', '2023-09-13 07:46:23'),
(3, 'App\\Models\\Post', 2, 'قشنگ بود :)', 1, '2023-09-20 09:01:50', '2023-09-20 09:01:50'),
(4, 'App\\Models\\Post', 2, 'خیلی خوب', 1, '2023-09-20 09:06:59', '2023-09-20 09:06:59'),
(5, 'App\\Models\\Post', 2, 'عالی بود', 1, '2023-09-20 09:07:41', '2023-09-20 09:07:41'),
(7, 'App\\Models\\Post', 3, 'اینجا کجاست؟', 1, '2023-09-20 09:10:01', '2023-09-20 09:10:01'),
(8, 'App\\Models\\Post', 3, 'زیبا', 1, '2023-09-20 09:12:42', '2023-09-20 09:12:42'),
(9, 'App\\Models\\Post', 2, 'دمت گرم🌹🌹❤❤', 1, '2023-09-20 09:18:03', '2023-09-20 09:18:03'),
(10, 'App\\Models\\Post', 2, 'بسیار عالی ، آموزش هم میدید؟🙏🌹', 1, '2023-09-20 09:22:14', '2023-09-20 09:22:14'),
(12, 'App\\Models\\Post', 3, 'ایروان 👌👌👌👌', 1, '2023-09-20 09:31:20', '2023-09-20 09:31:20'),
(13, 'App\\Models\\Post', 2, 'خیلی عالی❤', 1, '2023-09-20 09:33:20', '2023-09-20 09:33:20'),
(14, 'App\\Models\\Post', 2, 'سلام', 1, '2023-09-20 10:41:30', '2023-09-20 10:41:30'),
(15, 'App\\Models\\Post', 3, 'کامنت جدید', 1, '2023-09-20 11:06:28', '2023-09-20 11:06:28'),
(16, 'App\\Models\\Post', 2, 'متشکریم', 1, '2023-09-20 11:07:17', '2023-09-20 11:07:17'),
(17, 'App\\Models\\Post', 2, '💙💙❤❤', 1, '2023-09-20 11:12:27', '2023-09-20 11:12:27'),
(18, 'App\\Models\\Post', 2, 'سلام من حامد هستم', 1, '2023-09-20 12:32:04', '2023-09-20 12:32:04'),
(28, 'App\\Models\\Post', 3, 'سلام @sajad', 1, '2023-09-23 14:16:28', '2023-09-23 14:16:28'),
(29, 'App\\Models\\Post', 17, 'sssc', 1, '2023-09-25 09:33:05', '2023-09-25 09:33:05');

-- --------------------------------------------------------

--
-- Table structure for table `follows`
--

CREATE TABLE `follows` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `followed_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `follows`
--

INSERT INTO `follows` (`id`, `user_id`, `followed_id`, `created_at`, `updated_at`) VALUES
(1, 2, 1, '2023-09-25 13:24:45', '2023-09-25 13:24:47'),
(3, 1, 2, '2023-09-25 13:24:45', '2023-09-25 13:24:47');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` bigint UNSIGNED NOT NULL,
  `likeable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `likeable_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `likeable_type`, `likeable_id`, `user_id`, `created_at`, `updated_at`) VALUES
(23, 'App\\Models\\Post', 2, 1, '2023-09-20 12:27:09', '2023-09-20 12:27:09'),
(33, 'App\\Models\\Post', 3, 1, '2023-09-24 09:25:31', '2023-09-24 09:25:31'),
(34, 'App\\Models\\Post', 17, 1, '2023-09-25 09:33:00', '2023-09-25 09:33:00');

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(4, '2023_09_13_082055_create_posts_table', 1),
(5, '2023_09_13_091113_create_likes_table', 1),
(6, '2023_09_13_091733_create_saves_table', 1),
(8, '2023_09_13_092024_create_notifs_table', 1),
(9, '2023_09_13_094234_create_shares_table', 1),
(10, '2019_12_14_000001_create_personal_access_tokens_table', 2),
(11, '2023_09_13_091753_create_comments_table', 3),
(12, '2023_09_25_131452_create_follows_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `notifs`
--

CREATE TABLE `notifs` (
  `id` bigint UNSIGNED NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `owner_id` bigint UNSIGNED NOT NULL,
  `action` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `desc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `checked` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifs`
--

INSERT INTO `notifs` (`id`, `notifiable_type`, `notifiable_id`, `user_id`, `owner_id`, `action`, `desc`, `checked`, `created_at`, `updated_at`) VALUES
(10, 'App\\Models\\Post', 3, 1, 1, 'comment', '', 0, '2023-09-23 14:16:28', '2023-09-23 14:16:28'),
(11, 'App\\Models\\Post', 3, 1, 2, 'comment_mention', 'سلام @sajad', 0, '2023-09-23 14:16:28', '2023-09-23 14:16:28'),
(12, 'App\\Models\\Post', 3, 1, 1, 'like', '', 0, '2023-09-24 09:25:31', '2023-09-24 09:25:31'),
(13, 'App\\Models\\Post', 17, 1, 1, 'like', '', 0, '2023-09-25 09:33:00', '2023-09-25 09:33:00'),
(14, 'App\\Models\\Post', 17, 1, 1, 'comment', '', 0, '2023-09-25 09:33:05', '2023-09-25 09:33:05'),
(15, 'App\\Models\\Post', 21, 1, 2, 'post_mention', 'سلام خوبی؟ #مهرداد\r\n @sajad', 0, '2023-09-25 16:08:24', '2023-09-25 16:08:24');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '2023-09-13 06:16:10'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `desc` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `media` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `media_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `views` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `desc`, `media`, `media_type`, `created_at`, `updated_at`, `views`) VALUES
(2, 1, 'سه تار نوازی حامد ملکی #بداهه_نوازی #سه_تار @sajad', 'test.mp4', 'video', '2022-08-29 14:21:27', '2023-09-25 16:08:46', 202),
(3, 1, 'تصویر بیاد ماندنی از منطقه دلیجان ایروان در کشور ارمنستان #armenia ', 'hamed.jpg', 'photo', '2022-08-29 14:21:27', '2023-09-25 15:53:04', 229),
(21, 1, 'سلام خوبی؟ #مهرداد\r\n @sajad', '169567070495741066_Screenshot from 2023-09-06 17-01-21.png', 'photo', '2023-09-25 16:08:24', '2023-09-25 16:08:46', 1);

-- --------------------------------------------------------

--
-- Table structure for table `saves`
--

CREATE TABLE `saves` (
  `id` bigint UNSIGNED NOT NULL,
  `savable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `savable_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `saves`
--

INSERT INTO `saves` (`id`, `savable_type`, `savable_id`, `user_id`, `created_at`, `updated_at`) VALUES
(46, 'App\\Models\\Post', 3, 1, '2023-09-24 09:25:32', '2023-09-24 09:25:32'),
(47, 'App\\Models\\Post', 2, 1, '2023-09-25 11:58:34', '2023-09-25 11:58:34');

-- --------------------------------------------------------

--
-- Table structure for table `shares`
--

CREATE TABLE `shares` (
  `id` bigint UNSIGNED NOT NULL,
  `shareable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shareable_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `receiver_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shares`
--

INSERT INTO `shares` (`id`, `shareable_type`, `shareable_id`, `user_id`, `receiver_id`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\Post', 2, 2, 1, '2023-09-13 08:01:41', '2023-09-13 08:01:41');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'default-avatar.png',
  `account_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'public',
  `account_verified` tinyint(1) NOT NULL DEFAULT '0',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `role`, `mobile`, `email`, `profile`, `account_type`, `account_verified`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'حامد ملکی', 'hamex', 'admin', '09905758440', 'hamexmaleki@gmail.com', 'hamed.jpg', 'public', 1, '$2y$10$HqAP1/HPIvFeOlSPCPVWyuO4Uj7.aCRJJ8KjnQ4XcV3C2cXMq36ve', '7I1iNmZgPQQKj85cOzjCil8YPqpBS5B10BvUoSC2qCuCCkzDD4RavYCZZqOE', '2022-08-29 14:21:27', '2022-08-29 14:21:27'),
(2, 'سجاد ملکی', 'sajad', 'user', '09189011488', 'sajad@gmail.com', 'default-avatar.png', 'public', 1, '$2y$10$HqAP1/HPIvFeOlSPCPVWyuO4Uj7.aCRJJ8KjnQ4XcV3C2cXMq36ve', NULL, '2022-08-29 14:21:27', '2022-08-29 14:21:27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_commentable_type_commentable_id_index` (`commentable_type`,`commentable_id`),
  ADD KEY `comments_user_id_foreign` (`user_id`),
  ADD KEY `comments_id_index` (`id`);

--
-- Indexes for table `follows`
--
ALTER TABLE `follows`
  ADD PRIMARY KEY (`id`),
  ADD KEY `follows_user_id_foreign` (`user_id`),
  ADD KEY `follows_followed_id_foreign` (`followed_id`),
  ADD KEY `follows_id_index` (`id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `likes_likeable_type_likeable_id_index` (`likeable_type`,`likeable_id`),
  ADD KEY `likes_user_id_foreign` (`user_id`),
  ADD KEY `likes_id_index` (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifs`
--
ALTER TABLE `notifs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifs_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`),
  ADD KEY `notifs_user_id_foreign` (`user_id`),
  ADD KEY `notifs_owner_id_foreign` (`owner_id`),
  ADD KEY `notifs_id_index` (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `posts_user_id_foreign` (`user_id`),
  ADD KEY `posts_id_index` (`id`);

--
-- Indexes for table `saves`
--
ALTER TABLE `saves`
  ADD PRIMARY KEY (`id`),
  ADD KEY `saves_savable_type_savable_id_index` (`savable_type`,`savable_id`),
  ADD KEY `saves_user_id_foreign` (`user_id`),
  ADD KEY `saves_id_index` (`id`);

--
-- Indexes for table `shares`
--
ALTER TABLE `shares`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shares_shareable_type_shareable_id_index` (`shareable_type`,`shareable_id`),
  ADD KEY `shares_user_id_foreign` (`user_id`),
  ADD KEY `shares_receiver_id_foreign` (`receiver_id`),
  ADD KEY `shares_id_index` (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_mobile_unique` (`mobile`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_id_index` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `follows`
--
ALTER TABLE `follows`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `notifs`
--
ALTER TABLE `notifs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `saves`
--
ALTER TABLE `saves`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `shares`
--
ALTER TABLE `shares`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `follows`
--
ALTER TABLE `follows`
  ADD CONSTRAINT `follows_followed_id_foreign` FOREIGN KEY (`followed_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `follows_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notifs`
--
ALTER TABLE `notifs`
  ADD CONSTRAINT `notifs_owner_id_foreign` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notifs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `saves`
--
ALTER TABLE `saves`
  ADD CONSTRAINT `saves_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `shares`
--
ALTER TABLE `shares`
  ADD CONSTRAINT `shares_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `shares_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
