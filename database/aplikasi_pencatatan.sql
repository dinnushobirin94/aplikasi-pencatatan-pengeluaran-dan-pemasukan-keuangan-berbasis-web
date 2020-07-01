/*
SQLyog Ultimate v12.5.1 (64 bit)
MySQL - 10.1.13-MariaDB : Database - aplikasi_pencatatan
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `core_user` */

DROP TABLE IF EXISTS `core_user`;

CREATE TABLE `core_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(250) DEFAULT NULL,
  `username` varchar(250) DEFAULT NULL,
  `password` varchar(250) DEFAULT NULL,
  `nama_panjang` varchar(250) DEFAULT NULL,
  `email` varchar(250) DEFAULT NULL,
  `deskripsi` text,
  `insert_id` int(11) DEFAULT NULL,
  `insert_time` datetime DEFAULT NULL,
  `update_id` int(11) DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `core_user` */

insert  into `core_user`(`id`,`nama`,`username`,`password`,`nama_panjang`,`email`,`deskripsi`,`insert_id`,`insert_time`,`update_id`,`update_time`) values 
(1,'dinnu','dinnu','21232f297a57a5a743894a0e4a801fc3','Dinnu Prasetyo Shobirin','dinnushborin94@gmail.com','Admin Dinnu',1,'2020-07-01 13:55:41',NULL,NULL);

/*Table structure for table `ref_kategori` */

DROP TABLE IF EXISTS `ref_kategori`;

CREATE TABLE `ref_kategori` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) DEFAULT NULL,
  `deskripsi` text,
  `is_pengurangan` smallint(1) DEFAULT '0',
  `insert_id` int(11) DEFAULT NULL,
  `insert_time` datetime DEFAULT NULL,
  `update_id` int(11) DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

/*Data for the table `ref_kategori` */

insert  into `ref_kategori`(`id`,`nama`,`deskripsi`,`is_pengurangan`,`insert_id`,`insert_time`,`update_id`,`update_time`) values 
(1,'Gaji','Gajian',0,1,'2020-07-01 13:30:49',NULL,NULL),
(2,'Tunjangan','Tunjangan',0,1,'2020-07-01 13:30:54',NULL,NULL),
(3,'Bonus','Bonusan',0,1,'2020-07-01 13:31:01',NULL,NULL),
(4,'Sewa Kost','Bayar Kos',1,1,'2020-07-01 13:31:05',NULL,NULL),
(5,'Makan','Makan & Minum',1,1,'2020-07-01 13:31:09',NULL,NULL),
(6,'Pakaian','Baju Baru',1,1,'2020-07-01 13:31:14',NULL,NULL),
(7,'Nonton Bioskop','nonton dong',1,1,'2020-07-01 13:31:18',NULL,NULL);

/*Table structure for table `trx_dompet` */

DROP TABLE IF EXISTS `trx_dompet`;

CREATE TABLE `trx_dompet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_last_traksaksi` int(11) DEFAULT NULL,
  `is_last_pengurangan` smallint(1) DEFAULT NULL,
  `saldo` decimal(10,0) DEFAULT NULL,
  `saldo_sebelum` decimal(10,0) DEFAULT NULL,
  `total_pengeluaran` decimal(10,0) DEFAULT NULL,
  `total_pemasukan` decimal(10,0) DEFAULT NULL,
  `insert_id` int(11) DEFAULT NULL,
  `insert_time` datetime DEFAULT NULL,
  `update_id` int(11) DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `trx_dompet` */

insert  into `trx_dompet`(`id`,`id_last_traksaksi`,`is_last_pengurangan`,`saldo`,`saldo_sebelum`,`total_pengeluaran`,`total_pemasukan`,`insert_id`,`insert_time`,`update_id`,`update_time`) values 
(1,5,1,-3000,-1203233,12000,9000,1,'2020-07-01 16:59:52',1,'2020-07-01 13:53:09');

/*Table structure for table `trx_transaksi` */

DROP TABLE IF EXISTS `trx_transaksi`;

CREATE TABLE `trx_transaksi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_kategori` int(11) DEFAULT NULL,
  `is_pengurangan` smallint(1) DEFAULT '0',
  `nama` varchar(255) DEFAULT NULL,
  `nominal` decimal(10,0) DEFAULT NULL,
  `deskripsi` text,
  `insert_id` int(11) DEFAULT NULL,
  `insert_time` datetime DEFAULT NULL,
  `update_id` int(11) DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_kategori` (`id_kategori`),
  CONSTRAINT `trx_transaksi_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `ref_kategori` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `trx_transaksi` */

insert  into `trx_transaksi`(`id`,`id_kategori`,`is_pengurangan`,`nama`,`nominal`,`deskripsi`,`insert_id`,`insert_time`,`update_id`,`update_time`) values 
(1,1,0,'Awal',5000,'saldo',1,'2020-07-01 17:01:29',NULL,NULL),
(5,2,1,'Tunjangan',12000,'Tunjangan',1,'2020-07-01 13:12:21',1,'2020-07-01 13:53:09'),
(7,2,0,'Tunjangan',4000,'sas',1,'2020-07-01 13:52:40',NULL,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
