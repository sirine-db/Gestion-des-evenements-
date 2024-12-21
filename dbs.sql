-- MySQL dump 10.13  Distrib 8.0.34, for Win64 (x86_64)
--
-- Host: localhost    Database: dz_events
-- ------------------------------------------------------
-- Server version	8.0.35

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `event_participation`
--

DROP TABLE IF EXISTS `event_participation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `event_participation` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `event_id` int NOT NULL,
  `motivation` text,
  `attentes` text,
  `statut` enum('etudiant','professionnelle','retraité','autre') NOT NULL,
  `rajout` text,
  `participation_status` enum('en_cours','accepte','rejected') NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `event_id` (`event_id`),
  CONSTRAINT `event_participation_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `event_participation_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event_participation`
--

LOCK TABLES `event_participation` WRITE;
/*!40000 ALTER TABLE `event_participation` DISABLE KEYS */;
INSERT INTO `event_participation` VALUES (3,16,7,'x','xcz','professionnelle','x','en_cours','2024-12-15 04:22:55'),(4,10,12,'x','x','professionnelle','x','en_cours','2024-12-16 04:11:09'),(7,19,6,'sss','xs','professionnelle','s','en_cours','2024-12-17 23:22:22'),(8,19,7,'z','z','etudiant','x','en_cours','2024-12-18 01:30:49'),(13,17,7,'salam','wanna join','professionnelle','x','en_cours','2024-12-18 17:21:09'),(14,17,12,'i wanna join please','haha','professionnelle','jaj','en_cours','2024-12-21 19:15:43');
/*!40000 ALTER TABLE `event_participation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event_requests`
--

DROP TABLE IF EXISTS `event_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `event_requests` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `nombre_participant` int NOT NULL,
  `lieu` varchar(100) NOT NULL,
  `date_event` date NOT NULL,
  `duree` time NOT NULL,
  `organizer_id` int NOT NULL,
  `status` enum('pending','accepted','rejected') DEFAULT 'pending',
  `description` text,
  `photo_path` varchar(500) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `categorie` enum('Musique','Atelier','Séminaire','professionnels','culturels','sociaux','sportifs','éducatifs','caritatifs','religieux','loisirs','technologiques','virtuels') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `organizer_id` (`organizer_id`),
  CONSTRAINT `event_requests_ibfk_1` FOREIGN KEY (`organizer_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event_requests`
--

LOCK TABLES `event_requests` WRITE;
/*!40000 ALTER TABLE `event_requests` DISABLE KEYS */;
INSERT INTO `event_requests` VALUES (18,'ren',3,'Setif','2030-12-12','08:20:00',19,'pending','hwcd','path/pic.jpg','2024-12-17 23:29:41','religieux'),(19,'xx ',123,'Constantine','2004-12-12','12:12:00',19,'pending','sdac','rg.png','2024-12-18 01:36:19','Séminaire');
/*!40000 ALTER TABLE `event_requests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `events` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `nombre_participant` int NOT NULL,
  `lieu` varchar(100) NOT NULL,
  `date_event` date NOT NULL,
  `duree` time NOT NULL,
  `organizer_id` int NOT NULL,
  `users_list` text,
  `photo_path` varchar(255) DEFAULT NULL,
  `status` enum('pending','accepted','rejected') DEFAULT 'accepted',
  `description` text,
  `categorie` enum('Musique','Atelier','Séminaire','professionnels','culturels','sociaux','sportifs','éducatifs','caritatifs','religieux','loisirs','technologiques','virtuels') DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `organizer_id` (`organizer_id`),
  CONSTRAINT `events_ibfk_1` FOREIGN KEY (`organizer_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `events`
--

LOCK TABLES `events` WRITE;
/*!40000 ALTER TABLE `events` DISABLE KEYS */;
INSERT INTO `events` VALUES (5,'Science Symposium',100,'Djijel','2024-09-12','14:00:00',6,'null','path/to/photo5.jpg','accepted','An educational symposium on scientific advancements.','éducatifs'),(6,'Photography Workshop',20,'Setif','2024-10-05','16:00:00',7,'null','path/to/photo6.jpg','accepted','A hands-on workshop to improve photography skills.','Atelier'),(7,'Cinema GOLDEN AGE',75,'Alger','2024-09-12','14:00:00',5,'null','https://i.pinimg.com/736x/4c/ce/d7/4cced7768127231bdc5c34479c5c835b.jpg','accepted','Don\'t miss your chance!','loisirs'),(10,'Green Hat CTF',200,'Alger','2024-12-22','12:00:00',4,'null','path/to/photo4.jpg','accepted','Cybersecurity competition for ethical hackers.','technologiques'),(11,'AGC',150,'Constantine','2024-12-28','09:00:00',5,NULL,'path/to/photo5.jpg','accepted','Annual Game Championship',NULL),(12,'MicroCode',50,'Alger','2024-09-12','14:00:00',6,NULL,'path/to/photo.jpg','accepted','NAH ID WIN',NULL),(17,'HACKATHON',123,'Constantine','2004-12-12','12:12:00',17,NULL,'DV.JPG','accepted','BEST EVENT EVER',NULL);
/*!40000 ALTER TABLE `events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sender_id` int NOT NULL,
  `subject` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `sent_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `status` enum('unread','read','archived') DEFAULT 'unread',
  `sender_name` varchar(20) NOT NULL,
  `adresse_mail` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sender_id` (`sender_id`),
  CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` VALUES (1,3,'Problème avec l\'événement','Bonjour Admin, j\'ai rencontré un problème avec l\'événement prévu pour demain. Pouvez-vous m\'aider ?','2024-12-12 10:00:00','archived','',''),(2,4,'Demande de clarification','Bonjour, pourriez-vous clarifier les règles de participation à l\'événement ? Merci.','2024-12-12 10:30:00','read','',''),(3,5,'Suggestions pour un événement','Je voudrais suggérer un événement pour la promotion de la culture algérienne. J\'espère que vous le prendrez en considération.','2024-12-12 11:00:00','read','',''),(4,6,'Problème d\'accès à la plateforme','Bonjour, je ne peux pas accéder à la plateforme d\'inscription aux événements. Pouvez-vous m\'aider à résoudre ce problème ?','2024-12-12 11:30:00','archived','',''),(5,7,'Demande de participation','Je suis intéressé à participer à un événement que vous organisez, comment puis-je m\'inscrire ?','2024-12-12 12:00:00','read','',''),(6,8,'Événement annulé','Je viens d\'apprendre que l\'événement auquel je m\'étais inscrit est annulé. Est-ce correct ?','2024-12-12 12:30:00','read','',''),(7,9,'Notification de mise à jour','Bonjour, je viens de recevoir une mise à jour concernant un événement. Merci pour l\'information.','2024-12-12 13:00:00','read','',''),(8,1,'Event Confirmation','Your event request for \"Micro Code\" has been confirmed. Check the details on the dashboard.','2024-12-13 21:02:55','unread','',''),(9,2,'Event Cancellation','Unfortunately, your event \"Def Fest\" has been cancelled due to unforeseen circumstances.','2024-12-13 21:02:55','unread','',''),(10,3,'Event Reminder','The \"Ice Break\" event is happening tomorrow. Please don?t forget to attend.','2024-12-13 21:02:55','unread','',''),(11,4,'Event Update','The event \"GREEN HAT CTF\" has been updated with new participant details.','2024-12-13 21:02:55','archived','',''),(12,5,'Event Approval','Your request for \"AGC\" has been approved. We look forward to your participation!','2024-12-13 21:02:55','unread','',''),(13,6,'Important Notice','There will be a maintenance window on the website tomorrow at 2 PM. Please plan accordingly.','2024-12-13 21:02:55','unread','',''),(14,7,'Upcoming Events','Check out the new events added this week: Micro Code, Def Fest, and Ice Break.','2024-12-13 21:02:55','unread','',''),(15,8,'New Feature','We have introduced a new feature that allows users to submit event proposals directly through the platform.','2024-12-13 21:02:55','unread','',''),(17,19,'z','x','2024-12-18 06:55:27','unread','meee','erensirine@gmail.com'),(18,19,'z','x','2024-12-18 06:56:07','unread','meee','sirinedob@gmail.com'),(19,17,'salam ','test','2024-12-18 07:28:12','unread','sabr sara','SABR@gmail.com'),(20,17,'TEST BRK','HELLO','2024-12-21 20:16:40','unread','sabr sara','SABR@gmail.com');
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications` (
  `id` int NOT NULL AUTO_INCREMENT,
  `message` varchar(255) NOT NULL,
  `date_sent` datetime DEFAULT CURRENT_TIMESTAMP,
  `status` enum('unread','read') DEFAULT 'unread',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `preference_user`
--

DROP TABLE IF EXISTS `preference_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `preference_user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `categorie` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `preference_user_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `preference_user`
--

LOCK TABLES `preference_user` WRITE;
/*!40000 ALTER TABLE `preference_user` DISABLE KEYS */;
INSERT INTO `preference_user` VALUES (1,16,'sociaux'),(2,16,'loisirs'),(3,16,'virtuels'),(4,17,'sportifs'),(5,17,'religieux'),(6,17,'Atelier'),(7,NULL,'caritatifs'),(8,NULL,'Musique'),(9,NULL,'Séminaire'),(10,19,'sportifs'),(11,19,'éducatifs'),(12,19,'religieux');
/*!40000 ALTER TABLE `preference_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `numero_tele` varchar(20) NOT NULL,
  `adresse_mail` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `role` enum('user','admin','organiser') NOT NULL,
  `statut` enum('connecte','bannis') NOT NULL,
  `photo_path` varchar(255) DEFAULT NULL,
  `preference` int DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Sirine','Ferahita','0123456789','serine@example.com','password123','dob','admin','connecte',NULL,0),(2,'Hasnaa','Bentouri','0123456798','hasnaa@example.com','password123','hasnaa_bentouri','user','connecte',NULL,0),(3,'Sabrinel','sabr','0123456791','sabrinel@example.com','password123','nait-sherif','organiser','connecte',NULL,0),(4,'Hayat','mandarina','0123456792','hayat@example.com','password123','guendoul','user','connecte',NULL,0),(5,'Ines','eyeness','0123456793','ines@example.com','password123','djazari','user','connecte',NULL,0),(6,'Manel','manelll','0123456794','manel@example.com','password123','hamam','user','connecte',NULL,0),(7,'Meriem','meriemm','0123456795','meriem@example.com','password123','layadi','user','connecte',NULL,0),(8,'Meriem','meriem2','0123456796','ghersi@example.com','password123','ghersi','user','connecte',NULL,0),(9,'Noor','camatcho','0123456797','noor@example.com','password123','benhaddiya','user','connecte',NULL,0),(10,'Tahar','Karim','0123456799','tahar@example.com','password123','tahar_karim','user','connecte',NULL,0),(11,'Semsoum','Soumeya','0123456800','soumeya@example.com','password123','soumeya_semsoum','user','connecte',NULL,0),(12,'Chabi','Aya','0123456801','aya@example.com','password123','aya_chabi','user','connecte',NULL,0),(13,'Hanaizi','Meriem','0123456802','meriem@example.com','password123','meriem_hanaizi','user','connecte',NULL,0),(14,'Derahtia','Sirine','0123456803','sirine@example.com','password123','sirine_derahtia','user','connecte',NULL,0),(15,'WF','F','0798989898','sirine@gmail.com','$2y$10$kF/wd6GpYfv3BGsdL9/BKel4S1EUazm0SJ7MCQbvT0q057V1gJFWC','sirine.db','user','connecte','https://i.pinimg.com/736x/1e/05/81/1e05818bf72deae622934d4975db3ede.jpg',0),(16,'ooohihho','fgvbjhnkl','0798989898','user3@gmail.com','$2y$10$OZKS/BWIE1YTVws3Zk3Zmum/keknDesKTLF1U1jVAkB.CITJ8zItS','SSIRINE','user','connecte','https://i.pinimg.com/736x/1e/05/81/1e05818bf72deae622934d4975db3ede.jpg',1),(17,'sabr','sara','0798989898','SABR@gmail.com','$2y$10$jpfPMc4ut9i6uBbZyOAaJu3VSgwiCsM0jIVJduoX3UsHRqsBR7F2C','sabr','user','bannis','https://i.pinimg.com/736x/1e/05/81/1e05818bf72deae622934d4975db3ede.jpg',1),(18,'asdf','qewrry','0798989898','qef@gmail.com','$2y$10$IGUbRVUsyb7fhQNkuSE0TeJCas1t/Kd70NlKsbQ1r/JFGOkpzEOPK','s','user','connecte','https://i.pinimg.com/736x/1e/05/81/1e05818bf72deae622934d4975db3ede.jpg',0),(19,'qwerg`','qwefg','0798989898','AAsirine@gmail.com','$2y$10$507VdSMOAPyA4yhdz8VWb.GBixuXAIqlQ6BfPmsRRTngJlz6hB/fm','ws','admin','connecte','https://i.pinimg.com/736x/1e/05/81/1e05818bf72deae622934d4975db3ede.jpg',1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-12-21 15:00:44
