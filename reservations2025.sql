-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 04 sep. 2025 à 21:25
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `reservations2025`
--

-- --------------------------------------------------------

--
-- Structure de la table `artists`
--

CREATE TABLE `artists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `firstname` varchar(60) NOT NULL,
  `lastname` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `artists`
--

INSERT INTO `artists` (`id`, `firstname`, `lastname`) VALUES
(1, 'Daniel', 'Marcelin'),
(2, 'Philippe', 'Laurent'),
(3, 'Marius', 'Von Mayenburg'),
(4, 'Sophie', 'Marceau'),
(5, 'Jean', 'Dujardin'),
(6, 'Marion', 'Cotillard'),
(7, 'Gérard', 'Depardieu'),
(8, 'Catherine', 'Deneuve'),
(9, 'Vincent', 'Cassel'),
(10, 'Juliette', 'Binoche'),
(11, 'Omar', 'Sy'),
(12, 'Audrey', 'Tautou'),
(13, 'Louis', 'Garrel'),
(14, 'Léa', 'Seydoux'),
(15, 'Mathieu', 'Amalric'),
(16, 'Isabelle', 'Huppert'),
(17, 'Fabrice', 'Luchini'),
(18, 'Karin', 'Viard'),
(19, 'François', 'Cluzet'),
(20, 'Valérie', 'Lemercier');

-- --------------------------------------------------------

--
-- Structure de la table `artist_type`
--

CREATE TABLE `artist_type` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `artist_id` bigint(20) UNSIGNED NOT NULL,
  `type_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `artist_type`
--

INSERT INTO `artist_type` (`id`, `artist_id`, `type_id`) VALUES
(1, 1, 2),
(2, 2, 1),
(3, 2, 3),
(4, 3, 1),
(5, 3, 2),
(6, 4, 2),
(7, 4, 3),
(8, 5, 2),
(9, 6, 3),
(10, 7, 1),
(11, 8, 3),
(12, 9, 3),
(13, 10, 1),
(14, 11, 2),
(15, 12, 1),
(16, 12, 2),
(17, 13, 1),
(18, 13, 3),
(19, 14, 3),
(20, 15, 3),
(21, 16, 3),
(22, 17, 2),
(23, 17, 3),
(24, 18, 2),
(25, 19, 2),
(26, 20, 2);

-- --------------------------------------------------------

--
-- Structure de la table `artist_type_show`
--

CREATE TABLE `artist_type_show` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `artist_type_id` bigint(20) UNSIGNED NOT NULL,
  `show_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `artist_type_show`
--

INSERT INTO `artist_type_show` (`id`, `artist_type_id`, `show_id`) VALUES
(1, 13, 2),
(2, 20, 2),
(3, 23, 2),
(4, 26, 2),
(5, 3, 3),
(6, 10, 3),
(7, 11, 3),
(8, 15, 3),
(9, 25, 3),
(10, 9, 4),
(11, 22, 4),
(12, 1, 5),
(13, 14, 5),
(14, 19, 5),
(15, 20, 5),
(16, 21, 5),
(17, 9, 6),
(18, 12, 6),
(19, 22, 6),
(20, 23, 6),
(21, 8, 7),
(22, 9, 7),
(23, 16, 7),
(24, 21, 8),
(25, 26, 8),
(26, 9, 9),
(27, 20, 9),
(28, 2, 10),
(29, 4, 10),
(30, 15, 10),
(31, 19, 10);

-- --------------------------------------------------------

--
-- Structure de la table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
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
-- Structure de la table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `localities`
--

CREATE TABLE `localities` (
  `postal_code` varchar(6) NOT NULL,
  `locality` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `localities`
--

INSERT INTO `localities` (`postal_code`, `locality`) VALUES
('1000', 'Bruxelles'),
('1040', 'Etterbeek'),
('1050', 'Ixelles'),
('1170', 'Watermael-Boitsfort');

-- --------------------------------------------------------

--
-- Structure de la table `locations`
--

CREATE TABLE `locations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(60) NOT NULL,
  `designation` varchar(60) NOT NULL,
  `address` varchar(255) NOT NULL,
  `locality_postal_code` varchar(6) NOT NULL,
  `website` varchar(255) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `locations`
