/*
Navicat MySQL Data Transfer

Source Server         : แม่กลอง
Source Server Version : 50531
Source Host           : 127.0.0.1:3306
Source Database       : ems

Target Server Type    : MYSQL
Target Server Version : 50531
File Encoding         : 65001

Date: 2017-03-25 08:39:16
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
  `role` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fullname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `officer` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hospcode` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `last_login` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of ems_user
-- ----------------------------
INSERT INTO `ems_user` VALUES ('1', 'med', 'gnHl7qU68t5gqnd3AaRaRNkIrRiaJWmQ', '$2y$13$tknmacmE71ZhfXmeN1uT4eoA.KsMBYFrowd5f2eWlARoLEmw0IK4e', null, 'admin@localhost.com', '10', '1', null, null, null, '1488034856', '1488034856', null);
INSERT INTO `ems_user` VALUES ('3', 'driver', 'xUh44aNPZZwDPfstE4yuS7uds9N8OsYe', '$2y$13$ta9ZK3ESjKy1Ol80G49RdupoR1Y0txd15cD6iwm.YG93MxS4amI9e', null, 'drive@local.com', '10', '2', null, null, null, '1490405059', '1490405059', null);

-- ----------------------------
-- Procedure structure for ems_all
-- ----------------------------
DROP PROCEDURE IF EXISTS `ems_all`;
DELIMITER ;;
CREATE DEFINER=`ems`@`127.0.0.1` PROCEDURE `ems_all`()
BEGIN
	CALL ems_home;
	CALL ems_person;
	CALL ems_risk;

END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for ems_home
-- ----------------------------
DROP PROCEDURE IF EXISTS `ems_home`;
DELIMITER ;;
CREATE DEFINER=`ems`@`127.0.0.1` PROCEDURE `ems_home`()
BEGIN
	
DROP TABLE ems_home;
CREATE TABLE ems_home(
	SELECT * FROM home
);

UPDATE ems_home t ,home c 
SET t.LATITUDE = c.LONGITUDE,t.LONGITUDE = c.LATITUDE
WHERE t.LATITUDE > t.LONGITUDE
AND (t.HOSPCODE = c.HOSPCODE AND t.HID = c.HID);

END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for ems_person
-- ----------------------------
DROP PROCEDURE IF EXISTS `ems_person`;
DELIMITER ;;
CREATE DEFINER=`root`@`127.0.0.1` PROCEDURE `ems_person`()
BEGIN
	
DROP TABLE IF EXISTS ems_person;
CREATE TABLE ems_person (
SELECT p.CID,cprename.prename PNAME,pn.`NAME`,pn.LNAME,pn.SEX,pn.age_y AGE
,p.mix_dx DX 
,pn.check_vhid,cw.changwatname PROV,ca.ampurname AMP,ct.tambonname TMB
,RIGHT(pn.check_vhid,2) MOO ,h.HOUSE,h.LATITUDE LAT,h.LONGITUDE LON
,'g' as DGROUP

FROM t_cvd_ill p 
INNER JOIN t_person_cid pn on pn.CID = p.CID 
AND pn.DISCHARGE = 9 AND LEFT(pn.check_vhid,2) = (SELECT prov FROM sys_ems_config LIMIT 1)

LEFT JOIN cchangwat cw on cw.changwatcode = LEFT(pn.check_vhid,2)
LEFT JOIN campur ca on ca.ampurcodefull = LEFT(pn.check_vhid,4)
LEFT JOIN ctambon ct on ct.tamboncodefull = LEFT(pn.check_vhid,6)
LEFT JOIN ems_home h ON h.HOSPCODE = pn.HOSPCODE AND h.HID = pn.HID

LEFT JOIN cprename ON cprename.id_prename = pn.PRENAME



 
GROUP BY p.CID 
);

UPDATE ems_person t SET t.DGROUP = '1';

UPDATE ems_person t SET t.DGROUP = NULL
WHERE t.DGROUP NOT IN (1,2,3,4,5);

END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for ems_risk
-- ----------------------------
DROP PROCEDURE IF EXISTS `ems_risk`;
DELIMITER ;;
CREATE DEFINER=`ems`@`127.0.0.1` PROCEDURE `ems_risk`()
BEGIN
	
DROP TABLE IF EXISTS ems_risk;
CREATE TABLE ems_risk (
SELECT p.CID,cprename.prename PNAME,pn.`NAME`,pn.LNAME,pn.SEX,pn.age_y AGE
,p.mix_dx DX 
,pn.check_vhid,cw.changwatname PROV,ca.ampurname AMP,ct.tambonname TMB
,RIGHT(pn.check_vhid,2) MOO ,h.HOUSE,h.LATITUDE LAT,h.LONGITUDE LON
,p.L_RISK_SCORE  'SCORE'
,IF(p.L_RISK_SCORE >=40 ,5,4) RISKGROUP

FROM t_cvdrisk_fl p 
INNER JOIN t_person_cid pn on pn.CID = p.CID 
AND pn.DISCHARGE = 9 AND LEFT(pn.check_vhid,2) = (SELECT prov FROM sys_ems_config LIMIT 1)

LEFT JOIN cchangwat cw on cw.changwatcode = LEFT(pn.check_vhid,2)
LEFT JOIN campur ca on ca.ampurcodefull = LEFT(pn.check_vhid,4)
LEFT JOIN ctambon ct on ct.tamboncodefull = LEFT(pn.check_vhid,6)
LEFT JOIN ems_home h ON h.HOSPCODE = pn.HOSPCODE AND h.HID = pn.HID

LEFT JOIN cprename ON cprename.id_prename = pn.PRENAME

WHERE p.L_RISK_SCORE >=30

 
GROUP BY p.CID 
);



END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for t_surveil_ems
-- ----------------------------
DROP PROCEDURE IF EXISTS `t_surveil_ems`;
DELIMITER ;;
CREATE DEFINER=`ems`@`127.0.0.1` PROCEDURE `t_surveil_ems`()
BEGIN
	DROP TABLE if EXISTS t_surveil_ems;
CREATE TABLE t_surveil_ems (
SELECT t.*,h.LATITUDE LAT,h.LONGITUDE LON FROM t_surveil t LEFT JOIN home h
ON t.hospcode = h.HOSPCODE AND t.ill_areacode = CONCAT(h.CHANGWAT,h.AMPUR,h.TAMBON,h.VILLAGE)
AND t.illhouse = h.HOUSE
);

END
;;
DELIMITER ;

-- ----------------------------
-- Event structure for ems_event
-- ----------------------------
DROP EVENT IF EXISTS `ems_event`;
DELIMITER ;;
CREATE DEFINER=`ems`@`127.0.0.1` EVENT `ems_event` ON SCHEDULE EVERY 1 DAY STARTS '2017-03-23 06:31:52' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN

call ems_all;


END
;;
DELIMITER ;
