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

-- Listage de la structure de la table planner_room. boards
CREATE TABLE IF NOT EXISTS `boards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf16_bin NOT NULL,
  `description` text COLLATE utf16_bin,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tableapp_ibfk_1` (`user_id`) USING BTREE,
  CONSTRAINT `boards_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf16 COLLATE=utf16_bin;

-- Listage des données de la table planner_room.boards : ~3 rows (environ)
/*!40000 ALTER TABLE `boards` DISABLE KEYS */;
INSERT INTO `boards` (`id`, `title`, `description`, `user_id`) VALUES
	(1, 'Test', 'Voici un test', 2),
	(2, 'Projet CCI ', 'Backlog de Trello Like', 1),
	(6, 'test3', 'voici un test', 1);
/*!40000 ALTER TABLE `boards` ENABLE KEYS */;

-- Listage de la structure de la table planner_room. cards
CREATE TABLE IF NOT EXISTS `cards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `list_position` int(11) NOT NULL,
  `content` text COLLATE utf16_bin NOT NULL,
  `description` text COLLATE utf16_bin,
  `taskList_id` int(11) NOT NULL,
  `color_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `card_ibfk_2` (`color_id`),
  KEY `card_ibfk_1` (`taskList_id`) USING BTREE,
  CONSTRAINT `FK_cards_tasklists` FOREIGN KEY (`taskList_id`) REFERENCES `tasklists` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `cards_ibfk_2` FOREIGN KEY (`color_id`) REFERENCES `colors` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf16 COLLATE=utf16_bin;

-- Listage des données de la table planner_room.cards : ~4 rows (environ)
/*!40000 ALTER TABLE `cards` DISABLE KEYS */;
INSERT INTO `cards` (`id`, `list_position`, `content`, `description`, `taskList_id`, `color_id`) VALUES
	(1, 1000, 'test', NULL, 1, 1),
	(2, 2000, 'test2  test test', NULL, 1, 1),
	(3, 1000, 'test3', NULL, 2, 1),
	(4, 2000, 'test', NULL, 2, NULL);
/*!40000 ALTER TABLE `cards` ENABLE KEYS */;

-- Listage de la structure de la table planner_room. colors
CREATE TABLE IF NOT EXISTS `colors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `color_code` varchar(50) COLLATE utf16_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf16 COLLATE=utf16_bin;

-- Listage des données de la table planner_room.colors : ~0 rows (environ)
/*!40000 ALTER TABLE `colors` DISABLE KEYS */;
INSERT INTO `colors` (`id`, `color_code`) VALUES
	(1, '255,255,255');
/*!40000 ALTER TABLE `colors` ENABLE KEYS */;

-- Listage de la structure de la table planner_room. tasklists
CREATE TABLE IF NOT EXISTS `tasklists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text COLLATE utf16_bin NOT NULL,
  `board_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `list_ibfk_1` (`board_id`) USING BTREE,
  CONSTRAINT `tasklists_ibfk_1` FOREIGN KEY (`board_id`) REFERENCES `boards` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf16 COLLATE=utf16_bin;

-- Listage des données de la table planner_room.tasklists : ~3 rows (environ)
/*!40000 ALTER TABLE `tasklists` DISABLE KEYS */;
INSERT INTO `tasklists` (`id`, `title`, `board_id`) VALUES
	(1, 'A faire', 2),
	(2, 'En cours', 2),
	(3, 'Terminé', 2);
/*!40000 ALTER TABLE `tasklists` ENABLE KEYS */;

-- Listage de la structure de la table planner_room. users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nickname` varchar(128) COLLATE utf16_bin NOT NULL,
  `email` varchar(128) COLLATE utf16_bin NOT NULL,
  `password` varchar(128) COLLATE utf16_bin NOT NULL,
  `code_change` varchar(8) COLLATE utf16_bin DEFAULT NULL,
  `role` varchar(10) COLLATE utf16_bin NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf16 COLLATE=utf16_bin;

-- Listage des données de la table planner_room.users : ~5 rows (environ)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `nickname`, `email`, `password`, `code_change`, `role`) VALUES
	(1, ' Jérôme ', 'jerome.guyennet@orange.com', '$argon2i$v=19$m=65536,t=4,p=1$MkFuLmtSLlNDVVZiNjZQNA$84tlvor3fGaCO4weldQAgDLVmEC9CV/+7X7dneb0YCA', NULL, 'ROLE_USER'),
	(2, 'Maria Gordienko', 'mgordienkom@gmail.com', '$argon2i$v=19$m=65536,t=4,p=1$NHEwa1dCYkl3MHF4Rms1MQ$h0twzZi8CZbfgrW9RSP7z1dInpASR0Wm6W0EVqBNqjo', NULL, 'ROLE_USER'),
	(3, 'Hamme', 'hamme@gmail.com', '$argon2i$v=19$m=65536,t=4,p=1$TWFkeS5rWFd1WFM3UnFWSg$U7BYzqGnC5kzImAZWTldtAdkUakWt6KCTnYh2b4KwfE', NULL, 'ROLE_USER'),
	(5, 'admin', 'admin@gmail.com', '$argon2i$v=19$m=65536,t=4,p=1$ZGtQQTdLYm1kd21XZzMxZA$oZY3w5UiULtwT0w/Mj22F8ovsdcTISPyRKhNnvCYE+U', NULL, 'ROLE_ADMIN');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

-- Listage de la structure de la table planner_room. user_board_invitations
CREATE TABLE IF NOT EXISTS `user_board_invitations` (
  `board_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`board_id`,`user_id`) USING BTREE,
  KEY `invitation_ibfk_2` (`user_id`) USING BTREE,
  CONSTRAINT `user_board_invitations_ibfk_1` FOREIGN KEY (`board_id`) REFERENCES `boards` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user_board_invitations_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_bin;

-- Listage des données de la table planner_room.user_board_invitations : ~0 rows (environ)
/*!40000 ALTER TABLE `user_board_invitations` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_board_invitations` ENABLE KEYS */;

-- Listage de la structure de la table planner_room. user_board_participations
CREATE TABLE IF NOT EXISTS `user_board_participations` (
  `board_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`board_id`,`user_id`) USING BTREE,
  KEY `participation_ibfk_2` (`user_id`) USING BTREE,
  CONSTRAINT `user_board_participations_ibfk_1` FOREIGN KEY (`board_id`) REFERENCES `boards` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user_board_participations_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_bin;

-- Listage des données de la table planner_room.user_board_participations : ~7 rows (environ)
/*!40000 ALTER TABLE `user_board_participations` DISABLE KEYS */;
INSERT INTO `user_board_participations` (`board_id`, `user_id`) VALUES
	(2, 1),
	(6, 1),
	(1, 2),
	(2, 2),
	(6, 2),
	(1, 3),
	(2, 3);
/*!40000 ALTER TABLE `user_board_participations` ENABLE KEYS */;

-- Listage de la structure de la table planner_room. user_card_marks
CREATE TABLE IF NOT EXISTS `user_card_marks` (
  `card_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`card_id`,`user_id`) USING BTREE,
  KEY `mark_ibfk_2` (`user_id`) USING BTREE,
  CONSTRAINT `user_card_marks_ibfk_1` FOREIGN KEY (`card_id`) REFERENCES `cards` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user_card_marks_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_bin;

-- Listage des données de la table planner_room.user_card_marks : ~0 rows (environ)
/*!40000 ALTER TABLE `user_card_marks` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_card_marks` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