--

INSERT INTO `locations` (`id`, `slug`, `designation`, `address`, `locality_postal_code`, `website`, `phone`) VALUES
(1, 'the-art-center', 'The Art Center', '10 rue de la Vie', '1000', 'www.the-art-center.be', '+32 04568956'),
(2, 'nowhere-place', 'Nowhere Place', '125 avenue du Milieu', '1050', 'www.nowhere.be', '+32 01268989'),
(3, 'ground-zero', 'Ground Zero', '23 avenue du Ciel', '1000', '', '+32 05628956');

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_03_20_154226_create_artists_table', 1),
(5, '2025_04_03_143449_create_types_table', 1),
(6, '2025_04_24_125759_create_prices_table', 1),
(7, '2025_04_24_125805_create_roles_table', 1),
(8, '2025_04_24_125814_create_localities_table', 1),
(9, '2025_04_24_141956_create_reservations_table', 1),
(10, '2025_05_15_142148_create_locations_table', 1),
(11, '2025_05_22_125912_create_artist_type_table', 1),
(12, '2025_05_22_142407_create_shows_table', 1),
(13, '2025_05_22_143519_create_artist_type_show_table', 1),
(14, '2025_06_05_133805_add_description_shows_table', 1),
(15, '2025_06_12_144102_create_representations_table', 1),
(16, '2025_06_12_144325_create_price_show_table', 1),
(17, '2025_06_14_143212_create_reviews_table', 1),
(18, '2025_06_15_123251_create_representation_reservation_table', 1),
(19, '2025_06_17_171211_create_role_user_table', 1),
(20, '2025_06_18_173445_create_personal_access_tokens_table', 1),
(21, '2025_09_04_031158_add_total_amount_to_reservations_table', 2),
(22, '2025_09_04_032737_add_price_and_quantity_to_representation_reservation_table', 3);

-- --------------------------------------------------------

--
-- Structure de la table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `personal_access_tokens`
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
-- Structure de la table `prices`
--

CREATE TABLE `prices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(30) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` tinytext NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `prices`
--

INSERT INTO `prices` (`id`, `type`, `price`, `description`, `start_date`, `end_date`) VALUES
(1, 'normal', 15.90, 'Prix normal adulte.', '2024-01-01', '9999-12-31'),
(2, 'enfant', 7.90, 'Tarif enfant <12 ans.', '2020-01-01', '9999-12-31'),
(3, 'senior', 12.90, 'Tarif senior 65+ ans.', '2020-01-01', '9999-12-31'),
(4, 'etudiant', 10.90, 'Tarif étudiant avec carte.', '2020-01-01', '9999-12-31'),
(5, 'groupe', 11.90, 'Tarif groupe 10+ personnes.', '2020-01-01', '9999-12-31'),
(6, 'premium', 25.90, 'Place premium avec accès VIP.', '2020-01-01', '9999-12-31');

-- --------------------------------------------------------

--
-- Structure de la table `price_show`
--

