# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 162.243.218.179 (MySQL 5.7.18-0ubuntu0.16.04.1)
# Database: thriatlon
# Generation Time: 2017-05-24 15:09:27 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table admins
# ------------------------------------------------------------

DROP TABLE IF EXISTS `admins`;

CREATE TABLE `admins` (
  `admin_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(60) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `reset_password_token` varchar(255) DEFAULT NULL,
  `reset_password_expires` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`admin_id`),
  UNIQUE KEY `admins_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;

INSERT INTO `admins` (`admin_id`, `name`, `email`, `password`, `is_active`, `created_at`, `updated_at`, `reset_password_token`, `reset_password_expires`)
VALUES
	(1,'Maciej Kołodziejczak','maciek.kolodziejczak@insanelab.com','$2a$08$ae0JLt/2wH5hs9QZNkTXR.BUdL6TSeDPrnCzAEArUt0d6f.AaXqr.',1,'2017-05-10 14:39:29','2017-05-10 14:39:29',NULL,NULL),
	(2,'Jakub Babrzymąka','kuba.babrzymaka@insanelab.com','$2a$08$J6tPIIlaQI1yrVtgDa4MG.hKTx0jW4RsVqJnQcgbuKmjNOjfzcTSm',1,'2017-05-10 14:39:29','2017-05-10 14:39:29',NULL,NULL),
	(3,'Piotr Skwarliński','piotr.skwarlinski@insanelab.com','$2a$08$tKmZ4Hq6KjCUcBXbrUs2yeMVWN1xbRyfPVZJlAtVjMeCC1kRXS63K',0,'2017-05-10 14:39:29','2017-05-10 14:39:29',NULL,NULL);

/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table games
# ------------------------------------------------------------

DROP TABLE IF EXISTS `games`;

CREATE TABLE `games` (
  `game_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `max_points` int(11) NOT NULL,
  PRIMARY KEY (`game_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `games` WRITE;
/*!40000 ALTER TABLE `games` DISABLE KEYS */;

INSERT INTO `games` (`game_id`, `name`, `description`, `max_points`)
VALUES
	(1,'Swimming','Freestyle Spell',30),
	(2,'Cycling','Grammar Path',20),
	(3,'Running','Typing Run',40);

/*!40000 ALTER TABLE `games` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table knex_migrations_prod
# ------------------------------------------------------------

DROP TABLE IF EXISTS `knex_migrations_prod`;

CREATE TABLE `knex_migrations_prod` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `batch` int(11) DEFAULT NULL,
  `migration_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `knex_migrations_prod` WRITE;
/*!40000 ALTER TABLE `knex_migrations_prod` DISABLE KEYS */;

INSERT INTO `knex_migrations_prod` (`id`, `name`, `batch`, `migration_time`)
VALUES
	(1,'20170217103032_DataStructure.js',1,'2017-05-10 14:39:28'),
	(2,'20170302193005_BadgesAndUserInfo.js',1,'2017-05-10 14:39:28'),
	(3,'20170310160849_ResetPassword.js',1,'2017-05-10 14:39:28'),
	(4,'20170321134546_UserSocialFlag.js',1,'2017-05-10 14:39:28'),
	(5,'20170419131301_ReturningUsers.js',1,'2017-05-10 14:39:28'),
	(6,'20170419133804_UserShares.js',1,'2017-05-10 14:39:28'),
	(7,'20170510111238_UserSocialId.js',1,'2017-05-10 14:39:28');

/*!40000 ALTER TABLE `knex_migrations_prod` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table knex_migrations_prod_lock
# ------------------------------------------------------------

DROP TABLE IF EXISTS `knex_migrations_prod_lock`;

CREATE TABLE `knex_migrations_prod_lock` (
  `is_locked` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `knex_migrations_prod_lock` WRITE;
/*!40000 ALTER TABLE `knex_migrations_prod_lock` DISABLE KEYS */;

INSERT INTO `knex_migrations_prod_lock` (`is_locked`)
VALUES
	(0);

/*!40000 ALTER TABLE `knex_migrations_prod_lock` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table scores
# ------------------------------------------------------------

DROP TABLE IF EXISTS `scores`;

CREATE TABLE `scores` (
  `score_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `game_id` int(10) unsigned NOT NULL,
  `session_id` int(10) unsigned NOT NULL,
  `value` int(11) NOT NULL,
  `badge` int(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`score_id`),
  KEY `scores_game_id_foreign` (`game_id`),
  KEY `scores_session_id_foreign` (`session_id`),
  CONSTRAINT `scores_game_id_foreign` FOREIGN KEY (`game_id`) REFERENCES `games` (`game_id`),
  CONSTRAINT `scores_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`session_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `scores` WRITE;
/*!40000 ALTER TABLE `scores` DISABLE KEYS */;

INSERT INTO `scores` (`score_id`, `game_id`, `session_id`, `value`, `badge`, `created_at`, `updated_at`)
VALUES
	(1,1,1,30,3,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(2,2,1,12,1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(3,3,1,23,1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(4,1,2,22,3,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(5,2,2,11,0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(6,3,2,20,2,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(7,1,3,24,2,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(8,2,3,30,3,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(9,3,3,30,3,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(10,1,4,12,0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(11,2,4,14,0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(12,3,4,15,1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(13,1,5,26,2,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(14,2,5,27,3,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(15,3,5,34,3,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(16,1,6,25,2,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(17,2,6,30,3,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(18,3,6,20,1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(19,1,7,23,2,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(20,2,7,13,0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(21,3,7,33,2,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(22,1,8,7,0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(23,2,8,10,0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(24,3,8,15,1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(25,1,9,37,3,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(26,2,9,22,2,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(27,3,9,23,1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(28,1,10,12,0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(29,2,10,21,1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(30,3,10,20,0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(31,1,11,24,2,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(32,2,11,20,2,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(33,3,11,15,0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(34,1,12,12,0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(35,2,12,24,2,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(36,3,12,25,2,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(37,1,13,33,3,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(38,2,13,17,0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(39,3,13,24,1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(40,1,14,15,0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(41,2,14,14,1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(42,3,14,10,1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(43,1,15,23,2,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(44,2,15,13,0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(45,3,15,14,0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(46,1,16,25,2,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(47,2,16,17,1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(48,3,16,15,1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(49,1,17,32,3,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(50,2,17,12,1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(51,3,17,23,1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(52,1,18,22,3,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(53,2,18,11,0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(54,3,18,20,2,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(55,1,19,24,2,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(56,2,19,10,0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(57,3,19,21,1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(58,1,20,16,1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(59,2,20,18,1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(60,3,20,29,3,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(61,1,21,16,1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(62,2,21,21,1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(63,3,21,24,2,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(64,1,22,25,2,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(65,2,22,13,1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(66,3,22,26,2,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(67,1,23,23,2,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(68,2,23,13,0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(69,3,23,13,2,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(70,1,24,7,0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(71,2,24,10,0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(72,3,24,19,0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(73,1,25,10,0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(74,2,25,15,1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(75,3,25,36,3,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(76,1,26,27,2,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(77,2,26,23,1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(78,3,26,19,1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(79,1,27,14,1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(80,2,27,19,1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(81,3,27,15,1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(82,1,28,9,0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(83,2,28,24,3,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(84,3,28,15,1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(85,1,29,27,2,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(86,2,29,23,2,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(87,3,29,19,1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(88,1,30,11,0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(89,2,30,14,0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(90,3,30,21,1,'2017-05-10 14:39:29','2017-05-10 14:39:29');

/*!40000 ALTER TABLE `scores` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table sessions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sessions`;

CREATE TABLE `sessions` (
  `session_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`session_id`),
  KEY `sessions_user_id_foreign` (`user_id`),
  CONSTRAINT `sessions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;

INSERT INTO `sessions` (`session_id`, `user_id`, `created_at`, `updated_at`)
VALUES
	(1,1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(2,2,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(3,3,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(4,4,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(5,1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(6,2,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(7,3,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(8,4,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(9,1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(10,2,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(11,3,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(12,4,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(13,1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(14,2,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(15,3,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(16,4,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(17,1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(18,2,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(19,3,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(20,4,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(21,1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(22,2,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(23,3,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(24,4,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(25,1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(26,2,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(27,3,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(28,4,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(29,3,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(30,4,'2017-05-10 14:39:29','2017-05-10 14:39:29');

/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table shares
# ------------------------------------------------------------

DROP TABLE IF EXISTS `shares`;

CREATE TABLE `shares` (
  `share_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(15) NOT NULL,
  `count` int(15) NOT NULL,
  PRIMARY KEY (`share_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `shares` WRITE;
/*!40000 ALTER TABLE `shares` DISABLE KEYS */;

INSERT INTO `shares` (`share_id`, `name`, `count`)
VALUES
	(1,'google',0),
	(2,'facebook',0),
	(3,'twitter',0),
	(4,'email',0);

/*!40000 ALTER TABLE `shares` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(60) DEFAULT NULL,
  `avatar_uri` varchar(255) DEFAULT NULL,
  `gender` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `reset_password_token` varchar(255) DEFAULT NULL,
  `reset_password_expires` varchar(255) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `client_id` varchar(255) DEFAULT NULL,
  `operator_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `avatar_uri`, `gender`, `is_active`, `created_at`, `updated_at`, `reset_password_token`, `reset_password_expires`, `last_login`, `client_id`, `operator_id`)
VALUES
	(1,'Wojciech Krawiec','wojciech.krawiec@insanelab.com','$2a$08$UacdukrzrK4QcgnXYggtlOa9gW81g9nBnwB8nPKIJSMRQ.vSB.XF2',NULL,'male',1,'2017-05-10 14:39:29','2017-05-10 14:39:29',NULL,NULL,NULL,NULL,NULL),
	(2,'Mateusz Cisowski','mateusz.cisowski@insanelab.com','$2a$08$yeyPfTEG7lWBh3vgNjiim.ciQaHi7XZLNyISkFNAUi3jxQ5VFxibC',NULL,'male',1,'2017-05-10 14:39:29','2017-05-10 14:39:29',NULL,NULL,NULL,NULL,NULL),
	(3,'Damian Markowski','damian.markowski@insanelab.com','$2a$08$M0db1bCJug8mkEPCCOs6y.duZuWUJ9ikJE0kMRI4WTxBmuViyL71O',NULL,'male',1,'2017-05-10 14:39:29','2017-05-10 14:39:29',NULL,NULL,NULL,NULL,NULL),
	(4,'Mateusz Pęczkowski','mateusz.peczkowski@insanelab.com','$2a$08$EN/0aj4BEs5dza3ld/XPVuhcVL5vzLaB6Bnb4XO53VrB6KV8pKKaS',NULL,'male',0,'2017-05-10 14:39:29','2017-05-10 14:39:29',NULL,NULL,NULL,NULL,NULL),
	(5,'Michael Kansky','mkansky@zazasoftware.com','$2a$08$anoOaVx91uCQtYd48/wUaOA9UspuzKmWO10IBNctQaMkdM.LSBY0q','/lhn/agent/OperatorPhotos/6065-A48DC73QR2.jpg','male',1,'2017-05-10 14:39:49','2017-05-10 14:39:49',NULL,NULL,NULL,'4714','6065');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table words
# ------------------------------------------------------------

DROP TABLE IF EXISTS `words`;

CREATE TABLE `words` (
  `word_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `game_id` int(10) unsigned NOT NULL,
  `content` varchar(255) NOT NULL,
  `is_correct` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`word_id`),
  KEY `words_game_id_foreign` (`game_id`),
  CONSTRAINT `words_game_id_foreign` FOREIGN KEY (`game_id`) REFERENCES `games` (`game_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `words` WRITE;
/*!40000 ALTER TABLE `words` DISABLE KEYS */;

INSERT INTO `words` (`word_id`, `game_id`, `content`, `is_correct`, `created_at`, `updated_at`)
VALUES
	(1,1,'embarrassment',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(2,1,'fluorescent',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(3,1,'accommodate',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(4,1,'psychiatrist',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(5,1,'occasionally',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(6,1,'necessary',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(7,1,'questionnaire',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(8,1,'mischievous',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(9,1,'rhythm',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(10,1,'minuscule',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(11,1,'conscience',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(12,1,' xylophone',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(13,1,' pronunciation',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(14,1,'graffiti',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(15,1,'millennium',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(16,1,'occurrence',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(17,1,'exhilarate',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(18,1,'restaurant',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(19,1,'accessory',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(20,1,'guarantee',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(21,1,'license',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(22,1,'separate',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(23,1,'believe',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(24,1,'colleague',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(25,1,'definite',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(26,1,'humorous',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(27,1,'weird',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(28,1,'symphony',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(29,1,'illicit',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(30,1,'species',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(31,1,'appearance',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(32,1,'possession',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(33,1,' vacuum',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(34,1,'changeable',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(35,1,'queue',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(36,1,'acquire',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(37,1,'receipt',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(38,1,'receive',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(39,1,'difficulty',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(40,1,'foreign',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(41,1,'discipline',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(42,1,'equipment',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(43,1,'business',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(44,1,'relevant',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(45,1,'beautiful',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(46,1,'technology',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(47,1,'neighbour',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(48,1,'friend',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(49,1,'religious',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(50,1,'government',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(51,1,'acquaintence',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(52,1,'adress',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(53,1,'agression',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(54,1,'becuase',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(55,1,'begining',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(56,1,'buisness',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(57,1,'calender',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(58,1,'comming',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(59,1,'conceed',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(60,1,'desparate',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(61,1,'disapoint',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(62,1,'ignorence',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(63,1,'independant',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(64,1,'nieghbor',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(65,1,'occured',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(66,1,'millenium',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(67,1,'potatos',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(68,1,'personel',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(69,1,'seperate',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(70,1,' rythm',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(71,1,'wierd',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(72,1,'writting',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(73,1,'suprise',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(74,1,'relevent',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(75,1,'orignal',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(76,1,'occassionally',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(77,1,'neccessary',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(78,1,'judgement',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(79,1,'imediately',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(80,1,'higeine',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(81,1,'drunkeness',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(82,1,'beleive',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(83,1,'athiest',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(84,1,'anually',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(85,1,'absense',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(86,1,'foriegn',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(87,1,'flourescent',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(88,1,'extreem',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(89,1,'existance',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(90,1,'carribean',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(91,1,'cemetary',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(92,1,'collegue',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(93,1,'enviroment',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(94,1,'farenheit',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(95,1,'familar',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(96,1,'glamourous',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(97,1,'happend',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(98,1,'politican',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(99,1,'portugese',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(100,1,'resistence',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(101,2,'One morning on waking I saw from my window the blue sky glowing in the sun above the neighbouring houses.',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(102,2,'Give a man a match, and he\'ll be warm for a minute, but set him on fire, and he\'ll be warm for the rest of his life.',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(103,2,'If pro is opposite of con, then what is the opposite of progress?',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(104,2,'A train station is where the train stops. A bus station is where the bus stops. On my desk, I have a work station…',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(105,2,'A single death is a tragedy; a million deaths is a statistic.',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(106,2,'Books have knowledge, knowledge is power, power corrupts, corruption is a crime, and crime doesn\'t pay..so if you keep reading, you\'ll go broke.',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(107,2,'Never interrupt your opponent while he\'s making a mistake.',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(108,2,'Love is like pi - natural, irrational, and very important.',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(109,2,'It only takes 20 years for a liberal to become a conservative without changing a single idea.',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(110,2,'A criminal is a person with predatory instincts who has not sufficient capital to form a corporation.',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(111,2,'Going to church doesn\'t make you a Christian any more than standing in a garage makes you a car.',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(112,2,'If the grass is greener on the other side, you can bet the water bill is higher.',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(113,2,'The old believe everything, the middle- aged suspect everything, the young know everything.',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(114,2,'Calling an engineer an applied scientist is like calling an artistic painter an applied pigment chemist.',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(115,2,'The avoidance of taxes is the only intellectual pursuit that carries any reward.',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(116,2,'People who think they know what they\'re doing are especially annoying to those of us who do.',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(117,2,'An expert is one who knows more and more about less and less until he knows absolutely everything about nothing.',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(118,2,'If you love something very much, give it away. If it comes back to you, it\'s yours forever. If it doesn\'t, it wasn\'t yours to begin with.',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(119,2,'If your actions inspire others to dream more, learn more, do more and become more, you are a leader.',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(120,2,'It is strange that only extraordinary men make the discoveries, which later appear so easy and simple.',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(121,2,'Progress is made by trial and failure; the failures are generally a hundred times more numerous than the successes ; yet they are usually left unchronicled.',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(122,2,'Although Nature needs thousands or millions of years to create a new species, man needs only a few dozen years to destroy one.',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(123,2,'If your experiment needs statistics, you ought to have done a better experiment.',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(124,2,'An experiment is a question which science poses to Nature, and a measurement is the recording of Nature’s answer.',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(125,2,'Outstanding examples of genius – a Mozart, a Shakespeare, or a Carl Friedrich Gauss – are markers on the path along which our species appears destined to tread.',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(126,2,'The black holes of nature are the most perfect macroscopic objects there are in the universe: the only elements in their construction are our concepts of space and time.',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(127,2,'There are only two ways to live your life. One is as though nothing is a miracle. The other is as though everything is a miracle.',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(128,2,'Two things are infinite: the universe and human stupidity; and I\'m not sure about the universe.',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(129,2,'If you can\'t explain it to a six year old, you don\'t understand it yourself.',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(130,2,'Anyone who has never made a mistake has never tried anything new.',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(131,2,'Life is like riding a bicycle. To keep your balance, you must keep moving.',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(132,2,'If I were not a physicist, I would probably be a musician. I often think in music. I live my daydreams in music. I see my life in terms of music.',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(133,2,'When you trip over love, it is easy to get up. But when you fall in love, it is impossible to stand again.',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(134,2,'All different forms of human expression, art, science, are going to become expanded, by expanding our intelligence.',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(135,2,'As long as men are free to ask what they must, free to say what they think, free to think what they will, freedom can never be lost and science can never regress.',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(136,2,'Push will get a person almost anywhere- except through a door marked “pull.”',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(137,2,'You’ll lose a lot of money, chasing women. But you’ll never lose women, chasing money.',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(138,2,'I haven’t failed at anything, I’ve just found all the wrong ways of doing it.',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(139,2,'Never be afraid to try something new… An amateur built the ark that lasted forty days and forty nights; professionals built the titanic that sank.',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(140,2,'The woman had brought two daughters into the house with her, who were beautiful and fair of face, but vile and black of heart.',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(141,2,'She danced till it was evening, and then she wanted to go home.',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(142,2,'Of crustaceans, land-crabs are remarkable for size and number.',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(143,2,'At present cranberries are the only product of importance.',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(144,2,'She was in her mid-twenties, with crystal clear blue eyes and porcelain skin.',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(145,2,'Carry this cat away to prison, and keep her in safe confinement until she is tried by law for the crime of murder.',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(146,2,'The names \"alligator\" and \"crocodile\" are often confounded in popular speech; and the structure and habits of the two animals are so similar that both are most conveniently considered under the heading Crocodile.',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(147,2,'The metal panels on top of the generator opened like a flower, automatically adjusting themselves to catch the most sun.',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(148,2,'He insisted I tell him where I was setting my units so he always knew approximately where he was going.',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(149,2,'Different kinds of ants vary greatly in the substances which they use for food.',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(150,2,'Suddenly all those annoying rules of conduct began to make sense.',1,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(151,2,'I have visited Niagara Falls last weekend.',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(152,2,'The woman which works here is from Japan.',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(153,2,'She was boring in the class.',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(154,2,'She’s married with a dentist.',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(155,2,'I must to call him immediately.',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(156,2,'Every students like the teacher.',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(157,2,'Although it was raining, but we had the picnic.',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(158,2,'I enjoyed from the movie.',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(159,2,'I look forward to meet you.',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(160,2,'I like very much ice cream.',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(161,2,'She can to drive.',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(162,2,'Where I can find a bank?',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(163,2,'I live in United States',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(164,2,'When I will arrive, I will call you.',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(165,2,'I’ve been here since three months.',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(166,2,'My boyfriend has got a new work.',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(167,2,'She doesn’t listen me.',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(168,2,'You speak English good.',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(169,2,'The police is coming.',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(170,2,'The house isn’t enough big.',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(171,2,'You should not to smoke.',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(172,2,'Do you like a glass of wine?',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(173,2,'There is seven girls in the class.',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(174,2,'I didn’t meet nobody.',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(175,2,'My flight departs in 5:00 am.',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(176,2,'I promise I call you next week.',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(177,2,'Where is post office?',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(178,2,'Pleaseexplain me how improve my English.',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(179,2,'We studied during four hours.',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(180,2,'Is ready my passport?',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(181,2,'You cannot buy all what you like',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(182,2,'',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(183,2,'She is success.',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(184,2,'My mother wanted that I be doctor.',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(185,2,'The life is hard.',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(186,2,'How many childrens you have?',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(187,2,'My brother has 10 years.',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(188,2,'I want eat now.',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(189,2,'You are very nice, as your mother.',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(190,2,'She said me that she liked you.',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(191,2,'My husband engineer.',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(192,2,'I came Australia to study English.',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(193,2,'It is more hot now.',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(194,2,'You can give me an information?',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(195,2,'They cooked the dinner themself.',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(196,2,'Me and Johnny live here.',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(197,2,'I closed very quietly the door.',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(198,2,'You like dance with me?',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(199,2,'I go always to school by subway.',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(200,2,'If I will be in London, I will contact to you.',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(201,2,'We drive usually to home.',0,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(202,3,'adult',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(203,3,'aeroplane',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(204,3,'air',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(205,3,'aircraft',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(206,3,'carrier',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(207,3,'airforce',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(208,3,'airport',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(209,3,'album',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(210,3,'alphabet',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(211,3,'apple',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(212,3,'arm',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(213,3,'army',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(214,3,'baby',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(215,3,'baby',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(216,3,'backpack',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(217,3,'balloon',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(218,3,'banana',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(219,3,'bank',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(220,3,'barbecue',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(221,3,'bathroom',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(222,3,'bathtub',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(223,3,'bed',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(224,3,'bed',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(225,3,'bee',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(226,3,'bible',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(227,3,'bible',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(228,3,'bird',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(229,3,'bomb',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(230,3,'book',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(231,3,'boss',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(232,3,'bottle',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(233,3,'bowl',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(234,3,'box',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(235,3,'boy',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(236,3,'brain',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(237,3,'bridge',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(238,3,'butterfly',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(239,3,'button',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(240,3,'cappuccino',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(241,3,'car',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(242,3,'carpet',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(243,3,'carrot',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(244,3,'cave',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(245,3,'chair',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(246,3,'chess',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(247,3,'board',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(248,3,'chief',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(249,3,'child',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(250,3,'chisel',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(251,3,'chocolates',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(252,3,'church',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(253,3,'church',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(254,3,'circle',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(255,3,'circus',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(256,3,'circus',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(257,3,'clock',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(258,3,'clown',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(259,3,'coffee',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(260,3,'coffeeshop',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(261,3,'comet',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(262,3,'compass',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(263,3,'computer',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(264,3,'crystal',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(265,3,'cup',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(266,3,'cycle',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(267,3,'desk',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(268,3,'diamond',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(269,3,'dress',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(270,3,'drill',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(271,3,'drink',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(272,3,'drum',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(273,3,'dung',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(274,3,'ears',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(275,3,'earth',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(276,3,'egg',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(277,3,'electricity',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(278,3,'elephant',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(279,3,'eraser',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(280,3,'explosive',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(281,3,'eyes',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(282,3,'family',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(283,3,'fan',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(284,3,'feather',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(285,3,'festival',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(286,3,'film',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(287,3,'finger',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(288,3,'fire',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(289,3,'floodlight',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(290,3,'flower',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(291,3,'foot',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(292,3,'fork',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(293,3,'freeway',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(294,3,'fruit',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(295,3,'fungus',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(296,3,'game',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(297,3,'garden',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(298,3,'gas',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(299,3,'gate',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(300,3,'gemstone',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(301,3,'girl',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(302,3,'gloves',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(303,3,'god',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(304,3,'grapes',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(305,3,'guitar',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(306,3,'hammer',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(307,3,'hat',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(308,3,'hieroglyph',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(309,3,'highway',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(310,3,'horoscope',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(311,3,'horse',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(312,3,'hose',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(313,3,'ice',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(314,3,'insect',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(315,3,'jet',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(316,3,'junk',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(317,3,'kaleidoscope',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(318,3,'kitchen',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(319,3,'knife',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(320,3,'leather',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(321,3,'leg',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(322,3,'library',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(323,3,'liquid',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(324,3,'magnet',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(325,3,'man',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(326,3,'map',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(327,3,'maze',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(328,3,'meat',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(329,3,'meteor',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(330,3,'microscope',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(331,3,'milk',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(332,3,'milkshake',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(333,3,'mist',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(334,3,'money',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(335,3,'monster',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(336,3,'mosquito',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(337,3,'mouth',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(338,3,'nail',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(339,3,'navy',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(340,3,'necklace',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(341,3,'needle',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(342,3,'onion',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(343,3,'paintbrush',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(344,3,'pants',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(345,3,'parachute',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(346,3,'passport',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(347,3,'pebble',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(348,3,'pendulum',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(349,3,'pepper',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(350,3,'perfume',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(351,3,'pillow',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(352,3,'plane',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(353,3,'planet',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(354,3,'pocket',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(355,3,'potato',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(356,3,'printer',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(357,3,'prison',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(358,3,'pyramid',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(359,3,'radar',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(360,3,'rainbow',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(361,3,'record',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(362,3,'restaurant',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(363,3,'rifle',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(364,3,'ring',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(365,3,'robot',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(366,3,'rock',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(367,3,'rocket',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(368,3,'roof',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(369,3,'room',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(370,3,'rope',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(371,3,'saddle',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(372,3,'salt',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(373,3,'sandpaper',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(374,3,'sandwich',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(375,3,'satellite',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(376,3,'school',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(377,3,'sex',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(378,3,'ship',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(379,3,'shoes',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(380,3,'shop',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(381,3,'shower',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(382,3,'signature',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(383,3,'skeleton',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(384,3,'slave',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(385,3,'snail',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(386,3,'software',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(387,3,'solid',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(388,3,'space',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(389,3,'shuttle',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(390,3,'spectrum',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(391,3,'sphere',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(392,3,'spice',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(393,3,'spiral',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(394,3,'spoon',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(395,3,'spotlight',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(396,3,'square',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(397,3,'staircase',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(398,3,'star',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(399,3,'stomach',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(400,3,'sun',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(401,3,'sunglasses',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(402,3,'surveyor',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(403,3,'swimming',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(404,3,'sword',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(405,3,'table',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(406,3,'tapestry',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(407,3,'teeth',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(408,3,'telescope',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(409,3,'television',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(410,3,'tennis',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(411,3,'thermometer',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(412,3,'tiger',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(413,3,'toilet',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(414,3,'tongue',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(415,3,'torch',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(416,3,'torpedo',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(417,3,'train',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(418,3,'treadmill',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(419,3,'triangle',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(420,3,'tunnel',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(421,3,'typewriter',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(422,3,'umbrella',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(423,3,'vacuum',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(424,3,'vampire',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(425,3,'videotape',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(426,3,'vulture',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(427,3,'water',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(428,3,'weapon',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(429,3,'web',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(430,3,'wheelchair',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(431,3,'window',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(432,3,'woman',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(433,3,'worm',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29'),
	(434,3,'xray',NULL,'2017-05-10 14:39:29','2017-05-10 14:39:29');

/*!40000 ALTER TABLE `words` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
