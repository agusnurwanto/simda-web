-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 11, 2021 at 04:23 AM
-- Server version: 5.7.33
-- PHP Version: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `simda__2021`
--

-- --------------------------------------------------------

--
-- Table structure for table `app__activity_logs`
--

CREATE TABLE `app__activity_logs` (
  `id` int(22) NOT NULL,
  `user_id` int(22) NOT NULL,
  `path` varchar(255) DEFAULT NULL,
  `method` varchar(256) NOT NULL,
  `browser` varchar(256) NOT NULL,
  `platform` varchar(256) NOT NULL,
  `ip_address` varchar(22) NOT NULL,
  `timestamp` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `app__announcements`
--

CREATE TABLE `app__announcements` (
  `announcement_id` int(11) NOT NULL,
  `title` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `announcement_slug` varchar(256) NOT NULL,
  `content` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `placement` tinyint(1) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `created_timestamp` datetime NOT NULL,
  `updated_timestamp` datetime NOT NULL,
  `language_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `app__connections`
--

CREATE TABLE `app__connections` (
  `year` year(4) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` tinytext NOT NULL,
  `database_driver` varchar(32) NOT NULL,
  `hostname` varchar(255) NOT NULL,
  `port` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `database_name` varchar(255) NOT NULL,
  `dsn` text NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `app__countries`
--

CREATE TABLE `app__countries` (
  `id` int(11) NOT NULL,
  `code` varchar(8) NOT NULL,
  `country` varchar(32) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `app__ftp`
--

CREATE TABLE `app__ftp` (
  `site_id` int(11) NOT NULL,
  `hostname` varchar(255) NOT NULL,
  `port` int(5) NOT NULL,
  `username` varchar(64) NOT NULL,
  `password` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `app__groups`
--

CREATE TABLE `app__groups` (
  `group_id` int(11) NOT NULL,
  `group_name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `group_description` mediumtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `group_privileges` longtext NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `app__groups`
--

INSERT INTO `app__groups` (`group_id`, `group_name`, `group_description`, `group_privileges`, `status`) VALUES
(1, 'Global Administrator', 'Super Admin', '{\"addons\":[\"index\",\"detail\",\"install\"],\"addons\\/ftp\":[\"index\"],\"addons\\/modules\":[\"index\",\"detail\",\"delete\"],\"addons\\/themes\":[\"index\",\"detail\",\"customize\",\"delete\"],\"administrative\":[\"index\"],\"administrative\\/account\":[\"index\",\"update\"],\"administrative\\/activities\":[\"index\",\"read\",\"truncate\",\"delete\",\"pdf\",\"print\"],\"administrative\\/cleaner\":[\"index\",\"clean\"],\"administrative\\/connections\":[\"index\",\"create\",\"read\",\"update\",\"connect\"],\"administrative\\/countries\":[\"index\",\"create\",\"read\",\"update\",\"delete\",\"export\",\"print\",\"pdf\"],\"administrative\\/groups\":[\"index\",\"create\",\"read\",\"update\",\"delete\",\"export\",\"print\",\"pdf\"],\"administrative\\/groups\\/adjust_privileges\":[\"index\",\"create\",\"read\",\"update\",\"delete\",\"export\",\"print\",\"pdf\"],\"administrative\\/groups\\/privileges\":[\"index\",\"create\",\"update\",\"read\",\"delete\"],\"administrative\\/menus\":[\"index\",\"create\",\"read\",\"update\",\"delete\",\"export\",\"print\",\"pdf\"],\"administrative\\/settings\":[\"index\",\"update\"],\"administrative\\/translations\":[\"index\",\"create\",\"read\",\"update\",\"delete\",\"export\",\"print\",\"pdf\"],\"administrative\\/translations\\/synchronize\":[\"index\"],\"administrative\\/translations\\/translate\":[\"index\",\"delete_phrase\"],\"administrative\\/updater\":[\"index\",\"update\"],\"administrative\\/users\":[\"index\",\"create\",\"read\",\"update\",\"delete\",\"export\",\"print\",\"pdf\"],\"administrative\\/users\\/privileges\":[\"index\",\"update\"],\"administrative\\/years\":[\"index\",\"create\",\"read\",\"update\",\"delete\",\"export\",\"print\",\"pdf\"],\"anggaran\\/kegiatan\":[\"index\",\"create\",\"read\",\"update\"],\"anggaran\\/kegiatan\\/berkas\":[\"index\"],\"anggaran\\/pembiayaan\":[\"index\"],\"anggaran\\/pembiayaan\\/rekening\":[\"index\",\"create\",\"read\"],\"anggaran\\/pembiayaan\\/rincian\":[\"index\",\"create\",\"read\",\"update\"],\"anggaran\\/pembiayaan\\/sub_unit\":[\"index\",\"read\"],\"anggaran\\/pendapatan\\/rekening\":[\"index\",\"read\",\"create\",\"update\"],\"anggaran\\/pendapatan\\/rincian\":[\"index\",\"create\",\"read\",\"update\"],\"anggaran\\/pendapatan\\/sub_unit\":[\"index\",\"read\"],\"anggaran\\/rekening\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"anggaran\\/rincian\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"anggaran\\/sub\":[\"index\"],\"anggaran\\/sub_unit\":[\"index\",\"read\"],\"apis\":[\"index\"],\"apis\\/debug_tool\":[\"index\"],\"apis\\/services\":[\"index\",\"create\",\"read\",\"update\",\"delete\",\"export\",\"print\",\"pdf\"],\"bendahara\\/bukti_panjar\":[\"index\",\"create\",\"read\",\"update\"],\"bendahara\\/bukti_panjar\\/rinci\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"bendahara\\/bukti_panjar\\/sub_unit\":[\"index\",\"read\"],\"bendahara\\/bukti_penerimaan\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"bendahara\\/bukti_penerimaan\\/rinci\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"bendahara\\/bukti_penerimaan\\/sub_unit\":[\"index\",\"read\"],\"bendahara\\/bukti_pengeluaran\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"bendahara\\/bukti_pengeluaran\\/bukti_pengeluaran_panjar\":[\"index\",\"create\",\"read\"],\"bendahara\\/bukti_pengeluaran\\/potongan\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"bendahara\\/bukti_pengeluaran\\/sub_unit\":[\"index\",\"read\"],\"bendahara\\/ketetapan\":[\"index\",\"create\",\"read\"],\"bendahara\\/ketetapan\\/rinci\":[\"index\",\"create\",\"read\",\"update\"],\"bendahara\\/ketetapan\\/sub_unit\":[\"index\",\"read\"],\"bendahara\\/mutasi\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"bendahara\\/mutasi\\/sub_unit\":[\"index\",\"read\"],\"bendahara\\/pajak\":[\"index\",\"create\",\"read\"],\"bendahara\\/pajak\\/sub_unit\":[\"index\"],\"bendahara\\/panjar\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"bendahara\\/panjar\\/sub_unit\":[\"index\",\"read\"],\"bendahara\\/sisa_up\":[\"index\",\"create\",\"read\",\"update\"],\"bendahara\\/sisa_up\\/sub_unit\":[\"index\",\"read\"],\"bendahara\\/sp3b\":[\"index\",\"create\",\"read\",\"update\"],\"bendahara\\/sp3b\\/rinci\":[\"index\",\"create\",\"read\",\"update\"],\"bendahara\\/sp3b\\/sub_unit\":[\"index\",\"read\"],\"bendahara\\/spj\":[\"index\",\"read\",\"create\",\"update\",\"delete\"],\"bendahara\\/spj\\/rinci\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"bendahara\\/spj\\/sub_unit\":[\"index\",\"read\"],\"bendahara\\/spp\\/gu\":[\"index\",\"read\",\"update\",\"delete\"],\"bendahara\\/spp\\/gu\\/rinci\":[\"index\",\"read\"],\"bendahara\\/spp\\/gu\\/spj\":[\"index\",\"read\"],\"bendahara\\/spp\\/gu\\/sub_unit\":[\"index\",\"read\"],\"bendahara\\/spp\\/ls\":[\"index\",\"read\",\"create\",\"update\"],\"bendahara\\/spp\\/ls\\/rinci\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"bendahara\\/spp\\/ls\\/sub_unit\":[\"index\"],\"bendahara\\/spp\\/nihil\":[\"index\",\"read\"],\"bendahara\\/spp\\/nihil\\/sub_unit\":[\"index\"],\"bendahara\\/spp\\/tu\":[\"index\",\"read\",\"create\",\"update\"],\"bendahara\\/spp\\/tu\\/sub_unit\":[\"index\"],\"bendahara\\/spp\\/up\":[\"index\",\"read\",\"create\",\"update\"],\"bendahara\\/spp\\/up\\/sub_unit\":[\"index\",\"read\"],\"bendahara\\/sts\":[\"index\"],\"bendahara\\/sts\\/sub_unit\":[\"index\",\"read\"],\"bud\\/daftar_penguji\":[\"index\",\"create\",\"read\"],\"bud\\/daftar_penguji\\/rincian\":[\"index\",\"create\",\"read\",\"update\"],\"bud\\/sp2b\":[\"index\"],\"bud\\/sp2b\\/sp3b\":[\"index\"],\"bud\\/sp2b\\/sub_unit\":[\"index\"],\"bud\\/sp2d\":[\"index\",\"create\",\"read\"],\"bud\\/sp2d\\/spm\":[\"index\"],\"bud\\/sp2d\\/sub_unit\":[\"index\",\"read\"],\"bud\\/spd\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"bud\\/spd\\/rincian\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"bud\\/spd\\/sub_unit\":[\"index\",\"read\"],\"cms\":[\"index\"],\"cms\\/blogs\":[\"index\",\"create\",\"read\",\"update\",\"delete\",\"export\",\"print\",\"pdf\"],\"cms\\/blogs\\/categories\":[\"index\",\"create\",\"read\",\"update\",\"delete\",\"export\",\"print\",\"pdf\"],\"cms\\/galleries\":[\"index\",\"create\",\"read\",\"update\",\"delete\",\"export\",\"print\",\"pdf\"],\"cms\\/pages\":[\"index\",\"create\",\"read\",\"update\",\"delete\",\"export\",\"print\",\"pdf\"],\"cms\\/partials\":[\"index\"],\"cms\\/partials\\/announcements\":[\"index\",\"create\",\"read\",\"update\",\"delete\",\"export\",\"print\",\"pdf\"],\"cms\\/partials\\/carousels\":[\"index\",\"create\",\"read\",\"update\",\"delete\",\"export\",\"print\",\"pdf\"],\"cms\\/partials\\/faqs\":[\"index\",\"create\",\"read\",\"update\",\"delete\",\"export\",\"print\",\"pdf\"],\"cms\\/partials\\/inquiries\":[\"index\",\"read\",\"delete\",\"export\",\"print\",\"pdf\"],\"cms\\/partials\\/media\":[\"index\"],\"cms\\/partials\\/testimonials\":[\"index\",\"create\",\"read\",\"update\",\"delete\",\"export\",\"print\",\"pdf\"],\"cms\\/peoples\":[\"index\",\"create\",\"read\",\"update\",\"delete\",\"export\",\"print\",\"pdf\"],\"dashboard\":[\"index\"],\"laporan\\/anggaran\":[\"index\"],\"laporan\\/anggaran\\/anggaran_kas\":[\"index\",\"anggaran_kas\",\"rekapitulasi_anggaran_kas_kegiatan\",\"rekapitulasi_anggaran_kas_per_bulan\"],\"laporan\\/anggaran\\/dpa\":[\"index\",\"dpa_skpd\",\"dpa_pendapatan_skpd\",\"dpa_belanja_skpd\",\"dpa_rincian_belanja\",\"dpa_sub_kegiatan\",\"dpa_pembiayaan_skpd\"],\"laporan\\/anggaran\\/rka\":[\"index\",\"rka_221\",\"rka_skpd\",\"rka_pendapatan_skpd\",\"rka_belanja_skpd\",\"rka_rincian_belanja\",\"rka_pembiayaan_skpd\",\"rekening\",\"rka_rekening\",\"sumber_dana\",\"rka_sub_kegiatan\"],\"laporan\\/bendahara\\/dokumen_kendali\":[\"index\",\"kartu_kendali\",\"kartu_kendali_btl\",\"kartu_kendali_pembiayaan\",\"rincian_kartu_kendali_kegiatan\",\"rincian_kartu_kendali_btl\",\"rincian_kartu_kendali_pembiayaan\",\"rekap_pengeluaran\",\"bku_rincian_obyek\",\"posisi_Kas\",\"kartu_kendali_penyediaan\"],\"laporan\\/bendahara\\/penerimaan\":[\"index\",\"bukti_penerimaan\",\"sts\",\"rekapitulasi_penerimaan\",\"bku_pembantu\",\"spj_pendapatan\",\"bku_penerimaan\",\"register_sts\",\"reg_tanda_bukti\",\"reg_ketetapan_pendapatan\",\"bku_pendapatan_harian\"],\"laporan\\/bendahara\\/pengeluaran\":[\"index\",\"buku_pajak\",\"buku_pajak_per_jenis\",\"buku_panjar\",\"spj_pengeluaran\",\"laporan_spj\",\"rincian_spj\",\"spp1\",\"spp2\",\"spp3\",\"spp_tu\",\"spp1_permendagri\",\"spp2_permendagri\",\"spp3_permendagri\",\"buku_kas_pengeluaran\",\"register_spp\",\"s3tu\",\"pertanggungjawaban_tup\",\"spj_pengeluaran_per_kegiatan\",\"bku_pembantu_bank\",\"bku_pembantu_kas_tunai\",\"bku_pembantu_belanja_ls\"],\"laporan\\/pembukuan\\/akrual\":[\"index\"],\"laporan\\/pembukuan\\/basis\":[\"index\",\"rekening\",\"jurnal\",\"buku_besar\",\"buku_besar_pembantu\",\"neraca\",\"buku_besar_pembantu_bukti\",\"realisasi_anggaran\",\"memo_pembukuan\"],\"laporan\\/tata_usaha\":[\"index\",\"kartu_kendali\",\"register_spp\",\"register_spm\",\"register_penerimaan_spj\",\"register_pengesahan_spj\",\"register_sp2d\",\"register_penolakan_penerbitan_spm\",\"register_penolakan_spj\",\"register_sp2d_tu\",\"register_spj_sp2d\",\"register_spp_sp2d\",\"pengesahan_spj\",\"laporan_pengesahan_spj\",\"pengawasan_anggaran\",\"register_kontrak\",\"daftar_realisasi\",\"realisasi_pembayaran\",\"register_sp3b\",\"spm_anggaran\",\"kendali_rincian_kegiatan_per_opd\"],\"master\":[\"index\"],\"master\\/anggaran\\/penandatangan\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"master\\/anggaran\\/sub_unit\":[\"index\"],\"master\\/anggaran\\/tim_anggaran\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"master\\/data\\/bidang\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"master\\/data\\/blud_jkn_bos\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"master\\/data\\/kegiatan\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"master\\/data\\/program\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"master\\/data\\/sub_unit\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"master\\/data\\/sub_units\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"master\\/data\\/sub_units\\/units\":[\"index\"],\"master\\/data\\/units\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"master\\/data\\/urusan\":[\"index\",\"create\",\"read\",\"delete\",\"update\"],\"master\\/rekening\\/akun\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"master\\/rekening\\/jenis\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"master\\/rekening\\/kelompok\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"master\\/rekening\\/obyek\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"master\\/rekening\\/potongan_spm\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"master\\/rekening\\/rincian\":[\"index\",\"read\",\"create\",\"update\",\"delete\"],\"master\\/settings\":[\"index\"],\"master\\/sumber_dana\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"master\\/tim_anggaran\":[\"index\",\"create\",\"read\"],\"master\\/wilayah\\/kecamatan\":[\"index\"],\"master\\/wilayah\\/kelurahan\":[\"index\"],\"tata_usaha\\/kontrak\":[\"index\",\"create\",\"read\",\"update\"],\"tata_usaha\\/kontrak\\/addendum\":[\"index\",\"create\",\"read\",\"delete\",\"update\"],\"tata_usaha\\/kontrak\\/sub_unit\":[\"index\",\"read\"],\"tata_usaha\\/pengesahan_spj\":[\"index\",\"update\",\"read\"],\"tata_usaha\\/pengesahan_spj\\/rinci\":[\"index\",\"read\",\"update\"],\"tata_usaha\\/pengesahan_spj\\/spj\":[\"index\",\"read\"],\"tata_usaha\\/pengesahan_spj\\/sub_unit\":[\"index\",\"read\"],\"tata_usaha\\/spm\":[\"index\"],\"tata_usaha\\/spm\\/spp\":[\"index\",\"read\"],\"tata_usaha\\/spm\\/sub_unit\":[\"index\",\"read\"],\"tata_usaha\\/tagihan\":[\"create\",\"read\",\"update\",\"delete\"],\"tata_usaha\\/tagihan\\/kontrak\":[\"index\",\"read\"],\"tata_usaha\\/tagihan\\/kontrak\\/sub_unit_kontrak\":[\"index\"],\"tata_usaha\\/tagihan\\/non_kontrak\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"tata_usaha\\/tagihan\\/sub_unit_kontrak\":[\"index\",\"read\"],\"tata_usaha\\/tagihan\\/sub_unit_non_kontrak\":[\"index\"],\"tata_usaha\\/tagihan\\/tagihan\":[\"index\"],\"tata_usaha\\/tagihan\\/tagihan_kontrak\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"tata_usaha\\/verifikasi\\/spp\":[\"index\",\"read\",\"update\"],\"tata_usaha\\/verifikasi\\/spp\\/tu\":[\"index\"]}', 1),
(2, 'Technical', 'Group user for technical support', '{\"administrative\":{\"administrative\":{\"administrative\":[\"index\"]},\"account\":{\"account\":[\"index\"]},\"cms\":{\"cms\":{\"cms\":[\"index\"]},\"blogs\":{\"blogs\":[\"index\",\"create\",\"read\",\"update\",\"delete\",\"export\",\"print\",\"pdf\"],\"categories\":[\"index\",\"create\",\"read\",\"update\",\"delete\",\"export\",\"print\",\"pdf\"]},\"galleries\":{\"galleries\":[\"index\",\"create\",\"read\",\"update\",\"delete\",\"export\",\"print\",\"pdf\"]},\"pages\":{\"pages\":[\"index\",\"create\",\"read\",\"update\",\"delete\",\"export\",\"print\",\"pdf\"]},\"partials\":{\"faqs\":[\"index\",\"create\",\"read\",\"update\",\"delete\",\"export\",\"print\",\"pdf\"],\"inquiries\":[\"index\",\"read\",\"delete\",\"export\",\"print\",\"pdf\"],\"media\":[\"index\"],\"partials\":[\"index\"],\"carousels\":[\"index\",\"create\",\"read\",\"update\",\"delete\",\"export\",\"print\",\"pdf\"],\"testimonials\":[\"index\",\"create\",\"read\",\"update\",\"delete\",\"export\",\"print\",\"pdf\"],\"announcements\":[\"index\",\"create\",\"read\",\"update\",\"delete\",\"export\",\"print\",\"pdf\"]},\"peoples\":{\"peoples\":[\"index\",\"create\",\"read\",\"update\",\"delete\",\"export\",\"print\",\"pdf\"]}},\"dashboard\":{\"dashboard\":{\"dashboard\":[\"index\"]}}}', 1),
(3, 'Subscriber', 'Group user for subscriber', '{\"administrative\":[\"index\"],\"administrative\\/account\":[\"index\"],\"dashboard\":[\"index\"]}', 1),
(4, 'Admin Lainnya', '2. Admin Lainnya', '{\"renja\\/asistensi\\/sub_kegiatan\":[\"index\"]}', 1),
(5, 'Admin Dinas Pendidikan', '3. Admin Dinas Pendidikan', '', 1),
(6, 'Admin Dinas Pendidikan Lainnya', '4. Admin Dinas Pendidikan Lainnya', '', 1),
(7, 'Unit', '5. Unit', '{\"anggaran\":[\"index\"],\"anggaran\\/rencana_keuangan\":[\"index\",\"update\"],\"anggaran\\/rincian\":[\"index\",\"create\",\"update\",\"read\",\"delete\"],\"anggaran\\/rincian\\/pengajuan_standar_harga\":[\"index\",\"create\"],\"anggaran\\/sub\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"anggaran\\/sub_kegiatan\":[\"index\",\"read\",\"create\"],\"asistensi\":[\"index\"],\"asistensi\\/data\":[\"index\"],\"asistensi\\/sub_kegiatan\":[\"index\",\"read\"],\"asistensi\\/verifikasi\":[\"index\"],\"belanja\":[\"index\",\"create\",\"read\",\"update\",\"export\",\"print\",\"pdf\",\"delete\"],\"belanja\\/belanja_rinc\":[\"index\",\"read\",\"create\",\"update\",\"delete\"],\"belanja\\/bukti\":[\"index\"],\"belanja\\/kegiatan\":[\"index\"],\"belanja\\/potongan_pajak\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"belanja\\/rinci\":[\"index\",\"read\",\"create\",\"delete\",\"update\"],\"belanja\\/sub_kegiatan\":[\"index\",\"read\"],\"dashboard\":[\"index\",\"create\",\"read\"],\"laporan\":[\"index\"],\"laporan\\/anggaran\":[\"index\",\"rkas\",\"anggaran_kas\"],\"laporan\\/bos\":[\"index\"],\"laporan\\/pembukuan\":[\"index\"],\"laporan\\/tata_usaha\":[\"index\",\"buku_kas_umum\",\"buku_pembantu_bank\",\"buku_pembantu_pajak\",\"buku_pembantu_pajak_per_jenis_pajak\",\"buku_pembantu_tunai\",\"kartu_kendali\",\"sp3b\",\"spb\"],\"pendapatan\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"pendapatan\\/bukti\":[\"index\"],\"pendapatan\\/sub_kegiatan\":[\"index\",\"read\"],\"renja\\/kegiatan\":[\"index\"],\"renja\\/kegiatan\\/sub_unit\":[\"index\"],\"sp2b\":[\"index\",\"create\",\"read\",\"export\",\"print\",\"pdf\",\"update\",\"delete\"],\"sp2b\\/sub_kegiatan\":[\"index\",\"read\"],\"sub_kegiatan\\/asistensi_ready\":[\"index\",\"update\"],\"sub_kegiatan\\/detail\":[\"index\"],\"sub_kegiatan\\/indikator\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"sub_kegiatan\\/kak\":[\"index\"],\"sub_kegiatan\\/lock_sub_kegiatan\":[\"index\"],\"sub_kegiatan\\/saldo\":[\"index\"],\"sub_kegiatan\\/saldo_koreksi\":[\"index\"]}', 1),
(8, 'Unit Lainnya', '6. Unit Lainnya', '{\"administrative\":[\"index\"],\"administrative\\/groups\\/privileges\":[\"create\"],\"dashboard\":[\"index\"],\"laporan\":[\"index\"],\"master\\/wilayah\\/kecamatan\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"master\\/wilayah\\/kelurahan\":[\"index\",\"read\"]}', 1),
(9, 'Sub Unit', '7. Sub Unit', '{\"administrative\":[\"index\"],\"administrative\\/groups\":[\"index\",\"create\",\"read\",\"update\",\"delete\",\"export\",\"print\",\"pdf\"],\"administrative\\/groups\\/adjust_privileges\":[\"index\",\"create\",\"update\",\"index\",\"create\",\"update\"],\"administrative\\/groups\\/privileges\":[\"index\",\"create\",\"update\",\"read\",\"delete\"],\"administrative\\/menus\":[\"index\",\"create\",\"read\",\"update\",\"delete\",\"export\",\"print\",\"pdf\"],\"anggaran\":[\"index\"],\"anggaran\\/rekening\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"anggaran\\/rencana_keuangan\":[\"index\",\"update\"],\"anggaran\\/rincian\":[\"index\",\"create\",\"update\",\"read\",\"delete\"],\"anggaran\\/rincian\\/pengajuan_standar_harga\":[\"index\",\"create\"],\"anggaran\\/sub\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"anggaran\\/sub_kegiatan\":[\"index\",\"read\",\"create\"],\"asistensi\":[\"index\"],\"asistensi\\/data\":[\"index\"],\"asistensi\\/sub_kegiatan\":[\"index\",\"create\",\"read\"],\"asistensi\\/verifikasi\":[\"index\"],\"belanja\":[\"index\",\"create\",\"read\",\"update\",\"export\",\"print\",\"pdf\",\"delete\"],\"belanja\\/bukti\":[\"index\"],\"belanja\\/kegiatan\":[\"index\"],\"belanja\\/potongan_pajak\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"belanja\\/rinci\":[\"index\",\"read\",\"create\",\"delete\",\"update\"],\"belanja\\/sub_kegiatan\":[\"index\",\"read\"],\"dashboard\":[\"index\"],\"laporan\":[\"index\"],\"laporan\\/anggaran\":[\"index\",\"rkas\",\"rka_jenis\",\"anggaran_kas\",\"perbandingan_plafon_vs_anggaran\"],\"laporan\\/bos\":[\"index\",\"surat_pernyataan_k7\",\"bos_k7\",\"sptmh\",\"sptjm\",\"k7a\",\"rekapitulasi_k8\"],\"laporan\\/pembukuan\":[\"index\",\"lra\",\"pertanggung_jawaban_bendahara_penerimaan\",\"pertanggung_jawaban_bendahara_belanja\",\"belanja_modal\",\"persediaan\",\"berita_acara_klarifikasi\",\"rekapitulasi_belanja_modal\",\"rekapitulasi_lra\"],\"laporan\\/tata_usaha\":[\"index\",\"buku_kas_umum\",\"buku_pembantu_bank\",\"buku_pembantu_tunai\",\"buku_pembantu_pajak\",\"buku_pembantu_pajak_per_jenis_pajak\",\"kartu_kendali\",\"sp2b\",\"spb\",\"kuitansi\",\"rekapitulasi_pajak\",\"rekapitulasi_pfk_per_jenis_pajak\",\"rekapitulasi_pendapatan_realisasi_belanja\",\"rekapitulasi_realisasi\",\"rekapitulasi_sp2b\",\"rekapitulasi_spb\"],\"mutasi_kas\":[\"index\",\"create\",\"read\",\"export\",\"update\",\"print\",\"delete\"],\"mutasi_kas\\/bukti\":[\"index\"],\"mutasi_kas\\/sub_kegiatan\":[\"index\",\"read\",\"create\"],\"pajak\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"pajak\\/sub_kegiatan\":[\"index\",\"read\"],\"pendapatan\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"pendapatan\\/bukti\":[\"index\"],\"pendapatan\\/sub_kegiatan\":[\"index\",\"read\"],\"sp2b\":[\"index\",\"create\",\"read\",\"export\",\"print\",\"pdf\",\"update\",\"delete\"],\"sp2b\\/sub_kegiatan\":[\"index\",\"read\"],\"spb\":[\"index\",\"create\",\"export\",\"read\",\"print\",\"pdf\",\"update\",\"delete\"],\"spb\\/sub_kegiatan\":[\"index\",\"read\"],\"sub_kegiatan\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"sub_kegiatan\\/asistensi_ready\":[\"index\",\"update\"],\"sub_kegiatan\\/detail\":[\"index\"],\"sub_kegiatan\\/saldo\":[\"index\"],\"sub_kegiatan\\/saldo_koreksi\":[\"index\"]}', 1),
(10, 'Sub Unit Lainnya', '8. Sub Unit Lainnya', '{\"account\":[\"index\"],\"administrative\":[\"index\"],\"administrative\\/account\":[\"index\"],\"cms\":[\"index\"],\"cms\\/blogs\":[\"index\",\"create\",\"read\",\"update\",\"delete\",\"export\",\"print\",\"pdf\"],\"cms\\/blogs\\/comments\":[\"index\",\"create\",\"read\",\"update\",\"delete\",\"export\",\"print\",\"pdf\"],\"cms\\/galleries\":[\"index\",\"create\",\"read\",\"update\",\"delete\",\"export\",\"print\",\"pdf\"],\"dashboard\":[\"index\"]}', 1),
(11, 'Sub Kegiatan', '9. Sub Kegiatan', '{\"anggaran\":[\"index\"],\"anggaran\\/rekening\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"anggaran\\/rencana_keuangan\":[\"index\",\"update\"],\"anggaran\\/rincian\":[\"index\",\"create\",\"update\",\"read\",\"delete\"],\"anggaran\\/rincian\\/pengajuan_standar_harga\":[\"index\",\"create\"],\"anggaran\\/sub\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"anggaran\\/sub_kegiatan\":[\"index\",\"read\"],\"asistensi\":[\"index\"],\"asistensi\\/sub_kegiatan\":[\"index\",\"create\",\"read\"],\"asistensi\\/verifikasi\":[\"index\"],\"belanja\":[\"index\",\"create\",\"read\",\"update\",\"export\",\"print\",\"pdf\",\"delete\"],\"belanja\\/bukti\":[\"index\"],\"belanja\\/kegiatan\":[\"index\"],\"belanja\\/potongan_pajak\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"belanja\\/rinci\":[\"index\",\"read\",\"create\",\"delete\",\"update\"],\"belanja\\/sub_kegiatan\":[\"index\",\"read\"],\"dashboard\":[\"index\",\"read\"],\"laporan\":[\"index\"],\"laporan\\/anggaran\":[\"index\",\"rkas\",\"rka_jenis\",\"anggaran_kas\",\"perbandingan_plafon_vs_anggaran\",\"sumber_dana\",\"rekening\",\"lembar_asistensi\"],\"laporan\\/bos\":[\"index\",\"surat_pernyataan_k7\",\"bos_k7\",\"sptmh\",\"sptjm\",\"k7a\",\"rekapitulasi_k8\"],\"laporan\\/pembukuan\":[\"index\",\"lra\",\"pertanggung_jawaban_bendahara_penerimaan\",\"pertanggung_jawaban_bendahara_belanja\",\"belanja_modal\",\"persediaan\",\"berita_acara_klarifikasi\",\"rekapitulasi_belanja_modal\",\"rekapitulasi_lra\"],\"laporan\\/tata_usaha\":[\"index\",\"buku_kas_umum\",\"buku_pembantu_bank\",\"buku_pembantu_tunai\",\"buku_pembantu_pajak\",\"buku_pembantu_pajak_per_jenis_pajak\",\"kartu_kendali\",\"sp2b\",\"spb\",\"kuitansi\",\"rekapitulasi_pajak\",\"rekapitulasi_pfk_per_jenis_pajak\",\"rekapitulasi_pendapatan_realisasi_belanja\",\"rekapitulasi_realisasi\",\"rekapitulasi_sp2b\",\"rekapitulasi_spb\"],\"master\\/renja\\/tanggapan\":[\"index\"],\"mutasi_kas\":[\"index\",\"create\",\"read\",\"export\",\"update\",\"print\",\"delete\"],\"mutasi_kas\\/bukti\":[\"index\"],\"mutasi_kas\\/sub_kegiatan\":[\"index\",\"read\",\"create\"],\"pajak\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"pajak\\/sub_kegiatan\":[\"index\",\"read\"],\"pendapatan\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"pendapatan\\/bukti\":[\"index\"],\"pendapatan\\/sub_kegiatan\":[\"index\",\"read\"],\"sp2b\":[\"index\",\"create\",\"read\",\"export\",\"print\",\"pdf\",\"update\",\"delete\"],\"sp2b\\/sub_kegiatan\":[\"index\",\"read\"],\"spb\":[\"index\",\"export\",\"read\",\"print\",\"pdf\"],\"spb\\/sub_kegiatan\":[\"index\",\"read\"],\"standar_harga\":[\"index\"],\"standar_harga\\/rekening\":[\"index\"],\"sub_kegiatan\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"sub_kegiatan\\/asistensi_ready\":[\"index\",\"update\"],\"sub_kegiatan\\/detail\":[\"index\"],\"sub_kegiatan\\/indikator\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"sub_kegiatan\\/kak\":[\"index\"],\"sub_kegiatan\\/saldo\":[\"index\"],\"sub_kegiatan\\/saldo_koreksi\":[\"index\"]}', 1),
(12, 'Sub Kegiatan Lainnya', '10. Sub Kegiatan Lainnya', '{\"administrative\":[\"index\"],\"anggaran\":[\"index\"],\"anggaran\\/rekening\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"anggaran\\/rencana_keuangan\":[\"index\",\"update\"],\"anggaran\\/rincian\":[\"index\",\"create\",\"update\",\"read\",\"delete\"],\"anggaran\\/rincian\\/pengajuan_standar_harga\":[\"index\",\"create\"],\"anggaran\\/sub\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"anggaran\\/sub_kegiatan\":[\"index\"],\"asistensi\":[\"index\"],\"asistensi\\/sub_kegiatan\":[\"index\",\"read\"],\"belanja\":[\"index\",\"create\",\"read\",\"update\",\"export\",\"print\",\"pdf\",\"delete\"],\"belanja\\/bukti\":[\"index\"],\"belanja\\/potongan_pajak\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"belanja\\/rinci\":[\"index\",\"read\",\"create\",\"delete\",\"update\"],\"dashboard\":[\"index\"],\"laporan\":[\"index\"],\"laporan\\/anggaran\":[\"index\",\"rkas\",\"anggaran_kas\",\"perbandingan_plafon_vs_anggaran\",\"rka_jenis\"],\"laporan\\/bos\":[\"index\",\"bos_k7\",\"surat_pernyataan_k7\",\"sptmh\",\"sptjm\",\"k7a\"],\"laporan\\/pembukuan\":[\"index\",\"lra\",\"pertanggung_jawaban_bendahara_penerimaan\",\"pertanggung_jawaban_bendahara_belanja\",\"belanja_modal\",\"persediaan\",\"berita_acara_klarifikasi\",\"lra_akrual\",\"lo\"],\"laporan\\/tata_usaha\":[\"index\",\"buku_kas_umum\",\"buku_pembantu_bank\",\"buku_pembantu_pajak\",\"buku_pembantu_pajak_per_jenis_pajak\",\"buku_pembantu_tunai\",\"kartu_kendali\",\"sp3b\",\"spb\",\"sp2b\",\"kwitansi\",\"kuitansi\"],\"mutasi_kas\":[\"index\",\"create\",\"read\",\"export\",\"update\",\"print\",\"delete\"],\"mutasi_kas\\/bukti\":[\"index\"],\"mutasi_kas\\/sub_kegiatan\":[\"index\",\"read\"],\"pajak\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"pajak\\/bukti\":[\"index\"],\"pajak\\/sub_kegiatan\":[\"index\"],\"pendapatan\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"pendapatan\\/bukti\":[\"index\"],\"sp2b\":[\"index\",\"create\",\"read\",\"export\",\"print\",\"pdf\",\"update\",\"delete\"],\"sp2b\\/bukti\":[\"index\"],\"sp2b\\/sub_kegiatan\":[\"index\"],\"spb\":[\"index\"],\"sub_kegiatan\":[\"index\",\"read\"],\"sub_kegiatan\\/detail\":[\"index\"],\"sub_kegiatan\\/indikator\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"sub_kegiatan\\/kak\":[\"index\"],\"sub_kegiatan\\/lock_sub_kegiatan\":[\"index\"],\"sub_kegiatan\\/saldo\":[\"index\"],\"sub_kegiatan\\/saldo_koreksi\":[\"index\"]}', 1),
(13, 'Tim Asistensi', '11. Tim Asistensi', '{\"administrative\":[\"index\"],\"administrative\\/menus\":[\"export\",\"pdf\"],\"administrative\\/settings\":[\"index\",\"update\"],\"administrative\\/users\":[\"export\",\"pdf\"],\"anggaran\\/rekening\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"anggaran\\/rencana_keuangan\":[\"index\",\"update\"],\"anggaran\\/rincian\":[\"index\",\"create\",\"update\",\"read\",\"delete\"],\"anggaran\\/rincian\\/pengajuan_standar_harga\":[\"index\",\"create\"],\"anggaran\\/sub\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"dashboard\":[\"index\"],\"laporan\":[\"index\"],\"laporan\\/anggaran\\/asistensi\":[\"asistensi_kegiatan\",\"asistensi_skpd\"],\"laporan\\/anggaran\\/dpa\":[\"index\"],\"laporan\\/anggaran\\/rka\":[\"index\",\"rka_skpd\",\"rka_rincian_belanja\",\"rka_belanja_skpd\",\"rka_sub_kegiatan\",\"rekening\",\"sumber_dana\",\"anggaran_kas\",\"rka_pendapatan_skpd\",\"rka_pembiayaan_skpd\"],\"laporan\\/rup\":[\"index\"],\"laporan\\/sakip\":[\"index\"],\"laporan\\/simda\":[\"index\",\"perbandingan_organisasi\",\"perbandingan_program\",\"perbandingan_kegiatan\",\"perbandingan_rekening\"],\"master\\/renja\\/tanggapan\":[\"index\"],\"master\\/renja\\/tanggapan_kak\":[\"index\"],\"rpjmd\\/program\":[\"index\"]}', 1),
(14, 'Tim Asistensi Lainnya', '12. Tim Asistensi Lainnya', '{\"administrative\":[\"index\"],\"administrative\\/menus\":[\"index\",\"create\",\"read\",\"update\",\"delete\",\"export\",\"print\",\"pdf\"],\"anggaran\\/rekening\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"anggaran\\/rencana_keuangan\":[\"index\",\"update\"],\"anggaran\\/rincian\":[\"index\",\"create\",\"update\",\"read\",\"delete\"],\"anggaran\\/sub\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"dashboard\":[\"index\"],\"laporan\":[\"index\"],\"master\\/renja\\/indikator\":[\"index\"],\"rpjmd\\/program\":[\"index\",\"create\",\"read\",\"update\",\"delete\"]}', 1),
(15, 'Viewer', '13. Viewer', '{\"administrative\":[\"index\"],\"administrative\\/menus\":[\"export\",\"pdf\"],\"administrative\\/settings\":[\"index\",\"update\"],\"administrative\\/users\":[\"export\",\"pdf\"],\"anggaran\\/rekening\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"anggaran\\/rencana_keuangan\":[\"index\",\"update\"],\"anggaran\\/rincian\":[\"index\",\"create\",\"update\",\"read\",\"delete\"],\"anggaran\\/sub\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"cms\\/pages\":[\"export\",\"pdf\"],\"cms\\/partials\\/carousels\":[\"export\",\"pdf\",\"export\",\"pdf\"],\"dashboard\":[\"index\"],\"master\\/rekening\\/jenis_belanja\":[\"export\",\"print\",\"pdf\"],\"master\\/rekening\\/objek_belanja\":[\"export\",\"print\",\"pdf\"],\"master\\/rekening\\/rincian_objek\":[\"export\",\"print\",\"pdf\"],\"master\\/renja\\/tanggapan\":[\"index\"],\"master\\/renja\\/tanggapan_kak\":[\"index\"]}', 1),
(16, 'Viewer 2', '14. Viewer 2', '{\"administrative\":[\"index\"],\"administrative\\/menus\":[\"export\",\"pdf\"],\"administrative\\/settings\":[\"index\",\"update\"],\"administrative\\/users\":[\"export\",\"pdf\"],\"anggaran\\/rekening\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"anggaran\\/rencana_keuangan\":[\"index\",\"update\"],\"anggaran\\/rincian\":[\"index\",\"create\",\"update\",\"read\",\"delete\"],\"anggaran\\/sub\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"cms\\/pages\":[\"export\",\"pdf\"],\"cms\\/partials\\/carousels\":[\"export\",\"pdf\",\"export\",\"pdf\"],\"dashboard\":[\"index\"],\"master\\/rekening\\/jenis_belanja\":[\"export\",\"print\",\"pdf\"],\"master\\/rekening\\/objek_belanja\":[\"export\",\"print\",\"pdf\"],\"master\\/rekening\\/rincian_objek\":[\"export\",\"print\",\"pdf\"],\"master\\/renja\\/tanggapan\":[\"index\"],\"master\\/renja\\/tanggapan_kak\":[\"index\"]}', 1),
(17, 'Verifikatur SSH', '15. Verifikatur standar harga', '{\"administrative\":[\"profile\",\"account\",\"customizer\",\"index\",\"update\"],\"administrative\\/translations\":[\"index\",\"create\",\"read\",\"update\",\"delete\",\"export\",\"print\",\"pdf\",\"translate\"],\"administrative\\/translations\\/translate\":[\"index\"],\"administrative\\/groups\\/adjust_privileges\":[\"index\",\"create\",\"update\"],\"administrative\\/groups\\/privileges\":[\"index\",\"create\",\"read\",\"update\",\"delete\",\"export\",\"print\",\"pdf\"],\"administrative\\/groups\":[\"index\",\"create\",\"read\",\"update\",\"delete\",\"export\",\"print\",\"pdf\"],\"administrative\\/builder\":[\"index\",\"create\",\"read\",\"update\",\"delete\",\"export\",\"print\",\"pdf\"],\"administrative\\/menus\":[\"index\",\"create\",\"read\",\"update\",\"delete\",\"export\",\"print\",\"pdf\"],\"administrative\\/activities\":[\"index\",\"truncate\",\"create\",\"read\",\"print\",\"pdf\",\"export\"],\"administrative\\/settings\":[\"index\",\"update\"],\"administrative\\/users\\/privileges\":[\"index\",\"update\"],\"administrative\\/users\":[\"index\",\"create\",\"read\",\"update\",\"delete\",\"export\",\"print\",\"pdf\"],\"dashboard\":[\"index\"],\"kegiatan\\/kelog\":[\"index\",\"update\",\"pdf\",\"create\"],\"kegiatan\\/rab\":[\"index\",\"pdf\",\"create\"],\"kegiatan\\/set_model\":[\"index\",\"update\"],\"kegiatan\":[\"index\",\"create\",\"read\",\"update\",\"delete\",\"export\",\"print\",\"pdf\"],\"kegiatan\\/rka\":[\"index\",\"pdf\",\"create\"],\"laporan\\/renja\":[\"index\",\"renja_awal\",\"renja_akhir\",\"rekapitulasi_renja_awal_per_skpd\",\"ba_desk_renja\"],\"laporan\\/anggaran\":[\"index\",\"rka_221\",\"rka_22\",\"perbandingan_plafon_anggaran_kegiatan\",\"standar_harga\",\"rekapitulasi_standar_harga\",\"rekapitulasi_model_rka\",\"lembar_asistensi\",\"ringkasan\",\"perbandingan_plafon_anggaran_skpd\",\"anggaran_kas\",\"rekapitulasi_anggaran_kas_kegiatan\",\"rekapitulasi_rekening\",\"rkap_221\"],\"laporan\\/renja_khusus\":[\"index\",\"renja_awal\"],\"master\\/renja\\/isu\":[\"index\",\"create\",\"read\",\"update\",\"delete\",\"export\",\"print\",\"pdf\"],\"master\\/renja\\/variabel\":[\"index\",\"create\",\"read\",\"update\",\"delete\",\"export\",\"print\",\"pdf\"],\"master\\/renja\\/pertanyaan\":[\"index\",\"create\",\"read\",\"update\",\"delete\",\"export\",\"print\",\"pdf\"],\"master\\/renja\\/standar_harga\":[\"index\",\"create\",\"read\",\"update\",\"export\",\"print\",\"pdf\"],\"master\\/renja\\/jenis_usulan\":[\"index\",\"create\",\"read\",\"update\",\"delete\",\"export\",\"print\",\"pdf\"],\"master\\/renja\\/tanggapan\":[\"index\",\"create\",\"read\",\"update\"],\"master\":[\"index\"],\"renja\\/verifikasi_standar_harga\":[\"index\",\"create\",\"read\",\"update\",\"delete\",\"export\",\"print\",\"pdf\"],\"renja\\/kegiatan\\/data\":[\"index\",\"create\",\"update\",\"read\",\"delete\"],\"renja\\/kegiatan\\/indikator\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"renja\\/kegiatan\\/ubah_skpd\":[\"update\"],\"renja\\/kegiatan\":[\"index\",\"create\"],\"rpjmd\\/tujuan\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"rpjmd\":[\"index\",\"create\",\"update\",\"read\",\"delete\",\"export\",\"pdf\",\"print\"],\"rpjmd\\/visi\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"rpjmd\\/program\":[\"index\",\"create\",\"read\",\"update\",\"delete\",\"print\",\"export\",\"pdf\"],\"rpjmd\\/sasaran\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"rpjmd\\/misi\":[\"index\",\"create\",\"delete\",\"update\",\"read\"]}', 1),
(18, 'Verifikatur SSH Lainnya', '16. Verifikatur SSH Lainnya', '{\"administrative\":[\"index\"],\"anggaran\\/rekening\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"anggaran\\/rencana_keuangan\":[\"index\",\"update\"],\"anggaran\\/rincian\":[\"index\",\"create\",\"update\",\"read\",\"delete\"],\"anggaran\\/sub\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"dashboard\":[\"index\"],\"master\\/renja\\/tanggapan\":[\"index\"],\"master\\/renja\\/tanggapan_kak\":[\"index\"]}', 1),
(19, 'TAPD TTD', '17. Untuk TTD di lembar RKA', '{\"administrative\":[\"profile\",\"account\",\"customizer\",\"index\",\"update\"],\"dashboard\":[\"index\"],\"laporan\\/asistensi\":[\"index\",\"asistensi_kegiatan\",\"asistensi_skpd\"],\"laporan\\/anggaran\":[\"index\",\"rka_221\",\"rka_22\",\"perbandingan_plafon_anggaran_kegiatan\",\"standar_harga\",\"rekapitulasi_standar_harga\",\"rekapitulasi_model_rka\",\"lembar_asistensi\",\"ringkasan\",\"perbandingan_plafon_anggaran_skpd\",\"anggaran_kas\",\"rekapitulasi_anggaran_kas_kegiatan\",\"rekapitulasi_rekening\",\"rkap_221\",\"rekapitulasi_anggaran_kas_per_bulan\"],\"laporan\":[\"index\"],\"renja\\/asistensi\\/verifikasi\":[\"index\",\"update\"],\"renja\\/asistensi\":[\"index\",\"create\",\"read\",\"udate\",\"delete\",\"export\",\"print\",\"pdf\"],\"renja\\/asistensi\\/kegiatan\":[\"index\",\"create\"],\"renja\\/asistensi\\/sub_unit\":[\"index\",\"create\"],\"renja\\/asistensi\\/data\":[\"index\"]}', 1),
(20, 'TAPD TTD Lainnya', '18. TAPD TTD Lainnya', '{\"administrative\":[\"index\"],\"administrative\\/settings\":[\"index\",\"update\"],\"dashboard\":[\"index\"],\"laporan\":[\"index\"],\"master\\/data\\/program\":[\"index\",\"create\",\"read\",\"update\",\"delete\",\"export\",\"print\",\"pdf\"],\"rpjmd\\/program\":[\"index\",\"create\",\"read\",\"update\",\"delete\"]}', 1),
(21, 'Pengelola Keuangan', '19. Pengelola Keuangan', '{\"anggaran\\/rekening\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"anggaran\\/rencana_keuangan\":[\"index\",\"update\"],\"anggaran\\/rincian\":[\"index\",\"create\",\"update\",\"read\",\"delete\"],\"anggaran\\/sub\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"dashboard\":[\"index\"],\"laporan\\/simda\":[\"index\",\"perbandingan_organisasi\",\"perbandingan_program\",\"perbandingan_kegiatan\",\"perbandingan_rekening\"],\"master\\/renja\\/tanggapan\":[\"index\"]}', 1),
(22, 'Pengelola Keuangan Lainnya', '20. Pengelola Keuangan Lainnya', '{\"administrative\\/activities\":[\"index\",\"read\",\"truncate\"],\"administrative\\/groups\\/adjust_privileges\":[\"index\",\"create\",\"update\",\"index\",\"create\",\"update\"],\"administrative\\/translations\":[\"index\",\"create\",\"read\",\"update\",\"delete\",\"export\",\"print\",\"pdf\"],\"administrative\\/translations\\/translate\":[\"index\",\"index\"],\"dashboard\":[\"index\"],\"laporan\":[\"index\"],\"master\":[\"index\"],\"master\\/data\\/bidang\":[\"index\",\"read\"],\"master\\/data\\/sub_units\":[\"index\",\"create\",\"read\",\"update\",\"delete\",\"export\",\"print\",\"pdf\"],\"master\\/data\\/urusan\":[\"index\",\"read\"],\"master\\/rekening\\/kelompok\":[\"index\",\"read\"],\"master\\/wilayah\\/kecamatan\":[\"index\",\"create\",\"read\",\"update\",\"delete\"],\"master\\/wilayah\\/kelurahan\":[\"index\",\"create\",\"read\",\"update\",\"delete\"]}', 1),
(23, 'Pemeriksa', '21. Grup Untuk Inspektorat atau BPK atau BPKP', '{\"administrative\":[\"index\"],\"anggaran\\/rekening\":[\"index\",\"read\"],\"anggaran\\/rencana_keuangan\":[\"index\"],\"anggaran\\/rincian\":[\"index\",\"read\"],\"anggaran\\/rincian\\/pengajuan_standar_harga\":[\"index\"],\"anggaran\\/sub\":[\"index\",\"read\"],\"dashboard\":[\"index\"]}', 1),
(24, 'Pemeriksa Lainnya', '22. Grup Untuk Inspektorat atau BPK atau BPKP', '{\"account\":[\"index\"],\"administrative\":[\"index\"],\"administrative\\/account\":[\"index\"],\"dashboard\":[\"index\"]}', 1),
(25, 'Anggaran Pembiayaan', '23. Anggaran Pembiayaan', '', 1),
(26, 'Anggaran Pendapatan', '24. Anggaran Pendapatan', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `app__groups_privileges`
--

CREATE TABLE `app__groups_privileges` (
  `path` varchar(255) NOT NULL DEFAULT '',
  `privileges` longtext NOT NULL,
  `last_generated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `app__groups_privileges`
--

INSERT INTO `app__groups_privileges` (`path`, `privileges`, `last_generated`) VALUES
('addons', '[\"index\",\"detail\",\"install\"]', '2021-02-13 15:10:54'),
('addons/ftp', '[\"index\"]', '2021-02-13 15:10:54'),
('addons/modules', '[\"index\",\"detail\",\"delete\"]', '2021-02-13 15:10:54'),
('addons/themes', '[\"index\",\"detail\",\"customize\",\"delete\"]', '2021-02-13 15:10:54'),
('administrative', '[\"index\"]', '2021-02-13 15:10:54'),
('administrative/account', '[\"index\",\"update\"]', '2021-02-13 15:10:54'),
('administrative/activities', '[\"index\",\"read\",\"truncate\",\"delete\",\"pdf\",\"print\"]', '2021-02-13 15:10:54'),
('administrative/cleaner', '[\"index\",\"clean\"]', '2021-02-13 15:10:54'),
('administrative/connections', '[\"index\",\"create\",\"read\",\"update\",\"connect\"]', '2021-02-19 14:18:21'),
('administrative/countries', '[\"index\",\"create\",\"read\",\"update\",\"delete\",\"export\",\"print\",\"pdf\"]', '2021-02-13 15:10:54'),
('administrative/groups', '[\"index\",\"create\",\"read\",\"update\",\"delete\",\"export\",\"print\",\"pdf\"]', '2021-02-13 15:10:54'),
('administrative/groups/adjust_privileges', '[\"index\",\"create\",\"read\",\"update\",\"delete\",\"export\",\"print\",\"pdf\"]', '2021-02-13 15:10:54'),
('administrative/groups/privileges', '[\"index\",\"create\",\"update\",\"read\",\"delete\"]', '2021-02-13 15:10:54'),
('administrative/menus', '[\"index\",\"create\",\"read\",\"update\",\"delete\",\"export\",\"print\",\"pdf\"]', '2021-02-13 15:10:54'),
('administrative/settings', '[\"index\",\"update\"]', '2021-02-13 15:10:54'),
('administrative/translations', '[\"index\",\"create\",\"read\",\"update\",\"delete\",\"export\",\"print\",\"pdf\"]', '2021-02-13 15:10:54'),
('administrative/translations/synchronize', '[\"index\"]', '2021-02-13 15:10:54'),
('administrative/translations/translate', '[\"index\",\"delete_phrase\"]', '2021-02-13 15:10:54'),
('administrative/updater', '[\"index\",\"update\"]', '2021-02-13 15:10:54'),
('administrative/users', '[\"index\",\"create\",\"read\",\"update\",\"delete\",\"export\",\"print\",\"pdf\"]', '2021-02-13 15:10:54'),
('administrative/users/privileges', '[\"index\",\"update\"]', '2021-02-13 15:10:54'),
('administrative/years', '[\"index\",\"create\",\"read\",\"update\",\"delete\",\"export\",\"print\",\"pdf\"]', '2021-02-15 06:20:58'),
('anggaran/kegiatan', '[\"index\",\"create\",\"read\",\"update\"]', '2021-02-16 12:24:17'),
('anggaran/kegiatan/berkas', '[\"index\"]', '2021-05-21 10:14:41'),
('anggaran/pembiayaan', '[\"index\"]', '2021-02-15 09:32:22'),
('anggaran/pembiayaan/rekening', '[\"index\",\"create\",\"read\"]', '2021-02-15 09:34:02'),
('anggaran/pembiayaan/rincian', '[\"index\",\"create\",\"read\",\"update\"]', '2021-02-15 09:35:50'),
('anggaran/pembiayaan/sub_unit', '[\"index\",\"read\"]', '2021-02-15 09:33:43'),
('anggaran/pendapatan/rekening', '[\"index\",\"read\",\"create\",\"update\",\"delete\"]', '2021-02-17 13:21:47'),
('anggaran/pendapatan/rincian', '[\"index\",\"create\",\"read\",\"update\"]', '2021-02-15 09:28:37'),
('anggaran/pendapatan/sub_unit', '[\"index\",\"read\"]', '2021-02-15 05:34:28'),
('anggaran/rekening', '[\"index\",\"create\",\"read\",\"update\",\"delete\"]', '2021-04-06 10:03:13'),
('anggaran/rincian', '[\"index\",\"create\",\"read\",\"update\",\"delete\"]', '2021-04-06 10:19:58'),
('anggaran/sub', '[\"index\"]', '2021-04-06 10:20:55'),
('anggaran/sub_unit', '[\"index\",\"read\"]', '2021-02-15 07:44:58'),
('apis', '[\"index\"]', '2021-02-13 15:10:54'),
('apis/debug_tool', '[\"index\"]', '2021-02-13 15:10:54'),
('apis/services', '[\"index\",\"create\",\"read\",\"update\",\"delete\",\"export\",\"print\",\"pdf\"]', '2021-02-13 15:10:54'),
('bendahara/bukti_panjar', '[\"index\",\"create\",\"read\",\"update\"]', '2021-02-15 10:09:51'),
('bendahara/bukti_panjar/rinci', '[\"index\",\"create\",\"read\",\"update\",\"delete\"]', '2021-02-18 10:04:35'),
('bendahara/bukti_panjar/sub_unit', '[\"index\",\"read\"]', '2021-02-15 10:09:47'),
('bendahara/bukti_penerimaan', '[\"index\",\"create\",\"read\",\"update\",\"delete\"]', '2021-02-18 20:19:37'),
('bendahara/bukti_penerimaan/rinci', '[\"index\",\"create\",\"read\",\"update\",\"delete\"]', '2021-02-18 20:45:18'),
('bendahara/bukti_penerimaan/sub_unit', '[\"index\",\"read\"]', '2021-02-18 20:12:27'),
('bendahara/bukti_pengeluaran', '[\"index\",\"create\",\"read\",\"update\",\"delete\"]', '2021-02-18 11:52:15'),
('bendahara/bukti_pengeluaran/bukti_pengeluaran_panjar', '[\"index\",\"create\",\"read\"]', '2021-02-22 16:41:35'),
('bendahara/bukti_pengeluaran/potongan', '[\"index\",\"create\",\"read\",\"update\",\"delete\"]', '2021-02-18 13:33:46'),
('bendahara/bukti_pengeluaran/sub_unit', '[\"index\",\"read\"]', '2021-02-16 00:45:29'),
('bendahara/ketetapan', '[\"index\",\"create\",\"read\"]', '2021-02-15 16:08:03'),
('bendahara/ketetapan/rinci', '[\"index\",\"create\",\"read\",\"update\"]', '2021-02-15 16:08:50'),
('bendahara/ketetapan/sub_unit', '[\"index\",\"read\"]', '2021-02-15 16:08:00'),
('bendahara/mutasi', '[\"index\",\"create\",\"read\",\"update\",\"delete\"]', '2021-02-22 09:55:02'),
('bendahara/mutasi/sub_unit', '[\"index\",\"read\"]', '2021-02-15 09:38:56'),
('bendahara/pajak', '[\"index\",\"create\",\"read\"]', '2021-02-18 17:20:36'),
('bendahara/pajak/sub_unit', '[\"index\",\"read\"]', '2021-02-16 00:45:32'),
('bendahara/panjar', '[\"index\",\"create\",\"read\",\"update\",\"delete\"]', '2021-02-22 14:27:08'),
('bendahara/panjar/sub_unit', '[\"index\",\"read\"]', '2021-02-15 10:07:43'),
('bendahara/sisa_up', '[\"index\",\"create\",\"read\",\"update\"]', '2021-02-15 16:05:24'),
('bendahara/sisa_up/sub_unit', '[\"index\",\"read\"]', '2021-02-15 16:05:20'),
('bendahara/sp3b', '[\"index\",\"create\",\"read\",\"update\"]', '2021-02-15 16:06:12'),
('bendahara/sp3b/rinci', '[\"index\",\"create\",\"read\",\"update\"]', '2021-02-15 16:07:14'),
('bendahara/sp3b/sub_unit', '[\"index\",\"read\"]', '2021-02-15 16:06:08'),
('bendahara/spj', '[\"index\",\"read\",\"create\",\"update\",\"delete\"]', '2021-02-18 15:02:25'),
('bendahara/spj/rinci', '[\"index\",\"create\",\"read\",\"update\",\"delete\"]', '2021-02-18 15:25:04'),
('bendahara/spj/sub_unit', '[\"index\",\"read\"]', '2021-02-16 00:45:31'),
('bendahara/spp/gu', '[\"index\",\"read\",\"update\",\"delete\"]', '2021-04-07 11:27:50'),
('bendahara/spp/gu/rinci', '[\"index\",\"read\"]', '2021-04-07 11:42:25'),
('bendahara/spp/gu/spj', '[\"index\",\"read\"]', '2021-04-07 11:26:48'),
('bendahara/spp/gu/sub_unit', '[\"index\",\"read\"]', '2021-04-07 11:26:15'),
('bendahara/spp/ls', '[\"index\",\"read\",\"create\",\"update\"]', '2021-02-15 16:03:47'),
('bendahara/spp/ls/rinci', '[\"index\",\"create\",\"read\",\"update\",\"delete\"]', '2021-04-24 12:58:56'),
('bendahara/spp/ls/sub_unit', '[\"index\",\"read\"]', '2021-04-24 12:58:01'),
('bendahara/spp/nihil', '[\"index\",\"read\"]', '2021-02-15 10:14:01'),
('bendahara/spp/nihil/sub_unit', '[\"index\"]', '2021-04-24 12:35:58'),
('bendahara/spp/tu', '[\"index\",\"read\",\"create\",\"update\"]', '2021-02-15 16:04:17'),
('bendahara/spp/tu/sub_unit', '[\"index\",\"read\"]', '2021-04-24 12:40:57'),
('bendahara/spp/up', '[\"index\",\"read\",\"create\",\"update\"]', '2021-02-15 15:58:32'),
('bendahara/spp/up/sub_unit', '[\"index\",\"read\"]', '2021-04-24 12:35:13'),
('bendahara/sts', '[\"index\"]', '2021-02-18 21:35:05'),
('bendahara/sts/sub_unit', '[\"index\",\"read\"]', '2021-02-18 21:37:07'),
('bud/daftar_penguji', '[\"index\",\"create\",\"read\"]', '2021-02-15 16:21:03'),
('bud/daftar_penguji/rincian', '[\"index\",\"create\",\"read\",\"update\"]', '2021-02-15 16:21:46'),
('bud/sp2b', '[\"index\"]', '2021-02-15 10:08:57'),
('bud/sp2b/sp3b', '[\"index\",\"create\",\"read\"]', '2021-02-15 16:22:14'),
('bud/sp2b/sub_unit', '[\"index\"]', '2021-02-15 16:21:10'),
('bud/sp2d', '[\"index\",\"create\",\"read\",\"update\"]', '2021-03-25 13:46:07'),
('bud/sp2d/spm', '[\"index\",\"read\"]', '2021-03-25 13:45:55'),
('bud/sp2d/sub_unit', '[\"index\",\"read\"]', '2021-02-15 16:21:37'),
('bud/spd', '[\"index\",\"create\",\"read\",\"update\",\"delete\"]', '2021-04-07 12:06:05'),
('bud/spd/rincian', '[\"index\",\"create\",\"read\",\"update\",\"delete\"]', '2021-04-07 12:06:22'),
('bud/spd/sub_unit', '[\"index\",\"read\"]', '2021-02-15 16:21:30'),
('cms', '[\"index\"]', '2021-02-13 15:10:54'),
('cms/blogs', '[\"index\",\"create\",\"read\",\"update\",\"delete\",\"export\",\"print\",\"pdf\"]', '2021-02-13 15:10:54'),
('cms/blogs/categories', '[\"index\",\"create\",\"read\",\"update\",\"delete\",\"export\",\"print\",\"pdf\"]', '2021-02-13 15:10:54'),
('cms/galleries', '[\"index\",\"create\",\"read\",\"update\",\"delete\",\"export\",\"print\",\"pdf\"]', '2021-02-13 15:10:54'),
('cms/pages', '[\"index\",\"create\",\"read\",\"update\",\"delete\",\"export\",\"print\",\"pdf\"]', '2021-02-13 15:10:54'),
('cms/partials', '[\"index\"]', '2021-02-13 15:10:54'),
('cms/partials/announcements', '[\"index\",\"create\",\"read\",\"update\",\"delete\",\"export\",\"print\",\"pdf\"]', '2021-02-13 15:10:54'),
('cms/partials/carousels', '[\"index\",\"create\",\"read\",\"update\",\"delete\",\"export\",\"print\",\"pdf\"]', '2021-02-13 15:10:54'),
('cms/partials/faqs', '[\"index\",\"create\",\"read\",\"update\",\"delete\",\"export\",\"print\",\"pdf\"]', '2021-02-13 15:10:54'),
('cms/partials/inquiries', '[\"index\",\"read\",\"delete\",\"export\",\"print\",\"pdf\"]', '2021-02-13 15:10:54'),
('cms/partials/media', '[\"index\"]', '2021-02-13 15:10:54'),
('cms/partials/testimonials', '[\"index\",\"create\",\"read\",\"update\",\"delete\",\"export\",\"print\",\"pdf\"]', '2021-02-13 15:10:54'),
('cms/peoples', '[\"index\",\"create\",\"read\",\"update\",\"delete\",\"export\",\"print\",\"pdf\"]', '2021-02-13 15:10:54'),
('dashboard', '[\"index\"]', '2021-02-13 15:10:54'),
('laporan/anggaran', '[\"index\"]', '2021-02-25 17:49:30'),
('laporan/anggaran/anggaran_kas', '[\"index\",\"anggaran_kas\",\"rekapitulasi_anggaran_kas_kegiatan\",\"rekapitulasi_anggaran_kas_per_bulan\"]', '2021-02-25 09:51:07'),
('laporan/anggaran/dpa', '[\"index\",\"dpa_skpd\",\"dpa_pendapatan_skpd\",\"dpa_belanja_skpd\",\"dpa_rincian_belanja\",\"dpa_sub_kegiatan\",\"dpa_pembiayaan_skpd\"]', '2021-02-25 17:56:53'),
('laporan/anggaran/rka', '[\"index\",\"rka_221\",\"rka_skpd\",\"rka_pendapatan_skpd\",\"rka_belanja_skpd\",\"rka_rincian_belanja\",\"rka_pembiayaan_skpd\",\"rekening\",\"rka_rekening\",\"sumber_dana\",\"rka_sub_kegiatan\",\"rekapitulasi_anggaran_kas_per_bulan\",\"rekapitulasi_anggaran_kas_kegiatan\"]', '2021-02-23 19:25:19'),
('laporan/bendahara/dokumen_kendali', '[\"index\",\"kartu_kendali\",\"kartu_kendali_btl\",\"kartu_kendali_pembiayaan\",\"rincian_kartu_kendali_kegiatan\",\"rincian_kartu_kendali_btl\",\"rincian_kartu_kendali_pembiayaan\",\"rekap_pengeluaran\",\"bku_rincian_obyek\",\"posisi_Kas\",\"kartu_kendali_penyediaan\"]', '2021-03-18 11:57:32'),
('laporan/bendahara/penerimaan', '[\"index\",\"bukti_penerimaan\",\"sts\",\"rekapitulasi_penerimaan\",\"bku_pembantu\",\"spj_pendapatan\",\"bku_penerimaan\",\"register_sts\",\"reg_tanda_bukti\",\"reg_ketetapan_pendapatan\",\"bku_pendapatan_harian\"]', '2021-03-11 17:15:11'),
('laporan/bendahara/pengeluaran', '[\"index\",\"buku_pajak\",\"buku_pajak_per_jenis\",\"buku_panjar\",\"spj_pengeluaran\",\"laporan_spj\",\"rincian_spj\",\"spp1\",\"spp2\",\"spp3\",\"spp_tu\",\"spp1_permendagri\",\"spp2_permendagri\",\"spp3_permendagri\",\"buku_kas_pengeluaran\",\"register_spp\",\"s3tu\",\"per_tup\",\"pertanggungjawaban_tup\",\"spj_pengeluaran_per_kegiatan\",\"bku_pembantu_bank\",\"bku_pembantu_kas_tunai\",\"bku_pembantu_belanja_ls\",\"bku_pengeluaran_belanja\"]', '2021-03-20 10:30:00'),
('laporan/pembukuan/akrual', '[\"index\"]', '2021-02-27 15:27:05'),
('laporan/pembukuan/basis', '[\"index\",\"rekening\",\"jurnal\",\"buku_besar\",\"buku_besar_pembantu\",\"neraca\",\"buku_besar_pembantu_bukti\",\"realisasi_anggaran\",\"memo_pembukuan\"]', '2021-03-29 22:49:49'),
('laporan/tata_usaha', '[\"index\",\"kartu_kendali\",\"register_spp\",\"register_spm\",\"register_penerimaan_spj\",\"register_pengesahan_spj\",\"register_sp2d\",\"register_penolakan_penerbitan_spm\",\"register_penolakan_spj\",\"register_sp2d_tu\",\"register_spj_sp2d\",\"register_spp_sp2d\",\"pengesahan_spj\",\"laporan_pengesahan_spj\",\"pengawasan_anggaran\",\"register_kontrak\",\"daftar_realisasi\",\"realisasi_pembayaran\",\"register_sp3b\",\"spm_anggaran\",\"kendali_rincian_kegiatan_per_opd\"]', '2021-07-29 17:11:48'),
('master', '[\"index\"]', '2021-02-26 13:26:39'),
('master/anggaran/penandatangan', '[\"index\",\"create\",\"read\",\"update\",\"delete\"]', '2021-04-22 14:20:42'),
('master/anggaran/sub_unit', '[\"index\",\"read\"]', '2021-04-22 14:27:11'),
('master/anggaran/tim_anggaran', '[\"index\",\"create\",\"read\",\"update\",\"delete\"]', '2021-04-22 13:37:05'),
('master/data/bidang', '[\"index\",\"create\",\"read\",\"update\",\"delete\"]', '2021-04-21 14:19:00'),
('master/data/blud_jkn_bos', '[\"index\",\"create\",\"read\",\"update\",\"delete\"]', '2021-04-22 15:58:15'),
('master/data/kegiatan', '[\"index\",\"create\",\"read\",\"update\",\"delete\"]', '2021-04-22 21:47:17'),
('master/data/program', '[\"index\",\"create\",\"read\",\"update\",\"delete\"]', '2021-04-22 21:07:08'),
('master/data/sub_unit', '[\"index\",\"create\",\"read\",\"update\",\"delete\"]', '2021-04-22 09:40:55'),
('master/data/sub_units', '[\"index\",\"create\",\"read\",\"update\",\"delete\"]', '2021-04-22 10:39:05'),
('master/data/sub_units/units', '[\"index\"]', '2021-04-22 10:36:30'),
('master/data/units', '[\"index\",\"create\",\"read\",\"update\",\"delete\"]', '2021-04-21 14:31:45'),
('master/data/urusan', '[\"index\",\"create\",\"read\",\"delete\",\"update\"]', '2021-04-21 14:14:08'),
('master/rekening/akun', '[\"index\",\"create\",\"read\",\"update\",\"delete\"]', '2021-04-22 22:27:52'),
('master/rekening/jenis', '[\"index\",\"create\",\"read\",\"update\",\"delete\"]', '2021-04-22 22:43:49'),
('master/rekening/kelompok', '[\"index\",\"create\",\"read\",\"update\",\"delete\"]', '2021-04-22 22:33:28'),
('master/rekening/obyek', '[\"index\",\"create\",\"read\",\"update\",\"delete\"]', '2021-04-22 23:11:13'),
('master/rekening/potongan_spm', '[\"index\",\"create\",\"read\",\"update\",\"delete\"]', '2021-04-22 15:05:22'),
('master/rekening/rincian', '[\"index\",\"read\",\"create\",\"update\",\"delete\"]', '2021-04-22 23:23:53'),
('master/settings', '[\"index\"]', '2021-02-24 10:57:09'),
('master/sumber_dana', '[\"index\",\"create\",\"read\",\"update\",\"delete\"]', '2021-04-22 22:09:36'),
('master/tim_anggaran', '[\"index\",\"create\",\"read\"]', '2021-04-22 13:21:38'),
('master/wilayah/kecamatan', '[\"index\"]', '2021-04-07 14:43:00'),
('master/wilayah/kelurahan', '[\"index\"]', '2021-04-07 14:43:01'),
('tata_usaha/kontrak', '[\"index\",\"create\",\"read\",\"update\"]', '2021-02-15 16:10:24'),
('tata_usaha/kontrak/addendum', '[\"index\",\"create\",\"read\",\"delete\",\"update\"]', '2021-04-24 15:08:12'),
('tata_usaha/kontrak/sub_unit', '[\"index\",\"read\"]', '2021-02-15 16:10:20'),
('tata_usaha/pengesahan_spj', '[\"index\",\"update\",\"read\"]', '2021-02-15 16:13:10'),
('tata_usaha/pengesahan_spj/rinci', '[\"index\",\"read\",\"update\"]', '2021-02-15 16:14:02'),
('tata_usaha/pengesahan_spj/spj', '[\"index\",\"read\"]', '2021-02-15 16:13:05'),
('tata_usaha/pengesahan_spj/sub_unit', '[\"index\",\"read\"]', '2021-02-15 16:12:46'),
('tata_usaha/spm', '[\"index\"]', '2021-02-15 10:08:52'),
('tata_usaha/spm/spp', '[\"index\",\"read\"]', '2021-02-15 16:20:19'),
('tata_usaha/spm/sub_unit', '[\"index\",\"read\"]', '2021-02-15 16:19:58'),
('tata_usaha/tagihan', '[\"create\",\"read\",\"update\",\"delete\"]', '2021-04-24 20:23:17'),
('tata_usaha/tagihan/kontrak', '[\"index\",\"create\",\"read\"]', '2021-04-24 19:19:58'),
('tata_usaha/tagihan/kontrak/sub_unit_kontrak', '[\"index\"]', '2021-04-24 19:17:06'),
('tata_usaha/tagihan/non_kontrak', '[\"index\",\"create\",\"read\",\"update\",\"delete\"]', '2021-04-24 22:52:19'),
('tata_usaha/tagihan/sub_unit_kontrak', '[\"index\",\"read\"]', '2021-04-24 19:19:31'),
('tata_usaha/tagihan/sub_unit_non_kontrak', '[\"index\",\"read\"]', '2021-04-24 22:30:17'),
('tata_usaha/tagihan/tagihan', '[\"index\"]', '2021-04-24 19:46:47'),
('tata_usaha/tagihan/tagihan_kontrak', '[\"index\",\"create\",\"read\",\"update\",\"delete\"]', '2021-04-24 20:30:20'),
('tata_usaha/verifikasi/spp', '[\"index\",\"read\",\"update\"]', '2021-02-15 16:18:40'),
('tata_usaha/verifikasi/spp/tu', '[\"index\"]', '2021-04-07 11:51:06');

-- --------------------------------------------------------

--
-- Table structure for table `app__languages`
--

CREATE TABLE `app__languages` (
  `id` int(11) NOT NULL,
  `language` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `description` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(32) NOT NULL,
  `locale` varchar(64) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `app__languages`
--

INSERT INTO `app__languages` (`id`, `language`, `description`, `code`, `locale`, `status`) VALUES
(1, 'Default (English)', 'Default language', 'en', 'en-US,en_US,en_US.UTF8,en-us,en,english', 1),
(2, 'Bahasa Indonesia', 'Terjemahan bahasa Indonesia', 'id', 'id-ID,id_ID,id_ID.UTF8,id-id,id,indonesian', 1);

-- --------------------------------------------------------

--
-- Table structure for table `app__menus`
--

CREATE TABLE `app__menus` (
  `menu_id` int(11) NOT NULL,
  `menu_placement` varchar(22) COLLATE utf8_unicode_ci NOT NULL,
  `menu_label` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `menu_description` text COLLATE utf8_unicode_ci NOT NULL,
  `serialized_data` longtext COLLATE utf8_unicode_ci NOT NULL,
  `group_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `app__menus`
--

INSERT INTO `app__menus` (`menu_id`, `menu_placement`, `menu_label`, `menu_description`, `serialized_data`, `group_id`, `status`) VALUES
(1, 'header', 'Header Menu', 'Menu for navigation header (front end)', '[{\"order\":0,\"children\":[]},{\"id\":\"1\",\"icon\":\"mdi mdi-home\",\"label\":\"Home\",\"slug\":\"home\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"3\",\"icon\":\"mdi mdi-newspaper\",\"label\":\"News\",\"slug\":\"blogs\",\"newtab\":\"0\",\"order\":3,\"children\":[]},{\"id\":\"4\",\"icon\":\"mdi mdi-map-clock-outline\",\"label\":\"Galleries\",\"slug\":\"galleries\",\"newtab\":\"0\",\"order\":4,\"children\":[]}]', 0, 1),
(2, 'sidebar', 'Administrator', 'For administrator role', '[{\"order\":0,\"children\":[]},{\"id\":\"1\",\"icon\":\"mdi mdi-shape-plus\",\"label\":\"Perencanaan\",\"slug\":\"perencanaan\",\"newtab\":\"0\",\"order\":1,\"children\":[{\"id\":\"1\",\"icon\":\"mdi mdi-robot-industrial\",\"label\":\"RPJMD\",\"slug\":\"rpjmd\",\"newtab\":\"0\",\"order\":0,\"children\":[{\"id\":\"0\",\"icon\":\"mdi mdi-blackberry\",\"label\":\"Program\",\"slug\":\"rpjmd/program\",\"newtab\":\"0\",\"order\":0,\"children\":[]}]},{\"id\":\"1\",\"icon\":\"mdi mdi-coffee-to-go\",\"label\":\"Sub Kegiatan\",\"slug\":\"sub_kegiatan\",\"newtab\":\"0\",\"order\":1,\"children\":[]}]},{\"id\":\"2\",\"icon\":\"mdi mdi-blender-software\",\"label\":\"Anggaran\",\"slug\":\"anggaran\",\"newtab\":\"0\",\"order\":2,\"children\":[{\"id\":\"2\",\"icon\":\"mdi mdi-scissors-cutting\",\"label\":\"Pendapatan\",\"slug\":\"anggaran/pendapatan\",\"newtab\":\"0\",\"order\":0,\"children\":[]},{\"id\":\"2\",\"icon\":\"mdi mdi-scale\",\"label\":\"Belanja\",\"slug\":\"anggaran\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"2\",\"icon\":\"mdi mdi-robot-industrial\",\"label\":\"Pembiayaan\",\"slug\":\"anggaran/pembiayaan\",\"newtab\":\"0\",\"order\":2,\"children\":[]},{\"id\":\"2\",\"icon\":\"mdi mdi-arrow-collapse-all\",\"label\":\"Verifikasi\",\"slug\":\"asistensi\",\"newtab\":\"0\",\"order\":3,\"children\":[]},{\"id\":\"2\",\"icon\":\"mdi mdi-ear-hearing\",\"label\":\"Standar Harga\",\"slug\":\"standar_harga\",\"newtab\":\"0\",\"order\":4,\"children\":[]}]},{\"id\":\"3\",\"icon\":\"mdi mdi-shower-head\",\"label\":\"Bendahara Pengeluaran\",\"slug\":\"bendahara\",\"newtab\":\"0\",\"order\":3,\"children\":[{\"id\":\"3\",\"icon\":\"mdi mdi-rhombus-split\",\"label\":\"Bukti Pengeluaran\",\"slug\":\"pengeluaran\",\"newtab\":\"0\",\"order\":0,\"children\":[{\"id\":\"0\",\"icon\":\"mdi mdi-repeat-once\",\"label\":\"UP/GU\",\"slug\":\"bendahara/bukti_pengeluaran\",\"newtab\":\"0\",\"order\":0,\"children\":[]},{\"id\":\"0\",\"icon\":\"mdi mdi-radiobox-blank\",\"label\":\"TU\",\"slug\":\"bendahara/bukti_pengeluaran\",\"newtab\":\"0\",\"order\":1,\"children\":[]}]},{\"id\":\"3\",\"icon\":\"mdi mdi-seal\",\"label\":\"Pembuatan SPP\",\"slug\":\"bendahara/pengeluaran/spp\",\"newtab\":\"0\",\"order\":1,\"children\":[{\"id\":\"1\",\"icon\":\"mdi mdi-reflect-vertical\",\"label\":\"UP\",\"slug\":\"bendahara/spp/up\",\"newtab\":\"0\",\"order\":0,\"children\":[]},{\"id\":\"1\",\"icon\":\"mdi mdi-currency-ils\",\"label\":\"LS\",\"slug\":\"bendahara/spp/ls\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"1\",\"icon\":\"mdi mdi-repeat-once\",\"label\":\"GU\",\"slug\":\"bendahara/spp/gu\",\"newtab\":\"0\",\"order\":2,\"children\":[]},{\"id\":\"1\",\"icon\":\"mdi mdi-sack\",\"label\":\"TU\",\"slug\":\"bendahara/spp/tu\",\"newtab\":\"0\",\"order\":3,\"children\":[]},{\"id\":\"1\",\"icon\":\"mdi mdi-tumblr-reblog\",\"label\":\"Nihil\",\"slug\":\"bendahara/spp/nihil\",\"newtab\":\"0\",\"order\":4,\"children\":[]}]},{\"id\":\"3\",\"icon\":\"mdi mdi-select-color\",\"label\":\"Panjar & SPJ Panjar\",\"slug\":\"bendahara/panjar\",\"newtab\":\"0\",\"order\":2,\"children\":[]},{\"id\":\"3\",\"icon\":\"mdi mdi-skype\",\"label\":\"SPJ\",\"slug\":\"bendahara/spj\",\"newtab\":\"0\",\"order\":3,\"children\":[]},{\"id\":\"3\",\"icon\":\"mdi mdi-shape-plus\",\"label\":\"Pajak\",\"slug\":\"bendahara/pajak\",\"newtab\":\"0\",\"order\":4,\"children\":[]},{\"id\":\"3\",\"icon\":\"mdi mdi-smoking\",\"label\":\"Mutasi Kas Tunai - Bank\",\"slug\":\"bendahara/mutasi\",\"newtab\":\"0\",\"order\":5,\"children\":[]},{\"id\":\"3\",\"icon\":\"mdi mdi-soccer-field\",\"label\":\"Setoran Sisa UP\",\"slug\":\"bendahara/sisa_up\",\"newtab\":\"0\",\"order\":6,\"children\":[]},{\"id\":\"3\",\"icon\":\"mdi mdi-radio-tower\",\"label\":\"Bukti Panjar\",\"slug\":\"bendahara/bukti_panjar\",\"newtab\":\"0\",\"order\":7,\"children\":[]},{\"id\":\"3\",\"icon\":\"mdi mdi-source-pull\",\"label\":\"SP3B\",\"slug\":\"bendahara/sp3b\",\"newtab\":\"0\",\"order\":8,\"children\":[]}]},{\"id\":\"4\",\"icon\":\"mdi mdi-script-text-outline\",\"label\":\"Bendahara Penerimaan\",\"slug\":\"bendahara/penerimaan\",\"newtab\":\"0\",\"order\":4,\"children\":[{\"id\":\"4\",\"icon\":\"mdi mdi-pound-box\",\"label\":\"Ketetapan Pendapatan\",\"slug\":\"bendahara/ketetapan\",\"newtab\":\"0\",\"order\":0,\"children\":[]},{\"id\":\"4\",\"icon\":\"mdi mdi-pokeball\",\"label\":\"Bukti Penerimaan\",\"slug\":\"bendahara/bukti_penerimaan\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"4\",\"icon\":\"mdi mdi-pinwheel-outline\",\"label\":\"STS\",\"slug\":\"bendahara/sts\",\"newtab\":\"0\",\"order\":2,\"children\":[]}]},{\"id\":\"5\",\"icon\":\"mdi mdi-sofa\",\"label\":\"Tata Usaha\",\"slug\":\"tata_usaha\",\"newtab\":\"0\",\"order\":5,\"children\":[{\"id\":\"5\",\"icon\":\"mdi mdi-sigma\",\"label\":\"Kontrak\",\"slug\":\"tata_usaha/kontrak\",\"newtab\":\"0\",\"order\":0,\"children\":[]},{\"id\":\"5\",\"icon\":\"mdi mdi-spotlight\",\"label\":\"Tagihan\",\"slug\":\"tata_usaha/tagihan\",\"newtab\":\"0\",\"order\":1,\"children\":[{\"id\":\"1\",\"icon\":\"mdi mdi-registered-trademark\",\"label\":\"Kontrak\",\"slug\":\"tata_usaha/tagihan/kontrak\",\"newtab\":\"0\",\"order\":0,\"children\":[]},{\"id\":\"1\",\"icon\":\"mdi mdi-read\",\"label\":\"Non Kontrak\",\"slug\":\"tata_usaha/tagihan/non_kontrak\",\"newtab\":\"0\",\"order\":1,\"children\":[]}]},{\"id\":\"5\",\"icon\":\"mdi mdi-snowflake\",\"label\":\"Pengesahan SPJ\",\"slug\":\"tata_usaha/pengesahan_spj\",\"newtab\":\"0\",\"order\":2,\"children\":[]},{\"id\":\"5\",\"icon\":\"mdi mdi-shovel\",\"label\":\"Verifikasi SPP\",\"slug\":\"tata_usaha/verifikasi/spp\",\"newtab\":\"0\",\"order\":3,\"children\":[{\"id\":\"3\",\"icon\":\"mdi mdi-reflect-vertical\",\"label\":\"UP\",\"slug\":\"tata_usaha/verifikasi/spp/up\",\"newtab\":\"0\",\"order\":0,\"children\":[]},{\"id\":\"3\",\"icon\":\"mdi mdi-sack\",\"label\":\"TU\",\"slug\":\"tata_usaha/verifikasi/spp/tu\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"3\",\"icon\":\"mdi mdi-repeat-once\",\"label\":\"GU\",\"slug\":\"tata_usaha/verifikasi/spp/gu\",\"newtab\":\"0\",\"order\":2,\"children\":[]},{\"id\":\"3\",\"icon\":\"mdi mdi-currency-ils\",\"label\":\"LS\",\"slug\":\"tata_usaha/verifikasi/spp/ls\",\"newtab\":\"0\",\"order\":3,\"children\":[]},{\"id\":\"3\",\"icon\":\"mdi mdi-tumblr-reblog\",\"label\":\"Nihil\",\"slug\":\"tata_usaha/verifikasi/spp/nihil\",\"newtab\":\"0\",\"order\":4,\"children\":[]}]},{\"id\":\"5\",\"icon\":\"mdi mdi-react\",\"label\":\"Pembuatan SPM\",\"slug\":\"tata_usaha/spm\",\"newtab\":\"0\",\"order\":4,\"children\":[]}]},{\"id\":\"6\",\"icon\":\"mdi mdi-diamond-stone\",\"label\":\"BUD\",\"slug\":\"bud\",\"newtab\":\"0\",\"order\":6,\"children\":[{\"id\":\"6\",\"icon\":\"mdi mdi-paw\",\"label\":\"SPD\",\"slug\":\"bud/spd\",\"newtab\":\"0\",\"order\":0,\"children\":[]},{\"id\":\"6\",\"icon\":\"mdi mdi-parachute-outline\",\"label\":\"SP2D\",\"slug\":\"bud/sp2d\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"6\",\"icon\":\"mdi mdi-sheep\",\"label\":\"Daftar Penguji SP2D\",\"slug\":\"bud/daftar_penguji\",\"newtab\":\"0\",\"order\":2,\"children\":[]},{\"id\":\"6\",\"icon\":\"mdi mdi-sign-direction\",\"label\":\"SP2B\",\"slug\":\"bud/sp2b\",\"newtab\":\"0\",\"order\":3,\"children\":[]}]},{\"id\":\"7\",\"icon\":\"mdi mdi-chart-areaspline\",\"label\":\"Laporan\",\"slug\":\"laporan\",\"newtab\":\"0\",\"order\":7,\"children\":[{\"id\":\"7\",\"icon\":\"mdi mdi-chart-line-stacked\",\"label\":\"Anggaran\",\"slug\":\"laporan/anggaran\",\"newtab\":\"0\",\"order\":0,\"children\":[{\"id\":\"0\",\"icon\":\"mdi mdi-chart-arc\",\"label\":\"RKA\",\"slug\":\"laporan/anggaran/rka\",\"newtab\":\"0\",\"order\":0,\"children\":[]},{\"id\":\"0\",\"icon\":\"mdi mdi-chart-areaspline\",\"label\":\"Anggaran Kas\",\"slug\":\"laporan/anggaran/anggaran_kas\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"0\",\"icon\":\"mdi mdi-chart-bar\",\"label\":\"DPA\",\"slug\":\"laporan/anggaran/dpa\",\"newtab\":\"0\",\"order\":2,\"children\":[]}]},{\"id\":\"7\",\"icon\":\"mdi mdi-chart-scatterplot-hexbin\",\"label\":\"Bendahara\",\"slug\":\"laporan/bendahara\",\"newtab\":\"0\",\"order\":1,\"children\":[{\"id\":\"1\",\"icon\":\"mdi mdi-chart-bar-stacked\",\"label\":\"Penerimaan\",\"slug\":\"laporan/bendahara/penerimaan\",\"newtab\":\"0\",\"order\":0,\"children\":[]},{\"id\":\"1\",\"icon\":\"mdi mdi-chart-bell-curve\",\"label\":\"Pengeluaran\",\"slug\":\"laporan/bendahara/pengeluaran\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"1\",\"icon\":\"mdi mdi-chart-bubble\",\"label\":\"Dokumen Kendali\",\"slug\":\"laporan/bendahara/dokumen_kendali\",\"newtab\":\"0\",\"order\":2,\"children\":[]}]},{\"id\":\"7\",\"icon\":\"mdi mdi-chart-multiline\",\"label\":\"Tata Usaha\",\"slug\":\"laporan/tata_usaha\",\"newtab\":\"0\",\"order\":2,\"children\":[]},{\"id\":\"7\",\"icon\":\"mdi mdi-chart-line-variant\",\"label\":\"Pembukuan\",\"slug\":\"laporan/pembukuan\",\"newtab\":\"0\",\"order\":3,\"children\":[{\"id\":\"3\",\"icon\":\"mdi mdi-chart-donut\",\"label\":\"Basis\",\"slug\":\"laporan/pembukuan/basis\",\"newtab\":\"0\",\"order\":0,\"children\":[]},{\"id\":\"3\",\"icon\":\"mdi mdi-chart-donut-variant\",\"label\":\"Akrual\",\"slug\":\"laporan/pembukuan/akrual\",\"newtab\":\"0\",\"order\":1,\"children\":[]}]}]},{\"id\":\"8\",\"icon\":\"mdi mdi-briefcase-search\",\"label\":\"Master\",\"slug\":\"master\",\"newtab\":\"0\",\"order\":8,\"children\":[{\"id\":\"8\",\"icon\":\"mdi mdi-send\",\"label\":\"Posting\",\"slug\":\"master/posting\",\"newtab\":\"0\",\"order\":0,\"children\":[]},{\"id\":\"8\",\"icon\":\"mdi mdi-cogs\",\"label\":\"Settings\",\"slug\":\"master/settings\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"8\",\"icon\":\"mdi mdi-file-table-outline\",\"label\":\"Sumber Dana\",\"slug\":\"master/sumber_dana\",\"newtab\":\"0\",\"order\":2,\"children\":[]},{\"id\":\"8\",\"icon\":\"mdi mdi-radioactive\",\"label\":\"Anggaran\",\"slug\":\"master/anggaran\",\"newtab\":\"0\",\"order\":3,\"children\":[{\"id\":\"3\",\"icon\":\"mdi mdi-account-group\",\"label\":\"Tim Anggaran\",\"slug\":\"master/anggaran/tim_anggaran\",\"newtab\":\"0\",\"order\":0,\"children\":[]},{\"id\":\"3\",\"icon\":\"mdi mdi-account-card-details\",\"label\":\"Penandatangan Dokumen\",\"slug\":\"master/anggaran/penandatangan\",\"newtab\":\"0\",\"order\":1,\"children\":[]}]},{\"id\":\"8\",\"icon\":\"mdi mdi-format-list-bulleted\",\"label\":\"Urusan & Program\",\"slug\":\"master/data/urusan\",\"newtab\":\"0\",\"order\":4,\"children\":[{\"id\":\"4\",\"icon\":\"mdi mdi-buddhism\",\"label\":\"Urusan\",\"slug\":\"master/data/urusan\",\"newtab\":\"0\",\"order\":0,\"children\":[]},{\"id\":\"4\",\"icon\":\"mdi mdi-bus-articulated-front\",\"label\":\"Bidang\",\"slug\":\"master/data/bidang\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"4\",\"icon\":\"mdi mdi-car-wash\",\"label\":\"Program\",\"slug\":\"master/data/program\",\"newtab\":\"0\",\"order\":2,\"children\":[]},{\"id\":\"4\",\"icon\":\"mdi mdi-content-duplicate\",\"label\":\"Kegiatan\",\"slug\":\"master/data/kegiatan\",\"newtab\":\"0\",\"order\":3,\"children\":[]}]},{\"id\":\"8\",\"icon\":\"mdi mdi-cube-scan\",\"label\":\"SKPD\",\"slug\":\"master/data/units\",\"newtab\":\"0\",\"order\":5,\"children\":[{\"id\":\"5\",\"icon\":\"mdi mdi-arrow-decision-auto\",\"label\":\"Unit\",\"slug\":\"master/data/units\",\"newtab\":\"0\",\"order\":0,\"children\":[]},{\"id\":\"5\",\"icon\":\"mdi mdi-artstation\",\"label\":\"Sub Unit\",\"slug\":\"master/data/sub_units\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"5\",\"icon\":\"mdi mdi-react\",\"label\":\"BLUD/JKN/BOS\",\"slug\":\"master/data/blud_jkn_bos\",\"newtab\":\"0\",\"order\":2,\"children\":[]}]},{\"id\":\"8\",\"icon\":\"mdi mdi-cash-multiple\",\"label\":\"Rekening\",\"slug\":\"master/rekening\",\"newtab\":\"0\",\"order\":6,\"children\":[{\"id\":\"6\",\"icon\":\"mdi mdi-dialpad\",\"label\":\"Akun\",\"slug\":\"master/rekening/akun\",\"newtab\":\"0\",\"order\":0,\"children\":[]},{\"id\":\"6\",\"icon\":\"mdi mdi-cube-send\",\"label\":\"Kelompok\",\"slug\":\"master/rekening/kelompok\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"6\",\"icon\":\"mdi mdi-cart-outline\",\"label\":\"Jenis Belanja\",\"slug\":\"master/rekening/jenis_belanja\",\"newtab\":\"0\",\"order\":2,\"children\":[]},{\"id\":\"6\",\"icon\":\"mdi mdi-cart-plus\",\"label\":\"Objek Belanja\",\"slug\":\"master/rekening/objek_belanja\",\"newtab\":\"0\",\"order\":3,\"children\":[]},{\"id\":\"6\",\"icon\":\"mdi mdi-format-list-numbered\",\"label\":\"Rincian Objek\",\"slug\":\"master/rekening/rincian_objek\",\"newtab\":\"0\",\"order\":4,\"children\":[]},{\"id\":\"6\",\"icon\":\"mdi mdi-scissors-cutting\",\"label\":\"Potongan SPM\",\"slug\":\"master/rekening/potongan_spm\",\"newtab\":\"0\",\"order\":5,\"children\":[]}]},{\"id\":\"8\",\"icon\":\"mdi mdi-cash-register\",\"label\":\"Standar Harga\",\"slug\":\"master/standar_harga\",\"newtab\":\"0\",\"order\":7,\"children\":[{\"id\":\"7\",\"icon\":\"mdi mdi-shield-airplane-outline\",\"label\":\"Akun\",\"slug\":\"master/standar_harga/akun\",\"newtab\":\"0\",\"order\":0,\"children\":[]},{\"id\":\"7\",\"icon\":\"mdi mdi-sigma-lower\",\"label\":\"Kelompok\",\"slug\":\"master/standar_harga/kelompok\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"7\",\"icon\":\"mdi mdi-shape-outline\",\"label\":\"Jenis\",\"slug\":\"master/standar_harga/jenis\",\"newtab\":\"0\",\"order\":2,\"children\":[]},{\"id\":\"7\",\"icon\":\"mdi mdi-source-fork\",\"label\":\"Standar Harga\",\"slug\":\"master/standar_harga/standar_harga\",\"newtab\":\"0\",\"order\":3,\"children\":[]}]},{\"id\":\"8\",\"icon\":\"mdi mdi-sync\",\"label\":\"Sinkronisasi\",\"slug\":\"master/sinkronisasi\",\"newtab\":\"0\",\"order\":8,\"children\":[]}]}]', 1, 1),
(3, 'sidebar', 'Anggaran Pembiayaan', 'Sidebar Anggaran Pembiayaan', '[{\"order\":0,\"children\":[]},{\"id\":\"1\",\"icon\":\"mdi mdi-coffee-to-go\",\"label\":\"Sub Kegiatan\",\"slug\":\"sub_kegiatan\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"1\",\"icon\":\"mdi mdi-blender-software\",\"label\":\"Anggaran\",\"slug\":\"anggaran/rekening\",\"newtab\":\"0\",\"order\":2,\"children\":[{\"id\":\"1\",\"icon\":\"mdi mdi-scale\",\"label\":\"Anggaran\",\"slug\":\"anggaran\",\"newtab\":\"0\",\"order\":0,\"children\":[]},{\"id\":\"1\",\"icon\":\"mdi mdi-arrow-collapse-all\",\"label\":\"Verifikasi\",\"slug\":\"asistensi\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"10\",\"icon\":\"mdi mdi-ear-hearing\",\"label\":\"Standar Harga\",\"slug\":\"standar_harga\",\"newtab\":\"0\",\"order\":2,\"children\":[]}]},{\"id\":\"2\",\"icon\":\"mdi mdi-shower-head\",\"label\":\"Pendapatan\",\"slug\":\"pendapatan\",\"newtab\":\"0\",\"order\":3,\"children\":[]},{\"id\":\"3\",\"icon\":\"mdi mdi-sofa\",\"label\":\"Mutasi Kas\",\"slug\":\"mutasi_kas\",\"newtab\":\"0\",\"order\":4,\"children\":[]},{\"id\":\"4\",\"icon\":\"mdi mdi-diamond-stone\",\"label\":\"Belanja\",\"slug\":\"belanja\",\"newtab\":\"0\",\"order\":5,\"children\":[]},{\"id\":\"5\",\"icon\":\"mdi mdi-podium\",\"label\":\"Pajak\",\"slug\":\"pajak\",\"newtab\":\"0\",\"order\":6,\"children\":[]},{\"id\":\"6\",\"icon\":\"mdi mdi-paw\",\"label\":\"SP2B\",\"slug\":\"sp2b\",\"newtab\":\"0\",\"order\":7,\"children\":[]},{\"id\":\"7\",\"icon\":\"mdi mdi-chart-areaspline\",\"label\":\"laporan\",\"slug\":\"laporan\",\"newtab\":\"0\",\"order\":8,\"children\":[{\"id\":\"7\",\"icon\":\"mdi mdi-chart-line-stacked\",\"label\":\"Anggaran\",\"slug\":\"laporan/anggaran\",\"newtab\":\"0\",\"order\":0,\"children\":[]},{\"id\":\"7\",\"icon\":\"mdi mdi-chart-multiline\",\"label\":\"Tata Usaha\",\"slug\":\"laporan/tata_usaha\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"7\",\"icon\":\"mdi mdi-chart-scatterplot-hexbin\",\"label\":\"BOS\",\"slug\":\"laporan/bos\",\"newtab\":\"0\",\"order\":2,\"children\":[]},{\"id\":\"7\",\"icon\":\"mdi mdi-chart-line-variant\",\"label\":\"Pembukuan\",\"slug\":\"laporan/pembukuan\",\"newtab\":\"0\",\"order\":3,\"children\":[]}]}]', 23, 1),
(4, 'sidebar', 'Anggaran Pendapatan', 'Sidebar Anggaran Pendapatan', '[{\"order\":0,\"children\":[]},{\"id\":\"1\",\"icon\":\"mdi mdi-coffee-to-go\",\"label\":\"Sub Kegiatan\",\"slug\":\"sub_kegiatan\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"1\",\"icon\":\"mdi mdi-blender-software\",\"label\":\"Anggaran\",\"slug\":\"anggaran/rekening\",\"newtab\":\"0\",\"order\":2,\"children\":[{\"id\":\"1\",\"icon\":\"mdi mdi-scale\",\"label\":\"Anggaran\",\"slug\":\"anggaran\",\"newtab\":\"0\",\"order\":0,\"children\":[]},{\"id\":\"1\",\"icon\":\"mdi mdi-arrow-collapse-all\",\"label\":\"Verifikasi\",\"slug\":\"asistensi\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"10\",\"icon\":\"mdi mdi-ear-hearing\",\"label\":\"Standar Harga\",\"slug\":\"standar_harga\",\"newtab\":\"0\",\"order\":2,\"children\":[]}]},{\"id\":\"2\",\"icon\":\"mdi mdi-shower-head\",\"label\":\"Pendapatan\",\"slug\":\"pendapatan\",\"newtab\":\"0\",\"order\":3,\"children\":[]},{\"id\":\"3\",\"icon\":\"mdi mdi-sofa\",\"label\":\"Mutasi Kas\",\"slug\":\"mutasi_kas\",\"newtab\":\"0\",\"order\":4,\"children\":[]},{\"id\":\"4\",\"icon\":\"mdi mdi-diamond-stone\",\"label\":\"Belanja\",\"slug\":\"belanja\",\"newtab\":\"0\",\"order\":5,\"children\":[]},{\"id\":\"5\",\"icon\":\"mdi mdi-podium\",\"label\":\"Pajak\",\"slug\":\"pajak\",\"newtab\":\"0\",\"order\":6,\"children\":[]},{\"id\":\"6\",\"icon\":\"mdi mdi-paw\",\"label\":\"SP2B\",\"slug\":\"sp2b\",\"newtab\":\"0\",\"order\":7,\"children\":[]},{\"id\":\"7\",\"icon\":\"mdi mdi-chart-areaspline\",\"label\":\"laporan\",\"slug\":\"laporan\",\"newtab\":\"0\",\"order\":8,\"children\":[{\"id\":\"7\",\"icon\":\"mdi mdi-chart-line-stacked\",\"label\":\"Anggaran\",\"slug\":\"laporan/anggaran\",\"newtab\":\"0\",\"order\":0,\"children\":[]},{\"id\":\"7\",\"icon\":\"mdi mdi-chart-multiline\",\"label\":\"Tata Usaha\",\"slug\":\"laporan/tata_usaha\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"7\",\"icon\":\"mdi mdi-chart-scatterplot-hexbin\",\"label\":\"BOS\",\"slug\":\"laporan/bos\",\"newtab\":\"0\",\"order\":2,\"children\":[]},{\"id\":\"7\",\"icon\":\"mdi mdi-chart-line-variant\",\"label\":\"Pembukuan\",\"slug\":\"laporan/pembukuan\",\"newtab\":\"0\",\"order\":3,\"children\":[]}]}]', 24, 1),
(5, 'sidebar', 'Unit 2', 'Sidebar Unit 2', '[{\"order\":0,\"children\":[]},{\"id\":\"1\",\"icon\":\"mdi mdi-coffee-to-go\",\"label\":\"Sub Kegiatan\",\"slug\":\"sub_kegiatan\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"1\",\"icon\":\"mdi mdi-blender-software\",\"label\":\"Anggaran\",\"slug\":\"anggaran/rekening\",\"newtab\":\"0\",\"order\":2,\"children\":[{\"id\":\"1\",\"icon\":\"mdi mdi-scale\",\"label\":\"Anggaran\",\"slug\":\"anggaran\",\"newtab\":\"0\",\"order\":0,\"children\":[]},{\"id\":\"1\",\"icon\":\"mdi mdi-arrow-collapse-all\",\"label\":\"Verifikasi\",\"slug\":\"asistensi\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"10\",\"icon\":\"mdi mdi-ear-hearing\",\"label\":\"Standar Harga\",\"slug\":\"standar_harga\",\"newtab\":\"0\",\"order\":2,\"children\":[]}]},{\"id\":\"2\",\"icon\":\"mdi mdi-shower-head\",\"label\":\"Pendapatan\",\"slug\":\"pendapatan\",\"newtab\":\"0\",\"order\":3,\"children\":[]},{\"id\":\"3\",\"icon\":\"mdi mdi-sofa\",\"label\":\"Mutasi Kas\",\"slug\":\"mutasi_kas\",\"newtab\":\"0\",\"order\":4,\"children\":[]},{\"id\":\"4\",\"icon\":\"mdi mdi-diamond-stone\",\"label\":\"Belanja\",\"slug\":\"belanja\",\"newtab\":\"0\",\"order\":5,\"children\":[]},{\"id\":\"5\",\"icon\":\"mdi mdi-podium\",\"label\":\"Pajak\",\"slug\":\"pajak\",\"newtab\":\"0\",\"order\":6,\"children\":[]},{\"id\":\"6\",\"icon\":\"mdi mdi-paw\",\"label\":\"SP2B\",\"slug\":\"sp2b\",\"newtab\":\"0\",\"order\":7,\"children\":[]},{\"id\":\"7\",\"icon\":\"mdi mdi-chart-areaspline\",\"label\":\"laporan\",\"slug\":\"laporan\",\"newtab\":\"0\",\"order\":8,\"children\":[{\"id\":\"7\",\"icon\":\"mdi mdi-chart-line-stacked\",\"label\":\"Anggaran\",\"slug\":\"laporan/anggaran\",\"newtab\":\"0\",\"order\":0,\"children\":[]},{\"id\":\"7\",\"icon\":\"mdi mdi-chart-multiline\",\"label\":\"Tata Usaha\",\"slug\":\"laporan/tata_usaha\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"7\",\"icon\":\"mdi mdi-chart-scatterplot-hexbin\",\"label\":\"BOS\",\"slug\":\"laporan/bos\",\"newtab\":\"0\",\"order\":2,\"children\":[]},{\"id\":\"7\",\"icon\":\"mdi mdi-chart-line-variant\",\"label\":\"Pembukuan\",\"slug\":\"laporan/pembukuan\",\"newtab\":\"0\",\"order\":3,\"children\":[]}]}]', 6, 1),
(6, 'sidebar', 'Sub Unit', 'Sidebar Sub Unit', '[{\"order\":0,\"children\":[]},{\"id\":\"1\",\"icon\":\"mdi mdi-coffee-to-go\",\"label\":\"Sub Kegiatan\",\"slug\":\"sub_kegiatan\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"1\",\"icon\":\"mdi mdi-blender-software\",\"label\":\"Anggaran\",\"slug\":\"anggaran/rekening\",\"newtab\":\"0\",\"order\":2,\"children\":[{\"id\":\"1\",\"icon\":\"mdi mdi-scale\",\"label\":\"Anggaran\",\"slug\":\"anggaran\",\"newtab\":\"0\",\"order\":0,\"children\":[]},{\"id\":\"1\",\"icon\":\"mdi mdi-arrow-collapse-all\",\"label\":\"Verifikasi\",\"slug\":\"asistensi\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"10\",\"icon\":\"mdi mdi-ear-hearing\",\"label\":\"Standar Harga\",\"slug\":\"standar_harga\",\"newtab\":\"0\",\"order\":2,\"children\":[]}]},{\"id\":\"2\",\"icon\":\"mdi mdi-shower-head\",\"label\":\"Pendapatan\",\"slug\":\"pendapatan\",\"newtab\":\"0\",\"order\":3,\"children\":[]},{\"id\":\"3\",\"icon\":\"mdi mdi-sofa\",\"label\":\"Mutasi Kas\",\"slug\":\"mutasi_kas\",\"newtab\":\"0\",\"order\":4,\"children\":[]},{\"id\":\"4\",\"icon\":\"mdi mdi-diamond-stone\",\"label\":\"Belanja\",\"slug\":\"belanja\",\"newtab\":\"0\",\"order\":5,\"children\":[]},{\"id\":\"5\",\"icon\":\"mdi mdi-podium\",\"label\":\"Pajak\",\"slug\":\"pajak\",\"newtab\":\"0\",\"order\":6,\"children\":[]},{\"id\":\"6\",\"icon\":\"mdi mdi-paw\",\"label\":\"SP2B\",\"slug\":\"sp2b\",\"newtab\":\"0\",\"order\":7,\"children\":[]},{\"id\":\"7\",\"icon\":\"mdi mdi-chart-areaspline\",\"label\":\"laporan\",\"slug\":\"laporan\",\"newtab\":\"0\",\"order\":8,\"children\":[{\"id\":\"7\",\"icon\":\"mdi mdi-chart-line-stacked\",\"label\":\"Anggaran\",\"slug\":\"laporan/anggaran\",\"newtab\":\"0\",\"order\":0,\"children\":[]},{\"id\":\"7\",\"icon\":\"mdi mdi-chart-multiline\",\"label\":\"Tata Usaha\",\"slug\":\"laporan/tata_usaha\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"7\",\"icon\":\"mdi mdi-chart-scatterplot-hexbin\",\"label\":\"BOS\",\"slug\":\"laporan/bos\",\"newtab\":\"0\",\"order\":2,\"children\":[]},{\"id\":\"7\",\"icon\":\"mdi mdi-chart-line-variant\",\"label\":\"Pembukuan\",\"slug\":\"laporan/pembukuan\",\"newtab\":\"0\",\"order\":3,\"children\":[]}]}]', 7, 1),
(7, 'sidebar', 'Pemeriksa', 'Sidebar Pemeriksa', '[{\"order\":0,\"children\":[]},{\"id\":\"1\",\"icon\":\"mdi mdi-coffee-to-go\",\"label\":\"Sub Kegiatan\",\"slug\":\"sub_kegiatan\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"2\",\"icon\":\"mdi mdi-blender-software\",\"label\":\"Anggaran\",\"slug\":\"anggaran/rekening\",\"newtab\":\"0\",\"order\":2,\"children\":[{\"id\":\"2\",\"icon\":\"mdi mdi-scale\",\"label\":\"Anggaran\",\"slug\":\"anggaran\",\"newtab\":\"0\",\"order\":0,\"children\":[]},{\"id\":\"2\",\"icon\":\"mdi mdi-arrow-collapse-all\",\"label\":\"Verifikasi\",\"slug\":\"asistensi\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"2\",\"icon\":\"mdi mdi-ear-hearing\",\"label\":\"Standar Harga\",\"slug\":\"standar_harga\",\"newtab\":\"0\",\"order\":2,\"children\":[]}]},{\"id\":\"3\",\"icon\":\"mdi mdi-shower-head\",\"label\":\"Pendapatan\",\"slug\":\"pendapatan\",\"newtab\":\"0\",\"order\":3,\"children\":[]},{\"id\":\"4\",\"icon\":\"mdi mdi-sofa\",\"label\":\"Mutasi Kas\",\"slug\":\"mutasi_kas\",\"newtab\":\"0\",\"order\":4,\"children\":[]},{\"id\":\"5\",\"icon\":\"mdi mdi-diamond-stone\",\"label\":\"Belanja\",\"slug\":\"belanja\",\"newtab\":\"0\",\"order\":5,\"children\":[]},{\"id\":\"6\",\"icon\":\"mdi mdi-podium\",\"label\":\"Pajak\",\"slug\":\"pajak\",\"newtab\":\"0\",\"order\":6,\"children\":[]},{\"id\":\"7\",\"icon\":\"mdi mdi-paw\",\"label\":\"SP2B\",\"slug\":\"sp2b\",\"newtab\":\"0\",\"order\":7,\"children\":[]},{\"id\":\"10\",\"icon\":\"mdi mdi-parachute-outline\",\"label\":\"SPB\",\"slug\":\"spb\",\"newtab\":\"0\",\"order\":8,\"children\":[]},{\"id\":\"8\",\"icon\":\"mdi mdi-chart-areaspline\",\"label\":\"laporan\",\"slug\":\"laporan\",\"newtab\":\"0\",\"order\":9,\"children\":[{\"id\":\"8\",\"icon\":\"mdi mdi-chart-line-stacked\",\"label\":\"Anggaran\",\"slug\":\"laporan/anggaran\",\"newtab\":\"0\",\"order\":0,\"children\":[]},{\"id\":\"8\",\"icon\":\"mdi mdi-chart-multiline\",\"label\":\"Tata Usaha\",\"slug\":\"laporan/tata_usaha\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"8\",\"icon\":\"mdi mdi-chart-scatterplot-hexbin\",\"label\":\"BOS\",\"slug\":\"laporan/bos\",\"newtab\":\"0\",\"order\":2,\"children\":[]},{\"id\":\"8\",\"icon\":\"mdi mdi-chart-line-variant\",\"label\":\"Pembukuan\",\"slug\":\"laporan/pembukuan\",\"newtab\":\"0\",\"order\":3,\"children\":[]}]}]', 21, 1),
(8, 'sidebar', 'Tim Asistensi', 'Sidebar Tim Asistensi', '[{\"order\":0,\"children\":[]},{\"id\":\"1\",\"icon\":\"mdi mdi-coffee-to-go\",\"label\":\"Sub Kegiatan\",\"slug\":\"sub_kegiatan\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"1\",\"icon\":\"mdi mdi-blender-software\",\"label\":\"Anggaran\",\"slug\":\"anggaran/rekening\",\"newtab\":\"0\",\"order\":2,\"children\":[{\"id\":\"1\",\"icon\":\"mdi mdi-scale\",\"label\":\"Anggaran\",\"slug\":\"anggaran\",\"newtab\":\"0\",\"order\":0,\"children\":[]},{\"id\":\"1\",\"icon\":\"mdi mdi-arrow-collapse-all\",\"label\":\"Verifikasi\",\"slug\":\"asistensi\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"10\",\"icon\":\"mdi mdi-ear-hearing\",\"label\":\"Standar Harga\",\"slug\":\"standar_harga\",\"newtab\":\"0\",\"order\":2,\"children\":[]}]},{\"id\":\"2\",\"icon\":\"mdi mdi-shower-head\",\"label\":\"Pendapatan\",\"slug\":\"pendapatan\",\"newtab\":\"0\",\"order\":3,\"children\":[]},{\"id\":\"3\",\"icon\":\"mdi mdi-sofa\",\"label\":\"Mutasi Kas\",\"slug\":\"mutasi_kas\",\"newtab\":\"0\",\"order\":4,\"children\":[]},{\"id\":\"4\",\"icon\":\"mdi mdi-diamond-stone\",\"label\":\"Belanja\",\"slug\":\"belanja\",\"newtab\":\"0\",\"order\":5,\"children\":[]},{\"id\":\"5\",\"icon\":\"mdi mdi-podium\",\"label\":\"Pajak\",\"slug\":\"pajak\",\"newtab\":\"0\",\"order\":6,\"children\":[]},{\"id\":\"6\",\"icon\":\"mdi mdi-paw\",\"label\":\"SP2B\",\"slug\":\"sp2b\",\"newtab\":\"0\",\"order\":7,\"children\":[]},{\"id\":\"7\",\"icon\":\"mdi mdi-chart-areaspline\",\"label\":\"laporan\",\"slug\":\"laporan\",\"newtab\":\"0\",\"order\":8,\"children\":[{\"id\":\"7\",\"icon\":\"mdi mdi-chart-line-stacked\",\"label\":\"Anggaran\",\"slug\":\"laporan/anggaran\",\"newtab\":\"0\",\"order\":0,\"children\":[]},{\"id\":\"7\",\"icon\":\"mdi mdi-chart-multiline\",\"label\":\"Tata Usaha\",\"slug\":\"laporan/tata_usaha\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"7\",\"icon\":\"mdi mdi-chart-scatterplot-hexbin\",\"label\":\"BOS\",\"slug\":\"laporan/bos\",\"newtab\":\"0\",\"order\":2,\"children\":[]},{\"id\":\"7\",\"icon\":\"mdi mdi-chart-line-variant\",\"label\":\"Pembukuan\",\"slug\":\"laporan/pembukuan\",\"newtab\":\"0\",\"order\":3,\"children\":[]}]}]', 12, 1),
(9, 'sidebar', 'Pengelola Keuangan 2', 'Sidebar Pengelola Keuangan 2', '[{\"order\":0,\"children\":[]},{\"id\":\"1\",\"icon\":\"mdi mdi-coffee-to-go\",\"label\":\"Sub Kegiatan\",\"slug\":\"sub_kegiatan\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"2\",\"icon\":\"mdi mdi-blender-software\",\"label\":\"Anggaran\",\"slug\":\"anggaran/rekening\",\"newtab\":\"0\",\"order\":2,\"children\":[{\"id\":\"2\",\"icon\":\"mdi mdi-scale\",\"label\":\"Anggaran\",\"slug\":\"anggaran\",\"newtab\":\"0\",\"order\":0,\"children\":[]},{\"id\":\"2\",\"icon\":\"mdi mdi-arrow-collapse-all\",\"label\":\"Verifikasi\",\"slug\":\"asistensi\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"2\",\"icon\":\"mdi mdi-ear-hearing\",\"label\":\"Standar Harga\",\"slug\":\"standar_harga\",\"newtab\":\"0\",\"order\":2,\"children\":[]}]},{\"id\":\"3\",\"icon\":\"mdi mdi-shower-head\",\"label\":\"Pendapatan\",\"slug\":\"pendapatan\",\"newtab\":\"0\",\"order\":3,\"children\":[]},{\"id\":\"4\",\"icon\":\"mdi mdi-sofa\",\"label\":\"Mutasi Kas\",\"slug\":\"mutasi_kas\",\"newtab\":\"0\",\"order\":4,\"children\":[]},{\"id\":\"5\",\"icon\":\"mdi mdi-diamond-stone\",\"label\":\"Belanja\",\"slug\":\"belanja\",\"newtab\":\"0\",\"order\":5,\"children\":[]},{\"id\":\"6\",\"icon\":\"mdi mdi-podium\",\"label\":\"Pajak\",\"slug\":\"pajak\",\"newtab\":\"0\",\"order\":6,\"children\":[]},{\"id\":\"7\",\"icon\":\"mdi mdi-paw\",\"label\":\"SP2B\",\"slug\":\"sp2b\",\"newtab\":\"0\",\"order\":7,\"children\":[]},{\"id\":\"10\",\"icon\":\"mdi mdi-parachute-outline\",\"label\":\"SPB\",\"slug\":\"spb\",\"newtab\":\"0\",\"order\":8,\"children\":[]},{\"id\":\"8\",\"icon\":\"mdi mdi-chart-areaspline\",\"label\":\"laporan\",\"slug\":\"laporan\",\"newtab\":\"0\",\"order\":9,\"children\":[{\"id\":\"8\",\"icon\":\"mdi mdi-chart-line-stacked\",\"label\":\"Anggaran\",\"slug\":\"laporan/anggaran\",\"newtab\":\"0\",\"order\":0,\"children\":[]},{\"id\":\"8\",\"icon\":\"mdi mdi-chart-multiline\",\"label\":\"Tata Usaha\",\"slug\":\"laporan/tata_usaha\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"8\",\"icon\":\"mdi mdi-chart-scatterplot-hexbin\",\"label\":\"BOS\",\"slug\":\"laporan/bos\",\"newtab\":\"0\",\"order\":2,\"children\":[]},{\"id\":\"8\",\"icon\":\"mdi mdi-chart-line-variant\",\"label\":\"Pembukuan\",\"slug\":\"laporan/pembukuan\",\"newtab\":\"0\",\"order\":3,\"children\":[]}]}]', 20, 1),
(10, 'sidebar', 'TTD TAPD Asistensi 2', 'Sidebar TTD TAPD Asistensi 2', '[{\"order\":0,\"children\":[]},{\"id\":\"1\",\"icon\":\"mdi mdi-coffee-to-go\",\"label\":\"Sub Kegiatan\",\"slug\":\"sub_kegiatan\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"1\",\"icon\":\"mdi mdi-blender-software\",\"label\":\"Anggaran\",\"slug\":\"anggaran/rekening\",\"newtab\":\"0\",\"order\":2,\"children\":[{\"id\":\"1\",\"icon\":\"mdi mdi-scale\",\"label\":\"Anggaran\",\"slug\":\"anggaran\",\"newtab\":\"0\",\"order\":0,\"children\":[]},{\"id\":\"1\",\"icon\":\"mdi mdi-arrow-collapse-all\",\"label\":\"Verifikasi\",\"slug\":\"asistensi\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"10\",\"icon\":\"mdi mdi-ear-hearing\",\"label\":\"Standar Harga\",\"slug\":\"standar_harga\",\"newtab\":\"0\",\"order\":2,\"children\":[]}]},{\"id\":\"2\",\"icon\":\"mdi mdi-shower-head\",\"label\":\"Pendapatan\",\"slug\":\"pendapatan\",\"newtab\":\"0\",\"order\":3,\"children\":[]},{\"id\":\"3\",\"icon\":\"mdi mdi-sofa\",\"label\":\"Mutasi Kas\",\"slug\":\"mutasi_kas\",\"newtab\":\"0\",\"order\":4,\"children\":[]},{\"id\":\"4\",\"icon\":\"mdi mdi-diamond-stone\",\"label\":\"Belanja\",\"slug\":\"belanja\",\"newtab\":\"0\",\"order\":5,\"children\":[]},{\"id\":\"5\",\"icon\":\"mdi mdi-podium\",\"label\":\"Pajak\",\"slug\":\"pajak\",\"newtab\":\"0\",\"order\":6,\"children\":[]},{\"id\":\"6\",\"icon\":\"mdi mdi-paw\",\"label\":\"SP2B\",\"slug\":\"sp2b\",\"newtab\":\"0\",\"order\":7,\"children\":[]},{\"id\":\"7\",\"icon\":\"mdi mdi-chart-areaspline\",\"label\":\"laporan\",\"slug\":\"laporan\",\"newtab\":\"0\",\"order\":8,\"children\":[{\"id\":\"7\",\"icon\":\"mdi mdi-chart-line-stacked\",\"label\":\"Anggaran\",\"slug\":\"laporan/anggaran\",\"newtab\":\"0\",\"order\":0,\"children\":[]},{\"id\":\"7\",\"icon\":\"mdi mdi-chart-multiline\",\"label\":\"Tata Usaha\",\"slug\":\"laporan/tata_usaha\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"7\",\"icon\":\"mdi mdi-chart-scatterplot-hexbin\",\"label\":\"BOS\",\"slug\":\"laporan/bos\",\"newtab\":\"0\",\"order\":2,\"children\":[]},{\"id\":\"7\",\"icon\":\"mdi mdi-chart-line-variant\",\"label\":\"Pembukuan\",\"slug\":\"laporan/pembukuan\",\"newtab\":\"0\",\"order\":3,\"children\":[]}]}]', 18, 1),
(11, 'sidebar', 'Verifikatur SSH', 'Sidebar Verifikatur SSH', '[{\"order\":0,\"children\":[]},{\"id\":\"1\",\"icon\":\"mdi mdi-coffee-to-go\",\"label\":\"Sub Kegiatan\",\"slug\":\"sub_kegiatan\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"1\",\"icon\":\"mdi mdi-blender-software\",\"label\":\"Anggaran\",\"slug\":\"anggaran/rekening\",\"newtab\":\"0\",\"order\":2,\"children\":[{\"id\":\"1\",\"icon\":\"mdi mdi-scale\",\"label\":\"Anggaran\",\"slug\":\"anggaran\",\"newtab\":\"0\",\"order\":0,\"children\":[]},{\"id\":\"1\",\"icon\":\"mdi mdi-arrow-collapse-all\",\"label\":\"Verifikasi\",\"slug\":\"asistensi\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"10\",\"icon\":\"mdi mdi-ear-hearing\",\"label\":\"Standar Harga\",\"slug\":\"standar_harga\",\"newtab\":\"0\",\"order\":2,\"children\":[]}]},{\"id\":\"2\",\"icon\":\"mdi mdi-shower-head\",\"label\":\"Pendapatan\",\"slug\":\"pendapatan\",\"newtab\":\"0\",\"order\":3,\"children\":[]},{\"id\":\"3\",\"icon\":\"mdi mdi-sofa\",\"label\":\"Mutasi Kas\",\"slug\":\"mutasi_kas\",\"newtab\":\"0\",\"order\":4,\"children\":[]},{\"id\":\"4\",\"icon\":\"mdi mdi-diamond-stone\",\"label\":\"Belanja\",\"slug\":\"belanja\",\"newtab\":\"0\",\"order\":5,\"children\":[]},{\"id\":\"5\",\"icon\":\"mdi mdi-podium\",\"label\":\"Pajak\",\"slug\":\"pajak\",\"newtab\":\"0\",\"order\":6,\"children\":[]},{\"id\":\"6\",\"icon\":\"mdi mdi-paw\",\"label\":\"SP2B\",\"slug\":\"sp2b\",\"newtab\":\"0\",\"order\":7,\"children\":[]},{\"id\":\"7\",\"icon\":\"mdi mdi-chart-areaspline\",\"label\":\"laporan\",\"slug\":\"laporan\",\"newtab\":\"0\",\"order\":8,\"children\":[{\"id\":\"7\",\"icon\":\"mdi mdi-chart-line-stacked\",\"label\":\"Anggaran\",\"slug\":\"laporan/anggaran\",\"newtab\":\"0\",\"order\":0,\"children\":[]},{\"id\":\"7\",\"icon\":\"mdi mdi-chart-multiline\",\"label\":\"Tata Usaha\",\"slug\":\"laporan/tata_usaha\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"7\",\"icon\":\"mdi mdi-chart-scatterplot-hexbin\",\"label\":\"BOS\",\"slug\":\"laporan/bos\",\"newtab\":\"0\",\"order\":2,\"children\":[]},{\"id\":\"7\",\"icon\":\"mdi mdi-chart-line-variant\",\"label\":\"Pembukuan\",\"slug\":\"laporan/pembukuan\",\"newtab\":\"0\",\"order\":3,\"children\":[]}]}]', 15, 1),
(12, 'sidebar', 'Sub Unit 2', 'Sidebar Sub Unit 2', '[{\"order\":0,\"children\":[]},{\"id\":\"1\",\"icon\":\"mdi mdi-coffee-to-go\",\"label\":\"Sub Kegiatan\",\"slug\":\"sub_kegiatan\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"1\",\"icon\":\"mdi mdi-blender-software\",\"label\":\"Anggaran\",\"slug\":\"anggaran/rekening\",\"newtab\":\"0\",\"order\":2,\"children\":[{\"id\":\"1\",\"icon\":\"mdi mdi-scale\",\"label\":\"Anggaran\",\"slug\":\"anggaran\",\"newtab\":\"0\",\"order\":0,\"children\":[]},{\"id\":\"1\",\"icon\":\"mdi mdi-arrow-collapse-all\",\"label\":\"Verifikasi\",\"slug\":\"asistensi\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"10\",\"icon\":\"mdi mdi-ear-hearing\",\"label\":\"Standar Harga\",\"slug\":\"standar_harga\",\"newtab\":\"0\",\"order\":2,\"children\":[]}]},{\"id\":\"2\",\"icon\":\"mdi mdi-shower-head\",\"label\":\"Pendapatan\",\"slug\":\"pendapatan\",\"newtab\":\"0\",\"order\":3,\"children\":[]},{\"id\":\"3\",\"icon\":\"mdi mdi-sofa\",\"label\":\"Mutasi Kas\",\"slug\":\"mutasi_kas\",\"newtab\":\"0\",\"order\":4,\"children\":[]},{\"id\":\"4\",\"icon\":\"mdi mdi-diamond-stone\",\"label\":\"Belanja\",\"slug\":\"belanja\",\"newtab\":\"0\",\"order\":5,\"children\":[]},{\"id\":\"5\",\"icon\":\"mdi mdi-podium\",\"label\":\"Pajak\",\"slug\":\"pajak\",\"newtab\":\"0\",\"order\":6,\"children\":[]},{\"id\":\"6\",\"icon\":\"mdi mdi-paw\",\"label\":\"SP2B\",\"slug\":\"sp2b\",\"newtab\":\"0\",\"order\":7,\"children\":[]},{\"id\":\"7\",\"icon\":\"mdi mdi-chart-areaspline\",\"label\":\"laporan\",\"slug\":\"laporan\",\"newtab\":\"0\",\"order\":8,\"children\":[{\"id\":\"7\",\"icon\":\"mdi mdi-chart-line-stacked\",\"label\":\"Anggaran\",\"slug\":\"laporan/anggaran\",\"newtab\":\"0\",\"order\":0,\"children\":[]},{\"id\":\"7\",\"icon\":\"mdi mdi-chart-multiline\",\"label\":\"Tata Usaha\",\"slug\":\"laporan/tata_usaha\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"7\",\"icon\":\"mdi mdi-chart-scatterplot-hexbin\",\"label\":\"BOS\",\"slug\":\"laporan/bos\",\"newtab\":\"0\",\"order\":2,\"children\":[]},{\"id\":\"7\",\"icon\":\"mdi mdi-chart-line-variant\",\"label\":\"Pembukuan\",\"slug\":\"laporan/pembukuan\",\"newtab\":\"0\",\"order\":3,\"children\":[]}]}]', 8, 1),
(13, 'sidebar', 'Verifikatur SSH 2', 'Sidebar Verifikatur SSH 2', '[{\"order\":0,\"children\":[]},{\"id\":\"1\",\"icon\":\"mdi mdi-coffee-to-go\",\"label\":\"Sub Kegiatan\",\"slug\":\"sub_kegiatan\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"1\",\"icon\":\"mdi mdi-blender-software\",\"label\":\"Anggaran\",\"slug\":\"anggaran/rekening\",\"newtab\":\"0\",\"order\":2,\"children\":[{\"id\":\"1\",\"icon\":\"mdi mdi-scale\",\"label\":\"Anggaran\",\"slug\":\"anggaran\",\"newtab\":\"0\",\"order\":0,\"children\":[]},{\"id\":\"1\",\"icon\":\"mdi mdi-arrow-collapse-all\",\"label\":\"Verifikasi\",\"slug\":\"asistensi\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"10\",\"icon\":\"mdi mdi-ear-hearing\",\"label\":\"Standar Harga\",\"slug\":\"standar_harga\",\"newtab\":\"0\",\"order\":2,\"children\":[]}]},{\"id\":\"2\",\"icon\":\"mdi mdi-shower-head\",\"label\":\"Pendapatan\",\"slug\":\"pendapatan\",\"newtab\":\"0\",\"order\":3,\"children\":[]},{\"id\":\"3\",\"icon\":\"mdi mdi-sofa\",\"label\":\"Mutasi Kas\",\"slug\":\"mutasi_kas\",\"newtab\":\"0\",\"order\":4,\"children\":[]},{\"id\":\"4\",\"icon\":\"mdi mdi-diamond-stone\",\"label\":\"Belanja\",\"slug\":\"belanja\",\"newtab\":\"0\",\"order\":5,\"children\":[]},{\"id\":\"5\",\"icon\":\"mdi mdi-podium\",\"label\":\"Pajak\",\"slug\":\"pajak\",\"newtab\":\"0\",\"order\":6,\"children\":[]},{\"id\":\"6\",\"icon\":\"mdi mdi-paw\",\"label\":\"SP2B\",\"slug\":\"sp2b\",\"newtab\":\"0\",\"order\":7,\"children\":[]},{\"id\":\"7\",\"icon\":\"mdi mdi-chart-areaspline\",\"label\":\"laporan\",\"slug\":\"laporan\",\"newtab\":\"0\",\"order\":8,\"children\":[{\"id\":\"7\",\"icon\":\"mdi mdi-chart-line-stacked\",\"label\":\"Anggaran\",\"slug\":\"laporan/anggaran\",\"newtab\":\"0\",\"order\":0,\"children\":[]},{\"id\":\"7\",\"icon\":\"mdi mdi-chart-multiline\",\"label\":\"Tata Usaha\",\"slug\":\"laporan/tata_usaha\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"7\",\"icon\":\"mdi mdi-chart-scatterplot-hexbin\",\"label\":\"BOS\",\"slug\":\"laporan/bos\",\"newtab\":\"0\",\"order\":2,\"children\":[]},{\"id\":\"7\",\"icon\":\"mdi mdi-chart-line-variant\",\"label\":\"Pembukuan\",\"slug\":\"laporan/pembukuan\",\"newtab\":\"0\",\"order\":3,\"children\":[]}]}]', 16, 1),
(14, 'sidebar', 'Pengelola Keuangan', 'Sidebar Pengelola Keuangan', '[{\"order\":0,\"children\":[]},{\"id\":\"1\",\"icon\":\"mdi mdi-coffee-to-go\",\"label\":\"Sub Kegiatan\",\"slug\":\"sub_kegiatan\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"2\",\"icon\":\"mdi mdi-blender-software\",\"label\":\"Anggaran\",\"slug\":\"anggaran/rekening\",\"newtab\":\"0\",\"order\":2,\"children\":[{\"id\":\"2\",\"icon\":\"mdi mdi-scale\",\"label\":\"Anggaran\",\"slug\":\"anggaran\",\"newtab\":\"0\",\"order\":0,\"children\":[]},{\"id\":\"2\",\"icon\":\"mdi mdi-arrow-collapse-all\",\"label\":\"Verifikasi\",\"slug\":\"asistensi\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"2\",\"icon\":\"mdi mdi-ear-hearing\",\"label\":\"Standar Harga\",\"slug\":\"standar_harga\",\"newtab\":\"0\",\"order\":2,\"children\":[]}]},{\"id\":\"3\",\"icon\":\"mdi mdi-shower-head\",\"label\":\"Pendapatan\",\"slug\":\"pendapatan\",\"newtab\":\"0\",\"order\":3,\"children\":[]},{\"id\":\"4\",\"icon\":\"mdi mdi-sofa\",\"label\":\"Mutasi Kas\",\"slug\":\"mutasi_kas\",\"newtab\":\"0\",\"order\":4,\"children\":[]},{\"id\":\"5\",\"icon\":\"mdi mdi-diamond-stone\",\"label\":\"Belanja\",\"slug\":\"belanja\",\"newtab\":\"0\",\"order\":5,\"children\":[]},{\"id\":\"6\",\"icon\":\"mdi mdi-podium\",\"label\":\"Pajak\",\"slug\":\"pajak\",\"newtab\":\"0\",\"order\":6,\"children\":[]},{\"id\":\"7\",\"icon\":\"mdi mdi-paw\",\"label\":\"SP2B\",\"slug\":\"sp2b\",\"newtab\":\"0\",\"order\":7,\"children\":[]},{\"id\":\"10\",\"icon\":\"mdi mdi-parachute-outline\",\"label\":\"SPB\",\"slug\":\"spb\",\"newtab\":\"0\",\"order\":8,\"children\":[]},{\"id\":\"8\",\"icon\":\"mdi mdi-chart-areaspline\",\"label\":\"laporan\",\"slug\":\"laporan\",\"newtab\":\"0\",\"order\":9,\"children\":[{\"id\":\"8\",\"icon\":\"mdi mdi-chart-line-stacked\",\"label\":\"Anggaran\",\"slug\":\"laporan/anggaran\",\"newtab\":\"0\",\"order\":0,\"children\":[]},{\"id\":\"8\",\"icon\":\"mdi mdi-chart-multiline\",\"label\":\"Tata Usaha\",\"slug\":\"laporan/tata_usaha\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"8\",\"icon\":\"mdi mdi-chart-scatterplot-hexbin\",\"label\":\"BOS\",\"slug\":\"laporan/bos\",\"newtab\":\"0\",\"order\":2,\"children\":[]},{\"id\":\"8\",\"icon\":\"mdi mdi-chart-line-variant\",\"label\":\"Pembukuan\",\"slug\":\"laporan/pembukuan\",\"newtab\":\"0\",\"order\":3,\"children\":[]}]}]', 19, 1),
(15, 'sidebar', 'Viewer 2', 'Sidebar Viewer 2', '[{\"order\":0,\"children\":[]},{\"id\":\"1\",\"icon\":\"mdi mdi-coffee-to-go\",\"label\":\"Sub Kegiatan\",\"slug\":\"sub_kegiatan\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"2\",\"icon\":\"mdi mdi-blender-software\",\"label\":\"Anggaran\",\"slug\":\"anggaran/rekening\",\"newtab\":\"0\",\"order\":2,\"children\":[{\"id\":\"2\",\"icon\":\"mdi mdi-scale\",\"label\":\"Anggaran\",\"slug\":\"anggaran\",\"newtab\":\"0\",\"order\":0,\"children\":[]},{\"id\":\"2\",\"icon\":\"mdi mdi-arrow-collapse-all\",\"label\":\"Verifikasi\",\"slug\":\"asistensi\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"2\",\"icon\":\"mdi mdi-ear-hearing\",\"label\":\"Standar Harga\",\"slug\":\"standar_harga\",\"newtab\":\"0\",\"order\":2,\"children\":[]}]},{\"id\":\"3\",\"icon\":\"mdi mdi-shower-head\",\"label\":\"Pendapatan\",\"slug\":\"pendapatan\",\"newtab\":\"0\",\"order\":3,\"children\":[]},{\"id\":\"4\",\"icon\":\"mdi mdi-sofa\",\"label\":\"Mutasi Kas\",\"slug\":\"mutasi_kas\",\"newtab\":\"0\",\"order\":4,\"children\":[]},{\"id\":\"5\",\"icon\":\"mdi mdi-diamond-stone\",\"label\":\"Belanja\",\"slug\":\"belanja\",\"newtab\":\"0\",\"order\":5,\"children\":[]},{\"id\":\"6\",\"icon\":\"mdi mdi-podium\",\"label\":\"Pajak\",\"slug\":\"pajak\",\"newtab\":\"0\",\"order\":6,\"children\":[]},{\"id\":\"7\",\"icon\":\"mdi mdi-paw\",\"label\":\"SP2B\",\"slug\":\"sp2b\",\"newtab\":\"0\",\"order\":7,\"children\":[]},{\"id\":\"10\",\"icon\":\"mdi mdi-parachute-outline\",\"label\":\"SPB\",\"slug\":\"spb\",\"newtab\":\"0\",\"order\":8,\"children\":[]},{\"id\":\"8\",\"icon\":\"mdi mdi-chart-areaspline\",\"label\":\"laporan\",\"slug\":\"laporan\",\"newtab\":\"0\",\"order\":9,\"children\":[{\"id\":\"8\",\"icon\":\"mdi mdi-chart-line-stacked\",\"label\":\"Anggaran\",\"slug\":\"laporan/anggaran\",\"newtab\":\"0\",\"order\":0,\"children\":[]},{\"id\":\"8\",\"icon\":\"mdi mdi-chart-multiline\",\"label\":\"Tata Usaha\",\"slug\":\"laporan/tata_usaha\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"8\",\"icon\":\"mdi mdi-chart-scatterplot-hexbin\",\"label\":\"BOS\",\"slug\":\"laporan/bos\",\"newtab\":\"0\",\"order\":2,\"children\":[]},{\"id\":\"8\",\"icon\":\"mdi mdi-chart-line-variant\",\"label\":\"Pembukuan\",\"slug\":\"laporan/pembukuan\",\"newtab\":\"0\",\"order\":3,\"children\":[]}]}]', 14, 1),
(16, 'sidebar', 'TTD TAPD Asistensi', 'Sidebar TTD TAPD Asistensi', '[{\"order\":0,\"children\":[]},{\"id\":\"1\",\"icon\":\"mdi mdi-coffee-to-go\",\"label\":\"Sub Kegiatan\",\"slug\":\"sub_kegiatan\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"1\",\"icon\":\"mdi mdi-blender-software\",\"label\":\"Anggaran\",\"slug\":\"anggaran/rekening\",\"newtab\":\"0\",\"order\":2,\"children\":[{\"id\":\"1\",\"icon\":\"mdi mdi-scale\",\"label\":\"Anggaran\",\"slug\":\"anggaran\",\"newtab\":\"0\",\"order\":0,\"children\":[]},{\"id\":\"1\",\"icon\":\"mdi mdi-arrow-collapse-all\",\"label\":\"Verifikasi\",\"slug\":\"asistensi\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"10\",\"icon\":\"mdi mdi-ear-hearing\",\"label\":\"Standar Harga\",\"slug\":\"standar_harga\",\"newtab\":\"0\",\"order\":2,\"children\":[]}]},{\"id\":\"2\",\"icon\":\"mdi mdi-shower-head\",\"label\":\"Pendapatan\",\"slug\":\"pendapatan\",\"newtab\":\"0\",\"order\":3,\"children\":[]},{\"id\":\"3\",\"icon\":\"mdi mdi-sofa\",\"label\":\"Mutasi Kas\",\"slug\":\"mutasi_kas\",\"newtab\":\"0\",\"order\":4,\"children\":[]},{\"id\":\"4\",\"icon\":\"mdi mdi-diamond-stone\",\"label\":\"Belanja\",\"slug\":\"belanja\",\"newtab\":\"0\",\"order\":5,\"children\":[]},{\"id\":\"5\",\"icon\":\"mdi mdi-podium\",\"label\":\"Pajak\",\"slug\":\"pajak\",\"newtab\":\"0\",\"order\":6,\"children\":[]},{\"id\":\"6\",\"icon\":\"mdi mdi-paw\",\"label\":\"SP2B\",\"slug\":\"sp2b\",\"newtab\":\"0\",\"order\":7,\"children\":[]},{\"id\":\"7\",\"icon\":\"mdi mdi-chart-areaspline\",\"label\":\"laporan\",\"slug\":\"laporan\",\"newtab\":\"0\",\"order\":8,\"children\":[{\"id\":\"7\",\"icon\":\"mdi mdi-chart-line-stacked\",\"label\":\"Anggaran\",\"slug\":\"laporan/anggaran\",\"newtab\":\"0\",\"order\":0,\"children\":[]},{\"id\":\"7\",\"icon\":\"mdi mdi-chart-multiline\",\"label\":\"Tata Usaha\",\"slug\":\"laporan/tata_usaha\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"7\",\"icon\":\"mdi mdi-chart-scatterplot-hexbin\",\"label\":\"BOS\",\"slug\":\"laporan/bos\",\"newtab\":\"0\",\"order\":2,\"children\":[]},{\"id\":\"7\",\"icon\":\"mdi mdi-chart-line-variant\",\"label\":\"Pembukuan\",\"slug\":\"laporan/pembukuan\",\"newtab\":\"0\",\"order\":3,\"children\":[]}]}]', 17, 1),
(17, 'sidebar', 'Sub Kegiatan', 'Sidebar Sub Kegiatan', '[{\"order\":0,\"children\":[]},{\"id\":\"1\",\"icon\":\"mdi mdi-coffee-to-go\",\"label\":\"Sub Kegiatan\",\"slug\":\"sub_kegiatan\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"1\",\"icon\":\"mdi mdi-blender-software\",\"label\":\"Anggaran\",\"slug\":\"anggaran/rekening\",\"newtab\":\"0\",\"order\":2,\"children\":[{\"id\":\"1\",\"icon\":\"mdi mdi-scale\",\"label\":\"Anggaran\",\"slug\":\"anggaran\",\"newtab\":\"0\",\"order\":0,\"children\":[]},{\"id\":\"1\",\"icon\":\"mdi mdi-arrow-collapse-all\",\"label\":\"Verifikasi\",\"slug\":\"asistensi\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"10\",\"icon\":\"mdi mdi-ear-hearing\",\"label\":\"Standar Harga\",\"slug\":\"standar_harga\",\"newtab\":\"0\",\"order\":2,\"children\":[]}]},{\"id\":\"2\",\"icon\":\"mdi mdi-shower-head\",\"label\":\"Pendapatan\",\"slug\":\"pendapatan\",\"newtab\":\"0\",\"order\":3,\"children\":[]},{\"id\":\"3\",\"icon\":\"mdi mdi-sofa\",\"label\":\"Mutasi Kas\",\"slug\":\"mutasi_kas\",\"newtab\":\"0\",\"order\":4,\"children\":[]},{\"id\":\"4\",\"icon\":\"mdi mdi-diamond-stone\",\"label\":\"Belanja\",\"slug\":\"belanja\",\"newtab\":\"0\",\"order\":5,\"children\":[]},{\"id\":\"5\",\"icon\":\"mdi mdi-podium\",\"label\":\"Pajak\",\"slug\":\"pajak\",\"newtab\":\"0\",\"order\":6,\"children\":[]},{\"id\":\"6\",\"icon\":\"mdi mdi-paw\",\"label\":\"SP2B\",\"slug\":\"sp2b\",\"newtab\":\"0\",\"order\":7,\"children\":[]},{\"id\":\"7\",\"icon\":\"mdi mdi-chart-areaspline\",\"label\":\"laporan\",\"slug\":\"laporan\",\"newtab\":\"0\",\"order\":8,\"children\":[{\"id\":\"7\",\"icon\":\"mdi mdi-chart-line-stacked\",\"label\":\"Anggaran\",\"slug\":\"laporan/anggaran\",\"newtab\":\"0\",\"order\":0,\"children\":[]},{\"id\":\"7\",\"icon\":\"mdi mdi-chart-multiline\",\"label\":\"Tata Usaha\",\"slug\":\"laporan/tata_usaha\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"7\",\"icon\":\"mdi mdi-chart-scatterplot-hexbin\",\"label\":\"BOS\",\"slug\":\"laporan/bos\",\"newtab\":\"0\",\"order\":2,\"children\":[]},{\"id\":\"7\",\"icon\":\"mdi mdi-chart-line-variant\",\"label\":\"Pembukuan\",\"slug\":\"laporan/pembukuan\",\"newtab\":\"0\",\"order\":3,\"children\":[]}]}]', 9, 1);
INSERT INTO `app__menus` (`menu_id`, `menu_placement`, `menu_label`, `menu_description`, `serialized_data`, `group_id`, `status`) VALUES
(18, 'sidebar', 'Unit', 'Sidebar Unit', '[{\"order\":0,\"children\":[]},{\"id\":\"1\",\"icon\":\"mdi mdi-coffee-to-go\",\"label\":\"Sub Kegiatan\",\"slug\":\"sub_kegiatan\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"1\",\"icon\":\"mdi mdi-blender-software\",\"label\":\"Anggaran\",\"slug\":\"anggaran/rekening\",\"newtab\":\"0\",\"order\":2,\"children\":[{\"id\":\"1\",\"icon\":\"mdi mdi-scale\",\"label\":\"Anggaran\",\"slug\":\"anggaran\",\"newtab\":\"0\",\"order\":0,\"children\":[]},{\"id\":\"1\",\"icon\":\"mdi mdi-arrow-collapse-all\",\"label\":\"Verifikasi\",\"slug\":\"asistensi\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"10\",\"icon\":\"mdi mdi-ear-hearing\",\"label\":\"Standar Harga\",\"slug\":\"standar_harga\",\"newtab\":\"0\",\"order\":2,\"children\":[]}]},{\"id\":\"2\",\"icon\":\"mdi mdi-shower-head\",\"label\":\"Pendapatan\",\"slug\":\"pendapatan\",\"newtab\":\"0\",\"order\":3,\"children\":[]},{\"id\":\"3\",\"icon\":\"mdi mdi-sofa\",\"label\":\"Mutasi Kas\",\"slug\":\"mutasi_kas\",\"newtab\":\"0\",\"order\":4,\"children\":[]},{\"id\":\"4\",\"icon\":\"mdi mdi-diamond-stone\",\"label\":\"Belanja\",\"slug\":\"belanja\",\"newtab\":\"0\",\"order\":5,\"children\":[]},{\"id\":\"5\",\"icon\":\"mdi mdi-podium\",\"label\":\"Pajak\",\"slug\":\"pajak\",\"newtab\":\"0\",\"order\":6,\"children\":[]},{\"id\":\"6\",\"icon\":\"mdi mdi-paw\",\"label\":\"SP2B\",\"slug\":\"sp2b\",\"newtab\":\"0\",\"order\":7,\"children\":[]},{\"id\":\"7\",\"icon\":\"mdi mdi-chart-areaspline\",\"label\":\"laporan\",\"slug\":\"laporan\",\"newtab\":\"0\",\"order\":8,\"children\":[{\"id\":\"7\",\"icon\":\"mdi mdi-chart-line-stacked\",\"label\":\"Anggaran\",\"slug\":\"laporan/anggaran\",\"newtab\":\"0\",\"order\":0,\"children\":[]},{\"id\":\"7\",\"icon\":\"mdi mdi-chart-multiline\",\"label\":\"Tata Usaha\",\"slug\":\"laporan/tata_usaha\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"7\",\"icon\":\"mdi mdi-chart-scatterplot-hexbin\",\"label\":\"BOS\",\"slug\":\"laporan/bos\",\"newtab\":\"0\",\"order\":2,\"children\":[]},{\"id\":\"7\",\"icon\":\"mdi mdi-chart-line-variant\",\"label\":\"Pembukuan\",\"slug\":\"laporan/pembukuan\",\"newtab\":\"0\",\"order\":3,\"children\":[]}]}]', 5, 1),
(19, 'sidebar', 'Sub Kegiatan 2', 'Sidebar Sub Kegiatan 2', '[{\"order\":0,\"children\":[]},{\"id\":\"1\",\"icon\":\"mdi mdi-coffee-to-go\",\"label\":\"Sub Kegiatan\",\"slug\":\"sub_kegiatan\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"1\",\"icon\":\"mdi mdi-blender-software\",\"label\":\"Anggaran\",\"slug\":\"anggaran/rekening\",\"newtab\":\"0\",\"order\":2,\"children\":[{\"id\":\"1\",\"icon\":\"mdi mdi-scale\",\"label\":\"Anggaran\",\"slug\":\"anggaran/rekening\",\"newtab\":\"0\",\"order\":0,\"children\":[]},{\"id\":\"1\",\"icon\":\"mdi mdi-arrow-collapse-all\",\"label\":\"Verifikasi\",\"slug\":\"asistensi\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"10\",\"icon\":\"mdi mdi-ear-hearing\",\"label\":\"Standar Harga\",\"slug\":\"standar_harga\",\"newtab\":\"0\",\"order\":2,\"children\":[]}]},{\"id\":\"2\",\"icon\":\"mdi mdi-shower-head\",\"label\":\"Pendapatan\",\"slug\":\"pendapatan\",\"newtab\":\"0\",\"order\":3,\"children\":[]},{\"id\":\"3\",\"icon\":\"mdi mdi-sofa\",\"label\":\"Mutasi Kas\",\"slug\":\"mutasi_kas\",\"newtab\":\"0\",\"order\":4,\"children\":[]},{\"id\":\"4\",\"icon\":\"mdi mdi-diamond-stone\",\"label\":\"Belanja\",\"slug\":\"belanja\",\"newtab\":\"0\",\"order\":5,\"children\":[]},{\"id\":\"5\",\"icon\":\"mdi mdi-podium\",\"label\":\"Pajak\",\"slug\":\"pajak\",\"newtab\":\"0\",\"order\":6,\"children\":[]},{\"id\":\"6\",\"icon\":\"mdi mdi-paw\",\"label\":\"SP2B\",\"slug\":\"sp2b\",\"newtab\":\"0\",\"order\":7,\"children\":[]},{\"id\":\"7\",\"icon\":\"mdi mdi-chart-areaspline\",\"label\":\"laporan\",\"slug\":\"laporan\",\"newtab\":\"0\",\"order\":8,\"children\":[{\"id\":\"7\",\"icon\":\"mdi mdi-chart-line-stacked\",\"label\":\"Anggaran\",\"slug\":\"laporan/anggaran\",\"newtab\":\"0\",\"order\":0,\"children\":[]},{\"id\":\"7\",\"icon\":\"mdi mdi-chart-multiline\",\"label\":\"Tata Usaha\",\"slug\":\"laporan/tata_usaha\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"7\",\"icon\":\"mdi mdi-chart-scatterplot-hexbin\",\"label\":\"BOS\",\"slug\":\"laporan/bos\",\"newtab\":\"0\",\"order\":2,\"children\":[]},{\"id\":\"7\",\"icon\":\"mdi mdi-chart-line\",\"label\":\"Pembukuan\",\"slug\":\"laporan/pembukuan\",\"newtab\":\"0\",\"order\":3,\"children\":[]}]}]', 10, 1),
(20, 'sidebar', 'Admin Perencanaan', 'Sidebar Admin Perencanaan', '[{\"order\":0,\"children\":[]},{\"id\":\"1\",\"icon\":\"mdi mdi-coffee-to-go\",\"label\":\"Sub Kegiatan\",\"slug\":\"sub_kegiatan\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"2\",\"icon\":\"mdi mdi-blender-software\",\"label\":\"Anggaran\",\"slug\":\"anggaran/rekening\",\"newtab\":\"0\",\"order\":2,\"children\":[{\"id\":\"2\",\"icon\":\"mdi mdi-scale\",\"label\":\"Anggaran\",\"slug\":\"anggaran\",\"newtab\":\"0\",\"order\":0,\"children\":[]},{\"id\":\"2\",\"icon\":\"mdi mdi-arrow-collapse-all\",\"label\":\"Verifikasi\",\"slug\":\"asistensi\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"2\",\"icon\":\"mdi mdi-ear-hearing\",\"label\":\"Standar Harga\",\"slug\":\"standar_harga\",\"newtab\":\"0\",\"order\":2,\"children\":[]}]},{\"id\":\"3\",\"icon\":\"mdi mdi-shower-head\",\"label\":\"Pendapatan\",\"slug\":\"pendapatan\",\"newtab\":\"0\",\"order\":3,\"children\":[]},{\"id\":\"4\",\"icon\":\"mdi mdi-sofa\",\"label\":\"Mutasi Kas\",\"slug\":\"mutasi_kas\",\"newtab\":\"0\",\"order\":4,\"children\":[]},{\"id\":\"5\",\"icon\":\"mdi mdi-diamond-stone\",\"label\":\"Belanja\",\"slug\":\"belanja\",\"newtab\":\"0\",\"order\":5,\"children\":[]},{\"id\":\"6\",\"icon\":\"mdi mdi-podium\",\"label\":\"Pajak\",\"slug\":\"pajak\",\"newtab\":\"0\",\"order\":6,\"children\":[]},{\"id\":\"7\",\"icon\":\"mdi mdi-paw\",\"label\":\"SP2B\",\"slug\":\"sp2b\",\"newtab\":\"0\",\"order\":7,\"children\":[]},{\"id\":\"10\",\"icon\":\"mdi mdi-parachute-outline\",\"label\":\"SPB\",\"slug\":\"spb\",\"newtab\":\"0\",\"order\":8,\"children\":[]},{\"id\":\"8\",\"icon\":\"mdi mdi-chart-areaspline\",\"label\":\"laporan\",\"slug\":\"laporan\",\"newtab\":\"0\",\"order\":9,\"children\":[{\"id\":\"8\",\"icon\":\"mdi mdi-chart-line-stacked\",\"label\":\"Anggaran\",\"slug\":\"laporan/anggaran\",\"newtab\":\"0\",\"order\":0,\"children\":[]},{\"id\":\"8\",\"icon\":\"mdi mdi-chart-multiline\",\"label\":\"Tata Usaha\",\"slug\":\"laporan/tata_usaha\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"8\",\"icon\":\"mdi mdi-chart-scatterplot-hexbin\",\"label\":\"BOS\",\"slug\":\"laporan/bos\",\"newtab\":\"0\",\"order\":2,\"children\":[]},{\"id\":\"8\",\"icon\":\"mdi mdi-chart-line-variant\",\"label\":\"Pembukuan\",\"slug\":\"laporan/pembukuan\",\"newtab\":\"0\",\"order\":3,\"children\":[]}]}]', 2, 1),
(21, 'sidebar', 'Dinas Pendidikan', 'Sidebar Dinas Pendidikan', '[{\"order\":0,\"children\":[]},{\"id\":\"1\",\"icon\":\"mdi mdi-coffee-to-go\",\"label\":\"Sub Kegiatan\",\"slug\":\"sub_kegiatan\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"2\",\"icon\":\"mdi mdi-blender-software\",\"label\":\"Anggaran\",\"slug\":\"anggaran/rekening\",\"newtab\":\"0\",\"order\":2,\"children\":[{\"id\":\"2\",\"icon\":\"mdi mdi-scale\",\"label\":\"Anggaran\",\"slug\":\"anggaran\",\"newtab\":\"0\",\"order\":0,\"children\":[]},{\"id\":\"2\",\"icon\":\"mdi mdi-arrow-collapse-all\",\"label\":\"Verifikasi\",\"slug\":\"asistensi\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"2\",\"icon\":\"mdi mdi-ear-hearing\",\"label\":\"Standar Harga\",\"slug\":\"standar_harga\",\"newtab\":\"0\",\"order\":2,\"children\":[]}]},{\"id\":\"3\",\"icon\":\"mdi mdi-shower-head\",\"label\":\"Pendapatan\",\"slug\":\"pendapatan\",\"newtab\":\"0\",\"order\":3,\"children\":[]},{\"id\":\"4\",\"icon\":\"mdi mdi-sofa\",\"label\":\"Mutasi Kas\",\"slug\":\"mutasi_kas\",\"newtab\":\"0\",\"order\":4,\"children\":[]},{\"id\":\"5\",\"icon\":\"mdi mdi-diamond-stone\",\"label\":\"Belanja\",\"slug\":\"belanja\",\"newtab\":\"0\",\"order\":5,\"children\":[]},{\"id\":\"6\",\"icon\":\"mdi mdi-podium\",\"label\":\"Pajak\",\"slug\":\"pajak\",\"newtab\":\"0\",\"order\":6,\"children\":[]},{\"id\":\"7\",\"icon\":\"mdi mdi-paw\",\"label\":\"SP2B\",\"slug\":\"sp2b\",\"newtab\":\"0\",\"order\":7,\"children\":[]},{\"id\":\"10\",\"icon\":\"mdi mdi-parachute-outline\",\"label\":\"SPB\",\"slug\":\"spb\",\"newtab\":\"0\",\"order\":8,\"children\":[]},{\"id\":\"8\",\"icon\":\"mdi mdi-chart-areaspline\",\"label\":\"laporan\",\"slug\":\"laporan\",\"newtab\":\"0\",\"order\":9,\"children\":[{\"id\":\"8\",\"icon\":\"mdi mdi-chart-line-stacked\",\"label\":\"Anggaran\",\"slug\":\"laporan/anggaran\",\"newtab\":\"0\",\"order\":0,\"children\":[]},{\"id\":\"8\",\"icon\":\"mdi mdi-chart-multiline\",\"label\":\"Tata Usaha\",\"slug\":\"laporan/tata_usaha\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"8\",\"icon\":\"mdi mdi-chart-scatterplot-hexbin\",\"label\":\"BOS\",\"slug\":\"laporan/bos\",\"newtab\":\"0\",\"order\":2,\"children\":[]},{\"id\":\"8\",\"icon\":\"mdi mdi-chart-line-variant\",\"label\":\"Pembukuan\",\"slug\":\"laporan/pembukuan\",\"newtab\":\"0\",\"order\":3,\"children\":[]}]}]', 3, 1),
(22, 'sidebar', 'Dinas Pendidikan 2', 'Sidebar Dinas Pendidikan 2', '[{\"order\":0,\"children\":[]},{\"id\":\"1\",\"icon\":\"mdi mdi-coffee-to-go\",\"label\":\"Sub Kegiatan\",\"slug\":\"sub_kegiatan\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"2\",\"icon\":\"mdi mdi-blender-software\",\"label\":\"Anggaran\",\"slug\":\"anggaran/rekening\",\"newtab\":\"0\",\"order\":2,\"children\":[{\"id\":\"2\",\"icon\":\"mdi mdi-scale\",\"label\":\"Anggaran\",\"slug\":\"anggaran\",\"newtab\":\"0\",\"order\":0,\"children\":[]},{\"id\":\"2\",\"icon\":\"mdi mdi-arrow-collapse-all\",\"label\":\"Verifikasi\",\"slug\":\"asistensi\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"2\",\"icon\":\"mdi mdi-ear-hearing\",\"label\":\"Standar Harga\",\"slug\":\"standar_harga\",\"newtab\":\"0\",\"order\":2,\"children\":[]}]},{\"id\":\"3\",\"icon\":\"mdi mdi-shower-head\",\"label\":\"Pendapatan\",\"slug\":\"pendapatan\",\"newtab\":\"0\",\"order\":3,\"children\":[]},{\"id\":\"4\",\"icon\":\"mdi mdi-sofa\",\"label\":\"Mutasi Kas\",\"slug\":\"mutasi_kas\",\"newtab\":\"0\",\"order\":4,\"children\":[]},{\"id\":\"5\",\"icon\":\"mdi mdi-diamond-stone\",\"label\":\"Belanja\",\"slug\":\"belanja\",\"newtab\":\"0\",\"order\":5,\"children\":[]},{\"id\":\"6\",\"icon\":\"mdi mdi-podium\",\"label\":\"Pajak\",\"slug\":\"pajak\",\"newtab\":\"0\",\"order\":6,\"children\":[]},{\"id\":\"7\",\"icon\":\"mdi mdi-paw\",\"label\":\"SP2B\",\"slug\":\"sp2b\",\"newtab\":\"0\",\"order\":7,\"children\":[]},{\"id\":\"10\",\"icon\":\"mdi mdi-parachute-outline\",\"label\":\"SPB\",\"slug\":\"spb\",\"newtab\":\"0\",\"order\":8,\"children\":[]},{\"id\":\"8\",\"icon\":\"mdi mdi-chart-areaspline\",\"label\":\"laporan\",\"slug\":\"laporan\",\"newtab\":\"0\",\"order\":9,\"children\":[{\"id\":\"8\",\"icon\":\"mdi mdi-chart-line-stacked\",\"label\":\"Anggaran\",\"slug\":\"laporan/anggaran\",\"newtab\":\"0\",\"order\":0,\"children\":[]},{\"id\":\"8\",\"icon\":\"mdi mdi-chart-multiline\",\"label\":\"Tata Usaha\",\"slug\":\"laporan/tata_usaha\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"8\",\"icon\":\"mdi mdi-chart-scatterplot-hexbin\",\"label\":\"BOS\",\"slug\":\"laporan/bos\",\"newtab\":\"0\",\"order\":2,\"children\":[]},{\"id\":\"8\",\"icon\":\"mdi mdi-chart-line-variant\",\"label\":\"Pembukuan\",\"slug\":\"laporan/pembukuan\",\"newtab\":\"0\",\"order\":3,\"children\":[]}]}]', 4, 1),
(23, 'sidebar', 'Viewer', 'Sidebar Viewer', '[{\"order\":0,\"children\":[]},{\"id\":\"1\",\"icon\":\"mdi mdi-coffee-to-go\",\"label\":\"Sub Kegiatan\",\"slug\":\"sub_kegiatan\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"2\",\"icon\":\"mdi mdi-blender-software\",\"label\":\"Anggaran\",\"slug\":\"anggaran/rekening\",\"newtab\":\"0\",\"order\":2,\"children\":[{\"id\":\"2\",\"icon\":\"mdi mdi-scale\",\"label\":\"Anggaran\",\"slug\":\"anggaran\",\"newtab\":\"0\",\"order\":0,\"children\":[]},{\"id\":\"2\",\"icon\":\"mdi mdi-arrow-collapse-all\",\"label\":\"Verifikasi\",\"slug\":\"asistensi\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"2\",\"icon\":\"mdi mdi-ear-hearing\",\"label\":\"Standar Harga\",\"slug\":\"standar_harga\",\"newtab\":\"0\",\"order\":2,\"children\":[]}]},{\"id\":\"3\",\"icon\":\"mdi mdi-shower-head\",\"label\":\"Pendapatan\",\"slug\":\"pendapatan\",\"newtab\":\"0\",\"order\":3,\"children\":[]},{\"id\":\"4\",\"icon\":\"mdi mdi-sofa\",\"label\":\"Mutasi Kas\",\"slug\":\"mutasi_kas\",\"newtab\":\"0\",\"order\":4,\"children\":[]},{\"id\":\"5\",\"icon\":\"mdi mdi-diamond-stone\",\"label\":\"Belanja\",\"slug\":\"belanja\",\"newtab\":\"0\",\"order\":5,\"children\":[]},{\"id\":\"6\",\"icon\":\"mdi mdi-podium\",\"label\":\"Pajak\",\"slug\":\"pajak\",\"newtab\":\"0\",\"order\":6,\"children\":[]},{\"id\":\"7\",\"icon\":\"mdi mdi-paw\",\"label\":\"SP2B\",\"slug\":\"sp2b\",\"newtab\":\"0\",\"order\":7,\"children\":[]},{\"id\":\"10\",\"icon\":\"mdi mdi-parachute-outline\",\"label\":\"SPB\",\"slug\":\"spb\",\"newtab\":\"0\",\"order\":8,\"children\":[]},{\"id\":\"8\",\"icon\":\"mdi mdi-chart-areaspline\",\"label\":\"laporan\",\"slug\":\"laporan\",\"newtab\":\"0\",\"order\":9,\"children\":[{\"id\":\"8\",\"icon\":\"mdi mdi-chart-line-stacked\",\"label\":\"Anggaran\",\"slug\":\"laporan/anggaran\",\"newtab\":\"0\",\"order\":0,\"children\":[]},{\"id\":\"8\",\"icon\":\"mdi mdi-chart-multiline\",\"label\":\"Tata Usaha\",\"slug\":\"laporan/tata_usaha\",\"newtab\":\"0\",\"order\":1,\"children\":[]},{\"id\":\"8\",\"icon\":\"mdi mdi-chart-scatterplot-hexbin\",\"label\":\"BOS\",\"slug\":\"laporan/bos\",\"newtab\":\"0\",\"order\":2,\"children\":[]},{\"id\":\"8\",\"icon\":\"mdi mdi-chart-line-variant\",\"label\":\"Pembukuan\",\"slug\":\"laporan/pembukuan\",\"newtab\":\"0\",\"order\":3,\"children\":[]}]}]', 13, 1);

-- --------------------------------------------------------

--
-- Table structure for table `app__rest_api`
--

CREATE TABLE `app__rest_api` (
  `id` int(11) NOT NULL,
  `title` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `api_key` varchar(64) NOT NULL,
  `method` tinytext NOT NULL,
  `ip_range` text NOT NULL,
  `valid_until` date NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `app__rest_api`
--

INSERT INTO `app__rest_api` (`id`, `title`, `description`, `api_key`, `method`, `ip_range`, `valid_until`, `status`) VALUES
(2, 'Tes', 'Tes', '8F8233E10F16B6B6DD09C276BC8842C5', '[\"GET\",\"POST\",\"DELETE\"]', '5', '2021-04-30', 1);

-- --------------------------------------------------------

--
-- Table structure for table `app__sessions`
--

CREATE TABLE `app__sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `app__settings`
--

CREATE TABLE `app__settings` (
  `id` int(11) NOT NULL,
  `app_name` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `app_description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `app_logo` varchar(256) NOT NULL,
  `app_icon` varchar(256) NOT NULL,
  `frontend_theme` varchar(32) NOT NULL,
  `backend_theme` varchar(32) NOT NULL,
  `app_language` int(11) NOT NULL,
  `office_name` varchar(255) NOT NULL,
  `office_phone` varchar(32) NOT NULL,
  `office_email` varchar(64) NOT NULL,
  `office_fax` varchar(32) NOT NULL,
  `office_address` text NOT NULL,
  `office_map` text NOT NULL,
  `one_device_login` tinyint(1) NOT NULL,
  `username_changes` tinyint(1) NOT NULL,
  `frontend_registration` tinyint(1) NOT NULL,
  `default_membership_group` int(11) NOT NULL,
  `auto_active_registration` tinyint(1) NOT NULL COMMENT '1 = auto active',
  `google_analytics_key` varchar(32) NOT NULL,
  `openlayers_search_provider` varchar(10) NOT NULL,
  `openlayers_search_key` varchar(128) NOT NULL,
  `disqus_site_domain` varchar(128) NOT NULL,
  `facebook_app_id` varchar(22) NOT NULL,
  `facebook_app_secret` varchar(512) NOT NULL,
  `google_client_id` varchar(255) NOT NULL,
  `google_client_secret` varchar(512) NOT NULL,
  `twitter_username` varchar(64) NOT NULL,
  `instagram_username` varchar(64) NOT NULL,
  `whatsapp_number` varchar(16) NOT NULL,
  `smtp_email_masking` varchar(255) NOT NULL,
  `smtp_sender_masking` varchar(64) NOT NULL,
  `smtp_host` varchar(255) NOT NULL,
  `smtp_port` int(5) NOT NULL,
  `smtp_username` varchar(64) NOT NULL,
  `smtp_password` varchar(512) NOT NULL,
  `action_sound` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `app__settings`
--

INSERT INTO `app__settings` (`id`, `app_name`, `app_description`, `app_logo`, `app_icon`, `frontend_theme`, `backend_theme`, `app_language`, `office_name`, `office_phone`, `office_email`, `office_fax`, `office_address`, `office_map`, `one_device_login`, `username_changes`, `frontend_registration`, `default_membership_group`, `auto_active_registration`, `google_analytics_key`, `openlayers_search_provider`, `openlayers_search_key`, `disqus_site_domain`, `facebook_app_id`, `facebook_app_secret`, `google_client_id`, `google_client_secret`, `twitter_username`, `instagram_username`, `whatsapp_number`, `smtp_email_masking`, `smtp_sender_masking`, `smtp_host`, `smtp_port`, `smtp_username`, `smtp_password`, `action_sound`) VALUES
(1, 'SIMDA - Sistem Informasi Manajemen Daerah', 'Aplikasi SIMDA adalah Sistem Informasi Manajemen Daerah', '1614490990_76eb4078748a685c23e8.png', '1614490990_3f3e0e838c724258a7ed.png', 'default', 'backend', 1, 'GeekTech Karya Indonesia, PT', '+6281381614558', 'info@example.com', '', '2nd Floor Example Tower Building, Some Road Name, Any Region', '[]', 0, 0, 0, 3, 0, '', 'openlayers', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `app__shortlink`
--

CREATE TABLE `app__shortlink` (
  `hash` varchar(64) NOT NULL,
  `url` text NOT NULL,
  `session` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `app__users`
--

CREATE TABLE `app__users` (
  `user_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `username` varchar(32) NOT NULL,
  `first_name` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `gender` tinyint(1) NOT NULL,
  `bio` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `photo` varchar(255) NOT NULL,
  `address` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(16) NOT NULL,
  `postal_code` varchar(10) NOT NULL,
  `language_id` int(11) NOT NULL,
  `country` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `registered_date` date NOT NULL,
  `last_login` datetime NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `app__users`
--

INSERT INTO `app__users` (`user_id`, `email`, `password`, `username`, `first_name`, `last_name`, `gender`, `bio`, `photo`, `address`, `phone`, `postal_code`, `language_id`, `country`, `group_id`, `registered_date`, `last_login`, `status`) VALUES
(1, 'admin@simda.ganjar.id', '$2y$10$toXQzFnQYFg1wk25UW5mduNS746FQpZUWkgFCYmS5jhhqXehFy/Ye', 'admin', 'Admin', 'Istrator', 0, '', '', '', '', '', 2, 0, 1, '2021-02-15', '2021-09-11 09:33:07', 1),
(2, 'anggaran@gmail.com', '$2y$10$wdr.8UOkFcPd4D0Vy4hY7uQX.2njkvQgnMvcKUkKfQzKd3Pzw4t02', 'anggaran', 'Anggaran', 'BPKAD', 0, '', 'placeholder.png', '', '', '', 2, 0, 1, '0000-00-00', '2021-06-29 10:45:52', 1);

-- --------------------------------------------------------

--
-- Table structure for table `app__users_hash`
--

CREATE TABLE `app__users_hash` (
  `user_id` int(11) NOT NULL,
  `hash` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `app__users_privileges`
--

CREATE TABLE `app__users_privileges` (
  `user_id` int(11) NOT NULL,
  `sub_level_1` int(11) NOT NULL,
  `visible_menu` text NOT NULL,
  `access_year` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `app__visitor_logs`
--

CREATE TABLE `app__visitor_logs` (
  `ip_address` varchar(32) NOT NULL,
  `timestamp` datetime NOT NULL,
  `browser` varchar(32) NOT NULL,
  `platform` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `app__years`
--

CREATE TABLE `app__years` (
  `year` year(4) NOT NULL,
  `default` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `app__years`
--

INSERT INTO `app__years` (`year`, `default`, `status`) VALUES
(2021, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `post_id` int(11) NOT NULL,
  `post_title` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `post_slug` varchar(256) NOT NULL,
  `post_excerpt` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `post_content` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `post_category` int(11) NOT NULL,
  `post_tags` text NOT NULL,
  `created_timestamp` datetime NOT NULL,
  `updated_timestamp` datetime NOT NULL,
  `author` int(11) NOT NULL,
  `headline` tinyint(1) NOT NULL,
  `featured_image` varchar(256) NOT NULL,
  `language_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `blogs__categories`
--

CREATE TABLE `blogs__categories` (
  `category_id` int(11) NOT NULL,
  `category_title` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `category_slug` varchar(32) NOT NULL,
  `category_description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `category_image` varchar(256) NOT NULL,
  `language_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `blogs__categories`
--

INSERT INTO `blogs__categories` (`category_id`, `category_title`, `category_slug`, `category_description`, `category_image`, `language_id`, `status`) VALUES
(1, 'Uncategorized', 'uncategorized', 'Uncategorized category', 'placeholder.png', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(11) NOT NULL,
  `code` varchar(8) NOT NULL,
  `country` varchar(32) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `galleries`
--

CREATE TABLE `galleries` (
  `gallery_id` int(11) NOT NULL,
  `gallery_images` longtext NOT NULL,
  `gallery_title` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `gallery_slug` varchar(256) NOT NULL,
  `gallery_description` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `gallery_attributes` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `gallery_tags` longtext NOT NULL,
  `created_timestamp` datetime NOT NULL,
  `updated_timestamp` datetime NOT NULL,
  `featured` tinyint(1) NOT NULL,
  `author` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `inquiries`
--

CREATE TABLE `inquiries` (
  `id` int(11) NOT NULL,
  `sender_full_name` varchar(64) NOT NULL,
  `sender_email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `messages` text NOT NULL,
  `timestamp` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `oauth__login`
--

CREATE TABLE `oauth__login` (
  `user_id` int(11) NOT NULL,
  `service_provider` varchar(32) NOT NULL,
  `access_token` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `page_id` int(11) NOT NULL,
  `page_title` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `page_slug` varchar(256) NOT NULL,
  `page_description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `page_content` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `carousel_id` int(11) NOT NULL,
  `faq_id` int(11) NOT NULL,
  `created_timestamp` datetime NOT NULL,
  `updated_timestamp` datetime NOT NULL,
  `author` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `pages__carousels`
--

CREATE TABLE `pages__carousels` (
  `carousel_id` int(11) NOT NULL,
  `carousel_title` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `carousel_description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `carousel_content` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_timestamp` datetime NOT NULL,
  `updated_timestamp` datetime NOT NULL,
  `language_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pages__carousels`
--

INSERT INTO `pages__carousels` (`carousel_id`, `carousel_title`, `carousel_description`, `carousel_content`, `created_timestamp`, `updated_timestamp`, `language_id`, `status`) VALUES
(1, 'Carousel', 'This is the sample of carousel that can be include to page', '[{\"title\":\"SIMDA - Sistem Informasi Manajemen Daerah\",\"description\":\"Aplikasi SIMDA adalah Sistem Informasi Manajemen Daerah\",\"link\":\"\",\"label\":\"\",\"background\":\"1620916300_4e37688c91a770a6cffc.png\",\"thumbnail\":\"\"},{\"title\":\"SIMDA - Sistem Informasi Manajemen Daerah\",\"description\":\"Aplikasi SIMDA adalah Sistem Informasi Manajemen Daerah\",\"link\":\"\",\"label\":\"\",\"background\":\"1620916301_2ecfbd79d37b7ec2321f.png\",\"thumbnail\":\"\"}]', '2021-05-13 21:31:44', '2021-05-13 21:31:44', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pages__faqs`
--

CREATE TABLE `pages__faqs` (
  `faq_id` int(11) NOT NULL,
  `faq_title` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `faq_description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `faq_content` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_timestamp` datetime NOT NULL,
  `updated_timestamp` datetime NOT NULL,
  `language_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `peoples`
--

CREATE TABLE `peoples` (
  `people_id` int(11) NOT NULL,
  `first_name` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `people_slug` varchar(256) NOT NULL,
  `position` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(64) NOT NULL,
  `mobile` varchar(16) NOT NULL,
  `instagram` varchar(255) NOT NULL,
  `facebook` varchar(64) NOT NULL,
  `twitter` varchar(64) NOT NULL,
  `biography` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `photo` varchar(256) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `ref__settings`
--

CREATE TABLE `ref__settings` (
  `tahun` year(4) NOT NULL,
  `nama_pemda` varchar(255) NOT NULL,
  `nama_daerah` varchar(255) NOT NULL,
  `versi_simda` tinyint(1) NOT NULL,
  `logo_laporan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ref__settings`
--

INSERT INTO `ref__settings` (`tahun`, `nama_pemda`, `nama_daerah`, `versi_simda`, `logo_laporan`) VALUES
(2021, 'Pemerintah Kota Nusantara', 'Kota Nusantara', 1, '1614140101_48e8bc087f0a0d2dace1.png');

-- --------------------------------------------------------

--
-- Table structure for table `ref__tanggal`
--

CREATE TABLE `ref__tanggal` (
  `tahun` year(4) NOT NULL,
  `tanggal_rka` date NOT NULL,
  `tanggal_rka_perubahan` date NOT NULL,
  `tanggal_anggaran_kas` date NOT NULL,
  `tanggal_dpa` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ref__tanggal`
--

INSERT INTO `ref__tanggal` (`tahun`, `tanggal_rka`, `tanggal_rka_perubahan`, `tanggal_anggaran_kas`, `tanggal_dpa`) VALUES
(2021, '2019-06-24', '2020-03-18', '2019-12-26', '2020-10-29');

-- --------------------------------------------------------

--
-- Table structure for table `ref__tim_anggaran`
--

CREATE TABLE `ref__tim_anggaran` (
  `id` int(5) NOT NULL,
  `kode` int(5) NOT NULL,
  `jabatan_tim` varchar(100) NOT NULL,
  `nama_tim` varchar(50) NOT NULL,
  `nip_tim` varchar(21) NOT NULL,
  `opd` varchar(30) NOT NULL,
  `ttd` text NOT NULL,
  `tahun` year(4) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ta__kegiatan`
--

CREATE TABLE `ta__kegiatan` (
  `tahun` year(4) NOT NULL,
  `kd_urusan` int(3) NOT NULL,
  `kd_bidang` int(3) NOT NULL,
  `kd_unit` int(4) NOT NULL,
  `kd_sub` int(4) NOT NULL,
  `kd_prog` int(4) NOT NULL,
  `id_prog` int(3) NOT NULL,
  `kd_keg` int(4) NOT NULL,
  `berkas_rka` text NOT NULL,
  `berkas_dpa` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `testimonial_id` int(11) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `first_name` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `testimonial_title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `testimonial_content` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `language_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `app__activity_logs`
--
ALTER TABLE `app__activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_app__activity_logs_to_app__users` (`user_id`);

--
-- Indexes for table `app__announcements`
--
ALTER TABLE `app__announcements`
  ADD PRIMARY KEY (`announcement_id`,`announcement_slug`) USING BTREE,
  ADD KEY `language_id` (`language_id`);

--
-- Indexes for table `app__connections`
--
ALTER TABLE `app__connections`
  ADD PRIMARY KEY (`year`,`database_driver`) USING BTREE;

--
-- Indexes for table `app__countries`
--
ALTER TABLE `app__countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app__ftp`
--
ALTER TABLE `app__ftp`
  ADD PRIMARY KEY (`site_id`);

--
-- Indexes for table `app__groups`
--
ALTER TABLE `app__groups`
  ADD PRIMARY KEY (`group_id`) USING BTREE;

--
-- Indexes for table `app__groups_privileges`
--
ALTER TABLE `app__groups_privileges`
  ADD PRIMARY KEY (`path`);

--
-- Indexes for table `app__languages`
--
ALTER TABLE `app__languages`
  ADD PRIMARY KEY (`id`,`code`) USING BTREE;

--
-- Indexes for table `app__menus`
--
ALTER TABLE `app__menus`
  ADD PRIMARY KEY (`menu_id`,`menu_placement`,`group_id`) USING BTREE;

--
-- Indexes for table `app__rest_api`
--
ALTER TABLE `app__rest_api`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app__sessions`
--
ALTER TABLE `app__sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `app__sessions_timestamp` (`timestamp`);

--
-- Indexes for table `app__settings`
--
ALTER TABLE `app__settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `app_language` (`app_language`);

--
-- Indexes for table `app__shortlink`
--
ALTER TABLE `app__shortlink`
  ADD PRIMARY KEY (`hash`);

--
-- Indexes for table `app__users`
--
ALTER TABLE `app__users`
  ADD PRIMARY KEY (`user_id`) USING BTREE,
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `language_id` (`language_id`,`group_id`),
  ADD KEY `group_id` (`group_id`);

--
-- Indexes for table `app__users_hash`
--
ALTER TABLE `app__users_hash`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `app__users_privileges`
--
ALTER TABLE `app__users_privileges`
  ADD PRIMARY KEY (`user_id`) USING BTREE;

--
-- Indexes for table `app__visitor_logs`
--
ALTER TABLE `app__visitor_logs`
  ADD PRIMARY KEY (`ip_address`,`timestamp`);

--
-- Indexes for table `app__years`
--
ALTER TABLE `app__years`
  ADD PRIMARY KEY (`year`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`post_id`) USING BTREE,
  ADD KEY `fk_blogs_to_app__users` (`author`),
  ADD KEY `fk_blogs_to_blogs__categries` (`post_category`),
  ADD KEY `language_id` (`language_id`);

--
-- Indexes for table `blogs__categories`
--
ALTER TABLE `blogs__categories`
  ADD PRIMARY KEY (`category_id`,`category_slug`) USING BTREE,
  ADD KEY `language_id` (`language_id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `galleries`
--
ALTER TABLE `galleries`
  ADD PRIMARY KEY (`gallery_id`,`gallery_slug`) USING BTREE,
  ADD KEY `fk_galleries_to_app__users` (`author`);

--
-- Indexes for table `inquiries`
--
ALTER TABLE `inquiries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth__login`
--
ALTER TABLE `oauth__login`
  ADD PRIMARY KEY (`user_id`,`service_provider`) USING BTREE;

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`page_id`,`page_slug`) USING BTREE,
  ADD KEY `fk_pages_to_app__users` (`author`);

--
-- Indexes for table `pages__carousels`
--
ALTER TABLE `pages__carousels`
  ADD PRIMARY KEY (`carousel_id`),
  ADD KEY `language_id` (`language_id`);

--
-- Indexes for table `pages__faqs`
--
ALTER TABLE `pages__faqs`
  ADD PRIMARY KEY (`faq_id`),
  ADD KEY `language_id` (`language_id`);

--
-- Indexes for table `peoples`
--
ALTER TABLE `peoples`
  ADD PRIMARY KEY (`people_id`);

--
-- Indexes for table `ref__settings`
--
ALTER TABLE `ref__settings`
  ADD PRIMARY KEY (`tahun`);

--
-- Indexes for table `ref__tanggal`
--
ALTER TABLE `ref__tanggal`
  ADD PRIMARY KEY (`tahun`);

--
-- Indexes for table `ref__tim_anggaran`
--
ALTER TABLE `ref__tim_anggaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tim_anggaran_to_tahun` (`tahun`);

--
-- Indexes for table `ta__kegiatan`
--
ALTER TABLE `ta__kegiatan`
  ADD PRIMARY KEY (`tahun`,`kd_urusan`,`kd_bidang`,`kd_unit`,`kd_sub`,`kd_prog`,`id_prog`,`kd_keg`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`testimonial_id`),
  ADD KEY `language_id` (`language_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `app__activity_logs`
--
ALTER TABLE `app__activity_logs`
  MODIFY `id` int(22) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app__announcements`
--
ALTER TABLE `app__announcements`
  MODIFY `announcement_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app__countries`
--
ALTER TABLE `app__countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app__groups`
--
ALTER TABLE `app__groups`
  MODIFY `group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `app__languages`
--
ALTER TABLE `app__languages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `app__menus`
--
ALTER TABLE `app__menus`
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `app__rest_api`
--
ALTER TABLE `app__rest_api`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `app__settings`
--
ALTER TABLE `app__settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `app__users`
--
ALTER TABLE `app__users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blogs__categories`
--
ALTER TABLE `blogs__categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `galleries`
--
ALTER TABLE `galleries`
  MODIFY `gallery_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inquiries`
--
ALTER TABLE `inquiries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `page_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pages__carousels`
--
ALTER TABLE `pages__carousels`
  MODIFY `carousel_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pages__faqs`
--
ALTER TABLE `pages__faqs`
  MODIFY `faq_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `peoples`
--
ALTER TABLE `peoples`
  MODIFY `people_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ref__tim_anggaran`
--
ALTER TABLE `ref__tim_anggaran`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `testimonial_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `app__activity_logs`
--
ALTER TABLE `app__activity_logs`
  ADD CONSTRAINT `app__activity_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `app__users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `app__announcements`
--
ALTER TABLE `app__announcements`
  ADD CONSTRAINT `app__announcements_ibfk_1` FOREIGN KEY (`language_id`) REFERENCES `app__languages` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `app__connections`
--
ALTER TABLE `app__connections`
  ADD CONSTRAINT `app__connections_ibfk_1` FOREIGN KEY (`year`) REFERENCES `app__years` (`year`) ON UPDATE CASCADE;

--
-- Constraints for table `app__ftp`
--
ALTER TABLE `app__ftp`
  ADD CONSTRAINT `app__ftp_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `app__settings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `app__users`
--
ALTER TABLE `app__users`
  ADD CONSTRAINT `app__users_ibfk_1` FOREIGN KEY (`language_id`) REFERENCES `app__languages` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `app__users_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `app__groups` (`group_id`) ON UPDATE CASCADE;

--
-- Constraints for table `app__users_hash`
--
ALTER TABLE `app__users_hash`
  ADD CONSTRAINT `app__users_hash_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `app__users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `app__users_privileges`
--
ALTER TABLE `app__users_privileges`
  ADD CONSTRAINT `app__users_privileges_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `app__users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `blogs`
--
ALTER TABLE `blogs`
  ADD CONSTRAINT `blogs_ibfk_2` FOREIGN KEY (`author`) REFERENCES `app__users` (`user_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `blogs_ibfk_3` FOREIGN KEY (`language_id`) REFERENCES `app__languages` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `blogs_ibfk_4` FOREIGN KEY (`post_category`) REFERENCES `blogs__categories` (`category_id`) ON UPDATE CASCADE;

--
-- Constraints for table `blogs__categories`
--
ALTER TABLE `blogs__categories`
  ADD CONSTRAINT `blogs__categories_ibfk_1` FOREIGN KEY (`language_id`) REFERENCES `app__languages` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `galleries`
--
ALTER TABLE `galleries`
  ADD CONSTRAINT `galleries_ibfk_1` FOREIGN KEY (`author`) REFERENCES `app__users` (`user_id`) ON UPDATE CASCADE;

--
-- Constraints for table `oauth__login`
--
ALTER TABLE `oauth__login`
  ADD CONSTRAINT `oauth__login_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `app__users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pages`
--
ALTER TABLE `pages`
  ADD CONSTRAINT `pages_ibfk_1` FOREIGN KEY (`author`) REFERENCES `app__users` (`user_id`) ON UPDATE CASCADE;

--
-- Constraints for table `pages__carousels`
--
ALTER TABLE `pages__carousels`
  ADD CONSTRAINT `pages__carousels_ibfk_1` FOREIGN KEY (`language_id`) REFERENCES `app__languages` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `pages__faqs`
--
ALTER TABLE `pages__faqs`
  ADD CONSTRAINT `pages__faqs_ibfk_1` FOREIGN KEY (`language_id`) REFERENCES `app__languages` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `ref__settings`
--
ALTER TABLE `ref__settings`
  ADD CONSTRAINT `fk_settings_to_tahun` FOREIGN KEY (`tahun`) REFERENCES `app__years` (`year`) ON UPDATE CASCADE;

--
-- Constraints for table `ref__tanggal`
--
ALTER TABLE `ref__tanggal`
  ADD CONSTRAINT `fk_tanggal_to_tahun` FOREIGN KEY (`tahun`) REFERENCES `app__years` (`year`) ON UPDATE CASCADE;

--
-- Constraints for table `ref__tim_anggaran`
--
ALTER TABLE `ref__tim_anggaran`
  ADD CONSTRAINT `fk_tim_anggaran_to_tahun` FOREIGN KEY (`tahun`) REFERENCES `app__years` (`year`) ON UPDATE CASCADE;

--
-- Constraints for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD CONSTRAINT `testimonials_ibfk_1` FOREIGN KEY (`language_id`) REFERENCES `app__languages` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
