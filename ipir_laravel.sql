-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 23, 2024 at 12:30 PM
-- Server version: 10.3.39-MariaDB
-- PHP Version: 8.1.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ipir_laravel`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `commentable_type` varchar(255) NOT NULL,
  `commentable_id` bigint(20) UNSIGNED NOT NULL,
  `text` text NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
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
(29, 'App\\Models\\Post', 17, 'sssc', 1, '2023-09-25 09:33:05', '2023-09-25 09:33:05'),
(30, 'App\\Models\\Post', 2, '⚘️', 1, '2023-10-03 16:33:41', '2023-10-03 16:33:41'),
(31, 'App\\Models\\Post', 2, 'ت', 1, '2023-10-03 16:33:58', '2023-10-03 16:33:58'),
(32, 'App\\Models\\Post', 21, 'Gghh', 1, '2023-10-08 19:07:16', '2023-10-08 19:07:16'),
(33, 'App\\Models\\Post', 21, 'NC slm', 1, '2023-10-08 19:07:34', '2023-10-08 19:07:34'),
(34, 'App\\Models\\Post', 21, 'Gh', 1, '2023-10-08 19:07:43', '2023-10-08 19:07:43'),
(35, 'App\\Models\\Post', 24, 'تالد', 1, '2023-10-10 09:15:37', '2023-10-10 09:15:37'),
(36, 'App\\Models\\Post', 24, 'جخغلدد', 1, '2023-10-10 09:15:45', '2023-10-10 09:15:45'),
(37, 'App\\Models\\Post', 2, 'تت', 1, '2023-10-10 09:54:12', '2023-10-10 09:54:12'),
(38, 'App\\Models\\Post', 2, 'عاا', 1, '2023-10-10 09:54:16', '2023-10-10 09:54:16'),
(39, 'App\\Models\\Post', 2, 'عننم', 1, '2023-10-10 09:54:25', '2023-10-10 09:54:25'),
(40, 'App\\Models\\Post', 2, 'تنپن', 1, '2023-10-10 09:54:29', '2023-10-10 09:54:29'),
(41, 'App\\Models\\Post', 2, 'ننندن', 1, '2023-10-10 09:54:35', '2023-10-10 09:54:35'),
(42, 'App\\Models\\Post', 2, 'ajab zibas', 1, '2023-10-16 06:20:01', '2023-10-16 06:20:01'),
(43, 'App\\Models\\Post', 24, 'تست', 1, '2023-10-17 06:39:30', '2023-10-17 06:39:30'),
(44, 'App\\Models\\Post', 21, 'Hyhhh', 11, '2023-10-18 06:43:04', '2023-10-18 06:43:04'),
(45, 'App\\Models\\Post', 22, 'تست @sajad', 1, '2023-11-14 08:52:26', '2023-11-14 08:52:26'),
(46, 'App\\Models\\Post', 26, 'Awli', 1, '2024-02-21 08:02:11', '2024-02-21 08:02:11'),
(47, 'App\\Models\\Post', 28, 'عالی بود', 1, '2024-04-21 15:44:24', '2024-04-21 15:44:24');

-- --------------------------------------------------------

--
-- Table structure for table `follows`
--

CREATE TABLE `follows` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `followed_id` bigint(20) UNSIGNED NOT NULL,
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
  `id` bigint(20) UNSIGNED NOT NULL,
  `likeable_type` varchar(255) NOT NULL,
  `likeable_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `likeable_type`, `likeable_id`, `user_id`, `created_at`, `updated_at`) VALUES
