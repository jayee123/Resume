-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2024-09-02 10:04:26
-- 伺服器版本： 10.4.28-MariaDB
-- PHP 版本： 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `helmet`
--
CREATE DATABASE IF NOT EXISTS `helmet` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `helmet`;

-- --------------------------------------------------------

--
-- 資料表結構 `fileinfo`
--
-- 建立時間： 2024-08-27 12:36:30
--

DROP TABLE IF EXISTS `fileinfo`;
CREATE TABLE `fileinfo` (
  `fid` char(15) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `fextension` varchar(50) NOT NULL,
  `fsize` bigint(20) NOT NULL,
  `upload_date` datetime NOT NULL,
  `ori_path` varchar(2048) NOT NULL,
  `detect_mode` char(5) NOT NULL,
  `output_path` varchar(2048) NOT NULL,
  `status` varchar(15) NOT NULL DEFAULT 'uploading'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `no_hel_frame_record`
--
-- 建立時間： 2024-09-02 08:04:02
--

DROP TABLE IF EXISTS `no_hel_frame_record`;
CREATE TABLE `no_hel_frame_record` (
  `fid` char(15) NOT NULL,
  `frame_num` int(11) NOT NULL,
  `license_plate` varchar(8) NOT NULL DEFAULT '無法辨識',
  `frame_time` varchar(9) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `fileinfo`
--
ALTER TABLE `fileinfo`
  ADD PRIMARY KEY (`fid`);

--
-- 資料表索引 `no_hel_frame_record`
--
ALTER TABLE `no_hel_frame_record`
  ADD PRIMARY KEY (`fid`,`frame_num`,`license_plate`);

--
-- 已傾印資料表的限制式
--

--
-- 資料表的限制式 `no_hel_frame_record`
--
ALTER TABLE `no_hel_frame_record`
  ADD CONSTRAINT `no_hel_frame_record_ibfk_1` FOREIGN KEY (`fid`) REFERENCES `fileinfo` (`fid`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
