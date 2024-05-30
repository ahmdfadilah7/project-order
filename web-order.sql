-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 30, 2024 at 11:31 PM
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
-- Database: `web-order`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `judul_aktivitas` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bobots`
--

CREATE TABLE `bobots` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bobot` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bobots`
--

INSERT INTO `bobots` (`id`, `bobot`, `created_at`, `updated_at`) VALUES
(1, 'Job Kecil', '2024-05-28 08:16:46', '2024-05-28 08:16:53'),
(2, 'Job Besar', '2024-05-28 08:16:59', '2024-05-28 08:16:59'),
(3, 'Job Web', '2024-05-28 08:17:05', '2024-05-28 08:17:05');

-- --------------------------------------------------------

--
-- Table structure for table `chat_groups`
--

CREATE TABLE `chat_groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `message` longtext NOT NULL,
  `group_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chat_groups`
--

INSERT INTO `chat_groups` (`id`, `message`, `group_id`, `user_id`, `created_at`, `updated_at`) VALUES
(111, 'Berhasil', 3, 1, '2024-05-28 06:21:39', '2024-05-28 06:21:39'),
(112, 'Tahap pengerjaan ka', 3, 5, '2024-05-28 06:51:21', '2024-05-28 06:51:21'),
(113, 'Oke ka', 3, 20, '2024-05-28 07:04:32', '2024-05-28 07:04:32');

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
-- Table structure for table `file_projects`
--

CREATE TABLE `file_projects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `file` longtext NOT NULL,
  `keterangan` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `pelanggan_id` bigint(20) UNSIGNED NOT NULL,
  `penjoki_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `pelanggan_id`, `penjoki_id`, `created_at`, `updated_at`) VALUES
(3, 'A0me226', 20, 5, '2024-05-28 06:10:47', '2024-05-28 06:10:47');

-- --------------------------------------------------------

--
-- Table structure for table `jenis`
--

CREATE TABLE `jenis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jenis`
--

INSERT INTO `jenis` (`id`, `judul`, `created_at`, `updated_at`) VALUES
(1, 'BAB 1', '2023-12-10 16:55:53', '2024-05-28 06:35:14'),
(2, 'BAB 2', '2023-12-10 16:55:58', '2024-05-28 06:35:20'),
(3, 'BAB 3', '2024-05-28 06:35:26', '2024-05-28 06:35:26'),
(4, 'BAB 4', '2024-05-28 06:35:31', '2024-05-28 06:35:31'),
(5, 'BAB 5', '2024-05-28 06:35:36', '2024-05-28 06:35:36'),
(6, 'Website', '2024-05-28 08:24:44', '2024-05-28 08:24:44');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_orders`
--

CREATE TABLE `jenis_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `jenis_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jenis_orders`
--

