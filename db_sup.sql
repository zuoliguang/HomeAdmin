/*
 Navicat Premium Data Transfer

 Source Server         : 测试机
 Source Server Type    : MySQL
 Source Server Version : 50636
 Source Host           : 10.32.33.42
 Source Database       : db_sup

 Target Server Type    : MySQL
 Target Server Version : 50636
 File Encoding         : utf-8

 Date: 03/11/2019 17:55:26 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `ha_admin`
-- ----------------------------
DROP TABLE IF EXISTS `ha_admin`;
CREATE TABLE `ha_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL COMMENT '账户名称',
  `password` varchar(100) NOT NULL COMMENT '密码 password_hash 算法生成',
  `icon` varchar(150) DEFAULT NULL COMMENT '用户头像地址',
  `telphone` varchar(20) DEFAULT NULL COMMENT '手机号码',
  `email` varchar(50) DEFAULT NULL COMMENT '邮箱地址',
  `web` varchar(255) DEFAULT NULL COMMENT '个人网站地址',
  `sex` tinyint(4) unsigned DEFAULT '0' COMMENT '性别 0默认 1男 2女',
  `province` varchar(50) DEFAULT NULL COMMENT '省',
  `city` varchar(50) DEFAULT NULL COMMENT '市',
  `region` varchar(50) DEFAULT NULL COMMENT '区/县',
  `type` tinyint(3) unsigned DEFAULT '1' COMMENT '管理员类别 0超级管理员 1普通管理员',
  `right` tinyint(4) DEFAULT '0' COMMENT '权限 0只读 1读写',
  `last_login_time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique` (`username`),
  KEY `telphone` (`telphone`),
  KEY `username` (`username`),
  KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='管理员账户';

-- ----------------------------
--  Records of `ha_admin`
-- ----------------------------
BEGIN;
INSERT INTO `ha_admin` VALUES ('1', 'zlgcg', '$2y$10$p0TtmYTZtN1JmzhNbvfqae47LZ.glSEOw5.7JcDWPfd.rwyViCmpm', 'http://himg.bdimg.com/sys/portrait/item/39557a6c67636778797afd33.jpg', '18612701228', 'zlgcg@sina.com', 'https://github.com/zuoliguang', '1', '北京', '北京', '通州区', '0', '1', '1552294741'), ('2', 'test', '$2y$10$OaKv8gStxqyZp93dMNJI/uqvXPsRCSJnUjenhF0OpGGpTGHoYkbDq', null, '12345678901', 'test@sina.com', null, '0', null, null, null, '1', '0', '1552294409');
COMMIT;

-- ----------------------------
--  Table structure for `ha_catalog`
-- ----------------------------
DROP TABLE IF EXISTS `ha_catalog`;
CREATE TABLE `ha_catalog` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '父类目录id 0/null为初级目录',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '目录名称',
  `icon` varchar(10) DEFAULT '&#xe63c;' COMMENT '图标的标识',
  `url` varchar(50) DEFAULT '' COMMENT '链接地址',
  `is_del` tinyint(3) unsigned DEFAULT '0' COMMENT '删除状态 0未删除 1删除',
  `create_time` int(11) DEFAULT NULL,
  `modify_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique` (`url`,`title`) USING BTREE,
  KEY `title` (`title`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='系统的目录列表';

-- ----------------------------
--  Records of `ha_catalog`
-- ----------------------------
BEGIN;
INSERT INTO `ha_catalog` VALUES ('1', '0', '管理/权限', '&#xe613;', '/', '0', '1534908310', '1534998229'), ('2', '1', '管理员信息', '&#xe66f;', '/home/adminList', '0', '1534919729', '1552290816'), ('3', '1', '权限列表', '&#xe656;', '/home/catalogList', '0', '1534919834', '1552298036'), ('4', '1', '授权中心', '&#xe672;', '/home/permission', '0', '1534919891', '1552290759'), ('5', '0', '配置管理', '&#xe716;', '/', '0', '1535347051', '1552291362'), ('6', '5', '测试配置', '&#xe64e;', '/config/test', '0', '1535347120', '1552291394'), ('7', '0', '导购绩效', '&#xe629;', '/', '0', '1552281500', '1552291463'), ('8', '7', '门店信息', '&#xe68e;', '/performance/store/store', '0', '1552281617', '1552291534'), ('9', '7', '导购信息', '&#xe63b;', '/performance/operator/operator', '0', '1552281685', '1552291622'), ('10', '7', '导购订单', '&#xe63c;', '/', '0', '1552281732', '1552291656');
COMMIT;

-- ----------------------------
--  Table structure for `ha_permission`
-- ----------------------------
DROP TABLE IF EXISTS `ha_permission`;
CREATE TABLE `ha_permission` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) NOT NULL COMMENT '管理员id',
  `catalog_id` int(11) NOT NULL COMMENT '菜单id',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique` (`admin_id`,`catalog_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='目录的权限列表';

-- ----------------------------
--  Records of `ha_permission`
-- ----------------------------
BEGIN;
INSERT INTO `ha_permission` VALUES ('9', '2', '10'), ('8', '2', '9'), ('7', '2', '8');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
