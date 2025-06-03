-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 03, 2025 at 02:07 AM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_erapor`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
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
-- Table structure for table `guru`
--

DROP TABLE IF EXISTS `guru`;
CREATE TABLE IF NOT EXISTS `guru` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nip` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `guru_nip_unique` (`nip`),
  UNIQUE KEY `guru_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `guru`
--

INSERT INTO `guru` (`id`, `nama`, `nip`, `email`, `created_at`, `updated_at`, `user_id`) VALUES
(1, 'Andi Lubis, S.Si', '129990100011', 'andilubis@gmail.com', '2025-05-30 20:04:19', '2025-05-30 20:04:19', NULL),
(2, 'Iqbal Hanafi, S.Kom', '801212', 'iqbal@gmail.com', '2025-05-31 03:03:48', '2025-05-31 03:03:48', 5);

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_mengajar`
--

DROP TABLE IF EXISTS `jadwal_mengajar`;
CREATE TABLE IF NOT EXISTS `jadwal_mengajar` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `guru_id` bigint UNSIGNED NOT NULL,
  `mapel_id` bigint UNSIGNED NOT NULL,
  `kelas_id` bigint UNSIGNED NOT NULL,
  `tahun_akademik_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `jadwal_mengajar_guru_id_foreign` (`guru_id`),
  KEY `jadwal_mengajar_mapel_id_foreign` (`mapel_id`),
  KEY `jadwal_mengajar_kelas_id_foreign` (`kelas_id`),
  KEY `jadwal_mengajar_tahun_akademik_id_foreign` (`tahun_akademik_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jadwal_mengajar`
--

INSERT INTO `jadwal_mengajar` (`id`, `guru_id`, `mapel_id`, `kelas_id`, `tahun_akademik_id`, `created_at`, `updated_at`) VALUES
(5, 2, 3, 7, 1, '2025-06-02 18:59:46', '2025-06-02 18:59:46');

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

DROP TABLE IF EXISTS `kelas`;
CREATE TABLE IF NOT EXISTS `kelas` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_kelas` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id`, `nama_kelas`, `created_at`, `updated_at`) VALUES
(1, 'VII A', '2025-05-30 21:21:39', '2025-05-30 21:21:39'),
(7, 'VII B', '2025-06-02 02:53:34', '2025-06-02 02:53:52'),
(6, 'VII C', '2025-06-02 02:53:21', '2025-06-02 02:53:57'),
(8, 'VII D', '2025-06-02 02:53:43', '2025-06-02 02:53:43');

-- --------------------------------------------------------

--
-- Table structure for table `kelas_mapel_guru`
--

DROP TABLE IF EXISTS `kelas_mapel_guru`;
CREATE TABLE IF NOT EXISTS `kelas_mapel_guru` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `kelas_id` bigint UNSIGNED NOT NULL,
  `mapel_id` bigint UNSIGNED NOT NULL,
  `guru_id` bigint UNSIGNED NOT NULL,
  `tahun_akademik_id` bigint UNSIGNED NOT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `kelas_mapel_guru_kelas_id_foreign` (`kelas_id`),
  KEY `kelas_mapel_guru_mapel_id_foreign` (`mapel_id`),
  KEY `kelas_mapel_guru_guru_id_foreign` (`guru_id`),
  KEY `kelas_mapel_guru_tahun_akademik_id_foreign` (`tahun_akademik_id`),
  KEY `kelas_mapel_guru_created_by_foreign` (`created_by`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kelas_siswa`
--

DROP TABLE IF EXISTS `kelas_siswa`;
CREATE TABLE IF NOT EXISTS `kelas_siswa` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `siswa_id` bigint UNSIGNED NOT NULL,
  `kelas_id` bigint UNSIGNED NOT NULL,
  `tahun_akademik_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `kelas_siswa_siswa_id_foreign` (`siswa_id`),
  KEY `kelas_siswa_kelas_id_foreign` (`kelas_id`),
  KEY `kelas_siswa_tahun_akademik_id_foreign` (`tahun_akademik_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kelas_siswa`
--

INSERT INTO `kelas_siswa` (`id`, `siswa_id`, `kelas_id`, `tahun_akademik_id`, `created_at`, `updated_at`) VALUES
(2, 2, 1, 1, '2025-06-01 11:51:06', '2025-06-01 11:51:06'),
(3, 3, 1, 1, '2025-06-01 11:51:41', '2025-06-01 11:51:41');

-- --------------------------------------------------------

--
-- Table structure for table `mapel`
--

DROP TABLE IF EXISTS `mapel`;
CREATE TABLE IF NOT EXISTS `mapel` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `kode` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis` enum('Wajib','Muatan Lokal','Tambahan') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Wajib',
  `kkm` int NOT NULL DEFAULT '75',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mapel_kode_unique` (`kode`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mapel`
--

INSERT INTO `mapel` (`id`, `kode`, `nama`, `jenis`, `kkm`, `created_at`, `updated_at`) VALUES
(1, '0001', 'Bahasa Indonesia', 'Wajib', 75, '2025-05-30 20:02:38', '2025-05-30 20:03:20'),
(3, '0002', 'Informatika', 'Wajib', 70, '2025-06-02 02:54:55', '2025-06-02 02:55:04');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2025_05_25_165700_tahun_akademik', 1),
(6, '2025_05_25_171231_kelas', 1),
(7, '2025_05_25_171313_kelas_siswa', 1),
(8, '2025_05_25_171336_mapel', 1),
(9, '2025_05_25_171434_jadwal_mengajar', 1),
(10, '2025_05_25_171507_wali_kelas', 1),
(11, '2025_05_25_171541_nilai_siswa', 1),
(12, '2025_05_25_171625_guru', 1),
(13, '2025_05_25_171648_siswa', 1),
(14, '2025_05_26_064845_kelas-mapel-guru', 1);

