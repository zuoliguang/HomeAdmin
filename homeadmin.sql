/*
Navicat MySQL Data Transfer

Source Server         : 本机
Source Server Version : 50547
Source Host           : localhost:3306
Source Database       : homeadmin

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2018-08-23 12:26:11
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `ha_admin`
-- ----------------------------
DROP TABLE IF EXISTS `ha_admin`;
CREATE TABLE `ha_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL COMMENT '账户名称',
  `password` varchar(100) NOT NULL COMMENT '密码 password_hash 算法生成',
  `icon` varchar(50) DEFAULT NULL COMMENT '用户头像地址',
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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='管理员账户';

-- ----------------------------
-- Records of ha_admin
-- ----------------------------
INSERT INTO `ha_admin` VALUES ('1', 'zlgcg', '$2y$10$XotixigZhdIQGoyEzxRn2uUkXdMdjBkKjCTqQJX0B/OQa9RCBmX8S', 'https://avatars1.githubusercontent.com/u/7259943', '18612701228', 'zlgcg@sina.com', 'https://github.com/zuoliguang', '1', '北京', '北京', '通州区', '0', '1', '1534997436');

-- ----------------------------
-- Table structure for `ha_catalog`
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
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='系统的目录列表';

-- ----------------------------
-- Records of ha_catalog
-- ----------------------------
INSERT INTO `ha_catalog` VALUES ('1', '0', '管理/权限', '&#xe613;', '/', '0', '1534908310', '1534998229');
INSERT INTO `ha_catalog` VALUES ('2', '1', '管理员信息', '&#xe612;', '/home/adminList', '0', '1534919729', '1534921694');
INSERT INTO `ha_catalog` VALUES ('3', '1', '菜单列表', '&#xe63c;', '/home/catalogList', '0', '1534919834', '1534922781');
INSERT INTO `ha_catalog` VALUES ('4', '1', '授权中心', '&#xe628;', '/home/permission', '0', '1534919891', '1534922866');
INSERT INTO `ha_catalog` VALUES ('5', '0', '博客管理', '&#xe632;', '/', '0', '1534985946', '1534998216');
INSERT INTO `ha_catalog` VALUES ('6', '5', '博文管理', '&#xe60a;', '/blog/article', '0', '1534986040', '1534997910');
INSERT INTO `ha_catalog` VALUES ('7', '5', '首页展示图', '&#xe634;', '/blog/top', '0', '1534997724', null);

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
