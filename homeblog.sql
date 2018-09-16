/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : homeblog

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-09-16 22:12:30
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `hb_about_me`
-- ----------------------------
DROP TABLE IF EXISTS `hb_about_me`;
CREATE TABLE `hb_about_me` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nickname` varchar(100) DEFAULT NULL COMMENT '网名',
  `duty` varchar(50) DEFAULT NULL COMMENT '职业',
  `province` varchar(50) DEFAULT NULL COMMENT '省',
  `city` varchar(50) DEFAULT NULL COMMENT '市',
  `area` varchar(100) DEFAULT NULL COMMENT '区',
  `location` varchar(255) DEFAULT NULL COMMENT '详细地址',
  `email` varchar(100) DEFAULT NULL COMMENT '电子邮箱',
  `wchat_public_img` varchar(255) DEFAULT NULL COMMENT '微信公众号图片地址',
  `wchat_pay_img` varchar(255) DEFAULT NULL COMMENT '微信支付图片地址',
  `alipay_img` varchar(255) DEFAULT NULL COMMENT '阿里支付图片',
  `introduce` text COMMENT '简介信息',
  `is_default` tinyint(4) DEFAULT '0' COMMENT '是否默认',
  `is_del` tinyint(4) DEFAULT '0',
  `create_time` int(11) DEFAULT NULL,
  `modify_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of hb_about_me
-- ----------------------------

-- ----------------------------
-- Table structure for `hb_article`
-- ----------------------------
DROP TABLE IF EXISTS `hb_article`;
CREATE TABLE `hb_article` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL COMMENT '文章分类',
  `title` varchar(50) DEFAULT '' COMMENT '文章标题',
  `intro` varchar(100) DEFAULT '' COMMENT '文章简介',
  `img` varchar(255) DEFAULT NULL COMMENT '文章配图',
  `author` varchar(30) DEFAULT '' COMMENT '作者名称，这里记录后台账号名称',
  `content` text COMMENT '文章内容-使用在线编辑',
  `times` int(11) DEFAULT '0' COMMENT '浏览次数-文章排行',
  `admire` int(11) DEFAULT NULL COMMENT '被赞的次数 （一个IP 1次/天）',
  `tags` varchar(60) DEFAULT '' COMMENT '标签',
  `link_url` varchar(255) DEFAULT NULL COMMENT '如果是转载，该位置添加地址',
  `is_recommend` tinyint(4) DEFAULT '0' COMMENT '特别推荐 0否 1是',
  `is_show` tinyint(4) DEFAULT '0' COMMENT '显隐性 0 隐藏 1 显示',
  `is_del` tinyint(4) DEFAULT '0' COMMENT '软删除标识 0未删除 1删除',
  `create_time` int(11) DEFAULT NULL,
  `modify_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique` (`title`,`author`) USING BTREE,
  KEY `times` (`times`),
  KEY `tags` (`tags`),
  KEY `is_recommend` (`is_recommend`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of hb_article
-- ----------------------------
INSERT INTO `hb_article` VALUES ('1', '1', '测试', '测试', 'http://www.homeblog.com/public/images/b06.jpg', 'zlgcg', '<p>这是一段<b>测试<strike>内容</strike>。</b></p><p><b><img src=\"/upload/image/2018-09-16/2018-04-06_093151.jpg\" alt=\"HOMEADMIN图片\"></b></p><b></b>', '0', '0', '测试', 'http://www.homeblog.com/index/list', '0', '0', '0', '1537067374', '1537079983');

-- ----------------------------
-- Table structure for `hb_category`
-- ----------------------------
DROP TABLE IF EXISTS `hb_category`;
CREATE TABLE `hb_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL COMMENT '文章分类名称',
  `tags` varchar(255) DEFAULT NULL COMMENT '该分类下所有包含的标签',
  `is_del` tinyint(4) DEFAULT '0',
  `create_time` int(11) DEFAULT NULL,
  `modify_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique` (`title`),
  KEY `tags` (`tags`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of hb_category
-- ----------------------------
INSERT INTO `hb_category` VALUES ('1', '生活', '工作,生活,家庭,规划', '0', '1535355597', '1535361231');
INSERT INTO `hb_category` VALUES ('2', '编程', 'PHP,GO,Python,JS,HTML,框架,服务器,LINUX', '0', '1535357906', '1537066820');
INSERT INTO `hb_category` VALUES ('3', '职场', '初级职称,中级职称,高级职称,职业生涯', '0', '1537067119', null);

-- ----------------------------
-- Table structure for `hb_comment`
-- ----------------------------
DROP TABLE IF EXISTS `hb_comment`;
CREATE TABLE `hb_comment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `art_id` int(11) DEFAULT NULL COMMENT '文章的id',
  `pid` int(11) DEFAULT NULL COMMENT '该评论的上一级评论id',
  `massage` varchar(255) DEFAULT NULL COMMENT '评论内容',
  `is_del` tinyint(4) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `modify_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `art_id` (`art_id`),
  KEY `pid` (`pid`),
  KEY `massage` (`massage`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='评论列表 游客评论 每次发布使用验证码确认，防止被刷库';

-- ----------------------------
-- Records of hb_comment
-- ----------------------------

-- ----------------------------
-- Table structure for `hb_friendships`
-- ----------------------------
DROP TABLE IF EXISTS `hb_friendships`;
CREATE TABLE `hb_friendships` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL COMMENT '链接标题',
  `pic` varchar(100) DEFAULT NULL COMMENT '展示图',
  `friendsship_link` varchar(255) DEFAULT NULL COMMENT '链接地址',
  `is_del` tinyint(4) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `modify_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique` (`title`,`friendsship_link`) USING BTREE,
  KEY `title` (`title`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of hb_friendships
-- ----------------------------

-- ----------------------------
-- Table structure for `hb_pv`
-- ----------------------------
DROP TABLE IF EXISTS `hb_pv`;
CREATE TABLE `hb_pv` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `referer` varchar(255) DEFAULT '' COMMENT 'ip 来源',
  `local` varchar(255) DEFAULT '' COMMENT '本站地址',
  `tags` varchar(60) DEFAULT '' COMMENT '被访问的文章标签-用户兴趣点',
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `referer` (`referer`),
  KEY `local` (`local`),
  KEY `tags` (`tags`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of hb_pv
-- ----------------------------

-- ----------------------------
-- Table structure for `hb_tops`
-- ----------------------------
DROP TABLE IF EXISTS `hb_tops`;
CREATE TABLE `hb_tops` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL COMMENT '展示标题',
  `img` varchar(200) NOT NULL COMMENT '背景图',
  `is_del` tinyint(4) DEFAULT '0',
  `create_time` int(11) DEFAULT NULL,
  `modify_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_index` (`img`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='博客首页头栏';

-- ----------------------------
-- Records of hb_tops
-- ----------------------------
INSERT INTO `hb_tops` VALUES ('2', 'test测试标题', 'http://www.homeadmin.com/upload/image/2018-09-16/2018-09-16-1537105020.jpg', '0', '1537105026', null);
INSERT INTO `hb_tops` VALUES ('3', 'test', 'http://www.homeadmin.com/upload/image/2018-09-16/2018-09-16-1537106485.jpg', '0', '1537105126', '1537106881');
