<?php

use yii2mod\query\ArrayQuery;
use yii\data\ArrayDataProvider;
use kartik\grid\GridView;

$sql = " SELECT p.CID,GROUP_CONCAT(DISTINCT p.diagcode) DX FROM t_diag_opd p 
INNER JOIN t_person_cid pn on pn.CID = p.CID 
AND pn.DISCHARGE = 9 AND LEFT(pn.check_vhid,2) = 65

WHERE p.diagcode in (
SELECT t.diagcode from c_ems_disease t 
WHERE t.ems = 1 AND t.diagcode NOT BETWEEN 'I10' AND 'I15' 
)  AND p.CID <> '' AND p.CID IS NOT NULL
 
GROUP BY p.CID ";

 $raw = \Yii::$app->db_hdc->createCommand($sql)->queryAll();
 $dataProvider = new ArrayDataProvider([
     'allModels'=>$raw,
     'pagination' => [
                'pageSize' => 25
            ]
 ]);
 
 echo GridView::widget([
     'dataProvider'=>$dataProvider
 ]);



