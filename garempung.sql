-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 05, 2024 at 03:03 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `garempung`
--

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id_login` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` char(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `id_member` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id_login`, `username`, `password`, `id_member`) VALUES
(4, 'garempung', 'garempungjaya', 1);

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `id_member` int(10) NOT NULL,
  `Whatsapp` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `shopee` varchar(50) NOT NULL,
  `facebook` varchar(50) NOT NULL,
  `instagram` varchar(50) NOT NULL,
  `about` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`id_member`, `Whatsapp`, `email`, `shopee`, `facebook`, `instagram`, `about`) VALUES
(1, '+62895363662997', 'email@gmail.com', 'ulilshopee', 'ulilfacebook', 'testing', 'Garempung.id didirikan pada tahun 2024 oleh Muhammad Mandaka Adyatma, mahasiswa Manajemen Bisnis di Universitas Negeri Yogyakarta yang berasal dari Jepara. Terinspirasi oleh kecintaannya terhadap kerajinan kayu dan kebutuhan ergonomis pengguna laptop, Muhammad mendirikan Garempung sebagai usaha yang dibangun sejak masih kuliah. Garempung.id merupakan anak perusahaan dari Vista Homedeco, yang telah dikenal bergerak di bidang furniture dan kerajinan tangan. Dengan pengalaman dan jaringan yang dimiliki Vista Homedeco, Garempung hadir dengan menawarkan produk kerajinan tangan berbahan kayu solid berkualitas tinggi. Pada tahun 2024, Garempung.id meluncurkan dua produk utama: stand laptop kayu kecil dan stand laptop kayu besar, yang dapat dibongkar pasang dan mudah dibawa. Produk ini segera mendapatkan sambutan positif karena desain ergonomis, kualitas material, dan harga terjangkau. Visi Garempung.id adalah menjadi pemimpin dalam industri aksesori laptop dengan fokus pada kenyamanan pengguna dan keindahan desain. Misi kami adalah menyediakan produk berkualitas tinggi yang ramah lingkungan dan praktis, serta mampu meningkatkan pengalaman kerja pengguna laptop. Kami berkomitmen untuk menggunakan bahan-bahan ramah lingkungan dan proses produksi yang berkelanjutan. Setiap produk dibuat dengan standar kualitas tinggi, menggunakan kayu dari pemasok yang beretika. Garempung.id, sebagai anak perusahaan Vista Homedeco, terus berinovasi dalam menciptakan produk yang bermanfaat dan estetis. Dengan komitmen terhadap kualitas, kenyamanan, dan keberlanjutan, Garempung.id siap untuk memberikan yang terbaik bagi pelanggan.');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `is_best_seller` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `description`, `is_best_seller`, `created_at`, `updated_at`) VALUES
(19, 'bambang', 20000.00, 'enak pol to yo lek', 1, '2024-07-31 19:10:43', '2024-08-01 08:24:33'),
(22, 'NonameCC02', 123123.00, 'eadas', 1, '2024-08-01 09:16:16', '2024-08-01 09:24:24'),
(23, 'cihuy', 12.00, 'sada', 1, '2024-08-01 09:16:59', '2024-08-01 09:33:30'),
(24, 'budi', 12.00, 'as', 0, '2024-08-01 09:20:05', '2024-08-01 09:20:05'),
(26, 'ulil bau', 90000.00, 'opolah', 0, '2024-08-01 12:18:26', '2024-08-01 12:18:26');

-- --------------------------------------------------------

--
-- Table structure for table `product_media`
--

CREATE TABLE `product_media` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_type` enum('image','video') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_media`
--

INSERT INTO `product_media` (`id`, `product_id`, `file_name`, `file_type`) VALUES
(33, 19, 'images/66aa8c358e08b_cool-fun.gif', 'image'),
(37, 19, 'images/66ab477be27b5_lelang.png', 'image'),
(38, 19, 'images/66ab477be27f1_shopee.png', 'image'),
(39, 22, 'images/66ab526478c78_cool-fun.gif', 'image'),
(40, 23, 'images/66ab52945555e_shopee.png', 'image'),
(41, 24, 'images/66ab53492bae8_instagram.png', 'image'),
(43, 23, 'images/66ab56515f657_Cuplikan layar 2024-06-10 175015.png', 'image'),
(45, 26, 'images/66ab7d1b50562_Cuplikan layar 2024-06-24 185002.png', 'image');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id_login`),
  ADD UNIQUE KEY `id_member` (`id_member`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id_member`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_media`
--
ALTER TABLE `product_media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id_login` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `id_member` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `product_media`
--
ALTER TABLE `product_media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `product_media`
--
ALTER TABLE `product_media`
  ADD CONSTRAINT `product_media_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
