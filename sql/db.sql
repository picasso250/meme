-- 创建数据库

CREATE DATABASE IF NOT EXISTS bbs CHARACTER SET UTF8 COLLATE utf8_general_ci;

USE bbs;

-- ----------------------------
-- Table structure for article
-- ----------------------------
DROP TABLE IF EXISTS `article`;
CREATE TABLE `article` (
  `id` int(11) NOT NULL,
  `text` text,
  `create_time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `last_editor` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 节点，最基本的单位（节点一旦创建，就不可更改，现在，也不能分裂了）
CREATE TABLE IF NOT EXISTS `node`
(
    `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `user` INT(10) UNSIGNED NOT NULL COMMENT '创建节点的用户',
    `text` TEXT NOT NULL COMMENT '内容', 
    `time` DATETIME NOT NULL COMMENT '发表时间',
    PRIMARY KEY(id)
) ENGINE=MyISAM;

-- 主题，将节点串起来的东西，分裂自上一个主题 -- todo 是否隐藏
CREATE TABLE IF NOT EXISTS `topic`
(
    `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `creator` INT(10) UNSIGNED NOT NULL COMMENT '编辑者',
    `title` TEXT NOT NULL COMMENT '标题', 
    `time` DATETIME NOT NULL COMMENT '最后被 touch 的时间',
    PRIMARY KEY(id)
) ENGINE=MyISAM;

-- ----------------------------
-- Table structure for reply
-- ----------------------------
DROP TABLE IF EXISTS `reply`;
CREATE TABLE `reply` (
  `id` int(11) NOT NULL,
  `text` text,
  `author` int(10) unsigned DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tiezi
-- ----------------------------
DROP TABLE IF EXISTS `tiezi`;
CREATE TABLE `tiezi` (
  `id` int(11) NOT NULL,
  `author` int(10) unsigned DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `text` text,
  `create_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 用户，
CREATE TABLE IF NOT EXISTS `user`
(
    `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` CHAR(20) NOT NULL COMMENT '用户名',
    `message` TEXT COMMENT '用户的签名',
    `create_time` DATETIME NOT NULL COMMENT '注册时间',
    `last_login_time` datetime DEFAULT NULL,
    `password` varchar(255) DEFAULT NULL,
    PRIMARY KEY(id)
) ENGINE=MyISAM;

-- 公共帐号
CREATE TABLE IF NOT EXISTS `open_account`
(
    `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
    `user` INT(10) UNSIGNED NOT NULL,
    `platform` ENUM('QQ', 'weibo', 'douban') NOT NULL COMMENT '平台名称', -- 如qq weibo等等
    `openid` CHAR(128) NOT NULL DEFAULT '' COMMENT 'open id', -- 平台open id
    PRIMARY KEY(id),
    FOREIGN KEY(`user`) REFERENCES `user`(id)
) ENGINE=MyISAM;
