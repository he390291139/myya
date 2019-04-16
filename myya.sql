/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50721
 Source Host           : localhost:3306
 Source Schema         : myya

 Target Server Type    : MySQL
 Target Server Version : 50721
 File Encoding         : 65001

 Date: 16/04/2019 20:09:40
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for myya_admin
-- ----------------------------
DROP TABLE IF EXISTS `myya_admin`;
CREATE TABLE `myya_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `username` varchar(10) NOT NULL COMMENT '用户名',
  `password` varchar(32) NOT NULL COMMENT '用户密码',
  `email` varchar(100) DEFAULT NULL COMMENT 'email',
  `nickname` varchar(50) NOT NULL COMMENT '昵称',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态：0为正常，1为禁用',
  `token` varchar(255) DEFAULT NULL,
  `createTime` int(10) DEFAULT NULL,
  `updateTime` int(10) DEFAULT NULL,
  `deleteTime` int(10) DEFAULT NULL,
  `salt` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COMMENT='管理员表';

-- ----------------------------
-- Records of myya_admin
-- ----------------------------
BEGIN;
INSERT INTO `myya_admin` VALUES (1, 'admin', 'c2fd88e7d626b1fb24bfe7212260daa9', 'demo@demo.com', 'admin', 0, NULL, 1397897899, 1555392952, NULL, '6789');
INSERT INTO `myya_admin` VALUES (2, 'admin1', 'cbdfd2c75522617839e36f6cfbdd2653', 'demo@demo.com', 'admin1', 0, NULL, 1134435345, 1555391848, NULL, '4578');
INSERT INTO `myya_admin` VALUES (3, 'demo', '3c1a8fd4760e036bd4160feb5fdfd1f2', 'demo@demo.com', 'demo', 0, NULL, 1555231087, 1555330241, NULL, '5905');
INSERT INTO `myya_admin` VALUES (4, 'demo1', '06d0b2da1e3e295c63d07b0ec3dc63a4', 'demo@demo.com', 'demo2', 0, NULL, 1555233323, 1555392336, NULL, '3663');
INSERT INTO `myya_admin` VALUES (5, 'demo2', '2957fe89bb0d6d1f8517ef0f0b8eb2a5', 'demo@demo.com', 'demo', 0, NULL, 1555238189, 1555329753, 1555329753, '7383');
INSERT INTO `myya_admin` VALUES (6, 'demo3', 'eb793ab810fd912069af6482fed83e72', 'demo@demo.com', 'demo', 0, NULL, 1555238224, 1555327651, NULL, '4746');
INSERT INTO `myya_admin` VALUES (7, 'demo4', 'c903cf609323d957e472b7e6c3522214', 'demo@demo.com', 'demo2', 0, NULL, 1555238279, 1555327648, NULL, '8573');
INSERT INTO `myya_admin` VALUES (8, 'demo5', 'cdb34290dd65f8b0b5cd510221115873', 'demo@demo.com', 'demo', 0, NULL, 1555238333, 1555390861, 1555390861, '1979');
INSERT INTO `myya_admin` VALUES (9, 'demo90', '911069d9a9c288b352289eb84ce7c16d', 'demo@demo.com', 'demo', 0, NULL, 1555238391, 1555390859, 1555390859, '3109');
INSERT INTO `myya_admin` VALUES (10, 'demo89', '81b4caf3ab76c0f6a8c79d5e20c877af', 'demo', 'demo', 1, NULL, 1555238461, 1555329732, 1555329732, '2229');
INSERT INTO `myya_admin` VALUES (11, 'demo67', '0cb755a379ce02f6216e334ac0ce84a4', 'demo@demo.com', 'demo', 1, NULL, 1555238498, 1555331694, NULL, '7007');
INSERT INTO `myya_admin` VALUES (12, 'demo2', '4ff8ff06c0e6ea551d45f29b9f388d2f', 'demo2@demo.com', 'demo2', 0, NULL, 1555390911, 1555390911, NULL, '2314');
INSERT INTO `myya_admin` VALUES (13, 'demo23', '6f6f94bbe8d9bf803c418bdaba949b1b', 'demo@demo.com', 'demo', 0, NULL, 1555390925, 1555390925, NULL, '4612');
INSERT INTO `myya_admin` VALUES (14, 'demode', '31cbb74c672b9e4445bf7a4a1443370f', 'demo@demo.com', 'demode', 0, NULL, 1555390947, 1555392224, NULL, '8249');
INSERT INTO `myya_admin` VALUES (15, 'demo239', '64b023e51c30c8a6ec0b40b3e9d251f0', 'demo@demo.com', 'demo', 0, NULL, 1555390960, 1555390960, NULL, '5324');
COMMIT;

-- ----------------------------
-- Table structure for myya_auth_group
-- ----------------------------
DROP TABLE IF EXISTS `myya_auth_group`;
CREATE TABLE `myya_auth_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(100) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `rules` char(80) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of myya_auth_group
-- ----------------------------
BEGIN;
INSERT INTO `myya_auth_group` VALUES (1, '超级管理员组', 1, '1');
INSERT INTO `myya_auth_group` VALUES (2, '二级管理员', 1, '');
INSERT INTO `myya_auth_group` VALUES (3, '三级管理员', 1, '');
COMMIT;

-- ----------------------------
-- Table structure for myya_auth_group_access
-- ----------------------------
DROP TABLE IF EXISTS `myya_auth_group_access`;
CREATE TABLE `myya_auth_group_access` (
  `uid` mediumint(8) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of myya_auth_group_access
-- ----------------------------
BEGIN;
INSERT INTO `myya_auth_group_access` VALUES (1, 1);
COMMIT;

-- ----------------------------
-- Table structure for myya_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `myya_auth_rule`;
CREATE TABLE `myya_auth_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(80) NOT NULL DEFAULT '',
  `title` char(20) NOT NULL DEFAULT '',
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `condition` char(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of myya_auth_rule
-- ----------------------------
BEGIN;
INSERT INTO `myya_auth_rule` VALUES (1, 'admin/index/login', '后台登录', 1, 1, '');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
