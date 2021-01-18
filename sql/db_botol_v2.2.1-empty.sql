-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 18, 2021 at 10:56 AM
-- Server version: 10.1.29-MariaDB
-- PHP Version: 7.2.0

--
-- Author: @Galaxx.dev - @dioilham.com
--
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_botol`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--
-- Creation: Dec 20, 2020 at 06:18 AM
--

DROP TABLE IF EXISTS `barang`;
CREATE TABLE `barang` (
  `id_barang` char(7) NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `stok` double NOT NULL,
  `satuan_id` int(11) NOT NULL,
  `jenis_id` int(11) NOT NULL,
  `harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- RELATIONSHIPS FOR TABLE `barang`:
--   `satuan_id`
--       `satuan` -> `id_satuan`
--   `jenis_id`
--       `jenis` -> `id_jenis`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang_keluar`
--
-- Creation: Jan 18, 2021 at 08:00 AM
--

DROP TABLE IF EXISTS `barang_keluar`;
CREATE TABLE `barang_keluar` (
  `id_barang_keluar` char(16) NOT NULL,
  `user_id` int(11) NOT NULL,
  `id_customer` int(11) NOT NULL,
  `nama_penerima` char(50) NOT NULL,
  `alamat` text NOT NULL,
  `tanggal_keluar` date NOT NULL,
  `total_nominal` int(11) NOT NULL,
  `diskon` double(11,0) DEFAULT '0',
  `grand_total` int(11) NOT NULL,
  `payment` enum('kontrabon','transfer','cash') NOT NULL,
  `paid_amount` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- RELATIONSHIPS FOR TABLE `barang_keluar`:
--   `user_id`
--       `user` -> `id_user`
--   `id_customer`
--       `customer` -> `id`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang_keluar_copy1`
--
-- Creation: Dec 20, 2020 at 06:18 AM
--

