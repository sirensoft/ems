<?php

namespace frontend\modules\ems\models;

use yii\base\Model;
use yii2mod\query\ArrayQuery;
use yii\data\ArrayDataProvider;

class PersonView extends Model {

    //public $CID;

    public function rules() {
        return [
            
        ];
    }

    public function search($cid=null) {
        $sql = "SELECT t.CID,cprename.prename PNAME,t.`NAME`,t.LNAME,t.SEX
,t.BIRTH,t.age_y AGE,cw.changwatname PROV,ca.ampurname AMP,ct.tambonname TMB
,RIGHT(t.check_vhid,2) MOO ,h.HOUSE,h.LATITUDE LAT,h.LONGITUDE LON

FROM t_person_cid t 
LEFT JOIN cchangwat cw on cw.changwatcode = LEFT(t.check_vhid,2)
LEFT JOIN campur ca on ca.ampurcodefull = LEFT(t.check_vhid,4)
LEFT JOIN ctambon ct on ct.tamboncodefull = LEFT(t.check_vhid,6)
LEFT JOIN ems_home h ON h.HOSPCODE = t.HOSPCODE AND h.HID = t.HID

LEFT JOIN cprename ON cprename.id_prename = t.PRENAME  WHERE t.CID = '$cid'";

        $models = \Yii::$app->db_hdc->createCommand($sql)->queryAll();
        $query = new ArrayQuery();
        $query->from($models);
        //$query->andFilterWhere(['CID' => $this->CID]);

        $all_models = $query->all();
        if (!empty($all_models[0])) {
            $cols = array_keys($all_models[0]);
        }
        return new ArrayDataProvider([
            'allModels' => $all_models,
            //'totalItems'=>100,
            'sort' => !empty($cols) ? ['attributes' => $cols] : FALSE,
            'pagination' => [
                'pageSize' => 25
            ]
        ]);
    }

//search
    public function attributeLabels() {
        return [
        ];
    }

}
