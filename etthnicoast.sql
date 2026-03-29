-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 23, 2026 at 03:22 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `etthnicoast`
--

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `button` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `title`, `subtitle`, `image`, `button`, `is_active`, `created_at`, `updated_at`) VALUES
(2, 'Gift of Elegance', 'Perfect For Every Occasion', 'banners/b1XBJTrAZ13XallDx3b3Kaq9wtI0HTW3f7lBsCg0.jpg', 'Shop Gifts', 1, '2026-02-28 22:38:34', '2026-02-28 22:38:34'),
(3, 'Exclusive Designs', 'Handcrafted With Perfection', 'banners/7r0VICYLt0RhUkdTAf68CmbQkjrNpgWGYbovLoxu.jpg', 'View Collection', 1, '2026-02-28 22:39:03', '2026-02-28 22:39:03'),
(4, 'ETTHNICOAST', 'Premium Silver Jewelry', 'banners/f3l0ZVZVm9fAinC7kxhgDGA2GW1Ue1uQaZOWrZa7.jpg', 'Explore Collection', 1, '2026-02-28 22:39:48', '2026-02-28 22:39:48'),
(5, 'New Arrivals', 'Discover The Latest Collection', 'banners/OQmvKfFKqtJ0dc2JZPpaPmb4F1boZqjMSwyrOolZ.jpg', 'Shop Now', 1, '2026-02-28 22:40:49', '2026-02-28 22:40:49'),
(6, 'Bridal Collection', 'Shine On Your Special Day', 'banners/n6Oqfy3cIfCt9m4lNfsGvSTC70UTiFWrWPSz2KkG.jpg', 'Explore Bridal', 1, '2026-02-28 22:41:43', '2026-02-28 22:41:43');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_id` bigint(255) DEFAULT NULL,
  `variant_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `product_id`, `variant_id`, `quantity`, `created_at`, `updated_at`) VALUES
(2, 2, NULL, NULL, 1, '2026-03-13 23:29:46', '2026-03-13 23:29:46'),
(3, 2, 11, NULL, 1, '2026-03-15 04:59:30', '2026-03-15 04:59:30'),
(4, 2, 10, NULL, 1, '2026-03-15 04:59:32', '2026-03-15 04:59:32');

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cart_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `variant_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price` decimal(10,2) NOT NULL,
  `discount_price` decimal(10,2) DEFAULT NULL,
  `cgst` decimal(5,2) DEFAULT NULL,
  `sgst` decimal(5,2) DEFAULT NULL,
  `weight` decimal(10,2) DEFAULT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`id`, `cart_id`, `product_id`, `variant_id`, `quantity`, `price`, `discount_price`, `cgst`, `sgst`, `weight`, `total_price`, `created_at`, `updated_at`) VALUES
(7, 2, 6, NULL, 1, 44.21, NULL, NULL, NULL, NULL, 44.21, '2026-03-15 06:01:24', '2026-03-15 06:01:24'),
(8, 2, 7, NULL, 1, 875.00, NULL, NULL, NULL, NULL, 875.00, '2026-03-22 20:37:29', '2026-03-22 20:37:29');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_type_id` bigint(20) UNSIGNED NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `slug` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_type_id`, `category_name`, `description`, `status`, `slug`, `created_at`, `updated_at`) VALUES
(1, 6, 'Ear', NULL, 1, '', '2026-02-20 13:57:42', '2026-02-20 13:57:42'),
(2, 6, 'Neck', NULL, 1, '', '2026-02-20 13:58:07', '2026-02-20 13:58:07'),
(3, 6, 'Nose', NULL, 1, '', '2026-02-20 13:58:16', '2026-02-20 13:58:16'),
(4, 6, 'Hand', NULL, 1, '', '2026-02-20 13:58:31', '2026-02-20 13:58:31'),
(5, 6, 'Feet', NULL, 1, '', '2026-02-20 13:58:43', '2026-02-20 13:58:53'),
(6, 7, 'Bridal', NULL, 1, '', '2026-02-20 13:59:40', '2026-02-20 13:59:40'),
(7, 7, 'Ethnic/Traditional', NULL, 1, '', '2026-02-20 13:59:59', '2026-02-20 13:59:59'),
(8, 7, 'Contemporary', NULL, 1, '', '2026-02-20 14:00:20', '2026-02-20 14:00:20'),
(9, 7, 'Western', NULL, 1, '', '2026-02-20 14:00:28', '2026-02-21 00:32:05'),
(10, 7, 'Office', NULL, 1, '', '2026-02-20 14:00:43', '2026-02-20 14:00:43'),
(11, 7, 'Party', NULL, 1, '', '2026-02-20 14:00:58', '2026-02-20 14:00:58'),
(12, 7, 'Semi-casual', NULL, 1, '', '2026-02-20 14:01:11', '2026-02-20 14:01:11'),
(13, 8, 'Oxidized finish', NULL, 1, '', '2026-02-20 14:08:09', '2026-02-20 14:08:09'),
(14, 8, 'Rhodium polished', NULL, 1, '', '2026-02-20 14:08:27', '2026-02-20 14:08:27'),
(15, 8, 'Original matte finish', NULL, 1, '', '2026-02-20 14:08:46', '2026-02-20 14:08:46'),
(17, 8, 'With semi-precious stones', NULL, 1, '', '2026-02-20 14:09:12', '2026-02-20 14:09:12'),
(18, 8, 'With AD stones and studs', NULL, 1, '', '2026-02-20 14:09:34', '2026-02-20 14:09:34'),
(21, 8, 'With artificial pearls', NULL, 1, '', '2026-02-20 14:10:07', '2026-02-20 14:10:07'),
(22, 8, 'Handcrafted', NULL, 1, '', '2026-02-20 14:10:23', '2026-02-20 14:10:23'),
(23, 8, 'Chhilai / cut work', NULL, 1, '', '2026-02-20 14:10:33', '2026-02-20 14:10:33'),
(24, 8, 'Meenakari work', NULL, 1, '', '2026-02-20 14:11:00', '2026-02-20 14:11:00'),
(25, 9, 'WITHIN INR 1,000/-', NULL, 1, '', '2026-02-20 14:18:20', '2026-02-20 14:18:20'),
(26, 9, 'INR 1,000/- TO 2,000/-', NULL, 1, '', '2026-02-20 14:18:37', '2026-02-20 14:18:37'),
(27, 9, 'INR 2,000/- TO 3,000/-', NULL, 1, '', '2026-02-20 14:18:51', '2026-02-20 14:18:51'),
(28, 9, 'INR 3,000/- TO 5,000/-', NULL, 1, '', '2026-02-20 14:19:16', '2026-02-20 14:19:16'),
(29, 9, 'INR 5,000/- TO 10,000/-', NULL, 1, '', '2026-02-20 14:19:28', '2026-02-20 14:19:28'),
(30, 9, 'INR 10,000/- & ABOVE', NULL, 1, '', '2026-02-20 14:20:15', '2026-02-20 14:20:15'),
(31, 8, 'Polki with Kundan work', NULL, 1, '', '2026-02-21 00:36:08', '2026-02-21 00:36:08');

-- --------------------------------------------------------

--
-- Table structure for table `category_types`
--

CREATE TABLE `category_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type_name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category_types`
--

INSERT INTO `category_types` (`id`, `type_name`, `description`, `status`, `created_at`, `updated_at`) VALUES
(6, 'Type I', NULL, 1, '2026-02-20 13:44:43', '2026-02-20 13:44:43'),
(7, 'Type II', NULL, 1, '2026-02-20 13:44:50', '2026-02-20 13:44:50'),
(8, 'Type III', NULL, 1, '2026-02-20 13:44:56', '2026-02-20 13:44:56'),
(9, 'Type IV', NULL, 1, '2026-02-20 13:45:03', '2026-02-20 13:45:03');

-- --------------------------------------------------------

--
-- Table structure for table `collection_ranges`
--

CREATE TABLE `collection_ranges` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `collection_ranges`
--

