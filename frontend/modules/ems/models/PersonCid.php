<?php
namespace frontend\modules\ems\models;
use yii\base\Model;
use yii2mod\query\ArrayQuery;
use yii\data\ArrayDataProvider;

class PersonCid extends Model {
    public $search,$CID, $NAME,$LNAME,$PNAME;
    
    public function rules() {
        return [
            [['CID', 'NAME','LNAME','PNAME'], 'safe']
        ];
    }
    public function search($params = null) {
        $sql = " select  'null' limit 0";
        if (!empty($params['PersonCid']['search'])) {
            $search = $params['PersonCid']['search'];           
            
            $sql = "SELECT cp.prename PNAME,p.*,h.CHANGWAT,h.AMPUR,h.TAMBON,h.VILLAGE,h.HOUSE,h.LATITUDE,h.LONGITUDE FROM t_person_cid p
LEFT JOIN home h ON p.HOSPCODE = h.HOSPCODE AND p.HID = h.HID
LEFT JOIN cprename cp ON cp.id_prename = p.PRENAME
WHERE  (p.CID  LIKE '%$search%' OR p.`NAME` LIKE '%$search%'  OR p.LNAME LIKE '%$search%'  
or CONCAT(p.`NAME`,' ',p.LNAME) LIKE '%$search%' ) LIMIT 25 ";
        }
        $models = \Yii::$app->db_hdc->createCommand($sql)->queryAll();
        $query = new ArrayQuery();
        $query->from($models);
        if ($this->load($params) && $this->validate()) {
             $query->andFilterWhere(['like', 'CID', $this->CID]);
            $query->andFilterWhere(['like', 'NAME', $this->NAME]);
             $query->andFilterWhere(['like', 'LNAME', $this->LNAME]);
             $query->andFilterWhere(['PNAME'=> $this->PNAME]);
            
        }
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
