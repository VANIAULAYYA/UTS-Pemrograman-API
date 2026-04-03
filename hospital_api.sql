/*
SQLyog Professional v12.4.3 (64 bit)
MySQL - 8.0.30 : Database - hospital_api
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`hospital_api` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `hospital_api`;

/*Table structure for table `appointments` */

DROP TABLE IF EXISTS `appointments`;

CREATE TABLE `appointments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `patient_id` int NOT NULL,
  `doctor_id` int NOT NULL,
  `appointment_date` datetime NOT NULL,
  `complaint` text,
  `status` enum('pending','done','cancelled') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `patient_id` (`patient_id`),
  KEY `doctor_id` (`doctor_id`),
  CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE,
  CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `appointments` */

insert  into `appointments`(`id`,`patient_id`,`doctor_id`,`appointment_date`,`complaint`,`status`,`created_at`,`updated_at`) values 
(1,1,1,'2025-04-05 09:00:00','Demam dan batuk','done','2026-04-02 23:38:33','2026-04-03 02:21:14'),
(2,2,2,'2025-04-05 10:00:00','Kontrol rutin anak','pending','2026-04-02 23:38:33','2026-04-02 23:38:33'),
(3,1,2,'2026-04-10 09:00:00','Sakit kepala dan pusing','pending','2026-04-03 02:20:49','2026-04-03 02:20:49');

/*Table structure for table `doctors` */

DROP TABLE IF EXISTS `doctors`;

CREATE TABLE `doctors` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `specialization` varchar(100) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `doctors` */

insert  into `doctors`(`id`,`name`,`specialization`,`phone`,`created_at`,`updated_at`) values 
(1,'dr. Andi Wijaya','Umum','081111111111','2026-04-02 23:38:10','2026-04-02 23:38:10'),
(2,'dr. Sari Dewi','Anak','082222222222','2026-04-02 23:38:10','2026-04-02 23:38:10'),
(3,'dr. Budi Santoso','Jantung','083333333333','2026-04-02 23:38:10','2026-04-02 23:38:10'),
(4,'dr. Citra Lestari','Kulit','084444444444','2026-04-03 02:18:42','2026-04-03 02:18:42');

/*Table structure for table `patients` */

DROP TABLE IF EXISTS `patients`;

CREATE TABLE `patients` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `nik` varchar(16) NOT NULL,
  `birth_date` date NOT NULL,
  `gender` enum('Laki-laki','Perempuan') NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `address` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nik` (`nik`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `patients` */

insert  into `patients`(`id`,`name`,`nik`,`birth_date`,`gender`,`phone`,`address`,`created_at`,`updated_at`) values 
(1,'Ahmad Fauzi Updated','3578010101990001','1999-01-01','Laki-laki','089999999999','Jl. Baru No. 99 Surabaya','2026-04-02 23:38:21','2026-04-03 02:15:49'),
(2,'Siti Rahayu','3578010202000002','2000-02-02','Perempuan','085222222222','Jl. Gubeng No. 5','2026-04-02 23:38:21','2026-04-02 23:38:21'),
(3,'Dewi Putri','3578010303010003','2001-03-03','Perempuan','085333333333','Jl. Pemuda No. 15 Surabaya','2026-04-03 02:14:46','2026-04-03 02:14:46');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
