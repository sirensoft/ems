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
LEFT JOIN home h ON h.HOSPCODE = pn.HOSPCODE AND h.HID = pn.HID

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