INSERT INTO `collection_ranges` (`id`, `name`, `image`, `url`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Rings', 'collection-ranges/vdZyKs96hvVT7R4s0x9651J31kfmjEyWfUkpseyz.jpg', NULL, 1, '2026-02-28 23:18:40', '2026-02-28 23:21:01'),
(2, 'Bracelets', 'collection-ranges/4I4T1q374iZZrTUuJuOKlwfbiWiVjYknIbPjnYUc.jpg', NULL, 1, '2026-02-28 23:18:47', '2026-02-28 23:20:50'),
(3, 'Anklets', 'collection-ranges/BWBgGvFUb8tUDTrCRXywPKnWu5fcPmPI4Na6SZh9.jpg', NULL, 1, '2026-02-28 23:19:00', '2026-02-28 23:20:39'),
(4, 'Earrings', 'collection-ranges/pewTxZ5hDAn8ebRBxwMj8yKFWtthhoL5QJ1O40zX.jpg', NULL, 1, '2026-02-28 23:19:09', '2026-02-28 23:20:31'),
(5, 'Pendants', 'collection-ranges/TaePoZOLqDo8lVCrJ6ahXH9rzEgdF1VN8evPSRUs.jpg', NULL, 1, '2026-02-28 23:19:24', '2026-02-28 23:20:23'),
(6, 'Sets', 'collection-ranges/70yazlHDhlZhxouceo4SC1OPc04D5xU470oacgNO.jpg', NULL, 1, '2026-03-01 14:34:39', '2026-03-01 14:34:39'),
(7, 'Men in Silver', 'collection-ranges/BDlWOP3g2LvPJOYsuEX9N6gt5VC5u157vkpBYBMh.jpg', NULL, 1, '2026-03-01 14:34:55', '2026-03-01 14:34:55');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` enum('unread','read','replied') NOT NULL DEFAULT 'unread',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `etthnicoast_worlds`
--

CREATE TABLE `etthnicoast_worlds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `etthnicoast_worlds`
--

INSERT INTO `etthnicoast_worlds` (`id`, `title`, `subtitle`, `image`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'SILVER', 'Pure 925 Sterling Silver', 'etthnicoast-worlds/FIj7ENHjeYxIICubyrCPavXWjR4ldxU4sR14eosa.jpg', 1, '2026-03-03 13:17:35', '2026-03-03 13:17:35'),
(2, 'GOLD PLATED', 'Luxury Layered Shine', 'etthnicoast-worlds/M7osk75yNI7lKjdxzHD4FON2HKHFRBz4GciK3Zfk.jpg', 1, '2026-03-03 13:18:02', '2026-03-03 13:18:02'),
(3, 'XOXO', 'Younger • Trendier • Everyday Styles', 'etthnicoast-worlds/84WPXXHU7prYAQxovX6r6qAyqTTBcrMLm3j4591q.jpg', 1, '2026-03-03 13:18:36', '2026-03-03 13:18:36'),
(4, 'XOXO', 'Minimal & Modern Elegance', 'etthnicoast-worlds/Ia7GBi8BIZAvVXjMySHcq6kAo4kiaq7B6SictEt2.jpg', 1, '2026-03-03 13:19:07', '2026-03-03 13:19:07');

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
-- Table structure for table `home_customer_reviews`
--

CREATE TABLE `home_customer_reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `rating` int(11) NOT NULL DEFAULT 5,
  `review` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `home_customer_reviews`
--

INSERT INTO `home_customer_reviews` (`id`, `user_id`, `customer_name`, `rating`, `review`, `is_active`, `created_at`, `updated_at`) VALUES
(3, 1, 'Anjali Patel', 5, 'Best silver jewelry store! Great customer service and authentic products. Love my new necklace! The packaging was beautiful too.', 1, '2026-03-09 20:53:40', '2026-03-09 20:53:40'),
(4, 1, 'Rahul Sharma', 5, 'Amazing quality and beautiful designs. The pieces are exactly as shown on the website. Highly recommend Etthnicoast to everyone!', 1, '2026-03-09 20:53:40', '2026-03-09 20:53:40'),
(5, 1, 'Vikram Singh', 5, 'Perfect gift for my wife. She absolutely loved the earrings. Will definitely shop again from this store!', 1, '2026-03-09 20:53:40', '2026-03-09 20:53:40'),
(6, 1, 'Priya Mehta', 4, 'Very happy with my purchase. The ring fits perfectly and the silver quality is excellent. Delivery was quick too.', 1, '2026-03-09 20:53:40', '2026-03-09 20:53:40'),
(7, 1, 'Sneha Kapoor', 5, 'I ordered a bracelet set and it arrived in the most gorgeous gift box. The craftsmanship is top notch. Already placed a second order!', 1, '2026-03-09 20:53:40', '2026-03-09 20:53:40'),
(8, 1, 'Arjun Nair', 4, 'Good quality 925 silver. The oxidised finish on the pendant looks even better in person. Packaging is premium and gift-ready.', 1, '2026-03-09 20:53:40', '2026-03-09 20:53:40'),
(9, 1, 'Divya Reddy', 5, 'Ordered the stackable ring set as a birthday gift. My friend was absolutely thrilled. The quality is outstanding for the price!', 1, '2026-03-09 20:53:40', '2026-03-09 20:53:40'),
(10, 1, 'Karan Malhotra', 5, 'Bought a men\'s silver bracelet and I get compliments every time I wear it. Very sturdy and genuine 925 silver. Great brand!', 1, '2026-03-09 20:53:40', '2026-03-09 20:53:40'),
(11, 1, 'Meera Iyer', 4, 'Lovely collection and easy website to navigate. The anklet I purchased is delicate and well-made. Will shop again for sure.', 1, '2026-03-09 20:53:40', '2026-03-09 20:53:40'),
(12, 1, 'Rohan Joshi', 3, 'Overall decent product. The delivery took a bit longer than expected but the quality of the ring is good. Would give it another try.', 1, '2026-03-09 20:53:40', '2026-03-09 20:53:56'),
(13, 1, 'Nisha Gupta', 5, 'Absolutely in love with my moonstone ring! It looks magical and the silver setting is flawless. Etthnicoast never disappoints.', 1, '2026-03-09 20:53:40', '2026-03-09 20:53:40'),
(14, 1, 'Aditya Verma', 5, 'Gifted a pendant set to my mother on her anniversary and she was over the moon. Beautiful pieces, fast shipping, excellent service!', 1, '2026-03-09 20:53:40', '2026-03-09 20:53:40');

-- --------------------------------------------------------

--
-- Table structure for table `home_page_banner_setups`
--

CREATE TABLE `home_page_banner_setups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `banner_image` varchar(255) NOT NULL,
  `banner_title` varchar(255) DEFAULT NULL,
  `banner_subtitle` varchar(255) DEFAULT NULL,
  `banner_link` varchar(255) DEFAULT NULL,
  `button_text` varchar(255) DEFAULT NULL,
  `button_text_2` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `home_page_banner_setups`
--

INSERT INTO `home_page_banner_setups` (`id`, `user_id`, `type`, `banner_image`, `banner_title`, `banner_subtitle`, `banner_link`, `button_text`, `button_text_2`, `title`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, 'seasonal_banner', 'home-page-banners/tVecm0r9j2MizqjIGbFmHBeHVvlN0uLbN1uo384P.jpg', 'SEASONAL COLLECTION', 'Discover our exclusive seasonal collection', NULL, 'SHOP NOW', NULL, NULL, NULL, 1, '2026-02-28 23:53:45', '2026-02-28 23:53:45'),
(2, 1, 'for_him', 'home-page-banners/2dQAeEB9qgbcBdlqRtMk3uPi8umLKQWaAfE6N2Cj.jpg', 'FOR HIM', 'Bold and refined designs', NULL, 'EXPLORE MEN\'S COLLECTION', NULL, 'FOR HIM', 'Discover our exclusive collection of silver jewelry designed for the modern gentleman. Each piece combines timeless elegance with contemporary style, crafted to perfection from premium 925 sterling silver.', 1, '2026-02-28 23:55:20', '2026-03-08 12:23:40'),
(3, 1, 'for_her', 'home-page-banners/1cIy69nPWNIWBZAnsht3eCSJ5ScMZIBCwAD3QRUf.jpg', 'FOR HER', 'Elegant designs for every occasion', NULL, 'EXPLORE WOMEN\'S COLLECTION', NULL, 'FOR HER', 'Explore our stunning range of silver jewelry crafted for the elegant woman. From delicate everyday pieces to statement designs, each creation embodies sophistication and grace, made with the finest quality silver.', 1, '2026-02-28 23:56:39', '2026-02-28 23:56:39'),
(4, 1, 'new_arrivals', 'home-page-banners/hi0QgSpaAB55fp9VYOCLlfZfzqqjvkc9rYcASbBJ.jpg', NULL, NULL, NULL, 'SHOP NEW ARRIVALS', NULL, 'NEW ARRIVALS', 'Discover our latest collection of premium silver jewelry. Each piece is crafted with precision and designed to make you shine.', 1, '2026-03-01 00:01:50', '2026-03-01 00:01:50'),
(5, 1, 'perfect_gifts', 'home-page-banners/uxQChCSa26PaNVUl0fRpwxTiuH4qz3TSQnmkZFM4.jpg', 'PERFECT GIFTS', 'Show your love with timeless silver jewelry. Perfect for every occasion and every special person in your life.', NULL, 'EXPLORE GIFTS', NULL, NULL, 'Show your love with timeless silver jewelry. Perfect for every occasion and every special person in your life.', 1, '2026-03-01 00:03:56', '2026-03-01 00:03:56'),
(6, 1, 'generic_banner', 'home-page-banners/8KggcHdY7uOvTd4twW7Gp7TGPi5CborSydZ8pADg.jpg', 'Shine Brighter This Diwali', 'Celebrate the festival of lights with premium silver jewelry—crafted to glow with every moment.', NULL, 'SHOP DIWALI EDIT', 'GET GUIDE', NULL, NULL, 1, '2026-03-01 00:05:59', '2026-03-01 00:05:59'),
(7, 1, 'exclusive_collection', 'home-page-banners/JoTiNPAW7sIiFJS5Za2HK6SGkXtCjq39hwiDuQDn.jpg', 'EXCLUSIVE COLLECTION', 'Discover our handpicked selection of premium silver jewelry. Limited edition pieces crafted with passion and precision.', NULL, 'EXPLORE COLLECTION', NULL, NULL, NULL, 1, '2026-03-01 00:07:00', '2026-03-01 00:07:00');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_number` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `total_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `invoice_number`, `user_id`, `order_id`, `total_amount`, `created_at`, `updated_at`) VALUES
(2, 'INV-20260308-MBT5V', 2, 4, 3812.00, '2026-03-08 03:37:30', '2026-03-08 03:37:30'),
(3, 'INV-20260308-WTSOW', 2, 5, 1234.00, '2026-03-08 03:49:48', '2026-03-08 03:49:48'),
(4, 'INV-20260308-EIKPZ', 2, 6, 3812.00, '2026-03-08 12:08:14', '2026-03-08 12:08:14'),
(5, 'INV-20260314-JPR4D', 2, 7, 20921.01, '2026-03-14 00:33:03', '2026-03-14 00:33:03');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_items`
--

CREATE TABLE `invoice_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `variant_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price` decimal(10,2) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `cgst` decimal(5,2) DEFAULT NULL,
  `sgst` decimal(5,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoice_items`
--

INSERT INTO `invoice_items` (`id`, `invoice_id`, `product_id`, `variant_id`, `quantity`, `price`, `total_price`, `cgst`, `sgst`, `created_at`, `updated_at`) VALUES
(2, 2, 5, NULL, 1, 3812.00, 3812.00, NULL, NULL, '2026-03-08 03:37:30', '2026-03-08 03:37:30'),
(3, 3, 15, NULL, 1, 1234.00, 1234.00, NULL, NULL, '2026-03-08 03:49:48', '2026-03-08 03:49:48'),
(4, 4, 5, NULL, 1, 3812.00, 3812.00, NULL, NULL, '2026-03-08 12:08:14', '2026-03-08 12:08:14'),
(5, 5, 5, NULL, 5, 3812.00, 19060.00, NULL, NULL, '2026-03-14 00:33:03', '2026-03-14 00:33:03'),
(6, 5, 14, NULL, 4, 454.20, 1816.80, NULL, NULL, '2026-03-14 00:33:03', '2026-03-14 00:33:03'),
(7, 5, 6, NULL, 1, 44.21, 44.21, NULL, NULL, '2026-03-14 00:33:03', '2026-03-14 00:33:03');

-- --------------------------------------------------------

--
-- Table structure for table `jewellery_in_motions`
--

CREATE TABLE `jewellery_in_motions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `video` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jewellery_in_motions`
--

INSERT INTO `jewellery_in_motions` (`id`, `video`, `user_id`, `product_id`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'jewellery-in-motions/2hluo3FVADCQXw8T0VkmseB1Kg5nYxDBcNFVsKoS.mp4', 1, 5, 1, '2026-03-01 00:32:03', '2026-03-01 00:32:03'),
(2, 'jewellery-in-motions/VgxzGOHPsy2utg2U0ZR9Ks7THuN2x3uVNrAi69mZ.mp4', 1, 9, 1, '2026-03-01 00:32:14', '2026-03-08 08:25:42'),
(3, 'jewellery-in-motions/8V75gKu2kDDEN2miA16PR1rqN0sOUzGUr0FqkuB1.mp4', 1, 13, 1, '2026-03-01 00:32:22', '2026-03-08 08:25:31'),
(4, 'jewellery-in-motions/s5rXqGiwXIVBxzgZlqc6XUqkSixVglN8luSDGa9q.mp4', 1, 7, 1, '2026-03-01 00:32:45', '2026-03-08 08:25:22');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
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
-- Table structure for table `job_batches`
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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_02_19_014905_create_category_types_table', 2),
(5, '2026_02_19_015148_create_categories_table', 2),
(6, '2026_02_21_072458_create_pearl_types_table', 3),
(7, '2026_02_21_072458_create_polish_types_table', 4),
(8, '2026_02_21_072458_create_stone_types_table', 5),
(9, '2026_02_21_072458_create_products_table', 6),
(10, '2026_02_21_072459_create_product_variants_table', 7),
(11, '2026_02_21_072459_create_product_images_table', 8),
(12, '2026_02_26_193537_create_tab_categories_table', 9),
(13, '2026_02_26_193557_create_tab_sub_categories_table', 10),
(14, '2026_03_01_025204_create_banners_table', 11),
(15, '2026_03_01_025335_create_promo_strips_table', 12),
(16, '2026_03_01_025427_create_collection_ranges_table', 13),
(17, '2026_03_01_030222_create_home_page_banner_setups_table', 14),
(18, '2026_03_01_030714_create_shop_by_life_styles_table', 15),
(19, '2026_03_01_031004_create_jewellery_in_motions_table', 16),
(20, '2026_03_01_030920_create_our_best_sellers_table', 17),
(21, '2026_03_02_175639_create_product_code_item_details_table', 18),
(22, '2026_03_02_175700_create_product_code_emblishments_table', 19),
(23, '2026_03_02_175723_create_product_code_finishings_table', 20),
(24, '2026_03_02_175739_create_product_code_makers_table', 21),
(25, '2026_03_01_030816_create_etthnicoast_worlds_table', 22),
(26, '2026_03_01_031552_create_shop_the_looks_table', 23),
(27, '2026_03_01_031941_create_shop_the_look_hotspots_table', 24),
(28, '2026_03_01_032048_create_our_valued_partners_table', 25),
(29, '2026_03_06_013908_create_product_similar_items', 26),
(30, '2026_03_06_014304_create_product_complete_looks_table', 27),
(31, '2026_03_01_025053_create_reviews_table', 28),
(32, '2026_03_01_024332_create_carts_table', 29),
(33, '2026_03_01_024341_create_cart_items_table', 30),
(34, '2026_03_01_024644_create_orders_table', 31),
(35, '2026_03_01_024732_create_order_items_table', 32),
(36, '2026_03_01_032355_create_invoices_table', 33),
(37, '2026_03_01_032407_create_invoice_items_table', 34),
(38, '2026_03_08_085440_create_order_tax_details_table', 35),
(39, '2026_03_01_030534_create_home_customer_reviews_table', 36),
(40, '2026_03_14_011129_make_tab_category_product_table', 37),
(41, '2026_03_14_025205_create_wishlists_table', 38),
(42, '2026_03_22_125110_create_static_pages_table', 39),
(43, '2026_03_22_134251_create_contact_messages_table', 40);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_code` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_code`, `user_id`, `total_amount`, `status`, `created_at`, `updated_at`) VALUES
(4, 'ORD-5D1GWNKL', 2, 3812.00, 'paid', '2026-03-08 03:37:30', '2026-03-08 03:37:30'),
(5, 'ORD-EVF27ASC', 2, 1234.00, 'paid', '2026-03-08 03:49:48', '2026-03-08 03:49:48'),
(6, 'ORD-NL0WP8KI', 2, 3812.00, 'paid', '2026-03-08 12:08:13', '2026-03-08 12:08:13'),
(7, 'ORD-PCKNHGXD', 2, 20921.01, 'confirmed', '2026-03-14 00:33:03', '2026-03-14 00:33:03');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `variant_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price` decimal(10,2) NOT NULL,
  `discount_price` decimal(10,2) DEFAULT NULL,
  `cgst` decimal(5,2) DEFAULT NULL,
  `sgst` decimal(5,2) DEFAULT NULL,
  `weight` decimal(10,2) DEFAULT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `variant_id`, `quantity`, `price`, `discount_price`, `cgst`, `sgst`, `weight`, `total_price`, `created_at`, `updated_at`) VALUES
(3, 4, 5, NULL, 1, 3812.00, NULL, NULL, NULL, 4.74, 3812.00, '2026-03-08 03:37:30', '2026-03-08 03:37:30'),
(4, 5, 15, NULL, 1, 1234.00, NULL, NULL, NULL, NULL, 1234.00, '2026-03-08 03:49:48', '2026-03-08 03:49:48'),
(5, 6, 5, NULL, 1, 3812.00, NULL, NULL, NULL, 4.74, 3812.00, '2026-03-08 12:08:14', '2026-03-08 12:08:14'),
(6, 7, 5, NULL, 5, 3812.00, NULL, NULL, NULL, NULL, 19060.00, '2026-03-14 00:33:03', '2026-03-14 00:33:03'),
(7, 7, 14, NULL, 4, 454.20, NULL, NULL, NULL, NULL, 1816.80, '2026-03-14 00:33:03', '2026-03-14 00:33:03'),
(8, 7, 6, NULL, 1, 44.21, NULL, NULL, NULL, NULL, 44.21, '2026-03-14 00:33:03', '2026-03-14 00:33:03');

-- --------------------------------------------------------

--
-- Table structure for table `order_tax_details`
--

CREATE TABLE `order_tax_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `sale_date` date NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `unit_price` decimal(10,2) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `delivery_state` varchar(255) DEFAULT NULL,
  `delivery_cost` decimal(10,2) NOT NULL DEFAULT 0.00,
  `cgst_rate` decimal(5,2) NOT NULL DEFAULT 0.00,
  `sgst_rate` decimal(5,2) NOT NULL DEFAULT 0.00,
  `igst_rate` decimal(5,2) NOT NULL DEFAULT 0.00,
  `cgst_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `sgst_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `igst_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `gross_amount` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_tax_details`
--

INSERT INTO `order_tax_details` (`id`, `order_id`, `invoice_id`, `product_id`, `sale_date`, `quantity`, `unit_price`, `amount`, `delivery_state`, `delivery_cost`, `cgst_rate`, `sgst_rate`, `igst_rate`, `cgst_amount`, `sgst_amount`, `igst_amount`, `gross_amount`, `created_at`, `updated_at`) VALUES
(1, 4, 2, 5, '2026-03-08', 1, 3812.00, 3812.00, NULL, 0.00, 0.00, 0.00, 3.00, 0.00, 0.00, 114.36, 3812.00, '2026-03-08 03:37:30', '2026-03-08 03:37:30'),
(2, 5, 3, 15, '2026-03-08', 1, 1234.00, 1234.00, NULL, 0.00, 0.00, 0.00, 3.00, 0.00, 0.00, 37.02, 1234.00, '2026-03-08 03:49:48', '2026-03-08 03:49:48'),
(3, 6, 4, 5, '2026-03-08', 1, 3812.00, 3812.00, NULL, 0.00, 0.00, 0.00, 3.00, 0.00, 0.00, 114.36, 3812.00, '2026-03-08 12:08:14', '2026-03-08 12:08:14');

-- --------------------------------------------------------

--
-- Table structure for table `our_best_sellers`
--

CREATE TABLE `our_best_sellers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `our_best_sellers`
--

INSERT INTO `our_best_sellers` (`id`, `title`, `subtitle`, `image`, `tags`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Elegant Ring Collection', 'Most purchased jewellery of the month. Timeless designs that never go out of style.', 'our-best-sellers/WRD1jsO7anyhiKkKI9JMkooNl1g5JbVQVytLknJP.jpg', 'Top Seller', 1, '2026-03-01 13:56:47', '2026-03-01 13:56:47'),
(2, 'Statement Earrings', 'Loved for timeless minimal design. Perfect for every occasion and style.', 'our-best-sellers/pDkuqb7msV72KpL19JNn5w0b1O6DkppGGx7zJing.jpg', 'Fan Favourite', 1, '2026-03-01 13:57:32', '2026-03-01 13:57:32'),
(3, 'Pendant Designs', 'Perfect for gifting moments. Show your love with these beautiful pieces.', 'our-best-sellers/h9PmnbwMZcqisSQw96jU5bQHO5C9n0btdWx2285m.jpg', 'Most Gifted', 1, '2026-03-01 13:58:20', '2026-03-01 13:58:20'),
(4, 'Modern Bracelets', 'Fast-moving bestselling pieces. Stay ahead of the fashion curve.', 'our-best-sellers/Pg3nkF6hQSBuA4q9rL55snxkFrQJg0uHZ7sHVlsC.jpg', 'Trending', 1, '2026-03-01 13:58:56', '2026-03-01 13:58:56'),
(5, 'Anklet Collection', 'Highest rated by customers. Quality and style combined perfectly.', 'our-best-sellers/Q2wmZ0CjxRnzVzXi80oFJfF0Fioa3JGGEp4e45hk.jpg', 'Hot Pick', 1, '2026-03-01 13:59:44', '2026-03-01 13:59:44'),
(6, 'Designer Sets', 'Most loved new arrivals. Complete your look with matching sets.', 'our-best-sellers/y36lk40SvLbweRMbKWgp0GWQjJ9zebqVYjNzBuDw.jpg', 'Top Rated', 1, '2026-03-01 14:00:10', '2026-03-01 14:00:10');

-- --------------------------------------------------------

--
-- Table structure for table `our_valued_partners`
--

CREATE TABLE `our_valued_partners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `our_valued_partners`
--

INSERT INTO `our_valued_partners` (`id`, `name`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'OML', 1, '2026-03-03 22:22:30', '2026-03-03 22:22:30'),
(2, 'FedEx', 1, '2026-03-03 22:22:46', '2026-03-03 22:22:46'),
(3, 'ShaadiSaga', 1, '2026-03-03 22:23:01', '2026-03-03 22:23:01'),
(4, 'Femina', 1, '2026-03-03 22:23:18', '2026-03-03 22:23:18'),
(5, 'Afterpay', 1, '2026-03-03 22:23:39', '2026-03-03 22:23:39'),
(6, 'Stuller', 1, '2026-03-03 22:23:52', '2026-03-03 22:23:52');

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
-- Table structure for table `pearl_types`
--

CREATE TABLE `pearl_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `display_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pearl_types`
--

INSERT INTO `pearl_types` (`id`, `name`, `display_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Pearl White', 0, 1, '2026-02-21 22:38:07', '2026-02-21 22:38:07'),
(2, 'Golden Pearl', 0, 1, '2026-02-21 22:38:20', '2026-02-21 22:38:20'),
(3, 'Ivory Tone', 0, 1, '2026-02-21 22:38:29', '2026-02-21 22:38:29'),
(4, 'Cream Pearl', 0, 1, '2026-02-21 22:38:38', '2026-02-21 22:38:38');

-- --------------------------------------------------------

--
-- Table structure for table `polish_types`
--

CREATE TABLE `polish_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `display_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `color_code` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `polish_types`
--

INSERT INTO `polish_types` (`id`, `name`, `display_order`, `color_code`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Silver Polish', 0, '#cfcfcf', 1, '2026-02-21 23:11:22', '2026-03-07 22:20:10'),
(2, 'Gold Plated', 0, '#ffe229', 1, '2026-02-21 23:11:30', '2026-03-07 22:20:01'),
(3, 'Rhodium', 0, '#ca9191', 1, '2026-02-21 23:11:37', '2026-03-07 22:19:51'),
(4, 'Oxidized', 0, '#c2bdbd', 1, '2026-02-21 23:11:47', '2026-03-07 22:19:43'),
(5, 'Rose Gold', 0, '#fef739', 1, '2026-02-21 23:12:03', '2026-03-07 22:19:33'),
(6, 'Black', 0, '#3d3333', 1, '2026-03-07 22:19:21', '2026-03-07 22:19:21');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_code` varchar(255) NOT NULL,
  `base_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `quantity` decimal(12,3) NOT NULL DEFAULT 0.000,
  `base_price` decimal(12,2) NOT NULL DEFAULT 0.00,
  `discount_price` decimal(12,2) DEFAULT NULL,
  `cgst` decimal(12,2) DEFAULT NULL,
  `sgst` decimal(12,2) DEFAULT NULL,
  `weight` decimal(12,3) DEFAULT NULL,
  `stone_type_id` bigint(20) UNSIGNED DEFAULT NULL,
  `pearl_type_id` bigint(20) UNSIGNED DEFAULT NULL,
  `polish_type_id` bigint(20) UNSIGNED DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `display_order` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_code`, `base_name`, `description`, `quantity`, `base_price`, `discount_price`, `cgst`, `sgst`, `weight`, `stone_type_id`, `pearl_type_id`, `polish_type_id`, `category_id`, `is_active`, `display_order`, `created_at`, `updated_at`) VALUES
(5, 'ED001RHC', 'Ear Dangler with Pearl & AD Ear', 'Crafted in premium silver with a highshine rhodium polish, these graceful ear\r\ndanglers feature sparkling American\r\nDiamonds (AD) and lustrous pearls. The\r\nsleek, elongated design adds a touch of\r\nsophistication, making them perfect for\r\nboth everyday elegance and special\r\noccasions.', 0.000, 3812.00, NULL, NULL, NULL, 4.740, NULL, NULL, NULL, 14, 1, '', '2026-02-25 10:19:41', '2026-02-28 14:03:26'),
(6, 'PD001RGC', 'ROSE GOLD PENDANT WITH AD', 'Beautifully crafted in silver with a soft rose gold polish, this elegant leaf pendant is adorned with sparkling American Diamonds (AD). Its nature-inspired design adds a refined charm, making it perfect for everyday wear and special occasions alike.', 0.000, 44.21, NULL, NULL, NULL, 2.230, NULL, NULL, 5, NULL, 1, '', '2026-02-27 21:32:33', '2026-03-06 21:28:56'),
(7, 'BG001OXP', 'TEMPLE DESIGN OXIDISED BANGLE', 'Expertly crafted in 925 pure silver with an oxidised finish, this temple-inspired bangle is adorned with delicate semi-precious pink stones. Rich in traditional detailing and timeless elegance, it adds a graceful ethnic touch to festive and classic ensembles.', 0.000, 875.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '', '2026-02-27 21:34:24', '2026-03-13 23:22:28'),
(8, 'PD001GLC', 'BUTTERFLY GOLD PLATED PENDANT WITH AD', 'Beautifully crafted in 925 pure silver with a radiant gold plating, this high-shine butterfly design is embellished with sparkling American Diamonds (AD). Symbolising freedom and elegance, it adds a touch of charm and brilliance—perfect for everyday wear or gifting.', 0.000, 554.00, NULL, NULL, NULL, 33.370, NULL, NULL, NULL, NULL, 1, '', '2026-02-27 21:37:28', '2026-03-13 23:22:16'),
(9, 'PS001RHC', 'PENDANT SET WITH GREEN EMERALD & AD', 'Crafted in silver, this elegant pendant set features a rich green emerald centerpiece, beautifully accented with sparkling American Diamonds (AD). The timeless geometric design adds a touch of luxury, making it perfect for festive occasions and graceful evening wear.', 0.000, 775.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '', '2026-02-27 21:38:32', '2026-03-13 23:22:03'),
(10, 'PS002OXS', 'OXIDISED SILVER PENDANT SET', 'Designed in oxidised rose-finish silver, this floral pendant set features a beautifully sculpted rose motif paired with matching earrings. The vintage-inspired detailing adds a bold yet graceful charm, perfect for ethnic wear and contemporary fusion looks.', 0.000, 532.22, NULL, NULL, NULL, 14.970, NULL, NULL, NULL, NULL, 1, '', '2026-02-27 21:39:34', '2026-03-06 21:37:07'),
(11, 'WR001RHC', 'INFINITY & HEART WRISTLET EMBALISHED WITH AD', 'Crafted in 925 pure silver, this elegant wristlet features a beautiful fusion of infinity and heart motifs, symbolising eternal love. Embellished with sparkling American Diamonds (AD), it adds a timeless touch of elegance—perfect for everyday wear or gifting someone special.', 0.000, 432.00, NULL, NULL, NULL, 3.170, NULL, NULL, NULL, NULL, 1, '', '2026-02-27 21:41:09', '2026-03-13 23:21:53'),
(12, 'PS003RHS', 'SILVER PAW PENDANT SET', 'Crafted in 925 pure silver with a radiant rhodium polish, this adorable paw-shaped pendant set with matching earrings is a heartfelt tribute to unconditional love. Designed to charm every animal lover, it’s the perfect blend of elegance and emotion—ideal for everyday wear or thoughtful gifting.', 0.000, 34554.00, NULL, NULL, NULL, 8.710, NULL, NULL, NULL, NULL, 1, '', '2026-02-27 21:41:45', '2026-03-13 23:21:39'),
(13, 'PS004RHD', 'SILVER WITH AD PENDANT SET', 'Crafted in 925 pure silver with a high-shine rhodium polish, these elongated rectangular ear danglers are designed for effortless elegance. Accented with the sparkling brilliance of American Diamonds (AD), their sleek silhouette adds a contemporary edge—perfect for both everyday sophistication and evening wear.', 0.000, 5242.00, NULL, NULL, NULL, 7.000, NULL, NULL, NULL, NULL, 1, '', '2026-02-27 21:43:40', '2026-03-13 23:21:23'),
(14, 'ET001RHC', 'SILVER WITH AD EAR TOP', 'Crafted in 925 pure silver with a radiant rhodium polish, these delicate flower-shaped ear tops are embellished with sparkling American Diamonds (AD). Timeless and graceful, they add a subtle touch of brilliance—perfect for everyday elegance or effortless gifting.', 0.000, 454.20, NULL, NULL, NULL, 2.790, NULL, NULL, NULL, NULL, 1, '', '2026-02-27 21:45:19', '2026-03-06 21:28:06'),
(15, 'CB-AD-GL-DP-2342', 'Test', 'test', 0.000, 1234.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '', '2026-03-03 08:33:03', '2026-03-03 08:33:03');

-- --------------------------------------------------------

--
-- Table structure for table `product_code_emblishments`
--

CREATE TABLE `product_code_emblishments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `prefix` varchar(255) NOT NULL,
  `emblishment_name` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_code_emblishments`
--

INSERT INTO `product_code_emblishments` (`id`, `prefix`, `emblishment_name`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'AD', 'American Diamond', 1, '2026-03-02 14:00:03', '2026-03-02 14:00:03'),
(2, 'PR', 'Pearl', 1, '2026-03-02 14:00:03', '2026-03-02 14:00:03'),
(3, 'KN', 'Kundan', 1, '2026-03-02 14:00:03', '2026-03-02 14:00:03'),
(4, 'CS', 'Color Stone', 1, '2026-03-02 14:00:03', '2026-03-02 14:00:03'),
(5, 'MN', 'Meenakari', 1, '2026-03-02 14:00:03', '2026-03-02 14:00:03'),
(6, 'CH', 'Chilai Work', 1, '2026-03-02 14:00:03', '2026-03-02 14:00:03'),
(7, 'BD', 'Bandhni', 1, '2026-03-02 14:00:03', '2026-03-02 14:00:03'),
(8, 'TS', 'Tussle', 1, '2026-03-02 14:00:03', '2026-03-02 14:00:03');

-- --------------------------------------------------------

--
-- Table structure for table `product_code_finishings`
--

CREATE TABLE `product_code_finishings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `prefix` varchar(255) NOT NULL,
  `finishing_name` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_code_finishings`
--

INSERT INTO `product_code_finishings` (`id`, `prefix`, `finishing_name`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'RH', 'Rhodium Polish', 1, '2026-03-02 14:04:10', '2026-03-02 14:04:10'),
(2, 'GL', 'Gold Plated', 1, '2026-03-02 14:04:10', '2026-03-02 14:04:10'),
(3, 'RG', 'Rose Gold', 1, '2026-03-02 14:04:10', '2026-03-02 14:04:10'),
(4, 'OX', 'Oxidised', 1, '2026-03-02 14:04:10', '2026-03-02 14:04:10'),
(5, 'MG', 'Mat Gold', 1, '2026-03-02 14:04:10', '2026-03-02 14:04:10'),
(6, 'AG', 'Antique Gold', 1, '2026-03-02 14:04:10', '2026-03-02 14:04:10'),
(7, 'MS', 'Mat Silver', 1, '2026-03-02 14:04:10', '2026-03-02 14:04:10');

-- --------------------------------------------------------

--
-- Table structure for table `product_code_item_details`
--

CREATE TABLE `product_code_item_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `prefix` varchar(255) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_code_item_details`
--

INSERT INTO `product_code_item_details` (`id`, `prefix`, `item_name`, `is_active`, `created_at`, `updated_at`) VALUES
(5, 'ER', 'Ear Rings', 1, '2026-03-02 13:52:03', '2026-03-02 13:52:03'),
(6, 'ET', 'Ear Tops', 1, '2026-03-02 13:52:03', '2026-03-02 13:52:03'),
(7, 'ED', 'Ear Dangler', 1, '2026-03-02 13:52:03', '2026-03-02 13:52:03'),
(8, 'EC', 'Ear Cuff', 1, '2026-03-02 13:52:03', '2026-03-02 13:52:03'),
(9, 'EB', 'Ear Bugadi', 1, '2026-03-02 13:52:03', '2026-03-02 13:52:03'),
(10, 'EH', 'Ear Hoops', 1, '2026-03-02 13:52:03', '2026-03-02 13:52:03'),
(11, 'SP', 'Second Piercing', 1, '2026-03-02 13:52:03', '2026-03-02 13:52:03'),
(12, 'TP', 'Third Piercing', 1, '2026-03-02 13:52:03', '2026-03-02 13:52:03'),
(13, 'EB', 'Ear Bali', 1, '2026-03-02 13:52:03', '2026-03-02 13:52:03'),
(14, 'JH', 'Jhumka', 1, '2026-03-02 13:52:03', '2026-03-02 13:52:03'),
(15, 'NP', 'Nose Pin', 1, '2026-03-02 13:52:03', '2026-03-02 13:52:03'),
(16, 'SP', 'Septum', 1, '2026-03-02 13:52:03', '2026-03-02 13:52:03'),
(17, 'NR', 'Nose Rings', 1, '2026-03-02 13:52:03', '2026-03-02 13:52:03'),
(18, 'NT', 'Nathni', 1, '2026-03-02 13:52:03', '2026-03-02 13:52:03'),
(19, 'PD', 'Pendant', 1, '2026-03-02 13:52:03', '2026-03-02 13:52:03'),
(20, 'PS', 'Pendant Sets', 1, '2026-03-02 13:52:03', '2026-03-02 13:52:03'),
(21, 'CH', 'Chokers', 1, '2026-03-02 13:52:03', '2026-03-02 13:52:03'),
(22, 'NK', 'Necklace', 1, '2026-03-02 13:52:03', '2026-03-02 13:52:03'),
(23, 'NC', 'Neck Chains', 1, '2026-03-02 13:52:03', '2026-03-02 13:52:03'),
(24, 'NT', 'Necklace Temple Designs', 1, '2026-03-02 13:52:03', '2026-03-02 13:52:03'),
(25, 'WR', 'Wrislet', 1, '2026-03-02 13:52:03', '2026-03-02 13:52:03'),
(26, 'BG', 'Bangles', 1, '2026-03-02 13:52:03', '2026-03-02 13:52:03'),
(27, 'BT', 'Bangles Temple Designs', 1, '2026-03-02 13:52:03', '2026-03-02 13:52:03'),
(28, 'FR', 'Finger Rings', 1, '2026-03-02 13:52:03', '2026-03-02 13:52:03'),
(29, 'CR', 'Cocktail Rings', 1, '2026-03-02 13:52:03', '2026-03-02 13:52:03'),
(30, 'TR', 'Temple Design Rings', 1, '2026-03-02 13:52:03', '2026-03-02 13:52:03'),
(31, 'DR', 'Designer Ring', 1, '2026-03-02 13:52:03', '2026-03-02 13:52:03'),
(32, 'FN', 'Finger Nails', 1, '2026-03-02 13:52:03', '2026-03-02 13:52:03'),
(33, 'HP', 'Hair Pin', 1, '2026-03-02 13:52:03', '2026-03-02 13:52:03'),
(34, 'BR', 'Brooch', 1, '2026-03-02 13:52:03', '2026-03-02 13:52:03'),
(35, 'TR', 'Toe Rings', 1, '2026-03-02 13:52:03', '2026-03-02 13:52:03'),
(36, 'AN', 'Anklets', 1, '2026-03-02 13:52:03', '2026-03-02 13:52:03'),
(37, 'PL', 'Payels', 1, '2026-03-02 13:52:03', '2026-03-02 13:52:03'),
(38, 'CB', 'Cuff Buttons', 1, '2026-03-02 13:52:03', '2026-03-02 13:52:03'),
(39, 'KB', 'Kurta Buttons', 1, '2026-03-02 13:52:03', '2026-03-02 13:52:03');

-- --------------------------------------------------------

--
-- Table structure for table `product_code_makers`
--

CREATE TABLE `product_code_makers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `prefix` varchar(255) NOT NULL,
  `makers_name` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_code_makers`
--

INSERT INTO `product_code_makers` (`id`, `prefix`, `makers_name`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'CH', 'Chiranjeet', 1, '2026-03-02 14:07:44', '2026-03-02 14:07:44'),
(2, 'DP', 'Dipak', 1, '2026-03-02 14:07:44', '2026-03-02 14:07:44'),
(3, 'JP', 'Jaipur', 1, '2026-03-02 14:07:44', '2026-03-02 14:07:44'),
(4, 'PR', 'Parekh', 1, '2026-03-02 14:07:44', '2026-03-02 14:07:44'),
(5, 'SK', 'Sukumar', 1, '2026-03-02 14:07:44', '2026-03-02 14:07:44');

-- --------------------------------------------------------

--
-- Table structure for table `product_complete_looks`
--

CREATE TABLE `product_complete_looks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `look_product_id` bigint(20) UNSIGNED NOT NULL,
  `position` tinyint(3) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_complete_looks`
--

INSERT INTO `product_complete_looks` (`id`, `product_id`, `look_product_id`, `position`, `created_at`, `updated_at`) VALUES
(1, 15, 14, 1, '2026-03-05 21:51:22', '2026-03-05 21:51:22'),
(2, 15, 5, 2, '2026-03-05 21:51:22', '2026-03-05 21:51:22'),
(3, 15, 10, 3, '2026-03-05 21:51:22', '2026-03-05 21:51:22'),
(4, 5, 14, 1, '2026-03-05 21:52:50', '2026-03-05 21:52:50'),
(5, 5, 15, 2, '2026-03-05 21:52:50', '2026-03-05 21:52:50'),
(6, 5, 6, 3, '2026-03-05 21:52:50', '2026-03-05 21:52:50');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `variant_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `variant_id`, `type`, `image`, `created_at`, `updated_at`) VALUES
(14, 15, NULL, 'product', 'products/mnJs0rou6P9tAHzmNpScG2tMPz3jmoH2Wcltcc2h.jpg', '2026-03-03 08:33:04', '2026-03-03 08:33:04'),
(15, 15, NULL, 'product', 'products/lUzQ29G4n1MoWk6fdSB2A3m7WuwoIzX2t0Mtnt7x.jpg', '2026-03-03 08:41:51', '2026-03-03 08:41:51'),
(16, 15, NULL, 'product', 'products/SpA0hVcHpdW3RuGr3hgVzvLo9yCwBzAIA14BMN4J.jpg', '2026-03-03 08:41:51', '2026-03-03 08:41:51'),
(21, 5, NULL, 'product', 'products/r6AizJGxgs8k7O4j8fyleLEouIAbQSeVZCtJ0479.png', '2026-03-05 20:01:59', '2026-03-05 20:01:59'),
(22, 5, NULL, 'product', 'products/tGs3m0tIjdZBUh6eJQn0QskpOAAYIsUYAEcEK3SC.png', '2026-03-05 20:01:59', '2026-03-05 20:01:59'),
(23, 5, NULL, 'product', 'products/tV70fK5bTpcBtoELCBlZerZO3g2o7dgRqaDY91dp.png', '2026-03-05 20:01:59', '2026-03-05 20:01:59'),
(24, 10, NULL, 'product', 'products/h0ds4HiSnCSdDmzzUq325rvvOwF4V63lthaYs7eO.png', '2026-03-05 21:45:07', '2026-03-05 21:45:07'),
(25, 10, NULL, 'product', 'products/z4V0ppxF9UKDEvwKg1fFgclV2rKUmih5nevjcXSi.png', '2026-03-05 21:45:07', '2026-03-05 21:45:07'),
(26, 10, NULL, 'product', 'products/U7ppVntMEvNRrHEiOOMgGnJi30NvNKXoGGUe07Pu.png', '2026-03-05 21:45:07', '2026-03-05 21:45:07'),
(27, 14, NULL, 'product', 'products/TcWcjnIEv1p2C2C0Pm5vv2zyaWKwm6mRZyVnE0vC.png', '2026-03-05 21:48:11', '2026-03-05 21:48:11'),
(28, 14, NULL, 'product', 'products/Jgrwcsi2O50UZ9B1IPEKAnz7PaLBFvLPYdPZ9GWF.png', '2026-03-05 21:48:11', '2026-03-05 21:48:11'),
(29, 14, NULL, 'product', 'products/ggnqYRswUbIPPTjJnERSlZoVgu2p8zcyQxg5Or4E.png', '2026-03-05 21:48:11', '2026-03-05 21:48:11'),
(30, 14, NULL, 'product', 'products/XsFygjZHDN9JUACAjtywdOrzBXnzDCwOooEmNLxv.png', '2026-03-05 21:48:11', '2026-03-05 21:48:11'),
(31, 13, NULL, 'product', 'products/Indjiw6xuNsErYAIHmWwW9Gyxaz3JPBergoumrHA.png', '2026-03-05 21:48:57', '2026-03-05 21:48:57'),
(32, 13, NULL, 'product', 'products/5EKSO0923O1UhnxFD4jdw8fd5izVxtZYS6XuYU8W.png', '2026-03-05 21:48:57', '2026-03-05 21:48:57'),
(33, 13, NULL, 'product', 'products/61hQGkHb3lzuiL1U8DJAhWkwjG63s6FzVEi8Mp89.png', '2026-03-05 21:48:57', '2026-03-05 21:48:57'),
(34, 6, NULL, 'product', 'products/QRoGXucqf00LFClwou35s4ug6FwYxB2VnwKD0AbJ.png', '2026-03-06 21:27:22', '2026-03-06 21:27:22'),
(35, 6, NULL, 'product', 'products/WA8MgKlBME44PTSDMarbKtrfJc4RwI6c4w7OJhiW.png', '2026-03-06 21:27:22', '2026-03-06 21:27:22'),
(36, 6, NULL, 'product', 'products/y8KJIQeHCVdrfyOlToxM6WLxUfDG2lcHacjnrZfA.png', '2026-03-06 21:27:22', '2026-03-06 21:27:22'),
(37, 12, NULL, 'product', 'products/5MwCjTFJNIw8nzl9PqTqMeOIIxfQaneOL1vX3dEL.png', '2026-03-08 07:51:52', '2026-03-08 07:51:52'),
(38, 12, NULL, 'product', 'products/4Z7pOvt4iFZsqpJfWLJCiiBbH66lIV4R3phP3KB3.jpg', '2026-03-08 07:51:52', '2026-03-08 07:51:52'),
(39, 12, NULL, 'product', 'products/RScAdmNcuN7pu74EaNvhU8eKXUOOCCbrPEuGYSJ8.png', '2026-03-08 07:51:52', '2026-03-08 07:51:52'),
(40, 11, NULL, 'product', 'products/kZ1LNBSMByZPsldzGF4MHxybrtxWYkVlUiqeL3mX.png', '2026-03-08 07:52:13', '2026-03-08 07:52:13'),
(41, 11, NULL, 'product', 'products/mbehkLGtchZ1sokWzBwOEJMa6OTuAQkIj5oNvbPW.png', '2026-03-08 07:52:13', '2026-03-08 07:52:13'),
(42, 11, NULL, 'product', 'products/9s12IRSviZl6zC9PVvi1V7iCmyAHJclTOclfr5cZ.png', '2026-03-08 07:52:13', '2026-03-08 07:52:13'),
(43, 9, NULL, 'product', 'products/EXWVwSszL7EmR5VUjHvpqYWXsSCrqTOHInvnQmgj.png', '2026-03-08 07:52:31', '2026-03-08 07:52:31'),
(44, 9, NULL, 'product', 'products/8H1nmRQXQxq7Dh9Zpn73LiktOL7HrINBdhx6ea3z.jpg', '2026-03-08 07:52:31', '2026-03-08 07:52:31'),
(45, 9, NULL, 'product', 'products/lHlJrmeyFYm1PV1vLL3Ci0ThpPGAXVLlyrMUzf2F.png', '2026-03-08 07:52:31', '2026-03-08 07:52:31'),
(46, 8, NULL, 'product', 'products/iNQPIMkcBCiMkkxXNpxW2QnjF5lZAevI7Cm6JK9t.png', '2026-03-08 07:52:53', '2026-03-08 07:52:53'),
(47, 8, NULL, 'product', 'products/l7ljgAe10Is92VVofPd9DhHXc6GvCvaY1V0Jl3S6.png', '2026-03-08 07:52:53', '2026-03-08 07:52:53'),
(48, 8, NULL, 'product', 'products/w7yuGTnuEwpRp5vyHrS3BIfyVyxzI2boRxtyH99O.png', '2026-03-08 07:52:53', '2026-03-08 07:52:53'),
(49, 7, NULL, 'product', 'products/9LqJPc6g6Q4AjjePw8vQIMYf06XAjxkTXvEPqOo5.png', '2026-03-08 07:53:12', '2026-03-08 07:53:12'),
(50, 7, NULL, 'product', 'products/3gcWph2F8f5Cf6P4BGUPhiRl7BPLuFh9NVgY8nbZ.png', '2026-03-08 07:53:12', '2026-03-08 07:53:12'),
(51, 7, NULL, 'product', 'products/MWVLLZN9O3vFyI9uPLounAVSQn9m09B4PCsfJhkT.png', '2026-03-08 07:53:12', '2026-03-08 07:53:12');

-- --------------------------------------------------------

--
-- Table structure for table `product_similar_items`
--

CREATE TABLE `product_similar_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `similar_product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_similar_items`
--

INSERT INTO `product_similar_items` (`id`, `product_id`, `similar_product_id`, `created_at`, `updated_at`) VALUES
(1, 5, 10, '2026-03-05 21:46:18', '2026-03-05 21:46:18'),
(2, 5, 14, '2026-03-05 21:52:26', '2026-03-05 21:52:26'),
(3, 5, 15, '2026-03-05 21:52:27', '2026-03-05 21:52:27');

-- --------------------------------------------------------

--
-- Table structure for table `product_variants`
--

CREATE TABLE `product_variants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_code` varchar(255) NOT NULL,
  `polish_type_id` bigint(20) UNSIGNED DEFAULT NULL,
  `stone_type_id` bigint(20) UNSIGNED DEFAULT NULL,
  `pearl_type_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity` decimal(12,3) NOT NULL DEFAULT 0.000,
  `base_price` decimal(12,2) NOT NULL DEFAULT 0.00,
  `discount_price` decimal(12,2) DEFAULT NULL,
  `cgst` decimal(12,2) DEFAULT NULL,
  `sgst` decimal(12,2) DEFAULT NULL,
  `weight` decimal(12,3) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_variants`
--

INSERT INTO `product_variants` (`id`, `product_id`, `product_code`, `polish_type_id`, `stone_type_id`, `pearl_type_id`, `quantity`, `base_price`, `discount_price`, `cgst`, `sgst`, `weight`, `created_at`, `updated_at`) VALUES
(1, 4, 'VRN-6DDC8C2A', 2, 3, 1, 2.000, 2.00, 2.00, 2.00, 2.00, 2.000, '2026-02-22 01:11:00', '2026-02-22 06:37:07');

-- --------------------------------------------------------

--
-- Table structure for table `promo_strips`
--

CREATE TABLE `promo_strips` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `promo_strips`
--

INSERT INTO `promo_strips` (`id`, `title`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'EASY EXCHANGE', 1, '2026-02-28 22:58:23', '2026-02-28 22:58:23'),
(2, 'PREMIUM JEWELRY', 1, '2026-02-28 22:58:29', '2026-02-28 22:58:29'),
(3, 'FREE SHIPPING', 1, '2026-02-28 22:58:36', '2026-02-28 22:58:36'),
(4, 'LIFETIME WARRANTY', 1, '2026-02-28 22:58:43', '2026-02-28 22:58:43');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `rating` int(11) NOT NULL DEFAULT 5,
  `message` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `product_id`, `name`, `title`, `rating`, `message`, `created_at`, `updated_at`) VALUES
