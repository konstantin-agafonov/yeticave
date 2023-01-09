-- phpMyAdmin SQL Dump
-- version 4.7.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 17, 2019 at 11:08 AM
-- Server version: 5.7.16
-- PHP Version: 7.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `yeticave`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Доски и лыжи', '2017-05-13 19:25:33', '2017-05-13 19:25:33'),
(2, 'Крепления', '2017-05-13 19:25:33', '2017-05-13 19:25:33'),
(3, 'Ботинки', '2017-05-13 19:25:33', '2017-05-13 19:25:33'),
(4, 'Одежда', '2017-05-13 19:25:33', '2017-05-13 19:25:33'),
(5, 'Инструменты', '2017-05-13 19:25:33', '2017-05-13 19:25:33'),
(6, 'Разное', '2017-05-13 19:25:33', '2017-05-13 19:25:33');

-- --------------------------------------------------------

--
-- Table structure for table `lots`
--

CREATE TABLE `lots` (
  `id` int(10) UNSIGNED NOT NULL,
  `pic` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(2000) DEFAULT NULL,
  `start_price` decimal(10,2) NOT NULL,
  `end_date` timestamp NOT NULL,
  `stake_step` decimal(10,2) NOT NULL,
  `num_likes` int(10) UNSIGNED DEFAULT NULL,
  `author_id` int(10) UNSIGNED NOT NULL,
  `winner_id` int(10) UNSIGNED DEFAULT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lots`
--

INSERT INTO `lots` (`id`, `pic`, `name`, `description`, `start_price`, `end_date`, `stake_step`, `num_likes`, `author_id`, `winner_id`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 'lot-1.jpg', '2014 Rossignol District Snowboard', 'Description of 2014 Rossignol District Snowboard', '10999.00', '2017-05-24 19:38:27', '100.00', NULL, 1, NULL, 1, '2017-05-13 19:38:27', '2017-05-23 13:20:54'),
(2, 'lot-2.jpg', 'DC Ply Mens 2016/2017 Snowboard', 'Description of DC Ply Mens 2016/2017 Snowboard', '159999.00', '2017-05-23 19:38:27', '100.00', NULL, 1, NULL, 1, '2017-05-13 19:38:27', '2017-05-23 13:21:11'),
(3, 'lot-3.jpg', 'Крепления Union Contact Pro 2015 года размер L/XL', 'Description of Крепления Union Contact Pro 2015 года размер L/XL', '8000.00', '2017-05-22 19:38:27', '100.00', NULL, 2, NULL, 2, '2017-05-13 19:38:27', '2017-05-23 13:21:16'),
(4, 'lot-4.jpg', 'Ботинки для сноуборда DC Mutiny Charocal', 'Description of Ботинки для сноуборда DC Mutiny Charocal', '10999.00', '2017-05-21 19:38:27', '100.00', NULL, 2, NULL, 3, '2017-05-13 19:38:27', '2017-05-23 13:21:46'),
(5, 'lot-5.jpg', 'Куртка для сноуборда DC Mutiny Charocal', 'Description of Куртка для сноуборда DC Mutiny Charocal', '7500.00', '2017-05-20 19:38:27', '100.00', NULL, 3, NULL, 4, '2017-05-13 19:38:27', '2017-05-23 13:21:53'),
(6, 'lot-6.jpg', 'Маска Oakley Canopy', 'Description of Маска Oakley Canopy', '5400.00', '2017-05-25 19:38:27', '100.00', NULL, 3, NULL, 6, '2017-05-13 19:38:27', '2017-05-23 13:21:58'),
(7, 'woman.jpg', 'sadfasdf', 'asdfasdfasd', '2345234.00', '2017-11-11 09:28:58', '3452345.00', NULL, 3, NULL, 4, '2017-05-19 09:28:58', '2017-05-23 13:21:42'),
(8, 'advantage_6.jpg', 'Fake test lot', 'Fake test lot descripion', '12345.00', '2018-10-11 09:52:02', '432.00', NULL, 5, NULL, 3, '2017-05-23 09:52:02', '2017-05-30 14:22:50'),
(9, 'contact_office.jpg', 'Fake test lot', 'Fake test lot description', '54321.00', '2018-10-11 09:53:31', '234.00', NULL, 5, NULL, 1, '2017-05-23 09:53:31', '2017-05-30 14:22:55'),
(10, 'contact_office-2.jpg', 'наименование тестового лота', 'описание тестового лота', '7878678.00', '2018-10-11 12:27:40', '7867.00', NULL, 9, NULL, 1, '2017-05-24 12:27:40', '2017-05-30 14:22:57'),
(11, 'small-002.jpg', 'dfsd', '', '245.00', '2020-11-11 09:31:44', '234.00', NULL, 4, NULL, 1, '2017-05-26 09:31:44', '2017-05-30 14:23:00'),
(12, 'small-002.jpg', 'sdafasdfasdfasdfasdf', 'asdafsdfasdfasdfasdfasdfasdf', '0.19', '2017-11-10 21:40:58', '0.21', NULL, 4, NULL, 2, '2017-05-27 21:40:58', '2017-05-30 14:23:02'),
(13, 'buttons@2x.png', 'Очередной тестовый лот', 'ывфывафывафывафывафыва фва ыва ыва ыав', '0.12', '2017-11-10 22:04:17', '0.11', NULL, 4, NULL, 5, '2017-05-27 22:04:17', '2017-05-30 14:23:07'),
(14, '../uploads/001.jpg', 'Тестовый лот', 'Описание тестового лота', '123.00', '2017-10-10 13:47:01', '10.00', NULL, 4, NULL, 1, '2017-05-30 13:47:01', '2017-05-30 13:47:01');

-- --------------------------------------------------------

--
-- Table structure for table `stakes`
--

CREATE TABLE `stakes` (
  `id` int(10) UNSIGNED NOT NULL,
  `stake_sum` decimal(10,2) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `lot_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stakes`
--

INSERT INTO `stakes` (`id`, `stake_sum`, `user_id`, `lot_id`, `created_at`, `updated_at`) VALUES
(1, '12000.00', 1, 6, '2017-05-13 19:50:01', '2017-05-13 19:50:01'),
(2, '13000.00', 2, 6, '2017-05-13 19:50:01', '2017-05-13 19:50:01'),
(3, '14000.00', 1, 4, '2017-05-13 19:50:01', '2017-05-13 19:50:01'),
(4, '15000.00', 3, 4, '2017-05-13 19:50:01', '2017-05-13 19:50:01'),
(5, '33333.00', 4, 2, '2017-05-19 09:37:33', '2017-05-19 09:37:33'),
(6, '77777.00', 5, 6, '2017-05-23 09:08:23', '2017-05-23 09:08:23'),
(7, '88888.00', 5, 2, '2017-05-23 09:12:00', '2017-05-23 09:12:00'),
(8, '99999.00', 5, 8, '2017-05-23 09:52:52', '2017-05-23 09:52:52'),
(9, '99999.00', 9, 6, '2017-05-24 12:00:01', '2017-05-24 12:00:01'),
(10, '111111.00', 9, 10, '2017-05-24 12:28:23', '2017-05-24 12:28:23'),
(11, '11111.00', 4, 1, '2017-05-26 09:30:04', '2017-05-26 09:30:04'),
(12, '111.00', 4, 11, '2017-05-26 09:31:49', '2017-05-26 09:31:49'),
(13, '333333.00', 4, 8, '2017-05-27 11:12:46', '2017-05-27 11:12:46'),
(14, '22222.00', 10, 13, '2017-05-27 22:35:12', '2017-05-27 22:35:12'),
(15, '5555.00', 10, 2, '2017-05-27 22:35:32', '2017-05-27 22:35:32'),
(16, '100099.00', 4, 6, '2017-05-29 11:53:18', '2017-05-29 11:53:18'),
(17, '7000.00', 4, 5, '2017-05-29 12:04:28', '2017-05-29 12:04:28'),
(18, '0.41', 4, 12, '2017-05-29 12:20:04', '2017-05-29 12:20:04'),
(19, '118978.00', 4, 10, '2017-05-29 12:23:50', '2017-05-29 12:23:50'),
(20, '12345.00', 27, 11, '2017-05-30 14:11:44', '2017-05-30 14:11:44');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `contacts` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `avatar`, `email`, `password`, `contacts`, `created_at`, `updated_at`) VALUES
(1, 'Игнат', 'translation_letter.jpg', 'ignat.v@gmail.com', '$2y$10$OqvsKHQwr0Wk6FMZDoHo1uHoXd4UdxJG/5UDtUiie00XaxMHrW8ka', NULL, '2017-05-13 19:29:25', '2017-05-18 12:48:53'),
(2, 'Леночка', 'logo.png', 'kitty_93@li.ru', '$2y$10$bWtSjUhwgggtxrnJ7rxmIe63ABubHQs0AS0hgnOo41IEdMHkYoSVa', NULL, '2017-05-13 19:29:25', '2017-05-18 12:48:42'),
(3, 'Руслан', 'translation_letter.jpg', 'warrior07@mail.ru', '$2y$10$2OxpEH7narYpkOT1H5cApezuzh10tZEEQ2axgFOaKW.55LxIJBgWW', NULL, '2017-05-13 19:29:25', '2017-05-18 12:48:38'),
(4, '11111', 'lang_arm.jpg', 'konstantin.agafonov@gmail.com', '$2y$10$Qz0RbcUzqyHZ6zHUfqv7HenE6/xMpDUJbogWfLAJWS1z5tyW8FbkG', '11111', '2017-05-19 09:36:47', '2017-05-19 09:36:47'),
(5, 'Fake USer', 'advantage_1.jpg', 'fake@email.com', '$2y$10$RExIdQPLiSiJE3icwizgcOisT304j0JUg/ubL22T0NNN988LgYsjy', 'Fake USer contacts', '2017-05-22 22:26:08', '2017-05-22 22:26:08'),
(6, 'Fake user 2', 'woman.jpg', 'fakeemail2@mail.ru', '$2y$10$KzLmFm0KZpjUbTWZWnfuZ.hoJzgAA.j3CMaKJ4oHPkUq7HK1CSKo.', 'Kake user 2 description', '2017-05-24 10:45:37', '2017-05-24 10:45:37'),
(7, 'fake3@email.ru', 'leader.jpg', 'fake3@email.ru', '$2y$10$Vmp1oGBPwXtPSdXr14WQhOlrCa9gIDhNEueQrJZ30CXJK7EIC91wq', 'fake3@email.ru', '2017-05-24 10:47:37', '2017-05-24 10:47:37'),
(8, 'fake3@email.ru', 'video.jpg', 'fake4@email.ru', '$2y$10$sDiX4XFftqpYLetPr930au6CW.HYxh9VXngDb0yw5n11cNMaDG4kK', 'fake3@email.ru', '2017-05-24 10:49:53', '2017-05-24 10:49:53'),
(9, 'fake5@email.ru', 'advantage_2.jpg', 'fake5@email.ru', '$2y$10$4yo9kCcXXeRpakE3VoUQqudHULv6Dm9.EG02apLzEZNh0vDaWDRh6', 'fake5@email.ru', '2017-05-24 10:51:33', '2017-05-24 10:51:33'),
(10, 'fake66@gmail.com', 'buttons@2x.png', 'fake66@gmail.com', '$2y$10$ONkG..YSozlY8FhzYW7Yau6tua5gy4BLHpFvXjRxGslIW0Kk7/stG', 'fake66@gmail.com', '2017-05-27 22:26:06', '2017-05-27 22:26:06'),
(11, 'test@test.com', NULL, 'test@test.com', '$2y$10$flV7ShyVDxeuZ/2wH.RRcu0FIFIhjQNeGL9ilsqFCMr4v4.SiuLsi', 'test@test.com', '2017-05-29 08:52:26', '2017-05-29 08:52:26'),
(12, 'test2@test.com', NULL, 'test2@test.com', '$2y$10$6nGDVH/8N7nPIqf.bq9ia.ysMgE5EK0KgVRCzORpvGbcULpS3TeGq', 'test2@test.com', '2017-05-29 09:24:50', '2017-05-29 09:24:50'),
(13, 'test3@test.com', NULL, 'test3@test.com', '$2y$10$NPZA1q1pHhsg5vNDs.0lIemzqZ5eewzwb7hLmmfM99QYAzMR.TBVa', 'test3@test.com', '2017-05-29 09:26:21', '2017-05-29 09:26:21'),
(14, 'test4@test.com', NULL, 'test4@test.com', '$2y$10$2wdfU6rtOT3Qv.KyS2ySIuaTIJQ0a389C/CF9VkEgCEfKxa2SNl5W', 'test4@test.com', '2017-05-29 09:28:07', '2017-05-29 09:28:07'),
(15, 'test5@test.com', NULL, 'test5@test.com', '$2y$10$nlJICIuPSPbk4wP1XMZSjOhRiBFOvzUUB2mywH1bTVdJs0YankAWK', 'test5@test.com', '2017-05-29 09:29:21', '2017-05-29 09:29:21'),
(16, 'test6@test.com', NULL, 'test6@test.com', '$2y$10$wQLMagaCxsv.MJJ0GcDkJu/L5GQvP0A0Yg.XWlWE3uYUqIwOZCQk2', 'test6@test.com', '2017-05-29 09:30:20', '2017-05-29 09:30:20'),
(17, 'test7@test.com', NULL, 'test7@test.com', '$2y$10$pLkRSV8gIeHc4RAvkKA3deX1btf0KWdwatncrttVTuwXIeTnTX2aG', 'test7@test.com', '2017-05-29 09:31:03', '2017-05-29 09:31:03'),
(18, 'test8@test.com', NULL, 'test8@test.com', '$2y$10$uxodlSZ26p/UssicAd6NPe/LeqtXnZB6tJJT1OSbRlmC/CK5xBlFe', 'test8@test.com', '2017-05-29 09:31:45', '2017-05-29 09:31:45'),
(19, 'test9@test.com', NULL, 'test9@test.com', '$2y$10$5aYpi49kig4uIVnSOF3/pO9ycyxKRapywO4NnmvOF2jrr5Tiw3vqy', 'test9@test.com', '2017-05-29 09:35:48', '2017-05-29 09:35:48'),
(20, 'test10@test.com', NULL, 'test10@test.com', '$2y$10$Up.dICn.eQUPxxRk91NnSuNSsPbveZZO1ACNzA/GGO5whQf7y/P6K', 'test10@test.com', '2017-05-29 09:37:13', '2017-05-29 09:37:13'),
(21, 'test11@test.com', NULL, 'test11@test.com', '$2y$10$g1qxeM6B1JodTmX9D.K9eu65TKB5AEM13CsgOUsms4S9GEkpfZyt6', 'test11@test.com', '2017-05-29 09:38:08', '2017-05-29 09:38:08'),
(22, 'test12@test.com', NULL, 'test12@test.com', '$2y$10$mIQ6rVyNA9pTmQi5jeVaAencOe/ZvdxaQOli//hT4zLtZWX3vO4W2', 'test12@test.com', '2017-05-29 09:39:18', '2017-05-29 09:39:18'),
(23, 'test13@test.com', NULL, 'test13@test.com', '$2y$10$KhCyQSI3r74//YX3Jl4Sf.hGtx2g3/7jdjNF6FA29vh06ZFMju2GC', 'test13@test.com', '2017-05-29 09:40:47', '2017-05-29 09:40:47'),
(24, 'test14@test.com', NULL, 'test14@test.com', '$2y$10$xusqBFJxh0gYRtDT5znb7eT9EaUZyHnGDiTUdxrNNmG/LLpvgPlJq', 'test14@test.com', '2017-05-29 09:45:10', '2017-05-29 09:45:10'),
(25, 'test15@test.com', NULL, 'test15@test.com', '$2y$10$9QR89QnWRZ7aQX7NZUuyEOJFUhb.4cuWrnISHLgpwAoPJUU6P5X8O', 'test15@test.com', '2017-05-29 09:46:06', '2017-05-29 09:46:06'),
(26, 'test16@test.com', NULL, 'test16@test.com', '$2y$10$wDBRCQU/.1Cc2HEzx/NXxusfamyC/ase7cmpLrkD4NTwaUh7p1pKq', 'test16@test.com', '2017-05-29 09:47:46', '2017-05-29 09:47:46'),
(27, 'test17@test.com', NULL, 'test17@test.com', '$2y$10$QlyrxHmwsjbTnoG7WwpkOOFGRAEEIO.EZH2tF3Zjz1uJNy/LYeC02', 'test17@test.com', '2017-05-30 14:08:13', '2017-05-30 14:08:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `lots`
--
ALTER TABLE `lots`
  ADD PRIMARY KEY (`id`),
  ADD KEY `winner_id` (`winner_id`),
  ADD KEY `author_id` (`author_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `stakes`
--
ALTER TABLE `stakes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `lot_id` (`lot_id`);

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
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `lots`
--
ALTER TABLE `lots`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `stakes`
--
ALTER TABLE `stakes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `lots`
--
ALTER TABLE `lots`
  ADD CONSTRAINT `lots_categories` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lots_users` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stakes`
--
ALTER TABLE `stakes`
  ADD CONSTRAINT `stakes_lots` FOREIGN KEY (`lot_id`) REFERENCES `lots` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stakes_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
