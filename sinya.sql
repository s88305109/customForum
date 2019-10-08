-- phpMyAdmin SQL Dump
-- version 4.6.0
-- http://www.phpmyadmin.net
--
-- 主機: localhost
-- 產生時間： 2019-10-03 14:28:28
-- 伺服器版本: 5.6.17
-- PHP 版本： 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `sinya`
--

-- --------------------------------------------------------

--
-- 資料表結構 `cust`
--

CREATE TABLE `cust` (
  `cust_id` int(11) NOT NULL COMMENT '客戶ID',
  `card_id` varchar(20) NOT NULL DEFAULT '' COMMENT '會員卡號',
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '姓名',
  `id_num` varchar(10) DEFAULT NULL COMMENT '身分證字號',
  `sex` char(1) NOT NULL DEFAULT '' COMMENT '性別',
  `birth` date DEFAULT NULL COMMENT '生日',
  `tel` varchar(20) DEFAULT NULL COMMENT '電話1',
  `tel1` varchar(20) DEFAULT NULL COMMENT '電話2',
  `fax` varchar(20) DEFAULT NULL COMMENT '傳真',
  `mobile` varchar(20) DEFAULT NULL COMMENT '手機',
  `mail` varchar(100) DEFAULT NULL COMMENT 'Mail',
  `city_id` int(11) DEFAULT NULL COMMENT '縣市ID',
  `local_id` int(11) DEFAULT NULL COMMENT '鄉鎮市區ID',
  `addr` varchar(100) DEFAULT NULL COMMENT '地址',
  `invoice_id` varchar(8) DEFAULT NULL COMMENT '統一編號',
  `invoice` varchar(50) DEFAULT NULL COMMENT '發票抬頭',
  `cust_industry_id` int(11) NOT NULL DEFAULT '1' COMMENT '行業別',
  `cust_level_id` int(11) NOT NULL DEFAULT '1' COMMENT '會員等級',
  `introducer` int(11) DEFAULT NULL,
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '營業據點',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '服務人員',
  `credit` int(11) NOT NULL DEFAULT '0' COMMENT '信用額度',
  `memo` text COMMENT '備註',
  `consume` int(11) DEFAULT '0' COMMENT '消費總額',
  `stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '異動時間',
  `point_exist` int(6) NOT NULL DEFAULT '50',
  `epaper` tinyint(1) DEFAULT '1' COMMENT '是否訂閱epaper',
  `account` varchar(50) DEFAULT NULL COMMENT '帳號',
  `passwd` varchar(16) DEFAULT NULL COMMENT '密碼',
  `point_spent` int(6) NOT NULL DEFAULT '0',
  `point_total` int(6) DEFAULT NULL,
  `agent` tinyint(4) NOT NULL DEFAULT '0',
  `user_id1` int(11) NOT NULL DEFAULT '0',
  `career_id` int(11) NOT NULL DEFAULT '0' COMMENT '職業',
  `xposition_id` int(11) NOT NULL DEFAULT '0' COMMENT '職務',
  `cust_income_id` int(11) NOT NULL DEFAULT '0' COMMENT '收入',
  `education_id` int(11) NOT NULL DEFAULT '0' COMMENT '教育程度',
  `confirm` varchar(20) NOT NULL DEFAULT '' COMMENT '確認ID',
  `recommander_id` int(4) NOT NULL DEFAULT '0' COMMENT '推薦人ID',
  `first_spentdate` datetime NOT NULL,
  `registered` date NOT NULL,
  `school` int(11) DEFAULT NULL,
  `major` int(11) DEFAULT NULL,
  `cust_info_id` int(11) NOT NULL DEFAULT '0',
  `store_apply_id` tinyint(4) NOT NULL DEFAULT '0',
  `build_date` datetime NOT NULL COMMENT '註冊會員時間',
  `sell_count` int(11) NOT NULL DEFAULT '0',
  `acc_name` varchar(20) DEFAULT NULL COMMENT '會計科目ID',
  `acc_name1` varchar(20) DEFAULT NULL,
  `nick_name` varchar(20) DEFAULT NULL COMMENT '尊稱',
  `platinum_id` varchar(10) NOT NULL DEFAULT '' COMMENT '白金卡號',
  `platinum_s_date` date NOT NULL COMMENT '白金卡開始日期',
  `platinum_e_date` date NOT NULL COMMENT '白金卡結束日期',
  `platinum_point` int(11) NOT NULL DEFAULT '0' COMMENT '白金卡點數',
  `platinum_cust_id` int(11) NOT NULL DEFAULT '0' COMMENT '白金卡介紹人',
  `platinum_point_use` int(11) NOT NULL DEFAULT '0',
  `black_list` char(1) NOT NULL DEFAULT 'N' COMMENT '黑名單',
  `buy_name_1` varchar(30) NOT NULL DEFAULT '' COMMENT '採買人1',
  `buy_title_1` varchar(20) NOT NULL DEFAULT '' COMMENT '採買人1職稱  1050707新增',
  `buy_tel_1` varchar(20) NOT NULL DEFAULT '' COMMENT '採買人1電話  1050707新增',
  `buy_tel_ext_1` varchar(20) NOT NULL DEFAULT '' COMMENT '採買人1分機  1050707新增',
  `buy_fax_1` varchar(20) NOT NULL DEFAULT '' COMMENT '採買人1傳真  1050707新增',
  `buy_mail_1` varchar(100) NOT NULL DEFAULT '' COMMENT '採買人1信箱  1050707新增',
  `buy_name_2` varchar(30) NOT NULL DEFAULT '' COMMENT '採買人2',
  `buy_title_2` varchar(20) NOT NULL DEFAULT '' COMMENT '採買人2職稱  1050707新增',
  `buy_tel_2` varchar(20) NOT NULL DEFAULT '' COMMENT '採買人2電話  1050707新增',
  `buy_tel_ext_2` varchar(20) NOT NULL DEFAULT '' COMMENT '採買人2分機  1050707新增',
  `buy_fax_2` varchar(20) NOT NULL DEFAULT '' COMMENT '採買人2傳真  1050707新增',
  `buy_mail_2` varchar(100) NOT NULL DEFAULT '' COMMENT '採買人2信箱  1050707新增',
  `buy_name_m` varchar(30) NOT NULL DEFAULT '' COMMENT '採買主管',
  `buy_title_m` varchar(20) NOT NULL DEFAULT '' COMMENT '採買主管職稱  1050707新增',
  `buy_tel_m` varchar(20) NOT NULL DEFAULT '' COMMENT '採買主管電話  1050707新增',
  `buy_tel_ext_m` varchar(20) NOT NULL DEFAULT '' COMMENT '採買主管分機  1050707新增',
  `buy_fax_m` varchar(20) NOT NULL DEFAULT '' COMMENT '採買主管傳真  1050707新增',
  `buy_mail_m` varchar(100) NOT NULL DEFAULT '' COMMENT '採買主管信箱  1050707新增',
  `acc_memo` text NOT NULL COMMENT '財務備註',
  `acc_day_id` int(11) NOT NULL COMMENT '賒銷天數參數',
  `acc_pay_id` int(11) NOT NULL COMMENT '賒銷付款方式參數',
  `acc_tel` varchar(20) DEFAULT NULL COMMENT '帳務聯絡人電話',
  `acc_fax` varchar(20) DEFAULT NULL COMMENT '帳務聯絡人傳真',
  `acc_tel_ext` varchar(20) DEFAULT NULL COMMENT '帳務聯絡人分機  1050707新增',
  `acc_user_title` varchar(20) DEFAULT NULL COMMENT '帳號聯絡人職稱  1050707新增',
  `acc_user` varchar(20) DEFAULT NULL COMMENT '帳務聯絡人',
  `acc_mail` varchar(50) DEFAULT NULL COMMENT '帳務聯絡人Mail',
  `close` char(1) NOT NULL DEFAULT 'N' COMMENT '停用',
  `proj_percent` int(11) NOT NULL DEFAULT '100' COMMENT '專案百分比',
  `credit_type` char(1) NOT NULL DEFAULT 'N' COMMENT '信用類別 N:否 P:預開 C:賖',
  `store_credit_date` date NOT NULL,
  `store_credit_user` varchar(10) DEFAULT NULL,
  `fb_id` varchar(16) DEFAULT NULL COMMENT 'FB帳號',
  `confirm_status` int(1) NOT NULL DEFAULT '1' COMMENT '0:舊會員(未認證) , 1:新會員(未認證 | default) , 2:已認證',
  `confirm_time` datetime NOT NULL COMMENT '認證有效時間',
  `confirm_code` varchar(17) NOT NULL COMMENT '認證碼',
  `project` char(1) NOT NULL DEFAULT '0' COMMENT '專案',
  `cycle` int(11) DEFAULT NULL COMMENT '月結⊙30⊙45⊙60⊙90⊙120 天',
  `payment` int(11) DEFAULT NULL COMMENT '付款方式⊙匯款⊙支票⊙現金',
  `checkout_day` int(11) DEFAULT NULL COMMENT '結帳日 每月____日',
  `remit_day` int(11) DEFAULT NULL COMMENT '匯款日',
  `loop_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '額度循環',
  `report_unfold` tinyint(4) NOT NULL,
  `enc_name` blob NOT NULL,
  `enc_tel` blob NOT NULL,
  `enc_tel1` blob NOT NULL,
  `enc_mobile` blob NOT NULL,
  `enc_mail` blob NOT NULL,
  `enc_addr` blob NOT NULL,
  `web_member` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否為2015新網購平台新會員',
  `web_account` varchar(50) DEFAULT NULL COMMENT '2015新網購平台會員帳號(Email)',
  `web_password` varchar(32) DEFAULT NULL COMMENT '2015新網購平台會員密碼(MD5)',
  `partner` tinyint(1) NOT NULL DEFAULT '0' COMMENT '2015新網購平台一般會員是0聯盟商是1 聯盟商業務是2',
  `camprice` tinyint(4) NOT NULL DEFAULT '0',
  `enterprise` tinyint(4) DEFAULT '0' COMMENT '企業用戶',
  `company` int(5) DEFAULT NULL COMMENT '公司',
  `post` int(5) DEFAULT NULL COMMENT '職稱ID',
  `mis_name` varchar(50) DEFAULT NULL COMMENT '客戶公司資訊人員的名稱',
  `mis_email` varchar(255) DEFAULT NULL COMMENT '客戶公司資訊人員的信箱',
  `purchase_name` varchar(50) DEFAULT NULL COMMENT '客戶公司採購人員的名稱',
  `purchase_email` varchar(255) DEFAULT NULL COMMENT '客戶公司採購人員的信箱',
  `enterprise_agree` int(1) DEFAULT '0' COMMENT '使用條款',
  `company_create` date DEFAULT NULL COMMENT '公司設立時間  1050707新增',
  `registered_capital` varchar(50) DEFAULT NULL COMMENT '登記資本額  1050707新增',
  `real_capital` varchar(50) DEFAULT NULL COMMENT '實收資本額  1050707新增',
  `apply_credit_date` date DEFAULT NULL COMMENT '循環到期日  1050707新增',
  `payment_terms_other` varchar(50) DEFAULT NULL COMMENT '其他付款方式  1050707新增',
  `bank` varchar(50) DEFAULT NULL COMMENT '匯款銀行',
  `bank_branches` varchar(50) DEFAULT NULL COMMENT '匯款銀行-分行',
  `bank_name` varchar(50) DEFAULT NULL COMMENT '匯款銀行-帳戶名稱',
  `bank_number` varchar(100) DEFAULT NULL COMMENT '匯款銀行-帳號',
  `apply_condition` int(11) DEFAULT NULL COMMENT '賒銷申請條件',
  `concat_id` varchar(40) DEFAULT NULL COMMENT '串接帳號',
  `concat_type` int(11) DEFAULT '0' COMMENT '0:無,1:FB,2:Line'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- 資料表的匯出資料 `cust`
--

INSERT INTO `cust` (`cust_id`, `card_id`, `name`, `id_num`, `sex`, `birth`, `tel`, `tel1`, `fax`, `mobile`, `mail`, `city_id`, `local_id`, `addr`, `invoice_id`, `invoice`, `cust_industry_id`, `cust_level_id`, `introducer`, `store_id`, `user_id`, `credit`, `memo`, `consume`, `stamp`, `point_exist`, `epaper`, `account`, `passwd`, `point_spent`, `point_total`, `agent`, `user_id1`, `career_id`, `xposition_id`, `cust_income_id`, `education_id`, `confirm`, `recommander_id`, `first_spentdate`, `registered`, `school`, `major`, `cust_info_id`, `store_apply_id`, `build_date`, `sell_count`, `acc_name`, `acc_name1`, `nick_name`, `platinum_id`, `platinum_s_date`, `platinum_e_date`, `platinum_point`, `platinum_cust_id`, `platinum_point_use`, `black_list`, `buy_name_1`, `buy_title_1`, `buy_tel_1`, `buy_tel_ext_1`, `buy_fax_1`, `buy_mail_1`, `buy_name_2`, `buy_title_2`, `buy_tel_2`, `buy_tel_ext_2`, `buy_fax_2`, `buy_mail_2`, `buy_name_m`, `buy_title_m`, `buy_tel_m`, `buy_tel_ext_m`, `buy_fax_m`, `buy_mail_m`, `acc_memo`, `acc_day_id`, `acc_pay_id`, `acc_tel`, `acc_fax`, `acc_tel_ext`, `acc_user_title`, `acc_user`, `acc_mail`, `close`, `proj_percent`, `credit_type`, `store_credit_date`, `store_credit_user`, `fb_id`, `confirm_status`, `confirm_time`, `confirm_code`, `project`, `cycle`, `payment`, `checkout_day`, `remit_day`, `loop_type`, `report_unfold`, `enc_name`, `enc_tel`, `enc_tel1`, `enc_mobile`, `enc_mail`, `enc_addr`, `web_member`, `web_account`, `web_password`, `partner`, `camprice`, `enterprise`, `company`, `post`, `mis_name`, `mis_email`, `purchase_name`, `purchase_email`, `enterprise_agree`, `company_create`, `registered_capital`, `real_capital`, `apply_credit_date`, `payment_terms_other`, `bank`, `bank_branches`, `bank_name`, `bank_number`, `apply_condition`, `concat_id`, `concat_type`) VALUES
(3350593, 'C3350593', '吳崑山', 'C3350593', '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, 0, 0, 0, NULL, 0, '2019-03-14 08:44:29', 50, 1, NULL, NULL, 0, NULL, 0, 0, 0, 0, 0, 0, '', 0, '0000-00-00 00:00:00', '0000-00-00', NULL, NULL, 0, 0, '0000-00-00 00:00:00', 0, NULL, NULL, '○山●', '', '0000-00-00', '0000-00-00', 0, 0, 0, 'N', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'N', 100, 'N', '0000-00-00', NULL, NULL, 1, '0000-00-00 00:00:00', '', '0', NULL, NULL, NULL, NULL, 0, 0, '', '', '', '', '', '', 1, 's88305109@yahoo.com.tw', 'e10adc3949ba59abbe56e057f20f883e', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(1, '1', '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, 0, 0, 0, NULL, 0, '2019-03-29 06:51:08', 50, 1, NULL, NULL, 0, NULL, 0, 0, 0, 0, 0, 0, '', 0, '0000-00-00 00:00:00', '0000-00-00', NULL, NULL, 0, 0, '0000-00-00 00:00:00', 0, NULL, NULL, '管理員', '', '0000-00-00', '0000-00-00', 0, 0, 0, 'N', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'N', 100, 'N', '0000-00-00', NULL, NULL, 1, '0000-00-00 00:00:00', '', '0', NULL, NULL, NULL, NULL, 0, 0, '', '', '', '', '', '', 1, 'tester01@yahoo.com.tw', NULL, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(2, '2', '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, 0, 0, 0, NULL, 0, '2019-03-29 06:52:30', 50, 1, NULL, NULL, 0, NULL, 0, 0, 0, 0, 0, 0, '', 0, '0000-00-00 00:00:00', '0000-00-00', NULL, NULL, 0, 0, '0000-00-00 00:00:00', 0, NULL, NULL, '小妹妹', '', '0000-00-00', '0000-00-00', 0, 0, 0, 'N', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'N', 100, 'N', '0000-00-00', NULL, NULL, 1, '0000-00-00 00:00:00', '', '0', NULL, NULL, NULL, NULL, 0, 0, '', '', '', '', '', '', 1, 'tester02@gmail.com', NULL, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(3350594, '', '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, 0, 0, 0, NULL, 0, '2019-03-29 06:52:30', 50, 1, NULL, NULL, 0, NULL, 0, 0, 0, 0, 0, 0, '', 0, '0000-00-00 00:00:00', '0000-00-00', NULL, NULL, 0, 0, '0000-00-00 00:00:00', 0, NULL, NULL, '電應小弟', '', '0000-00-00', '0000-00-00', 0, 0, 0, 'N', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'N', 100, 'N', '0000-00-00', NULL, NULL, 1, '0000-00-00 00:00:00', '', '0', NULL, NULL, NULL, NULL, 0, 0, '', '', '', '', '', '', 1, NULL, NULL, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(3350595, 'C3350595', '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, 0, 0, 0, NULL, 0, '2019-05-27 06:02:11', 50, 1, NULL, NULL, 0, NULL, 0, 0, 0, 0, 0, 0, '', 0, '0000-00-00 00:00:00', '0000-00-00', NULL, NULL, 0, 0, '0000-00-00 00:00:00', 0, NULL, NULL, '測試管理員', '', '0000-00-00', '0000-00-00', 0, 0, 0, 'N', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'N', 100, 'N', '0000-00-00', NULL, NULL, 1, '0000-00-00 00:00:00', '', '0', NULL, NULL, NULL, NULL, 0, 0, '', '', '', '', '', '', 1, 'admin@test.com', 'e10adc3949ba59abbe56e057f20f883e', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(3350596, 'C3350596', '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, 0, 0, 0, NULL, 0, '2019-05-27 06:02:11', 50, 1, NULL, NULL, 0, NULL, 0, 0, 0, 0, 0, 0, '', 0, '0000-00-00 00:00:00', '0000-00-00', NULL, NULL, 0, 0, '0000-00-00 00:00:00', 0, NULL, NULL, '使用者1', '', '0000-00-00', '0000-00-00', 0, 0, 0, 'N', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'N', 100, 'N', '0000-00-00', NULL, NULL, 1, '0000-00-00 00:00:00', '', '0', NULL, NULL, NULL, NULL, 0, 0, '', '', '', '', '', '', 1, 'user01@test.com', 'e10adc3949ba59abbe56e057f20f883e', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(3350597, 'C3350597', '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, 0, 0, 0, NULL, 0, '2019-05-27 06:02:11', 50, 1, NULL, NULL, 0, NULL, 0, 0, 0, 0, 0, 0, '', 0, '0000-00-00 00:00:00', '0000-00-00', NULL, NULL, 0, 0, '0000-00-00 00:00:00', 0, NULL, NULL, '使用者2', '', '0000-00-00', '0000-00-00', 0, 0, 0, 'N', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'N', 100, 'N', '0000-00-00', NULL, NULL, 1, '0000-00-00 00:00:00', '', '0', NULL, NULL, NULL, NULL, 0, 0, '', '', '', '', '', '', 1, 'user02@test.com', 'e10adc3949ba59abbe56e057f20f883e', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(3350598, 'C3350598', '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, 0, 0, 0, NULL, 0, '2019-05-27 06:02:11', 50, 1, NULL, NULL, 0, NULL, 0, 0, 0, 0, 0, 0, '', 0, '0000-00-00 00:00:00', '0000-00-00', NULL, NULL, 0, 0, '0000-00-00 00:00:00', 0, NULL, NULL, '使用者3', '', '0000-00-00', '0000-00-00', 0, 0, 0, 'N', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'N', 100, 'N', '0000-00-00', NULL, NULL, 1, '0000-00-00 00:00:00', '', '0', NULL, NULL, NULL, NULL, 0, 0, '', '', '', '', '', '', 1, 'user03@test.com', 'e10adc3949ba59abbe56e057f20f883e', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- 資料表結構 `nsf_announcement`
--

CREATE TABLE `nsf_announcement` (
  `announcementID` int(11) NOT NULL,
  `title` text NOT NULL,
  `link` text NOT NULL,
  `startTime` datetime NOT NULL,
  `endTime` datetime NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `nsf_announcement`
--

INSERT INTO `nsf_announcement` (`announcementID`, `title`, `link`, `startTime`, `endTime`, `status`) VALUES
(1, '年終跑車大方送', 'http://www.sinya.com.tw', '2019-01-01 09:00:00', '2019-12-31 23:59:00', 1),
(4, '2080送給你', '', '2019-06-01 00:00:00', '2019-06-01 23:59:59', 1);

-- --------------------------------------------------------

--
-- 資料表結構 `nsf_banner`
--

CREATE TABLE `nsf_banner` (
  `bannerID` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `link` text NOT NULL,
  `position` varchar(32) NOT NULL,
  `filename` varchar(250) NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `nsf_banner`
--

INSERT INTO `nsf_banner` (`bannerID`, `title`, `description`, `link`, `position`, `filename`, `sort`, `status`) VALUES
(1, '春季', '春季購機加碼送', '', 'index', '5c8a0c7c44285.jpg', 2, 1),
(2, '搬家', '台南北門店搬家了', '', 'index', '5c8a0c4bda66d.jpg', 0, 1),
(7, '青春美機', '青春美機', 'http://localhost/sinyaforum/topic/60', 'index', '5c8a0c3ce8a05.jpg', 1, 1);

-- --------------------------------------------------------

--
-- 資料表結構 `nsf_board`
--

CREATE TABLE `nsf_board` (
  `boardID` int(11) NOT NULL,
  `categoryID` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(200) NOT NULL,
  `iconName` varchar(100) NOT NULL DEFAULT 'fa-laptop',
  `posts` int(11) NOT NULL DEFAULT '0',
  `responses` int(11) NOT NULL DEFAULT '0',
  `highlight` tinyint(4) NOT NULL DEFAULT '0',
  `sort` int(11) NOT NULL DEFAULT '0',
  `visible` tinyint(4) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `lastUpdateTime` datetime DEFAULT NULL,
  `lastUpdateMemberID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `nsf_board`
--

INSERT INTO `nsf_board` (`boardID`, `categoryID`, `title`, `description`, `iconName`, `posts`, `responses`, `highlight`, `sort`, `visible`, `status`, `lastUpdateTime`, `lastUpdateMemberID`) VALUES
(1, 1, '優惠情報', '欣亞優惠活動專區，關注本館搶好康！', 'fas fa-donate', 123, 256, 0, 5, 1, 1, NULL, NULL),
(2, 1, '最新資訊', '欣亞優惠活動專區，關注本館搶好康！', 'fas fa-bullhorn', 20, 0, 0, 4, 1, 1, NULL, NULL),
(3, 1, '軟體分享區', '欣亞優惠活動專區，關注本館搶好康！', 'fas fa-users', 10, 0, 0, 6, 1, 1, NULL, NULL),
(4, 2, '筆電詢價分享', '筆電購買先來此區詢價，將想購買的品牌、型號貼上看看別人怎麼說', 'fas fa-laptop', 547, 703, 0, 8, 1, 1, '2019-03-28 16:09:21', 1),
(5, 2, '電腦組裝請益估價', '對於硬體購買的問題不管是價格還是規格都歡迎來本區發問', 'fas fa-desktop', 1274, 5791, 0, 7, 1, 1, '2019-09-13 01:25:32', 5),
(6, 2, '軟硬體問題', '硬體安裝上的問題與軟體或系統上的疑難雜症歡迎在本區發問', 'fas fa-server', 0, 0, 0, 9, 1, 1, '2019-03-01 00:00:00', 555),
(7, 2, 'Apple專區', '筆電購買先來此區詢價，將想購買的品牌、型號貼上看別人怎麼說', 'fab fa-apple', 2, 0, 0, 10, 1, 1, '2019-03-05 20:21:07', 1),
(8, 2, '原廠維修站點資訊', '對於硬體購買的問題不管是價格還是規格都歡迎來本區發問對', 'fas fa-wrench', 0, 0, 0, 11, 1, 1, NULL, NULL),
(9, 3, 'DIY 電腦零件組', 'D 1\r\nI 2\r\nY 3', 'fas fa-wrench', 14, 16, 0, 12, 1, 1, '2019-09-22 01:28:27', 6),
(10, 3, '電腦手機與行動裝置', '', 'fas fa-mobile-alt', 1, 0, 0, 13, 1, 1, '2019-08-10 21:57:41', 5),
(11, 3, 'Apple使用分享', '', 'fab fa-apple', 0, 0, 0, 14, 1, 1, NULL, NULL),
(12, 3, '周邊商品', '', 'fas fa-headphones', 0, 0, 0, 15, 1, 1, NULL, NULL),
(13, 4, '註冊、帳務問題', '', 'fas fa-user', 1, 0, 0, 0, 1, 1, '2019-05-24 00:20:37', 4),
(14, 4, '文章投訴、申訴問題', '', 'fas fa-newspaper', 0, 0, 0, 1, 1, 1, NULL, NULL),
(15, 4, '過期、失效文章', '', 'fas fa-newspaper', 0, 0, 0, 2, 1, 1, NULL, NULL),
(16, 1, '欣亞官方公告', '', 'far fa-bell', 5, 7, 1, 3, 1, 1, '2019-07-10 18:56:54', 5),
(17, 6, '墳場', '', 'fa-laptop', 1, 0, 0, 16, 0, 1, '2019-03-16 21:58:49', 1);

-- --------------------------------------------------------

--
-- 資料表結構 `nsf_category`
--

CREATE TABLE `nsf_category` (
  `categoryID` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(200) NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '0',
  `visible` tinyint(4) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `nsf_category`
--

INSERT INTO `nsf_category` (`categoryID`, `title`, `description`, `sort`, `visible`, `status`) VALUES
(1, '王牌大活動', '王牌...', 1, 1, 1),
(2, '疑難雜症處理 (問題發問請來此區)', '', 3, 1, 1),
(3, '開箱評測與使用心得分享', '', 2, 1, 1),
(4, '論壇站務', '', 0, 1, 1),
(5, '閒聊區', '聊天打屁不設限', 4, 1, 1),
(6, '垃圾場', '', 5, 0, 1);

-- --------------------------------------------------------

--
-- 資料表結構 `nsf_collection`
--

CREATE TABLE `nsf_collection` (
  `collectionID` int(11) NOT NULL,
  `memberID` int(11) NOT NULL,
  `topicID` int(11) NOT NULL,
  `collectionTime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `nsf_collection`
--

INSERT INTO `nsf_collection` (`collectionID`, `memberID`, `topicID`, `collectionTime`) VALUES
(4, 1, 31, '2019-03-23 04:18:29'),
(5, 5, 103, '2019-07-05 11:11:36');

-- --------------------------------------------------------

--
-- 資料表結構 `nsf_draft`
--

CREATE TABLE `nsf_draft` (
  `draftID` int(11) NOT NULL,
  `boardID` int(11) DEFAULT NULL,
  `subjectID` int(11) DEFAULT NULL,
  `title` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `memberID` int(11) NOT NULL,
  `saveTime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `nsf_history`
--

CREATE TABLE `nsf_history` (
  `historyID` int(11) NOT NULL,
  `topicID` int(11) NOT NULL,
  `memberID` int(11) NOT NULL,
  `browseTime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `nsf_history`
--

INSERT INTO `nsf_history` (`historyID`, `topicID`, `memberID`, `browseTime`) VALUES
(1, 73, 1, '2019-03-18 23:36:48'),
(2, 72, 1, '2019-03-18 23:36:55'),
(3, 71, 1, '2019-03-18 23:46:30'),
(4, 31, 1, '2019-03-18 23:58:25'),
(5, 75, 1, '2019-03-19 01:10:29'),
(6, 83, 1, '2019-03-20 00:32:48'),
(7, 76, 1, '2019-03-20 00:40:55'),
(8, 74, 1, '2019-03-20 00:41:11'),
(9, 84, 1, '2019-03-20 01:06:10'),
(10, 34, 1, '2019-03-20 01:25:52'),
(11, 87, 1, '2019-03-28 16:13:37'),
(12, 86, 4, '2019-05-24 00:14:45'),
(13, 88, 4, '2019-05-24 00:20:40'),
(14, 91, 5, '2019-05-29 15:53:14'),
(15, 86, 5, '2019-05-29 15:55:20'),
(16, 31, 5, '2019-06-18 22:54:37'),
(17, 90, 5, '2019-06-18 23:44:30'),
(18, 97, 5, '2019-06-18 23:44:36'),
(19, 99, 5, '2019-06-18 23:50:09'),
(20, 101, 5, '2019-07-03 16:15:37'),
(21, 102, 5, '2019-07-03 16:20:05'),
(22, 103, 5, '2019-07-05 10:48:27'),
(23, 97, 6, '2019-07-05 10:51:58'),
(24, 104, 5, '2019-07-10 18:01:03'),
(25, 60, 5, '2019-07-10 19:02:42'),
(26, 103, 6, '2019-08-10 20:36:08'),
(27, 116, 5, '2019-08-10 22:05:38'),
(28, 113, 5, '2019-08-10 22:20:39'),
(29, 34, 5, '2019-08-24 19:15:54'),
(30, 121, 6, '2019-09-22 01:27:13');

-- --------------------------------------------------------

--
-- 資料表結構 `nsf_level`
--

CREATE TABLE `nsf_level` (
  `levelID` int(11) NOT NULL,
  `title` text NOT NULL,
  `upgradePoint` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `nsf_level`
--

INSERT INTO `nsf_level` (`levelID`, `title`, `upgradePoint`) VALUES
(1, '限制會員', NULL),
(2, '新手上路', 15),
(3, '註冊會員', 100),
(4, '中級會員', 300),
(5, '高級會員', 800),
(6, '金牌會員', 1500),
(7, '論壇元老', NULL);

-- --------------------------------------------------------

--
-- 資料表結構 `nsf_lottery`
--

CREATE TABLE `nsf_lottery` (
  `lotteryID` int(11) NOT NULL,
  `topicID` int(11) NOT NULL,
  `setting` text NOT NULL,
  `executionTime` datetime NOT NULL,
  `memberID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `nsf_lottery`
--

INSERT INTO `nsf_lottery` (`lotteryID`, `topicID`, `setting`, `executionTime`, `memberID`) VALUES
(1, 86, '[["1","3"],["10","1"]]', '2019-05-29 16:55:41', 5),
(2, 31, '[["1","1","1"],["100","100","0"]]', '2019-08-24 19:14:37', 5),
(3, 34, '[["1","1"],["10","0"]]', '2019-08-24 19:16:08', 5),
(4, 116, '[["1","1","1"],["0","0","0"],["RTX2080","RTX2070","RTX2060"]]', '2019-09-04 19:04:00', 5);

-- --------------------------------------------------------

--
-- 資料表結構 `nsf_lottery_award`
--

CREATE TABLE `nsf_lottery_award` (
  `lotteryAwardID` int(11) NOT NULL,
  `lotteryID` int(11) NOT NULL,
  `memberID` int(11) NOT NULL,
  `points` int(11) NOT NULL,
  `coin` int(11) NOT NULL,
  `item` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `nsf_lottery_award`
--

INSERT INTO `nsf_lottery_award` (`lotteryAwardID`, `lotteryID`, `memberID`, `points`, `coin`, `item`) VALUES
(1, 1, 5, 0, 10, ''),
(2, 1, 1, 0, 1, ''),
(3, 1, 4, 0, 1, ''),
(4, 1, 2, 0, 1, ''),
(5, 3, 2, 0, 10, ''),
(6, 3, 1, 0, 0, ''),
(7, 4, 5, 0, 0, 'RTX2080');

-- --------------------------------------------------------

--
-- 資料表結構 `nsf_member`
--

CREATE TABLE `nsf_member` (
  `memberID` int(11) NOT NULL,
  `originalCustID` int(11) NOT NULL,
  `uid` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `verificationCode` varchar(32) DEFAULT NULL,
  `nickName` text NOT NULL,
  `avatar` text NOT NULL,
  `posts` int(11) NOT NULL DEFAULT '0',
  `replies` int(11) NOT NULL DEFAULT '0',
  `points` int(11) NOT NULL DEFAULT '0',
  `coin` int(11) NOT NULL DEFAULT '0',
  `level` int(11) NOT NULL DEFAULT '1',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `admin` tinyint(4) NOT NULL DEFAULT '0',
  `registerTime` datetime DEFAULT NULL,
  `lastLoginTime` datetime DEFAULT NULL,
  `lastPostTime` datetime DEFAULT NULL,
  `lastActivityTime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `nsf_member`
--

INSERT INTO `nsf_member` (`memberID`, `originalCustID`, `uid`, `verificationCode`, `nickName`, `avatar`, `posts`, `replies`, `points`, `coin`, `level`, `status`, `admin`, `registerTime`, `lastLoginTime`, `lastPostTime`, `lastActivityTime`) VALUES
(1, 1, '001', '00a', '吳小山', '5c9a721b065b9.png', 8, 64, 191, 192, 1, 1, 1, '2019-03-01 00:00:00', '2019-03-12 00:00:00', '2019-03-11 00:00:00', '2019-03-12 00:00:00'),
(2, 2, '002', '00b', '王小明', '', 1, 0, 1000, 10009, 6, 1, 0, '2019-03-02 00:00:00', '2019-03-07 00:00:00', '2019-03-07 00:00:00', '2019-03-08 00:00:00'),
(4, 3350593, 'H17Bn1tjFgowkJcrcda8KhmHugGn9gIB', 'ZGnhYpFbLHTcp2mFJNfBlhPlXog8cm5k', '', '5ce6c85fe8e80.png', 1, 1, 402, 24, 1, 1, 0, '2019-03-25 21:51:00', '2019-03-25 21:51:00', NULL, NULL),
(5, 3350595, 'Cwz4TMVp5BggFrCB5jCNLrgt2haQGEio', 'NHRaXBXFC75XvWLgw6wG44AjgKaZm9ou', '', '5cee43abb54cc.jpg', 15, 14, 41, 71, 2, 1, 1, '2019-05-27 14:07:12', '2019-05-27 14:07:12', NULL, NULL),
(6, 3350596, 'ZCQfyT46skPiyvvislgNPmOPUqDq8Kuc', '77lKnRFQvAZS95VFutIPdh4zN89jJq2M', '', '5d4ebdc19a9d1.png', 3, 1, 1503, 18, 6, 1, 0, '2019-06-18 23:17:35', '2019-06-18 23:17:35', NULL, NULL);

-- --------------------------------------------------------

--
-- 資料表結構 `nsf_moderator`
--

CREATE TABLE `nsf_moderator` (
  `moderatorID` int(11) NOT NULL,
  `categoryID` int(11) NOT NULL,
  `boardID` int(11) NOT NULL,
  `memberID` int(11) NOT NULL,
  `setTime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `nsf_moderator`
--

INSERT INTO `nsf_moderator` (`moderatorID`, `categoryID`, `boardID`, `memberID`, `setTime`) VALUES
(3, 4, 0, 2, '2019-03-30 21:36:59'),
(4, 4, 0, 4, '2019-03-30 21:36:59'),
(5, 1, 0, 1, '2019-03-30 21:56:05');

-- --------------------------------------------------------

--
-- 資料表結構 `nsf_point`
--

CREATE TABLE `nsf_point` (
  `pointID` int(11) NOT NULL,
  `memberID` int(11) NOT NULL,
  `action` varchar(50) NOT NULL,
  `point` int(11) NOT NULL,
  `changeTime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `nsf_point`
--

INSERT INTO `nsf_point` (`pointID`, `memberID`, `action`, `point`, `changeTime`) VALUES
(1, 1, 'post', 1, '2019-03-19 01:05:36'),
(2, 1, 'post', 1, '2019-03-19 01:10:09'),
(3, 1, 'reply', 2, '2019-03-19 01:10:38'),
(4, 1, 'reply', 2, '2019-03-19 01:10:55'),
(5, 1, 'reply', 2, '2019-03-19 01:11:04'),
(6, 1, 'reply', 2, '2019-03-19 01:11:12'),
(7, 1, 'reply', 2, '2019-03-19 01:11:23'),
(8, 1, 'post', 1, '2019-03-19 01:16:45'),
(9, 1, 'delReply', -1, '2019-03-20 00:39:36'),
(10, 1, 'delReply', -1, '2019-03-20 00:40:17'),
(11, 1, 'delReply', -1, '2019-03-20 00:40:17'),
(12, 1, 'delReply', -1, '2019-03-20 00:40:17'),
(13, 1, 'delReply', -1, '2019-03-20 00:40:28'),
(14, 1, 'delPost', -2, '2019-03-20 00:40:56'),
(15, 1, 'violation', -10, '2019-03-20 00:45:02'),
(16, 1, 'post', 1, '2019-03-20 01:06:04'),
(17, 1, 'reply', 2, '2019-03-27 02:44:36'),
(18, 1, 'post', 1, '2019-03-28 16:08:57'),
(19, 1, 'post', 1, '2019-03-28 16:09:21'),
(20, 4, 'post', 1, '2019-05-24 00:20:37'),
(21, 4, 'reply', 2, '2019-05-25 02:03:08'),
(22, 5, 'post', 1, '2019-05-27 14:07:46'),
(23, 5, 'post', 1, '2019-05-27 14:08:27'),
(24, 5, 'reply', 2, '2019-05-29 16:30:59'),
(25, 5, 'reply', 2, '2019-05-29 16:32:14'),
(26, 5, 'reply', 2, '2019-05-29 16:36:54'),
(27, 5, 'reply', 2, '2019-05-29 16:37:14'),
(28, 5, 'reply', 2, '2019-05-29 16:37:50'),
(29, 6, 'post', 1, '2019-06-18 23:17:47'),
(30, 5, 'reply', 2, '2019-06-18 23:48:02'),
(31, 5, 'post', 1, '2019-06-18 23:49:25'),
(32, 5, 'reply', 2, '2019-07-03 15:56:27'),
(33, 5, 'post', 1, '2019-07-03 16:15:35'),
(34, 5, 'post', 1, '2019-07-03 16:20:03'),
(35, 5, 'post', 1, '2019-07-05 10:48:26'),
(36, 5, 'post', 1, '2019-07-10 18:01:00'),
(37, 5, 'reply', 2, '2019-07-10 18:07:11'),
(38, 5, 'reply', 2, '2019-07-10 18:07:59'),
(39, 5, 'reply', 2, '2019-07-10 18:36:10'),
(40, 5, 'reply', 2, '2019-07-10 18:38:57'),
(41, 5, 'reply', 2, '2019-07-10 18:54:02'),
(42, 6, 'post', 1, '2019-08-10 20:41:30'),
(43, 6, 'firstUpdateAvatar', 15, '2019-08-10 20:46:09'),
(44, 6, 'firstUpdateAvatar', 15, '2019-08-10 20:49:11'),
(45, 6, 'firstUpdateAvatar', 15, '2019-08-10 20:49:33'),
(46, 6, 'firstUpdateAvatar', 15, '2019-08-10 20:51:13'),
(47, 5, 'post', 1, '2019-08-10 21:35:18'),
(48, 5, 'post', 1, '2019-08-10 21:35:23'),
(49, 5, 'post', 1, '2019-08-10 21:56:54'),
(50, 5, 'post', 1, '2019-08-10 21:57:41'),
(51, 5, 'post', 1, '2019-08-10 22:05:35'),
(52, 5, 'reply', 2, '2019-08-10 22:10:26'),
(53, 2, 'adminAdjust', -599, '2019-08-24 18:58:03'),
(54, 2, 'adminAdjust', -5400, '2019-08-24 19:04:30'),
(55, 2, 'adminAdjust', 5940, '2019-08-24 19:04:47'),
(56, 2, 'adminAdjust', 940, '2019-08-24 19:08:39'),
(57, 6, 'adminAdjust', 1485, '2019-09-04 18:51:27'),
(58, 5, 'post', 1, '2019-09-13 01:25:14'),
(59, 5, 'post', 1, '2019-09-13 01:25:23'),
(60, 5, 'post', 1, '2019-09-13 01:25:32'),
(61, 6, 'post', 1, '2019-09-22 01:27:10'),
(62, 6, 'reply', 2, '2019-09-22 01:28:27');

-- --------------------------------------------------------

--
-- 資料表結構 `nsf_review`
--

CREATE TABLE `nsf_review` (
  `reviewID` int(11) NOT NULL,
  `topicID` int(11) NOT NULL,
  `memberID` int(11) NOT NULL,
  `review` tinyint(4) NOT NULL,
  `reviewTime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `nsf_review`
--

INSERT INTO `nsf_review` (`reviewID`, `topicID`, `memberID`, `review`, `reviewTime`) VALUES
(3, 31, 1, 1, '2019-03-23 04:18:33');

-- --------------------------------------------------------

--
-- 資料表結構 `nsf_search`
--

CREATE TABLE `nsf_search` (
  `searchID` int(11) NOT NULL,
  `searchstr` varchar(200) NOT NULL,
  `count` int(11) NOT NULL DEFAULT '0',
  `lastSearchTime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `nsf_search`
--

INSERT INTO `nsf_search` (`searchID`, `searchstr`, `count`, `lastSearchTime`) VALUES
(1, 'ASUS', 2, '2019-07-03 16:31:48'),
(2, '123', 1, '2019-07-03 16:05:36'),
(3, '1', 1, '2019-07-03 16:31:41'),
(4, '2', 1, '2019-07-03 16:31:44');

-- --------------------------------------------------------

--
-- 資料表結構 `nsf_topic`
--

CREATE TABLE `nsf_topic` (
  `topicID` int(11) NOT NULL,
  `boardID` int(11) DEFAULT NULL,
  `reply` tinyint(4) NOT NULL DEFAULT '0',
  `subjectID` int(11) DEFAULT NULL,
  `title` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `memberID` int(11) NOT NULL,
  `firstPost` tinyint(4) NOT NULL DEFAULT '0',
  `views` int(11) NOT NULL DEFAULT '0',
  `replies` int(11) NOT NULL DEFAULT '0',
  `awesome` int(11) NOT NULL DEFAULT '0',
  `trample` int(11) NOT NULL DEFAULT '0',
  `top` tinyint(4) NOT NULL DEFAULT '0',
  `del` tinyint(4) NOT NULL DEFAULT '0',
  `searchTitle` text,
  `searchContent` text,
  `postTime` datetime NOT NULL,
  `lastUpdateTime` datetime NOT NULL,
  `lastUpdateMemberID` int(11) DEFAULT NULL,
  `lastEditTime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `nsf_topic`
--

INSERT INTO `nsf_topic` (`topicID`, `boardID`, `reply`, `subjectID`, `title`, `content`, `memberID`, `firstPost`, `views`, `replies`, `awesome`, `trample`, `top`, `del`, `searchTitle`, `searchContent`, `postTime`, `lastUpdateTime`, `lastUpdateMemberID`, `lastEditTime`) VALUES
(1, 17, 0, NULL, '', '今天[size=6][font=Verdana]星期一[/font][/size]，[color=#44b8ff]我們[/color]去看[b]電影[/b]。\n電影名稱是"[u]Good day for you.[/u]"！', 1, 0, 0, 0, 0, 0, 0, 0, '', '今天 size=6 font=Verdana 星期一 font size ， color=#44b8ff 我們 color 去 看 b 電影 b 。 \n 電影 名稱 是 u Good day for you. u ！', '2019-03-05 03:00:35', '2019-03-05 03:00:35', 2, NULL),
(2, 17, 0, NULL, '', '今天[size=6][font=Verdana]星期一[/font][/size]，[color=#44b8ff]我們[/color]去看[b]電影[/b]。\n電影名稱是"[u]Good day for you.[/u]"！', 1, 0, 0, 0, 0, 0, 0, 0, '', '今天 size=6 font=Verdana 星期一 font size ， color=#44b8ff 我們 color 去 看 b 電影 b 。 \n 電影 名稱 是 u Good day for you. u ！', '2019-03-05 03:02:07', '2019-03-05 03:02:07', 2, NULL),
(3, 17, 0, NULL, '', '今天[size=6][font=Verdana]星期一[/font][/size]，[color=#44b8ff]我們[/color]去看[b]電影[/b]。\n電影名稱是"[u]Good day for you.[/u]"！\nhey!\n<qweqe>\n(1234)\n[qw4e56q4e]', 1, 0, 0, 0, 0, 0, 0, 0, '', '今天 size=6 font=Verdana 星期一 font size ， color=#44b8ff 我們 color 去 看 b 電影 b 。 \n 電影 名稱 是 u Good day for you. u ！ \nhey \n qweqe \n 1234 \n qw4e56q4e', '2019-03-05 03:02:30', '2019-03-05 03:02:30', 2, NULL),
(4, 17, 0, NULL, '', '今天[size=6][font=Verdana]星期一[/font][/size]，[color=#44b8ff]我們[/color]去看[b]電影[/b]。\n電影名稱是"[u]Good day for you.[/u]"！\nhey!\n<qweqe>\n(1234)\n[qw4e56q4e]', 1, 0, 0, 0, 0, 0, 0, 0, '', '今天 電影 名稱 是 hey 1234', '2019-03-05 03:05:06', '2019-03-05 03:05:06', 2, NULL),
(5, 17, 0, NULL, '', '今天[size=6][font=Verdana]星期一[/font][/size]，[color=#44b8ff]我們[/color]去看[b]電影[/b]。\n電影名稱是"[u]Good day for you.[/u]"！\nhey!\n<qweqe>\n(1234)\n[qw4e56q4e]', 1, 0, 0, 0, 0, 0, 0, 0, '', '今天 。 \n 電影 名稱 是 ！ \nhey \n\n 1234', '2019-03-05 03:06:28', '2019-03-05 03:06:28', 2, NULL),
(6, 17, 0, NULL, '', '今天。\n電影名稱是""！\nhey!\n\n(1234)', 1, 0, 0, 0, 0, 0, 0, 0, '', '今天 。 \n 電影 名稱 是 ！ \nhey \n\n 1234', '2019-03-05 03:07:03', '2019-03-05 03:07:03', 2, NULL),
(7, 17, 0, NULL, '', '今天[size=6][font=Verdana]星期一[/font][/size]，[color=#44b8ff]我們[/color]去看[b]電影[/b]。\n電影名稱是"[u]Good day for you.[/u]"！\nhey!\n<qweqe>\n(1234)\n[qw4e56q4e]', 1, 0, 0, 0, 0, 0, 0, 0, '', '今天 星期一 我們 去 看 電影 電影 名稱 是 Good day for you. hey qweqe 1234', '2019-03-05 03:10:37', '2019-03-05 03:10:37', 2, NULL),
(8, 17, 0, NULL, '', '今天[size=6][font=Verdana]星期一[/font][/size]，[color=#44b8ff]我們[/color]去看[b]電影[/b]。\n電影名稱是"[u]Good day for you.[/u]"！\nhey!\n<qweqe>\n(1234)\n[qw4e56q4e]', 1, 0, 0, 0, 0, 0, 0, 0, '', '今天 星期一 我們 去 看 電影 電影 名稱 是 Good day for you. hey qweqe 1234', '2019-03-05 03:11:04', '2019-03-05 03:11:04', 2, NULL),
(9, 17, 0, NULL, '', '今天[size=6][font=Verdana]星期一[/font][/size]，[color=#44b8ff]我們[/color]去看[b]電影[/b]。\n電影名稱是&quot;[u]Good day for you.[/u]&quot;！\nhey!\n&lt;qweqe&gt;\n(1234)\n[qw4e56q4e]', 1, 0, 0, 0, 0, 0, 0, 0, '', '今天 星期一 我們 去 看 電影 電影 名稱 是 &quot Good day for you.&quot hey &lt qweqe&gt 1234', '2019-03-05 03:16:29', '2019-03-05 03:16:29', 2, NULL),
(10, 17, 0, NULL, '', '今天[size=6][font=Verdana]星期一[/font][/size]，[color=#44b8ff]我們[/color]去看[b]電影[/b]。\n電影名稱是&quot;[u]Good day for you.[/u]&quot;！\nhey!\n&lt;qweqe&gt;\n(1234)\n[qw4e56q4e]', 1, 0, 0, 0, 0, 0, 0, 0, '', '今天 星期一 我們 去 看 電影 電影 名稱 是 &quot Good day for you.&quot hey &lt qweqe&gt 1234', '2019-03-05 03:17:42', '2019-03-05 03:17:42', 2, NULL),
(11, 17, 0, NULL, '', '今天[size=6][font=Verdana]星期一[/font][/size]，[color=#44b8ff]我們[/color]去看[b]電影[/b]。\n電影名稱是&quot;[u]Good day for you.[/u]&quot;！\nhey!\n\n(1234)\n[qw4e56q4e]\nalert(\'abc\');', 1, 0, 0, 0, 0, 0, 0, 0, '', '今天 星期一 我們 去 看 電影 電影 名稱 是 Good day for you. hey qweqe 1234 script alert abc script', '2019-03-05 03:19:01', '2019-03-05 03:19:01', 2, NULL),
(12, 17, 0, NULL, '', '今天要打開電腦時螢幕就不亮了\n怎麼辦?', 1, 0, 0, 0, 0, 0, 0, 0, '', '今天 要 打 開電腦 時 螢幕 就 不亮 了 怎麼 辦', '2019-03-05 15:50:26', '2019-03-05 15:50:26', 2, NULL),
(13, 17, 0, NULL, '', '今天要打開電腦時螢幕就不亮了\n怎麼辦?', 1, 0, 0, 0, 0, 0, 0, 0, '', '今天 要 打 開電腦 時 螢幕 就 不亮 了 怎麼 辦', '2019-02-28 15:53:48', '2019-02-28 15:53:48', 2, NULL),
(14, 7, 0, NULL, 'qweqe', '21321321', 1, 0, 0, 0, 0, 0, 0, 0, '', '21321321', '2019-03-05 15:54:04', '2019-03-05 15:54:04', 2, NULL),
(15, 6, 0, NULL, '電腦打不開 黑螢幕', '如題\n燈有亮但螢幕一直是黑的', 1, 0, 0, 0, 0, 0, 0, 0, '', '如題 燈 有亮 但 螢幕 一直 是 黑 的', '2019-03-05 15:54:52', '2019-03-05 15:54:52', 2, NULL),
(16, 17, 0, NULL, '1234', '&nbsp;', 1, 0, 0, 0, 0, 0, 0, 1, '', '', '2019-02-05 15:56:22', '2019-02-05 15:56:22', 2, NULL),
(17, 17, 0, NULL, '1234', '&nbsp;', 1, 0, 0, 0, 0, 0, 0, 1, '', '', '2019-03-05 15:57:20', '2019-03-05 15:57:20', 2, NULL),
(18, 17, 0, NULL, '1234', '&nbsp;', 1, 0, 0, 0, 0, 0, 0, 1, '', '', '2019-03-05 15:59:31', '2019-03-05 15:59:31', 2, NULL),
(19, 17, 0, NULL, '  a', '&nbsp;', 1, 0, 0, 0, 0, 0, 0, 0, '', '', '2019-03-05 16:00:11', '2019-03-05 16:00:11', 2, NULL),
(20, 4, 0, NULL, 'aaa', 'bbb', 1, 0, 2, 1, 0, 0, 0, 0, '', 'bbb', '2019-03-05 16:47:10', '2019-03-13 16:55:52', 2, NULL),
(21, 6, 0, NULL, '1234', 'qweq', 1, 0, 0, 0, 0, 0, 0, 0, '', 'qweq', '2019-03-05 16:48:49', '2019-03-05 16:48:49', 2, NULL),
(22, 7, 0, NULL, 'apple', 'apple', 1, 0, 0, 0, 0, 0, 0, 0, '', 'apple', '2019-03-05 16:50:33', '2019-03-05 16:50:33', 2, NULL),
(23, 5, 0, NULL, '組裝', '[b]組裝組裝組裝組裝組裝[/b]\n[b][b][color=#111111][size=2][font=Verdana, Arial, Helvetica, sans-serif]組裝組裝組裝組裝組裝[/font][/size][/color][/b][/b]\n[b][b][color=#111111][size=2][font=Verdana, Arial, Helvetica, sans-serif][b][color=#111111][size=2][font=Verdana, Arial, Helvetica, sans-serif]組裝組裝組裝組裝組裝[/font][/size][/color][/b][/font][/size][/color][/b][/b]\n[b][b][color=#111111][size=2][font=Verdana, Arial, Helvetica, sans-serif][b][color=#111111][size=2][font=Verdana, Arial, Helvetica, sans-serif][b][color=#111111][size=2][font=Verdana, Arial, Helvetica, sans-serif]組裝組裝組裝組裝組裝[/font][/size][/color][/b][/font][/size][/color][/b][/font][/size][/color][/b][/b]\n[b][b][color=#111111][size=2][font=Verdana, Arial, Helvetica, sans-serif][b][color=#111111][size=2][font=Verdana, Arial, Helvetica, sans-serif][b][color=#111111][size=2][font=Verdana, Arial, Helvetica, sans-serif][b][color=#111111][size=2][font=Verdana, Arial, Helvetica, sans-serif]組裝組裝組裝組裝組裝[/font][/size][/color][/b][/font][/size][/color][/b][/font][/size][/color][/b][/font][/size][/color][/b][/b]\n[b][b][color=#111111][size=2][font=Verdana, Arial, Helvetica, sans-serif][b][color=#111111][size=2][font=Verdana, Arial, Helvetica, sans-serif][b][color=#111111][size=2][font=Verdana, Arial, Helvetica, sans-serif][b][color=#111111][size=2][font=Verdana, Arial, Helvetica, sans-serif][b][color=#111111][size=2][font=Verdana, Arial, Helvetica, sans-serif]組裝組裝組裝組裝組裝[/font][/size][/color][/b][/font][/size][/color][/b][/font][/size][/color][/b][/font][/size][/color][/b][/font][/size][/color][/b][/b]\n[b][b][color=#111111][size=2][font=Verdana, Arial, Helvetica, sans-serif][b][color=#111111][size=2][font=Verdana, Arial, Helvetica, sans-serif][b][color=#111111][size=2][font=Verdana, Arial, Helvetica, sans-serif][b][color=#111111][size=2][font=Verdana, Arial, Helvetica, sans-serif][b][color=#111111][size=2][font=Verdana, Arial, Helvetica, sans-serif][b][color=#111111][size=2][font=Verdana, Arial, Helvetica, sans-serif]組裝組裝組裝組裝組裝[/font][/size][/color][/b][/font][/size][/color][/b][/font][/size][/color][/b][/font][/size][/color][/b][/font][/size][/color][/b][/font][/size][/color][/b][/b]', 1, 0, 0, 0, 0, 0, 0, 0, '', '組裝 組裝 組裝 組裝 組裝 組裝 組裝 組裝 組裝 組裝 組裝 組裝 組裝 組裝 組裝 組裝 組裝 組裝 組裝 組裝 組裝 組裝 組裝 組裝 組裝 組裝 組裝 組裝 組裝 組裝 組裝 組裝 組裝 組裝 組裝', '2019-03-05 16:51:11', '2019-03-05 16:51:11', 2, NULL),
(24, 17, 0, NULL, 'q1232131', '12', 1, 0, 0, 0, 0, 0, 0, 0, '', '12', '2019-03-05 16:55:13', '2019-03-05 16:55:13', 2, NULL),
(25, 4, 0, NULL, 'qqq', 'qqq', 1, 0, 1, 0, 0, 0, 0, 0, '', 'qqq', '2019-03-05 17:01:04', '2019-03-05 17:01:04', 2, NULL),
(26, 17, 0, NULL, '0814', '0814', 1, 0, 0, 0, 0, 0, 0, 0, '', '0814', '2019-03-05 20:14:11', '2019-03-05 20:14:11', 2, NULL),
(27, 7, 0, NULL, '7897', '&nbsp;&nbsp;', 1, 0, 0, 0, 0, 0, 0, 0, '', '', '2019-03-05 20:21:07', '2019-03-05 20:21:07', 2, NULL),
(28, 17, 0, NULL, '1', '2', 1, 0, 0, 0, 0, 0, 0, 0, '', '2', '2019-03-06 16:23:44', '2019-03-06 16:23:44', 2, NULL),
(29, 5, 0, NULL, '請問', '今天天氣如何？', 1, 0, 0, 0, 0, 0, 0, 0, '', '今天 天氣 如何', '2019-03-06 16:24:30', '2019-03-06 16:24:30', 2, NULL),
(30, 17, 0, NULL, '想組預算40k左右的電腦，請達人幫看有什麼可做調整的', '[size=3][color=#44b8ff][font=&quot;.SFNSText-Regular&quot;, &quot;.PingFang-TC-Regular&quot;, &quot;PingFang TC&quot;, Helvetica, Verdana, 新細明體, PMingLiU, sans-serif][b]大概6月中的時候會組一台預算40k的電腦[/b][/font][/color][/size]\n[color=#000000][size=3][font=&quot;.SFNSText-Regular&quot;, &quot;.PingFang-TC-Regular&quot;, &quot;PingFang TC&quot;, Helvetica, Verdana, 新細明體, PMingLiU, sans-serif]希望能頂個5年以上，未來以增加、汰換壞掉零件為主[/font][/size][/color]\n[color=#000000][size=3][font=&quot;.SFNSText-Regular&quot;, &quot;.PingFang-TC-Regular&quot;, &quot;PingFang TC&quot;, Helvetica, Verdana, 新細明體, PMingLiU, sans-serif]平常使用玩遊戲(單機、線上都有)、看影片居多，偶爾會修照片(Lightroom、Photoshop)、做影片(Premiere、AE)跟開實況[/font][/size][/color]\n[color=#000000][size=3][font=&quot;.SFNSText-Regular&quot;, &quot;.PingFang-TC-Regular&quot;, &quot;PingFang TC&quot;, Helvetica, Verdana, 新細明體, PMingLiU, sans-serif]因為想再搭一顆螢幕，所以想依選出來的菜單為主[/font][/size][/color]\n[color=#000000][size=3][font=&quot;.SFNSText-Regular&quot;, &quot;.PingFang-TC-Regular&quot;, &quot;PingFang TC&quot;, Helvetica, Verdana, 新細明體, PMingLiU, sans-serif]在不讓效能落差太多的情況下壓低金額[/font][/size][/color]\n\n[img]https://attach.mobile01.com/attach/201903/mobile01-d1d91888709cd5ae83648a0b363bccf0.jpg[/img]\n\n[color=#000000][size=3][font=&quot;.SFNSText-Regular&quot;, &quot;.PingFang-TC-Regular&quot;, &quot;PingFang TC&quot;, Helvetica, Verdana, 新細明體, PMingLiU, sans-serif]上面是目前我配出來的菜單[/font][/size][/color]\n[color=#000000][size=3][font=&quot;.SFNSText-Regular&quot;, &quot;.PingFang-TC-Regular&quot;, &quot;PingFang TC&quot;, Helvetica, Verdana, 新細明體, PMingLiU, sans-serif]這幾天在考慮的點大概是[/font][/size][/color]\n[i][b][color=#000000][size=3][font=&quot;.SFNSText-Regular&quot;, &quot;.PingFang-TC-Regular&quot;, &quot;PingFang TC&quot;, Helvetica, Verdana, 新細明體, PMingLiU, sans-serif]CPU：i7 8700(溫度比較高?)、R7 2700(核心數較多，但聽說比起intel容易出狀況)、i5-9400f(比較便宜，執行續較少)[/font][/size][/color][/b][/i]\n[color=#000000][size=3][font=&quot;.SFNSText-Regular&quot;, &quot;.PingFang-TC-Regular&quot;, &quot;PingFang TC&quot;, Helvetica, Verdana, 新細明體, PMingLiU, sans-serif][i][b]顯卡：RTX 2060(效能較好)、GTX1660ti(便宜很多)[/b][/i][/font][/size][/color]\n[color=#000000][size=3][font=&quot;.SFNSText-Regular&quot;, &quot;.PingFang-TC-Regular&quot;, &quot;PingFang TC&quot;, Helvetica, Verdana, 新細明體, PMingLiU, sans-serif]以上有錯請糾正XD[/font][/size][/color]\n\n[color=#cccccc][size=3][font=&quot;.SFNSText-Regular&quot;, &quot;.PingFang-TC-Regular&quot;, &quot;PingFang TC&quot;, Helvetica, Verdana, 新細明體, PMingLiU, sans-serif]另外如果菜單內有CP值更高的選擇也可以推薦給小弟[/font][/size][/color]\n[size=3][color=#cccccc][font=&quot;.SFNSText-Regular&quot;, &quot;.PingFang-TC-Regular&quot;, &quot;PingFang TC&quot;, Helvetica, Verdana, 新細明體, PMingLiU, sans-serif]感謝各位~[/font][/color][/size]\n\n\n', 1, 0, 8, 4, 0, 0, 0, 1, '', '大概 6 月 中 的 時候 會組 一台 預算 40k 的 電腦 希望 能 頂個 5 年 以上 未來 以 增加 、 汰 換壞 掉 零件 為主 平常 使用 玩遊戲 單機 、 線上 都 有 、 看 影片 居多 偶爾會 修 照片 Lightroom 、 Photoshop 、 做 影片 Premiere 、 AE 跟 開實況 因為 想 再 搭 一顆 螢幕 所以 想 依選出 來 的 菜 單為 主在 不 讓 效能 落差 太多 的 情況 下壓 低金額 https attach.mobile01.com attach 201903 mobile01 d1d91888709cd5ae83648a0b363bccf0.jpg 上面 是 目前 我配 出來 的 菜單 這幾天 在 考慮 的點 大概 是 CPU ： i7 8700 溫度 比 較 高 、 R7 2700 核心 數較 多 但 聽 說 比起 intel 容易 出狀況 、 i5 9400f 比較 便宜 執行續 較 少 顯卡 ： RTX 2060 效能 較 好 、 GTX1660ti 便宜 很多 以上 有錯 請 糾正 XD 另外 如果 菜 單內 有 CP 值 更 高 的 選擇 也 可以 推薦給 小弟 感謝 各位', '2019-03-07 20:11:01', '2019-03-16 22:12:35', 1, NULL),
(31, 5, 0, NULL, '想組預算40k左右的電腦，請達人幫看有什麼可做調整的', '[color=#1e92f7][size=3][font=".SFNSText-Regular", ".PingFang-TC-Regular", "PingFang TC", Helvetica, Verdana, 新細明體, PMingLiU, sans-serif]大概6月中的時候會組一台預算40k的電腦[/font][/size][/color]\n[color=#1e92f7][size=3][font=".SFNSText-Regular", ".PingFang-TC-Regular", "PingFang TC", Helvetica, Verdana, 新細明體, PMingLiU, sans-serif]希望能頂個5年以上，未來以增加、汰換壞掉零件為主[/font][/size][/color]\n[color=#1e92f7][size=3][font=".SFNSText-Regular", ".PingFang-TC-Regular", "PingFang TC", Helvetica, Verdana, 新細明體, PMingLiU, sans-serif]平常使用玩遊戲(單機、線上都有)、看影片居多，偶爾會修照片(Lightroom、Photoshop)、做影片(Premiere、AE)跟開實況[/font][/size][/color]\n[color=#1e92f7][size=3][font=".SFNSText-Regular", ".PingFang-TC-Regular", "PingFang TC", Helvetica, Verdana, 新細明體, PMingLiU, sans-serif]因為想再搭一顆螢幕，所以想依選出來的菜單為主[/font][/size][/color]\n[color=#1e92f7][size=3][font=".SFNSText-Regular", ".PingFang-TC-Regular", "PingFang TC", Helvetica, Verdana, 新細明體, PMingLiU, sans-serif]在不讓效能落差太多的情況下壓低金額[/font][/size][/color]\n\n[img]https://attach.mobile01.com/attach/201903/mobile01-d1d91888709cd5ae83648a0b363bccf0.jpg[/img]\n\n[color=#000000][size=3][font=".SFNSText-Regular", ".PingFang-TC-Regular", "PingFang TC", Helvetica, Verdana, 新細明體, PMingLiU, sans-serif]上面是目前我配出來的菜單[/font][/size][/color]\n[color=#000000][size=3][font=".SFNSText-Regular", ".PingFang-TC-Regular", "PingFang TC", Helvetica, Verdana, 新細明體, PMingLiU, sans-serif]這幾天在考慮的點大概是[/font][/size][/color]\n[b][i][u][color=#000000][size=3][font=".SFNSText-Regular", ".PingFang-TC-Regular", "PingFang TC", Helvetica, Verdana, 新細明體, PMingLiU, sans-serif]CPU：i7 8700(溫度比較高?)、R7 2700(核心數較多，但聽說比起intel容易出狀況)、i5-9400f(比較便宜，執行續較少)[/font][/size][/color][/u][/i][/b]\n[color=#000000][size=3][font=".SFNSText-Regular", ".PingFang-TC-Regular", "PingFang TC", Helvetica, Verdana, 新細明體, PMingLiU, sans-serif][b][i][u]顯卡：RTX 2060(效能較好)、GTX1660ti(便宜很多)[/u][/i][/b][/font][/size][/color]\n[color=#000000][size=3][font=".SFNSText-Regular", ".PingFang-TC-Regular", "PingFang TC", Helvetica, Verdana, 新細明體, PMingLiU, sans-serif]以上有錯請糾正XD[/font][/size][/color]\n\n[color=#000000][size=3][font=".SFNSText-Regular", ".PingFang-TC-Regular", "PingFang TC", Helvetica, Verdana, 新細明體, PMingLiU, sans-serif]另外如果菜單內有CP值更高的選擇也可以推薦給小弟[/font][/size][/color]\n[color=#000000][size=3][font=".SFNSText-Regular", ".PingFang-TC-Regular", "PingFang TC", Helvetica, Verdana, 新細明體, PMingLiU, sans-serif]感謝各位~[/font][/size][/color]\n\n\n', 1, 0, 74, 3, 17, 2, 1, 0, '想組 預算 40k 左右 的 電腦 ， 請達 人 幫 看 有 什麼 可 做 調整 的', '大概 6 月 中 的 時候 會組 一台 預算 40k 的 電腦 希望 能 頂個 5 年 以上 未來 以 增加 、 汰 換壞 掉 零件 為主 平常 使用 玩遊戲 單機 、 線上 都 有 、 看 影片 居多 偶爾會 修 照片 Lightroom 、 Photoshop 、 做 影片 Premiere 、 AE 跟 開實況 因為 想 再 搭 一顆 螢幕 所以 想 依選出 來 的 菜 單為 主在 不 讓 效能 落差 太多 的 情況 下壓 低金額 https attach.mobile01.com attach 201903 mobile01 d1d91888709cd5ae83648a0b363bccf0.jpg 上面 是 目前 我配 出來 的 菜單 這幾天 在 考慮 的點 大概 是 CPU ： i7 8700 溫度 比 較 高 、 R7 2700 核心 數較 多 但 聽 說 比起 intel 容易 出狀況 、 i5 9400f 比較 便宜 執行續 較 少 顯卡 ： RTX 2060 效能 較 好 、 GTX1660ti 便宜 很多 以上 有錯 請 糾正 XD 另外 如果 菜 單內 有 CP 值 更 高 的 選擇 也 可以 推薦給 小弟 感謝 各位', '2019-03-07 20:18:44', '2019-03-07 20:18:44', 2, NULL),
(32, 5, 0, NULL, '預算25000 達人請進', '[b][color=#17b529][font=Verdana]你好 [/font][/color][/b]\n目前只挑選好CPU 主機板 那想請問其他的該怎麼挑選比較適合? 附上的兩張圖 是在原價屋 欣亞 所看到的優惠組合價格 主要需求是模擬器四開 預算在25000以下 謝謝\n[img]https://attach.mobile01.com/attach/201903/mobile01-b3ddbe1277d55e6a146858cd1919fbf8.png[/img]', 1, 0, 1, 3, 0, 0, 0, 0, '預算 25000 達人 請 進', '你好 目前 只 挑選好 CPU 主機板 那想 請問 其他 的 該 怎麼 挑選 比較 適合 附上 的 兩 張圖 是 在 原價屋 欣亞 所 看到 的 優惠 組合 價格 主要 需求 是 模擬器 四開 預算 在 25000 以下 謝謝 https attach.mobile01.com attach 201903 mobile01 b3ddbe1277d55e6a146858cd1919fbf8.png', '2019-03-07 20:24:10', '2019-03-16 22:32:11', 1, NULL),
(33, 17, 0, NULL, 'test', '[youtube]3cgMGHC_e6U[/youtube]', 1, 0, 1, 1, 0, 0, 0, 1, 'test', '3cgMGHC_e6U', '2019-03-07 20:26:57', '2019-03-07 20:26:57', 2, NULL),
(34, 5, 0, NULL, '電腦主機板CPU記憶體顯示卡硬碟SSD喇叭電源供應器', '電腦主機板CPU記憶體顯示卡硬碟SSD喇叭電源供應器\nASUS EW2440\nEVGA RTX-2080 Black', 1, 0, 8, 2, 0, 0, 0, 0, '電腦 主機板 CPU 記憶體 顯示 卡 硬碟 SSD 喇叭 電源供 應器', '電腦 主機板 CPU 記憶體 顯示 卡 硬碟 SSD 喇叭 電源供 應器 ASUS EW2440EVGA RTX 2080 Black', '2019-03-07 20:47:18', '2019-03-16 22:34:00', 2, NULL),
(35, NULL, 1, 34, '', '買華碩就對了\n堅若磐石', 1, 0, 0, 0, 0, 0, 0, 0, NULL, '買華碩 就 對 了 堅若 磐石', '2019-03-08 13:55:42', '2019-03-08 13:55:42', 2, NULL),
(36, NULL, 1, 30, '', 'POWER換一顆好一點的啊\n[b][color=#ff4136]海盜船[/color][/b]如何?', 1, 0, 0, 0, 0, 0, 0, 0, NULL, 'POWER 換一顆 好 一點 的 啊 海盜 船 如何', '2019-03-08 13:57:22', '2019-03-08 13:57:22', 2, NULL),
(37, NULL, 1, 30, '', '好哦好哦\n1\n2\n3\n4\n5', 1, 0, 0, 0, 0, 0, 0, 0, NULL, '好 哦 好 哦 12345', '2019-03-08 13:57:39', '2019-03-08 13:57:39', 2, NULL),
(38, NULL, 1, 30, '', '151515151515151515151515151515', 1, 0, 0, 0, 0, 0, 0, 0, NULL, '151515151515151515151515151515', '2019-03-08 13:57:51', '2019-03-08 13:57:51', 2, NULL),
(39, NULL, 1, 33, '', 'cute', 1, 0, 0, 0, 0, 0, 0, 0, NULL, 'cute', '2019-03-08 14:49:47', '2019-03-08 14:49:47', 2, NULL),
(40, 17, 0, NULL, 'test123', '123123', 1, 0, 3, 3, 0, 0, 0, 1, 'test123', '123123', '2019-03-13 16:25:34', '2019-03-16 22:04:36', 1, NULL),
(41, NULL, 1, 40, '', 'qweqweqweqweqwewqe', 1, 0, 0, 0, 0, 0, 0, 0, NULL, 'qweqweqweqweqwewqe', '2019-03-13 16:25:59', '2019-03-13 16:25:59', 1, NULL),
(42, NULL, 1, 40, '', '12313213123', 2, 0, 0, 0, 0, 0, 0, 0, NULL, '12313213123', '2019-03-13 16:26:38', '2019-03-13 16:26:38', 2, NULL),
(43, 4, 0, NULL, '5555', '555', 2, 0, 3, 16, 0, 0, 0, 0, '5555', '555', '2019-03-13 16:37:58', '2019-03-14 19:22:50', 2, NULL),
(44, NULL, 1, 43, '', '6666', 2, 0, 0, 0, 0, 0, 0, 0, NULL, '6666', '2019-03-13 16:38:07', '2019-03-13 16:38:07', 2, NULL),
(45, NULL, 1, 43, '', '8888', 2, 0, 0, 0, 0, 0, 0, 0, NULL, '8888', '2019-03-13 16:42:17', '2019-03-13 16:42:17', 2, NULL),
(46, NULL, 1, 43, '', '8888', 2, 0, 0, 0, 0, 0, 0, 0, NULL, '8888', '2019-03-13 16:42:56', '2019-03-13 16:42:56', 2, NULL),
(47, NULL, 1, 43, '', '9', 2, 0, 0, 0, 0, 0, 0, 0, NULL, '9', '2019-03-13 16:45:35', '2019-03-13 16:45:35', 2, NULL),
(48, NULL, 1, 43, '', '10', 2, 0, 0, 0, 0, 0, 0, 0, NULL, '10', '2019-03-13 16:45:43', '2019-03-13 16:45:43', 2, NULL),
(49, NULL, 1, 43, '', '11', 2, 0, 0, 0, 0, 0, 0, 0, NULL, '11', '2019-03-13 16:45:52', '2019-03-13 16:45:52', 2, NULL),
(50, NULL, 1, 43, '', '12', 2, 0, 0, 0, 0, 0, 0, 0, NULL, '12', '2019-03-13 16:46:01', '2019-03-13 16:46:01', 2, NULL),
(51, NULL, 1, 43, '', '13', 2, 0, 0, 0, 0, 0, 0, 0, NULL, '13', '2019-03-13 16:46:10', '2019-03-13 16:46:10', 2, NULL),
(52, NULL, 1, 20, '', '1', 2, 0, 0, 0, 0, 0, 0, 0, NULL, '1', '2019-03-13 16:55:52', '2019-03-13 16:55:52', 2, NULL),
(53, NULL, 1, 43, '', 'a9', 2, 0, 0, 0, 0, 0, 0, 0, NULL, 'a9', '2019-03-13 16:59:30', '2019-03-13 16:59:30', 2, NULL),
(54, NULL, 1, 43, '', 'a10', 2, 0, 0, 0, 0, 0, 0, 0, NULL, 'a10', '2019-03-13 16:59:39', '2019-03-13 16:59:39', 2, NULL),
(55, NULL, 1, 43, '', 'a11', 2, 0, 0, 0, 0, 0, 0, 0, NULL, 'a11', '2019-03-13 16:59:47', '2019-03-13 16:59:47', 2, NULL),
(56, NULL, 1, 43, '', 'a12', 2, 0, 0, 0, 0, 0, 0, 0, NULL, 'a12', '2019-03-13 16:59:55', '2019-03-13 16:59:55', 2, NULL),
(57, NULL, 1, 43, '', '13', 2, 0, 0, 0, 0, 0, 0, 0, NULL, '13', '2019-03-13 17:06:39', '2019-03-13 17:06:39', 2, NULL),
(58, NULL, 1, 43, '', '14', 2, 0, 0, 0, 0, 0, 0, 0, NULL, '14', '2019-03-13 17:06:49', '2019-03-13 17:06:49', 2, NULL),
(59, NULL, 1, 43, '', '15', 2, 0, 0, 0, 0, 0, 0, 0, NULL, '15', '2019-03-13 17:07:00', '2019-03-13 17:07:00', 2, NULL),
(60, 16, 0, NULL, '青春美機', '青春美機', 2, 0, 3, 1, 0, 0, 0, 0, '青春 美機', '青春 美機', '2019-03-14 16:17:25', '2019-03-14 19:27:54', 2, NULL),
(61, NULL, 1, 43, '', 'hahaha', 2, 0, 0, 0, 0, 0, 0, 0, NULL, 'hahaha', '2019-03-14 19:22:50', '2019-03-14 19:22:50', 2, NULL),
(62, NULL, 1, 60, '', '[b][color=#e82a1f][size=7]讚[/size][/color][/b][color=#008e02][size=7]餒[/size][/color]', 2, 0, 0, 0, 0, 0, 0, 0, NULL, '讚 餒', '2019-03-14 19:27:54', '2019-03-14 19:27:54', 2, NULL),
(63, 17, 0, NULL, '垃圾場', '垃圾場', 1, 0, 0, 0, 0, 0, 0, 0, '垃圾 場', '垃圾 場', '2019-03-16 21:58:49', '2019-03-16 21:58:49', 1, NULL),
(64, NULL, 1, 40, '', 'del1', 1, 0, 0, 0, 0, 0, 0, 0, NULL, 'del1', '2019-03-16 22:04:36', '2019-03-16 22:04:36', 1, NULL),
(65, NULL, 1, 30, '', 'aaaa', 1, 0, 0, 0, 0, 0, 0, 0, NULL, 'aaaa', '2019-03-16 22:12:35', '2019-03-16 22:12:35', 1, NULL),
(66, NULL, 1, 32, '', '1', 1, 0, 0, 0, 0, 0, 0, 1, NULL, '1', '2019-03-16 22:31:55', '2019-03-16 22:31:55', 1, NULL),
(67, NULL, 1, 32, '', '2', 1, 0, 0, 0, 0, 0, 0, 1, NULL, '2', '2019-03-16 22:32:03', '2019-03-16 22:32:03', 1, NULL),
(68, NULL, 1, 32, '', '3', 1, 0, 0, 0, 0, 0, 0, 0, NULL, '3', '2019-03-16 22:32:11', '2019-03-16 22:32:11', 1, NULL),
(69, NULL, 1, 34, '', '12313', 2, 0, 0, 0, 0, 0, 0, 0, NULL, '12313', '2019-03-16 22:34:00', '2019-03-16 22:34:00', 2, NULL),
(70, 5, 0, NULL, '新來的', '新來的', 1, 1, 0, 0, 0, 0, 0, 0, '新來 的', '新來 的', '2019-03-18 23:21:32', '2019-03-18 23:21:32', 1, NULL),
(71, 17, 0, NULL, 'first test 1', 'first test 1', 1, 1, 1, 0, 0, 0, 0, 1, 'first test 1', 'first test 1', '2019-03-18 23:30:01', '2019-03-18 23:30:01', 1, NULL),
(72, 5, 0, NULL, 'first test 2', 'first test 2', 1, 1, 1, 0, 0, 0, 0, 0, 'first test 2', 'first test 2', '2019-03-18 23:30:12', '2019-03-18 23:30:12', 1, NULL),
(73, 5, 0, NULL, 'test3', 'test3', 1, 1, 1, 0, 0, 0, 0, 0, 'test3', 'test3', '2019-03-18 23:31:24', '2019-03-18 23:31:24', 1, NULL),
(74, 5, 0, NULL, 'tes  4', 'test 4', 1, 0, 3, 0, 0, 0, 0, 0, 'tes 4', 'test 4', '2019-03-18 23:31:35', '2019-03-18 23:31:35', 1, NULL),
(75, 17, 0, NULL, 'DIY', 'DIY', 1, 0, 2, 6, 0, 0, 0, 1, 'DIY', 'DIY', '2019-03-19 01:05:36', '2019-03-19 01:11:36', 1, NULL),
(76, 17, 0, NULL, 'diy2', 'diy2', 1, 0, 1, 0, 0, 0, 0, 1, 'diy2', 'diy2', '2019-03-19 01:10:09', '2019-03-19 01:10:09', 1, NULL),
(77, NULL, 1, 75, '', '2132131213', 1, 0, 0, 0, 0, 0, 0, 0, NULL, '2132131213', '2019-03-19 01:10:38', '2019-03-19 01:10:38', 1, NULL),
(78, NULL, 1, 75, '', '123', 1, 0, 0, 0, 0, 0, 0, 1, NULL, '123', '2019-03-19 01:10:55', '2019-03-19 01:10:55', 1, NULL),
(79, NULL, 1, 75, '', '1', 1, 0, 0, 0, 0, 0, 0, 1, NULL, '1', '2019-03-19 01:11:04', '2019-03-19 01:11:04', 1, NULL),
(80, NULL, 1, 75, '', '4', 1, 0, 0, 0, 0, 0, 0, 1, NULL, '4', '2019-03-19 01:11:12', '2019-03-19 01:11:12', 1, NULL),
(81, NULL, 1, 75, '', '5', 1, 0, 0, 0, 0, 0, 0, 1, NULL, '5', '2019-03-19 01:11:23', '2019-03-19 01:11:23', 1, NULL),
(82, NULL, 1, 75, '', '6', 1, 0, 0, 0, 0, 0, 0, 1, NULL, '6', '2019-03-19 01:11:36', '2019-03-19 01:11:36', 1, NULL),
(83, 17, 0, NULL, 'diy 333', '333', 1, 0, 1, 0, 0, 0, 0, 1, 'diy 333', '333', '2019-03-19 01:16:45', '2019-03-19 01:16:45', 1, NULL),
(84, 5, 0, NULL, '想組預算40k左右的電腦，請達人幫看有什麼可做調整的edit', '[color=#1e92f7][size=3][font=".SFNSText-Regular", ".PingFang-TC-Regular", "PingFang TC", Helvetica, Verdana, 新細明體, PMingLiU, sans-serif]大概6月中的時候會組一台預算40k的電腦  edit[/font][/size][/color]\n[color=#1e92f7][size=3][font=".SFNSText-Regular", ".PingFang-TC-Regular", "PingFang TC", Helvetica, Verdana, 新細明體, PMingLiU, sans-serif]希望能頂個5年以上，未來以增加、汰換壞掉零件為主[/font][/size][/color]\n[color=#1e92f7][size=3][font=".SFNSText-Regular", ".PingFang-TC-Regular", "PingFang TC", Helvetica, Verdana, 新細明體, PMingLiU, sans-serif]平常使用玩遊戲(單機、線上都有)、看影片居多，偶爾會修照片(Lightroom、Photoshop)、做影片(Premiere、AE)跟開實況[/font][/size][/color]\n[color=#1e92f7][size=3][font=".SFNSText-Regular", ".PingFang-TC-Regular", "PingFang TC", Helvetica, Verdana, 新細明體, PMingLiU, sans-serif]因為想再搭一顆螢幕，所以想依選出來的菜單為主[/font][/size][/color]\n[color=#1e92f7][size=3][font=".SFNSText-Regular", ".PingFang-TC-Regular", "PingFang TC", Helvetica, Verdana, 新細明體, PMingLiU, sans-serif]在不讓效能落差太多的情況下壓低金額[/font][/size][/color]\n\n[img]https://attach.mobile01.com/attach/201903/mobile01-d1d91888709cd5ae83648a0b363bccf0.jpg[/img]\n\n[color=#000000][size=3][font=".SFNSText-Regular", ".PingFang-TC-Regular", "PingFang TC", Helvetica, Verdana, 新細明體, PMingLiU, sans-serif]上面是目前我配出來的菜單[/font][/size][/color]\n[color=#000000][size=3][font=".SFNSText-Regular", ".PingFang-TC-Regular", "PingFang TC", Helvetica, Verdana, 新細明體, PMingLiU, sans-serif]這幾天在考慮的點大概是[/font][/size][/color]\n[b][i][u][color=#000000][size=3][font=".SFNSText-Regular", ".PingFang-TC-Regular", "PingFang TC", Helvetica, Verdana, 新細明體, PMingLiU, sans-serif]CPU：i7 8700(溫度比較高?)、R7 2700(核心數較多，但聽說比起intel容易出狀況)、i5-9400f(比較便宜，執行續較少)[/font][/size][/color][/u][/i][/b]\n[color=#000000][size=3][font=".SFNSText-Regular", ".PingFang-TC-Regular", "PingFang TC", Helvetica, Verdana, 新細明體, PMingLiU, sans-serif][b][i][u]顯卡：RTX 2060(效能較好)、GTX1660ti(便宜很多)[/u][/i][/b][/font][/size][/color]\n[color=#000000][size=3][font=".SFNSText-Regular", ".PingFang-TC-Regular", "PingFang TC", Helvetica, Verdana, 新細明體, PMingLiU, sans-serif]以上有錯請糾正XD[/font][/size][/color]\n\n[color=#000000][size=3][font=".SFNSText-Regular", ".PingFang-TC-Regular", "PingFang TC", Helvetica, Verdana, 新細明體, PMingLiU, sans-serif]另外如果菜單內有CP值更高的選擇也可以推薦給小弟[/font][/size][/color]\n[color=#000000][size=3][font=".SFNSText-Regular", ".PingFang-TC-Regular", "PingFang TC", Helvetica, Verdana, 新細明體, PMingLiU, sans-serif]感謝各位~[/font][/size][/color]\n\n\n', 1, 0, 2, 1, 0, 0, 0, 0, '想組 預算 40k 左右 的 電腦 ， 請達 人 幫 看 有 什麼 可 做 調整 的 edit', '大概 6 月 中 的 時候 會組 一台 預算 40k 的 電腦 edit 希望 能 頂個 5 年 以上 未來 以 增加 、 汰 換壞 掉 零件 為主 平常 使用 玩遊戲 單機 、 線上 都 有 、 看 影片 居多 偶爾會 修 照片 Lightroom 、 Photoshop 、 做 影片 Premiere 、 AE 跟 開實況 因為 想 再 搭 一顆 螢幕 所以 想 依選出 來 的 菜 單為 主在 不 讓 效能 落差 太多 的 情況 下壓 低金額 https attach.mobile01.com attach 201903 mobile01 d1d91888709cd5ae83648a0b363bccf0.jpg 上面 是 目前 我配 出來 的 菜單 這幾天 在 考慮 的點 大概 是 CPU ： i7 8700 溫度 比 較 高 、 R7 2700 核心 數較 多 但 聽 說 比起 intel 容易 出狀況 、 i5 9400f 比較 便宜 執行續 較 少 顯卡 ： RTX 2060 效能 較 好 、 GTX1660ti 便宜 很多 以上 有錯 請 糾正 XD 另外 如果 菜 單內 有 CP 值 更 高 的 選擇 也 可以 推薦給 小弟 感謝 各位', '2019-03-20 01:06:04', '2019-03-27 02:44:35', 1, '2019-03-20 01:15:26'),
(85, NULL, 1, 84, '', '123', 1, 0, 0, 0, 0, 0, 0, 0, NULL, '123', '2019-03-27 02:44:35', '2019-03-27 02:44:35', 1, NULL),
(86, 9, 0, NULL, 'ASUS主機板好棒棒', 'ASUS主機板好棒棒', 1, 0, 6, 6, 0, 0, 0, 0, 'ASUS 主機板 好 棒棒', 'ASUS 主機板 好 棒棒', '2019-03-28 16:08:57', '2019-05-29 16:37:50', 5, NULL),
(87, 4, 0, NULL, '華碩ASUS筆電最讚', '華碩ASUS筆電最讚', 1, 0, 1, 0, 0, 0, 0, 0, '華碩 ASUS 筆電 最 讚', '華碩 ASUS 筆電 最 讚', '2019-03-28 16:09:21', '2019-03-28 16:09:21', 1, NULL),
(88, 13, 0, NULL, '1', '2', 4, 1, 1, 0, 0, 0, 0, 0, '1', '2', '2019-05-24 00:20:37', '2019-05-24 00:20:37', 4, NULL),
(89, NULL, 1, 86, '', 'good', 4, 0, 0, 0, 0, 0, 0, 0, NULL, 'good', '2019-05-25 02:03:08', '2019-05-25 02:03:08', 4, NULL),
(90, 16, 0, NULL, 'test', 'test', 5, 1, 1, 0, 0, 0, 0, 0, 'test', 'test', '2019-05-27 14:07:45', '2019-05-27 14:07:45', 5, NULL),
(91, 9, 0, NULL, 'test2', 'test2', 5, 0, 1, 0, 0, 0, 0, 0, 'test2', 'test2', '2019-05-27 14:08:26', '2019-05-27 14:08:26', 5, NULL),
(92, NULL, 1, 86, '', '123', 1, 0, 0, 0, 0, 0, 0, 0, NULL, '123', '2019-05-29 16:30:59', '2019-05-29 16:30:59', 5, NULL),
(93, NULL, 1, 86, '', '456', 2, 0, 0, 0, 0, 0, 0, 0, NULL, '456', '2019-05-29 16:32:14', '2019-05-29 16:32:14', 5, NULL),
(94, NULL, 1, 86, '', 'aaa', 5, 0, 0, 0, 0, 0, 0, 0, NULL, 'aaa', '2019-05-29 16:36:54', '2019-05-29 16:36:54', 5, NULL),
(95, NULL, 1, 86, '', 'qqq', 5, 0, 0, 0, 0, 0, 0, 0, NULL, 'qqq', '2019-05-29 16:37:14', '2019-05-29 16:37:14', 5, NULL),
(96, NULL, 1, 86, '', 'qqqq', 5, 0, 0, 0, 0, 0, 0, 0, NULL, 'qqqq', '2019-05-29 16:37:50', '2019-05-29 16:37:50', 5, NULL),
(97, 9, 0, NULL, 'test2', 'test3', 6, 1, 3, 1, 0, 0, 0, 0, 'test2', 'test3', '2019-06-18 23:17:47', '2019-06-18 23:48:02', 5, NULL),
(98, NULL, 1, 97, '', 'qeqwewqe', 5, 0, 0, 0, 0, 0, 0, 0, NULL, 'qeqwewqe', '2019-06-18 23:48:02', '2019-06-18 23:48:02', 5, NULL),
(99, 9, 0, NULL, 'qqqqqqqqqqqq', 'aaaaaaaaaaaaaa', 5, 0, 3, 1, 0, 0, 0, 0, 'qqqqqqqqqqqq', 'aaaaaaaaaaaaaa', '2019-06-18 23:49:25', '2019-07-03 15:56:27', 5, NULL),
(100, NULL, 1, 99, '', '123', 5, 0, 0, 0, 0, 0, 0, 0, NULL, '123', '2019-07-03 15:56:27', '2019-07-03 15:56:27', 5, NULL),
(101, 16, 0, NULL, '[欣亞公告] 欣亞的待客之道-給你五欣級的服務', '\n[table][tr][td][table][tr][td][color=#444444][size=2][font=微軟正黑體][size=2][color=black][font=Verdana][size=2][img=600x277]https://forum.sinya.com.tw/data/attachment/forum/201903/14/095825btq2k2d2ykttqs32.jpg[/img] [/size][/font]\n[font=Verdana][size=2]這幾年我們為了給廣大的粉絲朋友更好的購買環境，在欣亞排排購的頁面我們也是不斷的做精進[/size][/font][font=Verdana][size=2]，讓大家可以在線上購買時更為方便。[/size][/font]\n[font=Verdana][size=2]也爭取了不管是在門市或者是排排購上全館六期零利率的優惠。[/size][/font][/color]\n\n[/size][/font][/size][/color]\n[left][color=#444444][size=2][font=微軟正黑體][size=2][font=Verdana][color=black][size=2]為了讓大家更喜歡在欣亞的購物感受[/size][/color][/font][/size][/font][/size][/color][/left]\n[color=#444444][size=2][font=微軟正黑體][size=2][font=Verdana][size=2][color=black]，給予五欣級的服務，[/color][/size][/font]\n[color=red][font=Verdana][size=2][b][b]當你們進到門市時聽到門市人員親切的與你們呼喊歡迎光臨[/b][/b][/size][/font]\n[font=Verdana][size=2][b][b]面帶微笑以及熱情、友善的服務態度接洽[/b][/b][/size][/font][/color][color=black]\n\n\n\n\n[font=Verdana][size=2]購買後我們將會用mail的方式給您一份滿意度調查，再請您不吝嗇的將您的意見反應給我們[/size][/font]\n[font=Verdana][size=2]如對我們的服務有疑慮或建議，也歡迎加入欣亞LINE@由相關人員服務您[/size][/font]\n[font=Verdana][size=2]對於您們寶貴的意見我們都會虛心接受並改善[/size][/font]\n[color=blue][font=Verdana][size=2][url=https://line.me/R/ti/p/%40wyf2547l][color=#336699][u][b][b]點我加入欣亞LINE@[/b][/b][/u][/color][/url][/size][/font]\n[font=Verdana][size=2]或是掃描QR CODE就可以加入我們喔![/size][/font][/color]\n[font=Verdana][size=2][img]https://forum.sinya.com.tw/data/attachment/forum/201903/14/102503vsosb7mygwg28wpp.png[/img] [/size][/font]\n[/color][/size][/font][/size][/color][/td]\n[/tr]\n[/table]\n\n[/td]\n[/tr]\n[tr][td][center][color=#444444][size=2][font=微軟正黑體][url=https://forum.sinya.com.tw/home.php?mod=spacecp&ac=favorite&type=thread&id=4321&formhash=4b4c398d][color=#333333][i][img]https://forum.sinya.com.tw/static/image/common/fav.gif[/img]收藏[/i][/color][/url][/font][/size][/color][/center]\n[/td]\n[/tr]\n[/table]\n\n', 5, 0, 1, 0, 0, 0, 0, 0, '欣亞 公告 欣亞 的 待客之道 給你五欣級 的 服務', 'https forum.sinya.com.tw data attachment forum 201903 14 095825btq2k2d2ykttqs32.jpg 這幾年 我們 為 了 給廣大 的 粉絲 朋友 更好 的 購買 環境 在 欣亞 排排 購 的 頁 面 我們 也 是 不斷 的 做 精進 讓 大家 可以 在 線 上 購買時 更 為 方便 也 爭取 了 不管 是 在 門市 或者 是 排排 購上 全館 六期 零利率 的 優惠為 了 讓 大家 更 喜歡 在 欣亞 的 購物 感受 給予 五欣級 的 服務當 你 們 進到 門市 時 聽 到 門市 人員 親切 的 與 你 們 呼喊 歡迎光 臨面 帶 微笑 以及 熱情 、 友善 的 服務態度 接洽 購買 後 我們 將會用 mail 的 方式 給 您 一份 滿意度 調查 再 請 您 不吝 嗇 的將 您 的 意見 反應給 我們 如 對 我們 的 服務有 疑慮 或 建議 也 歡迎 加入 欣亞 LINE 由 相關 人員 服務 您 對 於 您 們 寶貴 的 意見 我們 都 會 虛心 接受 並 改善 點我 加入 欣亞 LINE 或是 掃描 QR CODE 就 可以 加入 我們 喔 https forum.sinya.com.tw data attachment forum 201903 14 102503vsosb7mygwg28wpp.png https forum.sinya.com.tw static image common fav.gif 收藏', '2019-07-03 16:15:35', '2019-07-03 16:15:35', 5, NULL),
(102, 16, 0, NULL, '2', '\n[table][tr][td][color=#444444][size=2][font=微軟正黑體][size=2][color=black][font=Verdana][size=2][img=600x277]https://forum.sinya.com.tw/data/attachment/forum/201903/14/095825btq2k2d2ykttqs32.jpg[/img] [/size][/font][/color]\n[size=1][font=Tahoma, Helvetica, sans-serif][b][b]欣亞五欣級待客之道_王牌.jpg[/b][/b] [i][color=#666666](882.01 KB, 下載次數: 0)[/color][/i]\n[url=https://forum.sinya.com.tw/forum.php?mod=attachment&aid=MTk5ODZ8ZWIwYjVmMmN8MTU2MjE0MTcwMXwwfDQzMjE%3D&nothumb=yes][color=#336699][u]下載附件[/u][/color][/url]\n[color=#999999]2019-3-14 09:58 上傳[/color][/font][/size]\n\n[color=black]\n[font=Verdana][size=2]這幾年我們為了給廣大的粉絲朋友更好的購買環境，在欣亞排排購的頁面我們也是不斷的做精進[/size][/font][font=Verdana][size=2]，讓大家可以在線上購買時更為方便。[/size][/font]\n[font=Verdana][size=2]也爭取了不管是在門市或者是排排購上全館六期零利率的優惠。[/size][/font][/color]\n\n[/size][/font][/size][/color]\n[left][color=#444444][size=2][font=微軟正黑體][size=2][font=Verdana][color=black][size=2]為了讓大家更喜歡在欣亞的購物感受[/size][/color][/font][/size][/font][/size][/color][/left]\n[color=#444444][size=2][font=微軟正黑體][size=2][font=Verdana][size=2][color=black]，給予五欣級的服務，[/color][/size][/font]\n[color=red][font=Verdana][size=2][b][b]當你們進到門市時聽到門市人員親切的與你們呼喊歡迎光臨[/b][/b][/size][/font]\n[font=Verdana][size=2][b][b]面帶微笑以及熱情、友善的服務態度接洽[/b][/b][/size][/font][/color][color=black]\n\n\n\n\n[font=Verdana][size=2]購買後我們將會用mail的方式給您一份滿意度調查，再請您不吝嗇的將您的意見反應給我們[/size][/font]\n[font=Verdana][size=2]如對我們的服務有疑慮或建議，也歡迎加入欣亞LINE@由相關人員服務您[/size][/font]\n[font=Verdana][size=2]對於您們寶貴的意見我們都會虛心接受並改善[/size][/font]\n[color=blue][font=Verdana][size=2][url=https://line.me/R/ti/p/%40wyf2547l][color=#336699][u][b][b]點我加入欣亞LINE@[/b][/b][/u][/color][/url][/size][/font]\n[font=Verdana][size=2]或是掃描QR CODE就可以加入我們喔![/size][/font][/color]\n[font=Verdana][size=2][img]https://forum.sinya.com.tw/data/attachment/forum/201903/14/102503vsosb7mygwg28wpp.png[/img] [/size][/font][/color][/size][/font][/size][/color][/td]\n[/tr]\n[/table]\n\n', 5, 0, 1, 0, 0, 0, 0, 0, '2', 'https forum.sinya.com.tw data attachment forum 201903 14 095825btq2k2d2ykttqs32.jpg 欣亞 五欣級 待客之道 _ 王牌 .jpg 882.01 KB 下載 次數 0 下載 附件 2019 3 14 09 58 上傳 這幾年 我們 為 了 給廣大 的 粉絲 朋友 更好 的 購買 環境 在 欣亞 排排 購 的 頁 面 我們 也 是 不斷 的 做 精進 讓 大家 可以 在 線 上 購買時 更 為 方便 也 爭取 了 不管 是 在 門市 或者 是 排排 購上 全館 六期 零利率 的 優惠為 了 讓 大家 更 喜歡 在 欣亞 的 購物 感受 給予 五欣級 的 服務當 你 們 進到 門市 時 聽 到 門市 人員 親切 的 與 你 們 呼喊 歡迎光 臨面 帶 微笑 以及 熱情 、 友善 的 服務態度 接洽 購買 後 我們 將會用 mail 的 方式 給 您 一份 滿意度 調查 再 請 您 不吝 嗇 的將 您 的 意見 反應給 我們 如 對 我們 的 服務有 疑慮 或 建議 也 歡迎 加入 欣亞 LINE 由 相關 人員 服務 您 對 於 您 們 寶貴 的 意見 我們 都 會 虛心 接受 並 改善 點我 加入 欣亞 LINE 或是 掃描 QR CODE 就 可以 加入 我們 喔 https forum.sinya.com.tw data attachment forum 201903 14 102503vsosb7mygwg28wpp.png', '2019-07-03 16:20:03', '2019-07-03 16:20:03', 5, NULL),
(103, 9, 0, NULL, 'test222', 'test2222', 5, 0, 2, 0, 0, 0, 0, 0, 'test222', 'test2222', '2019-07-05 10:48:25', '2019-07-05 10:48:25', 5, '2019-07-05 10:50:29'),
(104, 16, 0, NULL, 'Google', '[url=www.google.com]Google[/url]\n[color=#ffa339]TITLE[/color]\n', 5, 0, 1, 6, 0, 0, 0, 0, 'Google', 'GoogleTITLE', '2019-07-10 18:01:00', '2019-07-10 18:56:54', 5, NULL),
(105, NULL, 1, 104, '', '[url=tw.yahoo.com]Yahoo[/url]', 5, 0, 0, 0, 0, 0, 0, 0, NULL, 'Yahoo', '2019-07-10 18:07:11', '2019-07-10 18:07:11', 5, NULL),
(106, NULL, 1, 104, '', '[url=http://tw.yahoo.com]YA[/url]', 5, 0, 0, 0, 0, 0, 0, 0, NULL, 'YA', '2019-07-10 18:07:59', '2019-07-10 18:07:59', 5, NULL),
(107, NULL, 1, 104, '', '[color=#000000][size=2][font=微軟正黑體][font=Verdana][size=2][img=600x277]https://forum.sinya.com.tw/data/attachment/forum/201905/24/133959i4t8cgqw2zb81ln1.jpg[/img] [/size][/font][/font][/size][/color]\n[size=2][font=微軟正黑體][size=1][font=Tahoma, Helvetica, sans-serif][b][b]欣亞快換中心TOSHIBA-王牌.jpg[/b][/b] [i][color=#666666](62.75 KB, 下載次數: 0)[/color][/i]\n[url=https://forum.sinya.com.tw/forum.php?mod=attachment&aid=MjA0Njh8MzAzM2U3MGR8MTU2Mjc1NDk0OHwwfDQ1NDc%3D&nothumb=yes][color=#336699][u]下載附件[/u][/color][/url]\n[color=#999999]2019-5-24 13:39 上傳[/color][/font][/size]\n[/font][/size]\n[color=#000000][size=2][font=微軟正黑體][font=Verdana][size=2]\n只要您購買的TOSHIBA東芝3.5吋內接式硬碟在保固期內非人為故障都可以到欣亞來做硬碟快換服務，但因TOSHIBA東芝硬碟仿冒品事件關係，前來快換的朋友需要攜帶有相片之身分證件以便查驗，若不便出示證件則只能以代收送的方式送回代理商做售後服務。\nTOSHIBA仿冒品警告聲明[/size][/font][font=Verdana][size=2]：[/size][/font][/font][/size][/color][font=Verdana][color=#444444][size=2][size=2][url=https://reurl.cc/e7bKb][color=#336699][u]https://reurl.cc/e7bKb[/u][/color][/url][/size][/size][/color][/font]\n\n[left][color=#444444][size=2][font=微軟正黑體][font=Verdana][size=2][color=#ff0000][b][b]※欣亞上架的TOSHIBA東芝3.5吋硬碟均為原廠公司貨，請安心購買※[/b][/b][/color][/size][/font][/font][/size][/color][/left]\n[font=Verdana][color=#444444][size=2][size=3][color=#000000]前往[/color][color=#000000]▸[/color][url=https://www.sinya.com.tw/search/?search_category=1&keyword=TOSHIBA][color=#336699][u][u][b][b][color=#008000]欣亞TOSHIBA東芝3.5吋硬碟專區 安心選購[/color][/b][/b][/u][/u][/color][/url][/size]\n\n\n[color=#000000][size=2][img=600x277]https://forum.sinya.com.tw/data/attachment/forum/201905/24/134354adidhij50keycduc.jpg[/img] [/size][/color]\n[color=#0000ff][size=2][b][b]欣亞巨蟒SSD[/b][/b][b][b]快換[/b][/b][/size][/color][b][b][color=#0000ff]服務流程說明：[/color]\n[/b][/b][/size][/color][/font]\n\n[color=#444444][size=2][size=2][color=#000000]STEP.1 備份您所有的重要資料：請先行備份重要資料，服務中心不提供安裝軟體、複製資料等動作。[/color][/size][/size][/color]\n\n[color=#444444][size=2][size=2][color=#000000]STEP.2 送快換中心：攜帶維修品至全省欣亞門市做快換、代收服務，工程師判斷型號、外觀是否異常並查保固期。[/color][/size][/size][/color]\n\n[color=#444444][size=2][size=2][color=#000000]STEP.3 更換新品：無特殊狀況直接更換新品，若有缺貨則以同系列或相近型號替換(同容量，同介面)。[/color][/size][/size][/color]\n\n[color=#444444][size=2][size=2][color=#000000]STEP.4 異常送回：若外觀異常或過保固期則走正常維修流程，後送回巨蟒ANACOMDA客服部。[/color][/size][/size][/color]\n[font=Verdana][color=#444444][size=2]\n[b][b][color=#0000ff]欣亞巨蟒SSD快換注意事項 :[/color]\n[/b][/b][/size][/color][/font]\n\n[color=#444444][size=2][size=2][color=#000000]1.快換中心僅提供SSD系列產品換貨，行動硬碟系列僅做代收服務。[/color][/size][/size][/color]\n\n[color=#444444][size=2][size=2][color=#000000]2.每個據點備品數量有限，換修前請先與各欣亞門市預約確認，若需批量換貨請洽ANACOMDA巨蟒官網線上申請。[/color][/size][/size][/color]\n\n[color=#444444][size=2][size=2][color=#000000]3.送修品須符合產品有限責任保固聲明之適用範圍，產品有限責任保固聲明請見ANACOMDA巨蟒官網說明。[/color][/size][/size][/color]\n\n[color=#444444][size=2][size=2][color=#000000]4.快換中心僅提供消費者至現場換修，若無法現場送修者請透過官網線上維修申請。[/color][/size][/size][/color]\n\n[color=#444444][size=2][size=2][color=#000000]5.若送修產品為限量款，因產品數量有限，ANACOMDA巨蟒將更換普通版本。[/color][/size][/size][/color]\n\n[color=#444444][size=2][size=2][color=#000000]6.若送修產品為停產款，ANACOMDA巨蟒將已同等級或更高等級的產品替代之。[/color][/size][/size][/color]\n\n[color=#444444][size=2][size=2][color=#000000]7.若送修產品無法現場提供快換，快換中心將協助消費者做代收服務。[/color][/size][/size][/color]\n\n\n[color=#444444][size=2][size=3][color=#000000]前往[/color][color=#000000]▸[/color][url=https://www.sinya.com.tw/show/105?sort=price&order=ASC&keyword=%E5%B7%A8%E8%9F%92][color=#336699][u][u][b][b][color=#008000]欣亞巨蟒SSD專區[/color][/b][/b][/u][/u][/color][/url][/size][/size][/color]\n[font=Verdana][color=#444444][size=2][color=#000000][size=2]\n\n\n\n[img]https://forum.sinya.com.tw/data/attachment/forum/201905/24/134630ddfz6zlo0u3u0nlr.jpg[/img] [/size][/color]\n[/size][/color][/font]\n[left][color=#444444][size=2][font=微軟正黑體][font=Verdana][size=2][color=black]即日起欣亞售出的be quiet! 電源供應器即享有二年欣亞快換服務[/color][/size][/font][/font][/size][/color][/left]\n[left][color=#444444][size=2][font=微軟正黑體][size=2][font=Verdana][color=#0000ff][b][b]欣亞[/b][/b][b][b]be quiet! 電源供應器[/b][/b][b][b]快[/b][/b][b][b]換[/b][/b][b][b]服務流程說明：[/b][/b][/color][/font][/size][/font][/size][/color][/left]\n[left][color=#444444][size=2][font=微軟正黑體][size=2][font=Verdana][color=black]STEP.1 確認商品購買日期是否在二年內購買：認發票/會員購買資料/欣亞商品保貼 擇其一即可[/color][/font][/size][/font][/size][/color][/left]\n[left][color=#444444][size=2][font=微軟正黑體][size=2][font=Verdana][color=black]STEP.2 檢查產品外觀有無人損或拆過痕跡 (線材破損、線材線頭燒毀溶解、防拆標籤毀損、螺絲滑牙或有拆過痕跡、外觀凹陷、邊角碰撞痕跡[/color][/font][/size][/font][/size][/color][/left]\n[left][color=#444444][size=2][font=微軟正黑體][size=2][font=Verdana][color=black]STEP.3 檢測後非人損直接換新品，若該門市若無庫存或缺貨、停產則代送廠商處理[/color][/font][/size][/font][/size][/color][/left]\n[left][color=#444444][size=2][font=微軟正黑體][color=#0000ff][font=Verdana][size=2][b][b]欣亞[/b][/b][b][b]be quiet! 電源供應器[/b][/b][b][b]快換注意事項 :[/b][/b][/size][/font][/color][/font][/size][/color][/left]\n[left][color=#444444][size=2][font=微軟正黑體][font=Verdana][size=2][color=black]以下情況不涵蓋在快換服務中，一律走代送修流程[/color][/size][/font][/font][/size][/color][/left]\n[left][color=#444444][size=2][font=微軟正黑體][font=Verdana][size=2][color=#000000]1．無原廠保固貼紙、欣亞保固貼紙[/color][/size][/font][/font][/size][/color][/left]\n[left][color=#444444][size=2][font=微軟正黑體][font=Verdana][size=2][color=black]2．電源供應器本身保貼毀損（有自行拆機改裝痕跡）\n3．電源供應器上的序號遺失或辨識不清\n4．外觀明顯損傷（撞凹、變形、刮痕）\n5．人為因素造成的損傷及線材配件遺失（包含線材/接頭斷裂...等）\n6．電源測試後無不良情況[/color][/size][/font][/font][/size][/color][/left]\n[color=#444444][size=2][font=微軟正黑體][font=Verdana][size=3][color=#000000]前往▸[/color][url=https://www.sinya.com.tw/show/9?sort=price&order=ASC&keyword=be%20quiet][color=#336699][u][color=#008000][b][b][u]欣亞be quiet! 電源供應器[/u][/b][/b][b][b][u]專區[/u][/b][/b][/color][/u][/color][/url][/size][/font][/font][/size][/color]\n\n', 5, 0, 0, 0, 0, 0, 0, 0, NULL, 'https forum.sinya.com.tw data attachment forum 201905 24 133959i4t8cgqw2zb81ln1.jpg 欣亞 快換 中心 TOSHIBA 王牌 .jpg 62.75 KB 下載 次數 0 下載 附件 2019 5 24 13 39 上傳 只要 您 購買 的 TOSHIBA 東芝 3.5 吋 內 接式 硬碟 在 保固期 內 非人 為 故障 都 可以 到 欣亞來 做 硬碟 快換 服務 但 因 TOSHIBA 東芝 硬碟 仿冒品 事件 關 係 前來 快換 的 朋友 需要 攜帶 有 相片 之 身分 證件 以便 查驗 若 不便 出示 證件則 只能 以 代收 送 的 方式 送回 代理商 做售 後 服務 TOSHIBA 仿冒品 警告 聲明 ： https reurl.cc e7bKb 欣亞 上架 的 TOSHIBA 東芝 3.5 吋 硬碟 均 為 原廠 公司 貨請 安心 購買 前往 欣亞 TOSHIBA 東芝 3.5 吋 硬碟 專區 安心 選購 https forum.sinya.com.tw data attachment forum 201905 24 134354adidhij50keycduc.jpg 欣亞 巨蟒 SSD 快換 服務 流程 說明 ： STEP.1 備份 您 所有 的 重要 資料 ： 請 先行 備份 重要 資料 服務 中心 不 提供 安裝 軟體 、 複 製 資 料 等 動 作 STEP.2 送 快換 中心 ： 攜帶 維修品 至 全省 欣亞門市 做 快換 、 代 收服 務 工程 師判斷 型號 、 外觀 是否 異常 並查 保固期 STEP.3 更換 新品 ： 無 特殊 狀況 直接 更換 新品 若有 缺貨則 以同 系列 或 相近 型號 替換 同 容量 同 介面 STEP.4 異常 送回 ： 若外 觀異常 或過 保固期 則走 正常 維修 流程 後 送回 巨蟒 ANACOMDA 客服部 欣亞 巨蟒 SSD 快換 注意 事項 1. 快換 中心 僅 提供 SSD 系列 產品 換貨 行動 硬碟 系列 僅做代 收服 務 2. 每個 據點 備品 數量 有限 換修前 請 先 與 各欣亞門市 預約 確認 若需 批量 換貨 請洽 ANACOMDA 巨蟒 官網線 上 申請 3. 送修 品須 符合 產品 有限 責任 保固 聲明 之 適用 範圍 產品 有限 責任 保固 聲明 請 見 ANACOMDA 巨蟒 官網 說明 4. 快換 中心 僅 提供 消費者 至 現場 換修 若 無法 現場 送修 者 請 透過 官 網線 上維修 申請 5. 若 送修 產品 為 限量 款 因產品 數量 有限 ANACOMDA 巨蟒 將更換 普通 版本 6. 若 送修 產品 為 停產款 ANACOMDA 巨蟒 將已 同等 級 或 更 高等 級 的 產品 替代 之 7. 若 送修 產品 無法 現場 提供 快換 快換 中心 將協助 消費者 做代 收服 務 前往 欣亞 巨蟒 SSD 專區 https forum.sinya.com.tw data attachment forum 201905 24 134630ddfz6zlo0u3u0nlr.jpg 即日起 欣亞 售出 的 be quiet 電源供 應器 即 享有 二年 欣亞 快換 服務欣亞 be quiet 電源供 應器 快換 服務 流程 說明 ： STEP.1 確認 商品 購買 日期 是否 在 二年 內購 買 ： 認發票 會員購 買 資料 欣亞 商品 保貼 擇 其一 即可 STEP.2 檢查 產品 外觀 有 無人損 或 拆過 痕跡 線材 破損 、 線材 線頭 燒毀 溶解 、 防拆標 籤 毀損 、 螺絲 滑牙 或 有 拆過 痕跡 、 外觀 凹陷 、 邊角 碰撞 痕跡 STEP.3 檢測 後 非人 損 直接 換 新品 若該 門市 若 無庫存 或缺 貨 、 停產則 代送 廠 商處 理欣亞 be quiet 電源供 應器 快換 注意 事項 以下 情況 不涵 蓋 在 快換 服務中 一律 走代 送修 流程 1 無原廠 保固 貼紙 、 欣亞 保固 貼紙 2 電源供 應器 本身 保貼 毀損 （ 有 自行 拆機 改裝 痕跡 ） 3 電源供 應器 上 的 序號 遺失 或 辨識 不清 4 外觀 明顯 損傷 （ 撞 凹 、 變形 、 刮痕 ） 5 人為 因素 造成 的 損傷 及線材 配件 遺失 （ 包含 線材 接頭 斷裂 ... 等 ） 6 電源 測試 後 無 不良 情況 前往 欣亞 be quiet 電源供 應器 專區', '2019-07-10 18:36:10', '2019-07-10 18:36:10', 5, NULL),
(108, NULL, 1, 104, '', '[url=http://www.sinya.com.tw]一[b][i][color=#b3d5f4]二三[size=7]四五[/size]六七[/color][/i][/b]八[/url]', 5, 0, 0, 0, 0, 0, 0, 0, NULL, '一二三四五 六 七八', '2019-07-10 18:38:57', '2019-07-10 18:38:57', 5, NULL),
(109, NULL, 1, 104, '', '[url=https://www.sinya.com.tw][img=400x185]https://forum.sinya.com.tw/data/attachment/forum/201905/24/134354adidhij50keycduc.jpg[/img][/url]', 5, 0, 0, 0, 0, 0, 0, 0, NULL, 'https forum.sinya.com.tw data attachment forum 201905 24 134354adidhij50keycduc.jpg', '2019-07-10 18:54:02', '2019-07-10 18:54:02', 5, NULL),
(110, NULL, 1, 104, '', '[url=http://www.google.com.tw]GOOGLe[/url]', 5, 0, 0, 0, 0, 0, 0, 0, NULL, 'GOOGLe', '2019-07-10 18:56:54', '2019-07-10 18:56:54', 5, NULL),
(111, 9, 0, NULL, '0841', '0841', 6, 0, 0, 0, 0, 0, 0, 0, '0841', '0841', '2019-08-10 20:41:30', '2019-08-10 20:41:30', 6, NULL),
(112, 9, 0, NULL, '123131', 'qweqwe', 5, 0, 0, 0, 0, 0, 0, 0, '123131', 'qweqwe', '2019-08-10 21:35:18', '2019-08-10 21:35:18', 5, NULL),
(113, 9, 0, NULL, '123131', 'qweqweqwe', 5, 0, 1, 0, 0, 0, 0, 0, '123131', 'qweqweqwe', '2019-08-10 21:35:23', '2019-08-10 21:35:23', 5, NULL),
(114, 9, 0, NULL, 'test', '1234567\nabcd\nqwe', 5, 0, 0, 0, 0, 0, 0, 0, 'test', '1234567abcdqwe', '2019-08-10 21:56:54', '2019-08-10 21:56:54', 5, NULL),
(115, 10, 0, NULL, 'test2', 'testsetsetsest2', 5, 0, 0, 0, 0, 0, 0, 0, 'test2', 'testsetsetsest2', '2019-08-10 21:57:41', '2019-08-10 21:57:41', 5, NULL),
(116, 9, 0, NULL, 'test', '1234567\nabcd\nqwe\nHTML5', 5, 0, 2, 1, 0, 0, 0, 0, 'test', '1234567abcdqweHTML5', '2019-08-10 22:05:35', '2019-08-10 22:10:26', 5, NULL),
(117, NULL, 1, 116, '', 'HTML6', 5, 0, 0, 0, 0, 0, 0, 0, NULL, 'HTML6', '2019-08-10 22:10:26', '2019-08-10 22:10:26', 5, NULL),
(118, 5, 0, NULL, '123', '123', 5, 0, 0, 0, 0, 0, 0, 0, '123', '123', '2019-09-13 01:25:14', '2019-09-13 01:25:14', 5, NULL),
(119, 5, 0, NULL, 'acb', 'abc', 5, 0, 0, 0, 0, 0, 0, 0, 'acb', 'abc', '2019-09-13 01:25:23', '2019-09-13 01:25:23', 5, NULL),
(120, 5, 0, NULL, 'aaaaaa', 'qqqqqqqq', 5, 0, 0, 0, 0, 0, 0, 0, 'aaaaaa', 'qqqqqqqq', '2019-09-13 01:25:32', '2019-09-13 01:25:32', 5, NULL),
(121, 9, 0, NULL, 'test', '[img]http://localhost/sinyaforum/upload/attachment/2019/5d865c7a620028548.png[/img][img]http://localhost/sinyaforum/uploads/2019/5d865b72b1ecf3499.png[/img]\n', 6, 0, 1, 1, 0, 0, 0, 0, 'test', 'http localhost sinyaforum upload attachment 2019 5d865c7a620028548.pnghttp localhost sinyaforum uploads 2019 5d865b72b1ecf3499.png', '2019-09-22 01:27:09', '2019-09-22 01:28:27', 6, NULL),
(122, NULL, 1, 121, '', '[img]http://localhost/sinyaforum/upload/attachment/2019/5d865db395bcd2665.png[/img]', 6, 0, 0, 0, 0, 0, 0, 0, NULL, 'http localhost sinyaforum upload attachment 2019 5d865db395bcd2665.png', '2019-09-22 01:28:27', '2019-09-22 01:28:27', 6, NULL);

-- --------------------------------------------------------

--
-- 資料表結構 `web_ci_sessions`
--

CREATE TABLE `web_ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(255) NOT NULL,
  `last_activity` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `user_data` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- 資料表的匯出資料 `web_ci_sessions`
--

INSERT INTO `web_ci_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('a75221ec71d2332314320a040ac252ab', '10.10.70.253', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36', 1553518572, 'a:3:{s:9:"user_data";s:0:"";s:8:"ad_close";i:1553519472;s:6:"Member";a:12:{s:7:"cust_id";s:7:"3350593";s:9:"cust_name";s:7:"吳崑*";s:8:"cmp_name";s:0:"";s:8:"camprice";s:1:"0";s:10:"owner_logo";N;s:10:"enterprise";s:1:"0";s:16:"enterprise_agree";s:1:"0";s:11:"web_account";s:22:"s88305109@yahoo.com.tw";s:6:"mobile";s:10:"09*2**2*8*";s:10:"mobile_enc";s:10:"0932992180";s:7:"another";s:7:"3350593";s:7:"card_id";s:10:"G201500028";}}');

--
-- 已匯出資料表的索引
--

--
-- 資料表索引 `cust`
--
ALTER TABLE `cust`
  ADD PRIMARY KEY (`cust_id`) USING BTREE,
  ADD UNIQUE KEY `card_id` (`card_id`) USING BTREE,
  ADD UNIQUE KEY `account` (`account`) USING BTREE,
  ADD UNIQUE KEY `web_account` (`web_account`) USING BTREE,
  ADD KEY `mobile` (`mobile`) USING BTREE,
  ADD KEY `tel` (`tel`,`tel1`) USING BTREE,
  ADD KEY `name` (`name`) USING BTREE,
  ADD KEY `birth` (`birth`) USING BTREE,
  ADD KEY `invoice_id` (`invoice_id`) USING BTREE,
  ADD KEY `store_credit_date` (`store_credit_date`) USING BTREE,
  ADD KEY `fb_id` (`fb_id`) USING BTREE,
  ADD KEY `acc_day_id` (`acc_day_id`,`acc_pay_id`) USING BTREE,
  ADD KEY `build_date` (`build_date`) USING BTREE,
  ADD KEY `web_member` (`web_member`) USING BTREE,
  ADD KEY `campprice` (`camprice`) USING BTREE,
  ADD KEY `school` (`school`,`major`) USING BTREE,
  ADD KEY `enterprise` (`enterprise`) USING BTREE,
  ADD KEY `enterpprise` (`company`,`post`) USING BTREE,
  ADD KEY `acc_name` (`acc_name`) USING BTREE,
  ADD KEY `acc_name1` (`acc_name1`) USING BTREE,
  ADD KEY `concat_id` (`concat_id`) USING BTREE;

--
-- 資料表索引 `nsf_announcement`
--
ALTER TABLE `nsf_announcement`
  ADD PRIMARY KEY (`announcementID`),
  ADD KEY `status` (`status`),
  ADD KEY `startTime` (`startTime`,`endTime`);

--
-- 資料表索引 `nsf_banner`
--
ALTER TABLE `nsf_banner`
  ADD PRIMARY KEY (`bannerID`),
  ADD KEY `position` (`position`);

--
-- 資料表索引 `nsf_board`
--
ALTER TABLE `nsf_board`
  ADD PRIMARY KEY (`boardID`),
  ADD KEY `categoryID` (`categoryID`);

--
-- 資料表索引 `nsf_category`
--
ALTER TABLE `nsf_category`
  ADD PRIMARY KEY (`categoryID`);

--
-- 資料表索引 `nsf_collection`
--
ALTER TABLE `nsf_collection`
  ADD PRIMARY KEY (`collectionID`),
  ADD KEY `memberID` (`memberID`);

--
-- 資料表索引 `nsf_draft`
--
ALTER TABLE `nsf_draft`
  ADD PRIMARY KEY (`draftID`),
  ADD KEY `boardID` (`boardID`),
  ADD KEY `subjectID` (`subjectID`);

--
-- 資料表索引 `nsf_history`
--
ALTER TABLE `nsf_history`
  ADD PRIMARY KEY (`historyID`),
  ADD KEY `topicID` (`topicID`),
  ADD KEY `memberID` (`memberID`);

--
-- 資料表索引 `nsf_level`
--
ALTER TABLE `nsf_level`
  ADD PRIMARY KEY (`levelID`);

--
-- 資料表索引 `nsf_lottery`
--
ALTER TABLE `nsf_lottery`
  ADD PRIMARY KEY (`lotteryID`),
  ADD KEY `topicID` (`topicID`);

--
-- 資料表索引 `nsf_lottery_award`
--
ALTER TABLE `nsf_lottery_award`
  ADD PRIMARY KEY (`lotteryAwardID`),
  ADD KEY `lotteryID` (`lotteryID`),
  ADD KEY `memberID` (`memberID`);

--
-- 資料表索引 `nsf_member`
--
ALTER TABLE `nsf_member`
  ADD PRIMARY KEY (`memberID`),
  ADD KEY `originalMemberID` (`originalCustID`),
  ADD KEY `uid` (`uid`);

--
-- 資料表索引 `nsf_moderator`
--
ALTER TABLE `nsf_moderator`
  ADD PRIMARY KEY (`moderatorID`),
  ADD KEY `boardID` (`boardID`),
  ADD KEY `memberID` (`memberID`),
  ADD KEY `categoryID` (`categoryID`);

--
-- 資料表索引 `nsf_point`
--
ALTER TABLE `nsf_point`
  ADD PRIMARY KEY (`pointID`),
  ADD KEY `memberID` (`memberID`),
  ADD KEY `action` (`action`),
  ADD KEY `changeTime` (`changeTime`);

--
-- 資料表索引 `nsf_review`
--
ALTER TABLE `nsf_review`
  ADD PRIMARY KEY (`reviewID`),
  ADD KEY `topicID` (`topicID`),
  ADD KEY `memberID` (`memberID`);

--
-- 資料表索引 `nsf_search`
--
ALTER TABLE `nsf_search`
  ADD PRIMARY KEY (`searchID`),
  ADD KEY `searchstr` (`searchstr`);

--
-- 資料表索引 `nsf_topic`
--
ALTER TABLE `nsf_topic`
  ADD PRIMARY KEY (`topicID`),
  ADD KEY `boardID` (`boardID`),
  ADD KEY `postTime` (`postTime`),
  ADD KEY `lastUpdateTime` (`lastUpdateTime`),
  ADD KEY `reply` (`reply`),
  ADD KEY `subjectID` (`subjectID`);
ALTER TABLE `nsf_topic` ADD FULLTEXT KEY `search` (`searchTitle`,`searchContent`);

--
-- 資料表索引 `web_ci_sessions`
--
ALTER TABLE `web_ci_sessions`
  ADD PRIMARY KEY (`session_id`) USING BTREE,
  ADD KEY `last_activity_idx` (`last_activity`) USING BTREE;

--
-- 在匯出的資料表使用 AUTO_INCREMENT
--

--
-- 使用資料表 AUTO_INCREMENT `cust`
--
ALTER TABLE `cust`
  MODIFY `cust_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '客戶ID', AUTO_INCREMENT=3350599;
--
-- 使用資料表 AUTO_INCREMENT `nsf_announcement`
--
ALTER TABLE `nsf_announcement`
  MODIFY `announcementID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- 使用資料表 AUTO_INCREMENT `nsf_banner`
--
ALTER TABLE `nsf_banner`
  MODIFY `bannerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- 使用資料表 AUTO_INCREMENT `nsf_board`
--
ALTER TABLE `nsf_board`
  MODIFY `boardID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- 使用資料表 AUTO_INCREMENT `nsf_category`
--
ALTER TABLE `nsf_category`
  MODIFY `categoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- 使用資料表 AUTO_INCREMENT `nsf_collection`
--
ALTER TABLE `nsf_collection`
  MODIFY `collectionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- 使用資料表 AUTO_INCREMENT `nsf_draft`
--
ALTER TABLE `nsf_draft`
  MODIFY `draftID` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用資料表 AUTO_INCREMENT `nsf_history`
--
ALTER TABLE `nsf_history`
  MODIFY `historyID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- 使用資料表 AUTO_INCREMENT `nsf_level`
--
ALTER TABLE `nsf_level`
  MODIFY `levelID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- 使用資料表 AUTO_INCREMENT `nsf_lottery`
--
ALTER TABLE `nsf_lottery`
  MODIFY `lotteryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- 使用資料表 AUTO_INCREMENT `nsf_lottery_award`
--
ALTER TABLE `nsf_lottery_award`
  MODIFY `lotteryAwardID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- 使用資料表 AUTO_INCREMENT `nsf_member`
--
ALTER TABLE `nsf_member`
  MODIFY `memberID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- 使用資料表 AUTO_INCREMENT `nsf_moderator`
--
ALTER TABLE `nsf_moderator`
  MODIFY `moderatorID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- 使用資料表 AUTO_INCREMENT `nsf_point`
--
ALTER TABLE `nsf_point`
  MODIFY `pointID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;
--
-- 使用資料表 AUTO_INCREMENT `nsf_review`
--
ALTER TABLE `nsf_review`
  MODIFY `reviewID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- 使用資料表 AUTO_INCREMENT `nsf_search`
--
ALTER TABLE `nsf_search`
  MODIFY `searchID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- 使用資料表 AUTO_INCREMENT `nsf_topic`
--
ALTER TABLE `nsf_topic`
  MODIFY `topicID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