CREATE TABLE `price_show` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `price_id` bigint(20) UNSIGNED NOT NULL,
  `show_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `price_show`
--

INSERT INTO `price_show` (`id`, `price_id`, `show_id`) VALUES
(1, 1, 2),
(2, 2, 2),
(3, 3, 2),
(4, 4, 2),
(5, 5, 2),
(6, 6, 2),
(7, 1, 3),
(8, 2, 3),
(9, 3, 3),
(10, 4, 3),
(11, 5, 3),
(12, 6, 3),
(13, 1, 4),
(14, 2, 4),
(15, 3, 4),
(16, 4, 4),
(17, 5, 4),
(18, 6, 4),
(19, 1, 5),
(20, 2, 5),
(21, 3, 5),
(22, 4, 5),
(23, 5, 5),
(24, 6, 5),
(25, 1, 6),
(26, 2, 6),
(27, 3, 6),
(28, 4, 6),
(29, 5, 6),
(30, 6, 6),
(31, 1, 7),
(32, 2, 7),
(33, 3, 7),
(34, 4, 7),
(35, 5, 7),
(36, 6, 7),
(37, 1, 8),
(38, 2, 8),
(39, 3, 8),
(40, 4, 8),
(41, 5, 8),
(42, 6, 8),
(43, 1, 9),
(44, 2, 9),
(45, 3, 9),
(46, 4, 9),
(47, 5, 9),
(48, 6, 9),
(49, 1, 10),
(50, 2, 10),
(51, 3, 10),
(52, 4, 10),
(53, 5, 10),
(54, 6, 10);

-- --------------------------------------------------------

--
-- Structure de la table `representations`
--

CREATE TABLE `representations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `show_id` bigint(20) UNSIGNED NOT NULL,
  `schedule` datetime NOT NULL,
  `location_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `representations`
--

INSERT INTO `representations` (`id`, `show_id`, `schedule`, `location_id`) VALUES
(25, 2, '2025-12-15 20:30:00', 1),
(26, 2, '2025-12-22 20:30:00', 1),
(27, 2, '2025-12-29 20:30:00', 1),
(28, 3, '2025-12-16 20:30:00', 2),
(29, 3, '2025-12-23 20:30:00', 2),
(30, 3, '2025-12-30 20:30:00', 2),
(31, 4, '2025-12-17 19:00:00', 3),
(32, 4, '2025-12-24 19:00:00', 3),
(33, 5, '2025-12-18 20:00:00', 1),
(34, 5, '2025-12-25 20:00:00', 1),
(35, 5, '2026-01-01 20:00:00', 1),
(36, 6, '2025-12-19 21:00:00', 2),
(37, 6, '2025-12-26 21:00:00', 2),
(38, 7, '2025-12-20 20:30:00', 3),
(39, 7, '2025-12-27 20:30:00', 3),
(40, 7, '2026-01-03 20:30:00', 3),
(41, 8, '2025-12-21 19:30:00', 1),
(42, 8, '2025-12-28 19:30:00', 1),
(43, 9, '2025-12-22 20:00:00', 2),
(44, 9, '2025-12-29 20:00:00', 2),
(45, 10, '2025-12-23 20:30:00', 3),
(46, 10, '2025-12-30 20:30:00', 3),
(47, 10, '2026-01-06 20:30:00', 3);

-- --------------------------------------------------------

--
-- Structure de la table `representation_reservation`
--

CREATE TABLE `representation_reservation` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `representation_id` bigint(20) UNSIGNED NOT NULL,
  `reservation_id` bigint(20) UNSIGNED NOT NULL,
  `price_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `seats` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `representation_reservation`
--

