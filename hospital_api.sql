-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 15, 2026 at 07:50 PM
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
-- Database: `hospital_api`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `appointment_date` datetime NOT NULL,
  `complaint` text DEFAULT NULL,
  `status` enum('pending','done','cancelled') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `patient_id`, `doctor_id`, `appointment_date`, `complaint`, `status`, `created_at`, `updated_at`) VALUES
(2, 2, 2, '2025-04-05 10:00:00', 'Kontrol rutin anak', 'pending', '2026-04-13 02:39:18', '2026-04-13 02:39:18'),
(4, 3, 1, '2026-04-12 11:00:00', 'Nyeri perut', 'pending', '2026-04-15 07:54:42', '2026-04-15 07:54:42');

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `specialization` varchar(100) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `name`, `specialization`, `phone`, `created_at`, `updated_at`) VALUES
(1, 'dr. Andi Wijaya', 'Umum', '081111111111', '2026-04-13 02:39:18', '2026-04-13 02:39:18'),
(2, 'dr. Sari Dewi', 'Anak', '082222222222', '2026-04-13 02:39:18', '2026-04-13 02:39:18'),
(3, 'dr. Budi Santoso', 'Jantung', '083333333333', '2026-04-13 02:39:18', '2026-04-13 02:39:18'),
(4, 'dr. Citra Lestari', 'Kulit', '084444444444', '2026-04-13 02:39:18', '2026-04-13 02:39:18');

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `nik` varchar(16) NOT NULL,
  `birth_date` date NOT NULL,
  `gender` enum('Laki-laki','Perempuan') NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `name`, `nik`, `birth_date`, `gender`, `phone`, `address`, `created_at`, `updated_at`) VALUES
(2, 'Siti Rahayu', '3578010202000002', '2000-02-02', 'Perempuan', '085222222222', 'Jl. Gubeng No. 5', '2026-04-13 02:39:18', '2026-04-13 02:39:18'),
(3, 'Dewi Putri', '3578010303010003', '2001-03-03', 'Perempuan', '085333333333', 'Jl. Pemuda No. 15 Surabaya', '2026-04-13 02:39:18', '2026-04-13 02:39:18'),
(4, 'Pasien Baru', '1234567890123456', '1995-05-15', 'Laki-laki', '08123456789', 'Jl. Contoh No. 123', '2026-04-15 07:58:54', '2026-04-15 07:58:54');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `gender` enum('Laki-laki','Perempuan') DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `api_key` varchar(100) DEFAULT NULL,
  `api_key_created_at` timestamp NULL DEFAULT NULL,
  `api_key_expires_at` timestamp NULL DEFAULT NULL,
  `role` enum('admin','staff','doctor') DEFAULT 'staff',
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `fullname`, `email`, `phone`, `gender`, `password`, `api_key`, `api_key_created_at`, `api_key_expires_at`, `role`, `is_active`, `created_at`) VALUES
(1, 'admin', 'Administrator', 'admin@hospital.com', '08123456789', 'Laki-laki', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, NULL, NULL, 'admin', 1, '2026-04-13 02:39:18'),
(2, 'Putri', 'putri rini', 'putri@gmail.com', '0845642', 'Perempuan', '$2y$10$LHoW/MJc9TuAGBKVT7dR..sHcY04s5vcdNdMQhEtMVGPo8ov/0HBO', '9b5fd43161437d52b7c28ee7df6e02eaa71c069bacb2e93a838c689859bb0ee6', '2026-04-13 02:54:30', '2027-04-13 02:54:30', 'staff', 1, '2026-04-13 02:54:30'),
(3, 'namauser_baru', 'Nama Lengkap User', 'email@domain.com', '08123456789', 'Laki-laki', '$2y$10$yolGfHwWNgogWjxvC5w87Olu05KisUJ/VO4j01r0LrWRpFpKJmeyu', '1396e4dfb847c44e818a08c33dfe3eff08725e26e424686703de95ab8a55accd', '2026-04-15 09:03:14', '2027-04-15 09:03:14', 'staff', 1, '2026-04-15 09:03:14'),
(4, 'bebek', 'bebek goreng', 'bebek@gmail.com', '123456', 'Laki-laki', '$2y$10$pNA6A4zrf4y8YDyXBay51eTVA5osd9Z4iZuQJDvVGMF1i2rHwWP2m', '2185875ce12dadd3a88b9cb545abe773bb34fd97c7dac3bb3ee40be90c1879c4', '2026-04-15 15:57:13', '2027-04-15 15:57:13', 'staff', 1, '2026-04-15 15:57:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nik` (`nik`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `api_key` (`api_key`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
