/*
Navicat MySQL Data Transfer

Source Server         : แม่กลอง
Source Server Version : 50531
Source Host           : 127.0.0.1:3306
Source Database       : ems

Target Server Type    : MYSQL
Target Server Version : 50531
File Encoding         : 65001

Date: 2017-03-22 18:57:26
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

-- ----------------------------
-- Procedure structure for ems_all
-- ----------------------------
DROP PROCEDURE IF EXISTS `ems_all`;
DELIMITER ;;
CREATE DEFINER=`ems`@`127.0.0.1` PROCEDURE `ems_all`()
BEGIN
	CALL ems_home;
	CALL ems_person;

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
,GROUP_CONCAT(DISTINCT p.diagcode) DX ,GROUP_CONCAT(DISTINCT cicd10tm.diagtname) DIS
,pn.check_vhid,cw.changwatname PROV,ca.ampurname AMP,ct.tambonname TMB
,RIGHT(pn.check_vhid,2) MOO ,h.HOUSE,h.LATITUDE LAT,h.LONGITUDE LON
,'g' as DGROUP

FROM t_diag_opd p 
INNER JOIN t_person_cid pn on pn.CID = p.CID 
AND pn.DISCHARGE = 9 AND LEFT(pn.check_vhid,2) = (SELECT prov FROM sys_ems_config LIMIT 1)

LEFT JOIN cchangwat cw on cw.changwatcode = LEFT(pn.check_vhid,2)
LEFT JOIN campur ca on ca.ampurcodefull = LEFT(pn.check_vhid,4)
LEFT JOIN ctambon ct on ct.tamboncodefull = LEFT(pn.check_vhid,6)
LEFT JOIN ems_home h ON h.HOSPCODE = pn.HOSPCODE AND h.HID = pn.HID

LEFT JOIN cprename ON cprename.id_prename = pn.PRENAME
LEFT JOIN cicd10tm ON cicd10tm.diagcode = p.diagcode

WHERE p.diagcode in (
	SELECT t.diagcode from c_ems_disease t 
	WHERE t.ems = 1 AND t.diagcode NOT BETWEEN 'I10' AND 'I15' 
)  AND p.CID <> '' AND p.CID IS NOT NULL
 
GROUP BY p.CID 
);

UPDATE ems_person t SET t.DGROUP = '1'
WHERE t.DX LIKE '%I6%';

UPDATE ems_person t SET t.DGROUP = NULL
WHERE t.DGROUP NOT IN (1,2,3,4,5);

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
