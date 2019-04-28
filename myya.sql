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

 Date: 28/04/2019 12:51:04
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
-- Table structure for myya_auth_group
-- ----------------------------
DROP TABLE IF EXISTS `myya_auth_group`;
CREATE TABLE `myya_auth_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(100) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `rules` char(80) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `title` (`title`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for myya_doctor
-- ----------------------------
DROP TABLE IF EXISTS `myya_doctor`;
CREATE TABLE `myya_doctor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL COMMENT '姓名',
  `experience` varchar(255) DEFAULT NULL COMMENT '个人经历',
  `scholastic` varchar(255) DEFAULT NULL COMMENT '学术成就',
  `honorary` varchar(255) DEFAULT NULL COMMENT '荣誉称号',
  `book` varchar(255) DEFAULT NULL COMMENT '著作',
  `good_at_disease` varchar(255) DEFAULT NULL COMMENT '擅长疾病',
  `img` varchar(255) DEFAULT NULL COMMENT '图片',
  `createTime` int(10) DEFAULT NULL,
  `updateTime` int(10) DEFAULT NULL,
  `deleteTime` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for myya_site_info
-- ----------------------------
DROP TABLE IF EXISTS `myya_site_info`;
CREATE TABLE `myya_site_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `type` varchar(20) DEFAULT 'other' COMMENT '类型',
  `description` varchar(255) DEFAULT NULL COMMENT '描述',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for myya_user
-- ----------------------------
DROP TABLE IF EXISTS `myya_user`;
CREATE TABLE `myya_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `nickname` varchar(50) DEFAULT NULL,
  `salt` int(4) DEFAULT NULL,
  `img` varchar(100) DEFAULT NULL,
  `createTime` int(10) DEFAULT NULL,
  `updateTime` int(10) DEFAULT NULL,
  `deleteTime` int(10) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for myya_ya
-- ----------------------------
DROP TABLE IF EXISTS `myya_ya`;
CREATE TABLE `myya_ya` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `patient_name` varchar(255) DEFAULT NULL,
  `patient_age` varchar(255) DEFAULT NULL,
  `patient_status` varchar(255) DEFAULT NULL,
  `patient_sex` varchar(255) DEFAULT NULL,
  `diagnose_first_time` int(11) DEFAULT NULL,
  `symptom` varchar(255) DEFAULT NULL,
  `medial_history` varchar(255) DEFAULT NULL,
  `carves_diagnosis` varchar(255) DEFAULT NULL,
  `tcm_diagnosis` varchar(255) DEFAULT NULL,
  `wes_diagnosis` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `usage` varchar(255) DEFAULT NULL,
  `therapeutic_principle_and_method` varchar(255) DEFAULT NULL,
  `prescription` varchar(255) DEFAULT NULL,
  `prescription_composition` varchar(255) DEFAULT NULL,
  `doctor_advice` varchar(255) DEFAULT NULL,
  `diagnosis_second` varchar(255) DEFAULT NULL,
  `diagnosis_second_recipe` varchar(255) DEFAULT NULL,
  `diagnosis_third` varchar(255) DEFAULT NULL,
  `diagnosis_third_recipe` varchar(255) DEFAULT NULL,
  `diagnosis_fourth` varchar(255) DEFAULT NULL,
  `diagnosis_fourth_recipe` varchar(255) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `imgs` varchar(255) DEFAULT NULL,
  `video` varchar(255) DEFAULT NULL,
  `source` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

SET FOREIGN_KEY_CHECKS = 1;