(33, 'App\\Models\\Post', 3, 1, '2023-09-24 09:25:31', '2023-09-24 09:25:31'),
(34, 'App\\Models\\Post', 17, 1, '2023-09-25 09:33:00', '2023-09-25 09:33:00'),
(38, 'App\\Models\\Post', 23, 9, '2023-10-05 07:05:25', '2023-10-05 07:05:25'),
(39, 'App\\Models\\Post', 22, 9, '2023-10-05 07:05:42', '2023-10-05 07:05:42'),
(50, 'App\\Models\\Post', 23, 1, '2023-10-10 09:06:20', '2023-10-10 09:06:20'),
(56, 'App\\Models\\Post', 25, 1, '2023-10-17 06:38:54', '2023-10-17 06:38:54'),
(57, 'App\\Models\\Post', 21, 11, '2023-10-18 06:43:00', '2023-10-18 06:43:00'),
(58, 'App\\Models\\Post', 24, 1, '2023-11-14 08:35:42', '2023-11-14 08:35:42'),
(60, 'App\\Models\\Post', 21, 1, '2023-11-14 08:35:51', '2023-11-14 08:35:51'),
(62, 'App\\Models\\Post', 22, 1, '2024-02-01 05:12:46', '2024-02-01 05:12:46'),
(63, 'App\\Models\\Post', 26, 1, '2024-02-21 08:02:05', '2024-02-21 08:02:05'),
(66, 'App\\Models\\Post', 35, 1, '2024-04-16 06:10:25', '2024-04-16 06:10:25'),
(67, 'App\\Models\\Post', 37, 1, '2024-04-16 06:15:17', '2024-04-16 06:15:17'),
(68, 'App\\Models\\Post', 2, 1, '2024-04-21 06:57:36', '2024-04-21 06:57:36'),
(69, 'App\\Models\\Post', 39, 1, '2024-04-21 15:04:56', '2024-04-21 15:04:56'),
(70, 'App\\Models\\Post', 29, 1, '2024-04-21 15:43:59', '2024-04-21 15:43:59');

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
  `id` bigint(20) UNSIGNED NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `owner_id` bigint(20) UNSIGNED NOT NULL,
  `action` varchar(255) DEFAULT NULL,
  `desc` varchar(255) DEFAULT NULL,
  `checked` tinyint(1) NOT NULL DEFAULT 0,
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
(15, 'App\\Models\\Post', 21, 1, 2, 'post_mention', 'سلام خوبی؟ #مهرداد\r\n @sajad', 0, '2023-09-25 16:08:24', '2023-09-25 16:08:24'),
(16, 'App\\Models\\Post', 2, 1, 1, 'like', '', 0, '2023-10-02 07:07:33', '2023-10-02 07:07:33'),
(17, 'App\\Models\\Post', 22, 1, 1, 'like', '', 0, '2023-10-02 07:07:55', '2023-10-02 07:07:55'),
(18, 'App\\Models\\Post', 2, 1, 1, 'post_mention', '', 0, '2023-10-03 16:33:41', '2023-10-03 16:33:41'),
(19, 'App\\Models\\Post', 2, 1, 1, 'post_mention', '', 0, '2023-10-03 16:33:58', '2023-10-03 16:33:58'),
(20, 'App\\Models\\Post', 23, 9, 1, 'like', '', 0, '2023-10-05 07:05:25', '2023-10-05 07:05:25'),
(21, 'App\\Models\\Post', 22, 9, 1, 'like', '', 0, '2023-10-05 07:05:42', '2023-10-05 07:05:42'),
(22, 'App\\Models\\Post', 3, 10, 1, 'like', '', 0, '2023-10-05 14:03:22', '2023-10-05 14:03:22'),
(23, 'App\\Models\\Post', 22, 10, 1, 'like', '', 0, '2023-10-05 14:04:23', '2023-10-05 14:04:23'),
(24, 'App\\Models\\Post', 21, 1, 1, 'like', '', 0, '2023-10-08 19:07:03', '2023-10-08 19:07:03'),
(25, 'App\\Models\\Post', 21, 1, 1, 'post_mention', '', 0, '2023-10-08 19:07:16', '2023-10-08 19:07:16'),
(26, 'App\\Models\\Post', 21, 1, 1, 'post_mention', '', 0, '2023-10-08 19:07:34', '2023-10-08 19:07:34'),
(27, 'App\\Models\\Post', 21, 1, 1, 'post_mention', '', 0, '2023-10-08 19:07:43', '2023-10-08 19:07:43'),
(28, 'App\\Models\\Post', 24, 1, 1, 'like', '', 0, '2023-10-10 09:00:13', '2023-10-10 09:00:13'),
(29, 'App\\Models\\Post', 23, 1, 1, 'like', '', 0, '2023-10-10 09:02:57', '2023-10-10 09:02:57'),
(30, 'App\\Models\\Post', 24, 1, 1, 'post_mention', '', 0, '2023-10-10 09:15:37', '2023-10-10 09:15:37'),
(31, 'App\\Models\\Post', 24, 1, 1, 'post_mention', '', 0, '2023-10-10 09:15:45', '2023-10-10 09:15:45'),
(32, 'App\\Models\\Post', 2, 1, 1, 'post_mention', '', 0, '2023-10-10 09:54:12', '2023-10-10 09:54:12'),
(33, 'App\\Models\\Post', 2, 1, 1, 'post_mention', '', 0, '2023-10-10 09:54:16', '2023-10-10 09:54:16'),
(34, 'App\\Models\\Post', 2, 1, 1, 'post_mention', '', 0, '2023-10-10 09:54:25', '2023-10-10 09:54:25'),
(35, 'App\\Models\\Post', 2, 1, 1, 'post_mention', '', 0, '2023-10-10 09:54:29', '2023-10-10 09:54:29'),
(36, 'App\\Models\\Post', 2, 1, 1, 'post_mention', '', 0, '2023-10-10 09:54:35', '2023-10-10 09:54:35'),
(37, 'App\\Models\\Post', 2, 1, 1, 'post_mention', '', 0, '2023-10-16 06:20:01', '2023-10-16 06:20:01'),
(38, 'App\\Models\\Post', 25, 1, 1, 'like', '', 0, '2023-10-16 06:34:44', '2023-10-16 06:34:44'),
(39, 'App\\Models\\Post', 24, 1, 1, 'post_mention', '', 0, '2023-10-17 06:39:30', '2023-10-17 06:39:30'),
(40, 'App\\Models\\Post', 21, 11, 1, 'like', '', 0, '2023-10-18 06:43:00', '2023-10-18 06:43:00'),
(41, 'App\\Models\\Post', 21, 11, 1, 'post_mention', '', 0, '2023-10-18 06:43:04', '2023-10-18 06:43:04'),
(42, 'App\\Models\\Post', 21, 1, 2, 'post_mention', 'سلام خوبی؟ <span class=\"arta_hashtags\">#مهرداد\r\n</span><span class=\"arta_mentions\">@sajad</span>', 0, '2023-11-12 10:05:12', '2023-11-12 10:05:12'),
(43, 'App\\Models\\Post', 22, 1, 1, 'post_mention', '', 0, '2023-11-14 08:52:26', '2023-11-14 08:52:26'),
(44, 'App\\Models\\Post', 22, 1, 2, 'comment_mention', 'تست @sajad', 0, '2023-11-14 08:52:26', '2023-11-14 08:52:26'),
(45, 'App\\Models\\Post', 26, 1, 1, 'like', '', 0, '2024-02-01 05:12:42', '2024-02-01 05:12:42'),
(46, 'App\\Models\\Post', 26, 1, 1, 'post_mention', '', 0, '2024-02-21 08:02:11', '2024-02-21 08:02:11'),
(47, 'App\\Models\\Post', 29, 1, 1, 'like', '', 0, '2024-02-23 13:36:00', '2024-02-23 13:36:00'),
(48, 'App\\Models\\Post', 31, 1, 1, 'like', '', 0, '2024-02-25 01:13:09', '2024-02-25 01:13:09'),
(49, 'App\\Models\\Post', 35, 1, 1, 'like', '', 0, '2024-04-16 06:10:25', '2024-04-16 06:10:25'),
(50, 'App\\Models\\Post', 37, 1, 1, 'like', '', 0, '2024-04-16 06:15:17', '2024-04-16 06:15:17'),
(51, 'App\\Models\\Post', 39, 1, 1, 'like', '', 0, '2024-04-21 15:04:56', '2024-04-21 15:04:56'),
(52, 'App\\Models\\Post', 28, 1, 1, 'post_mention', '', 0, '2024-04-21 15:44:24', '2024-04-21 15:44:24');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL DEFAULT '0',
  `mobile` varchar(255) NOT NULL DEFAULT '0',
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '2023-09-13 06:16:10'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `mobile`, `token`, `created_at`) VALUES
('0', '09000000000', '78074', '2023-09-13 06:16:10'),
('0', '09120413700', '44201', '2023-09-13 06:16:10');

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
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `desc` varchar(255) NOT NULL,
  `media` varchar(255) NOT NULL,
  `media_type` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `views` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `desc`, `media`, `media_type`, `created_at`, `updated_at`, `views`) VALUES
