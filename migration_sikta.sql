-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 23, 2017 at 10:02 AM
-- Server version: 10.2.3-MariaDB-log
-- PHP Version: 5.6.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `migration_sikta`
--

-- --------------------------------------------------------

--
-- Table structure for table `acara`
--

CREATE TABLE `acara` (
  `tahunak` mediumint(5) NOT NULL,
  `mulai` datetime NOT NULL,
  `berakhir` datetime NOT NULL,
  `detail` varchar(250) NOT NULL,
  `penanggungjawab` varchar(75) NOT NULL,
  `ruang` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `acara`
--

INSERT INTO `acara` (`tahunak`, `mulai`, `berakhir`, `detail`, `penanggungjawab`, `ruang`) VALUES
(20162, '2017-03-22 12:17:00', '2017-03-22 13:17:00', 'gfdgfgdfgdfg', 'dfgdfgdfgdfg', 1),
(20162, '2017-03-22 12:17:00', '2017-03-22 13:17:00', 'ffffffffffffffffffffffffffffffffff', 'kkkkkkkkkkkkkkkkkkkkkkkkk', 2),
(20162, '2017-04-19 07:59:00', '2017-04-19 15:59:00', 'Seminar Nasional', 'Pak Ragil', 1),
(20162, '2017-04-21 12:00:00', '2017-04-21 15:17:00', 'Rapat Koordinasi', 'Panji', 2),
(20162, '2017-05-23 13:33:00', '2017-05-23 16:36:00', 'Percobaan di mateatika', 'jafar abdurrahman', 3),
(20162, '2017-05-24 12:17:00', '2017-05-24 17:17:00', 'wwdsdsd', 'sdsdsd', 2),
(20162, '2017-05-25 10:17:00', '2017-05-25 12:17:00', 'Rapat Dosen', 'jaksja ksjak sjak sjkasj', 4),
(20162, '2017-05-30 08:44:00', '2017-05-30 10:42:00', 'dgdfgd fdgf', 'dgdfg dfgdfgdg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `identified` varchar(29) NOT NULL,
  `email` varchar(75) NOT NULL,
  `nohp` varchar(15) NOT NULL,
  `tasdurasi` smallint(3) NOT NULL,
  `taddurasi` smallint(3) NOT NULL,
  `kajur` varchar(29) NOT NULL,
  `wakil` varchar(29) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `nip` bigint(20) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`identified`, `email`, `nohp`, `tasdurasi`, `taddurasi`, `kajur`, `wakil`, `nama`, `alamat`, `nip`, `status`) VALUES
('A&&SIKTA<>2016+09-11#24?56/56', 'admin@emil.com', '8386997111', 210, 120, 'D&&SIKTA<>2017+03-21#16?10/34', 'D&&SIKTA<>2017+04-05#18?03/00', 'Annisa', '978565765746456465', 978565765746456465, 1);

-- --------------------------------------------------------

--
-- Table structure for table `dataproses`
--

CREATE TABLE `dataproses` (
  `id` tinyint(1) NOT NULL,
  `detail` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dataproses`
--

INSERT INTO `dataproses` (`id`, `detail`) VALUES
(1, 'Menunggu'),
(2, 'Disetujui'),
(3, 'Ditolak');

-- --------------------------------------------------------

--
-- Table structure for table `guru`
--

CREATE TABLE `guru` (
  `identified` varchar(29) NOT NULL,
  `nip` bigint(20) NOT NULL,
  `bidangriset` varchar(100) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `email` varchar(75) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `nohp` varchar(15) NOT NULL,
  `kodkel` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `guru`
--

INSERT INTO `guru` (`identified`, `nip`, `bidangriset`, `alamat`, `nama`, `email`, `status`, `nohp`, `kodkel`) VALUES
('D&&SIKTA<>2017+03-21#16?08/00', 9223372036854775807, '', '', 'Jafar Abdurrahman', '', 1, '', 0),
('D&&SIKTA<>2017+03-21#16?10/34', 922337203685477577, '', '', 'Rachmat Fidel', '', 1, '', 0),
('D&&SIKTA<>2017+04-05#18?03/00', 195206101983032001, '', '', 'Dra.Indriyati', '', 1, '', 0),
('D&&SIKTA<>2017+04-05#18?03/23', 195412191980031003, 'RPL', 'jalan alamant 56', 'Drs. Djalal Er Riyanto, M.IKom.', 'djalal@mail.com', 1, '083869970670', 0),
('D&&SIKTA<>2017+04-05#18?03/45', 195504071983031003, '', '', 'Drs. Suhartono, M.Komp', '', 1, '', 0),
('D&&SIKTA<>2017+04-05#18?05/11', 196511071992031003, '', '', 'Drs. Eko Adi Sarwoko,M.Kom.', '', 1, '', 0),
('D&&SIKTA<>2017+04-05#18?05/28', 197007051997021001, '', '', 'Priyo Sidik S,S.Si.,M.Kom', '', 1, '', 0),
('D&&SIKTA<>2017+04-05#18?05/49', 197404011999031002, '', '', 'Dr. Aris Puji Widodo, S.Si, MT', '', 1, '', 0),
('D&&SIKTA<>2017+04-05#18?06/13', 197805022005012002, '', '', 'Sukmawati Nur Endah M.Kom', '', 1, '', 2),
('D&&SIKTA<>2017+04-05#18?06/48', 198203092006041002, '', '', 'Dr. Eng. Adi Wibowo, S.Si., M.Kom', '', 1, '', 0),
('D&&SIKTA<>2017+04-05#18?07/01', 198104212008121002, '', '', 'Panji Wisnu Wirawan, ST,MT', '', 1, '', 0),
('D&&SIKTA<>2017+04-05#18?07/16', 198104202005012001, 'SC, Komdas', 'jalan ruam', 'Dr. Retno Kusumaningrum, S.Si, M.Kom', 'test@gmail.com', 1, '0878298781827', 2);

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` tinyint(1) NOT NULL,
  `detail` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `detail`) VALUES
(1, 'Baru'),
(2, 'Melanjutkan');

-- --------------------------------------------------------

--
-- Table structure for table `kejadian`
--

CREATE TABLE `kejadian` (
  `identified` varchar(29) NOT NULL,
  `tahunak` mediumint(5) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `mulai` date NOT NULL,
  `berakhir` date NOT NULL,
  `kode` tinyint(2) NOT NULL,
  `judul` varchar(100) NOT NULL,
  `isi` varchar(350) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kejadian`
--

INSERT INTO `kejadian` (`identified`, `tahunak`, `status`, `mulai`, `berakhir`, `kode`, `judul`, `isi`) VALUES
('E((SIKTA((2017(03(21/12)11)52', 20162, 1, '2017-03-22', '2017-04-26', 1, 'Regisrasi baru', 'hello jafar'),
('E((SIKTA((2017(03(21/12)27)22', 20162, 1, '2017-03-26', '2017-03-26', 3, 'sdsdsds sd sd', 'd sd sd sds d'),
('E((SIKTA((2017(03(22/10)27)05', 20162, 1, '2017-03-22', '2017-03-22', 3, 'asasasa sa s as a sa s', 'sdsdsdsds ds ds ds dsdsdsdsd'),
('E((SIKTA((2017(03(22/10)39)38', 20162, 1, '2017-03-26', '2017-03-26', 3, 'koksosko dksodksodk so', 'kjsd skdjks dks jdksjdk sdjk'),
('E((SIKTA((2017(03(26/16)23)57', 20162, 1, '2017-03-26', '2017-03-26', 3, 'sadads d ad', 'sdfsfsdf sdf sfs fsd');

-- --------------------------------------------------------

--
-- Table structure for table `koordinator`
--

CREATE TABLE `koordinator` (
  `identified` varchar(29) NOT NULL,
  `dosenk` varchar(29) NOT NULL,
  `startganjil` varchar(5) NOT NULL,
  `startgenap` varchar(5) NOT NULL,
  `mulai` datetime NOT NULL,
  `berakhir` datetime NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `koordinator`
--

INSERT INTO `koordinator` (`identified`, `dosenk`, `startganjil`, `startgenap`, `mulai`, `berakhir`, `status`) VALUES
('K&&SIKTA<>2016+09-99#24?56/56', '', '6|1', '11|1', '2017-01-16 07:23:53', '2017-03-22 11:03:39', 2),
('K&&SIKTA<>2016+09-99#24?56/56', 'D&&SIKTA<>2017+03-21#16?08/00', '6|1', '11|1', '2017-03-22 11:03:39', '2017-03-22 11:04:03', 2),
('K&&SIKTA<>2016+09-99#24?56/56', 'D&&SIKTA<>2017+03-21#16?10/34', '6|1', '11|1', '2017-03-22 11:04:03', '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `minat`
--

CREATE TABLE `minat` (
  `id` tinyint(1) NOT NULL,
  `detail` varchar(24) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `minat`
--

INSERT INTO `minat` (`id`, `detail`) VALUES
(1, 'Rekayasa Perangkat Lunak'),
(2, 'Sistem Informasi'),
(3, 'Sistem Cerdas'),
(4, 'Komputasi');

-- --------------------------------------------------------

--
-- Table structure for table `murid`
--

CREATE TABLE `murid` (
  `identified` varchar(29) NOT NULL,
  `nim` varchar(14) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `nohp` varchar(15) NOT NULL,
  `aktiftahun` smallint(5) NOT NULL,
  `namaorangtua` varchar(50) NOT NULL,
  `nohporangtua` varchar(15) NOT NULL,
  `formbaru` tinyint(1) NOT NULL DEFAULT 1,
  `registrasilama` tinyint(1) NOT NULL DEFAULT 2,
  `registrasibaru` tinyint(1) NOT NULL DEFAULT 2,
  `namafoto` varchar(30) NOT NULL,
  `namatranskrip` varchar(35) NOT NULL,
  `kodecookie` varchar(50) NOT NULL,
  `dosens` varchar(29) NOT NULL,
  `dosend` varchar(29) NOT NULL,
  `dosent` varchar(29) NOT NULL,
  `tanpawaktu` tinyint(1) NOT NULL DEFAULT 2,
  `waktucookie` datetime NOT NULL,
  `minat` tinyint(1) NOT NULL,
  `dosenrespon` varchar(29) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `murid`
--

INSERT INTO `murid` (`identified`, `nim`, `nama`, `email`, `status`, `nohp`, `aktiftahun`, `namaorangtua`, `nohporangtua`, `formbaru`, `registrasilama`, `registrasibaru`, `namafoto`, `namatranskrip`, `kodecookie`, `dosens`, `dosend`, `dosent`, `tanpawaktu`, `waktucookie`, `minat`, `dosenrespon`) VALUES
('M&&SIKTA<>2017+03-17#11?46/58', '24010313130125', 'jafar abdurrahman albasyir', 'jafarabdurrahmanalbasyir@gmail.com', 2, '083869970670', 20162, '', '', 1, 1, 1, '24010313130125-foto.jpg', '24010313130125-transkrip.pdf', '1c34a5bb8392e51551dcb9a53476a19e', '', '', '', 2, '2017-03-18 09:40:20', 0, ''),
('M&&SIKTA<>2017+03-17#14?07/10', '24010313130126', 'rizaldi wiratama', 'rizaldi@momo.com', 2, '083869970670', 20162, '', '', 1, 2, 2, '24010313130126-foto.jpg', '24010313130126-transkrip.pdf', 'b520649f78c64abfc208e33317c051e3', '', '', '', 2, '0000-00-00 00:00:00', 0, ''),
('M&&SIKTA<>2017+03-17#14?11/27', '24010313130127', 'ikhsan wisnuaji', 'ikhsanwisnu@gmail.com', 2, '083869970670', 20162, '', '', 1, 1, 1, '24010313130127-foto.jpg', '24010313130127-transkrip.pdf', 'f8c8bd10492e08330b654d4a283c4474', '', '', '', 2, '0000-00-00 00:00:00', 0, ''),
('M&&SIKTA<>2017+03-24#22?23/30', '24010313130128', 'test', 'test@test.com', 1, '083869970670', 20162, 'asas', '083869970670', 2, 2, 2, '24010313130128-foto.png', '24010313130128-transkrip.pdf', '50d0acd9a31ccf6dedc9f14d4eb809cd', 'D&&SIKTA<>2017+03-21#16?10/34', 'D&&SIKTA<>2017+04-05#18?03/23', '', 2, '0000-00-00 00:00:00', 1, 'D&&SIKTA<>2017+04-05#18?03/23'),
('M&&SIKTA<>2017+03-27#18?55/08', '24010313130129', 'test ddd', 'test.s@sss.dd', 1, '083869970670', 20162, 'aminah', '083869970670', 2, 2, 2, '24010313130129-foto.jpg', '24010313130129-transkrip.pdf', 'febcb60a2e57d2343df25ee8f654753b', 'D&&SIKTA<>2017+04-05#18?05/11', 'D&&SIKTA<>2017+04-05#18?03/00', 'D&&SIKTA<>2017+03-21#16?08/00', 2, '2017-05-23 07:43:48', 1, ''),
('M&&SIKTA<>2017+05-08#07?42/18', '24010313130123', 'Superman and Batman', 'supbat@gmail.com', 1, '0838699707872', 20162, '', '', 1, 2, 2, '24010313130123-foto.png', '24010313130123-transkrip.pdf', 'ea3140b6a02942d654bb82c4a0f5ce86', '', '', '', 2, '0000-00-00 00:00:00', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `identified` varchar(29) NOT NULL,
  `nickname` varchar(32) NOT NULL,
  `keyword` varchar(32) NOT NULL,
  `failedlogin` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`identified`, `nickname`, `keyword`, `failedlogin`) VALUES
('A&&SIKTA<>2016+09-11#24?56/56', '645188d758645c887fc8dd9e95c5510b', '2fabd75b2f7272940192801c26a849ac', 0),
('D&&SIKTA<>2017+03-21#16?08/00', '1b9d366e18f4cf00e83dfdb58813f88b', '269f1a75455656507a7b9dff02657f20', 0),
('D&&SIKTA<>2017+03-21#16?10/34', '7db7b919acb1bfbc21dd73944d618983', '269f1a75455656507a7b9dff02657f20', 0),
('D&&SIKTA<>2017+04-05#18?03/00', '650c3387863a535baff7694d52d495d5', '269f1a75455656507a7b9dff02657f20', 0),
('D&&SIKTA<>2017+04-05#18?03/23', '0e5247276bb4ec7173e5ff142e3e819f', '7e8c9a31a0d357c44553af8a57935318', 0),
('D&&SIKTA<>2017+04-05#18?03/45', '1423e53427c566243f9382fb2ee5ecfd', '269f1a75455656507a7b9dff02657f20', 0),
('D&&SIKTA<>2017+04-05#18?05/11', '0e7b8e80a1eab82ec2523c33de4988b0', '269f1a75455656507a7b9dff02657f20', 0),
('D&&SIKTA<>2017+04-05#18?05/28', 'd6e2042c70818a553cc15d032244794e', '269f1a75455656507a7b9dff02657f20', 0),
('D&&SIKTA<>2017+04-05#18?05/49', '013d4101d9539d892c6a45871d8b1c34', '269f1a75455656507a7b9dff02657f20', 0),
('D&&SIKTA<>2017+04-05#18?06/13', 'f4dfa74ec32207d1e27a23124653d473', '269f1a75455656507a7b9dff02657f20', 0),
('D&&SIKTA<>2017+04-05#18?06/48', '7bfa7b3d865f74e03c39b7cbe1625d48', '269f1a75455656507a7b9dff02657f20', 0),
('D&&SIKTA<>2017+04-05#18?07/01', '5cc67ac45d6f6279b2b237ae8acebb3d', '269f1a75455656507a7b9dff02657f20', 0),
('D&&SIKTA<>2017+04-05#18?07/16', '97c2124006ea270ef7485107b2e7b323', '269f1a75455656507a7b9dff02657f20', 0),
('K&&SIKTA<>2016+09-11#24?56/56', '6e85024b4fcf8090b36f3eb408ad66a8', '2d67d83a7f67ef8599e9ee2a9e690016', 0),
('M&&SIKTA<>2017+03-17#11?46/58', 'cf6e3e407a450638cd74d4bd8bb89cf9', '0ee805c1e9c7fa5b11e796b4659f9f30', 0),
('M&&SIKTA<>2017+03-17#14?07/10', 'cf63da926dd8ff1e1725515012fbbb90', '2f924b264622398cdcc6688f0ab12ad2', 0),
('M&&SIKTA<>2017+03-17#14?11/27', 'd9698bace412dec486b9c62312b0826e', '1eb7e4ebba05fbc91892a9a1effa9c88', 0),
('M&&SIKTA<>2017+03-24#22?23/30', '3356eb30bfd515ecd9c247b4db804512', '94533099997a665fd5ac86385c784d73', 0),
('M&&SIKTA<>2017+03-27#18?55/08', '9fb766850c9ffcd12086fecf3fb953f0', '94533099997a665fd5ac86385c784d73', 0),
('M&&SIKTA<>2017+05-08#07?42/18', '19ff878129e68f8270a29cecf8130667', 'ddfbdf364a2401376c4afb1184f4f798', 0);

-- --------------------------------------------------------

--
-- Table structure for table `registrasi`
--

CREATE TABLE `registrasi` (
  `tahunak` mediumint(5) NOT NULL,
  `mahasiswa` varchar(29) NOT NULL,
  `dosen` varchar(29) NOT NULL,
  `judulta` varchar(200) NOT NULL,
  `metode` varchar(200) NOT NULL,
  `refs` varchar(200) NOT NULL,
  `refd` varchar(200) NOT NULL,
  `reft` varchar(200) NOT NULL,
  `lokasi` varchar(150) NOT NULL,
  `namakrs` varchar(46) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `datastatus` tinyint(1) NOT NULL DEFAULT 0,
  `kategori` tinyint(1) NOT NULL DEFAULT 0,
  `dataproses` tinyint(1) NOT NULL DEFAULT 0,
  `pesan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `registrasi`
--

INSERT INTO `registrasi` (`tahunak`, `mahasiswa`, `dosen`, `judulta`, `metode`, `refs`, `refd`, `reft`, `lokasi`, `namakrs`, `status`, `datastatus`, `kategori`, `dataproses`, `pesan`) VALUES
(20162, 'M&&SIKTA<>2017+03-24#22?23/30', 'D&&SIKTA<>2017+04-05#18?03/23', 'Sistem Informasi Kegiatan Tugas Akhir', 'OOAD', 'Sistem Informasi Tugas Akhir', '', '', 'Semarang Selatan', '20162ac4d00d53bf8d1865ce30af24dacd7701KR5.pdf', 1, 0, 2, 2, 'melakukan pergantian dosen oleh koordinator'),
(20162, 'M&&SIKTA<>2017+03-24#22?23/30', '', 'Sistem Informasi Kegiatan Tugas Akhir', 'OOAD', 'Sistem Informasi Tugas Akhir', '', '', 'Semarang Selatan', '20162ac4d00d53bf8d1865ce30af24dacd7700KR5.pdf', 2, 1, 1, 1, ''),
(20162, 'M&&SIKTA<>2017+03-24#22?23/30', 'D&&SIKTA<>2017+03-21#16?10/34', 'Sistem Informasi Kegiatan Tugas Akhir', 'OOAD', 'Sistem Informasi Tugas Akhir', '', '', 'Semarang Selatan', '20162ac4d00d53bf8d1865ce30af24dacd7701KR5.pdf', 2, 2, 2, 1, ''),
(20162, 'M&&SIKTA<>2017+03-24#22?23/30', 'D&&SIKTA<>2017+03-21#16?10/34', 'Sistem Informasi Kegiatan Tugas Akhir', 'OOAD', 'Sistem Informasi Tugas Akhir', '', '', 'Semarang Selatan', '20162ac4d00d53bf8d1865ce30af24dacd7701KR5.pdf', 2, 3, 2, 1, ''),
(20162, 'M&&SIKTA<>2017+03-24#22?23/30', 'D&&SIKTA<>2017+03-21#16?10/34', 'Sistem Informasi Kegiatan Tugas Akhir', 'OOAD', 'Sistem Informasi Tugas Akhir', '', '', 'Semarang Selatan', '20162ac4d00d53bf8d1865ce30af24dacd7701KR5.pdf', 2, 4, 2, 2, ''),
(20162, 'M&&SIKTA<>2017+03-24#22?23/30', 'D&&SIKTA<>2017+04-05#18?03/45', 'Sistem Informasi Kegiatan Tugas Akhir', 'OOAD', 'Sistem Informasi Tugas Akhir', '', '', 'Semarang Selatan', '20162ac4d00d53bf8d1865ce30af24dacd7701KR5.pdf', 2, 5, 2, 1, ''),
(20162, 'M&&SIKTA<>2017+03-24#22?23/30', 'D&&SIKTA<>2017+04-05#18?03/23', 'Sistem Informasi Kegiatan Tugas Akhir', 'OOAD', 'Sistem Informasi Tugas Akhir', '', '', 'Semarang Selatan', '20162ac4d00d53bf8d1865ce30af24dacd7701KR5.pdf', 2, 6, 2, 1, ''),
(20162, 'M&&SIKTA<>2017+03-24#22?23/30', 'D&&SIKTA<>2017+04-05#18?06/48', 'Sistem Informasi Kegiatan Tugas Akhir', 'OOAD', 'Sistem Informasi Tugas Akhir', '', '', 'Semarang Selatan', '20162ac4d00d53bf8d1865ce30af24dacd7701KR5.pdf', 2, 7, 2, 1, 'melakukan pergantian dosen oleh koordinator'),
(20162, 'M&&SIKTA<>2017+03-24#22?23/30', 'D&&SIKTA<>2017+04-05#18?03/23', 'Sistem Informasi Kegiatan Tugas Akhir', 'OOAD', 'Sistem Informasi Tugas Akhir', '', '', 'Semarang Selatan', '20162ac4d00d53bf8d1865ce30af24dacd7701KR5.pdf', 2, 8, 2, 1, 'melakukan pergantian dosen oleh koordinator'),
(20162, 'M&&SIKTA<>2017+03-24#22?23/30', 'D&&SIKTA<>2017+04-05#18?03/23', 'Sistem Informasi Kegiatan Tugas Akhir', 'OOAD', 'Sistem Informasi Tugas Akhir', '', '', 'Semarang Selatan', '20162ac4d00d53bf8d1865ce30af24dacd7701KR5.pdf', 2, 9, 2, 1, 'melakukan pergantian dosen oleh koordinator'),
(20162, 'M&&SIKTA<>2017+03-24#22?23/30', 'D&&SIKTA<>2017+04-05#18?03/23', 'Sistem Informasi Kegiatan Tugas Akhir', 'OOAD', 'Sistem Informasi Tugas Akhir', '', '', 'Semarang Selatan', '20162ac4d00d53bf8d1865ce30af24dacd7701KR5.pdf', 2, 10, 2, 1, 'melakukan pergantian dosen oleh koordinator'),
(20162, 'M&&SIKTA<>2017+03-24#22?23/30', 'D&&SIKTA<>2017+04-05#18?03/23', 'Sistem Informasi Kegiatan Tugas Akhir', 'OOAD', 'Sistem Informasi Tugas Akhir', '', '', 'Semarang Selatan', '20162ac4d00d53bf8d1865ce30af24dacd7701KR5.pdf', 2, 11, 2, 1, 'melakukan pergantian dosen oleh koordinator'),
(20162, 'M&&SIKTA<>2017+03-24#22?23/30', 'D&&SIKTA<>2017+04-05#18?03/23', 'Sistem Informasi Kegiatan Tugas Akhir', 'OOAD', 'Sistem Informasi Tugas Akhir', '', '', 'Semarang Selatan', '20162ac4d00d53bf8d1865ce30af24dacd7701KR5.pdf', 2, 12, 2, 1, 'melakukan pergantian dosen oleh koordinator'),
(20162, 'M&&SIKTA<>2017+03-27#18?55/08', 'D&&SIKTA<>2017+03-21#16?10/34', 'Sistem Informasi Kegiatan Tugas Akhir Informatik sdsdsd', 'OOAD klklklk', 'Sistem Informasi Tugas Akhir', 'OOAD Mike Odherty', 'knknn k kn', 'Semarang', '20162bb4e2bd15dffbb7a2f3b62bf6268153b0KR5.pdf', 1, 0, 1, 2, ''),
(20162, 'M&&SIKTA<>2017+03-27#18?55/08', 'D&&SIKTA<>2017+03-21#16?10/34', 'Sistem Informasi Kegiatan Tugas Akhir Informatik sdsdsd', 'OOAD klklklk', 'Sistem Informasi Tugas Akhir', 'OOAD Mike Odherty', 'knknn k kn', 'Semarang', '20162bb4e2bd15dffbb7a2f3b62bf6268153b0KR5.pdf', 2, 1, 1, 1, ''),
(20162, 'M&&SIKTA<>2017+03-27#18?55/08', 'D&&SIKTA<>2017+03-21#16?10/34', 'Sistem Informasi Kegiatan Tugas Akhir Informatik sdsdsd', 'OOAD klklklk', 'Sistem Informasi Tugas Akhir', 'OOAD Mike Odherty', 'knknn k kn', 'Semarang', '20162bb4e2bd15dffbb7a2f3b62bf6268153b0KR5.pdf', 2, 2, 1, 1, ''),
(20162, 'M&&SIKTA<>2017+03-27#18?55/08', 'D&&SIKTA<>2017+03-21#16?10/34', 'Sistem Informasi Kegiatan Tugas Akhir Informatik sdsdsd', 'OOAD klklklk', 'Sistem Informasi Tugas Akhir', 'OOAD Mike Odherty', 'knknn k kn', 'Semarang', '20162bb4e2bd15dffbb7a2f3b62bf6268153b0KR5.pdf', 2, 3, 1, 2, '');

-- --------------------------------------------------------

--
-- Table structure for table `ruang`
--

CREATE TABLE `ruang` (
  `id` tinyint(1) NOT NULL,
  `detail` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ruang`
--

INSERT INTO `ruang` (`id`, `detail`) VALUES
(1, 'Ruang Seminar Informatika'),
(2, 'Ruang Sidang Informatika'),
(3, 'Ruang Seminar Matematika'),
(4, 'Ruang Puspital');

-- --------------------------------------------------------

--
-- Table structure for table `seminar`
--

CREATE TABLE `seminar` (
  `tahunak` mediumint(5) NOT NULL,
  `mahasiswa` varchar(29) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `datastatus` tinyint(1) NOT NULL DEFAULT 0,
  `dataproses` tinyint(1) NOT NULL,
  `karbim` varchar(35) NOT NULL,
  `karfolsem` varchar(35) NOT NULL,
  `ruang` tinyint(1) NOT NULL,
  `waktu` datetime NOT NULL DEFAULT '1000-01-01 00:00:00',
  `waktuend` datetime NOT NULL,
  `fujs` varchar(35) NOT NULL,
  `fujd` varchar(35) NOT NULL,
  `fujt` varchar(35) NOT NULL,
  `rekomendasi` tinyint(1) NOT NULL DEFAULT 0,
  `nilai` tinyint(1) NOT NULL,
  `kosurun` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `seminar`
--

INSERT INTO `seminar` (`tahunak`, `mahasiswa`, `status`, `datastatus`, `dataproses`, `karbim`, `karfolsem`, `ruang`, `waktu`, `waktuend`, `fujs`, `fujd`, `fujt`, `rekomendasi`, `nilai`, `kosurun`) VALUES
(20162, 'M&&SIKTA<>2017+03-24#22?23/30', 1, 0, 2, '20162-24010313130128-0-krtbm.png', '20162-24010313130128-0-krtta.png', 1, '2017-05-30 10:46:00', '2017-05-30 14:16:00', '20162-24010313130128-0-pngtr.pdf', '', '', 2, 0, 'NO.22/.UND.0.9/III/2017'),
(20162, 'M&&SIKTA<>2017+03-27#18?55/08', 1, 0, 1, '20162-24010313130129-0-krtbm.png', '20162-24010313130129-0-krtta.png', 1, '2017-06-01 12:17:00', '2017-06-01 15:47:00', '20162-24010313130129-0-pngtr.pdf', '', '', 2, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `sidang`
--

CREATE TABLE `sidang` (
  `tahunak` mediumint(5) NOT NULL,
  `mahasiswa` varchar(29) NOT NULL,
  `dosens` varchar(29) NOT NULL,
  `dosend` varchar(29) NOT NULL,
  `dosent` varchar(29) NOT NULL,
  `fujdp` varchar(35) NOT NULL,
  `fujds` varchar(35) NOT NULL,
  `fujdd` varchar(35) NOT NULL,
  `fujdt` varchar(35) NOT NULL,
  `fujdl` varchar(35) NOT NULL,
  `namatranskrip` varchar(35) NOT NULL,
  `toefl` varchar(35) NOT NULL,
  `namakrs` varchar(35) NOT NULL,
  `karbim` varchar(35) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `datastatus` tinyint(1) NOT NULL,
  `dataprosess` tinyint(1) NOT NULL DEFAULT 1,
  `dataprosesd` tinyint(1) NOT NULL DEFAULT 1,
  `rekomendasi` tinyint(1) NOT NULL,
  `nilai` tinyint(1) NOT NULL,
  `waktu` datetime NOT NULL DEFAULT '1000-01-01 00:00:00',
  `waktuend` datetime NOT NULL,
  `ruang` tinyint(1) NOT NULL,
  `kosurun` varchar(40) NOT NULL,
  `kosurtug` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sidang`
--

INSERT INTO `sidang` (`tahunak`, `mahasiswa`, `dosens`, `dosend`, `dosent`, `fujdp`, `fujds`, `fujdd`, `fujdt`, `fujdl`, `namatranskrip`, `toefl`, `namakrs`, `karbim`, `status`, `datastatus`, `dataprosess`, `dataprosesd`, `rekomendasi`, `nilai`, `waktu`, `waktuend`, `ruang`, `kosurun`, `kosurtug`) VALUES
(20162, 'M&&SIKTA<>2017+03-24#22?23/30', 'D&&SIKTA<>2017+04-05#18?06/48', 'D&&SIKTA<>2017+04-05#18?05/49', '', '20162-24010313130128-0-fuj20.pdf', '20162-24010313130128-0-fuj21.pdf', '', '', '20162-24010313130128-0-fuj25.pdf', '20162-24010313130128-0-trans.pdf', '20162-24010313130128-0-toefl.pdf', '20162-24010313130128-0-krs.pdf', '20162-24010313130128-0-karbi.pdf', 1, 0, 2, 2, 2, 0, '2017-05-30 14:17:00', '2017-05-30 16:17:00', 1, 'NO.04/UND/III/nsm.23/2017', 'NO.04a/UND/III/nsm.23/2017'),
(20162, 'M&&SIKTA<>2017+03-27#18?55/08', 'D&&SIKTA<>2017+04-05#18?06/13', 'D&&SIKTA<>2017+04-05#18?07/16', '', '20162-24010313130129-0-fuj20.pdf', '20162-24010313130129-0-fuj21.pdf', '', '', '20162-24010313130129-0-fuj25.pdf', '20162-24010313130129-0-trans.pdf', '20162-24010313130129-0-toefl.pdf', '20162-24010313130129-0-krs.pdf', '20162-24010313130129-0-karbi.pdf', 1, 0, 2, 2, 2, 1, '2017-05-25 07:56:00', '2017-05-25 09:56:00', 4, 'N098/UND/III.//78/2017', 'N098a/UND/III.//78/2017');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `id` tinyint(1) NOT NULL,
  `detail` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `detail`) VALUES
(1, 'Aktif'),
(2, 'Sejarah');

-- --------------------------------------------------------

--
-- Table structure for table `uploadkoordinator`
--

CREATE TABLE `uploadkoordinator` (
  `identified` varchar(29) NOT NULL,
  `detail` varchar(1024) NOT NULL,
  `namadata` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `uploadkoordinator`
--

INSERT INTO `uploadkoordinator` (`identified`, `detail`, `namadata`) VALUES
('U((SIKTA((2017(03(24/09)05)12', 'koaksoaskao sa skoaso', '4e7764b567cc59c64874e4e4d16bd72e2097d5ae2c07c9291506568a90b1dd33.pdf'),
('U((SIKTA((2017(05(07/21)20)30', 'ini kuis guru', '8f9b08987b1487341bdba8cddd43ea580d2378a797030f9c0a0dc106b8dd399b.xlsx');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `acara`
--
ALTER TABLE `acara`
  ADD PRIMARY KEY (`tahunak`,`mulai`,`berakhir`,`ruang`);

--
-- Indexes for table `dataproses`
--
ALTER TABLE `dataproses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`identified`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kejadian`
--
ALTER TABLE `kejadian`
  ADD PRIMARY KEY (`identified`);

--
-- Indexes for table `koordinator`
--
ALTER TABLE `koordinator`
  ADD PRIMARY KEY (`identified`,`dosenk`,`mulai`,`berakhir`),
  ADD KEY `dosenk` (`dosenk`);

--
-- Indexes for table `minat`
--
ALTER TABLE `minat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `murid`
--
ALTER TABLE `murid`
  ADD PRIMARY KEY (`identified`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`identified`);

--
-- Indexes for table `registrasi`
--
ALTER TABLE `registrasi`
  ADD PRIMARY KEY (`tahunak`,`mahasiswa`,`status`,`datastatus`,`dataproses`);

--
-- Indexes for table `ruang`
--
ALTER TABLE `ruang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seminar`
--
ALTER TABLE `seminar`
  ADD PRIMARY KEY (`tahunak`,`mahasiswa`,`status`,`datastatus`);

--
-- Indexes for table `sidang`
--
ALTER TABLE `sidang`
  ADD PRIMARY KEY (`tahunak`,`mahasiswa`,`status`,`datastatus`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uploadkoordinator`
--
ALTER TABLE `uploadkoordinator`
  ADD PRIMARY KEY (`identified`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
