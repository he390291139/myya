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

 Date: 14/04/2019 10:44:26
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='管理员表';

-- ----------------------------
-- Records of myya_admin
-- ----------------------------
BEGIN;
INSERT INTO `myya_admin` VALUES (1, 'admin', 'c2fd88e7d626b1fb24bfe7212260daa9', NULL, 'admin', 0, NULL, 1397897899, NULL, NULL, '6789');
INSERT INTO `myya_admin` VALUES (2, 'admin1', 'cbdfd2c75522617839e36f6cfbdd2653', NULL, 'admin1', 0, NULL, 1134435345, NULL, NULL, '4578');
COMMIT;

-- ----------------------------
-- Table structure for think_auth_group
-- ----------------------------
DROP TABLE IF EXISTS `think_auth_group`;
CREATE TABLE `think_auth_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(100) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `rules` char(80) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for think_auth_group_access
-- ----------------------------
DROP TABLE IF EXISTS `think_auth_group_access`;
CREATE TABLE `think_auth_group_access` (
  `uid` mediumint(8) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for think_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `think_auth_rule`;
CREATE TABLE `think_auth_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(80) NOT NULL DEFAULT '',
  `title` char(20) NOT NULL DEFAULT '',
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `condition` char(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

SET FOREIGN_KEY_CHECKS = 1;
