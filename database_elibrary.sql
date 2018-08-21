/*
SQLyog Ultimate v12.4.1 (64 bit)
MySQL - 8.0.11 : Database - uas_web
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`uas_web` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */;

USE `uas_web`;

/*Table structure for table `m_anggota` */

DROP TABLE IF EXISTS `m_anggota`;

CREATE TABLE `m_anggota` (
  `anggota_id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_anggota` varchar(15) DEFAULT NULL,
  `nama_anggota` varchar(150) DEFAULT NULL,
  `jenis_kelamin_anggota` char(1) DEFAULT NULL,
  `tempat_lahir_anggota` varchar(150) DEFAULT NULL,
  `tanggal_lahir_anggota` date DEFAULT NULL,
  `alamat_anggota` varchar(255) DEFAULT NULL,
  `email_anggota` varchar(150) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL COMMENT 'pengajuan/anggota',
  `tgl_menjadi_anggota` date DEFAULT NULL,
  PRIMARY KEY (`anggota_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `m_anggota` */

insert  into `m_anggota`(`anggota_id`,`kode_anggota`,`nama_anggota`,`jenis_kelamin_anggota`,`tempat_lahir_anggota`,`tanggal_lahir_anggota`,`alamat_anggota`,`email_anggota`,`status`,`tgl_menjadi_anggota`) values 
(1,'001','Defri Sucahyono','l','Denpasar','2018-07-02','Jalan kaki','-','member','2018-07-02'),
(2,'AGT00002','Putu Angga Suta Dharmawan','l','Gianyar','2018-02-25','-','-','','2018-07-03'),
(3,'AGT00005','Bang Satriyo','l','Jember','2018-06-24','Jalan Kaki','-',NULL,'2018-07-03'),
(4,'AGT00003','j','l','iu','2018-07-03','klk','ty',NULL,'2018-07-03'),
(5,'AGT00006','Riska Purnama','p','denpasar','1997-05-22','puputan baru','@gmail',NULL,'2018-07-03');

/*Table structure for table `m_buku` */

DROP TABLE IF EXISTS `m_buku`;

CREATE TABLE `m_buku` (
  `buku_id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_buku` varchar(64) NOT NULL,
  `nama_buku` varchar(100) NOT NULL,
  `barcode` varchar(64) DEFAULT NULL,
  `isbn` varchar(64) DEFAULT NULL,
  `kategori_buku_id` int(11) DEFAULT NULL,
  `url_ebook` varchar(255) DEFAULT '',
  `nama_rak` varchar(50) DEFAULT '',
  `stok_buku` int(10) DEFAULT '0',
  PRIMARY KEY (`buku_id`),
  UNIQUE KEY `kode_buku` (`kode_buku`),
  KEY `FK_KATEGORI_BUKU` (`kategori_buku_id`),
  CONSTRAINT `FK_KATEGORI_BUKU` FOREIGN KEY (`kategori_buku_id`) REFERENCES `m_kategori_buku` (`kategori_buku_id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=140 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `m_buku` */

insert  into `m_buku`(`buku_id`,`kode_buku`,`nama_buku`,`barcode`,`isbn`,`kategori_buku_id`,`url_ebook`,`nama_rak`,`stok_buku`) values 
(129,'BK00001','Buku Belajar IPS','098934792878','286474623',2,'129_Buku_Belajar_IPS.pdf','001',18),
(130,'BK00002','Buku Belajar IPA','099999','098-9897-87-98797-877',1,'','',11),
(131,'BK00003','Buku Coba Coba ajah','1111111','111-1-11-1-1111',2,'131_Buku_Coba_Coba_ajah.pdf','0009',22),
(132,'BK00004','Buku Ada ada fgdgfgdfgdfg','22222','22-2-2-2-222',1,'','',0),
(136,'BK00005','Buku Tulis Ala Kadar','9879877','8767-2-423432-43',2,'','',0),
(139,'BK00006','jhsgdhsgdfhj','hgjhgjh','jhg',2,'','jhg',19);

/*Table structure for table `m_buku_detail` */

DROP TABLE IF EXISTS `m_buku_detail`;

CREATE TABLE `m_buku_detail` (
  `buku_detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `buku_id` int(11) DEFAULT '0',
  `kode_detail` varchar(15) DEFAULT NULL,
  `rak_buku_id` int(11) DEFAULT '0',
  `kondisi` varchar(25) DEFAULT NULL,
  `status_pinjam` int(1) DEFAULT NULL COMMENT '1 terpinjam, 0 tidak',
  PRIMARY KEY (`buku_detail_id`),
  KEY `FK_BUKU_DETAIL` (`buku_id`),
  CONSTRAINT `FK_BUKU_DETAIL` FOREIGN KEY (`buku_id`) REFERENCES `m_buku` (`buku_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `m_buku_detail` */

/*Table structure for table `m_kategori_buku` */

DROP TABLE IF EXISTS `m_kategori_buku`;

CREATE TABLE `m_kategori_buku` (
  `kategori_buku_id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`kategori_buku_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `m_kategori_buku` */

insert  into `m_kategori_buku`(`kategori_buku_id`,`nama_kategori`) values 
(1,'Ilmu Pengetahuan'),
(2,'Buku Majalah dan Hiburan edited');

/*Table structure for table `m_penerbit` */

DROP TABLE IF EXISTS `m_penerbit`;

CREATE TABLE `m_penerbit` (
  `penerbit_id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_penerbit` varchar(150) DEFAULT NULL,
  `alamat_penerbit` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`penerbit_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `m_penerbit` */

insert  into `m_penerbit`(`penerbit_id`,`nama_penerbit`,`alamat_penerbit`) values 
(6,'PT Penerbit A','Jalan Raya Penerbit A'),
(9,'sdfsdf','sdfsdfsdfds'),
(10,'Bang Satrio','Denpasar'),
(11,'siapa','kuta');

/*Table structure for table `m_pengguna` */

DROP TABLE IF EXISTS `m_pengguna`;

CREATE TABLE `m_pengguna` (
  `pengguna_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `kode_pengguna` varchar(64) DEFAULT NULL,
  `hak_akses` varchar(100) DEFAULT NULL,
  `anggota_id` int(11) DEFAULT NULL,
  `tanggal_terdaftar` date DEFAULT NULL,
  `aktif` int(1) DEFAULT NULL,
  PRIMARY KEY (`pengguna_id`),
  KEY `username` (`username`),
  KEY `pass` (`password`),
  KEY `hak_akses` (`hak_akses`),
  KEY `FK_ANGGOTA` (`anggota_id`),
  CONSTRAINT `FK_ANGGOTA` FOREIGN KEY (`anggota_id`) REFERENCES `m_anggota` (`anggota_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `m_pengguna` */

insert  into `m_pengguna`(`pengguna_id`,`username`,`password`,`nama_lengkap`,`kode_pengguna`,`hak_akses`,`anggota_id`,`tanggal_terdaftar`,`aktif`) values 
(1,'admin','21232f297a57a5a743894a0e4a801fc3','Administrator','300518001','admin',NULL,'2018-01-01',1),
(2,'Anu','827ccb0eea8a706c4c34a16891f84e7b',NULL,NULL,'user',NULL,NULL,1),
(3,'userx','202cb962ac59075b964b07152d234b70',NULL,NULL,'user',NULL,NULL,1),
(4,'asdasd','922ec9531b1f94add983a8ce2ebdc97b',NULL,NULL,'user',NULL,NULL,1),
(5,'dasdas','3cafd8d9ffd2563374cc9363e12a1c0c',NULL,NULL,'user',NULL,NULL,1),
(6,'jhgj','d7bc3c1c6285d1b988bd8ddfc55f75bc',NULL,NULL,'user',NULL,NULL,1),
(7,'mbsbdbsj','c3f9718b96292c49a36a8c04266c2427',NULL,NULL,'user',NULL,NULL,1),
(8,'mbmnbmnb','649e5cd36e47ec3ba608d29cc1b3b6cc',NULL,NULL,'user',NULL,NULL,1),
(13,'user','ee11cbb19052e40b07aac0ca060c23ee',NULL,NULL,'user',NULL,NULL,1);

/*Table structure for table `m_penulis` */

DROP TABLE IF EXISTS `m_penulis`;

CREATE TABLE `m_penulis` (
  `penulis_id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_penulis` varchar(150) DEFAULT NULL,
  `jenis_kelamin` char(1) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  PRIMARY KEY (`penulis_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `m_penulis` */

insert  into `m_penulis`(`penulis_id`,`nama_penulis`,`jenis_kelamin`,`alamat`,`tanggal_lahir`) values 
(15,'Defri Sucahyono,S.Kom','l','Jalan Raya Kuta ','2018-06-26'),
(17,'testing','l','asdasdasd','2018-06-30'),
(19,'purno','p','ikip','2018-07-03');

/*Table structure for table `r_menerbitkan` */

DROP TABLE IF EXISTS `r_menerbitkan`;

CREATE TABLE `r_menerbitkan` (
  `menerbitkan_id` int(11) NOT NULL AUTO_INCREMENT,
  `buku_id` int(11) NOT NULL,
  `penerbit_id` int(11) NOT NULL,
  `tahun_terbit` year(4) NOT NULL,
  PRIMARY KEY (`menerbitkan_id`),
  UNIQUE KEY `ccccc` (`buku_id`,`penerbit_id`,`tahun_terbit`),
  KEY `menerbitkan_id` (`menerbitkan_id`),
  KEY `yy` (`penerbit_id`),
  CONSTRAINT `FK_MENERBITKAN_BUKU` FOREIGN KEY (`buku_id`) REFERENCES `m_buku` (`buku_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_MENERBITKAN_PENERBIT` FOREIGN KEY (`penerbit_id`) REFERENCES `m_penerbit` (`penerbit_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `xx` FOREIGN KEY (`buku_id`) REFERENCES `m_buku` (`buku_id`),
  CONSTRAINT `yy` FOREIGN KEY (`penerbit_id`) REFERENCES `m_penerbit` (`penerbit_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `r_menerbitkan` */

insert  into `r_menerbitkan`(`menerbitkan_id`,`buku_id`,`penerbit_id`,`tahun_terbit`) values 
(1,129,6,2018),
(2,129,9,2018);

/*Table structure for table `r_menulis` */

DROP TABLE IF EXISTS `r_menulis`;

CREATE TABLE `r_menulis` (
  `menulis_id` int(11) NOT NULL AUTO_INCREMENT,
  `penulis_id` int(11) DEFAULT NULL,
  `buku_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`menulis_id`),
  UNIQUE KEY `xx` (`penulis_id`,`buku_id`),
  KEY `fk_bukuMenulis` (`buku_id`),
  KEY `uniik` (`penulis_id`),
  CONSTRAINT `fk_bukuMenulis` FOREIGN KEY (`buku_id`) REFERENCES `m_buku` (`buku_id`),
  CONSTRAINT `fk_penulsimenulis` FOREIGN KEY (`penulis_id`) REFERENCES `m_penulis` (`penulis_id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `r_menulis` */

insert  into `r_menulis`(`menulis_id`,`penulis_id`,`buku_id`) values 
(12,15,129),
(21,15,130),
(17,17,129),
(20,17,130),
(11,17,136),
(25,19,129);

/*Table structure for table `t_peminjaman` */

DROP TABLE IF EXISTS `t_peminjaman`;

CREATE TABLE `t_peminjaman` (
  `peminjaman_id` int(11) NOT NULL AUTO_INCREMENT,
  `tanggal_pinjam` date DEFAULT NULL,
  `anggota_id` int(11) DEFAULT '0',
  `buku_id` int(11) DEFAULT '0',
  `lama_pinjam` int(4) DEFAULT '0',
  `tanggal_kembali` date DEFAULT NULL,
  `denda` double(22,2) DEFAULT '0.00',
  `pinjam_pengguna_id` int(11) DEFAULT NULL,
  `kembali_pengguna_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`peminjaman_id`),
  KEY `FK_P_ANGGOTA` (`anggota_id`),
  KEY `FK_P_PENGGUNA` (`pinjam_pengguna_id`),
  KEY `FK_BUKU` (`buku_id`),
  CONSTRAINT `FK_BUKU` FOREIGN KEY (`buku_id`) REFERENCES `m_buku` (`buku_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_P_ANGGOTA` FOREIGN KEY (`anggota_id`) REFERENCES `m_anggota` (`anggota_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_P_PENGGUNA` FOREIGN KEY (`pinjam_pengguna_id`) REFERENCES `m_pengguna` (`pengguna_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `t_peminjaman` */

insert  into `t_peminjaman`(`peminjaman_id`,`tanggal_pinjam`,`anggota_id`,`buku_id`,`lama_pinjam`,`tanggal_kembali`,`denda`,`pinjam_pengguna_id`,`kembali_pengguna_id`) values 
(26,'2018-07-02',1,129,7,'2018-07-02',0.00,1,1),
(27,'2018-07-02',1,129,7,'2018-07-02',0.00,1,1),
(28,'2018-07-02',1,129,7,'2018-08-03',37500.00,1,1),
(29,'2018-07-03',1,129,7,'2018-07-31',31500.00,1,1),
(30,'2018-07-03',1,130,7,'2018-07-03',0.00,1,1),
(31,'2018-07-03',5,129,7,'2018-07-03',0.00,1,1),
(32,'2018-07-03',1,129,7,'2018-07-03',0.00,1,1),
(33,'2018-07-03',1,129,7,'2018-07-03',0.00,1,1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
