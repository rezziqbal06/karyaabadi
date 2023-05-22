-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 21, 2023 at 01:23 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `asesmen_rs_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `a_indikator`
--

CREATE TABLE `a_indikator` (
  `id` int(5) NOT NULL,
  `a_jpenilaian_id` int(5) NOT NULL,
  `a_ruangan_ids` varchar(128) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `kategori` varchar(255) NOT NULL,
  `subkategori` varchar(255) NOT NULL,
  `type` varchar(128) NOT NULL,
  `cdate` datetime NOT NULL,
  `is_active` int(1) NOT NULL DEFAULT 1,
  `is_deleted` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `a_indikator`
--

INSERT INTO `a_indikator` (`id`, `a_jpenilaian_id`, `a_ruangan_ids`, `nama`, `kategori`, `subkategori`, `type`, `cdate`, `is_active`, `is_deleted`) VALUES
(125, 2, '[\"\"]', 'seb-ps', '', '', 'indikator', '2022-12-16 05:45:39', 1, 0),
(126, 2, '[\"\"]', 'Seb-asept', '', '', 'indikator', '2022-12-16 05:45:39', 1, 0),
(127, 2, '[\"\"]', 'Set-drh.c tbh', '', '', 'indikator', '2022-12-16 05:45:39', 1, 0),
(128, 2, '[\"\"]', 'Set-ps', '', '', 'indikator', '2022-12-16 05:45:39', 1, 0),
(129, 2, '[\"\"]', 'Set.lkg ps', '', '', 'indikator', '2022-12-16 05:45:39', 1, 0),
(130, 2, '[\"\"]', 'HW', '', '', 'aksi', '2022-12-16 05:45:39', 1, 0),
(131, 2, '[\"\"]', 'HR', '', '', 'aksi', '2022-12-16 05:45:39', 1, 0),
(132, 2, '[\"\"]', 'Tdk HH', '', '', 'aksi', '2022-12-16 05:45:39', 1, 0),
(133, 2, '[\"\"]', 'Glove', '', '', 'aksi', '2022-12-16 05:45:39', 1, 0),
(134, 3, '[\"\"]', 'Memandikan Pasien', '', '', 'indikator', '2022-12-16 05:45:59', 1, 0),
(135, 3, '[\"\"]', 'Vulva/penis Hygiene', '', '', 'indikator', '2022-12-16 05:45:59', 1, 0),
(136, 3, '[\"\"]', 'Menolong BAB', '', '', 'indikator', '2022-12-16 05:45:59', 1, 0),
(137, 3, '[\"\"]', 'Menolong BAK', '', '', 'indikator', '2022-12-16 05:45:59', 1, 0),
(138, 3, '[\"\"]', 'Oral Hygiene', '', '', 'indikator', '2022-12-16 05:45:59', 1, 0),
(139, 3, '[\"\"]', 'Pengisapan lendir', '', '', 'indikator', '2022-12-16 05:45:59', 1, 0),
(140, 3, '[\"\"]', 'Pemasangan kateter urine', '', '', 'indikator', '2022-12-16 05:45:59', 1, 0),
(141, 3, '[\"\"]', 'Pemasangan dan pencabutan infus', '', '', 'indikator', '2022-12-16 05:45:59', 1, 0),
(142, 3, '[\"\"]', 'Mengambil darah vena', '', '', 'indikator', '2022-12-16 05:45:59', 1, 0),
(143, 3, '[\"\"]', 'Perawatan luka mayor', '', '', 'indikator', '2022-12-16 05:45:59', 1, 0),
(144, 3, '[\"\"]', 'Perawatan luka minor', '', '', 'indikator', '2022-12-16 05:45:59', 1, 0),
(145, 3, '[\"\"]', 'Perawatan luka infeksius', '', '', 'indikator', '2022-12-16 05:45:59', 1, 0),
(146, 3, '[\"\"]', 'Pengukuran tekanan darah', '', '', 'indikator', '2022-12-16 05:45:59', 1, 0),
(147, 3, '[\"\"]', 'Pengukuran suhu', '', '', 'indikator', '2022-12-16 05:45:59', 1, 0),
(148, 3, '[\"\"]', 'Menyuntik', '', '', 'indikator', '2022-12-16 05:45:59', 1, 0),
(149, 3, '[\"\"]', 'Penanganan dan pembersihan alat-alat instrumen', '', '', 'indikator', '2022-12-16 05:45:59', 1, 0),
(150, 3, '[\"\"]', 'Penanganan limbah padat', '', '', 'indikator', '2022-12-16 05:45:59', 1, 0),
(151, 3, '[\"\"]', 'Penanganan darah / cairan tubuh', '', '', 'indikator', '2022-12-16 05:45:59', 1, 0),
(152, 3, '[\"\"]', 'Sarung Tangan', '', '', 'aksi', '2022-12-16 05:45:59', 1, 0),
(153, 3, '[\"\"]', 'Masker', '', '', 'aksi', '2022-12-16 05:45:59', 1, 0),
(154, 3, '[\"\"]', 'Gaun / Apron', '', '', 'aksi', '2022-12-16 05:45:59', 1, 0),
(155, 3, '[\"\"]', 'Kaca mata / penutup wajah', '', '', 'aksi', '2022-12-16 05:45:59', 1, 0),
(156, 3, '[\"\"]', 'Topi', '', '', 'aksi', '2022-12-16 05:45:59', 1, 0),
(407, 4, '[\"13\",\"14\",\"15\",\"16\",\"17\",\"18\",\"19\"]', 'Personal hegiene baik', 'Personal', '', 'indikator', '2022-12-23 22:55:08', 1, 0),
(408, 4, '[\"13\",\"14\",\"15\",\"16\",\"17\",\"18\",\"19\"]', 'Pakaian rapih', 'Personal', '', 'indikator', '2022-12-23 22:55:08', 1, 0),
(409, 4, '[\"13\",\"14\",\"15\",\"16\",\"17\",\"18\",\"19\"]', 'Rambut bersih dan rapih', 'Personal', '', 'indikator', '2022-12-23 22:55:08', 1, 0),
(410, 4, '[\"13\",\"14\",\"15\",\"16\",\"17\",\"18\",\"19\"]', 'Tidak menggunakan perhiasan tangan', 'Personal', '', 'indikator', '2022-12-23 22:55:08', 1, 0),
(411, 4, '[\"13\",\"14\",\"15\",\"16\",\"17\",\"18\",\"19\"]', 'Kuku pendek dan bersih', 'Personal', '', 'indikator', '2022-12-23 22:55:08', 1, 0),
(412, 4, '[\"13\",\"14\",\"15\",\"16\",\"17\",\"18\"]', 'Kursi, Meja, lemari tampak bersih', 'Kebersihan Secara Umum', '', 'indikator', '2022-12-23 22:55:08', 1, 0),
(413, 4, '[\"13\",\"14\",\"15\",\"16\",\"17\",\"18\"]', 'Kursi, meja , lemari dalam kondisi baik', 'Kebersihan Secara Umum', '', 'indikator', '2022-12-23 22:55:08', 1, 0),
(414, 4, '[\"13\",\"14\",\"15\",\"16\",\"17\",\"18\"]', 'Ruang nurse station bersih dan rapih', 'Kebersihan Secara Umum', '', 'indikator', '2022-12-23 22:55:08', 1, 0),
(415, 4, '[\"13\",\"14\",\"15\",\"16\",\"17\",\"18\"]', 'Troli tindakan tampak bersih', 'Kebersihan Secara Umum', '', 'indikator', '2022-12-23 22:55:08', 1, 0),
(416, 4, '[\"13\",\"14\",\"15\",\"16\",\"17\",\"18\"]', 'Troli tindakan dibersihkan dengan desinfektan jika terkontaminasi', 'Kebersihan Secara Umum', '', 'indikator', '2022-12-23 22:55:08', 1, 0),
(417, 4, '[\"13\",\"14\",\"15\",\"16\",\"17\",\"18\"]', 'Lantai bersih  dan dalam kondisi baik', 'Kebersihan Secara Umum', '', 'indikator', '2022-12-23 22:55:08', 1, 0),
(418, 4, '[\"13\",\"14\",\"15\",\"16\",\"17\",\"18\"]', 'Tidak ada debu di permukaan alat', 'Kebersihan Secara Umum', '', 'indikator', '2022-12-23 22:55:08', 1, 0),
(419, 4, '[\"13\",\"14\",\"15\",\"16\",\"17\",\"18\"]', 'Peralatan bersih, kering, dan disimpan dengan rapih', 'Kebersihan Secara Umum', '', 'indikator', '2022-12-23 22:55:08', 1, 0),
(420, 4, '[\"13\",\"14\",\"15\",\"16\",\"17\",\"18\"]', 'Tersedia washtafel untuk cuci tangan', 'Fasilitas Hand Hygiene', '', 'indikator', '2022-12-23 22:55:08', 1, 0),
(421, 4, '[\"13\",\"14\",\"15\",\"16\",\"17\",\"18\"]', 'Kran air berfungsi dengan baik', 'Fasilitas Hand Hygiene', '', 'indikator', '2022-12-23 22:55:08', 1, 0),
(422, 4, '[\"13\",\"14\",\"15\",\"16\",\"17\",\"18\"]', 'Tersedia sabun cair di setiap washtafel', 'Fasilitas Hand Hygiene', '', 'indikator', '2022-12-23 22:55:08', 1, 0),
(423, 4, '[\"13\",\"14\",\"15\",\"16\",\"17\",\"18\"]', 'Tersedia tissue towel di setiap washtafel', 'Fasilitas Hand Hygiene', '', 'indikator', '2022-12-23 22:55:08', 1, 0),
(424, 4, '[\"13\",\"14\",\"15\",\"16\",\"17\",\"18\"]', 'Tersedia tempat sampah di setiap washtafel', 'Fasilitas Hand Hygiene', '', 'indikator', '2022-12-23 22:55:08', 1, 0),
(425, 4, '[\"13\",\"14\",\"15\",\"16\",\"17\",\"18\"]', 'Tersedia poster hand hygiene disetiap wastafel', 'Fasilitas Hand Hygiene', '', 'indikator', '2022-12-23 22:55:08', 1, 0),
(426, 4, '[\"13\",\"14\",\"15\",\"16\",\"17\",\"18\"]', 'Tersedia handrub di nurse station', 'Fasilitas Hand Hygiene', '', 'indikator', '2022-12-23 22:55:08', 1, 0),
(427, 4, '[\"13\",\"14\",\"15\",\"16\",\"17\",\"18\"]', 'Tersedia handrub di setiap troli', 'Fasilitas Hand Hygiene', '', '', '2022-12-23 22:55:08', 1, 0),
(428, 4, '[\"13\",\"14\",\"15\",\"16\",\"17\",\"18\"]', 'Tersedia handrub di setiap ruangan rawat inap', 'Fasilitas Hand Hygiene', '', '', '2022-12-23 22:55:08', 1, 0),
(429, 4, '[\"13\",\"14\",\"15\",\"16\",\"17\",\"18\",\"19\"]', 'Masker', 'Fasilitas APD', '', '', '2022-12-23 22:55:08', 1, 0),
(430, 4, '[\"13\",\"14\",\"15\",\"16\",\"17\",\"18\",\"19\"]', 'Sarung tangan', 'Fasilitas APD', '', '', '2022-12-23 22:55:08', 1, 0),
(431, 4, '[\"13\",\"14\",\"15\",\"16\",\"17\",\"18\",\"19\"]', 'Apron', 'Fasilitas APD', '', '', '2022-12-23 22:55:08', 1, 0),
(432, 4, '[\"13\",\"14\",\"15\",\"16\",\"17\",\"18\",\"19\"]', 'Kacamata', 'Fasilitas APD', '', '', '2022-12-23 22:55:08', 1, 0),
(433, 4, '[\"13\",\"14\",\"15\",\"16\",\"17\",\"18\",\"19\"]', 'Tutup kepala', 'Fasilitas APD', '', '', '2022-12-23 22:55:08', 1, 0),
(434, 4, '[\"13\",\"14\",\"15\",\"16\",\"17\",\"18\",\"19\"]', 'Tersedia tempat sampah infeksius dengan pedal yang berfungsi dengan baik', 'Fasilitas tempat sampah', '', '', '2022-12-23 22:55:08', 1, 0),
(435, 4, '[\"13\",\"14\",\"15\",\"16\",\"17\",\"18\",\"19\"]', 'Tersedia tempat sampah non infeksius dengan pedal yang berfungsi dengan baik', 'Fasilitas tempat sampah', '', '', '2022-12-23 22:55:08', 1, 0),
(436, 4, '[\"13\",\"14\",\"15\",\"16\",\"17\",\"18\",\"19\"]', 'Tersedia safety box yang sesuai', 'Fasilitas tempat sampah', '', '', '2022-12-23 22:55:08', 1, 0),
(437, 4, '[\"13\",\"14\",\"15\",\"16\",\"17\",\"18\",\"19\"]', 'Ada label sesuai peruntukannya', 'Fasilitas tempat sampah', '', '', '2022-12-23 22:55:08', 1, 0),
(438, 4, '[\"13\",\"14\",\"15\",\"16\",\"17\",\"18\",\"19\"]', 'Tempat limbah dalam keadaan bersih dan tertutup', 'Tata Kelola Limbah Infeksius, Cairan tubuh, dan limbah domestik', '', '', '2022-12-23 22:55:08', 1, 0),
(439, 4, '[\"13\",\"14\",\"15\",\"16\",\"17\",\"18\",\"19\"]', 'Sampah tidak lebih 3/4 Penuh', 'Tata Kelola Limbah Infeksius, Cairan tubuh, dan limbah domestik', '', '', '2022-12-23 22:55:08', 1, 0),
(440, 4, '[\"13\",\"14\",\"15\",\"16\",\"17\",\"18\",\"19\"]', 'Membuang limbah cair infeksius ke dalam spoolhock/wastafel yang mengalir ke IPAL', 'Tata Kelola Limbah Infeksius, Cairan tubuh, dan limbah domestik', '', '', '2022-12-23 22:55:08', 1, 0),
(441, 4, '[\"13\",\"14\",\"15\",\"16\",\"17\",\"18\",\"19\"]', 'Membuang sampah infeksius ke dalam tempat sampah yang dilapisi plastik warna kuning', 'Tata Kelola Limbah Infeksius, Cairan tubuh, dan limbah domestik', '', '', '2022-12-23 22:55:08', 1, 0),
(442, 4, '[\"13\",\"14\",\"15\",\"16\",\"17\",\"18\",\"19\"]', 'Membuang sampah Domestik ke dalam tempat sampah yang dilapisi plastik warna hitam', 'Tata Kelola Limbah Infeksius, Cairan tubuh, dan limbah domestik', '', '', '2022-12-23 22:55:08', 1, 0),
(443, 4, '[\"13\",\"14\",\"15\",\"16\",\"17\",\"18\",\"19\"]', 'Membuang limbah benda tajam ke dalam safety box', 'Tata Kelola Limbah Infeksius, Cairan tubuh, dan limbah domestik', '', '', '2022-12-23 22:55:08', 1, 0),
(444, 4, '[\"13\",\"14\",\"15\",\"16\",\"17\",\"18\",\"19\"]', 'Safety box diletakkan di tempat yang aman, 30 cm dari lantai', 'Tata kelola benda tajam', '', '', '2022-12-23 22:55:08', 1, 0),
(445, 4, '[\"13\",\"14\",\"15\",\"16\",\"17\",\"18\",\"19\"]', 'Tempat limbah benda tajam dirakit dengan benar', 'Tata kelola benda tajam', '', '', '2022-12-23 22:55:08', 1, 0),
(446, 4, '[\"13\",\"14\",\"15\",\"16\",\"17\",\"18\",\"19\"]', 'isi limbah benda tajam tidak lebih dari 3/4 penuh', 'Tata kelola benda tajam', '', '', '2022-12-23 22:55:08', 1, 0),
(447, 4, '[\"13\",\"14\",\"15\",\"16\",\"17\",\"18\",\"19\"]', 'Tidak menutup kembali jarum suntik habis pakai (langsung buang)', 'Tata kelola benda tajam', '', '', '2022-12-23 22:55:08', 1, 0),
(448, 4, '[\"13\",\"14\",\"15\",\"16\",\"17\",\"18\",\"19\"]', 'Tidak memberikan banda tajam habis pakai ke orang lain', 'Tata kelola benda tajam', '', '', '2022-12-23 22:55:08', 1, 0),
(449, 4, '[\"13\",\"14\",\"15\",\"16\",\"17\",\"18\",\"19\"]', 'Jika harus memberikan benda tajam keorang lain gunakan kontainer', 'Tata kelola benda tajam', '', '', '2022-12-23 22:55:08', 1, 0),
(450, 4, '[\"13\",\"14\",\"15\",\"16\",\"17\",\"18\",\"19\"]', 'jika sudah 3/4 penuh, tempat limbah tajam ditutup rapat dan disimpan di TPS', 'Tata kelola benda tajam', '', '', '2022-12-23 22:55:08', 1, 0),
(451, 4, '[\"13\",\"14\",\"15\",\"16\",\"17\",\"18\",\"19\"]', 'Tersedia alur pasca pajanan benda tajam', 'Tata kelola benda tajam', '', '', '2022-12-23 22:55:08', 1, 0),
(452, 4, '[\"13\",\"15\",\"16\",\"17\",\"18\",\"19\"]', 'Area Kamar Mandi / Toilet kondisi baik', 'Toilet Kamar Mandi', '', '', '2022-12-23 22:55:08', 1, 0),
(453, 4, '[\"13\",\"15\",\"16\",\"17\",\"18\",\"19\"]', 'Toilet bersih', 'Toilet Kamar Mandi', '', '', '2022-12-23 22:55:08', 1, 0),
(454, 4, '[\"13\",\"15\",\"16\",\"17\",\"18\",\"19\"]', 'Kamar mandi terbebas dari benda-benda yang tak perlu', 'Toilet Kamar Mandi', '', '', '2022-12-23 22:55:08', 1, 0),
(455, 4, '[\"13\",\"15\",\"16\",\"17\",\"18\",\"19\"]', 'Tersedia fasilitas pembuangan sampah', 'Toilet Kamar Mandi', '', '', '2022-12-23 22:55:08', 1, 0),
(456, 4, '[\"13\",\"14\",\"15\",\"17\"]', 'Lemari linen bersih dan tertutup', 'Pengelolaan Linen', '', '', '2022-12-23 22:55:08', 1, 0),
(457, 4, '[\"13\",\"14\",\"15\",\"17\"]', 'Linen bersih tersusun rapih', 'Pengelolaan Linen', '', '', '2022-12-23 22:55:08', 1, 0),
(458, 4, '[\"13\",\"14\",\"15\",\"17\"]', 'Tersedia tempat linen kotor yang tertutup dalam kondisi baik dan bersih', 'Pengelolaan Linen', '', '', '2022-12-23 22:55:08', 1, 0),
(459, 4, '[\"13\",\"14\",\"15\",\"17\"]', 'Linen kotor infeksius ditempatkan dalam wadah linen kotor infeksius yang dilapisi kantong plastik warna kuning dan tertutup', 'Pengelolaan Linen', '', '', '2022-12-23 22:55:08', 1, 0),
(460, 4, '[\"13\",\"14\",\"15\",\"17\"]', 'Linen kotor non infeksius ditempatkan dalam wadah linen non infeksius yang dilapisi kantong plastik warna hitam dan tertutup', 'Pengelolaan Linen', '', '', '2022-12-23 22:55:08', 1, 0),
(461, 4, '[\"13\",\"14\",\"15\",\"17\"]', 'Tidak ditemukan linen kotor tergeletak dilantai', 'Pengelolaan Linen', '', '', '2022-12-23 22:55:08', 1, 0),
(462, 4, '[\"13\",\"14\",\"15\",\"17\"]', 'Petugas menggunakan APD dalam menangani linen kotor', 'Pengelolaan Linen', '', '', '2022-12-23 22:55:08', 1, 0),
(463, 4, '[\"13\",\"14\",\"15\",\"16\",\"17\",\"18\",\"19\"]', 'Dressing set dan alat steril lain disimpan dalam lemari tertutup dan terpisah dari alat non steril', 'Penyimpanan Alat Medis dan obat', '', '', '2022-12-23 22:55:08', 1, 0),
(464, 4, '[\"13\",\"14\",\"15\",\"16\",\"17\",\"18\",\"19\"]', 'Alat dan bahan steril belum kadaluarsa ( lihat tanggal dan kondisi)', 'Penyimpanan Alat Medis dan obat', '', '', '2022-12-23 22:55:08', 1, 0),
(465, 4, '[\"13\",\"14\",\"15\",\"16\",\"17\",\"18\",\"19\"]', 'Alat medis bersih disimpan terbungkus atau tertutup, kering dan terbebas dari debu', 'Penyimpanan Alat Medis dan obat', '', '', '2022-12-23 22:55:08', 1, 0),
(466, 4, '[\"13\",\"14\",\"15\",\"16\",\"17\",\"18\",\"19\"]', 'Lemari es penyimpanan obat kondisi bersih dan obat tidak tercampur dengan benda lain', 'Penyimpanan Alat Medis dan obat', '', '', '2022-12-23 22:55:08', 1, 0),
(467, 4, '[\"13\",\"14\",\"15\",\"16\",\"17\",\"18\",\"19\"]', 'Suhu lemari es tempat penyimpanan obat di catat setiap hari suhu 2 s/d 8°c', 'Penyimpanan Alat Medis dan obat', '', '', '2022-12-23 22:55:08', 1, 0),
(468, 4, '[\"19\"]', 'Kursi, meja, dan lemari tampak bersih dan kondisi baik', 'Kebersihan secara umum', '', '', '2022-12-23 22:55:08', 1, 0),
(469, 4, '[\"19\"]', 'Lantai di area polikinik bersih', 'Kebersihan secara umum', '', '', '2022-12-23 22:55:08', 1, 0),
(470, 4, '[\"19\"]', 'Lantai di area tunggu pasien bersih', 'Kebersihan secara umum', '', '', '2022-12-23 22:55:08', 1, 0),
(471, 4, '[\"19\"]', 'Dinding bersih', 'Kebersihan secara umum', '', '', '2022-12-23 22:55:08', 1, 0),
(472, 4, '[\"19\"]', 'Wastafel bersih', 'Kebersihan secara umum', '', '', '2022-12-23 22:55:08', 1, 0),
(473, 4, '[\"19\"]', 'Bed untuk pemeriksaan pasien bersih', 'Kebersihan secara umum', '', '', '2022-12-23 22:55:08', 1, 0),
(474, 4, '[\"19\"]', 'Tersedia wastafel dan berfungsi dengan baik', 'Fasilitas Hand Hygiene', '', '', '2022-12-23 22:55:08', 1, 0),
(475, 4, '[\"19\"]', 'Tersedia Tissue', 'Fasilitas Hand Hygiene', '', '', '2022-12-23 22:55:08', 1, 0),
(476, 4, '[\"19\"]', 'Tersedia handsoap', 'Fasilitas Hand Hygiene', '', '', '2022-12-23 22:55:08', 1, 0),
(477, 4, '[\"19\"]', 'Tersedia Handrub di meja dokter', 'Fasilitas Hand Hygiene', '', '', '2022-12-23 22:55:08', 1, 0),
(478, 4, '[\"19\"]', 'Tersedia handrub di meja perawat', 'Fasilitas Hand Hygiene', '', '', '2022-12-23 22:55:08', 1, 0),
(479, 4, '[\"19\"]', 'Ada poster Hand hygiene', 'Fasilitas Hand Hygiene', '', '', '2022-12-23 22:55:08', 1, 0),
(480, 5, '', '', '', '', 'indikator', '2023-02-21 18:23:15', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `a_jabatan`
--

CREATE TABLE `a_jabatan` (
  `id` int(5) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `cdate` datetime NOT NULL,
  `is_active` int(1) NOT NULL,
  `is_deleted` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `a_jabatan`
--

INSERT INTO `a_jabatan` (`id`, `nama`, `deskripsi`, `cdate`, `is_active`, `is_deleted`) VALUES
(1, 'IPCD', '(Infection Prevention Control Docter)', '0000-00-00 00:00:00', 1, 0),
(2, 'IPCN', '(Infection Prevention Control Nurse)', '0000-00-00 00:00:00', 1, 0),
(3, 'IPCLN', '(Infection Prevention Control Link Nurse)', '0000-00-00 00:00:00', 1, 0),
(4, 'Komite Mutu', 'Komite Mutu', '0000-00-00 00:00:00', 1, 0),
(5, 'Perawat', 'Perawat', '0000-00-00 00:00:00', 1, 0),
(6, 'Bidan', 'Bidan', '0000-00-00 00:00:00', 1, 0),
(7, 'Analis Laboratorium', 'Analis Laboratorium', '0000-00-00 00:00:00', 1, 0),
(8, 'Radiografer', 'Radiografer', '0000-00-00 00:00:00', 1, 0),
(9, 'Dokter Umum', 'Dokter Umum', '0000-00-00 00:00:00', 1, 0),
(10, 'Dokter Specialis', 'Dokter Specialis', '0000-00-00 00:00:00', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `a_jpenilaian`
--

CREATE TABLE `a_jpenilaian` (
  `id` int(5) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `cdate` datetime NOT NULL,
  `is_active` int(1) NOT NULL DEFAULT 1,
  `is_deleted` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `a_jpenilaian`
--

INSERT INTO `a_jpenilaian` (`id`, `nama`, `slug`, `deskripsi`, `cdate`, `is_active`, `is_deleted`) VALUES
(2, 'Audit Hand Hygiene', 'audit-hand-hygiene', 'Audit Hand Hygiene', '2022-12-15 05:22:06', 1, 0),
(3, 'Audit Kepatuhan APD', 'audit-kepatuhan-apd', 'Audit Kepatuhan APD', '2022-12-15 05:33:15', 1, 0),
(4, 'Monitoring Kegiatan Harian Pencegahan Pengendalian Infeksi (PPI)', 'monitoring-kegiatan-harian-pencegahan-pengendalian-infeksi-ppi', 'Monitoring Kegiatan Harian Pencegahan Pengendalian Infeksi (PPI)', '2022-12-15 07:19:05', 1, 0),
(5, 'Surveilan Pencegahan Dan Pengendalian Infeksi', 'surveilan-pencegahan-dan-pengendalian-infeksi', 'Surveilan Pencegahan Dan Pengendalian Infeksi', '2023-02-21 18:23:15', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `a_modules`
--

CREATE TABLE `a_modules` (
  `identifier` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `path` varchar(255) DEFAULT '',
  `level` int(1) NOT NULL DEFAULT 0 COMMENT 'depth level of menu, 0 mean outer 3 deeper submenu',
  `has_submenu` int(1) NOT NULL DEFAULT 0 COMMENT '1 mempunyai submenu, 2 tidak mempunyai submenu',
  `children_identifier` varchar(255) DEFAULT NULL,
  `is_active` int(1) NOT NULL DEFAULT 1,
  `is_default` enum('allowed','denied') NOT NULL DEFAULT 'denied',
  `is_visible` int(1) NOT NULL DEFAULT 1,
  `priority` int(3) NOT NULL DEFAULT 0 COMMENT '0 mean higher 999 lower',
  `fa_icon` varchar(255) NOT NULL DEFAULT 'fa fa-home' COMMENT 'font-awesome icon on menu',
  `utype` varchar(48) NOT NULL DEFAULT 'internal' COMMENT 'type module : internal, external'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='list modul yang ada dimenu atau tidak ada dimenu';

--
-- Dumping data for table `a_modules`
--

INSERT INTO `a_modules` (`identifier`, `name`, `path`, `level`, `has_submenu`, `children_identifier`, `is_active`, `is_default`, `is_visible`, `priority`, `fa_icon`, `utype`) VALUES
('admin_akun_user', 'Kustomer', 'admin/akun/user', 1, 0, 'akun', 1, 'denied', 1, 90, 'fa fa-users', 'internal'),
('admin_api_doc', 'Dokumentasi', 'admin/api/doc', 1, 0, 'api', 1, 'denied', 1, 1, 'fa fa-book', 'internal'),
('akun', 'Akun', '#', 0, 1, NULL, 1, 'denied', 1, 20, 'fa fa-users', 'internal'),
('akun_pengguna', 'Administrator', 'akun/pengguna', 1, 0, 'akun', 1, 'denied', 1, 90, 'fa fa-users', 'internal'),
('akun_user', 'Kustomer', 'akun/user', 1, 0, 'akun', 1, 'denied', 1, 90, 'fa fa-users', 'internal'),
('api', 'API', '#', 0, 1, NULL, 1, 'denied', 1, 80, 'fa fa-cog', 'internal'),
('api_doc', 'Dokumentasi', 'api/doc', 1, 0, 'api', 1, 'denied', 1, 1, 'fa fa-book', 'internal'),
('dashboard', 'Dashboard', '#', 0, 1, NULL, 1, 'denied', 1, 0, 'fa fa-home', 'internal'),
('laporan', 'Laporan', '#', 0, 1, NULL, 1, 'denied', 1, 90, 'fa fa-book', 'internal'),
('laporan_order', 'Order', 'laporan/order', 1, 0, 'laporan', 1, 'denied', 1, 1, 'fa fa-cogs', 'internal'),
('laporan_pengiriman', 'Pengiriman', 'laporan/pengiriman', 1, 0, 'laporan', 1, 'denied', 1, 1, 'fa fa-cogs', 'internal'),
('order', 'Kirim Paket', 'order', 0, 1, NULL, 1, 'denied', 1, 20, 'fa fa-exchange', 'internal'),
('partner', 'Partner', '#', 0, 1, NULL, 1, 'denied', 1, 20, 'fa fa-handshake-o', 'internal'),
('partner_reseller', 'Reseller', 'admin/partner/reseller', 1, 0, 'partner', 1, 'denied', 1, 90, 'fa fa-users', 'internal'),
('pengaturan', 'Pengaturan', 'pengaturan', 0, 1, NULL, 1, 'denied', 1, 90, 'fa fa-cogs', 'internal'),
('pengaturan_alamat', 'Alamat', 'pengaturan/alamat', 1, 0, 'pengaturan', 1, 'denied', 1, 5, 'fa fa-home', 'internal'),
('pengaturan_env', 'Environment', 'pengaturan/env', 1, 0, 'pengaturan', 1, 'denied', 1, 1, 'fa fa-cogs', 'internal'),
('pengaturan_perusahaan', 'Perusahaan', 'pengaturan/perusahaan', 1, 0, 'pengaturan', 1, 'denied', 1, 1, 'fa fa-users', 'internal'),
('pengaturan_user', 'User', 'pengaturan/user', 1, 0, 'pengaturan', 1, 'denied', 1, 1, 'fa fa-users', 'internal'),
('tracking', 'Tracking', 'tracking', 0, 1, NULL, 1, 'denied', 1, 20, 'fa fa-truck', 'internal');

-- --------------------------------------------------------

--
-- Table structure for table `a_pengguna`
--

CREATE TABLE `a_pengguna` (
  `id` int(6) UNSIGNED NOT NULL,
  `a_company_id` int(3) UNSIGNED DEFAULT NULL COMMENT 'penempatan',
  `a_company_nama` varchar(78) NOT NULL DEFAULT '-',
  `a_company_kode` varchar(32) NOT NULL DEFAULT '-',
  `a_jabatan_id` int(3) UNSIGNED DEFAULT NULL,
  `a_jabatan_nama` varchar(255) NOT NULL DEFAULT 'Staff',
  `username` varchar(24) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `welcome_message` varchar(255) NOT NULL,
  `scope` enum('all','current_below','current_only','none') NOT NULL DEFAULT 'none',
  `nip` varchar(32) DEFAULT '-',
  `alamat` varchar(150) NOT NULL DEFAULT '',
  `alamat2` varchar(150) NOT NULL DEFAULT '',
  `alamat_kecamatan` varchar(150) NOT NULL DEFAULT '',
  `alamat_kabkota` varchar(150) NOT NULL DEFAULT '',
  `alamat_provinsi` varchar(150) NOT NULL DEFAULT '',
  `alamat_negara` varchar(150) NOT NULL DEFAULT '',
  `alamat_kodepos` varchar(12) NOT NULL DEFAULT ' ',
  `tempat_lahir` varchar(150) NOT NULL DEFAULT '',
  `tgl_lahir` date DEFAULT NULL,
  `jenis_kelamin` int(1) UNSIGNED NOT NULL DEFAULT 1,
  `status_pernikahan` enum('belum menikah','menikah','duda','janda') NOT NULL DEFAULT 'belum menikah',
  `telp_rumah` varchar(25) DEFAULT NULL,
  `telp_hp` varchar(25) DEFAULT NULL,
  `bank_rekening_nomor` varchar(78) NOT NULL DEFAULT '',
  `bank_rekening_nama` varchar(150) NOT NULL DEFAULT '',
  `bank_nama` varchar(150) NOT NULL DEFAULT '',
  `npwp` varchar(128) NOT NULL DEFAULT '',
  `kerja_terakhir` varchar(150) NOT NULL DEFAULT '',
  `kerja_terakhir_jabatan` varchar(78) NOT NULL DEFAULT '',
  `kerja_terakhir_gaji` decimal(18,0) DEFAULT NULL,
  `pendidikan_terakhir` varchar(150) NOT NULL DEFAULT '',
  `pendidikan_terakhir_jenjang` enum('SD','SMP','SMA','S1','D3','D2','S2') NOT NULL DEFAULT 'SMA',
  `pendidikan_terakhir_tahun` year(4) NOT NULL DEFAULT 1971,
  `ibu_nama` varchar(150) NOT NULL DEFAULT '',
  `ibu_pekerjaan` varchar(78) NOT NULL DEFAULT '',
  `tgl_kerja_mulai` date DEFAULT NULL,
  `tgl_kerja_akhir` date DEFAULT NULL,
  `tgl_kontrak_akhir` date DEFAULT NULL,
  `karyawan_status` enum('Kontrak','Magang','Tetap','Harian Lepas') NOT NULL,
  `nama_perusahaan` varchar(128) NOT NULL DEFAULT '',
  `is_karyawan` int(1) UNSIGNED NOT NULL DEFAULT 0,
  `is_active` int(1) UNSIGNED NOT NULL DEFAULT 1,
  `a_pengguna_id` int(6) UNSIGNED DEFAULT NULL COMMENT 'atasan langsung',
  `is_admin_master` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='tabel pengguna';

--
-- Dumping data for table `a_pengguna`
--

INSERT INTO `a_pengguna` (`id`, `a_company_id`, `a_company_nama`, `a_company_kode`, `a_jabatan_id`, `a_jabatan_nama`, `username`, `password`, `email`, `nama`, `foto`, `welcome_message`, `scope`, `nip`, `alamat`, `alamat2`, `alamat_kecamatan`, `alamat_kabkota`, `alamat_provinsi`, `alamat_negara`, `alamat_kodepos`, `tempat_lahir`, `tgl_lahir`, `jenis_kelamin`, `status_pernikahan`, `telp_rumah`, `telp_hp`, `bank_rekening_nomor`, `bank_rekening_nama`, `bank_nama`, `npwp`, `kerja_terakhir`, `kerja_terakhir_jabatan`, `kerja_terakhir_gaji`, `pendidikan_terakhir`, `pendidikan_terakhir_jenjang`, `pendidikan_terakhir_tahun`, `ibu_nama`, `ibu_pekerjaan`, `tgl_kerja_mulai`, `tgl_kerja_akhir`, `tgl_kontrak_akhir`, `karyawan_status`, `nama_perusahaan`, `is_karyawan`, `is_active`, `a_pengguna_id`, `is_admin_master`) VALUES
(1, NULL, '-', '-', NULL, 'Staff', 'mimind', '$2y$10$FudYvQFvkQGm3mMt8fLN2uY.eaW6cLxKJfTnUFTMxfg9srDgki9.a', 'daeng@thecloudalert.com', 'Administrator', 'media/pengguna/2021/05/c4ca4238a0b923820dcc509a6f75849b3151.jpg', 'Selamat Beraktifitas', 'all', '-', '', '', '', '', '', '', '', '', NULL, 1, 'belum menikah', '', '', '', '', '', '', '', '', '0', '', 'SMA', 1971, '', '', '0000-00-00', '0000-00-00', NULL, 'Kontrak', '', 0, 1, NULL, 1),
(402, NULL, '-', '-', NULL, 'Staff', '', '$2y$10$P1X2OqhipTMdeGCs8cWqAOck6cw0Kye1zj5W/OeCuQXy5Zs2IS2gO', 'rezziqbal@gmail.com', 'Rezza Muhammad Iqbal', '', '', 'none', '-', 'Jl. Kutawaringin No 9 Rt 1 Rw 7 Desa/Kec. Kutawaringin Kabupaten Bandung', '', '', '', '', '', ' ', '', NULL, 1, 'belum menikah', NULL, '085789701750', '', '', '', '', '', '', NULL, '', 'SMA', 1971, '', '', NULL, NULL, NULL, 'Kontrak', 'Sukahiji', 0, 1, NULL, 0),
(403, NULL, '-', '-', NULL, 'Sales', 'admin', '$2y$10$6yakajGNZmqK/VZe9goNkut//aU4/.EWFwx3fKXJFtRv6c3vce3Le', 'rezziqbal@gmail.com', 'Administrator', 'media/pengguna/2021/05/c4ca4238a0b923820dcc509a6f75849b3151.jpg', 'Selamat Beraktifitas', 'all', '-', '', '', '', '', '', '', '', '', NULL, 1, 'belum menikah', '', '', '', '', '', '', '', '', '0', '', 'SMA', 1971, '', '', '0000-00-00', '0000-00-00', NULL, 'Kontrak', '', 0, 1, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `a_pengguna_module`
--

CREATE TABLE `a_pengguna_module` (
  `id` int(8) UNSIGNED NOT NULL,
  `a_pengguna_id` int(6) UNSIGNED DEFAULT NULL,
  `a_modules_identifier` varchar(255) DEFAULT NULL,
  `rule` enum('allowed','disallowed','allowed_except','disallowed_except') NOT NULL DEFAULT 'allowed',
  `tmp_active` enum('N','Y') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='hak akses pengguna';

--
-- Dumping data for table `a_pengguna_module`
--

INSERT INTO `a_pengguna_module` (`id`, `a_pengguna_id`, `a_modules_identifier`, `rule`, `tmp_active`) VALUES
(1, 1, NULL, 'allowed_except', 'N'),
(3189, 403, 'akun', 'allowed', 'N'),
(3190, 403, 'admin_akun_user', 'allowed', 'N'),
(3191, 403, 'partner', 'allowed', 'N'),
(3192, 403, 'partner_reseller', 'allowed', 'N'),
(3193, 403, 'api', 'allowed', 'N'),
(3194, 403, 'admin_api_doc', 'allowed', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `a_rs`
--

CREATE TABLE `a_rs` (
  `id` int(5) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `is_active` int(1) NOT NULL DEFAULT 0,
  `is_deleted` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `a_ruangan`
--

CREATE TABLE `a_ruangan` (
  `id` int(5) NOT NULL,
  `a_rs_id` int(5) DEFAULT NULL,
  `nama` varchar(255) NOT NULL,
  `kd_ruangan` varchar(20) NOT NULL,
  `deskripsi` text NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `cdate` datetime NOT NULL,
  `is_active` int(1) NOT NULL DEFAULT 1,
  `is_deleted` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `a_ruangan`
--

INSERT INTO `a_ruangan` (`id`, `a_rs_id`, `nama`, `kd_ruangan`, `deskripsi`, `gambar`, `cdate`, `is_active`, `is_deleted`) VALUES
(13, 1, 'Anggrek', '', '', '', '0000-00-00 00:00:00', 1, 0),
(14, 1, 'Perinatologi', '', '', '', '0000-00-00 00:00:00', 1, 0),
(15, 1, 'Melati', '', '', '', '0000-00-00 00:00:00', 1, 0),
(16, 1, 'HCU', '', '', '', '0000-00-00 00:00:00', 1, 0),
(17, 1, 'VK/Kebidanan', '', '', '', '0000-00-00 00:00:00', 1, 0),
(18, 1, 'IGD', '', '', '', '0000-00-00 00:00:00', 1, 0),
(19, 1, 'IRJ', '', '', '', '0000-00-00 00:00:00', 1, 0),
(20, 1, 'Isolasi', '', '', '', '0000-00-00 00:00:00', 1, 0),
(21, 1, 'Gizi', '', '', '', '0000-00-00 00:00:00', 1, 0),
(22, 1, 'Laundry', '', '', '', '0000-00-00 00:00:00', 1, 0),
(23, 1, 'CSSD', '', '', '', '0000-00-00 00:00:00', 1, 0),
(24, 1, 'Farmasi', '', '', '', '0000-00-00 00:00:00', 1, 0),
(25, 1, 'RO', '', '', '', '0000-00-00 00:00:00', 1, 0),
(26, 1, 'LAB', '', '', '', '0000-00-00 00:00:00', 1, 0),
(27, 1, 'Kamar Jenazah', '', '', '', '0000-00-00 00:00:00', 1, 0),
(28, 1, 'IPAL', '', '', '', '0000-00-00 00:00:00', 1, 0),
(29, 1, 'Limbah', '', '', '', '0000-00-00 00:00:00', 1, 0),
(30, 0, 'tes', 'tes', 'tes', '', '0000-00-00 00:00:00', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `a_unit`
--

CREATE TABLE `a_unit` (
  `id` int(5) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `cdate` datetime NOT NULL,
  `is_active` int(1) NOT NULL DEFAULT 1,
  `is_deleted` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `a_unit`
--

INSERT INTO `a_unit` (`id`, `nama`, `deskripsi`, `cdate`, `is_active`, `is_deleted`) VALUES
(1, 'UGD', 'Tes', '2022-12-06 19:04:59', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `b_pasien`
--

CREATE TABLE `b_pasien` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `jenis_kelamin` varchar(1) NOT NULL,
  `nik` varchar(16) NOT NULL,
  `bpjs` varchar(255) NOT NULL,
  `telp` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `b_user`
--

CREATE TABLE `b_user` (
  `id` int(11) NOT NULL,
  `b_user_id` int(11) DEFAULT NULL COMMENT 'atasan',
  `a_unit_id` int(5) DEFAULT NULL,
  `a_jabatan_id` int(5) UNSIGNED DEFAULT NULL,
  `google_id` varchar(128) NOT NULL DEFAULT '',
  `kode` varchar(24) DEFAULT NULL,
  `kode_lama` varchar(64) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(128) NOT NULL DEFAULT '',
  `foto` varchar(255) NOT NULL DEFAULT '',
  `welcome_message` varchar(255) NOT NULL DEFAULT '',
  `password` varchar(255) DEFAULT NULL,
  `fnama` varchar(255) NOT NULL DEFAULT '',
  `lnama` varchar(78) NOT NULL DEFAULT ' ',
  `alamat` varchar(78) NOT NULL DEFAULT '',
  `alamat2` varchar(78) DEFAULT NULL,
  `kelurahan` varchar(78) NOT NULL DEFAULT '',
  `kecamatan` varchar(78) NOT NULL DEFAULT '',
  `kabkota` varchar(150) NOT NULL DEFAULT '',
  `provinsi` varchar(150) NOT NULL DEFAULT '',
  `negara` varchar(255) NOT NULL DEFAULT 'Indonesia',
  `kodepos` varchar(25) NOT NULL DEFAULT '',
  `kelamin` int(1) NOT NULL DEFAULT 1 COMMENT '1 laki-laki 0 perempuan',
  `tlahir` varchar(78) NOT NULL DEFAULT '-' COMMENT 'tempat lahir',
  `bdate` date NOT NULL DEFAULT '1970-01-01' COMMENT 'tanggal lahir',
  `cdate` datetime NOT NULL COMMENT 'tanggal pembuatan',
  `adate` date DEFAULT NULL COMMENT 'tanggal aktifasi',
  `edate` date DEFAULT NULL COMMENT 'tanggal berakhir membership',
  `telp` varchar(25) NOT NULL DEFAULT '',
  `fb` varchar(255) NOT NULL DEFAULT '',
  `fb_id` int(11) DEFAULT NULL,
  `ig` varchar(255) NOT NULL DEFAULT '',
  `ig_id` int(11) DEFAULT NULL,
  `deposit` float NOT NULL DEFAULT 0 COMMENT 'saldo_deposit',
  `reward_poin` int(7) NOT NULL DEFAULT 0,
  `image` varchar(255) NOT NULL DEFAULT ' ',
  `reg_from` varchar(64) NOT NULL DEFAULT 'online',
  `know_from` varchar(48) DEFAULT NULL,
  `umur` int(3) NOT NULL DEFAULT 20,
  `npwp` varchar(128) NOT NULL DEFAULT '',
  `api_reg_date` date DEFAULT NULL,
  `api_reg_token` varchar(48) DEFAULT NULL,
  `api_web_date` date DEFAULT NULL,
  `api_web_token` varchar(24) DEFAULT NULL,
  `api_mobile_date` date DEFAULT NULL,
  `api_mobile_token` varchar(24) DEFAULT NULL,
  `fcm_token` varchar(255) NOT NULL DEFAULT ' ',
  `device` varchar(24) NOT NULL DEFAULT 'web',
  `apikey` varchar(28) NOT NULL DEFAULT '',
  `is_agree` int(1) UNSIGNED NOT NULL DEFAULT 0,
  `is_confirmed` int(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '1 ya, 0 belum konfirmasi, flag setelah konfirmasi',
  `is_premium` int(1) UNSIGNED NOT NULL DEFAULT 0,
  `is_wa_verified` int(1) NOT NULL DEFAULT 1,
  `is_wa_send` int(1) NOT NULL DEFAULT 1,
  `is_active` int(1) UNSIGNED NOT NULL DEFAULT 1,
  `is_deleted` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='tabel pengguna, bisa member atau user vendor,';

--
-- Dumping data for table `b_user`
--

INSERT INTO `b_user` (`id`, `b_user_id`, `a_unit_id`, `a_jabatan_id`, `google_id`, `kode`, `kode_lama`, `email`, `username`, `foto`, `welcome_message`, `password`, `fnama`, `lnama`, `alamat`, `alamat2`, `kelurahan`, `kecamatan`, `kabkota`, `provinsi`, `negara`, `kodepos`, `kelamin`, `tlahir`, `bdate`, `cdate`, `adate`, `edate`, `telp`, `fb`, `fb_id`, `ig`, `ig_id`, `deposit`, `reward_poin`, `image`, `reg_from`, `know_from`, `umur`, `npwp`, `api_reg_date`, `api_reg_token`, `api_web_date`, `api_web_token`, `api_mobile_date`, `api_mobile_token`, `fcm_token`, `device`, `apikey`, `is_agree`, `is_confirmed`, `is_premium`, `is_wa_verified`, `is_wa_send`, `is_active`, `is_deleted`) VALUES
(72, NULL, 19, 4, '', NULL, NULL, 'qaysa78@gmail.com', 'mochammadqaysa', '', '', '$2y$10$i5KvPJOUxPjeXexVtAATZ.217qt7a8dgP635iEOmtI1S15wkdmtGO', 'Mochammad Qaysa Al-Haq', ' ', 'Margahayu Kencana', NULL, '', '', '', '', 'Indonesia', '', 1, '-', '1970-01-01', '0000-00-00 00:00:00', NULL, NULL, '085123452134', '', NULL, '', NULL, 0, 0, ' ', 'online', NULL, 20, '', NULL, NULL, NULL, NULL, NULL, NULL, ' ', 'web', '', 0, 0, 0, 1, 1, 1, 0),
(73, 0, 0, 2, '', '', NULL, 'ginda@gmail.com', 'ginda', '', '', '$2y$10$85RhTiVjIbh8KTUkbc3qDe4gJVBmFUyBUmyAx016CZV4Z212JTz6W', 'Ginda Ginanjar', '', '', '', '', '', '', '', '', '', 0, '', '0000-00-00', '0000-00-00 00:00:00', '0000-00-00', '0000-00-00', '085234139162', '', NULL, '', NULL, 0, 0, '', 'online', NULL, 0, '', '0000-00-00', '', '0000-00-00', '', '0000-00-00', '', '', '', 'Q35X5DQX4D', 0, 0, 0, 1, 1, 1, 0),
(74, NULL, 15, 5, '', NULL, NULL, '', '', '', '', NULL, 'Rijal Sutisna, AMK', ' ', '', NULL, '', '', '', '', 'Indonesia', '', 1, '-', '1970-01-01', '2022-12-23 14:55:57', NULL, NULL, '', '', NULL, '', NULL, 0, 0, ' ', 'online', NULL, 20, '', NULL, NULL, NULL, NULL, NULL, NULL, ' ', 'web', '', 0, 0, 0, 1, 1, 1, 0),
(75, NULL, 15, 5, '', NULL, NULL, '', '', '', '', NULL, 'Zr Dinda', ' ', '', NULL, '', '', '', '', 'Indonesia', '', 1, '-', '1970-01-01', '2023-02-11 15:47:44', NULL, NULL, '', '', NULL, '', NULL, 0, 0, ' ', 'online', NULL, 20, '', NULL, NULL, NULL, NULL, NULL, NULL, ' ', 'web', '', 0, 0, 0, 1, 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `c_asesmen`
--

CREATE TABLE `c_asesmen` (
  `id` int(5) NOT NULL,
  `a_jpenilaian_id` int(5) NOT NULL,
  `b_user_id_penilai` int(11) NOT NULL,
  `b_user_id` int(5) NOT NULL,
  `a_ruangan_id` int(11) NOT NULL,
  `value` text NOT NULL,
  `nilai` text NOT NULL,
  `ntype` enum('angka','persen') NOT NULL DEFAULT 'angka' COMMENT 'nilai type',
  `cdate` datetime NOT NULL,
  `durasi` decimal(18,2) NOT NULL,
  `stime` time NOT NULL,
  `etime` time NOT NULL,
  `is_active` int(1) NOT NULL DEFAULT 1,
  `is_deleted` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `c_asesmen`
--

INSERT INTO `c_asesmen` (`id`, `a_jpenilaian_id`, `b_user_id_penilai`, `b_user_id`, `a_ruangan_id`, `value`, `nilai`, `ntype`, `cdate`, `durasi`, `stime`, `etime`, `is_active`, `is_deleted`) VALUES
(3, 2, 72, 71, 15, '{\"indikator\":\"125\",\"aksi\":\"130\"}', '1', 'angka', '2022-12-21 22:38:37', '0.10', '22:27:51', '22:38:37', 1, 0),
(4, 2, 72, 68, 16, '{\"indikator\":\"128\",\"aksi\":\"131\"}', '1', 'angka', '2022-12-22 08:59:15', '0.00', '08:58:38', '08:59:15', 1, 0),
(5, 2, 72, 68, 15, '{\"indikator\":\"128\",\"aksi\":\"130\"}', '1', 'angka', '2022-12-22 09:05:27', '0.00', '09:04:50', '09:05:27', 1, 0),
(6, 2, 72, 72, 19, '{\"indikator\":\"126\",\"aksi\":\"130\"}', '1', 'angka', '2022-12-23 07:35:41', '0.00', '07:35:29', '07:35:41', 1, 0),
(7, 2, 73, 74, 15, '{\"indikator\":\"125\",\"aksi\":\"131\"}', '1', 'angka', '2022-12-23 14:55:58', '0.10', '14:54:20', '14:55:58', 1, 0),
(8, 2, 73, 74, 13, '{\"indikator\":\"128\",\"aksi\":\"130\"}', '1', 'angka', '2022-12-23 18:06:19', '0.00', '18:05:49', '18:06:19', 1, 0),
(9, 2, 73, 74, 15, '{\"indikator\":\"126\",\"aksi\":\"132\"}', '0', 'angka', '2022-12-23 18:06:47', '0.00', '18:06:26', '18:06:47', 1, 0),
(10, 2, 72, 72, 19, '{\"indikator\":\"128\",\"aksi\":\"131\"}', '1', 'angka', '2022-12-24 12:33:53', '0.10', '12:23:19', '12:33:53', 1, 0),
(11, 4, 73, 72, 14, '[{\"indikator\":\"407\",\"aksi\":\"y\"},{\"indikator\":\"408\",\"aksi\":\"y\"},{\"indikator\":\"409\",\"aksi\":\"y\"},{\"indikator\":\"410\",\"aksi\":\"y\"},{\"indikator\":\"411\",\"aksi\":\"y\"},{\"indikator\":\"412\",\"aksi\":\"y\"},{\"indikator\":\"413\",\"aksi\":\"y\"},{\"indikator\":\"414\",\"aksi\":\"y\"},{\"indikator\":\"415\",\"aksi\":\"y\"},{\"indikator\":\"416\",\"aksi\":\"y\"},{\"indikator\":\"417\",\"aksi\":\"y\"},{\"indikator\":\"418\",\"aksi\":\"y\"},{\"indikator\":\"419\",\"aksi\":\"y\"},{\"indikator\":\"420\",\"aksi\":\"y\"},{\"indikator\":\"421\",\"aksi\":\"y\"},{\"indikator\":\"422\",\"aksi\":\"y\"},{\"indikator\":\"423\",\"aksi\":\"y\"},{\"indikator\":\"424\",\"aksi\":\"y\"},{\"indikator\":\"425\",\"aksi\":\"y\"},{\"indikator\":\"426\",\"aksi\":\"y\"},{\"indikator\":\"427\",\"aksi\":\"y\"},{\"indikator\":\"428\",\"aksi\":\"y\"},{\"indikator\":\"429\",\"aksi\":\"y\"},{\"indikator\":\"430\",\"aksi\":\"y\"},{\"indikator\":\"431\",\"aksi\":\"y\"},{\"indikator\":\"432\",\"aksi\":\"y\"},{\"indikator\":\"433\",\"aksi\":\"y\"},{\"indikator\":\"434\",\"aksi\":\"y\"},{\"indikator\":\"435\",\"aksi\":\"y\"},{\"indikator\":\"436\",\"aksi\":\"y\"},{\"indikator\":\"437\",\"aksi\":\"y\"},{\"indikator\":\"438\",\"aksi\":\"y\"},{\"indikator\":\"439\",\"aksi\":\"n\"},{\"indikator\":\"440\",\"aksi\":\"y\"},{\"indikator\":\"441\",\"aksi\":\"y\"},{\"indikator\":\"442\",\"aksi\":\"y\"},{\"indikator\":\"443\",\"aksi\":\"y\"},{\"indikator\":\"444\",\"aksi\":\"y\"},{\"indikator\":\"445\",\"aksi\":\"y\"},{\"indikator\":\"446\",\"aksi\":\"y\"},{\"indikator\":\"447\",\"aksi\":\"y\"},{\"indikator\":\"448\",\"aksi\":\"y\"},{\"indikator\":\"449\",\"aksi\":\"y\"},{\"indikator\":\"450\",\"aksi\":\"y\"},{\"indikator\":\"451\",\"aksi\":\"y\"},{\"indikator\":\"456\",\"aksi\":\"y\"},{\"indikator\":\"457\",\"aksi\":\"y\"},{\"indikator\":\"458\",\"aksi\":\"y\"},{\"indikator\":\"459\",\"aksi\":\"y\"},{\"indikator\":\"460\",\"aksi\":\"y\"},{\"indikator\":\"461\",\"aksi\":\"y\"},{\"indikator\":\"462\",\"aksi\":\"y\"},{\"indikator\":\"463\",\"aksi\":\"y\"},{\"indikator\":\"464\",\"aksi\":\"y\"},{\"indikator\":\"465\",\"aksi\":\"y\"},{\"indikator\":\"466\",\"aksi\":\"y\"},{\"indikator\":\"467\",\"aksi\":\"y\"}]', '', 'angka', '2023-02-11 00:00:00', '0.20', '12:31:08', '12:33:26', 1, 0),
(12, 2, 73, 75, 15, '[{\"c_asesmen_id\":12,\"indikator\":\"125\",\"aksi\":\"132\"},{\"c_asesmen_id\":12,\"indikator\":\"126\",\"aksi\":\"131\"},{\"c_asesmen_id\":12,\"indikator\":\"126\",\"aksi\":\"131\"},{\"c_asesmen_id\":12,\"indikator\":\"128\",\"aksi\":\"130\"},{\"c_asesmen_id\":12,\"indikator\":\"126\",\"aksi\":\"131\"},{\"c_asesmen_id\":12,\"indikator\":\"125\",\"aksi\":\"132\"},{\"c_asesmen_id\":12,\"indikator\":\"126\",\"aksi\":\"133\"},{\"c_asesmen_id\":12,\"indikator\":\"128\",\"aksi\":\"131\"},{\"c_asesmen_id\":12,\"indikator\":\"125\",\"aksi\":\"133\"},{\"c_asesmen_id\":12,\"indikator\":\"128\",\"aksi\":\"130\"}]', '6', 'angka', '2023-02-11 15:48:14', '0.00', '15:48:06', '15:48:14', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `c_survei`
--

CREATE TABLE `c_survei` (
  `id` int(11) NOT NULL,
  `a_ruangan_id` int(11) NOT NULL,
  `b_user_id` int(11) NOT NULL,
  `cdate` date NOT NULL,
  `tgl_masuk` date NOT NULL,
  `diagnosa_masuk` varchar(255) NOT NULL,
  `b_pasien_id` int(11) NOT NULL,
  `b_user_id_dokter` int(11) NOT NULL,
  `faktor_resiko` text NOT NULL,
  `monitoring` text NOT NULL,
  `isk` text NOT NULL,
  `ido` text NOT NULL,
  `pemakaian_antibiotik` text NOT NULL,
  `b_user_id_kepala_ruangan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `d_value`