(2, 1, 'سه تار نوازی حامد ملکی #بداهه_نوازی #سه_تار @sajad', 'test.mp4', 'video', '2022-08-29 14:21:27', '2024-06-29 16:54:09', 492),
(3, 1, 'تصویر بیاد ماندنی از منطقه دلیجان ایروان در کشور ارمنستان #armenia ', 'hamed.jpg', 'photo', '2022-08-29 14:21:27', '2024-07-06 04:30:47', 509),
(21, 1, 'سلام خوبی؟ <span class=\"arta_hashtags\">#مهرداد\r\n</span><span class=\"arta_mentions\">@sajad</span>', '169979611223632564_ponisha cover.png', 'photo', '2023-09-25 16:08:24', '2024-07-06 04:30:44', 316),
(22, 1, 'تست توضیحات\r\n#رودبار', '169622915779958452_IMG-20230911-WA0003.jpg', 'photo', '2023-10-02 03:15:57', '2024-07-06 04:30:44', 342),
(23, 1, 'این یک پست آزمایشی است\r\n      \r\n  #رودبار', '169636353245346649_IMG-20230820-WA0000.jpg', 'photo', '2023-10-03 16:35:32', '2024-07-06 04:30:42', 406),
(26, 1, 'تست', '170677692335873129_IMG-20240131-WA0000.jpg', 'photo', '2024-02-01 05:12:03', '2024-07-06 04:30:40', 119),
(27, 1, 'تست', '170677725624695646_20240201_120841.mp4', 'video', '2024-02-01 05:17:36', '2024-07-06 04:30:32', 137),
(28, 1, 'تعریف بیداری در یک دقیقه\r\nتا در طلب گوهر کانی کانی\r\nتا در هوس لقمهٔ نانی نانی\r\nاین نکتهٔ رمز اگر بدانی دانی\r\nهر چیزی که در جستن آنی آنی', '170870785188045932_IMG_20240223_203307_919.mp4', 'video', '2024-02-23 13:34:11', '2024-07-06 04:30:31', 159),
(29, 1, 'تعریف بیداری در یک دقیقه\r\n\r\n\r\n\r\nتا در طلب گوهر کانی کانی\r\nتا در هوس لقمهٔ نانی نانی\r\nاین نکتهٔ رمز اگر بدانی دانی\r\nهر چیزی که در جستن آنی ، آنی', '170870788748249302_IMG_20240223_203307_919.mp4', 'video', '2024-02-23 13:34:47', '2024-07-06 04:30:31', 178),
(30, 1, 'خداوندا :\r\nتو میدانی آنچه را که من نمیدانم\r\nدر دانستن تو آرامشیست و در ندانستن من تلاطمها\r\nتو خود با آرامشت تلاطم هایم را آرام ساز ...', '17087080725048023_IMG_20240223_203311_961.jpg', 'photo', '2024-02-23 13:37:52', '2024-07-06 04:30:29', 195),
(31, 1, 'وو', '170870839449794023_IMG_20240223_201947_301.jpg', 'photo', '2024-02-23 13:43:14', '2024-07-23 04:31:13', 223),
(38, 1, 'الا یا ایها الساقی ادر کأسا و ناولها\r\nبده باده که گردون فلک می گردد و اهلش\r\nساقیا در بزم خدا یار جز تو کس ندارم\r\nحضور صحبت یار از عیش و ناز افزون کند', '1713272082961_Rec 0006.mp4', 'video', '2024-04-16 09:25:23', '2024-07-23 04:31:08', 295),
(39, 1, 'لپ تاب لنوا\r\n        Lenovo', '1713273962519_IMG-20240415-WA0002.jpg', 'photo', '2024-04-16 09:56:13', '2024-07-23 04:31:08', 232);

