-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for framework
DROP DATABASE IF EXISTS `framework`;
CREATE DATABASE IF NOT EXISTS `framework` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `framework`;

-- Dumping structure for table framework.crypto
DROP TABLE IF EXISTS `crypto`;
CREATE TABLE IF NOT EXISTS `crypto` (
  `md5` varchar(32) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `base64` text COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table framework.crypto: ~13 rows (approximately)
INSERT INTO `crypto` (`md5`, `base64`) VALUES
	('345c260f1a9aa3a215260493f1f7077e', 'Z0g3Q3lUWTdHZnB2Tm85czAvWEpMZz09OjoEf0cz/ZKzFv1MHMEb2rEg'),
	('4d90cfcd90050a187f752bad9f0d1912', 'TkFIWjZNUVpqVGpjR1ZSdVRaaiswUT09OjrURIvuW73P+yo29Rdl9e0i'),
	('47b4177106b14aec878689a2a9dc0eb9', 'ZG5KK0dMMGpXWHVYVTZvRUZIbWxFZz09OjrCXz4vQ0X82Oa98/MoNKqW'),
	('62933109eb6bc25d4feabd3859d346dd', 'RU5ML2V6Nm1LSlAwNW4zcEYvRk5GUT09OjpIYQgSOAj97k+Oa+aqQmuf'),
	('e53890e70ef8c2245a656e2717636fc0', 'TVh0MTBpZ3FleEdkOWIveWhqZVZYUT09OjqJb23C+drLMT4sa3hN0D90'),
	('6caa62692432208a240e22a8be6d8509', 'QlpoQVk4TFU3VU14TTg0ZU12V1B5bTg2WDQydzVOd1lKYXg4UStDdEM2WT06OoMwSasJ/P3wjoiVk50joec='),
	('63c85f911d7c4af3ce2ba56cba2d10bf', 'eFJaUjZSTnVqMXBlTFRrU1RRK1MwRTdTTWUyY2M3QmJNdkVhQWdmQm9nRT06Ors5DATVkUOUWKgfoz179HE='),
	('e094c2baeb004d9a3c3309e9bb43e989', 'QThMTDBVT2NldStqVTg3MUdnNDB6M0ViTW9VcmJ5U2swWEhoWEJvZys1cnl3c1hkNXVpSkZzMEdVM3ZtajJBMlpHMXZlRE9GYjdHRXYvRHNac1pOWWc9PTo6n8zH1bsPHWNFPC3GDpz0lg=='),
	('f333771b9f41109a6180e636746e58ad', 'NlNlajJTV1kwNEpXUDZmbFc4Um00V3FwWlFkcXJOWnEwNXBaV1BXSHFXeVd1NUtBMTJoY2phTS9XK1MxZTJNRFoxWmxrbnN1aHEwdzlDMk5vdHRIbGc9PTo6DAPOforPxOY6ZXBoU4YQkQ=='),
	('535ade1e281f4f3d88c5ba2c004f2504', 'c2RNT2xNdnlLMWVaVjZuTlFkbG1JR3NQTkpKRzBWa0dCSkkxbzlhd0IyNHhudTZ3K3dpNGJXWUhlL1MrQ2JibDA1cUlCNHkxSW53OCtvckZlcE1GUlE9PTo6AZ5laU5H7IOzWQCgt0OBHQ=='),
	('faefe1d5e7bc9447f030595068290fc2', 'anZha2xiZG1YNVJDRy9lUEMrTHhJWUhTWnE1YXlkUXI3SDJCRDhNREFrSEdCT3pwVWFDYWtJSUdJaTVyMEtLcmRubEFOYm5jSG1kNjlZQjBYVjBqUEE9PTo6X7nSeVtXbEwQM6PVh4nl5A=='),
	('239682679f16432c10e8cc8742a0155e', 'N3JKc2dxbDk5dXp4MFB0aTA5aEk1SzNHWU5IYkR1RzhmMlZ0QWxMMlVkbz06OrxhN6d2Xbn+n2HxgDmLFt8='),
	('b01524af3a7b99c70bfc55f418d51f84', 'cWVSRURwSk1OejFvTGE3Q0RLZzZTUT09OjrFmODkng6L3Zi26SufUhHN');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