--

CREATE TABLE `d_value` (
  `id` int(11) NOT NULL,
  `c_asesmen_id` int(11) NOT NULL,
  `indikator` varchar(128) NOT NULL,
  `aksi` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `d_value`
--

INSERT INTO `d_value` (`id`, `c_asesmen_id`, `indikator`, `aksi`) VALUES
(11, 12, '125', '132'),
(12, 12, '126', '131'),
(13, 12, '126', '131'),
(14, 12, '128', '130'),
(15, 12, '126', '131'),
(16, 12, '125', '132'),
(17, 12, '126', '133'),
(18, 12, '128', '131'),
(19, 12, '125', '133'),
(20, 12, '128', '130');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `a_indikator`
--
ALTER TABLE `a_indikator`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `a_jabatan`
--
ALTER TABLE `a_jabatan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `a_jpenilaian`
--
ALTER TABLE `a_jpenilaian`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `a_modules`
--
ALTER TABLE `a_modules`
  ADD PRIMARY KEY (`identifier`),
  ADD KEY `children_identifier` (`children_identifier`);

--
-- Indexes for table `a_pengguna`
--
ALTER TABLE `a_pengguna`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `a_pengguna_username_unq` (`username`),
  ADD KEY `a_company_id` (`a_company_id`),
  ADD KEY `a_jabatan_id` (`a_jabatan_id`),
  ADD KEY `nip` (`nip`);

--
-- Indexes for table `a_pengguna_module`
--
ALTER TABLE `a_pengguna_module`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fka_modules_identifier` (`a_modules_identifier`);

--
-- Indexes for table `a_rs`
--
ALTER TABLE `a_rs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `a_ruangan`
--
ALTER TABLE `a_ruangan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`a_rs_id`) USING BTREE;

