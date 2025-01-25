<pre>
// BeaconMAN
// Matt Perkins VK2FLY - Copyright (C) 2025 
// This is a quick and somewhat nasty php program to monitor the Beacons at the VK2WI Radio station. 
// It uses the rtl_power package to sample segments of the band and  then compare output power. 

/*

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see .

*/


Dependences: 
rtl_power 
php5.6 
php-mysql-lib 5.6 
mysql 
uhubctl (plus latest pi SOC firmware ) 


DB schema
<pre> 
DROP TABLE IF EXISTS `beacon_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `beacon_history` (
  `seq` int DEFAULT NULL,
  `sample_time` datetime DEFAULT NULL,
  `db_av` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--

DROP TABLE IF EXISTS `beacons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `beacons` (
  `sequence` int NOT NULL,
  `call` varchar(6) DEFAULT NULL,
  `description` varchar(32) DEFAULT NULL,
  `start_freq` varchar(32) DEFAULT NULL,
  `end_freq` varchar(32) DEFAULT NULL,
  `sample_width` varchar(32) DEFAULT NULL,
  `tx_type` varchar(32) DEFAULT NULL,
  `test_active` tinyint(1) DEFAULT NULL,
  `threshold` float DEFAULT NULL,
  `tx_status` char(15) DEFAULT NULL,
  `last_update` datetime DEFAULT NULL,
  KEY `beacons_sequence_IDX` (`sequence`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `beacons`
--

LOCK TABLES `beacons` WRITE;
/*!40000 ALTER TABLE `beacons` DISABLE KEYS */;
INSERT INTO `beacons` VALUES (1,'VK2RSY','2m Beacon 144.420Mhz','144.410M','144.430M','1K','Beacon',1,-14,'','2024-12-24 13:05:28'),(2,'VK2RSY','70cm Beacon 432.420Mhz','432.410M','432.430M','1K','Beacon',1,-14,'FAULT','2024-12-23 21:03:32'),(3,'VK2RSY','6m Beacon 50.289Mhz','50.288M','50.290M','1K','Beacon',1,-14,'','2024-12-23 21:02:36'),(4,'VK2RSY','10m Beacon 28.262Mhz','28.261M','28.263M','1K','Beacon',1,-14,'','2024-12-23 21:02:41'),(5,'VK2RSY','23cm Beacon 1296.420Mhz','1296.419M','1296.421M','1K','Beacon',1,-13.2,'FAULT','2024-12-23 21:02:46'),(6,'VK2WI','Morse Practice 3699Khz','3698.5K','3699.5K','500','Beacon',1,-17,'','2024-12-23 22:06:28');
/*!40000 ALTER TABLE `beacons` ENABLE KEYS */;
UNLOCK TABLES;


