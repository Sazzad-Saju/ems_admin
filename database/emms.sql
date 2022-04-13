-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 30, 2021 at 01:57 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `emms`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

CREATE TABLE `attendances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bill_types`
--

CREATE TABLE `bill_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blood_groups`
--

CREATE TABLE `blood_groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blood_groups`
--

INSERT INTO `blood_groups` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'AB+', '2021-06-29 00:53:42', '2021-06-29 00:53:42', NULL),
(2, 'AB-', '2021-06-29 00:53:42', '2021-06-29 00:53:42', NULL),
(3, 'A+', '2021-06-29 00:53:42', '2021-06-29 00:53:42', NULL),
(4, 'A-', '2021-06-29 00:53:42', '2021-06-29 00:53:42', NULL),
(5, 'B+', '2021-06-29 00:53:42', '2021-06-29 00:53:42', NULL),
(6, 'B-', '2021-06-29 00:53:42', '2021-06-29 00:53:42', NULL),
(7, 'O+', '2021-06-29 00:53:42', '2021-06-29 00:53:42', NULL),
(8, 'O-', '2021-06-29 00:53:42', '2021-06-29 00:53:42', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `conveyance_bills`
--

CREATE TABLE `conveyance_bills` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `bill_type_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` double NOT NULL,
  `is_approve` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'IT', '1', '2021-06-29 00:53:42', '2021-06-29 00:53:42', NULL),
