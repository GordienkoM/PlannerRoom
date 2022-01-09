-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           5.7.33 - MySQL Community Server (GPL)
-- SE du serveur:                Win64
-- HeidiSQL Version:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour planner_room
CREATE DATABASE IF NOT EXISTS `planner_room` /*!40100 DEFAULT CHARACTER SET utf16 COLLATE utf16_bin */;
USE `planner_room`;

-- Listage de la structure de la table planner_room. card
CREATE TABLE IF NOT EXISTS `card` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `list_position` int(11) NOT NULL,
  `content` text COLLATE utf16_bin NOT NULL,
  `label` varchar(255) COLLATE utf16_bin DEFAULT NULL,
  `listApp_id` int(11) NOT NULL,
  `color_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `card_ibfk_2` (`color_id`),
  KEY `card_ibfk_1` (`listApp_id`) USING BTREE,
  CONSTRAINT `card_ibfk_1` FOREIGN KEY (`listApp_id`) REFERENCES `listapp` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `card_ibfk_2` FOREIGN KEY (`color_id`) REFERENCES `color` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_bin;

-- Listage des données de la table planner_room.card : ~0 rows (environ)
/*!40000 ALTER TABLE `card` DISABLE KEYS */;
/*!40000 ALTER TABLE `card` ENABLE KEYS */;

-- Listage de la structure de la table planner_room. color
CREATE TABLE IF NOT EXISTS `color` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `color_code` varchar(50) COLLATE utf16_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_bin;

-- Listage des données de la table planner_room.color : ~0 rows (environ)
/*!40000 ALTER TABLE `color` DISABLE KEYS */;
/*!40000 ALTER TABLE `color` ENABLE KEYS */;

-- Listage de la structure de la table planner_room. invitation
CREATE TABLE IF NOT EXISTS `invitation` (
  `tableApp_id` int(11) NOT NULL,
  `userApp_id` int(11) NOT NULL,
  PRIMARY KEY (`tableApp_id`,`userApp_id`),
  KEY `invitation_ibfk_2` (`userApp_id`),
  CONSTRAINT `invitation_ibfk_1` FOREIGN KEY (`tableApp_id`) REFERENCES `tableapp` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `invitation_ibfk_2` FOREIGN KEY (`userApp_id`) REFERENCES `userapp` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_bin;

-- Listage des données de la table planner_room.invitation : ~1 rows (environ)
/*!40000 ALTER TABLE `invitation` DISABLE KEYS */;
INSERT INTO `invitation` (`tableApp_id`, `userApp_id`) VALUES
	(6, 3);
/*!40000 ALTER TABLE `invitation` ENABLE KEYS */;

-- Listage de la structure de la table planner_room. listapp
CREATE TABLE IF NOT EXISTS `listapp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text COLLATE utf16_bin NOT NULL,
  `tableApp_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `list_ibfk_1` (`tableApp_id`),
  CONSTRAINT `listapp_ibfk_1` FOREIGN KEY (`tableApp_id`) REFERENCES `tableapp` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf16 COLLATE=utf16_bin;

-- Listage des données de la table planner_room.listapp : ~3 rows (environ)
/*!40000 ALTER TABLE `listapp` DISABLE KEYS */;
INSERT INTO `listapp` (`id`, `title`, `tableApp_id`) VALUES
	(1, 'A faire', 2),
	(2, 'En cours', 2),
	(3, 'Terminé', 2);
/*!40000 ALTER TABLE `listapp` ENABLE KEYS */;

-- Listage de la structure de la table planner_room. mark
CREATE TABLE IF NOT EXISTS `mark` (
  `card_id` int(11) NOT NULL,
  `userApp_id` int(11) NOT NULL,
  PRIMARY KEY (`card_id`,`userApp_id`),
  KEY `mark_ibfk_2` (`userApp_id`),
  CONSTRAINT `mark_ibfk_1` FOREIGN KEY (`card_id`) REFERENCES `card` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `mark_ibfk_2` FOREIGN KEY (`userApp_id`) REFERENCES `userapp` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_bin;

-- Listage des données de la table planner_room.mark : ~0 rows (environ)
/*!40000 ALTER TABLE `mark` DISABLE KEYS */;
/*!40000 ALTER TABLE `mark` ENABLE KEYS */;

-- Listage de la structure de la table planner_room. participation
CREATE TABLE IF NOT EXISTS `participation` (
  `tableApp_id` int(11) NOT NULL,
  `userApp_id` int(11) NOT NULL,
  PRIMARY KEY (`tableApp_id`,`userApp_id`),
  KEY `participation_ibfk_2` (`userApp_id`),
  CONSTRAINT `participation_ibfk_1` FOREIGN KEY (`tableApp_id`) REFERENCES `tableapp` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `participation_ibfk_2` FOREIGN KEY (`userApp_id`) REFERENCES `userapp` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_bin;

-- Listage des données de la table planner_room.participation : ~8 rows (environ)
/*!40000 ALTER TABLE `participation` DISABLE KEYS */;
INSERT INTO `participation` (`tableApp_id`, `userApp_id`) VALUES
	(1, 1),
	(2, 1),
	(6, 1),
	(1, 2),
	(2, 2),
	(6, 2),
	(1, 3),
	(2, 3);
/*!40000 ALTER TABLE `participation` ENABLE KEYS */;

-- Listage de la structure de la table planner_room. tableapp
CREATE TABLE IF NOT EXISTS `tableapp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf16_bin NOT NULL,
  `description` text COLLATE utf16_bin,
  `userApp_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tableapp_ibfk_1` (`userApp_id`),
  CONSTRAINT `tableapp_ibfk_1` FOREIGN KEY (`userApp_id`) REFERENCES `userapp` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf16 COLLATE=utf16_bin;