(1, NULL, 5, 'Anshuman Majumder', 'Test', 4, 'dffdf', '2026-03-06 22:20:22', '2026-03-06 22:20:22'),
(2, NULL, 5, 'Yoewasdsfssf', 'dsdsd', 4, 'dfsfsdf', '2026-03-06 22:21:29', '2026-03-06 22:21:29'),
(3, NULL, 5, 'Heello user', 'title', 4, 'Review', '2026-03-07 08:52:04', '2026-03-07 08:52:04'),
(4, NULL, 15, 'Tesy', 'gfd', 4, 'dfgdgfdgf', '2026-03-08 07:18:10', '2026-03-08 07:18:10'),
(5, NULL, 14, 'Saul Goodman', 'Good', 3, 'Good products', '2026-03-13 21:50:56', '2026-03-13 21:50:56');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shop_by_life_styles`
--

CREATE TABLE `shop_by_life_styles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shop_by_life_styles`
--

INSERT INTO `shop_by_life_styles` (`id`, `name`, `image`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'image1', 'shop-by-life-styles/VWa7BLyXX8JmwlRtd4zTxCV2TSNIycNeUB7VevBH.jpg', 1, '2026-03-01 00:16:15', '2026-03-01 00:16:15'),
(2, 'image2', 'shop-by-life-styles/5igKiqPN6aoWpgqeHpU4oaLjtUYd32kj1tg5BAQu.jpg', 1, '2026-03-01 00:16:31', '2026-03-01 00:16:31'),
(3, 'image3', 'shop-by-life-styles/trAApQNnXZ7G0fj4FGEyrkKcT33Jp140nFkHm49T.jpg', 1, '2026-03-01 00:16:41', '2026-03-01 00:16:41'),
(4, 'image4', 'shop-by-life-styles/bH0nBb4qovHvz3x6lRTTS1UnOH2ac7E26oSZHypZ.jpg', 1, '2026-03-01 00:16:58', '2026-03-01 00:16:58'),
(5, 'image5', 'shop-by-life-styles/2wxBuvylyr2vNLXfLsK4THVyqCNkOIVOh9Mq7UuJ.jpg', 1, '2026-03-01 00:17:16', '2026-03-01 00:17:16'),
(6, 'image6', 'shop-by-life-styles/XsEfoCrRBqjqPR8pA2WhMeL04WOlgCXKu21HHq4E.jpg', 1, '2026-03-01 00:17:52', '2026-03-01 00:17:52'),
(7, 'image7', 'shop-by-life-styles/8iqFadykwih3yLZ2Ya2plaH5tKe95KgSlkpi0Ika.jpg', 1, '2026-03-01 00:18:13', '2026-03-01 00:18:13'),
(8, 'image8', 'shop-by-life-styles/ixx6AXf7mIbp0DIriVgjTAbTBfchqnqnV3hREvN2.jpg', 1, '2026-03-01 00:18:28', '2026-03-01 00:18:28'),
(9, 'image9', 'shop-by-life-styles/aJKlO5ar08IBJgBe9uUiSckX7XjBScIZVklq4XbE.jpg', 1, '2026-03-01 00:18:52', '2026-03-01 00:18:52'),
(10, 'image10', 'shop-by-life-styles/VnkHQfE1aoNZscXeJl6ZIYfSnLBeX6kiZxuSsmVI.jpg', 1, '2026-03-01 00:19:23', '2026-03-01 00:19:23');

-- --------------------------------------------------------

--
-- Table structure for table `shop_the_looks`
--

CREATE TABLE `shop_the_looks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shop_the_looks`
--

INSERT INTO `shop_the_looks` (`id`, `title`, `image`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Summer Look', 'shop-the-looks/SW1qCHGPR1cCILOMSNPOUgkDrT9Ylf0bhKJGA4IB.jpg', 1, '2026-03-03 20:45:50', '2026-03-03 20:45:50');

-- --------------------------------------------------------

--
-- Table structure for table `shop_the_look_hotspots`
--

CREATE TABLE `shop_the_look_hotspots` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shop_the_look_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `x_coordinate` double NOT NULL,
  `y_coordinate` double NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shop_the_look_hotspots`
