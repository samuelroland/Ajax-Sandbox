-- --------------------------------------------------------
-- Hôte :                        127.0.0.1
-- Version du serveur:           8.0.20 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             11.0.0.5978
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Listage de la structure de la base pour rtchat
CREATE DATABASE IF NOT EXISTS `rtchat` /*!40100 DEFAULT CHARACTER SET utf8 */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `rtchat`;

-- Listage de la structure de la table rtchat. messages
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `text` varchar(2000) NOT NULL,
  `date` datetime NOT NULL,
  `sender_id` int NOT NULL,
  `receiver_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_messages_users_idx` (`sender_id`),
  KEY `fk_messages_users1_idx` (`receiver_id`),
  CONSTRAINT `fk_messages_users` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`),
  CONSTRAINT `fk_messages_users1` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- Listage des données de la table rtchat.messages : ~6 rows (environ)
DELETE FROM `messages`;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` (`id`, `text`, `date`, `sender_id`, `receiver_id`) VALUES
	(1, 'salut bob comment ca va ?', '2020-07-12 22:22:04', 1, 2),
	(2, 'ouais à fond ca va tip top! je m\'éclate trop durant ces vacances... et toi ?', '2020-07-12 22:24:48', 2, 1),
	(3, 'Hello bob, tu peux me prêter tes baskets stp ? j\'en ai besoin pour le concert de demain...', '2020-07-12 23:00:23', 3, 2),
	(4, 'Bah moi je fais un super projet qui consiste à dormir toute la journée... LOL. non plus sérieusement je bosse beaucoup le violon pour mes exams...', '2020-07-12 22:32:23', 1, 2),
	(5, 'ah tu joues du violon ? COOL !', '2020-07-12 22:33:52', 2, 1),
	(6, 'non désolé j\'en ai besoin demain... demandes au voisin !', '2020-07-12 23:28:36', 2, 3);
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;

-- Listage de la structure de la table rtchat. users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `firstname` varchar(45) NOT NULL,
  `lastname` varchar(45) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `firstname_UNIQUE` (`firstname`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Listage des données de la table rtchat.users : ~3 rows (environ)
DELETE FROM `users`;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `firstname`, `lastname`, `password`) VALUES
	(1, 'Alice', 'Carry', '$2y$10$Vyr9CVzWUVXHLj7WfKlMW.BDye2id1Rxz.sFu/4leNbDwqu/AK5WG'),
	(2, 'Bob', 'Dos', '$2y$10$wyOYOGqtT5ZmReBWpNtL1eBjSpyxzdfCTI/lq41uGTp76cFvcGnFG'),
	(3, 'Jen', 'Space', '$2y$10$hBvT5dxJXxP6ks1ZRuwYXOzBRhuNsXONmVDaslLIGW029smtVyt6y');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