INSERT INTO `jenis_orders` (`id`, `order_id`, `jenis_id`, `created_at`, `updated_at`) VALUES
(4, 9, 3, '2024-05-29 11:31:55', '2024-05-29 11:31:55'),
(5, 9, 2, '2024-05-29 11:31:55', '2024-05-29 11:31:55'),
(6, 9, 1, '2024-05-29 11:31:55', '2024-05-29 11:31:55');

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
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_09_20_151325_create_settings_table', 1),
(6, '2023_09_20_151514_create_profiles_table', 1),
(7, '2023_09_22_185029_add_field_foto_to_profiles', 1),
(8, '2023_09_22_221236_create_projects_table', 1),
(9, '2023_09_23_171124_create_orders_table', 1),
(10, '2023_09_23_171643_create_jenis_table', 1),
(11, '2023_09_23_171826_add_field_jenis_id_to_orders', 1),
(12, '2023_12_12_024003_create_groups_table', 2),
(13, '2023_12_12_031014_create_chat_groups_table', 3),
(14, '2023_12_17_061558_create_file_projects_table', 4),
(15, '2023_12_22_162625_create_activities_table', 5),
(16, '2023_12_22_211647_rename_column_name_in_activities', 5),
(17, '2023_12_22_231526_add_field_status_to_activities', 5),
(18, '2023_12_23_040553_delete_column_project_id_in_activities', 6),
(19, '2023_12_23_040945_add_field_order_id_to_activities', 7),
(20, '2024_03_08_211926_create_payments_table', 8),
(21, '2024_03_08_234153_create_user_accesses_table', 9),
(22, '2024_05_28_114525_add_field_judul_to_orders', 10),
(23, '2024_05_28_151033_create_bobots_table', 11),
(24, '2024_05_28_151804_add_field_bobot_id_to_orders', 12),
(25, '2024_05_28_152232_add_field_keterangan_to_orders', 13),
(26, '2024_05_29_045904_create_jenis_orders_table', 14),
(27, '2024_05_29_182742_add_field_code_order_to_orders', 15),
(28, '2024_05_29_183400_add_field_email_to_settings', 16);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_order` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `pelanggan_id` bigint(20) UNSIGNED NOT NULL,
  `bobot_id` bigint(20) UNSIGNED NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` varchar(255) NOT NULL,
  `deadline` date NOT NULL,
  `total` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `kode_order`, `user_id`, `pelanggan_id`, `bobot_id`, `keterangan`, `judul`, `deskripsi`, `deadline`, `total`, `status`, `created_at`, `updated_at`) VALUES
(9, 'ORDSIP20240529VRQ', 7, 20, 3, NULL, 'Test', '<p>Berhasil</p>', '2024-06-02', 950000, 0, '2024-05-29 11:31:55', '2024-05-29 11:31:55');

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
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `file` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
-- Table structure for table `profiles`
--

CREATE TABLE `profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `no_telp` varchar(255) DEFAULT NULL,
  `tmpt_lahir` varchar(255) DEFAULT NULL,
  `tgl_lahir` varchar(255) DEFAULT NULL,
  `jns_kelamin` enum('l','p') DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `jurusan` varchar(255) DEFAULT NULL,
  `daerah` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`id`, `user_id`, `no_telp`, `tmpt_lahir`, `tgl_lahir`, `jns_kelamin`, `foto`, `jurusan`, `daerah`, `created_at`, `updated_at`) VALUES
(4, 5, '08989505373', 'Bogor', '2001-11-07', 'l', NULL, NULL, NULL, '2024-05-28 04:21:07', '2024-05-28 04:21:07'),
(5, 6, '082339496742', 'Bima', '1999-05-23', 'p', NULL, NULL, NULL, '2024-05-28 04:22:46', '2024-05-28 04:22:46'),
(6, 7, '082211323995', 'Bogor', '2000-03-30', 'l', NULL, NULL, NULL, '2024-05-28 04:23:28', '2024-05-28 04:23:28'),
(7, 8, '081225058088', 'Purworejo', '1992-10-15', 'p', NULL, NULL, NULL, '2024-05-28 04:24:41', '2024-05-28 04:24:41'),
(8, 9, '087820827116', 'Kota Bogor', '2000-05-12', 'l', NULL, NULL, NULL, '2024-05-28 04:25:33', '2024-05-28 04:25:33'),
(9, 10, '085695604710', 'Bogor', '2001-03-19', 'l', NULL, NULL, NULL, '2024-05-28 04:26:43', '2024-05-28 04:26:43'),
(10, 11, '085790853018', 'Magetan', '1997-11-10', 'l', NULL, NULL, NULL, '2024-05-28 04:27:33', '2024-05-28 04:27:33'),
(11, 12, '085875461051', 'Lamongan', '1998-10-13', 'p', NULL, NULL, NULL, '2024-05-28 04:28:31', '2024-05-28 04:28:31'),
(12, 13, '089656568562', 'Garut', '1999-07-02', 'p', NULL, NULL, NULL, '2024-05-28 04:29:35', '2024-05-28 04:29:35'),
(13, 14, '085896930895', 'Mada Jaya', '2001-05-03', 'p', NULL, NULL, NULL, '2024-05-28 04:30:35', '2024-05-28 04:30:35'),
(14, 15, '085607802492', 'Tulungagung', '1999-09-15', 'p', NULL, NULL, NULL, '2024-05-28 04:31:15', '2024-05-28 04:31:15'),
(15, 16, '081388036411', 'Ogan Komering Ulu', '1999-10-16', 'p', NULL, NULL, NULL, '2024-05-28 04:32:05', '2024-05-28 04:32:05'),
(16, 17, '081281078651', 'Jakarta', '0007-05-12', 'p', NULL, NULL, NULL, '2024-05-28 04:32:48', '2024-05-28 04:32:48'),
(17, 18, '089636908632', 'Mombang Boru', '1998-09-12', 'p', NULL, NULL, NULL, '2024-05-28 04:33:32', '2024-05-28 04:33:32'),
(18, 19, '085770713652', 'Bogor', '2000-06-02', 'l', NULL, NULL, NULL, '2024-05-28 04:34:21', '2024-05-28 04:34:21'),
(19, 20, '081237123612', NULL, NULL, NULL, NULL, 'Sistem Informasi', 'Jakarta', '2024-05-28 04:50:30', '2024-05-28 04:50:30'),
(20, 21, '0819318221', 'Bogor', NULL, NULL, NULL, NULL, NULL, '2024-05-28 08:35:12', '2024-05-28 08:48:34'),
(21, 22, '08912381283', NULL, NULL, NULL, NULL, NULL, NULL, '2024-05-28 19:36:14', '2024-05-28 19:36:14');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `deadline` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_website` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `no_telp` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `logo` varchar(255) NOT NULL,
  `favicon` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `nama_website`, `email`, `no_telp`, `alamat`, `logo`, `favicon`, `created_at`, `updated_at`) VALUES
