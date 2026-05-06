-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: libreria
-- ------------------------------------------------------
-- Server version	8.0.45

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `categoria`
--

DROP TABLE IF EXISTS `categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categoria` (
  `id` int NOT NULL AUTO_INCREMENT,
  `categoria` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre` (`categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria`
--

LOCK TABLES `categoria` WRITE;
/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
INSERT INTO `categoria` VALUES (5,'Fantasía'),(2,'Filosofía'),(6,'Horror'),(1,'Literatura Contemporánea'),(3,'Psicología'),(4,'Sociología');
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `imagen`
--

DROP TABLE IF EXISTS `imagen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `imagen` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre_archivo` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `imagen`
--

LOCK TABLES `imagen` WRITE;
/*!40000 ALTER TABLE `imagen` DISABLE KEYS */;
INSERT INTO `imagen` VALUES (6,'La Minita del tatami.jpg'),(7,'Tatami Galaxy.png'),(8,'Amor líquido. Acerca de la fragilidad de los vínculos humanos.jpg'),(9,'Las cartas que no llegaron.jpg'),(10,'Cien años de soledad.jpg'),(11,'1984.jpg'),(12,'El Señor de los Anillos.png'),(13,'Your-Lie-in-April-de-que-se-trata_censored.jpg'),(14,'Amor líquido. Acerca de la fragilidad de los vínculos humanos.jpg'),(15,'WhatsApp Image 2026-03-23 at 9.12.20 AM_censored.jpg');
/*!40000 ALTER TABLE `imagen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item_pedido`
--

DROP TABLE IF EXISTS `item_pedido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `item_pedido` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fk_orden` int NOT NULL,
  `fk_libro` int NOT NULL,
  `cantidad` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `item_pedido_pedido_FK` (`fk_orden`),
  KEY `item_pedido_libro_FK` (`fk_libro`),
  CONSTRAINT `item_pedido_libro_FK` FOREIGN KEY (`fk_libro`) REFERENCES `libro` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `item_pedido_pedido_FK` FOREIGN KEY (`fk_orden`) REFERENCES `pedido` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item_pedido`
--

LOCK TABLES `item_pedido` WRITE;
/*!40000 ALTER TABLE `item_pedido` DISABLE KEYS */;
INSERT INTO `item_pedido` VALUES (1,1,1,1),(2,1,13,264),(3,2,1,7),(4,3,1,7),(5,4,3,2),(6,5,13,4),(7,5,14,1);
/*!40000 ALTER TABLE `item_pedido` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `libro`
--

DROP TABLE IF EXISTS `libro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `libro` (
  `id` int NOT NULL AUTO_INCREMENT,
  `isbn` varchar(13) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `autor` varchar(100) NOT NULL,
  `editorial` varchar(100) NOT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `paginas` int NOT NULL,
  `anio_publicacion` int NOT NULL,
  `existencia` int NOT NULL,
  `precio_compra` decimal(10,2) NOT NULL,
  `precio_venta` decimal(10,2) NOT NULL,
  `estado` tinyint NOT NULL DEFAULT '1',
  `creado` datetime NOT NULL,
  `modificado` datetime DEFAULT NULL,
  `fk_categoria` int NOT NULL,
  `fk_imagen` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `isbn` (`isbn`),
  KEY `fk_categoria` (`fk_categoria`),
  KEY `fk_imagen` (`fk_imagen`),
  CONSTRAINT `libro_ibfk_1` FOREIGN KEY (`fk_categoria`) REFERENCES `categoria` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `libro_ibfk_2` FOREIGN KEY (`fk_imagen`) REFERENCES `imagen` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `libro`
--

LOCK TABLES `libro` WRITE;
/*!40000 ALTER TABLE `libro` DISABLE KEYS */;
INSERT INTO `libro` VALUES (1,'3567304956873','El Diario de Luis Pucheta','Luis Fernando Pucheta Hernandez','AvovA','23edwc',123,234,560,345.00,456.00,1,'2026-03-09 00:10:53','2026-03-09 19:36:40',4,7),(2,'9789681683726','Amor líquido. Acerca de la fragilidad de los vínculos humanos\r\n','Mauricio Rosencof','Fondo de Cultura Economica','El autor analiza el amor y cómo, en la esfera creciente de lo comercial, las relaciones son pensadas en términos de costo y beneficio. A través de una reflexión audaz y original revela las injusticias y las angustias de la modernidad sin ser absolutamente pesimista, con la esperanza de que es posible superar los problemas que plantea la moderna sociedad líquida.\r\n\r\n',203,2003,100,280.00,380.00,1,'2026-04-05 22:28:54',NULL,4,8),(3,'9786071690623','Las cartas que no llegaron\r\n','Zygmunt Bauman','Fondo de Cultura Economica','Mauricio Rosencof recuerda su vida y la de su familia a través de cartas que nunca llegaron. Mientras narra la cotidianeidad de su infancia como hijo de inmigrantes judíos polacos en Uruguay, su padre espera noticias de su familia en Europa, quienes le escriben sobre sus últimos días en un campo de exterminio, pero el mensaje nunca es enviado. Años después, mientras está como prisionero político, Mauricio escribe a su papá sobre los paralelismos que vive ahora con su familia, sobre los recuerdos, la resiliencia y la añoranza. Y aunque aquellas palabras tampoco llegarán, seguirán trascendiendo mientras haya memoria.\r\n\r\n',150,2000,48,190.00,290.00,1,'2026-04-05 22:34:56',NULL,4,9),(13,'9788437604947','Cien años de soledad','Gabriel García Márquez','Diana','REvision',464,1967,46,150.00,250.00,1,'2026-04-06 05:33:36','2026-04-10 00:06:53',5,14),(14,'9788420674209','1984','George Orwell','Alianza Editorial','Ficción distópica sobre vigilancia gubernamental.',352,1949,29,120.00,199.90,1,'2026-04-06 05:33:36',NULL,2,11),(15,'9788445076633','El Señor de los Anillos','J.R.R. Tolkien','Minotauro','Fantasía épica ambientada en la Tierra Media.',1200,1954,15,350.00,500.00,1,'2026-04-06 05:33:36',NULL,3,12),(16,'2345872394587','Godspeed','Franco Oceano','Boys Don&#039;t Cry','Wishing you',258,2016,17,120.00,240.00,1,'2026-04-06 07:29:01','2026-04-06 07:29:53',1,13),(17,'2342342342342','El Diario de Luis 234','Luis Fernando Pucheta','AlfaOmega','Ramiro',2342,2036,345,123.00,234.00,1,'2026-04-10 00:08:08',NULL,4,15);
/*!40000 ALTER TABLE `libro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pedido`
--

DROP TABLE IF EXISTS `pedido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pedido` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fk_usuario` int NOT NULL,
  `total` float NOT NULL DEFAULT '0',
  `estado` enum('Pendiente','Completa','Cancelada') DEFAULT 'Pendiente',
  `creada` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pedido_usuario_FK` (`fk_usuario`),
  CONSTRAINT `pedido_usuario_FK` FOREIGN KEY (`fk_usuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedido`
--

LOCK TABLES `pedido` WRITE;
/*!40000 ALTER TABLE `pedido` DISABLE KEYS */;
INSERT INTO `pedido` VALUES (1,3,66456,'Pendiente','2026-04-06 07:18:50'),(2,3,3192,'Pendiente','2026-04-06 07:22:08'),(3,3,3192,'Pendiente','2026-04-06 07:47:10'),(4,3,580,'Pendiente','2026-04-06 07:59:23'),(5,3,1199.9,'Pendiente','2026-04-10 00:05:46');
/*!40000 ALTER TABLE `pedido` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `persona`
--

DROP TABLE IF EXISTS `persona`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `persona` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `a_paterno` varchar(100) NOT NULL,
  `a_materno` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `calle` varchar(150) NOT NULL,
  `numero` varchar(50) NOT NULL,
  `codigo_postal` varchar(10) NOT NULL,
  `ciudad` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `telefono` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `correo_electronico` varchar(150) NOT NULL,
  `creado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modificado` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `correo_electronico` (`correo_electronico`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `persona`
--

LOCK TABLES `persona` WRITE;
/*!40000 ALTER TABLE `persona` DISABLE KEYS */;
INSERT INTO `persona` VALUES (1,'Mirai','Kuri','Yama','Jetas','123','369','JDG','234','user1@gmail.com','2026-03-13 05:49:45',NULL),(3,'usuario','usuario','usuario','123','234','345','Estoy loco ✋🏻😛🤚🏻','1234567890','user@gmail.com','2026-03-17 06:23:39',NULL),(4,'administrador','administrador','administrador','123','234','345','Estoy loco ✋🏻😛🤚🏻','1234567890','admin@gmail.com','2026-03-17 06:25:01',NULL),(5,'NOHACS','JUST','ROBLOX','For','123','of','your','5610096623','nojacsjutsroblox@gmail.com','2026-04-09 23:13:33',NULL),(6,'Iraes','sdadf','adfad','213','234','34534','Tizayuca','83214762983','israel@gmail.com','2026-04-10 00:03:36',NULL);
/*!40000 ALTER TABLE `persona` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fk_persona` int NOT NULL,
  `tipo_usuario` enum('cliente','administrador') NOT NULL DEFAULT 'cliente',
  `activo` tinyint NOT NULL DEFAULT '0',
  `creado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modificado` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `usuario` (`usuario`),
  KEY `fk_persona` (`fk_persona`),
  CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`fk_persona`) REFERENCES `persona` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'user1','$2y$10$194g41flCqdbQQiTcvKpyu3MOi9f8yQoLnfI4JJrFo9hBFKHe0NmG',1,'cliente',1,'2026-03-13 05:49:45','2026-03-13 05:50:01'),(3,'user','$2y$10$LTpTFXo6pxP3UzL61Rl9pO4XREERpTDLu8EjE3/HL2yqoakzjj5lC',3,'cliente',1,'2026-03-17 06:23:39','2026-03-17 06:29:30'),(4,'admin','$2y$10$Sqsph5tURUEUZcje03CB1..FRaaBLf8zrGX4Nub6tM8rUlgnsWsoW',4,'administrador',1,'2026-03-17 06:25:01','2026-04-06 02:59:11'),(5,'NOJACS','$2y$10$uOLlpM2/EuZjyywVXn0vM.du7kx47fBcKQQFTrXxXBL7RKruHIE7m',5,'cliente',1,'2026-04-09 23:13:34','2026-04-09 23:17:24'),(6,'Israel','$2y$10$cK8A/jRBq497wXl/InCkE.FF2gGq8zXiL0/FOkn7KuBjWGBMU2tHK',6,'cliente',1,'2026-04-10 00:03:37','2026-04-10 00:03:53');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'libreria'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-05-06 16:51:45
