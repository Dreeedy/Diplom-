-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.3.22-MariaDB-log - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             11.0.0.5958
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for tania_valerova
CREATE DATABASE IF NOT EXISTS `tania_valerova` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `tania_valerova`;

-- Dumping structure for table tania_valerova.actstypes
CREATE TABLE IF NOT EXISTS `actstypes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type_code` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tania_valerova.actstypes: ~5 rows (approximately)
DELETE FROM `actstypes`;
/*!40000 ALTER TABLE `actstypes` DISABLE KEYS */;
INSERT INTO `actstypes` (`id`, `type_name`, `type_code`) VALUES
	(1, 'Свидетельство о заключении брака', 0),
	(2, 'Свидетельство о рождении', 1),
	(3, 'Свидетельство о усыновлении', 2),
	(4, 'Свидетельство о смерти', 3),
	(5, 'Свидетельство о расторжении брака', 4);
/*!40000 ALTER TABLE `actstypes` ENABLE KEYS */;

-- Dumping structure for table tania_valerova.adoptionacts
CREATE TABLE IF NOT EXISTS `adoptionacts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `date_birth` date DEFAULT NULL,
  `date_adoption` date DEFAULT NULL,
  `date` date DEFAULT NULL,
  `husband_id` int(11) unsigned DEFAULT NULL,
  `wife_id` int(11) unsigned DEFAULT NULL,
  `child_id` int(11) unsigned DEFAULT NULL,
  `staff_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `index_foreignkey_adoptionacts_husband` (`husband_id`),
  KEY `index_foreignkey_adoptionacts_wife` (`wife_id`),
  KEY `index_foreignkey_adoptionacts_child` (`child_id`),
  KEY `index_foreignkey_adoptionacts_staff` (`staff_id`),
  CONSTRAINT `c_fk_adoptionacts_child_id` FOREIGN KEY (`child_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `c_fk_adoptionacts_husband_id` FOREIGN KEY (`husband_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `c_fk_adoptionacts_staff_id` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `c_fk_adoptionacts_wife_id` FOREIGN KEY (`wife_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tania_valerova.adoptionacts: ~0 rows (approximately)
DELETE FROM `adoptionacts`;
/*!40000 ALTER TABLE `adoptionacts` DISABLE KEYS */;
INSERT INTO `adoptionacts` (`id`, `date_birth`, `date_adoption`, `date`, `husband_id`, `wife_id`, `child_id`, `staff_id`) VALUES
	(1, '2005-01-01', '2020-01-01', '2021-04-12', 17, 18, 19, 1);
/*!40000 ALTER TABLE `adoptionacts` ENABLE KEYS */;

-- Dumping structure for table tania_valerova.birthacts
CREATE TABLE IF NOT EXISTS `birthacts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `date_birth` date DEFAULT NULL,
  `date` date DEFAULT NULL,
  `husband_id` int(11) unsigned DEFAULT NULL,
  `wife_id` int(11) unsigned DEFAULT NULL,
  `child_id` int(11) unsigned DEFAULT NULL,
  `staff_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `index_foreignkey_birthacts_husband` (`husband_id`),
  KEY `index_foreignkey_birthacts_wife` (`wife_id`),
  KEY `index_foreignkey_birthacts_child` (`child_id`),
  KEY `index_foreignkey_birthacts_staff` (`staff_id`),
  CONSTRAINT `c_fk_birthacts_child_id` FOREIGN KEY (`child_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `c_fk_birthacts_husband_id` FOREIGN KEY (`husband_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `c_fk_birthacts_staff_id` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `c_fk_birthacts_wife_id` FOREIGN KEY (`wife_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tania_valerova.birthacts: ~2 rows (approximately)
DELETE FROM `birthacts`;
/*!40000 ALTER TABLE `birthacts` DISABLE KEYS */;
INSERT INTO `birthacts` (`id`, `date_birth`, `date`, `husband_id`, `wife_id`, `child_id`, `staff_id`) VALUES
	(1, '2005-04-03', '2021-01-10', 7, 8, 15, 1),
	(2, '2006-02-01', '2021-02-10', 7, 8, 16, 1);
/*!40000 ALTER TABLE `birthacts` ENABLE KEYS */;

-- Dumping structure for table tania_valerova.customers
CREATE TABLE IF NOT EXISTS `customers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `gender` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `surname` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `middle_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_birth` date DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `main_surname` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `roles_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `index_foreignkey_customers_roles` (`roles_id`),
  CONSTRAINT `c_fk_customers_roles_id` FOREIGN KEY (`roles_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tania_valerova.customers: ~10 rows (approximately)
DELETE FROM `customers`;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` (`id`, `gender`, `surname`, `name`, `middle_name`, `date_birth`, `address`, `phone_number`, `main_surname`, `roles_id`) VALUES
	(7, 'Мужчина', 'Иванов', 'Иван', 'Иванович', '1990-02-02', 'Василькова 22', '111111111111111', 'Иванов', 1),
	(8, 'Женщина', 'Иванова', 'Инна', 'Васильевна', '1990-03-03', 'Аэродромная 33', '222222222222222', 'Зиганшина', 1),
	(9, 'Мужчина', 'Федоров', 'Федор', 'Федорович', '1990-01-01', 'Ферова 34', '111111111111111', 'Федоров', 1),
	(10, 'Женщина', 'Цветкова', 'Оля', 'Олеговна', '1990-04-04', 'Цветочная 44', '111111111111111', 'Цветков', 1),
	(12, 'Мужчина', 'Иванов', 'Сергей', 'Иванович', '2014-04-04', NULL, NULL, 'Иванов', 1),
	(14, 'Женщина', 'Мультикова', 'Валя', 'Васильевна', '2005-09-09', '', '', 'Мультикова', 1),
	(15, 'Мужчина', 'Иванов', 'Олег', 'Иванович', '2005-04-03', NULL, NULL, 'Иванов', 1),
	(16, 'Мужчина', 'Иванов', 'Петр', 'Иванович', '2006-02-01', NULL, NULL, 'Иванов', 1),
	(17, 'Мужчина', 'Мужиков', 'Муж', 'Мужиков', '2000-01-01', 'Адресная 22', '111111111111111', 'Мужиков', 1),
	(18, 'Женщина', 'Женова', 'Жен', 'Женова', '2000-02-01', 'Адресная 33', '222222222222222', 'Женова', 1),
	(19, 'Мужчина', 'Усыновленов', 'Усын', 'Усыновленов', '2005-01-01', NULL, NULL, 'Усыновленов', 1);
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;

-- Dumping structure for table tania_valerova.deathacts
CREATE TABLE IF NOT EXISTS `deathacts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `date_death` date DEFAULT NULL,
  `date` date DEFAULT NULL,
  `customer_id` int(11) unsigned DEFAULT NULL,
  `staff_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `index_foreignkey_deathacts_customer` (`customer_id`),
  KEY `index_foreignkey_deathacts_staff` (`staff_id`),
  CONSTRAINT `c_fk_deathacts_customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `c_fk_deathacts_staff_id` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tania_valerova.deathacts: ~0 rows (approximately)
DELETE FROM `deathacts`;
/*!40000 ALTER TABLE `deathacts` DISABLE KEYS */;
INSERT INTO `deathacts` (`id`, `date_death`, `date`, `customer_id`, `staff_id`) VALUES
	(1, '2021-01-01', '2021-04-12', 17, 1);
/*!40000 ALTER TABLE `deathacts` ENABLE KEYS */;

-- Dumping structure for table tania_valerova.divorceacts
CREATE TABLE IF NOT EXISTS `divorceacts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `date_divorce` date DEFAULT NULL,
  `date` date DEFAULT NULL,
  `staff_id` int(11) unsigned DEFAULT NULL,
  `husband_id` int(11) unsigned DEFAULT NULL,
  `wife_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `index_foreignkey_divorceacts_staff` (`staff_id`),
  KEY `index_foreignkey_divorceacts_husband` (`husband_id`),
  KEY `index_foreignkey_divorceacts_wife` (`wife_id`),
  CONSTRAINT `c_fk_divorceacts_husband_id` FOREIGN KEY (`husband_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `c_fk_divorceacts_staff_id` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `c_fk_divorceacts_wife_id` FOREIGN KEY (`wife_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tania_valerova.divorceacts: ~0 rows (approximately)
DELETE FROM `divorceacts`;
/*!40000 ALTER TABLE `divorceacts` DISABLE KEYS */;
INSERT INTO `divorceacts` (`id`, `date_divorce`, `date`, `staff_id`, `husband_id`, `wife_id`) VALUES
	(1, '2020-02-02', '2021-04-12', 1, 17, 18);
/*!40000 ALTER TABLE `divorceacts` ENABLE KEYS */;

-- Dumping structure for table tania_valerova.marriageacts
CREATE TABLE IF NOT EXISTS `marriageacts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `date_marriage` date DEFAULT NULL,
  `is_active` tinyint(1) unsigned DEFAULT NULL,
  `date` date DEFAULT NULL,
  `staff_id` int(11) unsigned DEFAULT NULL,
  `husband_id` int(11) unsigned DEFAULT NULL,
  `wife_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `index_foreignkey_marriageacts_staff` (`staff_id`),
  KEY `index_foreignkey_marriageacts_husband` (`husband_id`),
  KEY `index_foreignkey_marriageacts_wife` (`wife_id`),
  CONSTRAINT `c_fk_marriageacts_husband_id` FOREIGN KEY (`husband_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `c_fk_marriageacts_staff_id` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `c_fk_marriageacts_wife_id` FOREIGN KEY (`wife_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tania_valerova.marriageacts: ~0 rows (approximately)
DELETE FROM `marriageacts`;
/*!40000 ALTER TABLE `marriageacts` DISABLE KEYS */;
INSERT INTO `marriageacts` (`id`, `date_marriage`, `is_active`, `date`, `staff_id`, `husband_id`, `wife_id`) VALUES
	(1, '2000-03-02', 1, '2021-04-10', 1, 7, 8),
	(2, '2019-01-01', 0, '2021-04-12', 1, 17, 18);
/*!40000 ALTER TABLE `marriageacts` ENABLE KEYS */;

-- Dumping structure for table tania_valerova.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `role_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tania_valerova.roles: ~3 rows (approximately)
DELETE FROM `roles`;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` (`id`, `role_name`, `code`) VALUES
	(1, 'Клиент', 1),
	(2, 'Сотрудник', 2),
	(3, 'Администратор', 3);
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;

-- Dumping structure for table tania_valerova.staff
CREATE TABLE IF NOT EXISTS `staff` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `surname` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `middle_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` double DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `it_works` tinyint(1) unsigned DEFAULT NULL,
  `roles_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `index_foreignkey_staff_roles` (`roles_id`),
  CONSTRAINT `c_fk_staff_roles_id` FOREIGN KEY (`roles_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tania_valerova.staff: ~3 rows (approximately)
DELETE FROM `staff`;
/*!40000 ALTER TABLE `staff` DISABLE KEYS */;
INSERT INTO `staff` (`id`, `surname`, `name`, `middle_name`, `phone_number`, `password`, `it_works`, `roles_id`) VALUES
	(1, 'Иванов', 'Иван', 'Иванович', 79172444941, 'admin', 1, 3),
	(2, 'Зиганшин', 'Зиган', 'Зиганович', 111111111111111, '1234', 1, 2),
	(3, 'Семейников', 'Иголь', 'Олегович', 111111111111111, '1234', 0, 2);
/*!40000 ALTER TABLE `staff` ENABLE KEYS */;

-- Dumping structure for table tania_valerova.usersandbookacts
CREATE TABLE IF NOT EXISTS `usersandbookacts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `locality` tinyint(1) unsigned DEFAULT NULL,
  `year` int(11) unsigned DEFAULT NULL,
  `date` date DEFAULT NULL,
  `act_types_id` int(11) unsigned DEFAULT NULL,
  `marriageacts_id` int(11) unsigned DEFAULT NULL,
  `birthacts_id` int(11) unsigned DEFAULT NULL,
  `adoptionacts_id` int(11) unsigned DEFAULT NULL,
  `deathacts_id` int(11) unsigned DEFAULT NULL,
  `divorceacts_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `index_foreignkey_usersandbookacts_act_types` (`act_types_id`),
  KEY `index_foreignkey_usersandbookacts_marriageacts` (`marriageacts_id`),
  KEY `index_foreignkey_usersandbookacts_birthacts` (`birthacts_id`),
  KEY `index_foreignkey_usersandbookacts_adoptionacts` (`adoptionacts_id`),
  KEY `index_foreignkey_usersandbookacts_deathacts` (`deathacts_id`),
  KEY `index_foreignkey_usersandbookacts_divorceacts` (`divorceacts_id`),
  CONSTRAINT `c_fk_usersandbookacts_act_types_id` FOREIGN KEY (`act_types_id`) REFERENCES `actstypes` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `c_fk_usersandbookacts_adoptionacts_id` FOREIGN KEY (`adoptionacts_id`) REFERENCES `adoptionacts` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `c_fk_usersandbookacts_birthacts_id` FOREIGN KEY (`birthacts_id`) REFERENCES `birthacts` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `c_fk_usersandbookacts_deathacts_id` FOREIGN KEY (`deathacts_id`) REFERENCES `deathacts` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `c_fk_usersandbookacts_divorceacts_id` FOREIGN KEY (`divorceacts_id`) REFERENCES `divorceacts` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `c_fk_usersandbookacts_marriageacts_id` FOREIGN KEY (`marriageacts_id`) REFERENCES `marriageacts` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tania_valerova.usersandbookacts: ~7 rows (approximately)
DELETE FROM `usersandbookacts`;
/*!40000 ALTER TABLE `usersandbookacts` DISABLE KEYS */;
INSERT INTO `usersandbookacts` (`id`, `locality`, `year`, `date`, `act_types_id`, `marriageacts_id`, `birthacts_id`, `adoptionacts_id`, `deathacts_id`, `divorceacts_id`) VALUES
	(1, NULL, 2021, '2021-04-10', 1, 1, NULL, NULL, NULL, NULL),
	(2, NULL, 2021, '2021-04-10', 2, NULL, 1, NULL, NULL, NULL),
	(3, NULL, 2021, '2021-04-10', 2, NULL, 2, NULL, NULL, NULL),
	(4, NULL, 2021, '2021-04-12', 3, NULL, NULL, 1, NULL, NULL),
	(5, NULL, 2021, '2021-04-12', 4, NULL, NULL, NULL, 1, NULL),
	(6, NULL, 2021, '2021-04-12', 1, 2, NULL, NULL, NULL, NULL),
	(7, NULL, 2021, '2021-04-12', 5, NULL, NULL, NULL, NULL, 1);
/*!40000 ALTER TABLE `usersandbookacts` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
