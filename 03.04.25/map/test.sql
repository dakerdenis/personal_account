-- MySQL dump 10.13  Distrib 8.0.30, for Linux (x86_64)
--
-- Host: localhost    Database: test
-- ------------------------------------------------------
-- Server version	8.0.30

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
-- Table structure for table `cities`
--

DROP TABLE IF EXISTS `cities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cities` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cities`
--

LOCK TABLES `cities` WRITE;
/*!40000 ALTER TABLE `cities` DISABLE KEYS */;
INSERT INTO `cities` VALUES (1,'Baku'),(3,'Sumgayıt'),(4,'Xaçmaz'),(5,'Qusar'),(6,'Qəbələ'),(7,'Göyçəy'),(8,'Şirvan'),(9,'Masallı'),(10,'Lənkaran'),(11,'İmişli'),(12,'Bərdə'),(13,'Biləsuvar'),(14,'Şəki'),(15,'Mingəçevir'),(16,'Zaqatala'),(17,'Gəncə'),(18,'Qazax'),(19,'Naxçivan'),(20,'Qaradağ'),(21,'Tovuz');
/*!40000 ALTER TABLE `cities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clinics`
--

DROP TABLE IF EXISTS `clinics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `clinics` (
  `id` int NOT NULL AUTO_INCREMENT,
  `clinic_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `numbers` varchar(255) NOT NULL,
  `adress` varchar(255) NOT NULL,
  `adress2` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clinics`
--

LOCK TABLES `clinics` WRITE;
/*!40000 ALTER TABLE `clinics` DISABLE KEYS */;
INSERT INTO `clinics` VALUES (9,'AQS Dental-Center Ltd ','018 64 85141, 018 65 63513(103), 0558542598(п), 0554508884(п)-sığorta, 0558287513, 0554143273','Sumqayit, mkr. 13, h.55','Green house ilə üzbəüz','AQS-x.isayeva@aqsgroup.az','3'),(10,'Implant Dental, Sumgayit','018 65 20609, 0124082196 0186421896, 0507441896, 0702021896','Sumqayıt şəhəri 6-cı mkr-n, Cəlil Məmmədquluzadə küç.','Yeni bulvarın yanı','implant_sigorta@mail.ru','3'),(11,'Liman, Sumgayit','5851421(100),  050 235 24 34','Sumgayıt S.Vurgun 35','Dörd qardaş restoranı','kazimov-rovshen@mail.ru','3'),(12,'Müasir Stomatologiya','050 243 88 01, 050 277 11 70 , 070 326 21 09 , 018 655 48 98','Sumqayit, 3 məhəllə, Nizami küç. 23/14','İcra Hakimiyyətinin yanı','muasir.stomatologiya@mail.ru','3'),(13,'Real Clinic Sumgait','447-04-25; 447-04-26; 447-04-28, 585 12 69/Tibbi Sığorta, 0186424581 (но ночам также), Айнур 0557104075,  0507441103(по ночам также)','Sumgayıt 45 kvartal','14 mərtəbəli bina','real_saglamliq_klinikasi@mail.ru','3'),(14,'Sumqayıt Hospital','(+994 18) 656 82 55;  (+994 99) 800 02 55, (051 201 52 41-Sığorta rəhbəri Könül x)  0554685707','Sumqayıt ş.,12 mkr. Çerkassi k.181','','sumqayithospital@gmail.com Konul.quliyeva.atu@mail.ru','3'),(15,'N-Kay Medical ','050 262 88 87','Xaçmaz şəh., Nəriman Nərimanov 49','Mərkəzi xəstəxananın yanı','nkaymedical@gmail.com','4'),(16,'OKI Gusary','0233852915, Айтен 0513640310 (но ночам также)(п),0505971647 (по ночам также)','Qusar ş.,Fərhad Musayev 27','Nərimanov parkı','oki.klinikasi@mail.ru','5'),(17,'TEST BAKU ','TEST BAKU ','TEST BAKU','TEST BAKU','test@test.ru','1'),(18,'Sağlam Həyat','994 706 330 360','Qəbələ şəhəri, H. Aslanov küç','','sheyat2006@gmail.com','6'),(19,'REFERANS QƏBƏLƏ TİBB MƏRKƏZİ” MMC',' 0777600033, 077 345 00 33, Whatsapp: 070 653 00 33','Qəbələ şəh, Abbas Səhət küç, 25A','',' lady_emma@mail.ru','6'),(20,'Bioloji Təbabət','0502461411, 0552597090','Göyçay şəhəri, M. Muradov küç, 12','Göyçay şəhəri','b.mamedov_bt@mail.ru','7'),(21,'Dental-MM Şirvan','0515353430 ,(021)2150030 ,mob: (055)5353434, 0776110001(Mahir baş həkim)','Şirvan şəh Xəqani küç.ev 2A','Şirvan,Mərkəzdə dəmiryol tunelin yaxınlığı,məktəb N18,İnarə şadlıq s.','','8'),(22,'Şirvan Oil Tibb Məntəqəsi','994556404148(Aftandil), (0502229586, 0502557986-Teyyub (nadir hallarda yığılsın)','Şirvan şəh Gülbala-Şıxbala küç 74.','Şirvan Oil Neft Şirkətinin yanı','aftandilqurban78@gmail.com','8'),(23,'Bioloji Təbabət','0555328988, 0507545040','Masallı şəhəri, E. Hüseynov küç','Masallı şəhəri','b.mamedov_bt@mail.ru','9'),(24,'MEDICAN HOSPITAL Tibb mərkəzi','(025) 255 02 98,   070 255 02 98(п), 050 266 02 98(п), 0707107199 (Baş Həkim)','Lənkəran ş-ri, 20 Yanvar k-su 71','MSES ilə üzbə-üz','nkaymedical@gmail.com','10'),(25,'MEDISAN tibb mərkəzi','9942124-6-10-70,  99470246-10-70(İlahə), 99451634-09-06(Məmməd buxalter)','İmişli şəh,H.Əliyev prospekti 131','Mədəniyyət evinin yanı','labmed609@gmail.com','11'),(26,' OMURDEN PAY','050 791 06 16 Ульвия,    0502867688 Эльнур главврач  ,0202053100',' ş. Bərdə,N.Nərimanov küç 2',' Doğum evi','dr.men@bk.ru','12'),(27,'Vita Med','051 795 00 08','Biləsuvar şəhəri, 1 May küç, ev 7','-','-','13'),(28,'Alyans','055 925 55 11','Şəki şəhəri, Mirzə Fəəli Axundov küç, ev 351A','Şəki şəhəri','Alyansmed.sheki@mail.ru','14'),(29,'BONUM MEDİCAL “FORTİS-İ” MMC','050 663 00 88','Şəki şəh, Zərifə ƏLiyeva küç, 90','-','fortis.sheki@gmail.com','14'),(30,'REGİONAL HOSPİTAL','0705287771,  0703287771','Mingəçevir Şəhəri, Dilarə Əliyeva küçəsi, 2 C','Herbi hissenin yaninda,7 N mektebin yaninda Samux Sadliq evinin sol hissesinde','ulviovsar@gmail.com sebineezizli5@gmail.com','15'),(31,'Shafa Diagnostic Center','994504033670(Aygül)','Xan Şuşinski küç. 2а, Mingəçevir','Mərkəzi xəstəxananın yanı','sefadiaqnostika@mail.ru sefa_mahmudova@mail.ru','15'),(32,'LABSTYLE”MMC','0503851737   ',' Zaqatala şəh, Vidadi küç, 34','-','ecavansir@list.ru','16'),(33,'Gəncə beynəlxalq xəstəxanası','022 255 3838,  022 255 8383,  055 500 71 13,   055 500 71 25 (П) ,Nərqiz xan. 055 500 71 13','H.Əliyev pr. 60D/E/F',' Kəpəz r-n polis idarəsinin yaxınlığında',' insurance@gih.az','17'),(34,' MediClub Ganja','050 2230451 (reception) , 050 220 4742,  (022) 2578744,  (022) 2578208',' Abbaszadə küç. 47',' Kukla teatrının yanı','-','17'),(35,'YENI GƏNCƏ','(022) 2540700,  (022) 2542755, 051 3864613(п), 0774035040(п)',' 28 may küç',' H.Əliyev parkı','-','17'),(36,' Apex Dental','994503340634 İlahə, (994552340634(Direktor)','Gəncə şəhəri, Gəncə Beynəlxalq Xəstəxanası, Heydər Əliyev prospekti 60 D/E/F',' ASAN Xidmətin yanı','-','17'),(37,'Stomadent','Reception 994503376660,  0557713281(Sultanova Kəmalə baş həkim )','Həsən Əliyev 254/42 Gəncə','    Heydər Əliyev Universiteti yanı 95 apteklə yanaşı','-','17'),(38,'LABMED TİBB MƏRKƏZİ MMC','0502739012/13 reception , 0502739010 Turan x baş hekim  ,070262 95 95, 0502739015','Qazax rayonu, Qazax şəhəri, Heydər Əliyev 134.','-',' labmed609@gmail.com','18'),(39,'Naxçıvan Diaqnostika Müalicə Məkəzı','994 706 567 825','Naxçıvan şəhəri Ə.Əliyev küçəsi,66','-','-','19'),(40,'Shafa Medical Center',' (036) 5456432    050 ,055,070 3476649',' Naxçivan, Məmmədquluzadə 13','Tikiş fabriki, şəhər qəbirsanlığı, H.Əliyev parkının yanı','-','19'),(41,'Sədəf','994124463304, 994503087866 (Nərmin)',' Qaradağ rayonu,Sahil qəs,B.Əliyev küç.33','-','nermine.talibova.sedefsigorta@gmail.com','20'),(42,'Тестовая клиника','Тестовая клиника','Тестовая клиника','Тестовая клиника','Тестовая клиника','21');
/*!40000 ALTER TABLE `clinics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) NOT NULL DEFAULT 'rasmuslerdorf',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'daker','geklas123','rasmuslerdorf'),(2,'admin','Servis101','rasmuslerdorf');
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

-- Dump completed on 2024-07-09 12:03:36
