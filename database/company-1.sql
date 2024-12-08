-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2024-06-04 10:40:19
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
-- 資料庫： `company`
--
CREATE DATABASE IF NOT EXISTS `company` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `company`;

-- --------------------------------------------------------

--
-- 資料表結構 `finished_product`
--
-- 建立時間： 2024-06-04 07:44:55
-- 最後更新： 2024-06-04 08:19:08
--

DROP TABLE IF EXISTS `finished_product`;
CREATE TABLE `finished_product` (
  `fp_no` char(6) NOT NULL COMMENT '成品編號',
  `fp_name` varchar(15) NOT NULL COMMENT '成品名稱',
  `fp_class` varchar(6) NOT NULL COMMENT '類別',
  `fp_made` varchar(10) DEFAULT NULL COMMENT '成品材質',
  `fp_inventory` int(11) NOT NULL COMMENT '庫存數量',
  `fp_state` char(4) NOT NULL DEFAULT '販售中' COMMENT '產品狀態',
  `safe_inventory` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 資料表新增資料前，先清除舊資料 `finished_product`
--

TRUNCATE TABLE `finished_product`;
--
-- 傾印資料表的資料 `finished_product`
--

INSERT INTO `finished_product` (`fp_no`, `fp_name`, `fp_class`, `fp_made`, `fp_inventory`, `fp_state`, `safe_inventory`) VALUES
('f00001', '彈套', 'A', '中碳鋼', 60, '販售中', 20),
('f00002', '梅花開板手8mm', 'A', NULL, 10, '販售中', 20),
('f00003', '梅花開板手10mm', 'A', NULL, 100, '販售中', 50),
('f00004', '梅花開板手11mm', 'A', NULL, 30, '販售中', 40),
('f00005', '梅花開板手12mm', 'A', NULL, 80, '販售中', 50),
('f00006', '梅花開板手13mm', 'A', NULL, 90, '販售中', 40),
('f00007', '梅花開板手14mm', 'A', NULL, 30, '販售中', 40),
('f00008', '梅花開板手17mm', 'B', NULL, 50, '販售中', 50),
('f00009', '梅花開板手19mm', 'B', NULL, 70, '販售中', 30),
('f00010', '梅花開板手22mm', 'B', NULL, 40, '販售中', 45),
('f00011', '五吋接杆', 'B', NULL, 30, '販售中', 30),
('f00012', '轉換接頭', 'B', '合金鋼', 110, '販售中', 40),
('f00013', '雙鉤鏡面短套筒14mm', 'B', '合金鋼', 90, '販售中', 20),
('f00014', '雙鉤鏡面短套筒15mm', 'B', NULL, 40, '販售中', 20),
('f00015', '雙鉤鏡面短套筒16mm', 'C', '中碳鋼', 10, '販售中', 30),
('f00016', '雙鉤鏡面短套筒17mm', 'C', NULL, 50, '販售中', 20),
('f00017', '雙鉤鏡面短套筒18mm', 'C', NULL, 50, '販售中', 25),
('f00018', '雙鉤鏡面短套筒19mm', 'C', NULL, 10, '販售中', 35),
('f00019', '雙鉤鏡面短套筒20mm', 'C', NULL, 30, '販售中', 20),
('f00020', '雙鉤鏡面短套筒21mm', 'C', NULL, 20, '販售中', 20),
('f00021', '雙鉤鏡面短套筒24mm', 'C', NULL, 40, '販售中', 15),
('f00022', '雙鉤鏡面短套筒27mm', 'D', NULL, 100, '販售中', 30),
('f00023', '雙鉤鏡面短套筒30mm', 'D', NULL, 10, '販售中', 35),
('f00024', '雙鉤鏡面短套筒32mm', 'D', '中碳鋼', 10, '販售中', 30),
('f00025', '火星塞套頭16mm', 'D', NULL, 100, '販售中', 45),
('f00026', '火星塞套頭21mm', 'D', NULL, 40, '販售中', 20),
('f00027', '1/4滑行杆', 'D', NULL, 20, '販售中', 35),
('f00028', '彈性接杆', 'D', NULL, 100, '販售中', 60),
('f00029', '1/2吋延長杆', 'E', NULL, 80, '販售中', 40),
('f00030', '1/4吋雙鉤鏡面短套筒4mm', 'E', NULL, 110, '販售中', 25),
('f00031', '1/4吋雙鉤鏡面短套筒4.5m', 'E', NULL, 100, '販售中', 30),
('f00032', '1/4吋雙鉤鏡面短套筒5mm', 'E', NULL, 30, '販售中', 50),
('f00033', '1/4吋雙鉤鏡面短套筒5.5m', 'E', '中碳鋼', 80, '販售中', 30),
('f00034', '1/4吋雙鉤鏡面短套筒6mm', 'E', NULL, 40, '販售中', 0),
('f00035', '1/4吋雙鉤鏡面短套筒7mm', 'E', NULL, 40, '販售中', 25),
('f00036', '1/4吋雙鉤鏡面短套筒8mm', 'F', NULL, 20, '販售中', 45),
('f00037', '1/4吋雙鉤鏡面短套筒9mm', 'F', NULL, 60, '販售中', 20),
('f00038', '1/4吋雙鉤鏡面短套筒10mm', 'F', NULL, 30, '販售中', 30),
('f00039', '1/4吋雙鉤鏡面短套筒11mm', 'F', NULL, 100, '販售中', 50),
('f00040', '1/4吋雙鉤鏡面短套筒12mm', 'F', NULL, 60, '販售中', 35),
('f00041', '1/4吋雙鉤鏡面短套筒13mm', 'F', NULL, 100, '販售中', 35),
('f00042', '1/4吋雙鉤鏡面短套筒14mm', 'F', '合金鋼', 70, '販售中', 80);

-- --------------------------------------------------------

--
-- 資料表結構 `finished_product_order`
--
-- 建立時間： 2024-06-04 07:25:12
--

DROP TABLE IF EXISTS `finished_product_order`;
CREATE TABLE `finished_product_order` (
  `fp_order_no` char(8) NOT NULL COMMENT '成品訂單編號',
  `fp_order_Tprice` decimal(10,2) NOT NULL COMMENT '成品訂單總價',
  `fp_order_time` datetime NOT NULL DEFAULT current_timestamp() COMMENT '交易時間',
  `fp_order_deadline` date NOT NULL COMMENT '交貨日',
  `fp_order_state` varchar(6) NOT NULL COMMENT '訂單狀態',
  `s_no` char(8) DEFAULT NULL COMMENT '供應商編號',
  `st_no` char(5) DEFAULT NULL COMMENT '採購人編號'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 資料表新增資料前，先清除舊資料 `finished_product_order`
--

TRUNCATE TABLE `finished_product_order`;
--
-- 傾印資料表的資料 `finished_product_order`
--

INSERT INTO `finished_product_order` (`fp_order_no`, `fp_order_Tprice`, `fp_order_time`, `fp_order_deadline`, `fp_order_state`, `s_no`, `st_no`) VALUES
('24403001', 14020.00, '2024-03-28 09:34:42', '2024-04-21', '待出貨', '00000607', 'st003'),
('24403002', 6095.00, '2024-03-28 09:34:42', '2024-04-20', '待出貨', '00000523', 'st002'),
('24403003', 6965.00, '2024-03-28 09:34:42', '2024-04-02', '完成', '00000273', 'st003'),
('24403004', 7595.00, '2024-03-28 09:34:42', '2024-04-02', '完成', '00000253', 'st003'),
('24403005', 240.00, '2024-03-28 09:34:42', '2024-04-11', '待出貨', '00000253', 'st001'),
('24403006', 9890.00, '2024-03-28 09:34:42', '2024-04-28', '待出貨', '00000273', 'st002'),
('24403007', 2340.00, '2024-03-28 09:34:42', '2024-04-08', '完成', '00000607', 'st001'),
('24403008', 420.00, '2024-03-28 09:34:42', '2024-04-19', '待出貨', '00000129', 'st002'),
('24403009', 5605.00, '2024-03-28 09:34:42', '2024-04-08', '完成', '00000607', 'st001'),
('24403010', 6660.00, '2024-03-28 09:34:42', '2024-04-13', '待出貨', '00000832', 'st002');

-- --------------------------------------------------------

--
-- 資料表結構 `finished_product_order_record`
--
-- 建立時間： 2024-06-04 07:25:12
--

DROP TABLE IF EXISTS `finished_product_order_record`;
CREATE TABLE `finished_product_order_record` (
  `fp_order_no` char(8) NOT NULL COMMENT '成品訂單編號',
  `fp_no` char(6) NOT NULL COMMENT '成品編號',
  `fp_Uprice` decimal(10,2) NOT NULL COMMENT '單價',
  `fp_quantity` int(11) NOT NULL COMMENT '數量'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 資料表新增資料前，先清除舊資料 `finished_product_order_record`
--

TRUNCATE TABLE `finished_product_order_record`;
--
-- 傾印資料表的資料 `finished_product_order_record`
--

INSERT INTO `finished_product_order_record` (`fp_order_no`, `fp_no`, `fp_Uprice`, `fp_quantity`) VALUES
('24403001', 'f00001', 47.00, 70),
('24403001', 'f00013', 50.00, 95),
('24403001', 'f00014', 38.00, 85),
('24403001', 'f00027', 25.00, 110),
('24403002', 'f00002', 42.00, 50),
('24403002', 'f00014', 43.00, 60),
('24403002', 'f00017', 13.00, 80),
('24403002', 'f00018', 15.00, 25),
('24403003', 'f00034', 28.00, 80),
('24403003', 'f00042', 45.00, 105),
('24403004', 'f00019', 41.00, 25),
('24403004', 'f00023', 37.00, 90),
('24403004', 'f00030', 36.00, 90),
('24403005', 'f00039', 12.00, 20),
('24403006', 'f00003', 14.00, 75),
('24403006', 'f00004', 37.00, 105),
('24403006', 'f00009', 45.00, 20),
('24403006', 'f00011', 37.00, 90),
('24403006', 'f00038', 29.00, 25),
('24403007', 'f00003', 26.00, 65),
('24403007', 'f00032', 13.00, 50),
('24403008', 'f00013', 14.00, 30),
('24403009', 'f00007', 23.00, 75),
('24403009', 'f00021', 22.00, 100),
('24403009', 'f00035', 16.00, 105),
('24403010', 'f00012', 44.00, 105),
('24403010', 'f00031', 24.00, 85);

-- --------------------------------------------------------

--
-- 資料表結構 `finished_product_process`
--
-- 建立時間： 2024-06-04 07:25:12
--

DROP TABLE IF EXISTS `finished_product_process`;
CREATE TABLE `finished_product_process` (
  `fpp_no` char(8) NOT NULL COMMENT '製程編號',
  `fpp_time` datetime NOT NULL DEFAULT current_timestamp() COMMENT '委託時間',
  `p_Tprice` decimal(10,2) NOT NULL COMMENT '製程總價',
  `rm_order_no` char(8) NOT NULL COMMENT '原料訂單編號',
  `fp_no` char(6) DEFAULT NULL COMMENT '成品編號',
  `fp_finished_quantity` int(11) NOT NULL COMMENT '預計完成量',
  `st_no` char(5) DEFAULT NULL COMMENT '採購人編號'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 資料表新增資料前，先清除舊資料 `finished_product_process`
--

TRUNCATE TABLE `finished_product_process`;
--
-- 傾印資料表的資料 `finished_product_process`
--

INSERT INTO `finished_product_process` (`fpp_no`, `fpp_time`, `p_Tprice`, `rm_order_no`, `fp_no`, `fp_finished_quantity`, `st_no`) VALUES
('24403001', '2024-03-28 11:08:25', 5440.00, '24403002', 'f00029', 80, 'st001'),
('24403002', '2024-03-28 11:08:25', 5808.00, '24403003', 'f00027', 110, 'st002'),
('24403003', '2024-03-28 11:08:25', 5250.00, '24403009', 'f00014', 75, 'st003'),
('24403004', '2024-03-28 11:08:25', 10000.00, '24403006', 'f00039', 100, 'st002'),
('24403005', '2024-03-28 11:08:25', 5250.00, '24403005', 'f00018', 70, 'st003'),
('24403006', '2024-03-28 11:08:25', 6200.00, '24403007', 'f00040', 80, 'st001'),
('24403007', '2024-03-28 11:08:25', 1364.00, '24403001', 'f00023', 20, 'st001'),
('24403008', '2024-03-28 11:08:25', 2353.00, '24403004', 'f00021', 40, 'st002'),
('24403009', '2024-03-28 11:08:25', 2976.00, '24403008', 'f00042', 45, 'st002'),
('24403010', '2024-03-28 11:08:25', 4060.00, '24403010', 'f00037', 75, 'st001'),
('fpptest1', '2024-04-07 16:20:00', 2340.00, 'test3004', 'f00038', 65, 'st002');

-- --------------------------------------------------------

--
-- 資料表結構 `processor`
--
-- 建立時間： 2024-06-04 07:25:12
--

DROP TABLE IF EXISTS `processor`;
CREATE TABLE `processor` (
  `p_no` char(8) NOT NULL COMMENT '加工商編號',
  `p_name` varchar(20) NOT NULL COMMENT '加工商名稱',
  `p_contact` varchar(6) NOT NULL COMMENT '聯絡人',
  `p_phone` varchar(10) NOT NULL COMMENT '加工商電話',
  `p_email` varchar(200) NOT NULL COMMENT '加工商email',
  `p_address` varchar(40) NOT NULL COMMENT '加工商地址',
  `p_state` varchar(6) NOT NULL DEFAULT '營業中' COMMENT '營業狀態'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 資料表新增資料前，先清除舊資料 `processor`
--

TRUNCATE TABLE `processor`;
--
-- 傾印資料表的資料 `processor`
--

INSERT INTO `processor` (`p_no`, `p_name`, `p_contact`, `p_phone`, `p_email`, `p_address`, `p_state`) VALUES
('20000146', '超吉貿易有限公司', '吳小姐', '0978103538', 'chaugee@ms59.hinet.net', '臺北市大同區承德路3段191巷8號1樓', '營業中'),
('20000147', '良聯工業股份有限公司', '楊先生', '0969426731', 'mail@lianglian.com.tw', '高雄市林園區五福里工業一路2號', '營業中'),
('20000204', '永鈿潤滑科技有限公司', '李小姐', '0970249334', 'chiba.tw@gmail.com', '臺中市神岡區岸裡里大豐路5段295巷21號', '營業中'),
('20000223', '松勤股份有限公司', '劉小姐', '0946807214', 'sctexco@sunchintex.com.tw', '桃園市龍潭區烏林里工二路1段169號', '營業中'),
('20000254', '星瑞實業有限公司', '黃先生', '0928815058', 'sinjui2004@yahoo.com.tw', '新北市林口區文林一街99巷12號5樓', '營業中'),
('20000274', '華鴻開發股份有限公司', '張先生', '0952008137', 'j352062@yahoo.com.tw', '嘉義縣水上鄉寬士村崎子頭22之176號1樓', '營業中'),
('20000282', '益廣嘉精密機械有限公司', '趙小姐', '0933620838', 'ygj.co@msa.hinet.net', '桃園縣八德市瑞泰里瑞源一街17號1樓', '營業中'),
('20000363', '凱斯達企業有限公司', '孫先生', '0948966112', 'kaisuda.cnc@msa.hinet.net', '嘉義縣大林鎮中坑里大埔美園區三路12號', '營業中'),
('20000528', '中部雷射股份有限公司', '陳小姐', '0923449883', 'mark@chungpu.com', '彰化縣員林市中央里中央路430號', '營業中'),
('20000633', '儀立鑫企業股份有限公司', '王小姐', '0998362464', 'elysion@elysion-tek.com.tw', '臺中市霧峰區四德里中投西路2段88號', '營業中'),
('20000662', '建光工業有限公司', '陳小姐', '0923713463', 'c1004089@ms18.hinet.net', '嘉義市西區友忠路307號', '營業中'),
('20000696', '普笠國際股份有限公司', '張先生', '0912656352', 'aresbelt@ms58.hinet.net', '臺南市永康區王行里王行路68巷36號', '營業中'),
('20000941', '佑誠機械股份有限公司', '王先生', '0921973254', 'cnc.yuchen@msa.hinet.net', '嘉義縣水上鄉下寮村鴿溪寮20-130號', '營業中'),
('20000955', '宏泰工業股份有限公司', '楊小姐', '0945732867', 'edward@hung-thai.com.tw', '臺南市永康區三民里和平東路79號', '營業中'),
('20000966', '國翔機械股份有限公司', '劉小姐', '0945560871', 'kuo123.hsiang@msa.hinet.net', '嘉義縣水上鄉下寮村鴿溪寮20-123號', '營業中');

-- --------------------------------------------------------

--
-- 資料表結構 `raw_material`
--
-- 建立時間： 2024-06-04 07:25:12
--

DROP TABLE IF EXISTS `raw_material`;
CREATE TABLE `raw_material` (
  `rm_no` char(6) NOT NULL COMMENT '原料編號',
  `rm_name` varchar(15) NOT NULL COMMENT '原料名稱',
  `rm_made` varchar(10) DEFAULT NULL COMMENT '原料材質',
  `rm_state` char(4) NOT NULL DEFAULT '使用中' COMMENT '使用狀態'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 資料表新增資料前，先清除舊資料 `raw_material`
--

TRUNCATE TABLE `raw_material`;
--
-- 傾印資料表的資料 `raw_material`
--

INSERT INTO `raw_material` (`rm_no`, `rm_name`, `rm_made`, `rm_state`) VALUES
('r00001', '銅塊', NULL, '使用中'),
('r00002', '鐵塊', NULL, '使用中'),
('r00003', '鋼材', NULL, '使用中'),
('r00004', '鋁合金', NULL, '使用中'),
('r00005', '塑料', NULL, '使用中'),
('r00006', '橡膠', NULL, '使用中'),
('s00001', '壓鑄件', NULL, '使用中'),
('s00002', '塑料模具', NULL, '使用中'),
('s00003', '鋼管', NULL, '使用中'),
('s00004', '鋁管', NULL, '使用中');

-- --------------------------------------------------------

--
-- 資料表結構 `raw_material_order`
--
-- 建立時間： 2024-06-04 07:25:12
--

DROP TABLE IF EXISTS `raw_material_order`;
CREATE TABLE `raw_material_order` (
  `rm_order_no` char(8) NOT NULL COMMENT '原料訂單編號',
  `rm_order_Tprice` decimal(10,2) NOT NULL COMMENT '原料訂單總價',
  `rm_order_time` datetime NOT NULL DEFAULT current_timestamp() COMMENT '交易時間',
  `rm_order_deadline` date NOT NULL COMMENT '交貨日',
  `rm_order_state` varchar(6) NOT NULL COMMENT '訂單狀態',
  `s_no` char(8) DEFAULT NULL COMMENT '供應商編號',
  `st_no` char(5) DEFAULT NULL COMMENT '採購人編號'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 資料表新增資料前，先清除舊資料 `raw_material_order`
--

TRUNCATE TABLE `raw_material_order`;
--
-- 傾印資料表的資料 `raw_material_order`
--

INSERT INTO `raw_material_order` (`rm_order_no`, `rm_order_Tprice`, `rm_order_time`, `rm_order_deadline`, `rm_order_state`, `s_no`, `st_no`) VALUES
('24403001', 1220.00, '2024-03-28 10:26:52', '2024-04-08', '待出貨', '00000221', 'st002'),
('24403002', 880.00, '2024-03-28 10:26:52', '2024-04-13', '完成', '00000627', 'st001'),
('24403003', 22220.00, '2024-03-28 10:26:52', '2024-04-15', '待出貨', '00000627', 'st002'),
('24403004', 1480.00, '2024-03-28 10:26:52', '2024-04-01', '完成', '00000832', 'st001'),
('24403005', 9730.00, '2024-03-28 10:26:52', '2024-04-08', '完成', '00000607', 'st002'),
('24403006', 13200.00, '2024-03-28 10:26:52', '2024-04-10', '完成', '00000607', 'st002'),
('24403007', 6400.00, '2024-03-28 10:26:52', '2024-04-14', '待出貨', '00000129', 'st003'),
('24403008', 5265.00, '2024-03-28 10:26:52', '2024-04-06', '完成', '00000523', 'st001'),
('24403009', 13650.00, '2024-03-28 10:26:52', '2024-04-08', '完成', '00000253', 'st002'),
('24403010', 825.00, '2024-03-28 10:26:52', '2024-04-10', '完成', '00000221', 'st001'),
('test3001', 10140.00, '2024-04-04 10:19:04', '2024-04-15', '待出貨', '00000273', 'st001'),
('test3002', 5520.00, '2024-04-04 10:19:04', '2024-04-14', '待出貨', '00000116', 'st003'),
('test3003', 6160.00, '2024-04-04 10:19:04', '2024-04-23', '待出貨', '00000129', 'st001'),
('test3004', 7930.00, '2024-04-04 10:19:04', '2024-04-06', '待出貨', '00000184', 'st001'),
('test3005', 950.00, '2024-04-04 10:19:04', '2024-04-08', '待出貨', '00000184', 'st001');

-- --------------------------------------------------------

--
-- 資料表結構 `raw_material_order_record`
--
-- 建立時間： 2024-06-04 07:25:12
--

DROP TABLE IF EXISTS `raw_material_order_record`;
CREATE TABLE `raw_material_order_record` (
  `rm_order_no` char(8) NOT NULL COMMENT '原料訂單編號',
  `rm_no` char(6) NOT NULL COMMENT '原料編號',
  `rm_Uprice` decimal(10,2) NOT NULL COMMENT '單價',
  `rm_quantity` int(11) NOT NULL COMMENT '數量'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 資料表新增資料前，先清除舊資料 `raw_material_order_record`
--

TRUNCATE TABLE `raw_material_order_record`;
--
-- 傾印資料表的資料 `raw_material_order_record`
--

INSERT INTO `raw_material_order_record` (`rm_order_no`, `rm_no`, `rm_Uprice`, `rm_quantity`) VALUES
('24403001', 'r00005', 37.00, 20),
('24403001', 's00003', 24.00, 20),
('24403002', 'r00001', 11.00, 80),
('24403003', 'r00001', 36.00, 110),
('24403003', 'r00003', 43.00, 110),
('24403003', 'r00004', 42.00, 110),
('24403003', 's00001', 32.00, 110),
('24403003', 's00002', 49.00, 110),
('24403004', 'r00003', 37.00, 40),
('24403005', 'r00004', 26.00, 70),
('24403005', 'r00005', 12.00, 70),
('24403005', 's00002', 26.00, 70),
('24403005', 's00003', 47.00, 70),
('24403005', 's00004', 28.00, 70),
('24403006', 'r00002', 46.00, 100),
('24403006', 'r00005', 39.00, 100),
('24403006', 'r00006', 26.00, 100),
('24403006', 's00003', 21.00, 100),
('24403007', 'r00006', 50.00, 80),
('24403007', 's00002', 30.00, 80),
('24403008', 'r00002', 41.00, 45),
('24403008', 'r00004', 43.00, 45),
('24403008', 'r00006', 33.00, 45),
('24403009', 'r00006', 42.00, 75),
('24403009', 's00001', 45.00, 75),
('24403009', 's00002', 47.00, 75),
('24403009', 's00003', 48.00, 75),
('24403010', 's00001', 11.00, 75),
('test3001', 'r00001', 21.00, 65),
('test3001', 'r00002', 38.00, 65),
('test3001', 'r00003', 41.00, 65),
('test3001', 'r00006', 35.00, 65),
('test3001', 's00004', 21.00, 65),
('test3002', 's00001', 20.00, 80),
('test3002', 's00003', 49.00, 80),
('test3003', 'r00003', 46.00, 40),
('test3003', 'r00004', 33.00, 40),
('test3003', 'r00006', 31.00, 40),
('test3003', 's00002', 44.00, 40),
('test3004', 'r00003', 40.00, 65),
('test3004', 'r00004', 49.00, 65),
('test3004', 'r00005', 33.00, 65),
('test3005', 'r00001', 19.00, 50);

-- --------------------------------------------------------

--
-- 資料表結構 `staff`
--
-- 建立時間： 2024-06-04 07:25:12
--

DROP TABLE IF EXISTS `staff`;
CREATE TABLE `staff` (
  `st_no` char(5) NOT NULL COMMENT '採購人編號',
  `st_name` varchar(6) NOT NULL COMMENT '姓名',
  `st_state` char(4) NOT NULL DEFAULT '就職中' COMMENT '就職狀態'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 資料表新增資料前，先清除舊資料 `staff`
--

TRUNCATE TABLE `staff`;
--
-- 傾印資料表的資料 `staff`
--

INSERT INTO `staff` (`st_no`, `st_name`, `st_state`) VALUES
('st001', '王小姐', '就職中'),
('st002', '李小姐', '就職中'),
('st003', '張先生', '就職中');

-- --------------------------------------------------------

--
-- 資料表結構 `sub_process`
--
-- 建立時間： 2024-06-04 07:25:12
--

DROP TABLE IF EXISTS `sub_process`;
CREATE TABLE `sub_process` (
  `fpp_no` char(8) NOT NULL COMMENT '製程編號',
  `sp_num` int(11) NOT NULL COMMENT '加工序號',
  `p_content` varchar(6) DEFAULT NULL COMMENT '備註',
  `p_quantity` int(11) DEFAULT NULL COMMENT '加工數量',
  `p_Uprice` decimal(10,2) DEFAULT NULL COMMENT '加工單價',
  `p_deadline` date NOT NULL COMMENT '加工期限',
  `p_state` varchar(6) NOT NULL DEFAULT '材料未運達' COMMENT '加工狀態',
  `p_loss` int(11) NOT NULL DEFAULT 0 COMMENT '損耗',
  `p_no` char(8) DEFAULT NULL COMMENT '加工商編號'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 資料表新增資料前，先清除舊資料 `sub_process`
--

TRUNCATE TABLE `sub_process`;
--
-- 傾印資料表的資料 `sub_process`
--

INSERT INTO `sub_process` (`fpp_no`, `sp_num`, `p_content`, `p_quantity`, `p_Uprice`, `p_deadline`, `p_state`, `p_loss`, `p_no`) VALUES
('24403001', 1, NULL, 80, 24.00, '2024-04-17', '加工中', 0, '20000955'),
('24403001', 2, NULL, 80, 20.00, '2024-04-22', '材料未運達', 0, '20000363'),
('24403001', 3, NULL, 80, 24.00, '2024-04-28', '材料未運達', 0, '20000204'),
('24403002', 1, NULL, 110, 18.00, '2024-04-19', '材料未運達', 0, '20000966'),
('24403002', 2, NULL, 110, 24.00, '2024-04-24', '材料未運達', 0, '20000662'),
('24403002', 3, NULL, 110, 10.80, '2024-04-29', '材料未運達', 0, '20000146'),
('24403003', 1, NULL, 75, 18.00, '2024-04-11', '加工中', 0, '20000966'),
('24403003', 2, NULL, 75, 13.00, '2024-04-14', '材料未運達', 0, '20000223'),
('24403003', 3, NULL, 75, 23.00, '2024-04-18', '材料未運達', 0, '20000282'),
('24403003', 4, NULL, 75, 16.00, '2024-04-23', '材料未運達', 0, '20000363'),
('24403004', 1, NULL, 100, 30.00, '2024-04-14', '加工中', 0, '20000274'),
('24403004', 2, NULL, 100, 23.00, '2024-04-20', '材料未運達', 0, '20000254'),
('24403004', 3, NULL, 100, 28.00, '2024-04-23', '材料未運達', 0, '20000282'),
('24403004', 4, NULL, 100, 19.00, '2024-04-28', '材料未運達', 0, '20000147'),
('24403005', 1, NULL, 70, 17.50, '2024-04-12', '加工中', 0, '20000274'),
('24403005', 2, NULL, 70, 19.50, '2024-04-16', '材料未運達', 0, '20000363'),
('24403005', 3, NULL, 70, 18.00, '2024-04-20', '材料未運達', 0, '20000223'),
('24403005', 4, NULL, 70, 20.00, '2024-04-23', '材料未運達', 0, '20000941'),
('24403006', 1, NULL, 80, 14.00, '2024-04-20', '材料未運達', 0, '20000274'),
('24403006', 2, NULL, 80, 12.50, '2024-04-25', '材料未運達', 0, '20000696'),
('24403006', 3, NULL, 80, 17.00, '2024-04-30', '材料未運達', 0, '20000223'),
('24403006', 4, NULL, 80, 19.00, '2024-05-05', '材料未運達', 0, '20000941'),
('24403006', 5, NULL, 80, 15.00, '2024-05-11', '材料未運達', 0, '20000147'),
('24403007', 1, NULL, 20, 16.00, '2024-04-13', '材料未運達', 0, '20000147'),
('24403007', 2, NULL, 20, 27.00, '2024-04-18', '材料未運達', 0, '20000941'),
('24403007', 3, NULL, 20, 16.20, '2024-04-21', '材料未運達', 0, '20000204'),
('24403007', 4, NULL, 20, 9.00, '2024-04-28', '材料未運達', 0, '20000146'),
('24403008', 1, NULL, 40, 22.00, '2024-04-13', '完成', 5, '20000662'),
('24403008', 2, NULL, 35, 14.00, '2024-04-19', '完成', 0, '20000223'),
('24403008', 3, NULL, 35, 13.00, '2024-04-25', '完成', 2, '20000633'),
('24403008', 4, NULL, 33, 16.00, '2024-04-28', '完成', 5, '20000282'),
('24403009', 1, NULL, 45, 15.00, '2024-04-15', '完成', 0, '20000147'),
('24403009', 2, NULL, 45, 11.00, '2024-04-19', '完成', 2, '20000955'),
('24403009', 3, NULL, 43, 14.00, '2024-04-23', '完成', 0, '20000633'),
('24403009', 4, NULL, 43, 18.00, '2024-04-30', '完成', 0, '20000282'),
('24403009', 5, NULL, 43, 10.00, '2024-05-04', '加工中', 0, '20000528'),
('24403010', 1, NULL, 75, 21.00, '2024-04-16', '完成', 5, '20000966'),
('24403010', 2, NULL, 70, 17.00, '2024-04-22', '加工中', 0, '20000633'),
('24403010', 3, NULL, 70, 18.50, '2024-04-29', '材料未運達', 0, '20000696'),
('fpptest1', 1, NULL, 65, 12.00, '2024-04-18', '材料未運達', 0, '20000955'),
('fpptest1', 2, NULL, 65, 14.00, '2024-04-22', '材料未運達', 0, '20000662'),
('fpptest1', 3, NULL, 65, 10.00, '2024-04-25', '材料未運達', 0, '20000966');

-- --------------------------------------------------------

--
-- 資料表結構 `supplier`
--
-- 建立時間： 2024-06-04 07:25:12
--

DROP TABLE IF EXISTS `supplier`;
CREATE TABLE `supplier` (
  `s_no` char(8) NOT NULL COMMENT '供應商編號',
  `s_name` varchar(20) NOT NULL COMMENT '供應商名稱',
  `s_contact` varchar(6) NOT NULL COMMENT '聯絡人',
  `s_phone` varchar(10) NOT NULL COMMENT '供應商電話',
  `s_email` varchar(200) NOT NULL COMMENT '供應商email',
  `s_address` varchar(40) NOT NULL COMMENT '供應商地址',
  `s_state` char(4) NOT NULL DEFAULT '營業中' COMMENT '營業狀態'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 資料表新增資料前，先清除舊資料 `supplier`
--

TRUNCATE TABLE `supplier`;
--
-- 傾印資料表的資料 `supplier`
--

INSERT INTO `supplier` (`s_no`, `s_name`, `s_contact`, `s_phone`, `s_email`, `s_address`, `s_state`) VALUES
('00000116', '詠宇科技有限公司', '王先生', '0959582682', 'yj23666@gmail.com', '臺中市神岡區岸裡里大洲路461號2樓', '營業中'),
('00000129', '吉勝企業社', '李先生', '0943365904', 'ken@yuancut.com.tw', '彰化縣彰化市西興里辭修路502巷13號1樓', '營業中'),
('00000184', '明將實業有限公司', '張先生', '0916539487', 'sales@mjtw.com.tw', '彰化縣和美鎮鐵山里秀東路41巷16號1樓', '營業中'),
('00000221', '臺灣保安工業股份有限公司', '劉小姐', '0923497763', 'justin.chen@tpagas.com', '臺北市中山區新生北路1段31號1樓', '營業中'),
('00000253', '太菖股份有限公司', '陳小姐', '0958030893', 'tay.charng@msa.hinet.net', '彰化縣線西鄉頂犁村和線路185巷131號', '營業中'),
('00000273', '力卡實業有限公司', '楊小姐', '0981068878', 'leeka.belinda@gmail.com', '臺中市西屯區協和里工業區三十八路210號5樓之1', '營業中'),
('00000523', '本達企業社', '黃小姐', '0951839655', 'b2dr478@yahoo.com.tw', '彰化縣和美鎮竹營里忠善路130號', '營業中'),
('00000607', '臺亨機械股份有限公司', '孫先生', '0932197919', 'tai.herng@msa.hinet.net', '新北市樹林區俊興街189號', '營業中'),
('00000627', '健程工業有限公司', '趙先生', '0994316138', 'sales@tsengson.com.tw', '新北市汐止市福德一路342巷2弄7號', '營業中'),
('00000832', '元長鴻有限公司', '吳先生', '0916136879', 'chang.shun888@msa.hinet.net', '臺中市大雅區中和路270號', '營業中');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `finished_product`
--
ALTER TABLE `finished_product`
  ADD PRIMARY KEY (`fp_no`);

--
-- 資料表索引 `finished_product_order`
--
ALTER TABLE `finished_product_order`
  ADD PRIMARY KEY (`fp_order_no`),
  ADD KEY `s_no` (`s_no`),
  ADD KEY `st_no` (`st_no`);

--
-- 資料表索引 `finished_product_order_record`
--
ALTER TABLE `finished_product_order_record`
  ADD PRIMARY KEY (`fp_order_no`,`fp_no`),
  ADD KEY `fp_no` (`fp_no`);

--
-- 資料表索引 `finished_product_process`
--
ALTER TABLE `finished_product_process`
  ADD PRIMARY KEY (`fpp_no`),
  ADD KEY `rm_order_no` (`rm_order_no`),
  ADD KEY `fp_no` (`fp_no`),
  ADD KEY `st_no` (`st_no`);

--
-- 資料表索引 `processor`
--
ALTER TABLE `processor`
  ADD PRIMARY KEY (`p_no`);

--
-- 資料表索引 `raw_material`
--
ALTER TABLE `raw_material`
  ADD PRIMARY KEY (`rm_no`);

--
-- 資料表索引 `raw_material_order`
--
ALTER TABLE `raw_material_order`
  ADD PRIMARY KEY (`rm_order_no`),
  ADD KEY `s_no` (`s_no`),
  ADD KEY `st_no` (`st_no`);

--
-- 資料表索引 `raw_material_order_record`
--
ALTER TABLE `raw_material_order_record`
  ADD PRIMARY KEY (`rm_order_no`,`rm_no`),
  ADD KEY `rm_no` (`rm_no`);

--
-- 資料表索引 `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`st_no`);

--
-- 資料表索引 `sub_process`
--
ALTER TABLE `sub_process`
  ADD PRIMARY KEY (`fpp_no`,`sp_num`),
  ADD KEY `p_no` (`p_no`);

--
-- 資料表索引 `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`s_no`);

--
-- 已傾印資料表的限制式
--

--
-- 資料表的限制式 `finished_product_order`
--
ALTER TABLE `finished_product_order`
  ADD CONSTRAINT `finished_product_order_ibfk_1` FOREIGN KEY (`s_no`) REFERENCES `supplier` (`s_no`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `finished_product_order_ibfk_2` FOREIGN KEY (`st_no`) REFERENCES `staff` (`st_no`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- 資料表的限制式 `finished_product_order_record`
--
ALTER TABLE `finished_product_order_record`
  ADD CONSTRAINT `finished_product_order_record_ibfk_1` FOREIGN KEY (`fp_order_no`) REFERENCES `finished_product_order` (`fp_order_no`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `finished_product_order_record_ibfk_2` FOREIGN KEY (`fp_no`) REFERENCES `finished_product` (`fp_no`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 資料表的限制式 `finished_product_process`
--
ALTER TABLE `finished_product_process`
  ADD CONSTRAINT `finished_product_process_ibfk_1` FOREIGN KEY (`rm_order_no`) REFERENCES `raw_material_order` (`rm_order_no`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `finished_product_process_ibfk_2` FOREIGN KEY (`fp_no`) REFERENCES `finished_product` (`fp_no`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `finished_product_process_ibfk_3` FOREIGN KEY (`st_no`) REFERENCES `staff` (`st_no`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- 資料表的限制式 `raw_material_order`
--
ALTER TABLE `raw_material_order`
  ADD CONSTRAINT `raw_material_order_ibfk_1` FOREIGN KEY (`s_no`) REFERENCES `supplier` (`s_no`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `raw_material_order_ibfk_2` FOREIGN KEY (`st_no`) REFERENCES `staff` (`st_no`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- 資料表的限制式 `raw_material_order_record`
--
ALTER TABLE `raw_material_order_record`
  ADD CONSTRAINT `raw_material_order_record_ibfk_1` FOREIGN KEY (`rm_order_no`) REFERENCES `raw_material_order` (`rm_order_no`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `raw_material_order_record_ibfk_2` FOREIGN KEY (`rm_no`) REFERENCES `raw_material` (`rm_no`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 資料表的限制式 `sub_process`
--
ALTER TABLE `sub_process`
  ADD CONSTRAINT `sub_process_ibfk_1` FOREIGN KEY (`fpp_no`) REFERENCES `finished_product_process` (`fpp_no`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sub_process_ibfk_2` FOREIGN KEY (`p_no`) REFERENCES `processor` (`p_no`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