--

INSERT INTO `shop_the_look_hotspots` (`id`, `shop_the_look_id`, `product_id`, `x_coordinate`, `y_coordinate`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, 6, 36.41, 41.6, 1, '2026-03-03 20:49:54', '2026-03-03 20:52:25'),
(2, 1, 7, 54.78, 80.96, 1, '2026-03-03 20:52:15', '2026-03-03 20:52:15'),
(3, 1, 7, 78.23, 91.38, 1, '2026-03-08 03:53:04', '2026-03-08 03:53:04'),
(4, 1, 9, 41.29, 26.92, 1, '2026-03-08 12:18:53', '2026-03-08 12:18:53');

-- --------------------------------------------------------

--
-- Table structure for table `static_pages`
--

CREATE TABLE `static_pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(255) NOT NULL,
  `hero_title` varchar(255) DEFAULT NULL,
  `hero_subtitle` varchar(255) DEFAULT NULL,
  `hero_tag` varchar(255) DEFAULT NULL,
  `hero_image` varchar(255) DEFAULT NULL,
  `sections` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`sections`)),
  `stats` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`stats`)),
  `cta_title` varchar(255) DEFAULT NULL,
  `cta_subtitle` varchar(255) DEFAULT NULL,
  `cta_button_text` varchar(255) DEFAULT NULL,
  `cta_button_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `static_pages`
