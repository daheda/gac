
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `tickets_appels`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `tickets_appels` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `tickets_appels`;

--
-- Table structure for table `detail_appel`
--

DROP TABLE IF EXISTS `detail_appel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detail_appel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero_abonne` bigint(20) NOT NULL,
  `date_facture` datetime NOT NULL,
  `heure_facture` time DEFAULT NULL,
  `duree_total` int(11) DEFAULT NULL,
  `duree_facture` int(11) DEFAULT NULL,
  `type_appel_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_detail_appel_type_appel_idx` (`type_appel_id`),
  CONSTRAINT `fk_detail_appel_type_appel` FOREIGN KEY (`type_appel_id`) REFERENCES `type_appel` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detail_appel`
--

LOCK TABLES `detail_appel` WRITE;
/*!40000 ALTER TABLE `detail_appel` DISABLE KEYS */;
/*!40000 ALTER TABLE `detail_appel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `type_appel`
--

DROP TABLE IF EXISTS `type_appel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `type_appel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `type_appel`
--

LOCK TABLES `type_appel` WRITE;
/*!40000 ALTER TABLE `type_appel` DISABLE KEYS */;
/*!40000 ALTER TABLE `type_appel` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;