-- Listage des données de la table planner_room.tableapp : ~3 rows (environ)
/*!40000 ALTER TABLE `tableapp` DISABLE KEYS */;
INSERT INTO `tableapp` (`id`, `title`, `description`, `userApp_id`) VALUES
	(1, 'Test', 'Voici un test', 2),
	(2, 'Projet CCI ', 'Backlog de Trello Like', 1),
	(6, 'test3', 'voici un test', 1);
/*!40000 ALTER TABLE `tableapp` ENABLE KEYS */;

-- Listage de la structure de la table planner_room. userapp
CREATE TABLE IF NOT EXISTS `userapp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nickname` varchar(128) COLLATE utf16_bin NOT NULL,
  `email` varchar(128) COLLATE utf16_bin NOT NULL,
  `password` varchar(128) COLLATE utf16_bin NOT NULL,
  `code_change` varchar(8) COLLATE utf16_bin DEFAULT NULL,
  `role` varchar(10) COLLATE utf16_bin NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf16 COLLATE=utf16_bin;

-- Listage des données de la table planner_room.userapp : ~4 rows (environ)
/*!40000 ALTER TABLE `userapp` DISABLE KEYS */;
INSERT INTO `userapp` (`id`, `nickname`, `email`, `password`, `code_change`, `role`) VALUES
	(1, 'Jérôme', 'jerome.guyennet@orange.com', '$argon2i$v=19$m=65536,t=4,p=1$MkFuLmtSLlNDVVZiNjZQNA$84tlvor3fGaCO4weldQAgDLVmEC9CV/+7X7dneb0YCA', NULL, 'ROLE_USER'),
	(2, 'Maria Gordienko', 'mgordienkom@gmail.com', '$argon2i$v=19$m=65536,t=4,p=1$NHEwa1dCYkl3MHF4Rms1MQ$h0twzZi8CZbfgrW9RSP7z1dInpASR0Wm6W0EVqBNqjo', NULL, 'ROLE_USER'),
	(3, 'Hamme', 'hamme@gmail.com', '$argon2i$v=19$m=65536,t=4,p=1$TWFkeS5rWFd1WFM3UnFWSg$U7BYzqGnC5kzImAZWTldtAdkUakWt6KCTnYh2b4KwfE', NULL, 'ROLE_USER'),
	(5, 'admin', 'admin@gmail.com', '$argon2i$v=19$m=65536,t=4,p=1$ZGtQQTdLYm1kd21XZzMxZA$oZY3w5UiULtwT0w/Mj22F8ovsdcTISPyRKhNnvCYE+U', NULL, 'ROLE_ADMIN');
/*!40000 ALTER TABLE `userapp` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
