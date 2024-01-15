-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2023-12-26 10:10:16
-- 伺服器版本： 10.4.28-MariaDB
-- PHP 版本： 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `bookcom`
--
CREATE DATABASE IF NOT EXISTS `bookcom` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `bookcom`;

-- --------------------------------------------------------

--
-- 資料表結構 `books`
--
-- 建立時間： 2023-12-26 07:45:17
-- 最後更新： 2023-12-26 07:35:39
--

CREATE TABLE `books` (
  `bookId` int(11) NOT NULL,
  `bookName` varchar(20) NOT NULL,
  `price` decimal(6,2) NOT NULL,
  `type` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 資料表新增資料前，先清除舊資料 `books`
--

TRUNCATE TABLE `books`;
--
-- 傾印資料表的資料 `books`
--

INSERT INTO `books` (`bookId`, `bookName`, `price`, `type`) VALUES
(1, '打開 Mac 新世界', 420.00, '電子設備'),
(2, '眼球運動視力鍛鍊', 350.00, '健康'),
(3, 'HTML5 程式設計範例字典', 520.00, '程式設計'),
(4, 'Word 使用手冊', 300.00, '辦公室軟體'),
(5, '抓住你的 Photoshop', 450.00, '圖像處理'),
(7, 'EXECL 快速入門', 350.00, '辦公室軟體'),
(8, 'PHP 程式語言', 460.00, '程式設計'),
(9, '卡娃依彩繪世界', 280.00, '圖像處理'),
(10, 'Android 程式設計', 480.00, '程式設計'),
(11, '超平板工作玩樂技', 199.00, '電子設備'),
(12, '麵包、西點手感烘培教室', 360.00, '食譜料理'),
(13, '設計師產品繪圖知識', 480.00, '圖像處理'),
(14, '法式迷你砂鍋創意食譜', 880.00, '食譜料理'),
(15, 'Photoshop 識別設計', 450.00, '圖像處理'),
(16, 'Microsoft Excel 商用範例', 490.00, '辦公室軟體'),
(17, '上班族一定要會的 Excel 函數', 320.00, '辦公室軟體'),
(18, '數位攝影的黃金法則', 380.00, '圖像處理'),
(19, '核心訓練圖解聖經', 580.00, '健康'),
(21, 'iPad 使用手冊', 380.00, '電子設備'),
(23, '手機 App 活用術', 320.00, '電子設備'),
(24, '智慧手機 App UI/UX 設計鐵則', 380.00, '電子設備'),
(25, 'iPhone 使用手冊', 320.00, '電子設備'),
(26, 'AutoCAD 電腦繪圖設計', 620.00, '圖像處理'),
(31, '復古時尚素材集', 350.00, '圖像處理'),
(32, 'SketchUp 建築繪圖細部教學', 450.00, '圖像處理'),
(34, 'Excel VBA 超入門教室', 320.00, '辦公室軟體');

-- --------------------------------------------------------

--
-- 資料表結構 `guestbook`
--
-- 建立時間： 2023-12-26 08:46:38
-- 最後更新： 2023-12-26 09:09:32
--

CREATE TABLE `guestbook` (
  `msgId` int(10) UNSIGNED NOT NULL,
  `msgName` varchar(20) NOT NULL DEFAULT '無名氏',
  `msg` varchar(256) DEFAULT NULL,
  `msgDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 資料表新增資料前，先清除舊資料 `guestbook`
--

TRUNCATE TABLE `guestbook`;
--
-- 傾印資料表的資料 `guestbook`
--

INSERT INTO `guestbook` (`msgId`, `msgName`, `msg`, `msgDate`) VALUES
(1, '低頭族', '請問你們有出 Android 的相關書籍嗎?', '2014-04-02 15:17:41'),
(2, '旗標出版社', '親愛的低頭族讀者您好:\r\n\r\n我們已經出版相當多 Android 相關書籍, 您可以到我們的網站 http://www.flag.com.tw, 在右上角的搜尋欄輸入 \"Vista\", 就可以找到 Vista 書籍了。', '2014-04-02 16:17:05'),
(3, '王大頭', '我最近買了你們 Linux 的書來學, 覺得你們寫得很不錯, 觀念詳細步驟又清楚, 多多加油喔!', '2014-04-03 12:13:45');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`bookId`);

--
-- 資料表索引 `guestbook`
--
ALTER TABLE `guestbook`
  ADD PRIMARY KEY (`msgId`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `books`
--
ALTER TABLE `books`
  MODIFY `bookId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `guestbook`
--
ALTER TABLE `guestbook`
  MODIFY `msgId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
