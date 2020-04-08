-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- 主机： 127.0.0.1
-- 生成日期： 2020-04-08 04:29:28
-- 服务器版本： 10.4.6-MariaDB
-- PHP 版本： 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `meme`
--

-- --------------------------------------------------------

--
-- 表的结构 `message`
--

CREATE TABLE `message` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp(),
  `event` text NOT NULL COMMENT '事件'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='消息';

-- --------------------------------------------------------

--
-- 表的结构 `open_account`
--

CREATE TABLE `open_account` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'id',
  `user` int(10) UNSIGNED NOT NULL,
  `platform` enum('QQ','weibo','douban') NOT NULL COMMENT '平台名称',
  `openid` char(128) NOT NULL DEFAULT '' COMMENT 'open id'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- 表的结构 `topic`
--

CREATE TABLE `topic` (
  `id` bigint(10) UNSIGNED NOT NULL,
  `origin` bigint(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '起源',
  `editor` int(10) UNSIGNED NOT NULL COMMENT '编辑者',
  `merge` bigint(4) NOT NULL DEFAULT 0 COMMENT '合并至',
  `title` text COLLATE utf8_unicode_ci NOT NULL COMMENT '标题',
  `text` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '内容',
  `time` datetime NOT NULL DEFAULT current_timestamp() COMMENT '最后被 touch 的时间',
  `hit` bigint(20) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `topic`
--

INSERT INTO `topic` (`id`, `origin`, `editor`, `merge`, `title`, `text`, `time`, `hit`) VALUES
(116, 0, 1, 0, 'c', 'dd', '2020-04-07 19:56:13', 0),
(117, 0, 1, 0, 'cc', 'zz', '2020-04-07 19:57:31', 0),
(118, 0, 1, 0, 'c', 'zz', '2020-04-07 20:04:26', 0),
(119, 0, 1, 0, '这是一个标题', '里面是内容', '2020-04-07 20:55:57', 0),
(120, 119, 1, 0, '这是一个标题', '里面是内容1', '2020-04-07 20:56:32', 0),
(121, 120, 1, 0, '这是一个标题', '里面是内容1\r\n换行', '2020-04-07 21:06:49', 0),
(122, 121, 1, 0, '这是一个标题', '里面是内容1\r\n*换行*', '2020-04-07 21:27:27', 0),
(123, 122, 1, 0, '这是一个标题', '里面是内容1\r\n*换\\*行*', '2020-04-07 21:28:48', 0),
(124, 123, 1, 0, '这是一个标题', '>里面是内容1\r\n*换\\*行*', '2020-04-07 21:31:01', 0),
(125, 124, 1, 126, '这是一个标题', '>里面是内容\r\n*换\\*行*', '2020-04-08 08:16:40', 0),
(126, 125, 1, 0, '这是一个标题', '>这里是内容\r\n*换\\*行*', '2020-04-08 08:17:28', 1),
(127, 0, 1, 0, 'a', 'bb', '2020-04-08 09:32:01', 128);

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE `user` (
  `id` bigint(10) UNSIGNED NOT NULL,
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL COMMENT '用户名',
  `message` mediumtext COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '用户的签名',
  `create_time` datetime NOT NULL DEFAULT current_timestamp() COMMENT '注册时间',
  `login_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `update_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `name`, `message`, `create_time`, `login_token`, `update_time`) VALUES
(1, 'xiaochi_test', NULL, '2020-04-07 00:00:00', NULL, '0000-00-00 00:00:00'),
(102, 'wxiaochi@qq.com', NULL, '2020-04-08 10:17:27', NULL, '2020-04-08 10:28:18');

--
-- 转储表的索引
--

--
-- 表的索引 `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user` (`user_id`);

--
-- 表的索引 `open_account`
--
ALTER TABLE `open_account`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`user`);

--
-- 表的索引 `topic`
--
ALTER TABLE `topic`
  ADD PRIMARY KEY (`id`),
  ADD KEY `origin` (`origin`),
  ADD KEY `merge` (`merge`),
  ADD KEY `hit` (`hit`);

--
-- 表的索引 `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `message`
--
ALTER TABLE `message`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `open_account`
--
ALTER TABLE `open_account`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=101;

--
-- 使用表AUTO_INCREMENT `topic`
--
ALTER TABLE `topic`
  MODIFY `id` bigint(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- 使用表AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `id` bigint(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