--

INSERT INTO `static_pages` (`id`, `slug`, `hero_title`, `hero_subtitle`, `hero_tag`, `hero_image`, `sections`, `stats`, `cta_title`, `cta_subtitle`, `cta_button_text`, `cta_button_url`, `created_at`, `updated_at`) VALUES
(1, 'about-us', 'Our Story', 'Rooted in craft. Worn with intention.', 'Our Commitment', 'static-pages/Id5DvkNH4oOtKhEAGsAEb2noednQLspRSjd4OJKM.png', '[{\"type\":\"intro\",\"eyebrow\":\"Who we are\",\"heading\":\"Jewellery that carries a culture forward\",\"body\":\"Ethnicoast was born from a simple belief \\u2014 that heritage jewellery shouldn\'t live only in glass cases.\\n\\nEvery piece we create draws from centuries-old craft traditions, reimagined for the modern wardrobe.\\n\\nFrom the hands that shape the metal to the moment it reaches you, care is the thread that runs through everything we do.\",\"image\":null},{\"type\":\"timeline\",\"heading\":\"How We Grew\",\"eyebrow\":\"Our journey\",\"items\":[{\"year\":\"2018\",\"title\":\"The Beginning\",\"body\":\"Started as a small passion project in a living room, sourcing directly from artisans in Rajasthan.\"},{\"year\":\"2020\",\"title\":\"Going Online\",\"body\":\"Launched our digital storefront and shipped our first 500 orders across India.\"},{\"year\":\"2022\",\"title\":\"Community First\",\"body\":\"Partnered with 30+ artisan families, introduced the lifetime plating guarantee.\"},{\"year\":\"2024\",\"title\":\"10,000 Smiles\",\"body\":\"Crossed 10,000 customers and expanded to 500+ unique designs.\"}]},{\"type\":\"team\",\"heading\":\"Meet the Team\",\"eyebrow\":\"The people\",\"items\":[{\"name\":\"Priya Sharma\",\"role\":\"Founder & Creative Director\",\"image\":null},{\"name\":\"Ravi Menon\",\"role\":\"Head of Artisan Relations\",\"image\":null},{\"name\":\"Anjali Bose\",\"role\":\"Customer Experience Lead\",\"image\":null}]},{\"type\":\"values\",\"heading\":\"Our Values\",\"eyebrow\":\"What we stand for\",\"items\":[{\"icon\":\"fa-solid fa-hands\",\"title\":\"Handcrafted Always\",\"body\":\"Every piece is made by skilled artisan hands \\u2014 never mass-produced.\"},{\"icon\":\"fa-solid fa-leaf\",\"title\":\"Responsible Sourcing\",\"body\":\"We choose materials and partners who share our commitment to people and the planet.\"},{\"icon\":\"fa-solid fa-heart\",\"title\":\"Community First\",\"body\":\"Fair wages, long-term partnerships, and real stories behind every piece we sell.\"}]}]', '[{\"num\":\"10K+\",\"label\":\"Happy Customers\"},{\"num\":\"500+\",\"label\":\"Unique Designs\"},{\"num\":\"50+\",\"label\":\"Artisan Families\"},{\"num\":\"6+\",\"label\":\"Years of Craft\"}]', 'Find your piece of the story', 'Explore our latest collections, each one rooted in craft.', 'Shop Now', '/collection', '2026-03-22 07:23:46', '2026-03-22 20:16:58'),
(2, 'why-us', 'Why Choose Us', 'Not all jewellery is made equal. Here\'s what sets us apart.', 'The Ethnicoast difference', 'static-pages/lKpoeuGmD2J20VQll75mMmQSLPGU4zJoSfxvosZf.png', '[{\"type\":\"pillars\",\"heading\":\"Built on Three Things\",\"eyebrow\":\"Our pillars\",\"items\":[{\"num\":\"01\",\"icon\":\"fa-solid fa-gem\",\"title\":\"Quality Without Compromise\",\"body\":\"We use only high-grade base metals with thick plating. Every piece passes a 7-point quality check.\"},{\"num\":\"02\",\"icon\":\"fa-solid fa-hands-holding-heart\",\"title\":\"Artisan-Made, Always\",\"body\":\"We partner directly with skilled artisan families. No middlemen, no factories.\"},{\"num\":\"03\",\"icon\":\"fa-solid fa-shield-halved\",\"title\":\"Unmatched After-Care\",\"body\":\"Free lifetime plating. 30-day easy exchanges. 9-to-5 customer support.\"}]},{\"type\":\"compare\",\"heading\":\"Ethnicoast vs The Rest\",\"eyebrow\":\"See the difference\",\"items\":[{\"feature\":\"Free Lifetime Plating\",\"us\":true,\"them\":false},{\"feature\":\"Direct Artisan Sourcing\",\"us\":true,\"them\":false},{\"feature\":\"7-Point Quality Check\",\"us\":true,\"them\":false},{\"feature\":\"30-Day Easy Exchange\",\"us\":true,\"them\":false},{\"feature\":\"Real Customer Support\",\"us\":true,\"them\":\"Sometimes\"},{\"feature\":\"Transparent Pricing\",\"us\":true,\"them\":\"Varies\"}]},{\"type\":\"promises\",\"heading\":\"What We Promise You\",\"eyebrow\":\"Our commitments\",\"items\":[{\"icon\":\"fa-solid fa-spray-can-sparkles\",\"title\":\"Free Lifetime Plating\",\"body\":\"We re-plate it free of charge, for life. No fine print.\"},{\"icon\":\"fa-solid fa-rotate-left\",\"title\":\"30-Day Easy Exchange\",\"body\":\"Exchange within 30 days, no questions asked.\"},{\"icon\":\"fa-solid fa-truck-fast\",\"title\":\"Free Shipping, Always\",\"body\":\"Every order ships free across India.\"},{\"icon\":\"fa-solid fa-headset\",\"title\":\"Real Human Support\",\"body\":\"Our team is reachable 9am\\u20135pm, 7 days a week.\"}]},{\"type\":\"testimonials\",\"heading\":\"Don\'t Take Our Word for It\",\"eyebrow\":\"What customers say\",\"items\":[{\"stars\":5,\"quote\":\"The quality is unlike anything I\'ve found at this price point.\",\"author\":\"Meera R., Bangalore\"},{\"stars\":5,\"quote\":\"Their exchange process was so smooth. Rare to find this kind of service.\",\"author\":\"Sunita K., Delhi\"},{\"stars\":5,\"quote\":\"Knowing my purchase supports artisan families makes wearing it feel even better.\",\"author\":\"Aisha P., Mumbai\"}]}]', NULL, 'Ready to experience the difference?', 'Shop our full collection and find something made just for you.', 'Explore Collection', '/collection', '2026-03-22 07:23:46', '2026-03-22 20:24:19'),
(3, 'chat-with-us', 'Chat With Us', 'Whether it\'s a question, a custom request, or just a hello — we\'d love to hear from you.', 'We\'re here for you', 'static-pages/rh1XZmS9vBf6KM1cAqQgxIVplTOv2KrxJjby31Z7.png', '[{\"type\":\"channels\",\"heading\":\"Choose How to Reach Us\",\"eyebrow\":\"Get in touch\",\"items\":[{\"icon\":\"fa-brands fa-whatsapp\",\"title\":\"WhatsApp\",\"hours\":\"Mon\\u2013Sun, 9am\\u20136pm\",\"body\":\"The fastest way to reach us. Reply within minutes during business hours.\",\"btn_text\":\"Chat on WhatsApp\",\"btn_url\":\"https:\\/\\/wa.me\\/919XXXXXXXXX\"},{\"icon\":\"fa-solid fa-envelope\",\"title\":\"Email Us\",\"hours\":\"Response within 24 hrs\",\"body\":\"For detailed queries, orders, or feedback. We read every email personally.\",\"btn_text\":\"Send an Email\",\"btn_url\":\"mailto:hello@ethnicoast.com\"},{\"icon\":\"fa-brands fa-instagram\",\"title\":\"Instagram DM\",\"hours\":\"Mon\\u2013Sat, 10am\\u20135pm\",\"body\":\"Drop us a DM. We\'re happy to share styling tips and upcoming launches.\",\"btn_text\":\"Message on Instagram\",\"btn_url\":\"https:\\/\\/instagram.com\\/ethnicoast\"}]},{\"type\":\"faq\",\"heading\":\"Frequently Asked\",\"eyebrow\":\"Common questions\",\"items\":[{\"q\":\"How long does delivery take?\",\"a\":\"Most orders are dispatched within 1\\u20132 business days and delivered within 3\\u20135 business days.\"},{\"q\":\"What is the free lifetime plating promise?\",\"a\":\"If your jewellery loses its shine, send it back and we\'ll re-plate it free \\u2014 for life.\"},{\"q\":\"How do I initiate an exchange?\",\"a\":\"WhatsApp or email us within 30 days with your order number. We\'ll arrange a pickup.\"},{\"q\":\"Do you accept custom orders?\",\"a\":\"Yes! Share your reference over WhatsApp or email and we\'ll revert with a quote in 48 hours.\"},{\"q\":\"Is COD available?\",\"a\":\"COD is available for orders up to \\u20b92,000 in select pincodes.\"}]},{\"type\":\"contact_info\",\"heading\":\"Send a Message\",\"eyebrow\":\"Write to us\",\"body\":\"Fill in the form and the right person on our team will get back to you within 24 hours.\",\"email\":\"hello@ethnicoast.com\",\"whatsapp\":\"+91 9330613955\",\"hours\":\"Mon\\u2013Sun, 9am\\u20136pm\",\"form_route\":\"frontend.contact.store\"}]', '{\"num\":\"10K+\",\"label\":\"Happy Customers\"}', NULL, NULL, NULL, NULL, '2026-03-22 07:23:46', '2026-03-22 20:32:14'),
(4, 'animal-welfare', 'Animal Welfare', 'We believe beautiful jewellery should never come at an animal\'s expense. Ever.', 'Our Commitment', 'static-pages/o98m2tcBxTiIdRUtxe3Pt8RbnDg8OCURnI5yVdNq.png', '[{\"type\":\"statement\",\"heading\":\"100% Cruelty Free\",\"eyebrow\":\"Where we stand\",\"body\":\"Every material we use, every supplier we work with, and every design we create follows one rule: no animal is harmed.\\n\\nThis isn\'t a trend for us \\u2014 it\'s been a founding principle since day one.\",\"big_quote\":\"\\\"Style should never ask anything of the natural world that it cannot willingly give.\\\"\",\"body2\":\"From the stones we source to the packaging we ship in, every decision is made with animals, artisans, and the earth in mind.\"},{\"type\":\"commitments\",\"heading\":\"Our Commitments\",\"eyebrow\":\"What this means in practice\",\"items\":[{\"num\":\"01\",\"title\":\"No Animal-Derived Materials\",\"body\":\"We use zero ivory, bone, horn, shell, fur, leather, or any other material sourced from animals.\"},{\"num\":\"02\",\"title\":\"Lab-Created Stones Only\",\"body\":\"Where gemstones are used, we source lab-grown or ethically mined mineral alternatives.\"},{\"num\":\"03\",\"title\":\"Supply Chain Audits\",\"body\":\"We visit and audit our artisan partners at least once a year. No audit, no partnership.\"},{\"num\":\"04\",\"title\":\"Cruelty-Free Packaging\",\"body\":\"Our boxes and pouches are made from recycled, plant-based, or sustainably harvested materials.\"}]},{\"type\":\"feature_split\",\"eyebrow\":\"Beyond materials\",\"heading\":\"Giving Back to the Wild\",\"body\":\"For every 100 orders placed, we donate to wildlife conservation efforts in India.\\n\\nWe also choose shipping partners who have committed to carbon-neutral last-mile delivery routes.\\n\\nThis is not charity. It is accountability.\",\"image\":null},{\"type\":\"certifications\",\"heading\":\"Verified & Committed\",\"eyebrow\":\"Our standards\",\"items\":[{\"icon\":\"fa-solid fa-certificate\",\"title\":\"PETA Approved\",\"body\":\"Recognized by PETA as free from animal testing and animal-derived ingredients.\"},{\"icon\":\"fa-solid fa-leaf\",\"title\":\"Vegan Verified\",\"body\":\"All materials used are certified vegan \\u2014 no silk, lac, beeswax, or shell.\"},{\"icon\":\"fa-solid fa-shield-halved\",\"title\":\"Ethical Sourcing\",\"body\":\"Supplier code of conduct includes animal welfare clauses backed by annual review.\"}]}]', '[{\"icon\":\"fa-solid fa-paw\",\"label\":\"Status\",\"value\":\"100% Cruelty Free\"},{\"icon\":\"fa-solid fa-seedling\",\"label\":\"Materials\",\"value\":\"Zero Animal-Derived\"},{\"icon\":\"fa-solid fa-recycle\",\"label\":\"Packaging\",\"value\":\"Eco-Conscious\"},{\"icon\":\"fa-solid fa-earth-asia\",\"label\":\"Giving Back\",\"value\":\"Wildlife Donations\"}]', 'Wear your values', 'Every piece you buy is a choice that doesn\'t cost the earth — or the creatures on it.', 'Shop Cruelty-Free', '/collection', '2026-03-22 07:23:46', '2026-03-22 07:54:51');