DROP TABLE IF EXISTS `barang_keluar_copy1`;
CREATE TABLE `barang_keluar_copy1` (
  `id_barang_keluar` char(16) NOT NULL,
  `user_id` int(11) NOT NULL,
  `barang_id` char(7) NOT NULL,
  `nama_penerima` char(50) NOT NULL,
  `alamat` text NOT NULL,
  `jumlah_keluar` double NOT NULL,
  `tanggal_keluar` date NOT NULL,
  `total_nominal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- RELATIONSHIPS FOR TABLE `barang_keluar_copy1`:
--   `user_id`
--       `user` -> `id_user`
--   `barang_id`
--       `barang` -> `id_barang`
--

--
-- Triggers `barang_keluar_copy1`
--
DROP TRIGGER IF EXISTS `update_stok_keluar_copy1`;
DELIMITER $$
CREATE TRIGGER `update_stok_keluar_copy1` BEFORE INSERT ON `barang_keluar_copy1` FOR EACH ROW UPDATE `barang` SET `barang`.`stok` = `barang`.`stok` - NEW.jumlah_keluar WHERE `barang`.`id_barang` = NEW.barang_id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `barang_keluar_dtl`
--
-- Creation: Dec 20, 2020 at 06:18 AM
--

DROP TABLE IF EXISTS `barang_keluar_dtl`;
CREATE TABLE `barang_keluar_dtl` (
  `id_detail` int(11) NOT NULL,
  `id_barang_keluar` char(16) NOT NULL,
  `barang_id` char(7) NOT NULL,
  `harga` int(11) NOT NULL,
  `jumlah_keluar` double NOT NULL,
  `total_nominal_dtl` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- RELATIONSHIPS FOR TABLE `barang_keluar_dtl`:
--   `id_barang_keluar`
--       `barang_keluar` -> `id_barang_keluar`
--

--
-- Triggers `barang_keluar_dtl`
--
DROP TRIGGER IF EXISTS `delete_stok_keluar`;
DELIMITER $$
CREATE TRIGGER `delete_stok_keluar` AFTER DELETE ON `barang_keluar_dtl` FOR EACH ROW UPDATE `barang` SET `barang`.`stok` = `barang`.`stok` + OLD.jumlah_keluar WHERE `barang`.`id_barang` = OLD.barang_id
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `update_stok_keluar`;
DELIMITER $$
CREATE TRIGGER `update_stok_keluar` BEFORE INSERT ON `barang_keluar_dtl` FOR EACH ROW UPDATE `barang` SET `barang`.`stok` = `barang`.`stok` - NEW.jumlah_keluar WHERE `barang`.`id_barang` = NEW.barang_id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `barang_masuk`
--
-- Creation: Dec 20, 2020 at 06:18 AM
--

DROP TABLE IF EXISTS `barang_masuk`;
CREATE TABLE `barang_masuk` (
  `id_barang_masuk` char(16) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `barang_id` char(7) NOT NULL,
  `jumlah_masuk` double NOT NULL,
  `tanggal_masuk` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- RELATIONSHIPS FOR TABLE `barang_masuk`:
--   `user_id`
--       `user` -> `id_user`
--   `supplier_id`
--       `supplier` -> `id_supplier`
--   `barang_id`
--       `barang` -> `id_barang`
--

--
-- Triggers `barang_masuk`
--
DROP TRIGGER IF EXISTS `update_stok_masuk`;
DELIMITER $$
CREATE TRIGGER `update_stok_masuk` BEFORE INSERT ON `barang_masuk` FOR EACH ROW UPDATE `barang` SET `barang`.`stok` = `barang`.`stok` + NEW.jumlah_masuk WHERE `barang`.`id_barang` = NEW.barang_id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--
-- Creation: Jan 18, 2021 at 07:53 AM
--

DROP TABLE IF EXISTS `customer`;
CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `address` varchar(250) NOT NULL,
  `phone` varchar(16) NOT NULL,
  `total_utang` bigint(20) NOT NULL,
  `last_utang_paid` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `customer`:
--

-- --------------------------------------------------------

--
-- Table structure for table `jenis`
--
-- Creation: Jan 18, 2021 at 07:24 AM
--

DROP TABLE IF EXISTS `jenis`;
CREATE TABLE `jenis` (
  `id_jenis` int(11) NOT NULL,
  `nama_jenis` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- RELATIONSHIPS FOR TABLE `jenis`:
--

--
-- Truncate table before insert `jenis`
--

TRUNCATE TABLE `jenis`;
--
-- Dumping data for table `jenis`
--

INSERT INTO `jenis` (`id_jenis`, `nama_jenis`) VALUES
(1, 'Alat'),
(2, 'Makanan'),
(3, 'Minuman');

-- --------------------------------------------------------

--
-- Table structure for table `satuan`
--
-- Creation: Jan 18, 2021 at 07:24 AM
--

DROP TABLE IF EXISTS `satuan`;
CREATE TABLE `satuan` (
  `id_satuan` int(11) NOT NULL,
  `nama_satuan` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- RELATIONSHIPS FOR TABLE `satuan`:
--

--
-- Truncate table before insert `satuan`
--

TRUNCATE TABLE `satuan`;
--
-- Dumping data for table `satuan`
--

INSERT INTO `satuan` (`id_satuan`, `nama_satuan`) VALUES
(1, 'Pcs'),
(2, 'Botol'),
(3, 'Bungkus'),
(4, 'Porsi');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--
-- Creation: Jan 18, 2021 at 07:24 AM
--

DROP TABLE IF EXISTS `supplier`;
CREATE TABLE `supplier` (
  `id_supplier` int(11) NOT NULL,
  `nama_supplier` varchar(50) NOT NULL,
  `no_telp` varchar(15) NOT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- RELATIONSHIPS FOR TABLE `supplier`:
--

--
-- Truncate table before insert `supplier`
--

TRUNCATE TABLE `supplier`;
--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id_supplier`, `nama_supplier`, `no_telp`, `alamat`) VALUES
(5, 'PT Adi Makmur Santosa', '085314522528', 'Jl. Sukarno Hatta, Bandung'),
(6, 'PT Multi Bintang', '082121678861', 'Jl. Jendral Sudirman, Garut');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--
-- Creation: Jan 18, 2021 at 07:24 AM
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `no_telp` varchar(15) NOT NULL,
  `role` enum('gudang','admin') NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` int(11) NOT NULL,
  `foto` text NOT NULL,
  `is_active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- RELATIONSHIPS FOR TABLE `user`:
