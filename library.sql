-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 30, 2025 at 07:52 PM
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
-- Database: `library`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `isbn` varchar(100) NOT NULL,
  `author_name` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `pdf` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `isbn`, `author_name`, `category_id`, `image`, `pdf`, `created_at`) VALUES
(1, 'The mans Homes', '9098873456781', 'Jeremy Tiger', 1, '688371e81467c_blood-crime-book-cover-design-template-403f457ed929a6cd172d0c4c5817d126_screen.jpg', '688371e814ac4_the-man-who-was-thursday-obooko.pdf', '2025-07-25 12:00:40'),
(2, 'No wolves in Los Angeles', '90875631245', 'Dickson Joseph', 1, '68875ee97d4ba_canva-brown-rusty-mystery-novel-book-cover-hG1QhA7BiBU.jpg', '68875ee97d9c6_no-wolves-in-los-angeles-obooko.pdf', '2025-07-28 11:28:41'),
(3, 'One Step from Reality', '90875633476', 'Damson Idris', 2, '68875f5b3caec_images (1).jpg', '68875f5b3cdcb_one-step-from-reality-obooko.pdf', '2025-07-28 11:30:35'),
(4, 'Pantera_reinke', '9087567890', 'Dickson Joseph', 2, '68875f9fa77fe_images (2).jpg', '68875f9fa7a2f_Pantera_reinke.pdf', '2025-07-28 11:31:43'),
(5, 'Christmas Books', '90875678905', 'Josiah Daniels', 3, '688760751c314_images.jpg', '688760751c66b_688735ad3d65e-christmas-stories-for-children-.pdf', '2025-07-28 11:35:17'),
(6, 'Ganja ', '90875633478', 'Timothy Nelly', 4, '688760c1c6c84_f7c812c9b0296cd9f119e33a06d9a256.jpg', '688760c1c72e6_weed-book-adrift-in-a-sea-of-ganja-obooko.pdf', '2025-07-28 11:36:33');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `category` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `category`) VALUES
(1, 'Crimes'),
(2, 'Fiction'),
(3, 'Kids'),
(4, 'Comedy');

-- --------------------------------------------------------

--
-- Table structure for table `downloads`
--

CREATE TABLE `downloads` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `bought_on` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `downloads`
--

INSERT INTO `downloads` (`id`, `user_id`, `book_id`, `category_id`, `bought_on`) VALUES
(1, 2, 3, 2, '2025-07-28 05:40:19'),
(2, 2, 2, 1, '2025-07-28 06:32:36'),
(3, 2, 6, 4, '2025-07-28 06:34:04');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `library_name` varchar(255) NOT NULL,
  `admin_email` varchar(255) DEFAULT NULL,
  `download_limit` int(11) DEFAULT 0,
  `logo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `library_name`, `admin_email`, `download_limit`, `logo`, `created_at`, `updated_at`) VALUES
(1, 'BookStore', 'salamsamiat45@gmail.com', 0, '68877d19a2d7b_fantasy-angel-gold-digital-art-5k-0e-1366x768.jpg', '2025-07-26 19:42:19', '2025-07-28 13:37:29');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(150) NOT NULL,
  `role_as` enum('admin','user') NOT NULL DEFAULT 'user',
  `verification_token` varchar(100) DEFAULT NULL,
  `is_verified` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `fname`, `lname`, `username`, `password`, `phone`, `email`, `role_as`, `verification_token`, `is_verified`, `created_at`, `address`) VALUES
(1, 'Abdulquadri', 'Abdulsalam', 'Abdulsalam123', '$2y$10$S090cxs67R9JWY/EZKAAi.vHwPfo60Fs/Y8dBpPHN7Az1o4Em2xs2', '07082648913', 'moneyraiser43@gmail.com', 'admin', 'fe39dcf1d476be3fe6a4ed0854b1bdb09efa5966c6823eac39a63a915af3d8b6', 1, '2025-07-24 08:01:38', '28 Aina street off johnson busstop surulere lagos'),
(2, 'Reginald', 'Abdulsalam', 'Reginald2', '$2y$10$XbxieBHE1wjSwMI0a4rU7efHvmapfDCKIt4pe6G4tYZunhnOKUDJK', '08127728103', 'officialsouthamptonacademy@gmail.com', 'user', '5d52eb4e08e554eab5282d4b08da188446c8ca18d8f58c5479753bfd60735d4e', 1, '2025-07-24 08:28:20', '29 Aina street off johnson busstop surulere lagos'),
(3, 'Tolu', 'Dixon', 'Money_raiser1', '$2y$10$gA0BRU.buS4SAyAWQ0gM0Or4UcnsBaQz3DarWCnHCKYZ8brPI1F6i', '08127728104', 'salamsamiat45@gmail.com', 'user', '7ec85c7750293439043a2e3781057f938023594f2fd0b8b30376fecb7d96a482', 0, '2025-07-30 10:47:40', '28 Aina street off johnson busstop surulere lagos');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `isbn` (`isbn`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `downloads`
--
ALTER TABLE `downloads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `downloads`
--
ALTER TABLE `downloads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