--
-- Indexes for table `a_unit`
--
ALTER TABLE `a_unit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `b_pasien`
--
ALTER TABLE `b_pasien`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `b_user`
--
ALTER TABLE `b_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_api_web_token` (`api_web_token`),
  ADD KEY `kode` (`kode`),
  ADD KEY `a_company_id` (`a_unit_id`),
  ADD KEY `a_departemen_id` (`a_jabatan_id`),
  ADD KEY `a_pengguna_id` (`b_user_id`),
  ADD KEY `idx_is_active` (`google_id`),
  ADD KEY `idx_is_confirmed` (`kode_lama`);

--
-- Indexes for table `c_asesmen`
--
ALTER TABLE `c_asesmen`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `c_survei`
--
ALTER TABLE `c_survei`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `d_value`
--
ALTER TABLE `d_value`
  ADD PRIMARY KEY (`id`),
  ADD KEY `c_asesmen_id` (`c_asesmen_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `a_indikator`
--
ALTER TABLE `a_indikator`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=481;

--
-- AUTO_INCREMENT for table `a_jabatan`
--
ALTER TABLE `a_jabatan`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `a_jpenilaian`
--
ALTER TABLE `a_jpenilaian`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `a_pengguna`
--
ALTER TABLE `a_pengguna`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=404;

--
-- AUTO_INCREMENT for table `a_pengguna_module`
--
ALTER TABLE `a_pengguna_module`
  MODIFY `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3195;

--
-- AUTO_INCREMENT for table `a_rs`
--
ALTER TABLE `a_rs`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `a_ruangan`
--
ALTER TABLE `a_ruangan`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `a_unit`
--
ALTER TABLE `a_unit`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `b_pasien`
--
ALTER TABLE `b_pasien`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `b_user`
--
ALTER TABLE `b_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `c_asesmen`
--
ALTER TABLE `c_asesmen`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `c_survei`
--
ALTER TABLE `c_survei`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `d_value`
--
ALTER TABLE `d_value`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `a_modules`
--
ALTER TABLE `a_modules`
  ADD CONSTRAINT `a_modules_ibfk_1` FOREIGN KEY (`children_identifier`) REFERENCES `a_modules` (`identifier`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `a_pengguna_module`
--
ALTER TABLE `a_pengguna_module`
  ADD CONSTRAINT `a_pengguna_module_ibfk_2` FOREIGN KEY (`a_modules_identifier`) REFERENCES `a_modules` (`identifier`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