(2, 'HR', '1', '2021-06-29 00:53:42', '2021-06-29 00:53:42', NULL),
(3, 'Network', '1', '2021-06-29 00:53:42', '2021-06-29 00:53:42', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `designations`
--

CREATE TABLE `designations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `designations`
--

INSERT INTO `designations` (`id`, `name`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Technical Office', '1', '2021-06-29 00:53:42', '2021-06-29 00:53:42', NULL),
(2, 'Software Engineer', '1', '2021-06-29 00:53:42', '2021-06-29 00:53:42', NULL),
(3, 'Network Engineer', '1', '2021-06-29 00:53:42', '2021-06-29 00:53:42', NULL),
(4, 'SEO Expert', '1', '2021-06-29 00:53:42', '2021-06-29 00:53:42', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `custom_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `blood_group_id` bigint(20) UNSIGNED NOT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `designation_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `office_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `office_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `present_address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `permanent_address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dob` date NOT NULL,
  `emergency_contact_person` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `emergency_contact_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `emergency_contact_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `emergency_contact_relation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nid_number` int(11) NOT NULL,
  `nid_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `certificate_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `salary` double NOT NULL,
  `join_date` date NOT NULL,
  `quit_date` date DEFAULT NULL,
  `is_current_employee` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1 for current employee 0 for not current employee',
  `is_provision_period` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1 for provision period 0 for not provision period',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `custom_id`, `blood_group_id`, `department_id`, `designation_id`, `created_by`, `updated_by`, `name`, `personal_email`, `office_email`, `phone`, `office_phone`, `gender`, `present_address`, `permanent_address`, `profile_image`, `dob`, `emergency_contact_person`, `emergency_contact_phone`, `emergency_contact_address`, `emergency_contact_relation`, `nid_number`, `nid_image`, `certificate_image`, `salary`, `join_date`, `quit_date`, `is_current_employee`, `is_provision_period`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '71', 1, 1, 1, NULL, NULL, 'Mr employee', 'employee@g.com', 'employee@g.com', '10000000', '9999999', 'Male', 'Dhaka, Bangladesh', 'Dhaka, Bangladesh', 'asset/img/user1-128x128.jpg', '2021-06-29', 'Mr someone', '9999999', 'Dhaka, Bangladesh', 'Uncle', 1000000000, 'asset/img/user1-128x128.jpg', 'asset/img/user2-128x128.jpg', 20395, '2021-06-29', NULL, 1, 1, '2021-06-29 00:53:41', '2021-06-29 00:53:41', NULL),
(2, 'Miss Mabelle Cormier', 1, 1, 1, NULL, NULL, 'Miss Veronica Hahn III', 'bradley03@mcglynn.com', 'crist.aric@parisian.com', '10000000', '9999999', 'Female', '52662 Hudson Streets\nLake Marielaburgh, NY 50688-6038', '549 Nina Parks\nWest Scotty, MN 61848', 'asset/img/user8-128x128.jpg', '2021-06-29', 'Karen Schamberger', '10000000', '55370 Sharon Parkway\nTyreeshire, NJ 01925-1896', 'Brother', 1000000000, 'asset/img/user3-128x128.jpg', 'asset/img/user3-128x128.jpg', 49741, '2021-06-29', NULL, 1, 1, '2021-06-29 00:53:41', '2021-06-29 00:53:41', NULL),
(3, 'Mr. Joaquin McClure', 1, 1, 1, NULL, NULL, 'Lennie Rippin', 'rusty14@glover.org', 'kstanton@crist.info', '10000000', '10000000', 'Female', '313 Leuschke Cliffs\nNorth Oswaldo, MN 43573', '6554 Mollie Ville Apt. 759\nNew Lyda, ID 41441', 'asset/img/user2-128x128.jpg', '2021-06-29', 'Augusta Dietrich', '9999999', '914 Cody Parks\nWilburnborough, ID 03668', 'Brother', 999999999, 'asset/img/user5-128x128.jpg', 'asset/img/user1-128x128.jpg', 13634, '2021-06-29', NULL, 1, 1, '2021-06-29 00:53:41', '2021-06-29 00:53:41', NULL),
(4, 'Kris Strosin', 1, 1, 1, NULL, NULL, 'Magnus Haley IV', 'althea36@emmerich.org', 'dgrimes@raynor.com', '9999999', '10000000', 'Female', '87074 Novella Loop Apt. 289\nPort Jeffry, NV 78008-6940', '8368 Branson Extensions Apt. 912\nTurnerburgh, WA 25595', 'asset/img/user4-128x128.jpg', '2021-06-29', 'Jody Nader', '10000000', '85343 Kenyatta Street Suite 673\nAbernathyport, LA 55404', 'Brother', 1000000000, 'asset/img/user7-128x128.jpg', 'asset/img/user5-128x128.jpg', 79375, '2021-06-29', NULL, 1, 1, '2021-06-29 00:53:41', '2021-06-29 00:53:41', NULL),
(5, 'Mrs. Myrtie Lebsack Jr.', 1, 1, 1, NULL, NULL, 'Rebeka Quitzon II', 'jpfeffer@hintz.com', 'sgoodwin@rodriguez.info', '10000000', '9999999', 'Female', '7616 Gottlieb Pines Suite 515\nWest Gaston, NE 91804', '393 Breanne Squares\nLenniehaven, AL 47665', 'asset/img/user5-128x128.jpg', '2021-06-29', 'Ardella Quigley', '10000000', '901 Rickey Lodge\nOrnhaven, SC 72774', 'Brother', 999999999, 'asset/img/user7-128x128.jpg', 'asset/img/user1-128x128.jpg', 20431, '2021-06-29', NULL, 1, 1, '2021-06-29 00:53:41', '2021-06-29 00:53:41', NULL),
(6, 'Gracie Kessler', 1, 1, 1, NULL, NULL, 'Mr. Benjamin Armstrong III', 'sabernathy@senger.com', 'cecil47@gmail.com', '9999999', '10000000', 'Male', '499 Koelpin Terrace\nWest Laurinetown, MT 02267-3439', '9188 Sawayn Streets\nSouth Myrna, PA 46869-0906', 'asset/img/user3-128x128.jpg', '2021-06-29', 'Reggie Bergstrom', '9999999', '6992 Predovic Garden\nEast Nicholas, KS 02831-8080', 'Uncle', 1000000000, 'asset/img/user6-128x128.jpg', 'asset/img/user7-128x128.jpg', 96650, '2021-06-29', NULL, 1, 1, '2021-06-29 00:53:41', '2021-06-29 00:53:41', NULL),
(7, 'Odessa Bartoletti', 1, 1, 1, NULL, NULL, 'Ms. Modesta Goyette', 'palma.lueilwitz@feeney.com', 'fritsch.omari@rice.com', '10000000', '10000000', 'Male', '31128 Fritz Springs\nMalcolmville, MA 26096', '722 Blake Causeway\nBettiebury, HI 59583', 'asset/img/user4-128x128.jpg', '2021-06-29', 'Claire Pfeffer', '10000000', '76166 Tremblay Shore\nPort Josefa, AZ 95346-8047', 'Uncle', 1000000000, 'asset/img/user3-128x128.jpg', 'asset/img/user7-128x128.jpg', 21907, '2021-06-29', NULL, 1, 1, '2021-06-29 00:53:41', '2021-06-29 00:53:41', NULL),
(8, 'Mr. Frederic Auer MD', 1, 1, 1, NULL, NULL, 'General Davis', 'jaime07@gmail.com', 'hudson.gerhold@wiza.com', '10000000', '9999999', 'Female', '122 Myriam Wells Apt. 684\nSouth Darrellburgh, ND 79612-6999', '4578 Clarabelle Alley\nSouth Peytonshire, DE 51969', 'asset/img/user1-128x128.jpg', '2021-06-29', 'Amya Huel', '9999999', '786 Murray Way\nNew Eloy, WV 48480', 'Uncle', 999999999, 'asset/img/user8-128x128.jpg', 'asset/img/user6-128x128.jpg', 10690, '2021-06-29', NULL, 1, 1, '2021-06-29 00:53:41', '2021-06-29 00:53:41', NULL),
(9, 'Sabina Kuhic', 1, 1, 1, NULL, NULL, 'Prof. Darien Erdman I', 'will.florian@ratke.com', 'schmitt.harley@yahoo.com', '9999999', '9999999', 'Female', '88005 Lela Mountain\nEast Kade, KS 08295-0584', '772 Hellen Ridges Suite 192\nLemketown, RI 62274-7142', 'asset/img/user1-128x128.jpg', '2021-06-29', 'Simeon Gibson', '10000000', '2768 Rozella Crest\nWest Shana, WY 92831', 'Uncle', 999999999, 'asset/img/user4-128x128.jpg', 'asset/img/user2-128x128.jpg', 94088, '2021-06-29', NULL, 1, 1, '2021-06-29 00:53:41', '2021-06-29 00:53:41', NULL),
(10, 'Joelle Douglas', 1, 1, 1, NULL, NULL, 'Warren Mayer', 'jewell52@hotmail.com', 'kareem.brekke@gmail.com', '9999999', '9999999', 'Male', '7936 Fleta Plain\nEast Liamburgh, OR 16707', '245 Bashirian Freeway\nBiankaton, KS 26063-3499', 'asset/img/user2-128x128.jpg', '2021-06-29', 'Cale Ward IV', '10000000', '80657 Crooks Point Suite 651\nJermainside, NV 12915-8158', 'Uncle', 999999999, 'asset/img/user1-128x128.jpg', 'asset/img/user5-128x128.jpg', 11805, '2021-06-29', NULL, 1, 1, '2021-06-29 00:53:42', '2021-06-29 00:53:42', NULL),
(11, 'Maryse Bergnaum', 1, 1, 1, NULL, NULL, 'Mr. Uriel Kertzmann', 'marco66@mitchell.com', 'kkautzer@yahoo.com', '9999999', '10000000', 'Female', '46696 Moore Greens\nNorth Montyville, HI 48668', '722 Cyrus Fords\nLancechester, VA 37635-4657', 'asset/img/user6-128x128.jpg', '2021-06-29', 'Ms. Faye Maggio', '10000000', '4412 Mafalda Lights Suite 896\nSawaynburgh, VT 66129', 'Brother', 999999999, 'asset/img/user4-128x128.jpg', 'asset/img/user3-128x128.jpg', 97087, '2021-06-29', NULL, 1, 1, '2021-06-29 00:53:42', '2021-06-29 00:53:42', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `holidays`
--

CREATE TABLE `holidays` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leaves`
--

CREATE TABLE `leaves` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `leave_type_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `recommend_employee_id` bigint(20) UNSIGNED NOT NULL,
  `reason` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `submission_type` enum('Pre','Post') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'enum [pre,post]',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `duration` double NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Pending,Approve,Reject',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leaves`
--

INSERT INTO `leaves` (`id`, `employee_id`, `leave_type_id`, `created_by`, `updated_by`, `recommend_employee_id`, `reason`, `submission_type`, `start_date`, `end_date`, `start_time`, `end_time`, `duration`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, NULL, NULL, 2, 'Ut quis quod aliquid', 'Pre', '2004-06-17', '1998-08-18', '20:33:00', '09:14:00', 5, 'Rejected', '2021-06-29 01:04:44', '2021-06-29 03:32:58', NULL),
(2, 1, 1, NULL, NULL, 3, 'Error similique proi', 'Pre', '2021-06-29', '2021-06-29', '12:52:00', '06:09:00', 5, 'Pending', '2021-06-29 03:11:39', '2021-06-29 04:27:55', NULL),
(3, 1, 4, NULL, NULL, 11, 'Sit atque pariatur', 'Post', '2021-06-28', '2021-06-29', '17:00:00', '11:00:00', 5, 'Pending', '2021-06-29 05:50:38', '2021-06-29 06:36:20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `leave_types`
--

CREATE TABLE `leave_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leave_types`
--

INSERT INTO `leave_types` (`id`, `name`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Casual', '1', '2021-06-29 00:53:42', '2021-06-29 00:53:42', NULL),
(2, 'Sick', '1', '2021-06-29 00:53:42', '2021-06-29 00:53:42', NULL),
(3, 'Earned', '1', '2021-06-29 00:53:42', '2021-06-29 00:53:42', NULL),
(4, 'Unpaid', '1', '2021-06-29 00:53:42', '2021-06-29 00:53:42', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `loans`
--

CREATE TABLE `loans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `reason` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` double NOT NULL,
  `issue_date` date NOT NULL,
  `return_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `manage_department`
--

CREATE TABLE `manage_department` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `parent_department_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT '0 or null for no parent',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2021_06_24_070037_create_employees_table', 1),
(5, '2021_06_24_070300_create_leaves_table', 1),
(6, '2021_06_24_070424_create_holidays_table', 1),
(7, '2021_06_24_070506_create_reports_table', 1),
(8, '2021_06_24_070523_create_tasks_table', 1),
(9, '2021_06_24_070618_create_attendances_table', 1),
(10, '2021_06_24_070643_create_notices_table', 1),
(11, '2021_06_24_074208_create_departments_table', 1),
(12, '2021_06_24_074259_create_designations_table', 1),
(13, '2021_06_24_074330_create_leave_types_table', 1),
(14, '2021_06_24_074425_create_bill_types_table', 1),
(15, '2021_06_24_074444_create_blood_groups_table', 1),
(16, '2021_06_24_075210_create_conveyance_bills_table', 1),
(17, '2021_06_24_075325_create_loans_table', 1),
(18, '2021_06_24_075707_create_manage_department_table', 1),
(19, '2021_06_24_095723_create_settings_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notices`
--

CREATE TABLE `notices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bill_types`
--
ALTER TABLE `bill_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blood_groups`
--
ALTER TABLE `blood_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conveyance_bills`
--
ALTER TABLE `conveyance_bills`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `designations`
--
ALTER TABLE `designations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `holidays`
--
ALTER TABLE `holidays`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leaves`
--
ALTER TABLE `leaves`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_types`
--
ALTER TABLE `leave_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loans`
--
ALTER TABLE `loans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `manage_department`
--
ALTER TABLE `manage_department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notices`
--
ALTER TABLE `notices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
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
-- AUTO_INCREMENT for table `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bill_types`
--
ALTER TABLE `bill_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blood_groups`
--
ALTER TABLE `blood_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `conveyance_bills`
--
ALTER TABLE `conveyance_bills`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `designations`
--
ALTER TABLE `designations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `holidays`
--
ALTER TABLE `holidays`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leaves`
--
ALTER TABLE `leaves`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `leave_types`
--
ALTER TABLE `leave_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `loans`
--
ALTER TABLE `loans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `manage_department`
--
ALTER TABLE `manage_department`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `notices`
--
ALTER TABLE `notices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
