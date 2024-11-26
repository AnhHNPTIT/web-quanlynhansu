-- MySQL dump 10.13  Distrib 8.0.40, for Linux (x86_64)
--
-- Host: localhost    Database: db_hr
-- ------------------------------------------------------
-- Server version	8.0.40-0ubuntu0.20.04.1

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
-- Table structure for table `NhanVien`
--

DROP TABLE IF EXISTS `NhanVien`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `NhanVien` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `maPB` int unsigned DEFAULT NULL,
  `hoTen` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `soDT` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `anhThe` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `gioiTinh` enum('Nam','Nữ','Khác') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `ngaySinh` date NOT NULL,
  `diaChi` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `bangCap` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `soCMND` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `maBHXH` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `maBHYT` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `luong` int DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_NhanVien_1_idx` (`maPB`),
  CONSTRAINT `fk_NhanVien_1` FOREIGN KEY (`maPB`) REFERENCES `PhongBan` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `NhanVien`
--

LOCK TABLES `NhanVien` WRITE;
/*!40000 ALTER TABLE `NhanVien` DISABLE KEYS */;
INSERT INTO `NhanVien` VALUES (1,NULL,'Bùi Huy Toàn','trong@gmail.com','00000000000000','168557930820230601072828MoSGLHcrZ3H0IYevwayx75kGuDazx9fyM1lw4MAa.png','Nữ','2023-05-31','BN','ĐH','1111111111','3222222222222','44444444444',0),(4,NULL,'Phan Văn ABC','abcphanvan@gmail.com','0350001111','16855189892023053114430977RM9cggQtvI9ZlYc3ndMeIrq6a3n5wSJrlx5Oiv.png','Nam','2023-05-01','HN 2','Đại học','00000000','111111111111','222222222222',0),(5,NULL,'Nguyễn Trọng Nhân','trongnhan@gmail.com','03311111111','1685518923202305311442030OFC5j1OOzgQXyZwnPCEpGl2h0emeurDY2D8lSx6.png','Nam','2023-05-01','HN','Tiến sĩ','000000000001','000000000002','000000000003',0),(6,NULL,'Bùi Huy Trọng','trong@gmail.com','00000000000000','168554911620230531230516VKeiDcDp6Q48RiBwZtjzrZLfeJHuFCc1O6rUgIp5.png','Nữ','2023-05-31','BN','ĐH','1111111111','3222222222222','44444444444',0),(8,1,'MKK','test@gmail.com','0331278291','public/images/img_2024-11-26-19-28.png','Nữ','2024-11-09','Tầng 2 tòa Handico','DH','11212',NULL,NULL,9898),(9,2,'MKK','test@gmail.com','0331278291','public/images/img_2024-11-26-19-41.png','Nữ','2024-11-12','Tầng 2 tòa Handico','DH','11212',NULL,NULL,9898),(10,1,'MKK2','test@gmail.com','0331278291','public/images/img_2024-11-26-19-50.png','Nam','2024-11-10','Tầng 2 tòa Handico','DH','11212',NULL,NULL,9898),(11,2,'IT0001','test@gmail.com','0331278291','public/images/img_2024-11-26-21-06.png','Nam','2024-11-03','Tầng 2 tòa Handico','DH','11212','211212','43434',454545),(12,1,'MKK3','','','','Nam','2024-11-26','','','','','',0);
/*!40000 ALTER TABLE `NhanVien` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `PhongBan`
--

DROP TABLE IF EXISTS `PhongBan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `PhongBan` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `tenPB` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `soDT` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `diaChi` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `PhongBan`
--

LOCK TABLES `PhongBan` WRITE;
/*!40000 ALTER TABLE `PhongBan` DISABLE KEYS */;
INSERT INTO `PhongBan` VALUES (1,'Phòng IT','0350001111','Đà Nãng'),(2,'Phòng MKT','0350001112','Sài Gòn'),(3,'Phòng truyền thông','033127829','Tầng 2 tòa Handico'),(10,'Phòng Hành chính - Nhân sự','0331278291','Tầng 2 tòa Handico');
/*!40000 ALTER TABLE `PhongBan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `QTCongTac`
--

DROP TABLE IF EXISTS `QTCongTac`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `QTCongTac` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `maNV` int unsigned NOT NULL,
  `maPB` int unsigned NOT NULL,
  `ngayDenCT` date DEFAULT NULL,
  `ngayChuyenCT` date DEFAULT NULL,
  `moTaCongViec` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_QTCongTac_2` (`maPB`),
  KEY `fk_QTCongTac_1_idx` (`maNV`),
  CONSTRAINT `fk_QTCongTac_1` FOREIGN KEY (`maNV`) REFERENCES `NhanVien` (`id`),
  CONSTRAINT `fk_QTCongTac_2` FOREIGN KEY (`maPB`) REFERENCES `PhongBan` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `QTCongTac`
--

LOCK TABLES `QTCongTac` WRITE;
/*!40000 ALTER TABLE `QTCongTac` DISABLE KEYS */;
INSERT INTO `QTCongTac` VALUES (8,8,2,'2024-11-21','2024-11-20','Trợ lý giám đốc 2'),(9,11,3,'2024-10-29','2024-10-31','Trợ lý giám đốc'),(10,11,10,'2024-11-01','2024-11-30','Tổng giám đốc'),(11,10,1,'2024-11-30','2024-11-30','Phó giám đốc');
/*!40000 ALTER TABLE `QTCongTac` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `TaiKhoan`
--

DROP TABLE IF EXISTS `TaiKhoan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `TaiKhoan` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `maNV` int unsigned DEFAULT NULL,
  `tenDN` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `matKhau` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `loaiTK` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL DEFAULT 'NHANVIEN',
  PRIMARY KEY (`id`),
  UNIQUE KEY `maNV_UNIQUE` (`maNV`),
  KEY `taikhoan_manv_foreign` (`maNV`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `TaiKhoan`
--

LOCK TABLES `TaiKhoan` WRITE;
/*!40000 ALTER TABLE `TaiKhoan` DISABLE KEYS */;
INSERT INTO `TaiKhoan` VALUES (14,NULL,'admin','$2y$10$sIJxmkngkTvDAK3436iIX.wYQMsi0HorM.eGFSTkzpskQOzx0sVaK','ADMIN'),(18,8,'MKK','$2y$10$xsOJKjd2w4Yl/VLnOwIzl.GDGyGKxeujrt6WlfdhBnN1JOQ0H.abG','NHANVIEN'),(19,9,'MKK4','$2y$10$xsOJKjd2w4Yl/VLnOwIzl.GDGyGKxeujrt6WlfdhBnN1JOQ0H.abG','NHANVIEN'),(20,10,'MKK2','$2y$10$xsOJKjd2w4Yl/VLnOwIzl.GDGyGKxeujrt6WlfdhBnN1JOQ0H.abG','NHANVIEN'),(21,11,'IT0001','$2y$10$xsOJKjd2w4Yl/VLnOwIzl.GDGyGKxeujrt6WlfdhBnN1JOQ0H.abG','NHANVIEN'),(22,12,'MKK3','$2y$10$sIJxmkngkTvDAK3436iIX.wYQMsi0HorM.eGFSTkzpskQOzx0sVaK','NHANVIEN');
/*!40000 ALTER TABLE `TaiKhoan` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-11-26 23:40:56
