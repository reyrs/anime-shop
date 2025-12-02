-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 20, 2025 at 05:40 AM
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
-- Database: `anime_figures_shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `figures`
--

CREATE TABLE `figures` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `figures`
--

INSERT INTO `figures` (`id`, `name`, `description`, `price`, `image`, `created_at`) VALUES
(1, 'Rascal Does Not Dream of Bunny Girl Senpai: Mai Sakurajima Bunny Ver. - Figure it Out', 'Special Edition', 24.00, '1760804039_hr_tapr451605000.jpg', '2025-10-18 16:13:59'),
(2, 'Kitagawa', 'Extra Edition', 23.00, '1760809217_b041674b25ca413b94546a0812ea381f.jpg', '2025-10-18 17:40:17'),
(3, 'Oshi No Ko - Hoshino Ai - 1/7 Scale Figure', 'Special Edition', 26.00, '1760809261_screenshot_1-hkoux3sho6.webp', '2025-10-18 17:41:01'),
(4, 'Luffy Gear 5', 'Special Edition', 30.00, '1760809708_S59986cb04f914e4892c59810b8902760F.webp', '2025-10-18 17:48:28'),
(5, 'Uchiha Sasuke', 'Naruto Edition', 25.00, '1760812275_1-1-06_2000x.webp', '2025-10-18 18:31:15'),
(6, 'Zoro', 'Full Haki', 34.00, '1760812324_21cm-One-Piece-Zoro-Figure-2-Heads-Roronoa-Zoro-Action-Figure-PVC-Anime-Model-Figurine-Kids-2.webp', '2025-10-18 18:32:04');

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE `videos` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `figure_id` int(11) DEFAULT NULL,
  `video_file` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `videos`
--

INSERT INTO `videos` (`id`, `title`, `description`, `figure_id`, `video_file`, `created_at`) VALUES
(1, 'Chainsaw Man', 'Reze', NULL, '1760809446_米津玄師  Kenshi Yonezu - IRIS OUT.mp4', '2025-10-18 17:44:06'),
(2, 'Attack On Titan', 'RUMBLINGGG', NULL, '1760809545_TVアニメ「進撃の巨人」The Final Season Part 2ノンクレジットOP ｜SiM「The Rumbling」 (1).mp4', '2025-10-18 17:45:45'),
(3, 'Jujutsu Kaisen', 'Specialz', NULL, '1760809637_TBS系列全国28局にて放送中!!.mp4', '2025-10-18 17:47:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `figures`
--
ALTER TABLE `figures`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_figure_id_videos` (`figure_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `figures`
--
ALTER TABLE `figures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `videos`
--
ALTER TABLE `videos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `videos`
--
ALTER TABLE `videos`
  ADD CONSTRAINT `fk_videos_figure` FOREIGN KEY (`figure_id`) REFERENCES `figures` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