-- --------------------------------------------------------

--
-- Table structure for table `saves`
--

CREATE TABLE `saves` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `savable_type` varchar(255) NOT NULL,
  `savable_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `saves`
--

INSERT INTO `saves` (`id`, `savable_type`, `savable_id`, `user_id`, `created_at`, `updated_at`) VALUES
(53, 'App\\Models\\Post', 22, 10, '2023-10-05 14:03:37', '2023-10-05 14:03:37'),
(55, 'App\\Models\\Post', 23, 1, '2023-10-10 09:04:45', '2023-10-10 09:04:45'),
(58, 'App\\Models\\Post', 2, 1, '2023-10-16 06:21:39', '2023-10-16 06:21:39'),
(64, 'App\\Models\\Post', 21, 1, '2023-11-06 09:46:17', '2023-11-06 09:46:17'),
(67, 'App\\Models\\Post', 3, 1, '2023-12-23 22:09:43', '2023-12-23 22:09:43'),
(68, 'App\\Models\\Post', 32, 1, '2024-04-02 01:46:44', '2024-04-02 01:46:44'),
(69, 'App\\Models\\Post', 29, 1, '2024-04-21 15:44:03', '2024-04-21 15:44:03');

-- --------------------------------------------------------

--
-- Table structure for table `shares`
--

CREATE TABLE `shares` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shareable_type` varchar(255) NOT NULL,
  `shareable_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `receiver_id` bigint(20) UNSIGNED DEFAULT NULL,
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
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `mobile` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `profile` varchar(255) DEFAULT 'default-avatar.png',
  `account_type` varchar(255) NOT NULL DEFAULT 'public',
  `account_verified` tinyint(1) NOT NULL DEFAULT 0,
  `password` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `role`, `mobile`, `email`, `profile`, `account_type`, `account_verified`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'دکتر یونیورس', 'dr_universe', 'admin', '09391079393', 'hamexmaleki@gmail.com', '170870770333654323_IMG_20240223_201947_301.jpg', 'public', 1, '$2y$10$HqAP1/HPIvFeOlSPCPVWyuO4Uj7.aCRJJ8KjnQ4XcV3C2cXMq36ve', '7I1iNmZgPQQKj85cOzjCil8YPqpBS5B10BvUoSC2qCuCCkzDD4RavYCZZqOE', '2022-08-29 14:21:27', '2024-02-23 13:31:43'),
(2, 'سجاد ملکی', 'sajad', 'user', '09189011488', 'sajad@gmail.com', 'default-avatar.png', 'public', 1, '$2y$10$HqAP1/HPIvFeOlSPCPVWyuO4Uj7.aCRJJ8KjnQ4XcV3C2cXMq36ve', NULL, '2022-08-29 14:21:27', '2022-08-29 14:21:27'),
(9, NULL, 'HGl', 'user', '09385483485', NULL, 'default-avatar.png', 'public', 1, NULL, 'mJezt5LQTcDmvzWI3JGeW36LI61oxd9xLw2otsGGcPL86A83Uu3CxmEMUaRN', '2023-10-05 07:04:59', '2023-10-05 07:04:59'),
(10, NULL, 'ifahmideh', 'user', '09120417300', NULL, 'default-avatar.png', 'public', 1, NULL, 'XJ5R5r8wvYc9IwMxdaFQPPduZ8pQkOLVzmZ9FZiTtLWiWInX0Cq91WCgOm3g', '2023-10-05 14:03:01', '2023-10-05 14:03:01'),
(11, NULL, 'daniel1999m', 'user', '09901398457', NULL, 'default-avatar.png', 'public', 1, NULL, 'Vnw2Fa0NJLBfzayR8CYVYcfrh3UcDBoEKFaMptOMDvUIdFYsUHeaxwJZ88BN', '2023-10-18 06:41:53', '2023-10-18 06:41:53');

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `follows`
--
ALTER TABLE `follows`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `notifs`
--
ALTER TABLE `notifs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `saves`
--
ALTER TABLE `saves`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `shares`
--
ALTER TABLE `shares`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
