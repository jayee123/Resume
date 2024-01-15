-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2023-11-22 04:56:13
-- 伺服器版本： 10.4.28-MariaDB
-- PHP 版本： 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `friend_club`
--
CREATE DATABASE IF NOT EXISTS `friend_club` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `friend_club`;

-- --------------------------------------------------------

--
-- 資料表結構 `friend`
--
-- 建立時間： 2023-11-22 02:09:44
-- 最後更新： 2023-11-22 03:52:12
--

DROP TABLE IF EXISTS `friend`;
CREATE TABLE `friend` (
  `no` smallint(6) NOT NULL COMMENT '編號欄位',
  `name` varchar(5) NOT NULL COMMENT '姓名欄位',
  `sex` char(1) NOT NULL COMMENT '性別欄位',
  `age` varchar(10) NOT NULL COMMENT '年齡欄位',
  `star_signs` varchar(3) NOT NULL COMMENT '星座欄位',
  `height` varchar(10) NOT NULL COMMENT '身高欄位',
  `weight` varchar(10) NOT NULL COMMENT '體重欄位',
  `career` varchar(10) NOT NULL COMMENT '職業欄位'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 資料表新增資料前，先清除舊資料 `friend`
--

TRUNCATE TABLE `friend`;
--
-- 傾印資料表的資料 `friend`
--

INSERT INTO `friend` (`no`, `name`, `sex`, `age`, `star_signs`, `height`, `weight`, `career`) VALUES
(1, '孫小美', '女', '15 ~ 20', '雙魚座', ' 165 ~ 170', '50 ~ 55', '學生'),
(2, '小燕子', '女', '20 ~ 25', '牡羊座', '155 ~ 160', ' 45 ~ 50', '上班族'),
(3, '雲翔', '男', '20 ~ 25', '天蠍座', '175 ~ 180', '65 ~ 70', 'SOHO 族'),
(4, '莫召奴', '男', '25 ~ 30', '天秤座', '175 ~ 180', '65 ~ 70', '上班族'),
(5, '葉小釵', '男', '30 ~ 35', '魔羯座', '165 ~ 170', '60 ~ 65', '老師'),
(6, '流川楓', '男', '15 ~ 20', '射手座', '180 ~ 185', '65 ~ 70', '上班族'),
(7, '林阿土', '男', '25 ~ 30', '牡羊座', '170 ~ 175', '65 ~ 70', '老師'),
(8, '趙冰冰', '女', '20 ~ 25', '處女座', '155 ~ 160', '45 ~ 50', '學生'),
(9, '嘟嘟', '男', '15 ~ 20', '獅子座', '165 ~ 170', ' 55 ~ 60', '學生'),
(10, '晴子', '女', '15 ~ 20', '雙子座', '160 ~ 165', '45 ~ 50', '學生'),
(11, '小蘭', '女', '25 ~ 30', '巨蟹座', '165 ~ 170', '50 ~ 55', '上班族'),
(12, '凱蒂', '女', '20 ~ 25', '雙魚座', '160 ~ 165', '45 ~ 50', '公務員'),
(13, '櫻桃子', '女', '25 ~ 30', '天秤座', '155 ~ 160', '55 ~ 60', 'SOHO 族'),
(14, '亮亮', '女', '25 ~ 30', '射手座', '165 ~ 170', '50 ~ 55', '公務員'),
(15, '小齊', '男', '25 ~ 30', '水瓶座', '170 ~ 175', '55 ~ 60', '上班族'),
(16, '安琪', '女', '15 ~ 20', '獅子座', '165 ~ 170', '50 ~ 55', '學生'),
(17, '林達', '女', '20 ~ 25', '雙魚座', '165 ~ 170', '50 ~ 55', '公務員'),
(18, '陳小東', '男', '25 ~ 30', '魔羯座', '175 ~ 180', '65 ~ 70', '上班族'),
(19, 'CoCo', '女', '20 ~ 25', '獅子座', '170 ~ 175', '55 ~ 60', '上班族'),
(20, '安室', '女', '30 ~ 35', '處女座', '155 ~ 160', '45 ~ 50', '老師');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `friend`
--
ALTER TABLE `friend`
  ADD PRIMARY KEY (`no`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `friend`
--
ALTER TABLE `friend`
  MODIFY `no` smallint(6) NOT NULL AUTO_INCREMENT COMMENT '編號欄位', AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
