/*
Navicat MySQL Data Transfer

Source Server         : ftp2.plkhealth.go.th_3306
Source Server Version : 50505
Source Host           : ftp2.plkhealth.go.th:3306
Source Database       : ems

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-03-08 10:07:55
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ems_user
-- ----------------------------
DROP TABLE IF EXISTS `ems_user`;
CREATE TABLE `ems_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of ems_user
-- ----------------------------
INSERT INTO `ems_user` VALUES ('1', 'admin', 'gnHl7qU68t5gqnd3AaRaRNkIrRiaJWmQ', '$2y$13$tknmacmE71ZhfXmeN1uT4eoA.KsMBYFrowd5f2eWlARoLEmw0IK4e', null, 'admin@localhost.com', '10', '1488034856', '1488034856');
