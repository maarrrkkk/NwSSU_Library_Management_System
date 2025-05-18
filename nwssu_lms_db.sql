-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 18, 2025 at 09:46 AM
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
-- Database: `nwssu_lms_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `borrowed_books`
--

CREATE TABLE `borrowed_books` (
  `id` int(11) NOT NULL,
  `book_title` varchar(255) NOT NULL,
  `borrow_date` date NOT NULL,
  `return_date` date NOT NULL,
  `borrower_id` int(11) NOT NULL,
  `borrowed_name` varchar(255) DEFAULT NULL,
  `book_id` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `borrowed_books`
--

INSERT INTO `borrowed_books` (`id`, `book_title`, `borrow_date`, `return_date`, `borrower_id`, `borrowed_name`, `book_id`) VALUES
(48, 'English', '2025-05-15', '2025-05-23', 33, 'John Mark Aguilar', 'E-344'),
(49, 'Math', '2025-05-06', '2025-05-09', 33, 'John Mark Aguilar', 'M-324'),
(50, 'Algebra', '2025-05-18', '2025-05-23', 34, 'Emely', 'ALGE-342');

-- --------------------------------------------------------

--
-- Table structure for table `borrowers`
--

CREATE TABLE `borrowers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `status` varchar(50) NOT NULL,
  `student_id` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `number_of_books` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `borrowers`
--

INSERT INTO `borrowers` (`id`, `name`, `age`, `status`, `student_id`, `email`, `phone`, `number_of_books`) VALUES
(33, 'John Mark Aguilar', 22, 'Graduated', '', 'johnmarkaguilar405@gmail.com', '09659604430', 2),
(34, 'Emely', 26, 'Student', '22-23568', 'emely@gmail.com', '03214569878', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `surname` varchar(50) DEFAULT NULL,
  `full_name` varchar(150) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `position` enum('admin','librarian assistant') DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `university_id` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `middle_name`, `surname`, `full_name`, `age`, `position`, `email`, `phone`, `university_id`, `password`) VALUES
(3, 'John Mark', 'Pantacan', 'Aguilar', 'John Mark Pantacan Aguilar', 22, 'admin', 'johnmarkaguilar405@gmail.com', '09659604430', '20-2236852', '$2y$10$6dDg6rEMMmnfG8tvolUXiux6trxa/iAp0vyYwVn9h2lYWekrgn4Vq'),
(4, 'Emely', 'Char', 'Taduyo', 'Emely Char Taduyo', 26, 'admin', 'emely@gmail.com', '01234567898', '2255-6598', '$2y$10$Jui/2NdfSp6PqYy5KcORZOuomh2xKXEOeYQulttcO2eYYUtZZIeDi');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `borrowed_books`
--
ALTER TABLE `borrowed_books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `borrower_id` (`borrower_id`);

--
-- Indexes for table `borrowers`
--
ALTER TABLE `borrowers`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `borrowed_books`
--
ALTER TABLE `borrowed_books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `borrowers`
--
ALTER TABLE `borrowers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `borrowed_books`
--
ALTER TABLE `borrowed_books`
  ADD CONSTRAINT `borrowed_books_ibfk_1` FOREIGN KEY (`borrower_id`) REFERENCES `borrowers` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