INSERT INTO `representation_reservation` (`id`, `representation_id`, `reservation_id`, `price_id`, `quantity`, `seats`, `created_at`, `updated_at`) VALUES
(2, 25, 3, 1, 4, 1, '2025-09-04 01:28:58', '2025-09-04 01:28:58'),
(3, 25, 3, 2, 3, 1, '2025-09-04 01:28:58', '2025-09-04 01:28:58'),
(4, 25, 3, 3, 2, 1, '2025-09-04 01:28:58', '2025-09-04 01:28:58'),
(5, 25, 3, 4, 2, 1, '2025-09-04 01:28:58', '2025-09-04 01:28:58'),
(6, 25, 3, 5, 4, 1, '2025-09-04 01:28:58', '2025-09-04 01:28:58'),
(7, 25, 3, 6, 1, 1, '2025-09-04 01:28:58', '2025-09-04 01:28:58'),
(8, 39, 4, 1, 5, 1, '2025-09-04 01:52:21', '2025-09-04 01:52:21'),
(9, 39, 4, 2, 2, 1, '2025-09-04 01:52:21', '2025-09-04 01:52:21'),
(10, 39, 4, 3, 3, 1, '2025-09-04 01:52:21', '2025-09-04 01:52:21'),
(11, 39, 4, 4, 3, 1, '2025-09-04 01:52:21', '2025-09-04 01:52:21'),
(12, 39, 4, 5, 5, 1, '2025-09-04 01:52:21', '2025-09-04 01:52:21'),
(13, 39, 4, 6, 7, 1, '2025-09-04 01:52:21', '2025-09-04 01:52:21'),
(14, 29, 5, 1, 5, 1, '2025-09-04 02:01:53', '2025-09-04 02:01:53'),
(15, 29, 5, 2, 2, 1, '2025-09-04 02:01:53', '2025-09-04 02:01:53'),
(16, 29, 5, 3, 2, 1, '2025-09-04 02:01:53', '2025-09-04 02:01:53'),
(17, 29, 5, 4, 6, 1, '2025-09-04 02:01:53', '2025-09-04 02:01:53'),
(18, 29, 5, 5, 1, 1, '2025-09-04 02:01:53', '2025-09-04 02:01:53'),
(19, 29, 5, 6, 1, 1, '2025-09-04 02:01:53', '2025-09-04 02:01:53'),
(20, 28, 6, 1, 1, 1, '2025-09-04 02:34:32', '2025-09-04 02:34:32'),
(21, 28, 6, 2, 3, 1, '2025-09-04 02:34:32', '2025-09-04 02:34:32'),
(22, 28, 6, 3, 1, 1, '2025-09-04 02:34:32', '2025-09-04 02:34:32'),
(23, 28, 6, 4, 1, 1, '2025-09-04 02:34:32', '2025-09-04 02:34:32'),
(24, 28, 6, 5, 4, 1, '2025-09-04 02:34:32', '2025-09-04 02:34:32'),
(25, 28, 6, 6, 1, 1, '2025-09-04 02:34:32', '2025-09-04 02:34:32'),
(26, 28, 7, 1, 1, 1, '2025-09-04 02:43:25', '2025-09-04 02:43:25'),
(27, 27, 8, 1, 1, 1, '2025-09-04 03:05:33', '2025-09-04 03:05:33'),
(28, 27, 8, 4, 1, 1, '2025-09-04 03:05:33', '2025-09-04 03:05:33'),
(29, 45, 9, 4, 1, 1, '2025-09-04 13:58:55', '2025-09-04 13:58:55');

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

CREATE TABLE `reservations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(60) NOT NULL,
  `booking_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `stripe_session_id` varchar(255) DEFAULT NULL,
  `stripe_payment_intent_id` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `reservations`
--

INSERT INTO `reservations` (`id`, `user_id`, `status`, `booking_date`, `total_amount`, `stripe_session_id`, `stripe_payment_intent_id`, `updated_at`) VALUES
(1, 14, 'cancelled', '2025-09-04 01:26:03', 234.30, NULL, NULL, '2025-09-04 01:37:57'),
(3, 14, 'paid', '2025-09-04 01:28:58', 208.40, 'cs_test_b17hCkfigWxdRT6mmGKz3okO16GFlqzzy7bDXl0MQIT5SZWLkRj737Qoc2', 'pi_3S3TrT024FRToMVB0E35vhoe', '2025-09-04 01:29:26'),
(4, 14, 'paid', '2025-09-04 01:52:21', 407.50, 'cs_test_b1j5VvdqDGjpFcQ5WQG6EAXfLV1mV3ELZS3d2LkE9m9FbrywK5S52rdgE7', 'pi_3S3UE7024FRToMVB1GfpqfLH', '2025-09-04 01:52:50'),
(5, 14, 'paid', '2025-09-04 02:01:53', 224.30, 'cs_test_b1RcGMhjUgiw7LOQBcT1uEZMnBqOceHd6SpszyXS2TFnbzQXu46uZeHJvC', 'pi_3S3UNG024FRToMVB15tHlXya', '2025-09-04 02:02:18'),
(6, 14, 'cancelled', '2025-09-04 02:34:32', 136.90, 'cs_test_b15wA9cCYOUXpNYx6mAKTCZvJLrq2Y7yMF2OMTQ7fJanEdoCdUJ3ViH8OE', NULL, '2025-09-04 03:06:36'),
(7, 14, 'cancelled', '2025-09-04 02:43:25', 15.90, 'cs_test_a1yXSxEIJSNXRvrn7Hcza6lyQRvXB7R7Hgq47j1UXzOMAhv8mJCsurbIJX', NULL, '2025-09-04 02:43:32'),
(8, 14, 'paid', '2025-09-04 03:05:33', 26.80, 'cs_test_b1O7JW07SWKDeof7iePa4UC9DD1yCqjrHyyCkXoIZeZWxACvLMx6gEPhmR', 'pi_3S3VMs024FRToMVB1CjemTNS', '2025-09-04 03:05:57'),
(9, 14, 'paid', '2025-09-04 13:58:55', 10.90, 'cs_test_a1ehqWEOoXJ8oi3xAqXMZVHYU7PubuhzWElJ5Zo8eJjW0Wg3z8JNdy1ZAB', 'pi_3S3fZa024FRToMVB1zEwfzRu', '2025-09-04 13:59:46');