-- --------------------------------------------------------

--
-- Table structure for table `nilai_siswa`
--

DROP TABLE IF EXISTS `nilai_siswa`;
CREATE TABLE IF NOT EXISTS `nilai_siswa` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `siswa_id` bigint UNSIGNED NOT NULL,
  `mapel_id` bigint UNSIGNED NOT NULL,
  `guru_id` bigint UNSIGNED NOT NULL,
  `kelas_id` bigint UNSIGNED NOT NULL,
  `tahun_akademik_id` bigint UNSIGNED NOT NULL,
  `nilai_pengetahuan` int DEFAULT NULL,
  `nilai_keterampilan` int DEFAULT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `nilai_siswa_siswa_id_foreign` (`siswa_id`),
  KEY `nilai_siswa_mapel_id_foreign` (`mapel_id`),
  KEY `nilai_siswa_guru_id_foreign` (`guru_id`),
  KEY `nilai_siswa_kelas_id_foreign` (`kelas_id`),
  KEY `nilai_siswa_tahun_akademik_id_foreign` (`tahun_akademik_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
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
-- Table structure for table `siswa`
--

DROP TABLE IF EXISTS `siswa`;
CREATE TABLE IF NOT EXISTS `siswa` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nis` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nisn` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_kelamin` enum('L','P') COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_hp` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `siswa_nis_unique` (`nis`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`id`, `nama`, `nis`, `nisn`, `email`, `jenis_kelamin`, `no_hp`, `created_at`, `updated_at`) VALUES
(1, 'Anak Andi', '1010', '1090019010', 'anakandi@gmail.com', 'L', '080121111212', NULL, NULL),
(2, 'Zakir', '1092', '000120002', 'zakir@gmail.com', 'L', '082280977712', '2025-06-01 11:51:06', '2025-06-01 11:51:06'),
(3, 'asa', '121', '0012', 'iqn12@gmail.com', 'L', '091220', '2025-06-01 11:51:41', '2025-06-01 11:51:41');

-- --------------------------------------------------------

--
-- Table structure for table `tahun_akademik`
--

DROP TABLE IF EXISTS `tahun_akademik`;
CREATE TABLE IF NOT EXISTS `tahun_akademik` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tahun` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `semester` enum('Ganjil','Genap') COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tahun_akademik`
--

INSERT INTO `tahun_akademik` (`id`, `tahun`, `semester`, `is_active`, `created_at`, `updated_at`) VALUES
(1, '2024/2025', 'Ganjil', 1, '2025-05-30 22:07:32', '2025-05-30 22:07:32');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'guru',
  `linked_id` bigint UNSIGNED DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `linked_id`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin Sekolah', 'admin@sekolah.test', NULL, '$2y$10$LQiPaclld9D/sxjOIVgeT.JI4VinlSA6JOXlZAlgRKwjNpUDdujXy', 'admin', NULL, NULL, '2025-05-30 19:54:31', '2025-05-30 19:54:31'),
(2, 'Guru Bahasa', 'guru@sekolah.test', NULL, '$2y$10$AT3eCltGg8heoQXiEQS2L.LmKTMVlK.gu73k/TD1F6lnWn2Ok77zG', 'guru', NULL, NULL, '2025-05-30 19:54:31', '2025-05-30 19:54:31'),
(3, 'Wali Kelas X IPA 1', 'walikelas@sekolah.test', NULL, '$2y$10$3wYXGbmh.rVIE2WdH0JCUuQDcgyl4VkWrET9P9P5WHeCQt4XSNRGS', 'walikelas', NULL, NULL, '2025-05-30 19:54:31', '2025-05-30 19:54:31'),
(5, 'Iqbal Hanafi, S.Kom', 'iqbal@gmail.com', NULL, '$2y$10$8.sDOt4siMDjTEq/Rw.JvOpaVUU6gzxycyTmIVsJvVffJHmkUKmOa', 'guru', NULL, NULL, '2025-05-31 03:03:48', '2025-05-31 03:03:48');

-- --------------------------------------------------------

--
-- Table structure for table `wali_kelas`
--

DROP TABLE IF EXISTS `wali_kelas`;
CREATE TABLE IF NOT EXISTS `wali_kelas` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `guru_id` bigint UNSIGNED NOT NULL,
  `kelas_id` bigint UNSIGNED NOT NULL,
  `tahun_akademik_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `wali_kelas_guru_id_foreign` (`guru_id`),
  KEY `wali_kelas_kelas_id_foreign` (`kelas_id`),
  KEY `wali_kelas_tahun_akademik_id_foreign` (`tahun_akademik_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wali_kelas`
--

INSERT INTO `wali_kelas` (`id`, `guru_id`, `kelas_id`, `tahun_akademik_id`, `created_at`, `updated_at`) VALUES
(2, 2, 1, 1, '2025-05-31 03:04:30', '2025-05-31 03:04:30');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
