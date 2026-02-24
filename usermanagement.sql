-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 24, 2026 at 04:54 PM
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
-- Database: `usermanagement`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(120) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `firstname` varchar(60) NOT NULL,
  `lastname` varchar(60) NOT NULL,
  `gender` enum('male','female','other') DEFAULT 'other',
  `nationality` varchar(80) DEFAULT NULL,
  `contact_number` varchar(30) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password_hash`, `role`, `firstname`, `lastname`, `gender`, `nationality`, `contact_number`, `created_at`) VALUES
(2, 'jreyes_admin', 'juan.reyes@systemmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9fH0eYl9F8Z0kC5Q8K1Y2K', 'admin', 'Juan', 'Reyes', 'male', 'Filipino', '09181234502', '2026-02-16 08:11:58'),
(3, 'lgarcia_admin', 'leo.garcia@systemmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9fH0eYl9F8Z0kC5Q8K1Y2K', 'admin', 'Leo', 'Garcia', 'male', 'Filipino', '09191234503', '2026-02-16 08:11:58'),
(5, 'pjimenez', 'paolo.jimenez@yahoo.com', '$2y$10$e0NR0LYKX2F6Y8C5tG1c2eY1z0uFqO8cG7hL9kM2pQ4rT6uV8wXy', 'user', 'Paolo', 'Jimenez', 'male', 'Filipino', '09170010002', '2026-02-16 08:11:58'),
(6, 'ksantos', 'karen.santos@gmail.com', '$2y$10$e0NR0LYKX2F6Y8C5tG1c2eY1z0uFqO8cG7hL9kM2pQ4rT6uV8wXy', 'user', 'Karen', 'Santos', 'female', 'Filipino', '09170010003', '2026-02-16 08:11:58'),
(7, 'mdizon', 'miguel.dizon@gmail.com', '$2y$10$e0NR0LYKX2F6Y8C5tG1c2eY1z0uFqO8cG7hL9kM2pQ4rT6uV8wXy', 'user', 'Miguel', 'Dizon', 'male', 'Filipino', '09170010004', '2026-02-16 08:11:58'),
(8, 'lfernandez', 'lara.fernandez@gmail.com', '$2y$10$e0NR0LYKX2F6Y8C5tG1c2eY1z0uFqO8cG7hL9kM2pQ4rT6uV8wXy', 'user', 'Lara', 'Fernandez', 'female', 'Filipino', '09170010005', '2026-02-16 08:11:58'),
(9, 'jtorres', 'john.torres@gmail.com', '$2y$10$e0NR0LYKX2F6Y8C5tG1c2eY1z0uFqO8cG7hL9kM2pQ4rT6uV8wXy', 'user', 'John', 'Torres', 'male', 'Filipino', '09170010006', '2026-02-16 08:11:58'),
(10, 'asantiago', 'alyssa.santiago@gmail.com', '$2y$10$e0NR0LYKX2F6Y8C5tG1c2eY1z0uFqO8cG7hL9kM2pQ4rT6uV8wXy', 'user', 'Alyssa', 'Santiago', 'female', 'Filipino', '09170010007', '2026-02-16 08:11:58'),
(11, 'rlopez', 'ryan.lopez@gmail.com', '$2y$10$e0NR0LYKX2F6Y8C5tG1c2eY1z0uFqO8cG7hL9kM2pQ4rT6uV8wXy', 'user', 'Ryan', 'Lopez', 'male', 'Filipino', '09170010008', '2026-02-16 08:11:58'),
(12, 'bvelasco', 'bianca.velasco@gmail.com', '$2y$10$e0NR0LYKX2F6Y8C5tG1c2eY1z0uFqO8cG7hL9kM2pQ4rT6uV8wXy', 'user', 'Bianca', 'Velasco', 'female', 'Filipino', '09170010009', '2026-02-16 08:11:58'),
(15, 'eze', 'eze@gmail.com', '$2y$10$Z4XKSS1sxM87fpU.tNIStOB9l3X3zyih4rUi/Vh4zU13fe8DIufym', 'admin', 'Ezequel', 'Gilayy', 'male', 'Filipino', '09514025672', '2026-02-24 14:29:54'),
(17, 'cha', 'cha@gmail.com', '$2y$10$jKS2QYIV8.yYfP88dO6FxugZ2qtYkZrjFJ9gV9VHj4eLrcmSata2C', 'user', 'chaldeane', 'Umpay', 'other', NULL, NULL, '2026-02-24 14:57:30'),
(19, 'test', 'test@gmail.com', '$2y$10$4mcFpRUZRz38XYp87dC5e.v1ZzEcC.5LTNucn5yMnLIdvg6F/fCbC', 'admin', 'test', 'testt', 'female', 'Filipino', '09514025672', '2026-02-24 15:11:08'),
(21, 'mcruz_admin', 'maria.cruz@systemmail.com', '$2y$10$lwADbko9GpS0Gyv5Y8VAde0IxP3P4V/BH5t38L4ezwzEs9d1RY9HW', 'admin', 'Maria', 'Cruz', 'female', 'Filipino', '09171234501', '2026-02-24 15:34:21'),
(23, 'aramos', 'anna.ramos@gmail.com', '$2y$10$OCOfjzxwj3aPGlIJ5CxpgusdP31YJ22vzifD19upIo0p12.HtiDdK', 'user', 'Anna', 'Ramos', 'female', 'Filipino', '09170010001', '2026-02-24 15:37:08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
