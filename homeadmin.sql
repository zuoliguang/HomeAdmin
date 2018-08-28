/*
Navicat MySQL Data Transfer

Source Server         : 本机
Source Server Version : 50547
Source Host           : localhost:3306
Source Database       : homeadmin

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2018-08-28 13:04:11
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
-- Records of ha_admin
-- ----------------------------
INSERT INTO `ha_admin` VALUES ('1', 'zlgcg', '$2y$10$p0TtmYTZtN1JmzhNbvfqae47LZ.glSEOw5.7JcDWPfd.rwyViCmpm', 'http://himg.bdimg.com/sys/portrait/item/39557a6c67636778797afd33.jpg', '18612701228', 'zlgcg@sina.com', 'https://github.com/zuoliguang', '1', '北京', '北京', '通州区', '0', '1', '1535358485');
INSERT INTO `ha_admin` VALUES ('2', 'test', '$2y$10$2HQevjH9yZeTkUcbd4i6fO3IjFH0GtmUYG3.cMISOoDDLgSldhDKq', '', '18612701228', 'zlgcg@sina.com', 'https://github.com/zuoliguang', '1', null, null, null, '1', '0', '1535098995');

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
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='系统的目录列表';

-- ----------------------------
-- Records of ha_catalog
-- ----------------------------
INSERT INTO `ha_catalog` VALUES ('1', '0', '管理/权限', '&#xe613;', '/', '0', '1534908310', '1534998229');
INSERT INTO `ha_catalog` VALUES ('2', '1', '管理员信息', '&#xe612;', '/home/adminList', '0', '1534919729', '1534921694');
INSERT INTO `ha_catalog` VALUES ('3', '1', '菜单列表', '&#xe63c;', '/home/catalogList', '0', '1534919834', '1534922781');
INSERT INTO `ha_catalog` VALUES ('4', '1', '授权中心', '&#xe628;', '/home/permission', '0', '1534919891', '1534922866');
INSERT INTO `ha_catalog` VALUES ('5', '0', '配置管理', '&#xe631;', '/', '0', '1535347051', null);
INSERT INTO `ha_catalog` VALUES ('6', '5', '测试配置', '&#xe64e;', '/config/test', '0', '1535347120', null);
INSERT INTO `ha_catalog` VALUES ('7', '0', '博客管理', '&#xe632;', '/', '0', '1535347172', null);
INSERT INTO `ha_catalog` VALUES ('8', '7', '博文分类', '&#xe630;', '/blog/category', '0', '1535347269', null);
INSERT INTO `ha_catalog` VALUES ('9', '7', '博文管理', '&#xe60a;', '/blog/article', '0', '1535347378', null);
INSERT INTO `ha_catalog` VALUES ('10', '7', '首页展示图', '&#xe634;', '/blog/tops', '0', '1535347508', null);
INSERT INTO `ha_catalog` VALUES ('11', '7', '关于我', '&#xe60c;', '/blog/aboutme', '0', '1535347595', null);
INSERT INTO `ha_catalog` VALUES ('12', '7', '友情链接', '&#xe64c;', '/blog/friendship', '0', '1535347702', null);
INSERT INTO `ha_catalog` VALUES ('13', '7', '数据统计', '&#xe629;', '/blog/dataCenter', '0', '1535347814', null);

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