--

--
-- Truncate table before insert `user`
--

TRUNCATE TABLE `user`;
--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nama`, `username`, `email`, `no_telp`, `role`, `password`, `created_at`, `foto`, `is_active`) VALUES
(1, 'Adminisitrator', 'admin', 'admin@admin.com', '025123456789', 'admin', '$2y$10$Mh4022E8uLMx3KaXme7ofuiIZvGqAqmTsuu/NsjD8cFgRlpZR3FBa', 1568689561, 'd5f22535b639d55be7d099a7315e1f7f.png', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`) USING BTREE,
  ADD KEY `satuan_id` (`satuan_id`) USING BTREE,
  ADD KEY `kategori_id` (`jenis_id`) USING BTREE;

--
-- Indexes for table `barang_keluar`
--
ALTER TABLE `barang_keluar`
  ADD PRIMARY KEY (`id_barang_keluar`) USING BTREE,
  ADD KEY `id_user` (`user_id`) USING BTREE,
  ADD KEY `id_customer` (`id_customer`);

--
-- Indexes for table `barang_keluar_copy1`
--
ALTER TABLE `barang_keluar_copy1`
  ADD PRIMARY KEY (`id_barang_keluar`) USING BTREE,
  ADD KEY `id_user` (`user_id`) USING BTREE,
  ADD KEY `barang_id` (`barang_id`) USING BTREE;

--
-- Indexes for table `barang_keluar_dtl`
--
ALTER TABLE `barang_keluar_dtl`
  ADD PRIMARY KEY (`id_detail`) USING BTREE,
  ADD KEY `barang_keluar_dtl_ibfk_1` (`id_barang_keluar`) USING BTREE;

--
-- Indexes for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD PRIMARY KEY (`id_barang_masuk`) USING BTREE,
  ADD KEY `id_user` (`user_id`) USING BTREE,
  ADD KEY `supplier_id` (`supplier_id`) USING BTREE,
  ADD KEY `barang_id` (`barang_id`) USING BTREE;

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jenis`
--
ALTER TABLE `jenis`
  ADD PRIMARY KEY (`id_jenis`) USING BTREE;

--
-- Indexes for table `satuan`
--
ALTER TABLE `satuan`
  ADD PRIMARY KEY (`id_satuan`) USING BTREE;

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id_supplier`) USING BTREE;

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang_keluar_dtl`
--
ALTER TABLE `barang_keluar_dtl`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jenis`
--
ALTER TABLE `jenis`
  MODIFY `id_jenis` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `satuan`
--
ALTER TABLE `satuan`
  MODIFY `id_satuan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id_supplier` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `barang_ibfk_1` FOREIGN KEY (`satuan_id`) REFERENCES `satuan` (`id_satuan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `barang_ibfk_2` FOREIGN KEY (`jenis_id`) REFERENCES `jenis` (`id_jenis`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `barang_keluar`
--
ALTER TABLE `barang_keluar`
  ADD CONSTRAINT `barang_keluar_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `barang_keluar_ibfk_2` FOREIGN KEY (`id_customer`) REFERENCES `customer` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `barang_keluar_copy1`
--
ALTER TABLE `barang_keluar_copy1`
  ADD CONSTRAINT `barang_keluar_copy1_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `barang_keluar_copy1_ibfk_2` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `barang_keluar_dtl`
--
ALTER TABLE `barang_keluar_dtl`
  ADD CONSTRAINT `barang_keluar_dtl_ibfk_1` FOREIGN KEY (`id_barang_keluar`) REFERENCES `barang_keluar` (`id_barang_keluar`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD CONSTRAINT `barang_masuk_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `barang_masuk_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`id_supplier`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `barang_masuk_ibfk_3` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
