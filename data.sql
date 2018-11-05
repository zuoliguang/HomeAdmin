CREATE DATABASE  IF NOT EXISTS `homeadmin` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `homeadmin`;
-- MySQL dump 10.13  Distrib 5.7.24, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: homeadmin
-- ------------------------------------------------------
-- Server version	5.5.60-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `ha_admin`
--

DROP TABLE IF EXISTS `ha_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ha_admin`
--

LOCK TABLES `ha_admin` WRITE;
/*!40000 ALTER TABLE `ha_admin` DISABLE KEYS */;
INSERT INTO `ha_admin` VALUES (1,'zlgcg','$2y$10$p0TtmYTZtN1JmzhNbvfqae47LZ.glSEOw5.7JcDWPfd.rwyViCmpm','http://himg.bdimg.com/sys/portrait/item/39557a6c67636778797afd33.jpg','18612701228','zlgcg@sina.com','https://github.com/zuoliguang',1,'北京','北京','通州区',0,1,1541385216),(2,'test','$2y$10$2HQevjH9yZeTkUcbd4i6fO3IjFH0GtmUYG3.cMISOoDDLgSldhDKq','','18612701228','zlgcg@sina.com','https://github.com/zuoliguang',1,NULL,NULL,NULL,1,0,1540451042);
/*!40000 ALTER TABLE `ha_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ha_catalog`
--

DROP TABLE IF EXISTS `ha_catalog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ha_catalog`
--

LOCK TABLES `ha_catalog` WRITE;
/*!40000 ALTER TABLE `ha_catalog` DISABLE KEYS */;
INSERT INTO `ha_catalog` VALUES (1,0,'管理/权限','&#xe613;','/',0,1534908310,1534998229),(2,1,'管理员信息','&#xe612;','/home/adminList',0,1534919729,1534921694),(3,1,'菜单列表','&#xe63c;','/home/catalogList',0,1534919834,1534922781),(4,1,'授权中心','&#xe628;','/home/permission',0,1534919891,1534922866),(5,0,'配置管理','&#xe631;','/',0,1535347051,NULL),(6,5,'测试配置','&#xe64e;','/config/test',0,1535347120,NULL),(7,0,'博客管理','&#xe632;','/',0,1535347172,NULL),(8,7,'博文分类','&#xe630;','/blog/category',0,1535347269,NULL),(9,7,'博文管理','&#xe60a;','/blog/articles',0,1535347378,1537014559),(10,7,'首页展示图','&#xe634;','/blog/tops',0,1535347508,NULL),(11,7,'关于我','&#xe60c;','/blog/aboutme',0,1535347595,NULL),(12,7,'友情链接','&#xe64c;','/blog/friendships',0,1535347702,1537608581),(13,7,'数据统计','&#xe629;','/blog/dataCenter',0,1535347814,NULL);
/*!40000 ALTER TABLE `ha_catalog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ha_permission`
--

DROP TABLE IF EXISTS `ha_permission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ha_permission` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) NOT NULL COMMENT '管理员id',
  `catalog_id` int(11) NOT NULL COMMENT '菜单id',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique` (`admin_id`,`catalog_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='目录的权限列表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ha_permission`
--

LOCK TABLES `ha_permission` WRITE;
/*!40000 ALTER TABLE `ha_permission` DISABLE KEYS */;
INSERT INTO `ha_permission` VALUES (1,2,8),(2,2,9),(3,2,10),(4,2,11),(5,2,12),(6,2,13);
/*!40000 ALTER TABLE `ha_permission` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-11-05 16:42:06
CREATE DATABASE  IF NOT EXISTS `homeblog` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `homeblog`;
-- MySQL dump 10.13  Distrib 5.7.24, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: homeblog
-- ------------------------------------------------------
-- Server version	5.5.60-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `hb_about_me`
--

DROP TABLE IF EXISTS `hb_about_me`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hb_about_me`
--

LOCK TABLES `hb_about_me` WRITE;
/*!40000 ALTER TABLE `hb_about_me` DISABLE KEYS */;
INSERT INTO `hb_about_me` VALUES (1,'testindex','test测试','北京市','北京市','朝阳区','测试哈哈哈哈','zlgcg@sina.com','http://www.homeadmin.com/upload/image/2018-09-18/2018-09-18-1537278691.jpg?(2976x3968)','http://www.homeadmin.com/upload/image/2018-09-18/2018-09-18-1537278693.jpg?(2976x3968)','http://www.homeadmin.com/upload/image/2018-09-18/2018-09-18-1537278694.jpg?(300x301)','&lt;p&gt;测试，&lt;b&gt;&lt;i&gt;&lt;u&gt;test&lt;/u&gt;&lt;/i&gt;&lt;/b&gt;!&amp;nbsp; 哈哈哈&lt;/p&gt;',1,0,1537278716,1540371911);
/*!40000 ALTER TABLE `hb_about_me` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hb_article`
--

DROP TABLE IF EXISTS `hb_article`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hb_article`
--

LOCK TABLES `hb_article` WRITE;
/*!40000 ALTER TABLE `hb_article` DISABLE KEYS */;
INSERT INTO `hb_article` VALUES (1,3,'要不要升本科？','大学刚毕业的前几年，我们对学历还没有明显的感觉，工作5、6年之后发现，要提升自己职称的时候，学历却默默的拖了我们的后腿。','https://github.com/zuoliguang/images/blob/master/blog/1.jpg?raw=true','zlgcg','<h5><p>大学刚毕业的前几年，我们对学历还没有明显的感觉，工作5、6年之后发现，要提升自己职称的时候，学历却默默的拖了我们的后腿。</p></h5><b></b><p><br></p>',0,0,'学历 职场','http://www.homeblog.com/index/list',0,0,0,1537067374,1540454354);
/*!40000 ALTER TABLE `hb_article` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hb_category`
--

DROP TABLE IF EXISTS `hb_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hb_category`
--

LOCK TABLES `hb_category` WRITE;
/*!40000 ALTER TABLE `hb_category` DISABLE KEYS */;
INSERT INTO `hb_category` VALUES (1,'生活','工作,生活,家庭,规划,学习',0,1535355597,1540451376),(2,'编程','PHP,GO,Python,JS,HTML,框架,服务器,LINUX',0,1535357906,1537066820),(3,'职场','初级职称,中级职称,高级职称,职业生涯,学习',0,1537067119,1540451344),(4,'学业','专科,本科,研究生',0,1540451436,NULL);
/*!40000 ALTER TABLE `hb_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hb_comment`
--

DROP TABLE IF EXISTS `hb_comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hb_comment`
--

LOCK TABLES `hb_comment` WRITE;
/*!40000 ALTER TABLE `hb_comment` DISABLE KEYS */;
/*!40000 ALTER TABLE `hb_comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hb_friendships`
--

DROP TABLE IF EXISTS `hb_friendships`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hb_friendships`
--

LOCK TABLES `hb_friendships` WRITE;
/*!40000 ALTER TABLE `hb_friendships` DISABLE KEYS */;
INSERT INTO `hb_friendships` VALUES (1,'test','http://www.homeadmin.com/upload/image/2018-09-22/2018-09-22-1537611178.jpg?(300x301)','www.test1.com',1,1537611198,1537611564);
/*!40000 ALTER TABLE `hb_friendships` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hb_pv`
--

DROP TABLE IF EXISTS `hb_pv`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hb_pv` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `referer` varchar(255) DEFAULT '' COMMENT 'ip 来源',
  `local` varchar(255) DEFAULT '' COMMENT '被访问本站地址',
  `tags` varchar(60) DEFAULT '' COMMENT '被访问的文章标签-热点',
  `agent` varchar(100) DEFAULT '' COMMENT 'server中agent信息用于区分设备类型',
  `province` varchar(60) DEFAULT '' COMMENT 'IP所属地区',
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `referer` (`referer`),
  KEY `local` (`local`),
  KEY `tags` (`tags`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='记录网站被访问的次数，同一个IP半小时内被访问无效';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hb_pv`
--

LOCK TABLES `hb_pv` WRITE;
/*!40000 ALTER TABLE `hb_pv` DISABLE KEYS */;
/*!40000 ALTER TABLE `hb_pv` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hb_tops`
--

DROP TABLE IF EXISTS `hb_tops`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hb_tops`
--

LOCK TABLES `hb_tops` WRITE;
/*!40000 ALTER TABLE `hb_tops` DISABLE KEYS */;
INSERT INTO `hb_tops` VALUES (2,'test测试标题','http://hadmin.com/upload/image/2018-10-25/2018-10-25-1540451114.jpg',0,1537105026,1540451115),(3,'test','http://hadmin.com/upload/image/2018-10-25/2018-10-25-1540451125.jpg',0,1537105126,1540451126);
/*!40000 ALTER TABLE `hb_tops` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-11-05 16:42:06