(1, 'CV. Solution Intan Prima', 'solutionintanprima@gmail.com', '08983122616', '<p>Kebon Kopi<br>RT 01/02</p>', 'images/Logo-Web-Order1HMDn.png', 'images/Favicon-Web-Order4k9H2.png', '2023-12-07 12:07:32', '2024-05-29 11:38:27');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('admin','penjoki','pelanggan') NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'superadmin@example.com', 'admin', NULL, '$2y$10$Re7qnBIn4xNuw.TA38eklulJoOY94zfPxpxkI6cHhnwXrIAbM7aHG', NULL, '2023-12-07 12:09:42', '2024-05-29 11:25:01'),
(5, 'Ahmad Fadilah', 'ahmdfadilah7@gmail.com', 'penjoki', NULL, '$2y$10$Q4WjXkJrATwz/Zf9eMb/NOVlUOlta28EnBbPjhuLe64JF9yOC3.tW', NULL, '2024-05-28 04:21:07', '2024-05-28 04:21:07'),
(6, 'Ainun Islamiyah', 'ainunislamiyah99@gmail.com', 'penjoki', NULL, '$2y$10$w/GU2XBmvAHfwQQgiJzbieYF3rYYEn6DEmIXmnjP1LAUzj1zgh9Kq', NULL, '2024-05-28 04:22:46', '2024-05-28 04:22:46'),
(7, 'Alfan Fadilah', 'alfanfdlah.30@gmail.com', 'penjoki', NULL, '$2y$10$cCaw1h6nx/GNS74Eh8fGmezyzK7GYf/4SfnX7y5J7.LuskvmU0eRy', NULL, '2024-05-28 04:23:28', '2024-05-28 04:23:28'),
(8, 'Bernadete Sonia Surya Santika Devinawati', 'bernadetesonia92@gmail.com', 'penjoki', NULL, '$2y$10$lhY5NaEWBro0Uu7yhd2CBOKK99fC5B.NniIHBR9WBfQj/Omedh4ji', NULL, '2024-05-28 04:24:41', '2024-05-28 04:24:41'),
(9, 'Diva Randika', 'randikadiva2@gmail.com', 'penjoki', NULL, '$2y$10$Q/NeJK/8iz1lZszRPJ2WP.JTNaKOYCLSJbhRvzO5dBQxtxcMauYuC', NULL, '2024-05-28 04:25:33', '2024-05-28 04:25:33'),
(10, 'Fauzi Rachman', 'rkwhyprtm@gmail.com', 'penjoki', NULL, '$2y$10$c5SPzF.3DEdSrdJCtjNcSefJogj.eppvo1r0kdHyr0KNsboL0VJpy', NULL, '2024-05-28 04:26:43', '2024-05-28 04:26:43'),
(11, 'Guntur Wahyu Kurniawan', 'gunturwisanggeni10@gmail.com', 'penjoki', NULL, '$2y$10$S0TGp7qgRNE65hASAsR/eeisFqX18rOVLxk7NkfFkyuyCgj7eqna2', NULL, '2024-05-28 04:27:33', '2024-05-28 04:27:33'),
(12, 'Kurniawati Surya Ningrum', 'kurn498@gmail.com', 'penjoki', NULL, '$2y$10$96Q8CsVElXmMyelOZpNdMe0Q0pZv/JtQ2Q9J1cUPULOFDu1a7ZTXu', NULL, '2024-05-28 04:28:31', '2024-05-28 04:28:31'),
(13, 'Nia Abania', 'niabania02@gmail.com', 'penjoki', NULL, '$2y$10$nm51X5kEukgmKNw4TSkOO.p5lM/TQya3QtLRvW4iTeEPskd4Yq/Z6', NULL, '2024-05-28 04:29:35', '2024-05-28 04:29:35'),
(14, 'Nida Saidatun Hasanah', 'nidaaa497@gmail.com', 'penjoki', NULL, '$2y$10$.IRkhtQ/rPnIwJikPXO.fuJzOBStbwUC9lRNKlpzQSDYZRZdaPkpu', NULL, '2024-05-28 04:30:35', '2024-05-28 04:30:35'),
(15, 'Nilam Yuniari', 'nlmynr@gmail.com', 'penjoki', NULL, '$2y$10$oz7xmnjs4UaTTsv2iSMReOzYjOdy/D.7Mm20MkNFbT0wxQqem.fTO', NULL, '2024-05-28 04:31:15', '2024-05-28 04:31:15'),
(16, 'Reni Puspitasari', 'renipuspita9910@gmail.com', 'penjoki', NULL, '$2y$10$f1kYevAn60veEF7VUzSDkuRzZlE3rpusi0hR4x.MuiOfatiP04Mhq', NULL, '2024-05-28 04:32:05', '2024-05-28 04:32:05'),
(17, 'Vira', 'muvirah@gmail.com', 'penjoki', NULL, '$2y$10$mzhLse9lqDvmWHT0ezVwMObP/wb8ayMrHypNXV9vPBysCBRISS/PS', NULL, '2024-05-28 04:32:48', '2024-05-28 04:32:48'),
(18, 'Yusni', 'yusnikonayy@gmail.com', 'penjoki', NULL, '$2y$10$ggjUGVF24izj.ySL2g43ZurMxPlHcPbX1CEzm85ffIYOOFDz6H59O', NULL, '2024-05-28 04:33:32', '2024-05-28 04:33:32'),
(19, 'Muhammad Diwan Sundarta', 'mdiwansundarta461@gmail.com', 'penjoki', NULL, '$2y$10$s/3EaKzb10Q5ysrwpOGPeu4EpmK4GvmZ/z0N0tjjEBu4PlxKmiKvO', NULL, '2024-05-28 04:34:21', '2024-05-28 04:34:21'),
(20, 'Pelanggan 1', 'pelanggan1@example.com', 'pelanggan', NULL, '$2y$10$1FKHHPf9Mti6tcWqzjd4duqpA9eHqLW4qRxx0k.pMT61m06nujtXu', NULL, '2024-05-28 04:50:30', '2024-05-28 04:50:30'),
(21, 'Ima', 'ima@example.com', 'admin', NULL, '$2y$10$4YEfxl6DiA8XnsGOvmu0k.T.//NEjS8PSiuBe7N7/V9BNXxvowiqG', NULL, '2024-05-28 08:35:12', '2024-05-28 08:35:12'),
(22, 'Ricky', 'ricky@example.com', 'admin', NULL, '$2y$10$Sm2ZWQvrXutIc80aV4w3j.o8j5L3dnfQLpwQZq7hsLFT0Hasftyhu', NULL, '2024-05-28 19:36:13', '2024-05-28 19:36:13');

