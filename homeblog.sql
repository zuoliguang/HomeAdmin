/*
Navicat MySQL Data Transfer

Source Server         : 本机
Source Server Version : 50547
Source Host           : localhost:3306
Source Database       : homeblog

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2018-08-23 08:43:25
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `hb_article`
-- ----------------------------
DROP TABLE IF EXISTS `hb_article`;
CREATE TABLE `hb_article` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(150) DEFAULT '' COMMENT '文章标题',
  `intro` varchar(300) DEFAULT '' COMMENT '文章简介',
  `author` varchar(30) DEFAULT '' COMMENT '作者名称，这里记录后台账号名称',
  `body` text COMMENT '文章内容-使用在线编辑',
  `is_del` tinyint(4) DEFAULT '0' COMMENT '软删除标识 0未删除 1删除',
  `times` int(11) DEFAULT '0' COMMENT '浏览次数-文章排行',
  `tags` varchar(60) DEFAULT '' COMMENT '标签',
  `create_time` int(11) DEFAULT NULL,
  `modify_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique` (`title`,`author`) USING BTREE,
  KEY `times` (`times`),
  KEY `tags` (`tags`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of hb_article
-- ----------------------------

-- ----------------------------
-- Table structure for `hb_pv`
-- ----------------------------
DROP TABLE IF EXISTS `hb_pv`;
CREATE TABLE `hb_pv` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `referer` varchar(255) DEFAULT '' COMMENT 'ip 来源',
  `local` varchar(255) DEFAULT '' COMMENT '本站地址',
  `tag` varchar(60) DEFAULT '' COMMENT '被访问的文章标签-用户兴趣点',
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of hb_pv
-- ----------------------------
