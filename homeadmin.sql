/*
Navicat MySQL Data Transfer

Source Server         : 本机
Source Server Version : 50547
Source Host           : localhost:3306
Source Database       : homeadmin

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2018-08-17 17:51:46
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `ha_admin`
-- ----------------------------
DROP TABLE IF EXISTS `ha_admin`;
CREATE TABLE `ha_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL COMMENT '账户名称',
  `password` varchar(100) NOT NULL COMMENT '密码',
  `telphone` varchar(20) DEFAULT NULL COMMENT '手机号码',
  `sex` tinyint(4) unsigned DEFAULT '0' COMMENT '性别 0默认 1男 2女',
  `type` tinyint(3) unsigned DEFAULT '1' COMMENT '管理员类别 0超级管理员 1普通管理员',
  `right` tinyint(4) DEFAULT '0' COMMENT '权限 0只读 1读写',
  `last_login_time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique` (`username`,`password`),
  KEY `telphone` (`telphone`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='管理员账户';

-- ----------------------------
-- Records of ha_admin
-- ----------------------------
INSERT INTO `ha_admin` VALUES ('1', 'zlgcg', '123456', '18612701228', '1', '0', '1', null);

-- ----------------------------
-- Table structure for `ha_catalog`
-- ----------------------------
DROP TABLE IF EXISTS `ha_catalog`;
CREATE TABLE `ha_catalog` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '父类目录id 0为初级',
  `title` varchar(50) NOT NULL COMMENT '目录名称',
  `icon` varchar(10) DEFAULT 'default' COMMENT '图标的标识',
  `url` varchar(50) DEFAULT NULL COMMENT '链接地址',
  `create_time` int(11) DEFAULT NULL,
  `modify_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique` (`url`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='系统的目录列表';

-- ----------------------------
-- Records of ha_catalog
-- ----------------------------

-- ----------------------------
-- Table structure for `ha_permission`
-- ----------------------------
DROP TABLE IF EXISTS `ha_permission`;
CREATE TABLE `ha_permission` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) NOT NULL COMMENT '管理员id',
  `catalog_id` int(11) NOT NULL COMMENT '菜单id',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique` (`admin_id`,`catalog_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='目录的权限列表';

-- ----------------------------
-- Records of ha_permission
-- ----------------------------
