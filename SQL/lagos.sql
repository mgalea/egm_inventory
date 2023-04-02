CREATE DATABASE  IF NOT EXISTS `dblagos` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `dblagos`;
-- MySQL dump 10.13  Distrib 8.0.32, for Win64 (x86_64)
--
-- Host: portal.rnggaming.com    Database: dblagos
-- ------------------------------------------------------
-- Server version	8.0.12

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
-- Table structure for table `brand`
--

DROP TABLE IF EXISTS `brand`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `brand` (
  `id_brand` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id_brand`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;


DROP TABLE IF EXISTS `brand_operator`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `brand_operator` (
  `fk_operator` int(10) unsigned NOT NULL,
  `fk_brand` int(10) unsigned NOT NULL,
  KEY `idx_brand_operator_fk_brand` (`fk_brand`),
  KEY `idx_brand_operator_fk_operator` (`fk_operator`),
  CONSTRAINT `fk_brand_operator_brand` FOREIGN KEY (`fk_brand`) REFERENCES `brand` (`id_brand`),
  CONSTRAINT `fk_brand_operator_operator` FOREIGN KEY (`fk_operator`) REFERENCES `operator` (`license_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `brand_operator`
--

LOCK TABLES `brand_operator` WRITE;
/*!40000 ALTER TABLE `brand_operator` DISABLE KEYS */;
/*!40000 ALTER TABLE `brand_operator` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contacts`
--

DROP TABLE IF EXISTS `contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contacts` (
  `id_contacts` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(35) NOT NULL,
  `surname` varchar(35) NOT NULL,
  `telephone_number` varchar(30) NOT NULL,
  `email` varchar(256) NOT NULL,
  `fk_license_number` int(10) unsigned NOT NULL,
  `cellular_number` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id_contacts`),
  KEY `idx_contacts_fk_license_number` (`fk_license_number`),
  CONSTRAINT `fk_contacts_operator` FOREIGN KEY (`fk_license_number`) REFERENCES `operator` (`license_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contacts`
--

LOCK TABLES `contacts` WRITE;
/*!40000 ALTER TABLE `contacts` DISABLE KEYS */;
/*!40000 ALTER TABLE `contacts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `establishment`
--

DROP TABLE IF EXISTS `establishment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `establishment` (
  `permit_number` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `fk_id_pstl_adr` int(10) unsigned NOT NULL,
  `active` int(11) NOT NULL,
  `fk_license_number_operator` int(10) unsigned NOT NULL,
  `official_permit_number` varchar(100) NOT NULL,
  PRIMARY KEY (`permit_number`),
  UNIQUE KEY `official_permit_number_UNIQUE` (`official_permit_number`),
  KEY `idx_establishment_fk_id_pstl_adr` (`fk_id_pstl_adr`),
  KEY `idx_establishment_fk_license_number_operator` (`fk_license_number_operator`),
  CONSTRAINT `fk_establishment_operator` FOREIGN KEY (`fk_license_number_operator`) REFERENCES `operator` (`license_number`),
  CONSTRAINT `fk_establishment_pstl_adr` FOREIGN KEY (`fk_id_pstl_adr`) REFERENCES `pstl_adr` (`id_pstl_adr`)
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--

--
-- Table structure for table `establishment_type`
--

DROP TABLE IF EXISTS `establishment_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `establishment_type` (
  `fk_permit_number` int(10) unsigned NOT NULL,
  `fk_establishment_type` int(10) unsigned NOT NULL,
  `typestring` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`fk_permit_number`,`fk_establishment_type`),
  KEY `idx_establishment_type_fk_type` (`fk_establishment_type`),
  KEY `idx_establishment_type_fk_license_number` (`fk_permit_number`),
  CONSTRAINT `fk_establishment_type` FOREIGN KEY (`fk_permit_number`) REFERENCES `establishment` (`permit_number`),
  CONSTRAINT `fk_establishment_type_type` FOREIGN KEY (`fk_establishment_type`) REFERENCES `type` (`id_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `establishment_type`
--

LOCK TABLES `establishment_type` WRITE;
/*!40000 ALTER TABLE `establishment_type` DISABLE KEYS */;
INSERT INTO `establishment_type` VALUES (3,4,NULL),(4,7,NULL),(6,5,NULL),(7,6,NULL),(8,5,NULL),(10,6,NULL),(12,5,NULL),(13,5,NULL),(14,5,NULL),(15,5,NULL),(17,5,NULL),(18,4,NULL),(21,5,NULL),(23,7,NULL),(24,5,NULL),(25,6,NULL),(27,6,NULL),(28,5,NULL),(29,5,NULL),(30,5,NULL),(31,7,NULL),(32,5,NULL),(33,5,NULL),(35,7,NULL),(37,6,NULL),(39,5,NULL),(41,6,NULL),(43,6,NULL),(45,7,NULL),(47,5,NULL),(49,7,NULL),(52,7,NULL),(54,5,NULL),(56,5,NULL),(57,6,NULL),(58,5,NULL),(59,7,NULL),(62,5,NULL),(63,6,NULL),(64,5,NULL),(65,5,NULL),(67,5,NULL),(69,5,NULL),(71,5,NULL),(73,5,NULL),(75,5,NULL),(77,5,NULL),(79,5,NULL),(81,7,NULL),(82,5,NULL),(84,5,NULL),(87,6,NULL),(88,4,NULL),(93,4,NULL);
/*!40000 ALTER TABLE `establishment_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `info_slot_machines`
--

DROP TABLE IF EXISTS `info_slot_machines`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `info_slot_machines` (
  `id_info` int(11) NOT NULL AUTO_INCREMENT,
  `slot_machines` int(11) NOT NULL,
  `establishment` int(11) NOT NULL,
  `active` date NOT NULL,
  `revoked` date DEFAULT NULL,
  PRIMARY KEY (`id_info`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;


DROP TABLE IF EXISTS `manual`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `manual` (
  `id_manual` int(11) NOT NULL AUTO_INCREMENT,
  `name_manual` varchar(50) NOT NULL,
  `fk_model` int(10) unsigned NOT NULL,
  `link_manual` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_manual`),
  KEY `idx_manual_fk_model` (`fk_model`),
  CONSTRAINT `fk_manual_model` FOREIGN KEY (`fk_model`) REFERENCES `slot_model` (`id_model`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `manual`
--

LOCK TABLES `manual` WRITE;
/*!40000 ALTER TABLE `manual` DISABLE KEYS */;
/*!40000 ALTER TABLE `manual` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `manual_motherboard`
--

DROP TABLE IF EXISTS `manual_motherboard`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `manual_motherboard` (
  `id_manual` int(11) NOT NULL AUTO_INCREMENT,
  `name_manual` varchar(50) NOT NULL,
  `link_manual` varchar(100) DEFAULT NULL,
  `fk_model` varchar(30) NOT NULL,
  PRIMARY KEY (`id_manual`),
  KEY `idx_manual_fk_model_0` (`fk_model`),
  CONSTRAINT `fk_manual_matherboard` FOREIGN KEY (`fk_model`) REFERENCES `motherboard` (`serial_number_motherboard`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `manufacturer`
--

DROP TABLE IF EXISTS `manufacturer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `manufacturer` (
  `id_manufacturer` int(11) NOT NULL AUTO_INCREMENT,
  `name_manufacturer` varchar(50) NOT NULL,
  `image` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id_manufacturer`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `manufacturer`
--

LOCK TABLES `manufacturer` WRITE;
/*!40000 ALTER TABLE `manufacturer` DISABLE KEYS */;
INSERT INTO `manufacturer` VALUES (8,'Austrian Gaming Industries (AGI)',NULL),(9,'Alphastreet',NULL),(10,'Amatic Industries',NULL),(11,'Aristocrat',NULL),(12,'Aruze',NULL),(13,'Bally Technologies',NULL),(14,'Casino Technology AD',NULL),(15,'DLV',NULL),(16,'GTECH',NULL),(17,'IGT',NULL),(18,'Konami',NULL),(19,'Atronic',NULL),(20,'Euro Games Technology (EGT)',NULL),(21,'Novomatic',NULL),(22,'Spielo',NULL),(23,'TAB Austria',NULL),(24,'WMS',NULL),(25,'TAB Austria',NULL),(26,'Ainsworth Game Technology ',NULL),(27,'Win System',NULL),(28,'Interblock',NULL);
/*!40000 ALTER TABLE `manufacturer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `motherboard`
--

DROP TABLE IF EXISTS `motherboard`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `motherboard` (
  `serial_number_motherboard` varchar(30) NOT NULL,
  `com_jumper_number` varchar(10) DEFAULT NULL,
  `com_jumper_type` varchar(45) DEFAULT NULL,
  `power_jumper_number` varchar(10) DEFAULT NULL,
  `power_jumper_type` varchar(45) DEFAULT NULL,
  `fk_manufacturer` int(11) NOT NULL,
  `model_motherboard` varchar(100) DEFAULT NULL,
  `mb_serial_number` varchar(30) DEFAULT NULL COMMENT 'Actual  motherboard serial number',
  PRIMARY KEY (`serial_number_motherboard`),
  KEY `idx_motherboard_fk_manufacturer` (`fk_manufacturer`),
  CONSTRAINT `fk_motherboard_manufacturer` FOREIGN KEY (`fk_manufacturer`) REFERENCES `manufacturer` (`id_manufacturer`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `operator`
--

DROP TABLE IF EXISTS `operator`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `operator` (
  `license_number` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `jurisdiction` varchar(50) NOT NULL,
  `fk_id_pstl_adr` int(10) unsigned NOT NULL,
  `company_name` varchar(50) NOT NULL,
  `company_telephone` varchar(30) NOT NULL,
  `company_email` varchar(256) NOT NULL,
  `company_website` varchar(256) DEFAULT NULL,
  `official_license_number` varchar(50) NOT NULL,
  PRIMARY KEY (`license_number`),
  UNIQUE KEY `official_license_number_UNIQUE` (`official_license_number`),
  KEY `idx_operator_fk_id_pstl_adr` (`fk_id_pstl_adr`),
  CONSTRAINT `fk_id_pstl_adr` FOREIGN KEY (`fk_id_pstl_adr`) REFERENCES `pstl_adr` (`id_pstl_adr`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `peripherals`
--

DROP TABLE IF EXISTS `peripherals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `peripherals` (
  `id_peripheral` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`id_peripheral`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `peripherals`
--

LOCK TABLES `peripherals` WRITE;
/*!40000 ALTER TABLE `peripherals` DISABLE KEYS */;
/*!40000 ALTER TABLE `peripherals` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `photos`
--

DROP TABLE IF EXISTS `photos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `photos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(300) DEFAULT NULL,
  `fk_serial_number` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_serial_number_idx` (`fk_serial_number`),
  CONSTRAINT `fk_photos_slot_machines` FOREIGN KEY (`fk_serial_number`) REFERENCES `slot_machines` (`serial_number`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pstl_adr`
--

DROP TABLE IF EXISTS `pstl_adr`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pstl_adr` (
  `id_pstl_adr` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `strt_nm` varchar(100) NOT NULL,
  `bldg_nm` varchar(30) DEFAULT NULL,
  `twn_nm` varchar(30) NOT NULL,
  `region` varchar(45) DEFAULT NULL,
  `ctry` varchar(10) NOT NULL,
  `pstl_code_number` varchar(10) DEFAULT NULL,
  `latitude` decimal(11,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  PRIMARY KEY (`id_pstl_adr`)
) ENGINE=InnoDB AUTO_INCREMENT=161 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `slot_machines`
--

DROP TABLE IF EXISTS `slot_machines`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `slot_machines` (
  `slot_id` int(11) NOT NULL AUTO_INCREMENT,
  `serial_number` varchar(30) NOT NULL,
  `fk_model` int(10) unsigned NOT NULL,
  `date_manufacturing` date NOT NULL,
  `fk_slot_type` int(11) NOT NULL,
  `fk_license_number` int(10) unsigned NOT NULL,
  `commission` tinyint(1) NOT NULL,
  `date_commission` date NOT NULL,
  `date_decommission` date DEFAULT NULL,
  `multi_game` tinyint(1) NOT NULL,
  `multi_terminal` tinyint(1) NOT NULL,
  `est_location` varchar(256) DEFAULT NULL,
  `reg_number` int(11) DEFAULT NULL,
  `operator_number` int(11) DEFAULT NULL,
  `fk_serial_number_motherboard` varchar(30) NOT NULL,
  `is_original` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`serial_number`),
  UNIQUE KEY `slot_id_UNIQUE` (`slot_id`),
  KEY `idx_slot_machines_fk_license_number` (`fk_license_number`),
  KEY `idx_slot_machines_fk_manufacturer` (`fk_model`),
  KEY `idx_slot_machines_fk_type` (`fk_slot_type`),
  KEY `idx_slot_machines_fk_serial_number_motherboard` (`fk_serial_number_motherboard`),
  CONSTRAINT `fk_slot_machines_motherboard` FOREIGN KEY (`fk_serial_number_motherboard`) REFERENCES `motherboard` (`serial_number_motherboard`),
  CONSTRAINT `fk_slot_machines_operator` FOREIGN KEY (`fk_license_number`) REFERENCES `operator` (`license_number`),
  CONSTRAINT `fk_slot_machines_slot_model` FOREIGN KEY (`fk_model`) REFERENCES `slot_model` (`id_model`),
  CONSTRAINT `fk_type_slot_machines` FOREIGN KEY (`fk_slot_type`) REFERENCES `type_slot_machines` (`id_type_slot_machines`)
) ENGINE=InnoDB AUTO_INCREMENT=1255 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `slot_machines_establishment`
--

DROP TABLE IF EXISTS `slot_machines_establishment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `slot_machines_establishment` (
  `fk_establishment` int(10) unsigned NOT NULL,
  `fk_slot_machines` varchar(30) NOT NULL,
  KEY `idx_contract_fk_slot_machines` (`fk_slot_machines`),
  KEY `idx_contract_fk_establishment` (`fk_establishment`),
  CONSTRAINT `fk_slot_machines_establishment` FOREIGN KEY (`fk_establishment`) REFERENCES `establishment` (`permit_number`),
  CONSTRAINT `fk_slot_machines_establishment2` FOREIGN KEY (`fk_slot_machines`) REFERENCES `slot_machines` (`serial_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
--
-- Table structure for table `slot_machines_peripherals`
--

DROP TABLE IF EXISTS `slot_machines_peripherals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `slot_machines_peripherals` (
  `fk_id_slot_machines` varchar(30) NOT NULL,
  `fk_id_peripheral` int(11) NOT NULL,
  KEY `idx_slot_machines_peripherals_fk_id_peripheral` (`fk_id_peripheral`),
  KEY `fk_serial_number_idx` (`fk_id_slot_machines`),
  CONSTRAINT `fk_id_peripherals` FOREIGN KEY (`fk_id_peripheral`) REFERENCES `peripherals` (`id_peripheral`),
  CONSTRAINT `fk_slot_machines_peripherals` FOREIGN KEY (`fk_id_slot_machines`) REFERENCES `slot_machines` (`serial_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `slot_machines_peripherals`
--

LOCK TABLES `slot_machines_peripherals` WRITE;
/*!40000 ALTER TABLE `slot_machines_peripherals` DISABLE KEYS */;
/*!40000 ALTER TABLE `slot_machines_peripherals` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `slot_model`
--

DROP TABLE IF EXISTS `slot_model`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `slot_model` (
  `id_model` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name_model` varchar(20) DEFAULT NULL,
  `fk_id_manufacturer` int(11) NOT NULL,
  PRIMARY KEY (`id_model`),
  KEY `idx_model_fk_id_manufacturer` (`fk_id_manufacturer`),
  CONSTRAINT `fk_model_manufacturer` FOREIGN KEY (`fk_id_manufacturer`) REFERENCES `manufacturer` (`id_manufacturer`)
) ENGINE=InnoDB AUTO_INCREMENT=113 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `slot_model`
--

LOCK TABLES `slot_model` WRITE;
/*!40000 ALTER TABLE `slot_model` DISABLE KEYS */;
INSERT INTO `slot_model` VALUES (8,'WIKY',9),(9,'FS 470 F2',8),(10,'FV 600 CF2',8),(11,'FV 610 CF2',8),(12,'FV 834 F2',8),(13,'PERFORMER GRAND A',10),(14,'GENX-WD00',12),(15,'Pro Series MKT-AP-1',13),(16,'MK2A-S9000-0001',13),(17,'DIAMOND',15),(18,'EGT-VS8',20),(19,'EGT-VS14',20),(20,'AXXIS 23/23',16),(21,'AXXIS 3D/39',16),(22,'96499410',17),(23,'96499810',17),(24,'96499812',17),(25,'96499817',17),(26,'KGP 2.0 UVSN',18),(27,'KGP 3.5 PDM2',18),(28,'MAXVUSION',22),(29,'SEPOXG',22),(30,'Go4Gold',23),(31,'BLADE S',24),(32,'BLADE S23',24),(33,'Bluebird 2 (BB2)',24),(34,'FV 623',8),(35,'FW 623',8),(36,'FV 629 CF2',8),(37,'FW 629 CF2',8),(38,'FV 880',8),(39,'eMotion',19),(40,'Blade',24),(41,'AP-1',13),(42,'FV 881 F2',8),(43,'Helix Upright Gen 8',11),(45,'SEPOST',22),(49,'FV 640 F2',8),(50,'AH-1',13),(51,'EGT-VS12',20),(52,'FV 880 F',8),(53,'FS 590',8),(54,'EGT-VS9',20),(55,'VIRIDIAN WS',11),(56,'SEPOXG OXYGEN',22),(63,'Helix Slant Gen 8',11),(64,'FA 880 F2 C08',8),(65,'A600-H',26),(66,'S3',27),(67,'FF2 DL-PUB',21),(68,'ROULETTE PRESS',10),(69,'FA 880 F2 C05',21),(71,'6900',14),(72,'GEMINI 6900 Plus',14),(74,'VIRIDIAN WS Gen7',11),(75,'XCITE MK6',11),(76,'GEMINI 6639',14),(77,'HIHA',19),(78,'ARC Gen8',11),(82,'FV 880 C2',8),(83,'FV 800 CF2',8),(85,'FV 880 CF2',8),(86,'EGT-VS10-2',20),(87,'96499417',17),(89,'ORGANIC PLAYSTATION',28),(90,'ORGANIC ROULETTE',28),(93,'SEPOXG_OXYGEN',19),(96,'SEPOXG_OXYGEN',16),(97,'FV 623 CF D',8),(99,'AXXIS_3D/39',22),(100,'S9-1',13),(101,'BBU',24),(102,'96497500',17),(103,'FV640 F2',21),(104,'FV623A CF2',21);
/*!40000 ALTER TABLE `slot_model` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tag`
--

DROP TABLE IF EXISTS `tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag_number` varchar(30) NOT NULL,
  `date_active` date NOT NULL,
  `fk_serial_number` varchar(30) NOT NULL,
  `broken` tinyint(1) DEFAULT '0',
  `active` tinyint(4) DEFAULT '0',
  `removed` tinyint(4) DEFAULT '0',
  `tagcol` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`tag_number`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `idx_seal_fk_serial_number` (`fk_serial_number`),
  CONSTRAINT `fk_seal_slot_machines` FOREIGN KEY (`fk_serial_number`) REFERENCES `slot_machines` (`serial_number`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;


DROP TABLE IF EXISTS `type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `type` (
  `namet` varchar(50) NOT NULL,
  `id_type` int(10) unsigned NOT NULL AUTO_INCREMENT,
  UNIQUE KEY `idx_type_fk_license_number` (`id_type`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `type`
--

LOCK TABLES `type` WRITE;
/*!40000 ALTER TABLE `type` DISABLE KEYS */;
INSERT INTO `type` VALUES ('Casino',4),('Gaming Parlour',5),('Bingo Hall',6),('Warehouse',7);
/*!40000 ALTER TABLE `type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `type_slot_machines`
--

DROP TABLE IF EXISTS `type_slot_machines`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `type_slot_machines` (
  `id_type_slot_machines` int(11) NOT NULL AUTO_INCREMENT,
  `name_type` varchar(45) NOT NULL,
  PRIMARY KEY (`id_type_slot_machines`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `type_slot_machines`
--

LOCK TABLES `type_slot_machines` WRITE;
/*!40000 ALTER TABLE `type_slot_machines` DISABLE KEYS */;
INSERT INTO `type_slot_machines` VALUES (8,'Slant Top'),(10,'Upright'),(12,'tabletop');
/*!40000 ALTER TABLE `type_slot_machines` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `type_user`
--

DROP TABLE IF EXISTS `type_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `type_user` (
  `id_type_user` int(11) NOT NULL,
  `type_value` varchar(20) NOT NULL,
  PRIMARY KEY (`id_type_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `type_user`
--

LOCK TABLES `type_user` WRITE;
/*!40000 ALTER TABLE `type_user` DISABLE KEYS */;
INSERT INTO `type_user` VALUES (1,'Administrator'),(2,'User');
/*!40000 ALTER TABLE `type_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(45) DEFAULT NULL,
  `last_name` varchar(45) DEFAULT NULL,
  `personal_id` varchar(45) DEFAULT NULL,
  `username` varchar(100) NOT NULL,
  `user_pasw` varchar(220) NOT NULL,
  `user_type` int(11) NOT NULL,
  `email` varchar(253) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `organization` varchar(100) DEFAULT NULL,
  `image` varchar(45) DEFAULT NULL,
  `role` varchar(45) DEFAULT NULL,
  `active` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_users_user_type` (`user_type`),
  CONSTRAINT `fk_users_type_user` FOREIGN KEY (`user_type`) REFERENCES `type_user` (`id_type_user`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Mario','Galea','412169M','Administrator','14491622486423fbb2e6acf:f11deaf2d6e1b49b9806863bea606f3dbf4b1678728aa83150727dd3c3272a744263bbfd914d7a96a14b4e1c3d4a5b946de084dadf587bee2619ba62ec048b39',1,'mario.s.galea@gmail.com','99445314','Random',NULL,NULL,1,'2023-03-29 08:33:44','2023-03-29 08:53:39');
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

-- Dump completed on 2023-04-01 17:06:40
