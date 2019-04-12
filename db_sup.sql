/*
 Navicat MySQL Data Transfer

 Source Server         : db_sup
 Source Server Version : 50616
 Source Host           : rdsa5d34981eehgxmloqo.mysql.rds.aliyuncs.com
 Source Database       : db_sup

 Target Server Version : 50616
 File Encoding         : utf-8

 Date: 04/12/2019 11:32:13 AM
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='管理员账户';

-- ----------------------------
--  Records of `ha_admin`
-- ----------------------------
BEGIN;
INSERT INTO `ha_admin` VALUES ('1', 'zlgcg', '$2y$10$p0TtmYTZtN1JmzhNbvfqae47LZ.glSEOw5.7JcDWPfd.rwyViCmpm', 'http://himg.bdimg.com/sys/portrait/item/39557a6c67636778797afd33.jpg', '18612701228', 'zlgcg@sina.com', 'https://github.com/zuoliguang', '1', '北京', '北京', '通州区', '0', '1', '1555039757'), ('2', 'test', '$2y$10$OaKv8gStxqyZp93dMNJI/uqvXPsRCSJnUjenhF0OpGGpTGHoYkbDq', null, '12345678901', 'test@sina.com', null, '0', null, null, null, '1', '1', '1555039631');
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
  `sort` int(11) DEFAULT '0' COMMENT '排序，小到大',
  `create_time` int(11) DEFAULT NULL,
  `modify_time` int(11) DEFAULT NULL,
  `is_del` tinyint(3) unsigned DEFAULT '0' COMMENT '删除状态 0未删除 1删除',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique` (`url`,`title`) USING BTREE,
  KEY `title` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='系统的目录列表';

-- ----------------------------
--  Records of `ha_catalog`
-- ----------------------------
BEGIN;
INSERT INTO `ha_catalog` VALUES ('1', '0', '管理/权限', '&#xe613;', '/', '0', '1534908310', '1534998229', '0'), ('2', '1', '管理员信息', '&#xe66f;', '/home/adminList', '0', '1534919729', '1552290816', '0'), ('3', '1', '权限列表', '&#xe656;', '/home/catalogList', '0', '1534919834', '1552298036', '0'), ('4', '1', '授权中心', '&#xe672;', '/home/permission', '0', '1534919891', '1552290759', '0'), ('5', '0', '配置管理', '&#xe716;', '/', '0', '1535347051', '1552291362', '0'), ('6', '5', '测试配置', '&#xe64e;', '/config/test', '0', '1535347120', '1552291394', '0'), ('7', '0', '导购绩效', '&#xe629;', '/', '0', '1552281500', '1552291463', '0'), ('8', '7', '门店信息', '&#xe68e;', '/performance/store/store', '0', '1552281617', '1552291534', '0'), ('9', '7', '导购信息', '&#xe63b;', '/performance/operator/operator', '2', '1552281685', '1555039555', '0'), ('10', '7', '导购订单', '&#xe63c;', '/performance/order/order', '3', '1552281732', '1555039571', '0'), ('12', '7', '绩效规则', '&#xe62c;', '/performance/performance/roles', '4', '1552465796', '1555039583', '0'), ('13', '7', '门店群', '&#xe63a;', '/performance/store_group/group', '1', '1554973341', '1555039535', '0');
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
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='目录的权限列表';

-- ----------------------------
--  Records of `ha_permission`
-- ----------------------------
BEGIN;
INSERT INTO `ha_permission` VALUES ('14', '2', '8'), ('15', '2', '9'), ('16', '2', '10'), ('17', '2', '12'), ('18', '2', '13');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
