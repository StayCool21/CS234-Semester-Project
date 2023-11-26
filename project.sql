-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 26, 2023 at 09:36 PM
-- Server version: 5.7.24
-- PHP Version: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(6) UNSIGNED NOT NULL,
  `course_code` varchar(50) NOT NULL,
  `course_name` varchar(100) NOT NULL,
  `course_instructor` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `course_code`, `course_name`, `course_instructor`) VALUES
(1, 'CS111', 'Introduction to Computer Science', 'Randy Smith'),
(2, 'CS140', 'Introduction to Computing I', 'Tom Green'),
(3, 'CS150', 'Introduction to Computing II', 'Randy Smith'),
(4, 'CS234', 'Introduction to Web Development', 'Billy Bob'),
(5, 'CS286', 'Introduction to Computer Architecture and Organization', 'Randy Smith'),
(6, 'CS314', 'Operating Systems', 'Tom Green'),
(7, 'CS325', 'Software Engineering', 'Tom Green'),
(8, 'CS425', 'Senior Project: Software Design', 'Billy Bob'),
(9, 'CS499', 'Senior Project: Software Implementation', 'Randy Smith');

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE `registration` (
  `id` int(6) UNSIGNED NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varbinary(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`id`, `username`, `password`) VALUES
(1, 'admin', 0x243279243130244d75714751766949436b2e6730586636635144396975515947616d457853784e53716b6e3338444c2e5878724a6d426b6b2f703547),
(2, 'spongebob', 0x243279243130244c7263655563353955726a65563778424f594335624f6379585a744353614338703068692f6f7942715038395271586d6c36475a47),
(3, 'patrick', 0x243279243130244433533330754c4544413642426e682e54414f70552e624e4a69637532644e6e547732416458314530484a392f70715078546f4432),
(4, 'mrkrabs', 0x243279243130244d2e72782f3544696b535947563259776543564f45755049545043756b64446e6b535735713130444a705a54632e5549694a756661),
(5, 'sandy', 0x24327924313024636541393334502f586a376b737072674f7272497565776a545875484e66592e7872394a2f4e7647574b7853346d4a6e7a35517447);

-- --------------------------------------------------------

--
-- Table structure for table `user_courses`
--

CREATE TABLE `user_courses` (
  `id` int(6) UNSIGNED NOT NULL,
  `user_id` int(6) UNSIGNED NOT NULL,
  `course_id` int(6) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_courses`
--

INSERT INTO `user_courses` (`id`, `user_id`, `course_id`) VALUES
(1, 2, 4),
(2, 2, 5),
(3, 2, 6),
(4, 3, 6),
(5, 3, 7),
(6, 3, 8),
(7, 4, 4),
(8, 4, 6),
(9, 4, 8),
(10, 5, 2),
(11, 5, 4),
(12, 5, 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_courses`
--
ALTER TABLE `user_courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `course_id` (`course_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `registration`
--
ALTER TABLE `registration`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_courses`
--
ALTER TABLE `user_courses`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_courses`
--
ALTER TABLE `user_courses`
  ADD CONSTRAINT `user_courses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `registration` (`id`),
  ADD CONSTRAINT `user_courses_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
