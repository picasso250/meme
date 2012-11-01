-- 创建数据库

CREATE DATABASE IF NOT EXISTS bbs CHARACTER SET UTF8 COLLATE utf8_general_ci;

USE bbs;

-- 节点，最基本的单位（节点一旦创建，就不可更改，现在，也不能分裂了）
CREATE TABLE IF NOT EXISTS `node`
(
    `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `user` INT(10) UNSIGNED NOT NULL COMMENT '创建节点的用户',
    `text` TEXT NOT NULL COMMENT '内容', 
    `time` DATETIME NOT NULL COMMENT '发表时间',
    PRIMARY KEY(id)
) ENGINE=MyISAM AUTO_INCREMENT=101;

-- 主题，将节点串起来的东西，分裂自上一个主题 -- todo 是否隐藏
CREATE TABLE IF NOT EXISTS `topic`
(
    `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `origin` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '起源',
    `editor` INT(10) UNSIGNED NOT NULL COMMENT '编辑者',
    `is_leaf` TINYINT(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '编辑者',
    `title` TEXT NOT NULL COMMENT '标题', 
    `nodes` TEXT NOT NULL COMMENT '内容', 
    `time` DATETIME NOT NULL COMMENT '最后被 touch 的时间',
    PRIMARY KEY(id)
) ENGINE=MyISAM AUTO_INCREMENT=101;

-- 用户，
CREATE TABLE IF NOT EXISTS `user`
(
    `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` CHAR(20) NOT NULL COMMENT '用户名',
    `message` TEXT COMMENT '用户的签名',
    `create_time` DATETIME NOT NULL COMMENT '注册时间',
    PRIMARY KEY(id)
) ENGINE=MyISAM AUTO_INCREMENT=101;

-- 公共帐号
CREATE TABLE IF NOT EXISTS `open_account`
(
    `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
    `user` INT(10) UNSIGNED NOT NULL,
    `platform` ENUM('QQ', 'weibo', 'douban') NOT NULL COMMENT '平台名称', -- 如qq weibo等等
    `openid` CHAR(128) NOT NULL DEFAULT '' COMMENT 'open id', -- 平台open id
    PRIMARY KEY(id),
    FOREIGN KEY(`user`) REFERENCES `user`(id)
) ENGINE=MyISAM AUTO_INCREMENT=101;