-- --------------------------------------------------------

--
-- Table structure for table `stone_types`
--

CREATE TABLE `stone_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `display_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stone_types`
--

INSERT INTO `stone_types` (`id`, `name`, `display_order`, `is_active`, `created_at`, `updated_at`) VALUES
(2, 'Amethyst', 0, 1, '2026-02-22 00:03:18', '2026-02-22 00:03:18'),
(3, 'Topaz', 0, 1, '2026-02-22 00:03:25', '2026-02-22 00:03:25'),
(4, 'Sapphire', 0, 1, '2026-02-22 00:03:32', '2026-02-22 00:03:32'),
(5, 'Emerald', 0, 1, '2026-02-22 00:03:39', '2026-02-22 00:03:55');

-- --------------------------------------------------------

--
-- Table structure for table `tab_categories`
--

CREATE TABLE `tab_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `display_order` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tab_categories`
--

INSERT INTO `tab_categories` (`id`, `name`, `slug`, `is_active`, `display_order`, `created_at`, `updated_at`) VALUES
(9, 'EAR RINGS', 'ear-rings', 1, '', '2026-02-26 20:30:37', '2026-02-26 20:30:37'),
(10, 'NECK PIECES', 'neck-pieces', 1, '', '2026-02-26 20:30:37', '2026-02-26 20:30:37'),
(11, 'WRISTLETS', 'wristlets', 1, '', '2026-02-26 20:30:37', '2026-02-26 20:30:37'),
(12, 'RINGS', 'rings', 1, '', '2026-02-26 20:30:37', '2026-02-26 20:30:37'),
(13, 'ALL JEWELLERY', 'all-jewellery', 1, '', '2026-02-26 20:30:37', '2026-02-26 20:30:37'),
(14, 'ETTHNICOAST EXCLUSIVE', 'etthnicoast-exclusive', 1, '', '2026-02-26 20:30:37', '2026-02-26 20:30:37'),
(15, 'NEW ARRIVAL', 'new-arrival', 1, '', '2026-02-26 20:30:37', '2026-02-26 20:30:37');

-- --------------------------------------------------------

--
-- Table structure for table `tab_category_product`
--

CREATE TABLE `tab_category_product` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tab_category_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `display_order` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tab_category_product`
--

