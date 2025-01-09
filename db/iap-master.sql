-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 09, 2025 at 02:43 PM
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
-- Database: `iap-master`
--

-- --------------------------------------------------------

--
-- Table structure for table `a_internaship_periode`
--

CREATE TABLE `a_internaship_periode` (
  `id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `total_student` int(11) NOT NULL DEFAULT 0,
  `taken_student` int(11) NOT NULL DEFAULT 0,
  `upload_grade` enum('no','yes') NOT NULL DEFAULT 'no',
  `status` enum('activated','deactivated') NOT NULL DEFAULT 'deactivated',
  `user_id` bigint(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `a_internaship_periode`
--

INSERT INTO `a_internaship_periode` (`id`, `start_date`, `end_date`, `total_student`, `taken_student`, `upload_grade`, `status`, `user_id`) VALUES
(2, '2025-01-07', '2025-02-21', 10, 0, 'no', 'activated', 1);

-- --------------------------------------------------------

--
-- Table structure for table `a_partner_student_request`
--

CREATE TABLE `a_partner_student_request` (
  `id` int(11) NOT NULL,
  `request_student_number` int(3) NOT NULL,
  `major_in` varchar(100) NOT NULL,
  `partner_id` int(5) NOT NULL,
  `internaship_id` int(3) NOT NULL,
  `given_student_number` int(3) NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `a_partner_student_request`
--

INSERT INTO `a_partner_student_request` (`id`, `request_student_number`, `major_in`, `partner_id`, `internaship_id`, `given_student_number`, `created_at`) VALUES
(1, 4, 'Information and Communication technology', 4, 2, 1, '2025-01-07');

-- --------------------------------------------------------

--
-- Table structure for table `a_partner_student_request_totals`
--

CREATE TABLE `a_partner_student_request_totals` (
  `id` int(11) NOT NULL,
  `partner_id` int(5) NOT NULL,
  `internaship_id` int(6) NOT NULL,
  `requested_student` int(3) NOT NULL DEFAULT 0,
  `given_student` int(3) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `a_partner_student_request_totals`
--

INSERT INTO `a_partner_student_request_totals` (`id`, `partner_id`, `internaship_id`, `requested_student`, `given_student`) VALUES
(1, 4, 2, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `a_partner_tb`
--

CREATE TABLE `a_partner_tb` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(16) NOT NULL,
  `tin` varchar(9) NOT NULL,
  `place` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `major_in` varchar(200) NOT NULL,
  `is_active` enum('yes','no') NOT NULL DEFAULT 'yes',
  `c_profile` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `a_partner_tb`
--

INSERT INTO `a_partner_tb` (`id`, `name`, `phone`, `tin`, `place`, `email`, `major_in`, `is_active`, `c_profile`, `created_at`, `user_id`) VALUES
(1, 'EDMS', '0787654212', '23655456', 'Kigali', 'mbanzatrichard@gmail.com', '', 'yes', 'EDMS', '2025-01-07 19:37:24', 1),
(2, 'Test', '0787654212', '0', 'test', 'mbanzatrichard@gmail.com', '', 'yes', NULL, '2025-01-07 19:38:18', 0),
(3, 'DB', '0787654212', '789795641', 'remera', 'mbanzatrichard@gmail.com', '', 'yes', 'deborh', '2025-01-07 19:44:42', 1),
(4, 'abg', '0785689500', '0', 'Remera', 'laundry@gba.com', 'Information and Communication technology', 'yes', NULL, '2025-01-07 19:55:05', 0);

-- --------------------------------------------------------

--
-- Table structure for table `a_student_grade`
--

CREATE TABLE `a_student_grade` (
  `id` int(11) NOT NULL,
  `evaluation_criteria` text NOT NULL,
  `marks` int(2) NOT NULL,
  `s_marks` int(2) DEFAULT NULL,
  `attachment` varchar(200) NOT NULL,
  `student_id` varchar(7) NOT NULL,
  `partner_id` int(6) NOT NULL,
  `supervisior_id` int(6) NOT NULL,
  `internaship_id` int(6) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `a_student_logbook`
--

CREATE TABLE `a_student_logbook` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `used_tools` varchar(200) DEFAULT NULL,
  `screenshoots` varchar(200) NOT NULL DEFAULT '-',
  `objective` varchar(200) NOT NULL,
  `challenges` varchar(250) DEFAULT NULL,
  `student_id` int(6) NOT NULL,
  `suppervisor_id` int(6) NOT NULL,
  `internaship_id` int(6) NOT NULL,
  `partner_id` int(6) NOT NULL,
  `partner_comment` varchar(200) NOT NULL DEFAULT '-',
  `suppervisior_comment` varchar(200) NOT NULL DEFAULT '-',
  `log_date` date NOT NULL DEFAULT current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `a_student_logbook`
--

INSERT INTO `a_student_logbook` (`id`, `name`, `used_tools`, `screenshoots`, `objective`, `challenges`, `student_id`, `suppervisor_id`, `internaship_id`, `partner_id`, `partner_comment`, `suppervisior_comment`, `log_date`, `created_at`) VALUES
(13, 'Expiration of Product', NULL, '-', 'Documentation of APIs', 'Was some co....', 2089661, 1, 2, 4, '-', '', '2025-01-07', '2025-01-07 20:16:49');

-- --------------------------------------------------------

--
-- Table structure for table `a_student_tb`
--

CREATE TABLE `a_student_tb` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `major_in` varchar(100) NOT NULL,
  `card_id` int(6) NOT NULL,
  `internaship_periode_id` int(6) NOT NULL,
  `partner_id` int(6) DEFAULT NULL,
  `suppervisior_id` int(6) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `a_student_tb`
--

INSERT INTO `a_student_tb` (`id`, `first_name`, `last_name`, `email`, `phone`, `gender`, `major_in`, `card_id`, `internaship_periode_id`, `partner_id`, `suppervisior_id`, `created_at`, `updated_at`) VALUES
(1, 'Gregg', 'Nicolas', 'noelia.kovacek@spinka.com', '+6064828186982', 'male', 'Software Engineering', 21430, 1, NULL, NULL, '2023-09-07 12:15:27', '2023-09-07 12:15:27'),
(2, 'Fernando', 'Schumm', 'waelchi.bryana@parker.com', '+2349989527245', 'male', 'Marketing', 19326, 1, NULL, NULL, '2023-09-07 12:15:27', '2023-09-07 12:15:27'),
(3, 'Sherwood', 'Rippin', 'larkin.vallie@hotmail.com', '+9803093543297', 'male', 'Management', 18156, 1, NULL, NULL, '2023-09-07 12:15:27', '2023-09-07 12:15:27'),
(4, 'Sadie', 'Herzog', 'domenic.bruen@price.biz', '+5966934578901', 'female', 'Information Management', 19310, 1, NULL, NULL, '2023-09-07 12:15:27', '2023-09-07 12:15:27'),
(5, 'Mabelle', 'McLaughlin', 'rogahn.danika@schmeler.com', '+9196726471053', 'female', 'theology', 19943, 1, NULL, NULL, '2023-09-07 12:15:27', '2023-09-07 12:15:27'),
(6, 'Araceli', 'Breitenberg', 'wehner.reagan@hotmail.com', '+8573410331717', 'female', 'Management', 21306, 1, NULL, NULL, '2023-09-07 12:15:28', '2023-09-07 12:15:28'),
(7, 'Alyce', 'Haag', 'krystal46@yahoo.com', '+5219475399867', 'female', 'Health Sciences', 19070, 1, NULL, NULL, '2023-09-07 12:15:28', '2023-09-07 12:15:28'),
(8, 'Jerod', 'Keeling', 'bahringer.lexi@yahoo.com', '+6998294616392', 'male', 'Health Sciences', 20386, 1, NULL, NULL, '2023-09-07 12:15:28', '2023-09-07 12:15:28'),
(9, 'Dixie', 'Mitchell', 'swaniawski.carlie@mosciski.net', '+1623156596643', 'female', 'Information Management', 20164, 1, NULL, NULL, '2023-09-07 12:15:28', '2023-09-07 12:15:28'),
(10, 'Adalberto', 'Heathcote', 'mckenzie.laura@terry.com', '+4472306704271', 'male', 'Marketing', 19997, 1, NULL, NULL, '2023-09-07 12:15:28', '2023-09-07 12:15:28'),
(11, 'Scot', 'Veum', 'reichmann@hotmail.com', '+4507107585887', 'male', 'Health Sciences', 20495, 1, NULL, NULL, '2023-09-07 12:15:28', '2023-09-07 12:15:28'),
(12, 'Cleora', 'Schamberger', 'goldner.marcelino@daniel.com', '+1394456810195', 'female', 'Management', 21094, 1, NULL, NULL, '2023-09-07 12:15:29', '2023-09-07 12:15:29'),
(13, 'Dulce', 'Leannon', 'fgleichner@gmail.com', '+3500452913858', 'female', 'Health Sciences', 19340, 1, NULL, NULL, '2023-09-07 12:15:29', '2023-09-07 12:15:29'),
(14, 'Karina', 'Hammes', 'karolann.shanahan@hotmail.com', '+6722676143240', 'female', 'Marketing', 21214, 1, NULL, NULL, '2023-09-07 12:15:29', '2023-09-07 12:15:29'),
(15, 'Ethyl', 'Welch', 'hammes.suzanne@mann.com', '+9803520539828', 'female', 'Management', 20859, 1, NULL, NULL, '2023-09-07 12:15:29', '2023-09-07 12:15:29'),
(16, 'Arvid', 'Reilly', 'tyrese.homenick@dach.biz', '+3267057482237', 'male', 'Information Management', 19588, 1, NULL, NULL, '2023-09-07 12:15:29', '2023-09-07 12:15:29'),
(17, 'Chaya', 'Monahan', 'heidenreich.xander@gmail.com', '+4517683434425', 'female', 'Network and communication Systems', 21911, 1, NULL, NULL, '2023-09-07 12:15:29', '2023-09-07 12:15:29'),
(18, 'Amelie', 'Schinner', 'romaguera.camren@gmail.com', '+1289296705007', 'female', 'Mechanical Engineering', 2033075, 1, NULL, NULL, '2025-01-07 19:42:57', '2025-01-07 19:42:57'),
(19, 'Elian', 'Ferry', 'simeon.mckenzie@gmail.com', '+5340987970578', 'male', 'Mechanical Engineering', 2068647, 1, NULL, NULL, '2025-01-07 19:42:58', '2025-01-07 19:42:58'),
(20, 'Daren', 'Rogahn', 'julianne81@okon.com', '+4364698545044', 'male', 'Creative Arts Department', 2080711, 1, NULL, NULL, '2025-01-07 19:42:58', '2025-01-07 19:42:58'),
(21, 'Willow', 'Nitzsche', 'keyshawn99@von.com', '+6103544365375', 'female', 'Creative Arts Department', 2032449, 1, NULL, NULL, '2025-01-07 19:42:58', '2025-01-07 19:42:58'),
(22, 'Maud', 'Stoltenberg', 'aufderhar.charlotte@hotmail.com', '+9922381300195', 'female', 'Transport and Logistics Department', 2078870, 1, NULL, NULL, '2025-01-07 19:42:58', '2025-01-07 19:42:58'),
(23, 'Kieran', 'Kunze', 'berenice.cronin@ernser.com', '+3736856848279', 'male', 'Civil Engineering', 2058057, 1, NULL, NULL, '2025-01-07 19:42:58', '2025-01-07 19:42:58'),
(24, 'Dolores', 'Fahey', 'idurgan@gerhold.info', '+8363061461799', 'female', 'Mechanical Engineering', 2021186, 1, NULL, NULL, '2025-01-07 19:42:59', '2025-01-07 19:42:59'),
(25, 'Viola', 'Lemke', 'msenger@adams.com', '+9635427551444', 'female', 'Mining Engineering', 2094292, 1, NULL, NULL, '2025-01-07 19:42:59', '2025-01-07 19:42:59'),
(26, 'Jazmin', 'Wunsch', 'schroeder.rex@mayert.biz', '+1075186726124', 'female', 'Mining Engineering', 2022841, 1, NULL, NULL, '2025-01-07 19:42:59', '2025-01-07 19:42:59'),
(27, 'Martina', 'Collins', 'dolores53@funk.com', '+7871336699289', 'female', 'Transport and Logistics Department', 2038495, 1, NULL, NULL, '2025-01-07 19:42:59', '2025-01-07 19:42:59'),
(28, 'Rolando', 'Dach', 'kuvalis.maud@ziemann.info', '+2307698861871', 'male', 'Civil Engineering', 2034644, 2, NULL, NULL, '2025-01-07 19:56:10', '2025-01-07 19:56:10'),
(29, 'Neva', 'Breitenberg', 'liza.jenkins@mueller.biz', '+1843287852087', 'female', 'Electrical and Electronics Engineering', 2083173, 2, NULL, NULL, '2025-01-07 19:56:10', '2025-01-07 19:56:10'),
(30, 'Zaria', 'Morar', 'mireya.marks@hotmail.com', '+1825331975884', 'female', 'Information and Communication technology', 2089661, 2, 4, 1, '2025-01-07 19:56:11', '2025-01-07 20:16:11'),
(31, 'Aurore', 'Kassulke', 'deven43@gmail.com', '+2480269868131', 'female', 'Information and Communication technology', 2064333, 2, NULL, NULL, '2025-01-07 19:56:11', '2025-01-07 19:56:11'),
(32, 'Gayle', 'Block', 'salma00@ernser.biz', '+8451504026417', 'male', 'Information and Communication technology', 2021135, 2, NULL, NULL, '2025-01-07 19:56:11', '2025-01-07 19:56:11'),
(33, 'Tristian', 'Padberg', 'cindy82@weissnat.com', '+3036504115594', 'male', 'Electrical and Electronics Engineering', 2027247, 2, NULL, NULL, '2025-01-07 19:56:11', '2025-01-07 19:56:11'),
(34, 'Gunner', 'Hackett', 'stefan.swaniawski@bednar.com', '+3779584644192', 'male', 'Mechanical Engineering', 2062219, 2, NULL, NULL, '2025-01-07 19:56:12', '2025-01-07 19:56:12'),
(35, 'Hattie', 'Boyle', 'laurianne.grimes@yahoo.com', '+6588852687891', 'female', 'Information and Communication technology', 2090958, 2, NULL, NULL, '2025-01-07 19:56:12', '2025-01-07 19:56:12'),
(36, 'Merritt', 'Raynor', 'asa21@yahoo.com', '+5697621150903', 'male', 'Electrical and Electronics Engineering', 2031904, 2, NULL, NULL, '2025-01-07 19:56:12', '2025-01-07 19:56:12'),
(37, 'Odie', 'Weber', 'pbeahan@schamberger.org', '+1921185040665', 'female', 'Mechanical Engineering', 2084643, 2, NULL, NULL, '2025-01-07 19:56:12', '2025-01-07 19:56:12');

-- --------------------------------------------------------

--
-- Table structure for table `a_suppervisior_tb`
--

CREATE TABLE `a_suppervisior_tb` (
  `id` int(11) NOT NULL,
  `names` varchar(200) NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `department` varchar(500) NOT NULL,
  `major_in` varchar(200) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(16) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `a_suppervisior_tb`
--

INSERT INTO `a_suppervisior_tb` (`id`, `names`, `gender`, `department`, `major_in`, `email`, `phone`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Fabien MANZI', 'male', 'Information and Communication technology', 'Information and Communication technology', 'fabien@gmail.com', '0789546321', 'active', '2025-01-07 20:12:22', '2025-01-07 20:12:22');

-- --------------------------------------------------------

--
-- Table structure for table `a_users`
--

CREATE TABLE `a_users` (
  `id` bigint(20) NOT NULL,
  `names` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `phone` varchar(16) DEFAULT NULL,
  `secret` varchar(150) NOT NULL,
  `level` enum('ADMIN','PARTNER','STUDENT','SUPERVISIOR','USER') NOT NULL DEFAULT 'USER',
  `institition_id` varchar(5) NOT NULL DEFAULT '0',
  `status` enum('active','inactive') NOT NULL DEFAULT 'inactive',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `a_ip` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `a_users`
--

INSERT INTO `a_users` (`id`, `names`, `username`, `phone`, `secret`, `level`, `institition_id`, `status`, `updated_at`, `a_ip`) VALUES
(116, 'IPRCKIGALI', 'iprckigali', '0787654212', '$2y$10$xNEXlh2k4c1VfA/JE2g9g.5sFOROjJkbeLN2iDlbhi63GT1eFsi9.', 'ADMIN', '0', 'active', '2025-01-09 15:42:41', '::1'),
(117, 'Richardgh', 'test', '0787654212', '$2y$10$NtFuh3fLBnI1IkaqRUpTueU7a5FLjLWJO9xzgqtMecB2FmA0EWbdK', 'PARTNER', '2', 'active', '2025-01-07 19:38:19', '::1'),
(128, 'DB', 'deborah', '0787654212', '$2y$10$01YIB.hK42nz3p./Bmx9h.wMJhj7KYshTLo7AYk/vgV12uJDWfdNe', 'PARTNER', '3', 'active', '2025-01-07 19:44:42', NULL),
(129, 'LAUNDRY', 'abg', '0785689500', '$2y$10$bjzNM6gWwpEWvQTkyGa/fOag55Kt.UQOiR1FOKnv6164e4sTjuTua', 'PARTNER', '4', 'active', '2025-01-07 19:55:05', '::1'),
(130, 'Rolando Dach', '2034644', '+2307698861871', '$2y$10$a895BPuZzs5GFVW5/XjKMuctY47MGqYl4Ry3TV98Y1CEqmzVXN7vG', 'STUDENT', '0', 'active', '2025-01-07 19:56:10', NULL),
(131, 'Neva Breitenberg', '2083173', '+1843287852087', '$2y$10$oDXyNG7K8cmt9DUyo1dS9O9ZZqXdJg.HmHkXoaHWoK1etwwOVD6a.', 'STUDENT', '0', 'active', '2025-01-07 19:56:10', NULL),
(132, 'Zaria Morar', '2089661', '+1825331975884', '$2y$10$aHX87EfG6hLdZKhk6jJpEOnxr8C12P4YPDr0j7hrBnUvnG.ZD6Jf2', 'STUDENT', '0', 'active', '2025-01-07 20:10:49', '::1'),
(133, 'Aurore Kassulke', '2064333', '+2480269868131', '$2y$10$l5hI40KKWOgoDdU5g9eEfOHIuX1kXoQ9blhpaXJymmKbjFWkMVGeC', 'STUDENT', '0', 'active', '2025-01-07 19:56:11', NULL),
(134, 'Gayle Block', '2021135', '+8451504026417', '$2y$10$8y4rH2iLc5RKiRQ74pQPu.nA.wTJS9r3/NC8.ClaIgHCUTZweBMD.', 'STUDENT', '0', 'active', '2025-01-07 19:56:11', NULL),
(135, 'Tristian Padberg', '2027247', '+3036504115594', '$2y$10$5B8NOg5.swozDlCtOtLx3u2fUec.flQ/aJz5KmzO6G/8RvdY2uQRC', 'STUDENT', '0', 'active', '2025-01-07 19:56:11', NULL),
(136, 'Gunner Hackett', '2062219', '+3779584644192', '$2y$10$A/d8MIeNDH2SGdTOCi2QxurOKhaie7v1KIVxATLyFJUa8gTKKqbhK', 'STUDENT', '0', 'active', '2025-01-07 19:56:12', NULL),
(137, 'Hattie Boyle', '2090958', '+6588852687891', '$2y$10$TZGrgLR.JteowtN2zdTuWuZ84tdC0M8sozmYi4scUl3MH2S1D9nji', 'STUDENT', '0', 'active', '2025-01-07 19:56:12', NULL),
(138, 'Merritt Raynor', '2031904', '+5697621150903', '$2y$10$PqOTiIZIt88MYMhUS306n.DNSV2p3JHNCu0Br94dDreyD9J41s8lq', 'STUDENT', '0', 'active', '2025-01-07 19:56:12', NULL),
(139, 'Odie Weber', '2084643', '+1921185040665', '$2y$10$Ssw7A04FLSBPYhsbr1uKJOClYzFJdywAXfUujNX7Cvi1kQr/MAC9O', 'STUDENT', '0', 'active', '2025-01-07 19:56:12', NULL),
(140, 'Fabien MANZI', 'Fabien', '0789546321', '$2y$10$OCh7CKBaH4DNoJPp4ZfTmueqSG0zsBNnevzXcKfoFHjl5VVM2FncK', 'SUPERVISIOR', '1', 'active', '2025-01-07 20:12:22', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `notifications_tb`
--

CREATE TABLE `notifications_tb` (
  `id` int(11) NOT NULL,
  `message` varchar(200) NOT NULL,
  `link` varchar(200) NOT NULL,
  `level` enum('ADMIN','PARTNER','STUDENT','SUPERVISIOR') NOT NULL,
  `level_id` int(3) NOT NULL,
  `done_by` int(3) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications_tb`
--

INSERT INTO `notifications_tb` (`id`, `message`, `link`, `level`, `level_id`, `done_by`, `created_at`) VALUES
(2, 'Auca internaship(Start:2025-01-07 End:2025-02-21,status:deactivated,upload Marks:no)', 'home?id', 'PARTNER', 1, 1, '2025-01-07 19:43:26'),
(3, 'Auca internaship(Start:2025-01-07 End:2025-02-21,status:deactivated,upload Marks:no)', 'home?id', 'PARTNER', 2, 1, '2025-01-07 19:43:26'),
(9, 'New Internaship Student(Morar Morar)', 'a_partner_student?st=2089661', 'PARTNER', 4, 1, '2025-01-07 20:16:11'),
(10, 'New Assigned Student(Morar Morar)', 'a_partner_student?st=2089661', 'SUPERVISIOR', 1, 1, '2025-01-07 20:16:11'),
(11, 'abg -&gt; Remera as partern AND Fabien MANZI -&gt; Information and Communication technology as supervisior', 'home', 'STUDENT', 2089661, 1, '2025-01-07 20:16:11'),
(12, 'Please check Zaria Morar daily activity', 's_log_book?st=2089661', 'SUPERVISIOR', 1, 2089661, '2025-01-07 20:16:49'),
(13, 'Please check Zaria Morar daily activity', 'p_log_book?st=2089661', 'PARTNER', 4, 2089661, '2025-01-07 20:16:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `a_internaship_periode`
--
ALTER TABLE `a_internaship_periode`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `a_partner_student_request`
--
ALTER TABLE `a_partner_student_request`
  ADD PRIMARY KEY (`id`),
  ADD KEY `internaship_id` (`internaship_id`),
  ADD KEY `partner_id` (`partner_id`);

--
-- Indexes for table `a_partner_student_request_totals`
--
ALTER TABLE `a_partner_student_request_totals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `internaship_id` (`internaship_id`),
  ADD KEY `partiner_id` (`partner_id`);

--
-- Indexes for table `a_partner_tb`
--
ALTER TABLE `a_partner_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `a_student_grade`
--
ALTER TABLE `a_student_grade`
  ADD PRIMARY KEY (`id`),
  ADD KEY `partner_id` (`partner_id`),
  ADD KEY `supervisior_id` (`supervisior_id`),
  ADD KEY `internaship_id` (`internaship_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `a_student_logbook`
--
ALTER TABLE `a_student_logbook`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `partner_id` (`partner_id`),
  ADD KEY `suppervisor_id` (`suppervisor_id`),
  ADD KEY `internaship_id` (`internaship_id`),
  ADD KEY `log_date` (`log_date`);

--
-- Indexes for table `a_student_tb`
--
ALTER TABLE `a_student_tb`
  ADD PRIMARY KEY (`id`),
  ADD KEY `internaship_periode_id` (`internaship_periode_id`),
  ADD KEY `suppervisior_id` (`suppervisior_id`),
  ADD KEY `partner_id` (`partner_id`),
  ADD KEY `card_id` (`card_id`);

--
-- Indexes for table `a_suppervisior_tb`
--
ALTER TABLE `a_suppervisior_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `a_users`
--
ALTER TABLE `a_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username_indx` (`username`),
  ADD KEY `username` (`username`),
  ADD KEY `institition_id` (`institition_id`);

--
-- Indexes for table `notifications_tb`
--
ALTER TABLE `notifications_tb`
  ADD PRIMARY KEY (`id`),
  ADD KEY `level_id` (`level_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `a_internaship_periode`
--
ALTER TABLE `a_internaship_periode`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `a_partner_student_request`
--
ALTER TABLE `a_partner_student_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `a_partner_student_request_totals`
--
ALTER TABLE `a_partner_student_request_totals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `a_partner_tb`
--
ALTER TABLE `a_partner_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `a_student_grade`
--
ALTER TABLE `a_student_grade`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `a_student_logbook`
--
ALTER TABLE `a_student_logbook`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `a_student_tb`
--
ALTER TABLE `a_student_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `a_suppervisior_tb`
--
ALTER TABLE `a_suppervisior_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `a_users`
--
ALTER TABLE `a_users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT for table `notifications_tb`
--
ALTER TABLE `notifications_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `a_internaship_periode`
--
ALTER TABLE `a_internaship_periode`
  ADD CONSTRAINT `a_internaship_periode_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `a_users` (`id`);

--
-- Constraints for table `a_partner_student_request`
--
ALTER TABLE `a_partner_student_request`
  ADD CONSTRAINT `a_partner_student_request_ibfk_1` FOREIGN KEY (`internaship_id`) REFERENCES `a_internaship_periode` (`id`),
  ADD CONSTRAINT `a_partner_student_request_ibfk_2` FOREIGN KEY (`partner_id`) REFERENCES `a_partner_tb` (`id`);

--
-- Constraints for table `a_partner_student_request_totals`
--
ALTER TABLE `a_partner_student_request_totals`
  ADD CONSTRAINT `a_partner_student_request_totals_ibfk_1` FOREIGN KEY (`internaship_id`) REFERENCES `a_internaship_periode` (`id`),
  ADD CONSTRAINT `a_partner_student_request_totals_ibfk_2` FOREIGN KEY (`partner_id`) REFERENCES `a_partner_tb` (`id`);

--
-- Constraints for table `a_student_grade`
--
ALTER TABLE `a_student_grade`
  ADD CONSTRAINT `a_student_grade_ibfk_1` FOREIGN KEY (`partner_id`) REFERENCES `a_partner_tb` (`id`),
  ADD CONSTRAINT `a_student_grade_ibfk_2` FOREIGN KEY (`supervisior_id`) REFERENCES `a_suppervisior_tb` (`id`),
  ADD CONSTRAINT `a_student_grade_ibfk_3` FOREIGN KEY (`internaship_id`) REFERENCES `a_internaship_periode` (`id`);

--
-- Constraints for table `a_student_logbook`
--
ALTER TABLE `a_student_logbook`
  ADD CONSTRAINT `a_student_logbook_ibfk_1` FOREIGN KEY (`partner_id`) REFERENCES `a_partner_tb` (`id`),
  ADD CONSTRAINT `a_student_logbook_ibfk_2` FOREIGN KEY (`suppervisor_id`) REFERENCES `a_suppervisior_tb` (`id`),
  ADD CONSTRAINT `a_student_logbook_ibfk_3` FOREIGN KEY (`internaship_id`) REFERENCES `a_internaship_periode` (`id`);

--
-- Constraints for table `a_student_tb`
--
ALTER TABLE `a_student_tb`
  ADD CONSTRAINT `a_student_tb_ibfk_1` FOREIGN KEY (`internaship_periode_id`) REFERENCES `a_internaship_periode` (`id`),
  ADD CONSTRAINT `a_student_tb_ibfk_3` FOREIGN KEY (`suppervisior_id`) REFERENCES `a_suppervisior_tb` (`id`),
  ADD CONSTRAINT `a_student_tb_ibfk_4` FOREIGN KEY (`partner_id`) REFERENCES `a_partner_tb` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
