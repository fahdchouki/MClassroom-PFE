-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 19, 2022 at 09:17 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mclassroom`
--

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `idCourse` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL,
  `idUser` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `course_for_group`
--

CREATE TABLE `course_for_group` (
  `idCourse` int(11) NOT NULL,
  `idGroup` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `idEvent` int(11) NOT NULL,
  `title` varchar(900) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `idUser` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_for_group`
--

CREATE TABLE `event_for_group` (
  `idEvent` int(11) NOT NULL,
  `idGroup` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exercice`
--

CREATE TABLE `exercice` (
  `idExercice` int(11) NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `joingroup`
--

CREATE TABLE `joingroup` (
  `idUser` int(11) NOT NULL,
  `idGroup` int(11) NOT NULL,
  `joined_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `joingroup`
--

INSERT INTO `joingroup` (`idUser`, `idGroup`, `joined_at`) VALUES
(1, 1, '2022-06-19 18:43:34');

-- --------------------------------------------------------

--
-- Table structure for table `livechat`
--

CREATE TABLE `livechat` (
  `idLive` int(11) NOT NULL,
  `subject` varchar(900) COLLATE utf8mb4_unicode_ci NOT NULL,
  `channel` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `for_date` datetime NOT NULL,
  `idUser` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `livechat_for_group`
--

CREATE TABLE `livechat_for_group` (
  `idLive` int(11) NOT NULL,
  `idGroup` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `idMessage` int(11) NOT NULL,
  `content` varchar(800) COLLATE utf8mb4_bin NOT NULL,
  `idUser` int(11) NOT NULL,
  `idGroup` int(11) NOT NULL,
  `created_at` datetime(4) NOT NULL DEFAULT current_timestamp(4)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `m_group`
--

CREATE TABLE `m_group` (
  `idGroup` int(11) NOT NULL,
  `label` varchar(90) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_icon` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_type` tinyint(4) NOT NULL,
  `idUser` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `m_group`
--

INSERT INTO `m_group` (`idGroup`, `label`, `group_icon`, `group_type`, `idUser`, `created_at`) VALUES
(1, 'Reseaux informatiques', 'default.jpg', 1, 1, '2022-06-19 18:43:34');

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `idNotification` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` tinyint(4) NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notification_for_group`
--

CREATE TABLE `notification_for_group` (
  `idNotification` int(11) NOT NULL,
  `idGroup` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notification_for_user`
--

CREATE TABLE `notification_for_user` (
  `idNotification` int(11) NOT NULL,
  `idUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quiz`
--

CREATE TABLE `quiz` (
  `idQuiz` int(11) NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `submittask`
--

CREATE TABLE `submittask` (
  `idUser` int(11) NOT NULL,
  `idTask` int(11) NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `submit_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `idTask` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL,
  `task_type` tinyint(4) NOT NULL,
  `id_type` int(11) NOT NULL,
  `deadline` date NOT NULL,
  `idUser` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `task_for_group`
--

CREATE TABLE `task_for_group` (
  `idTask` int(11) NOT NULL,
  `idGroup` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `task_for_user`
--

CREATE TABLE `task_for_user` (
  `idTask` int(11) NOT NULL,
  `idUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `idUser` int(11) NOT NULL,
  `name` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `school_subject` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_type` tinyint(4) NOT NULL,
  `account_token` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`idUser`, `name`, `username`, `email`, `password`, `school_subject`, `photo`, `account_type`, `account_token`) VALUES
(1, 'fahd chouki', 'fahdchouki', 'freecamp007@gmail.com', '7c222fb2927d828af22f592134e8932480637c0d', 'Reseaux informatiques', 'default.jpg', 2, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`idCourse`),
  ADD KEY `create_course` (`idUser`);

--
-- Indexes for table `course_for_group`
--
ALTER TABLE `course_for_group`
  ADD KEY `idCourse` (`idCourse`),
  ADD KEY `idGroup` (`idGroup`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`idEvent`),
  ADD KEY `create_event` (`idUser`);

--
-- Indexes for table `event_for_group`
--
ALTER TABLE `event_for_group`
  ADD KEY `idEvent` (`idEvent`),
  ADD KEY `idGroup` (`idGroup`);

--
-- Indexes for table `exercice`
--
ALTER TABLE `exercice`
  ADD PRIMARY KEY (`idExercice`);

--
-- Indexes for table `joingroup`
--
ALTER TABLE `joingroup`
  ADD KEY `idGroup` (`idGroup`),
  ADD KEY `idUser` (`idUser`);

--
-- Indexes for table `livechat`
--
ALTER TABLE `livechat`
  ADD PRIMARY KEY (`idLive`),
  ADD KEY `create_live` (`idUser`);

--
-- Indexes for table `livechat_for_group`
--
ALTER TABLE `livechat_for_group`
  ADD KEY `idGroup` (`idGroup`),
  ADD KEY `idLive` (`idLive`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`idMessage`),
  ADD KEY `belongs_to` (`idGroup`),
  ADD KEY `create_message` (`idUser`);

--
-- Indexes for table `m_group`
--
ALTER TABLE `m_group`
  ADD PRIMARY KEY (`idGroup`),
  ADD KEY `create_group` (`idUser`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`idNotification`);

--
-- Indexes for table `notification_for_group`
--
ALTER TABLE `notification_for_group`
  ADD KEY `idNotification` (`idNotification`),
  ADD KEY `idGroup` (`idGroup`);

--
-- Indexes for table `notification_for_user`
--
ALTER TABLE `notification_for_user`
  ADD KEY `idNotification` (`idNotification`),
  ADD KEY `idUser` (`idUser`);

--
-- Indexes for table `quiz`
--
ALTER TABLE `quiz`
  ADD PRIMARY KEY (`idQuiz`);

--
-- Indexes for table `submittask`
--
ALTER TABLE `submittask`
  ADD KEY `idTask` (`idTask`),
  ADD KEY `idUser` (`idUser`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`idTask`),
  ADD KEY `idUser` (`idUser`);

--
-- Indexes for table `task_for_group`
--
ALTER TABLE `task_for_group`
  ADD KEY `idGroup` (`idGroup`),
  ADD KEY `idTask` (`idTask`);

--
-- Indexes for table `task_for_user`
--
ALTER TABLE `task_for_user`
  ADD KEY `idTask` (`idTask`),
  ADD KEY `idUser` (`idUser`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`idUser`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `idCourse` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `idEvent` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exercice`
--
ALTER TABLE `exercice`
  MODIFY `idExercice` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `livechat`
--
ALTER TABLE `livechat`
  MODIFY `idLive` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `idMessage` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_group`
--
ALTER TABLE `m_group`
  MODIFY `idGroup` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `idNotification` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quiz`
--
ALTER TABLE `quiz`
  MODIFY `idQuiz` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `idTask` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `course`
--
ALTER TABLE `course`
  ADD CONSTRAINT `create_course` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `course_for_group`
--
ALTER TABLE `course_for_group`
  ADD CONSTRAINT `course_for_group_ibfk_1` FOREIGN KEY (`idCourse`) REFERENCES `course` (`idCourse`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `course_for_group_ibfk_2` FOREIGN KEY (`idGroup`) REFERENCES `m_group` (`idGroup`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `create_event` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `event_for_group`
--
ALTER TABLE `event_for_group`
  ADD CONSTRAINT `event_for_group_ibfk_1` FOREIGN KEY (`idEvent`) REFERENCES `event` (`idEvent`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `event_for_group_ibfk_2` FOREIGN KEY (`idGroup`) REFERENCES `m_group` (`idGroup`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `joingroup`
--
ALTER TABLE `joingroup`
  ADD CONSTRAINT `joingroup_ibfk_1` FOREIGN KEY (`idGroup`) REFERENCES `m_group` (`idGroup`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `joingroup_ibfk_2` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `livechat`
--
ALTER TABLE `livechat`
  ADD CONSTRAINT `create_live` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `livechat_for_group`
--
ALTER TABLE `livechat_for_group`
  ADD CONSTRAINT `livechat_for_group_ibfk_1` FOREIGN KEY (`idGroup`) REFERENCES `m_group` (`idGroup`) ON DELETE CASCADE,
  ADD CONSTRAINT `livechat_for_group_ibfk_2` FOREIGN KEY (`idLive`) REFERENCES `livechat` (`idLive`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `belongs_to` FOREIGN KEY (`idGroup`) REFERENCES `m_group` (`idGroup`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `create_message` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `m_group`
--
ALTER TABLE `m_group`
  ADD CONSTRAINT `create_group` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notification_for_group`
--
ALTER TABLE `notification_for_group`
  ADD CONSTRAINT `notification_for_group_ibfk_1` FOREIGN KEY (`idNotification`) REFERENCES `notification` (`idNotification`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notification_for_group_ibfk_2` FOREIGN KEY (`idGroup`) REFERENCES `m_group` (`idGroup`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notification_for_user`
--
ALTER TABLE `notification_for_user`
  ADD CONSTRAINT `notification_for_user_ibfk_1` FOREIGN KEY (`idNotification`) REFERENCES `notification` (`idNotification`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notification_for_user_ibfk_2` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `submittask`
--
ALTER TABLE `submittask`
  ADD CONSTRAINT `submittask_ibfk_1` FOREIGN KEY (`idTask`) REFERENCES `task` (`idTask`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `submittask_ibfk_2` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `task_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `task_for_group`
--
ALTER TABLE `task_for_group`
  ADD CONSTRAINT `task_for_group_ibfk_1` FOREIGN KEY (`idGroup`) REFERENCES `m_group` (`idGroup`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `task_for_group_ibfk_2` FOREIGN KEY (`idTask`) REFERENCES `task` (`idTask`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `task_for_user`
--
ALTER TABLE `task_for_user`
  ADD CONSTRAINT `task_for_user_ibfk_1` FOREIGN KEY (`idTask`) REFERENCES `task` (`idTask`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `task_for_user_ibfk_2` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