INSERT INTO `tab_category_product` (`id`, `tab_category_id`, `product_id`, `display_order`, `created_at`, `updated_at`) VALUES
(1, 9, 7, '', NULL, NULL),
(2, 9, 15, '', NULL, NULL),
(3, 9, 14, '', NULL, NULL),
(4, 9, 13, '', NULL, NULL),
(5, 10, 8, '', NULL, NULL),
(6, 10, 5, '', NULL, NULL),
(7, 10, 11, '', NULL, NULL),
(8, 11, 9, '', NULL, NULL),
(9, 11, 6, '', NULL, NULL),
(11, 12, 5, '', NULL, NULL),
(12, 12, 11, '', NULL, NULL),
(13, 12, 10, '', NULL, NULL),
(14, 13, 11, '', NULL, NULL),
(15, 13, 10, '', NULL, NULL),
(16, 14, 9, '', NULL, NULL),
(17, 14, 13, '', NULL, NULL),
(18, 14, 7, '', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tab_sub_categories`
--

CREATE TABLE `tab_sub_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `display_order` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tab_sub_categories`
--

INSERT INTO `tab_sub_categories` (`id`, `category_id`, `name`, `slug`, `is_active`, `display_order`, `created_at`, `updated_at`) VALUES
(38, 9, 'Ear tops', 'ear-tops', 1, '', '2026-02-26 20:30:37', '2026-02-26 20:30:37'),
(39, 9, 'Ear danglers', 'ear-danglers', 1, '', '2026-02-26 20:30:37', '2026-02-26 20:30:37'),
(40, 9, 'Ear hoops', 'ear-hoops', 1, '', '2026-02-26 20:30:37', '2026-02-26 20:30:37'),
(41, 9, 'Ear cuffs', 'ear-cuffs', 1, '', '2026-02-26 20:30:37', '2026-02-26 20:30:37'),
(42, 9, 'Ear jhumkas', 'ear-jhumkas', 1, '', '2026-02-26 20:30:37', '2026-02-26 20:30:37'),
(43, 9, 'Second piercing', 'second-piercing', 1, '', '2026-02-26 20:30:37', '2026-02-26 20:30:37'),
(44, 9, 'Third piercing', 'third-piercing', 1, '', '2026-02-26 20:30:37', '2026-02-26 20:30:37'),
(45, 9, 'Bugadi', 'bugadi', 1, '', '2026-02-26 20:30:37', '2026-02-26 20:30:37'),
(46, 10, 'Pendant/pendant set', 'pendantpendant-set', 1, '', '2026-02-26 20:30:37', '2026-02-26 20:30:37'),
(47, 10, 'Neckless', 'neckless', 1, '', '2026-02-26 20:30:37', '2026-02-26 20:30:37'),
(48, 10, 'Chokers', 'chokers', 1, '', '2026-02-26 20:30:37', '2026-02-26 20:30:37'),
(49, 10, 'Bridal neck pieces', 'bridal-neck-pieces', 1, '', '2026-02-26 20:30:37', '2026-02-26 20:30:37'),
(50, 12, 'Finger ring', 'finger-ring', 1, '', '2026-02-26 20:30:37', '2026-02-26 20:30:37'),
(51, 12, 'Toe ring', 'toe-ring', 1, '', '2026-02-26 20:30:37', '2026-02-26 20:30:37'),
(52, 13, 'EAR RINGS', 'ear-rings', 1, '', '2026-02-26 20:30:37', '2026-02-26 20:30:37'),
(53, 13, 'JHUMKAS', 'jhumkas', 1, '', '2026-02-26 20:30:37', '2026-02-26 20:30:37'),
(54, 13, 'NECK PIECES', 'neck-pieces', 1, '', '2026-02-26 20:30:37', '2026-02-26 20:30:37'),
(55, 13, 'NOSE PINS', 'nose-pins', 1, '', '2026-02-26 20:30:37', '2026-02-26 20:30:37'),
(56, 13, 'BANGLES', 'bangles', 1, '', '2026-02-26 20:30:37', '2026-02-26 20:30:37'),
(57, 13, 'WRISTLETS', 'wristlets', 1, '', '2026-02-26 20:30:37', '2026-02-26 20:30:37'),
(58, 13, 'FINGER RINGS', 'finger-rings', 1, '', '2026-02-26 20:30:37', '2026-02-26 20:30:37'),
(59, 13, 'COCKTAIL RINGS', 'cocktail-rings', 1, '', '2026-02-26 20:30:37', '2026-02-26 20:30:37'),
(60, 13, 'ANKLETS', 'anklets', 1, '', '2026-02-26 20:30:37', '2026-02-26 20:30:37'),
(61, 13, 'PAYELS', 'payels', 1, '', '2026-02-26 20:30:37', '2026-02-26 20:30:37'),
(62, 13, 'TOE RINGS', 'toe-rings', 1, '', '2026-02-26 20:30:37', '2026-02-26 20:30:37'),
(63, 13, 'HAIR PINS', 'hair-pins', 1, '', '2026-02-26 20:30:37', '2026-02-26 20:30:37'),
(64, 14, 'ETHNIC', 'ethnic', 1, '', '2026-02-26 20:30:37', '2026-02-26 20:30:37'),
(65, 14, 'ELEGANCE', 'elegance', 1, '', '2026-02-26 20:30:37', '2026-02-26 20:30:37'),
(66, 14, 'WEDDING WAVES', 'wedding-waves', 1, '', '2026-02-26 20:30:37', '2026-02-26 20:30:37'),
(67, 14, 'GLOW & GLITTERS', 'glow-glitters', 1, '', '2026-02-26 20:30:37', '2026-02-26 20:30:37'),
(68, 14, 'PARTY', 'party', 1, '', '2026-02-26 20:30:37', '2026-02-26 20:30:37'),
(69, 14, 'MINIMALISTIC', 'minimalistic', 1, '', '2026-02-26 20:30:37', '2026-02-26 20:30:37'),
(70, 14, 'INDULGENCE', 'indulgence', 1, '', '2026-02-26 20:30:37', '2026-02-26 20:30:37'),
(71, 16, 'About Us', 'about-us', 1, '', '2026-02-26 20:30:37', '2026-02-26 20:30:37'),
(72, 16, 'Why Us', 'why-us', 1, '', '2026-02-26 20:30:37', '2026-02-26 20:30:37'),
(73, 16, 'Chat with us', 'chat-with-us', 1, '', '2026-02-26 20:30:37', '2026-02-26 20:30:37'),
(74, 16, 'Animal Welfare', 'animal-welfare', 1, '', '2026-02-26 20:30:37', '2026-02-26 20:30:37');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `join_date` varchar(255) DEFAULT NULL,
  `last_login` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `role_name` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `line_manager` varchar(255) DEFAULT NULL,
  `seconde_line_manager` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `user_id`, `email`, `join_date`, `last_login`, `phone_number`, `status`, `role_name`, `avatar`, `position`, `department`, `line_manager`, `seconde_line_manager`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Anshuman Majumder', 'KH-0001', 'admin@example.com', 'Thu, Feb 19, 2026 1:33 AM', '2026-03-23 01:46:11', NULL, 'Active', 'User', NULL, NULL, NULL, NULL, NULL, NULL, '$2y$12$2XVWpOVNpW6nyQVCWWRPTORFx9o7A/fYNkfwOZWxY/0xuiv.1amsm', NULL, '2026-02-18 20:03:21', '2026-03-22 20:16:11'),
(2, 'Anshuman Majumder', 'ETHAE597HRW', 'user1@gmail.com', '2026-03-08', '2026-03-23 02:04:52', '9899889988', 'active', 'etthnicoast_user', NULL, NULL, NULL, NULL, NULL, NULL, '$2y$12$MvjXGCWIPlDBxRmUozwyzOwlmOJ/Xn4QOcIdvX00yRC3WLgAEaQUy', 'OT02DEPwttjh29kTZG1BtBNRZ4MJ30AXImRxBNPNZ04nICRyow82WmsobCp6', '2026-03-08 01:19:18', '2026-03-22 20:34:52');

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wishlists`
--

INSERT INTO `wishlists` (`id`, `user_id`, `product_id`, `created_at`, `updated_at`) VALUES
(4, 2, 10, '2026-03-15 06:05:58', '2026-03-15 06:05:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category_types`
--
ALTER TABLE `category_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `collection_ranges`
--
ALTER TABLE `collection_ranges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `etthnicoast_worlds`
--
ALTER TABLE `etthnicoast_worlds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `home_customer_reviews`
--
ALTER TABLE `home_customer_reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `home_page_banner_setups`
--
ALTER TABLE `home_page_banner_setups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoices_invoice_number_unique` (`invoice_number`);

--
-- Indexes for table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jewellery_in_motions`
--
ALTER TABLE `jewellery_in_motions`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_code_unique` (`order_code`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_tax_details`
--
ALTER TABLE `order_tax_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_tax_details_order_id_foreign` (`order_id`),
  ADD KEY `order_tax_details_invoice_id_foreign` (`invoice_id`),
  ADD KEY `order_tax_details_product_id_foreign` (`product_id`);

--
-- Indexes for table `our_best_sellers`
--
ALTER TABLE `our_best_sellers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `our_valued_partners`
--
ALTER TABLE `our_valued_partners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pearl_types`
--
ALTER TABLE `pearl_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pearl_types_name_unique` (`name`);

--
-- Indexes for table `polish_types`
--
ALTER TABLE `polish_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `polish_types_name_unique` (`name`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_product_code_unique` (`product_code`),
  ADD KEY `products_stone_type_id_index` (`stone_type_id`),
  ADD KEY `products_pearl_type_id_index` (`pearl_type_id`),
  ADD KEY `products_polish_type_id_index` (`polish_type_id`),
  ADD KEY `products_category_id_index` (`category_id`);

--
-- Indexes for table `product_code_emblishments`
--
ALTER TABLE `product_code_emblishments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_code_finishings`
--
ALTER TABLE `product_code_finishings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_code_item_details`
--
ALTER TABLE `product_code_item_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_code_makers`
--
ALTER TABLE `product_code_makers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_complete_looks`
--
ALTER TABLE `product_complete_looks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_images_product_id_index` (`product_id`),
  ADD KEY `id` (`variant_id`);

--
-- Indexes for table `product_similar_items`
--
ALTER TABLE `product_similar_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_variants_product_code_unique` (`product_code`),
  ADD KEY `product_variants_product_id_index` (`product_id`),
  ADD KEY `product_variants_polish_type_id_index` (`polish_type_id`),
  ADD KEY `product_variants_stone_type_id_index` (`stone_type_id`),
  ADD KEY `product_variants_pearl_type_id_index` (`pearl_type_id`);

--
-- Indexes for table `promo_strips`
--
ALTER TABLE `promo_strips`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `shop_by_life_styles`
--
ALTER TABLE `shop_by_life_styles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shop_the_looks`
--
ALTER TABLE `shop_the_looks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shop_the_look_hotspots`
--
ALTER TABLE `shop_the_look_hotspots`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `static_pages`
--
ALTER TABLE `static_pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `static_pages_slug_unique` (`slug`);

--
-- Indexes for table `stone_types`
--
ALTER TABLE `stone_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `stone_types_name_unique` (`name`);

--
-- Indexes for table `tab_categories`
--
ALTER TABLE `tab_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tab_categories_slug_unique` (`slug`);

--
-- Indexes for table `tab_category_product`
--
ALTER TABLE `tab_category_product`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tab_category_product_tab_category_id_product_id_unique` (`tab_category_id`,`product_id`),
  ADD KEY `tab_category_product_product_id_foreign` (`product_id`);

--
-- Indexes for table `tab_sub_categories`
--
ALTER TABLE `tab_sub_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tab_sub_categories_slug_unique` (`slug`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `wishlists_user_id_product_id_unique` (`user_id`,`product_id`),
  ADD KEY `wishlists_product_id_foreign` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `category_types`
--
ALTER TABLE `category_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `collection_ranges`
--
ALTER TABLE `collection_ranges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `etthnicoast_worlds`
--
ALTER TABLE `etthnicoast_worlds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `home_customer_reviews`
--
ALTER TABLE `home_customer_reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `home_page_banner_setups`
--
ALTER TABLE `home_page_banner_setups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `invoice_items`
--
ALTER TABLE `invoice_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `jewellery_in_motions`
--
ALTER TABLE `jewellery_in_motions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `order_tax_details`
--
ALTER TABLE `order_tax_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `our_best_sellers`
--
ALTER TABLE `our_best_sellers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `our_valued_partners`
--
ALTER TABLE `our_valued_partners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pearl_types`
--
ALTER TABLE `pearl_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `polish_types`
--
ALTER TABLE `polish_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `product_code_emblishments`
--
ALTER TABLE `product_code_emblishments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `product_code_finishings`
--
ALTER TABLE `product_code_finishings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `product_code_item_details`
--
ALTER TABLE `product_code_item_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `product_code_makers`
--
ALTER TABLE `product_code_makers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `product_complete_looks`
--
ALTER TABLE `product_complete_looks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `product_similar_items`
--
ALTER TABLE `product_similar_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product_variants`
--
ALTER TABLE `product_variants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `promo_strips`
--
ALTER TABLE `promo_strips`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `shop_by_life_styles`
--
ALTER TABLE `shop_by_life_styles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `shop_the_looks`
--
ALTER TABLE `shop_the_looks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `shop_the_look_hotspots`
--
ALTER TABLE `shop_the_look_hotspots`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `static_pages`
--
ALTER TABLE `static_pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `stone_types`
--
ALTER TABLE `stone_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tab_categories`
--
ALTER TABLE `tab_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tab_category_product`
--
ALTER TABLE `tab_category_product`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tab_sub_categories`
--
ALTER TABLE `tab_sub_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_tax_details`
--
ALTER TABLE `order_tax_details`
  ADD CONSTRAINT `order_tax_details_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `order_tax_details_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_tax_details_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tab_category_product`
--
ALTER TABLE `tab_category_product`
  ADD CONSTRAINT `tab_category_product_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tab_category_product_tab_category_id_foreign` FOREIGN KEY (`tab_category_id`) REFERENCES `tab_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD CONSTRAINT `wishlists_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