-- --------------------------------------------------------

--
-- Table structure for table `user_accesses`
--

CREATE TABLE `user_accesses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `access` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_accesses`
--

INSERT INTO `user_accesses` (`id`, `user_id`, `access`, `created_at`, `updated_at`) VALUES
(1, 1, 'Super Admin', '2024-03-08 16:53:45', '2024-03-08 16:53:45'),
(3, 21, 'Admin', '2024-05-28 08:35:12', '2024-05-29 11:25:52'),
(4, 22, 'Manajer', '2024-05-28 19:36:14', '2024-05-28 19:36:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activities_user_id_foreign` (`user_id`),
  ADD KEY `activities_order_id_foreign` (`order_id`);

--
-- Indexes for table `bobots`
--
ALTER TABLE `bobots`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chat_groups`
--
ALTER TABLE `chat_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chat_groups_group_id_foreign` (`group_id`),
  ADD KEY `chat_groups_user_id_foreign` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `file_projects`
--
ALTER TABLE `file_projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `file_projects_order_id_foreign` (`order_id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `groups_name_unique` (`name`),
  ADD KEY `groups_pelanggan_id_foreign` (`pelanggan_id`),
  ADD KEY `groups_penjoki_id_foreign` (`penjoki_id`);

--
-- Indexes for table `jenis`
--
ALTER TABLE `jenis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jenis_orders`
--
ALTER TABLE `jenis_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jenis_orders_order_id_foreign` (`order_id`),
  ADD KEY `jenis_orders_jenis_id_foreign` (`jenis_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_kode_order_unique` (`kode_order`),
  ADD KEY `orders_user_id_foreign` (`user_id`),
  ADD KEY `orders_pelanggan_id_foreign` (`pelanggan_id`),
  ADD KEY `orders_bobot_id_foreign` (`bobot_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_order_id_foreign` (`order_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profiles_user_id_foreign` (`user_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `projects_user_id_foreign` (`user_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_accesses`
--
ALTER TABLE `user_accesses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_accesses_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `bobots`
--
ALTER TABLE `bobots`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `chat_groups`
--
ALTER TABLE `chat_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `file_projects`
--
ALTER TABLE `file_projects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `jenis`
--
ALTER TABLE `jenis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `jenis_orders`
--
ALTER TABLE `jenis_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `user_accesses`
--
ALTER TABLE `user_accesses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activities`
--
ALTER TABLE `activities`
  ADD CONSTRAINT `activities_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `activities_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `chat_groups`
--
ALTER TABLE `chat_groups`
  ADD CONSTRAINT `chat_groups_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `chat_groups_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `file_projects`
--
ALTER TABLE `file_projects`
  ADD CONSTRAINT `file_projects_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `groups`
--
ALTER TABLE `groups`
  ADD CONSTRAINT `groups_pelanggan_id_foreign` FOREIGN KEY (`pelanggan_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `groups_penjoki_id_foreign` FOREIGN KEY (`penjoki_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `jenis_orders`
--
ALTER TABLE `jenis_orders`
  ADD CONSTRAINT `jenis_orders_jenis_id_foreign` FOREIGN KEY (`jenis_id`) REFERENCES `jenis` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `jenis_orders_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_bobot_id_foreign` FOREIGN KEY (`bobot_id`) REFERENCES `bobots` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_pelanggan_id_foreign` FOREIGN KEY (`pelanggan_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `profiles`
--
ALTER TABLE `profiles`
  ADD CONSTRAINT `profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_accesses`
--
ALTER TABLE `user_accesses`
  ADD CONSTRAINT `user_accesses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