-- --------------------------------------------------------

--
-- Structure de la table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `show_id` bigint(20) UNSIGNED NOT NULL,
  `review` text NOT NULL,
  `stars` tinyint(3) UNSIGNED NOT NULL,
  `validated` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `show_id`, `review`, `stars`, `validated`, `created_at`, `updated_at`) VALUES
(1, 14, 3, 'bonjour, j\'ai beaucoup aimé ce spectacle', 5, 0, '2025-09-04 02:44:24', '2025-09-04 13:54:08'),
(2, 14, 10, 'bonjouuuuuuurrrr', 5, 0, '2025-09-04 14:01:19', '2025-09-04 14:01:19');

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `roles`
--

INSERT INTO `roles` (`id`, `role`) VALUES
(1, 'admin'),
(3, 'affiliate'),
(2, 'member'),
(4, 'press');

-- --------------------------------------------------------

--
-- Structure de la table `role_user`
--

CREATE TABLE `role_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('MJLFNjdneCrh86YlYl4KUvt6Od2PWGsgfCYoQDrX', 14, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTo3OntzOjY6Il90b2tlbiI7czo0MDoiNHpYYk13dkJWRmQ2WHJvSTZ4U1Z6UlFCbjhJbUtmMmdXejRhcUI1dyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9teS1yZXNlcnZhdGlvbnMvOSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MzoidXJsIjthOjA6e31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxNDtzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2MDoiJDJ5JDEyJEcyOWo0RE5Wd25IVXRra2I0WGkyZmVEWnp2dy9pN1dmekhFbDJ4TUczZXM2dlJXdUhxZ3FhIjtzOjg6ImZpbGFtZW50IjthOjA6e319', 1757002283),
('y2P87V5TGdmrYGHacwdbMhYJxgoly8efDQZ4CVBB', 14, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoicmpKWWpXWktmUmJZM29zOHpiNGQ1YVBaRldFc3RyTXZ3UUFpb1hZWCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9yZXNlcnZhdGlvbnMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjM6InVybCI7YTowOnt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTQ7czoxNzoicGFzc3dvcmRfaGFzaF93ZWIiO3M6NjA6IiQyeSQxMiRHMjlqNEROVnduSFV0a2tiNFhpMmZlRFp6dncvaTdXZnpIRWwyeE1HM2VzNnZSV3VIcWdxYSI7fQ==', 1757013716);

-- --------------------------------------------------------

--
-- Structure de la table `shows`
--

CREATE TABLE `shows` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `poster_url` varchar(255) NOT NULL,
  `duration` smallint(6) NOT NULL,
  `created_in` year(4) NOT NULL,
  `location_id` bigint(20) UNSIGNED NOT NULL,
  `bookable` tinyint(1) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `shows`
--

INSERT INTO `shows` (`id`, `slug`, `title`, `poster_url`, `duration`, `created_in`, `location_id`, `bookable`, `description`) VALUES
(2, 'romeo-juliette', 'Roméo et Juliette', 'romeojuliet.jpg', 120, '2003', 1, 1, 'Deux ados, trois échanges, un mariage, cinq morts. Une pub tragique pour l’amour instantané, écrit avant l’invention du cerveau préfrontal.'),
(3, 'cyrano-bergerac', 'Cyrano de Bergerac', 'cyrano.jpg', 135, '2010', 2, 1, 'Un poète guerrier au nez intersidéral préfère écrire des lettres d’amour pour un autre plutôt que d’utiliser son propre charisme, parce que c’est plus noble de souffrir en alexandrins.'),
(4, 'moliere-avare', 'L\'Avare de Molière', 'lavare.jpg', 110, '2017', 3, 0, 'Il cache son argent, surveille ses enfants, soupçonne tout le monde et finit ruiné, mais sans jamais sortir son portefeuille.'),
(5, 'le-cirque-des-reves', 'Le Cirque des Rêves', 'no-poster.png', 95, '2022', 1, 1, 'Un spectacle magique où les acrobates volent entre les étoiles et les clowns racontent des histoires qui font pleurer de rire. Une ode à l\'enfance et à l\'imagination sans limites.'),
(6, 'symphonie-electrique', 'Symphonie Électrique', 'no-poster.png', 85, '2023', 2, 1, 'Un mélange explosif de musique classique et électronique. Les violons rencontrent les synthétiseurs dans une fusion audacieuse qui redéfinit les frontières musicales.'),
(7, 'les-memoires-dun-robot', 'Les Mémoires d\'un Robot', 'no-poster.png', 105, '2024', 3, 1, 'Dans un futur proche, un robot développe des émotions et questionne sa propre existence. Une réflexion poétique sur l\'humanité et la technologie.'),
(8, 'cafe-de-nuit', 'Café de Nuit', 'no-poster.png', 75, '2021', 1, 1, 'Dans un petit café parisien, les clients se croisent, se racontent leurs histoires et partagent leurs secrets. Un spectacle intimiste sur la solitude urbaine et les rencontres inattendues.'),
(9, 'le-jardin-des-delices', 'Le Jardin des Délices', 'no-poster.png', 120, '2020', 2, 0, 'Inspiré de l\'œuvre de Jérôme Bosch, ce spectacle visuel transporte le public dans un monde onirique peuplé de créatures fantastiques et de paysages surréalistes.'),
(10, 'chroniques-martiennes', 'Chroniques Martiennes', 'no-poster.png', 140, '2019', 3, 1, 'Une adaptation théâtrale du roman de Ray Bradbury. L\'histoire de la colonisation de Mars vue à travers les yeux des premiers colons terriens.');

-- --------------------------------------------------------

--
-- Structure de la table `types`
--

CREATE TABLE `types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `types`
--

