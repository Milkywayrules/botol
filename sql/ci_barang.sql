/*
 Navicat Premium Data Transfer

 Source Server         : LOCAL (No PASSWORD)
 Source Server Type    : MySQL
 Source Server Version : 100138
 Source Host           : localhost:3306
 Source Schema         : ci_barang

 Target Server Type    : MySQL
 Target Server Version : 100138
 File Encoding         : 65001

 Date: 06/11/2020 14:00:33
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for barang
-- ----------------------------
DROP TABLE IF EXISTS `barang`;
CREATE TABLE `barang`  (
  `id_barang` char(7) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `nama_barang` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `stok` int(11) NOT NULL,
  `satuan_id` int(11) NOT NULL,
  `jenis_id` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  PRIMARY KEY (`id_barang`) USING BTREE,
  INDEX `satuan_id`(`satuan_id`) USING BTREE,
  INDEX `kategori_id`(`jenis_id`) USING BTREE,
  CONSTRAINT `barang_ibfk_1` FOREIGN KEY (`satuan_id`) REFERENCES `satuan` (`id_satuan`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `barang_ibfk_2` FOREIGN KEY (`jenis_id`) REFERENCES `jenis` (`id_jenis`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of barang
-- ----------------------------
INSERT INTO `barang` VALUES ('B000000', 'Botol 400ml', 50, 5, 9, 1000);
INSERT INTO `barang` VALUES ('B000001', 'Botol 1000ml', 0, 5, 9, 2500);
INSERT INTO `barang` VALUES ('B000002', 'Tupperware', 40, 3, 9, 50000);
INSERT INTO `barang` VALUES ('B000003', 'Face Wash', 75, 2, 8, 6800);
INSERT INTO `barang` VALUES ('B000004', 'Jam Tangan', 50, 5, 8, 500000);

-- ----------------------------
-- Table structure for barang_keluar
-- ----------------------------
DROP TABLE IF EXISTS `barang_keluar`;
CREATE TABLE `barang_keluar`  (
  `id_barang_keluar` char(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `nama_penerima` char(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `alamat` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `tanggal_keluar` date NOT NULL,
  `diskon` double(11, 0) NULL DEFAULT 0,
  `total_nominal` int(11) NOT NULL,
  `grand_total` int(11) NOT NULL,
  PRIMARY KEY (`id_barang_keluar`) USING BTREE,
  INDEX `id_user`(`user_id`) USING BTREE,
  CONSTRAINT `barang_keluar_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of barang_keluar
-- ----------------------------
INSERT INTO `barang_keluar` VALUES ('T-BK-20110300001', 1, 'Ferrye', 'Bandung', '2020-11-03', 0, 5000000, 5000000);
INSERT INTO `barang_keluar` VALUES ('T-BK-20110300002', 1, 'Fadil', 'Tegalega', '2020-11-03', 0, 10400000, 10400000);
INSERT INTO `barang_keluar` VALUES ('T-BK-20110600000', 1, 'Garaga', 'Bandung', '2020-11-06', 0, 2568000, 2568000);
INSERT INTO `barang_keluar` VALUES ('T-BK-20110600001', 1, 'Tetty', 'Garut', '2020-11-06', 20, 2500000, 2000000);
INSERT INTO `barang_keluar` VALUES ('T-BK-20110600002', 1, 'Sultan', 'Pinggir Jalan', '2020-11-06', 15, 127000, 107950);

-- ----------------------------
-- Table structure for barang_keluar_copy1
-- ----------------------------
DROP TABLE IF EXISTS `barang_keluar_copy1`;
CREATE TABLE `barang_keluar_copy1`  (
  `id_barang_keluar` char(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `barang_id` char(7) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `nama_penerima` char(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `alamat` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `jumlah_keluar` int(11) NOT NULL,
  `tanggal_keluar` date NOT NULL,
  `total_nominal` int(11) NOT NULL,
  PRIMARY KEY (`id_barang_keluar`) USING BTREE,
  INDEX `id_user`(`user_id`) USING BTREE,
  INDEX `barang_id`(`barang_id`) USING BTREE,
  CONSTRAINT `barang_keluar_copy1_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `barang_keluar_copy1_ibfk_2` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of barang_keluar_copy1
-- ----------------------------
INSERT INTO `barang_keluar_copy1` VALUES ('T-BK-20093000000', 1, 'B000002', 'Ferry', 'Jl. Simatupang no.18, Medan', 10, '2020-09-30', 500000);
INSERT INTO `barang_keluar_copy1` VALUES ('T-BK-20093000001', 1, 'B000000', 'Sule', 'Jl. Soekarno Hatta No.199', 25, '2020-09-30', 25000);
INSERT INTO `barang_keluar_copy1` VALUES ('T-BK-20110300000', 1, 'B000004', 'Asep', 'Bandung', 10, '2020-11-03', 5000000);

-- ----------------------------
-- Table structure for barang_keluar_dtl
-- ----------------------------
DROP TABLE IF EXISTS `barang_keluar_dtl`;
CREATE TABLE `barang_keluar_dtl`  (
  `id_detail` int(11) NOT NULL AUTO_INCREMENT,
  `id_barang_keluar` char(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `barang_id` char(7) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `harga` int(11) NOT NULL,
  `jumlah_keluar` int(1) NOT NULL,
  `total_nominal_dtl` int(1) NOT NULL,
  PRIMARY KEY (`id_detail`) USING BTREE,
  INDEX `barang_keluar_dtl_ibfk_1`(`id_barang_keluar`) USING BTREE,
  CONSTRAINT `barang_keluar_dtl_ibfk_1` FOREIGN KEY (`id_barang_keluar`) REFERENCES `barang_keluar` (`id_barang_keluar`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of barang_keluar_dtl
-- ----------------------------
INSERT INTO `barang_keluar_dtl` VALUES (1, 'T-BK-20110300001', 'B000004', 500000, 10, 5000000);
INSERT INTO `barang_keluar_dtl` VALUES (2, 'T-BK-20110300002', 'B000004', 500000, 20, 10000000);
INSERT INTO `barang_keluar_dtl` VALUES (3, 'T-BK-20110300002', 'B000002', 50000, 8, 400000);
INSERT INTO `barang_keluar_dtl` VALUES (12, 'T-BK-20110600000', 'B000004', 500000, 5, 2500000);
INSERT INTO `barang_keluar_dtl` VALUES (13, 'T-BK-20110600000', 'B000003', 6800, 10, 68000);
INSERT INTO `barang_keluar_dtl` VALUES (14, 'T-BK-20110600001', 'B000004', 500000, 5, 2500000);
INSERT INTO `barang_keluar_dtl` VALUES (15, 'T-BK-20110600002', 'B000000', 1000, 25, 25000);
INSERT INTO `barang_keluar_dtl` VALUES (16, 'T-BK-20110600002', 'B000003', 6800, 15, 102000);

-- ----------------------------
-- Table structure for barang_masuk
-- ----------------------------
DROP TABLE IF EXISTS `barang_masuk`;
CREATE TABLE `barang_masuk`  (
  `id_barang_masuk` char(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `barang_id` char(7) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `jumlah_masuk` int(11) NOT NULL,
  `tanggal_masuk` date NOT NULL,
  PRIMARY KEY (`id_barang_masuk`) USING BTREE,
  INDEX `id_user`(`user_id`) USING BTREE,
  INDEX `supplier_id`(`supplier_id`) USING BTREE,
  INDEX `barang_id`(`barang_id`) USING BTREE,
  CONSTRAINT `barang_masuk_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `barang_masuk_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`id_supplier`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `barang_masuk_ibfk_3` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of barang_masuk
-- ----------------------------
INSERT INTO `barang_masuk` VALUES ('T-BM-20092000000', 4, 1, 'B000000', 100, '2020-09-20');
INSERT INTO `barang_masuk` VALUES ('T-BM-20093000000', 4, 1, 'B000002', 6, '2020-09-30');
INSERT INTO `barang_masuk` VALUES ('T-BM-20093000001', 4, 1, 'B000002', 6, '2020-09-30');
INSERT INTO `barang_masuk` VALUES ('T-BM-20093000002', 4, 1, 'B000002', 5, '2020-09-30');
INSERT INTO `barang_masuk` VALUES ('T-BM-20093000003', 4, 1, 'B000002', 6, '2020-09-30');
INSERT INTO `barang_masuk` VALUES ('T-BM-20093000004', 4, 1, 'B000002', 5, '2020-09-30');
INSERT INTO `barang_masuk` VALUES ('T-BM-20101100000', 4, 1, 'B000003', 90, '2020-10-11');
INSERT INTO `barang_masuk` VALUES ('T-BM-20110300000', 4, 1, 'B000004', 100, '2020-11-03');
INSERT INTO `barang_masuk` VALUES ('T-BM-20110300001', 4, 1, 'B000003', 100, '2020-11-03');

-- ----------------------------
-- Table structure for jenis
-- ----------------------------
DROP TABLE IF EXISTS `jenis`;
CREATE TABLE `jenis`  (
  `id_jenis` int(11) NOT NULL AUTO_INCREMENT,
  `nama_jenis` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id_jenis`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of jenis
-- ----------------------------
INSERT INTO `jenis` VALUES (8, 'Plastik');
INSERT INTO `jenis` VALUES (9, 'Botol');

-- ----------------------------
-- Table structure for satuan
-- ----------------------------
DROP TABLE IF EXISTS `satuan`;
CREATE TABLE `satuan`  (
  `id_satuan` int(11) NOT NULL AUTO_INCREMENT,
  `nama_satuan` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id_satuan`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of satuan
-- ----------------------------
INSERT INTO `satuan` VALUES (2, 'Pack');
INSERT INTO `satuan` VALUES (3, 'Botol');
INSERT INTO `satuan` VALUES (5, 'Unit');

-- ----------------------------
-- Table structure for supplier
-- ----------------------------
DROP TABLE IF EXISTS `supplier`;
CREATE TABLE `supplier`  (
  `id_supplier` int(11) NOT NULL AUTO_INCREMENT,
  `nama_supplier` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `no_telp` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `alamat` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id_supplier`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of supplier
-- ----------------------------
INSERT INTO `supplier` VALUES (4, 'Dimas Botol', '0891234567', 'Kabupaten Garut');

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`  (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `no_telp` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `role` enum('gudang','admin') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `created_at` int(11) NOT NULL,
  `foto` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_user`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 14 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES (1, 'Adminisitrator', 'admin', 'admin@admin.com', '025123456789', 'admin', '$2y$10$wMgi9s3FEDEPEU6dEmbp8eAAEBUXIXUy3np3ND2Oih.MOY.q/Kpoy', 1568689561, 'd5f22535b639d55be7d099a7315e1f7f.png', 1);
INSERT INTO `user` VALUES (7, 'Arfan ID', 'arfandotid', 'arfandotid@gmail.com', '081221528805', 'gudang', '$2y$10$5es8WhFQj8xCmrhDtH86Fu71j97og9f8aR4T22soa7716kAusmaeK', 1568691611, 'user.png', 1);
INSERT INTO `user` VALUES (8, 'Muhammad Ghifari Arfananda', 'mghifariarfan', 'mghifariarfan@gmail.com', '085697442673', 'gudang', '$2y$10$5SGUIbRyEXH7JslhtEegEOpp6cvxtK6X.qdiQ1eZR7nd0RZjjx3qe', 1568691629, 'user.png', 1);
INSERT INTO `user` VALUES (13, 'Arfan Kashilukato', 'arfankashilukato', 'arfankashilukato@gmail.com', '081623123181', 'gudang', '$2y$10$/QpTunAD9alBV5NSRJ7ytupS2ibUrbmS3ia3u5B26H6f3mCjOD92W', 1569192547, 'user.png', 1);

-- ----------------------------
-- Triggers structure for table barang_keluar_copy1
-- ----------------------------
DROP TRIGGER IF EXISTS `update_stok_keluar_copy1`;
delimiter ;;
CREATE TRIGGER `update_stok_keluar_copy1` BEFORE INSERT ON `barang_keluar_copy1` FOR EACH ROW UPDATE `barang` SET `barang`.`stok` = `barang`.`stok` - NEW.jumlah_keluar WHERE `barang`.`id_barang` = NEW.barang_id
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table barang_keluar_dtl
-- ----------------------------
DROP TRIGGER IF EXISTS `update_stok_keluar`;
delimiter ;;
CREATE TRIGGER `update_stok_keluar` BEFORE INSERT ON `barang_keluar_dtl` FOR EACH ROW UPDATE `barang` SET `barang`.`stok` = `barang`.`stok` - NEW.jumlah_keluar WHERE `barang`.`id_barang` = NEW.barang_id
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table barang_keluar_dtl
-- ----------------------------
DROP TRIGGER IF EXISTS `delete_stok_keluar`;
delimiter ;;
CREATE TRIGGER `delete_stok_keluar` AFTER DELETE ON `barang_keluar_dtl` FOR EACH ROW UPDATE `barang` SET `barang`.`stok` = `barang`.`stok` + OLD.jumlah_keluar WHERE `barang`.`id_barang` = OLD.barang_id
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table barang_masuk
-- ----------------------------
DROP TRIGGER IF EXISTS `update_stok_masuk`;
delimiter ;;
CREATE TRIGGER `update_stok_masuk` BEFORE INSERT ON `barang_masuk` FOR EACH ROW UPDATE `barang` SET `barang`.`stok` = `barang`.`stok` + NEW.jumlah_masuk WHERE `barang`.`id_barang` = NEW.barang_id
;
;;
delimiter ;

SET FOREIGN_KEY_CHECKS = 1;