INSERT INTO `types` (`id`, `type`) VALUES
(1, 'comédien'),
(2, 'scénographe'),
(3, 'auteur');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `firstname` varchar(60) NOT NULL,
  `lastname` varchar(60) NOT NULL,
  `langue` varchar(2) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `langue`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `is_admin`) VALUES
(1, 'Bob', 'Sull', 'en', 'bob@sull.com', NULL, '$2y$12$K1cCMGZ59vfvxTLmJnlufOKfeUCUvO1TFY0RNzSR2SBL71qsQFUhe', NULL, NULL, NULL, 1),
(2, 'Lydia', 'Smith', 'en', 'lydia@smith.com', NULL, '$2y$12$0r.Uy78N9xVVEFYzZBlNnOA0tH0z/.bGwPijI2wLlY3y6IfQJIkay', NULL, NULL, NULL, 0),
(3, 'Fred', 'Cury', 'fr', 'fred@cury.com', NULL, '$2y$12$giXRhOMAUZtdb3MZ.tRe0O8WVrOXgKg8c0JB2qua7Tsi2SJySMbJG', NULL, NULL, NULL, 0),
(4, 'Marie', 'Dubois', 'fr', 'marie@dubois.com', NULL, '$2y$12$VZDwOh75dGAAjo91RCrB0.GIluUaowAjEgqoha/G66Q6UMB3Ute2a', NULL, NULL, NULL, 0),
(5, 'Martin', 'Thomas', 'fr', 'martin@thomas.com', NULL, '$2y$12$gRVNwtHrJ6IFHkGk0oa14edOo4eIF1tuHczkbq8ikTi7JARu1NLNG', NULL, NULL, NULL, 0),
(6, 'Louise', 'Desmet', 'nl', 'Louise@Desmet.com', NULL, '$2y$12$YrJ6rQK6u6eAHgUtgRRKoOldkoprdt5wNh97Jhh8Ilsgn5bJln3e6', NULL, NULL, NULL, 0),
(7, 'Rafael', 'Martinez', 'es', 'rafael@martinez.com', NULL, '$2y$12$qln0J/zGcvnf3CDqFIKuzeODfQB0U9P.kci9FmifZd0/Oq22EunKy', NULL, NULL, NULL, 0),
(8, 'Thomas', 'Petit', 'fr', 'thhomas@petit.com', NULL, '$2y$12$AzI28tJqzssVXUmp9SJqlONhmucSQmlV6aRZeyww9PrrfsDhBq5hS', NULL, NULL, NULL, 0),
(9, 'Nowak', ' Kochanowski', 'pl', 'nowak@kochanowski.com', NULL, '$2y$12$oRg59dIJOQyJdxzQDgh2K.PDx3GxslUCVqlwwKRPVpdnqajxO3eeW', NULL, NULL, NULL, 0),
(10, 'Hamza', 'Naim', 'ar', 'hamza@naim.com', NULL, '$2y$12$JiLAWTT/p8UjQJxmHORAled/w0EWlgaaJVm/y07Ym/946zeGNE6h.', NULL, NULL, NULL, 0),
(11, 'Hanane', 'Amar', 'ar', 'hanane@amar.com', NULL, '$2y$12$KP/t/0ZdqumP6tyyjh0WIelznYp0wOhKWw9TZahoS2FfrMlV317S.', NULL, NULL, NULL, 0),
(12, 'Maeve', 'Kelly', 'ir', 'maeve@kelly.com', NULL, '$2y$12$AvOoU7./OhPtL6iEqkAuxuFgsPWLMKWyck39T5A2vMAEXOqyusU12', NULL, NULL, NULL, 0),
(13, 'Niall', 'Ryan', 'ir', 'niall@ryan.com', NULL, '$2y$12$QrlInu0jafEb4gc5q452je/ggehlxu9CtpAR2eaRoU0zE3RjCkF22', NULL, NULL, NULL, 0),
(14, 'justin', 'ghatas', NULL, 'justin.ghatas@gmail.com', NULL, '$2y$12$G29j4DNVwnHUtkkb4Xi2feDZzvw/i7WfzHEl2xMG3es6vRWuHqgqa', NULL, NULL, NULL, 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `artists`
--
ALTER TABLE `artists`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `artist_type`
--
ALTER TABLE `artist_type`
  ADD PRIMARY KEY (`id`),
  ADD KEY `artist_type_artist_id_foreign` (`artist_id`),
  ADD KEY `artist_type_type_id_foreign` (`type_id`);

--
-- Index pour la table `artist_type_show`
--
ALTER TABLE `artist_type_show`
  ADD PRIMARY KEY (`id`),
  ADD KEY `artist_type_show_artist_type_id_foreign` (`artist_type_id`),
  ADD KEY `artist_type_show_show_id_foreign` (`show_id`);

--
-- Index pour la table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Index pour la table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Index pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Index pour la table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Index pour la table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `localities`
--
ALTER TABLE `localities`
  ADD PRIMARY KEY (`postal_code`);

--
-- Index pour la table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `locations_slug_unique` (`slug`),
  ADD KEY `locations_locality_postal_code_foreign` (`locality_postal_code`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Index pour la table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Index pour la table `prices`
--
ALTER TABLE `prices`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `price_show`
--
ALTER TABLE `price_show`
  ADD PRIMARY KEY (`id`),
  ADD KEY `price_show_price_id_foreign` (`price_id`),
  ADD KEY `price_show_show_id_foreign` (`show_id`);

--
-- Index pour la table `representations`
--
ALTER TABLE `representations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `representations_location_id_foreign` (`location_id`),
  ADD KEY `representations_show_id_foreign` (`show_id`);

--
-- Index pour la table `representation_reservation`
--
ALTER TABLE `representation_reservation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `representation_reservation_representation_id_foreign` (`representation_id`),
  ADD KEY `representation_reservation_reservation_id_foreign` (`reservation_id`),
  ADD KEY `representation_reservation_price_id_foreign` (`price_id`);

--
-- Index pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reservations_user_id_foreign` (`user_id`);

--
-- Index pour la table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`),
  ADD KEY `reviews_show_id_foreign` (`show_id`);

--
-- Index pour la table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_role_unique` (`role`);

--
-- Index pour la table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `role_user_user_id_role_id_unique` (`user_id`,`role_id`),
  ADD KEY `role_user_role_id_foreign` (`role_id`);

--
-- Index pour la table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Index pour la table `shows`
--
ALTER TABLE `shows`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `shows_slug_unique` (`slug`),
  ADD KEY `shows_location_id_foreign` (`location_id`);

--
-- Index pour la table `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `artists`
--
ALTER TABLE `artists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `artist_type`
--
ALTER TABLE `artist_type`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT pour la table `artist_type_show`
--
ALTER TABLE `artist_type_show`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `prices`
--
ALTER TABLE `prices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `price_show`
--
ALTER TABLE `price_show`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT pour la table `representations`
--
ALTER TABLE `representations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT pour la table `representation_reservation`
--
ALTER TABLE `representation_reservation`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT pour la table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `role_user`
--
ALTER TABLE `role_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `shows`
--
ALTER TABLE `shows`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `types`
--
ALTER TABLE `types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `artist_type`
--
ALTER TABLE `artist_type`
  ADD CONSTRAINT `artist_type_artist_id_foreign` FOREIGN KEY (`artist_id`) REFERENCES `artists` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `artist_type_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `types` (`id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `artist_type_show`
--
ALTER TABLE `artist_type_show`
  ADD CONSTRAINT `artist_type_show_artist_type_id_foreign` FOREIGN KEY (`artist_type_id`) REFERENCES `artist_type` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `artist_type_show_show_id_foreign` FOREIGN KEY (`show_id`) REFERENCES `shows` (`id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `locations`
--
ALTER TABLE `locations`
  ADD CONSTRAINT `locations_locality_postal_code_foreign` FOREIGN KEY (`locality_postal_code`) REFERENCES `localities` (`postal_code`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `price_show`
--
ALTER TABLE `price_show`
  ADD CONSTRAINT `price_show_price_id_foreign` FOREIGN KEY (`price_id`) REFERENCES `prices` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `price_show_show_id_foreign` FOREIGN KEY (`show_id`) REFERENCES `shows` (`id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `representations`
--
ALTER TABLE `representations`
  ADD CONSTRAINT `representations_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `representations_show_id_foreign` FOREIGN KEY (`show_id`) REFERENCES `shows` (`id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `representation_reservation`
--
ALTER TABLE `representation_reservation`
  ADD CONSTRAINT `representation_reservation_price_id_foreign` FOREIGN KEY (`price_id`) REFERENCES `prices` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `representation_reservation_representation_id_foreign` FOREIGN KEY (`representation_id`) REFERENCES `representations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `representation_reservation_reservation_id_foreign` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_show_id_foreign` FOREIGN KEY (`show_id`) REFERENCES `shows` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `shows`
--
ALTER TABLE `shows`
  ADD CONSTRAINT `shows_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
