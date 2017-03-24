<?php
namespace frontend\modules\ems\models;
use yii\base\Model;
use yii2mod\query\ArrayQuery;
use yii\data\ArrayDataProvider;

class PersonRisk extends Model {
    public $search,$CID, $NAME,$LNAME,$PNAME,$SEX,$DX,$RISKGROUP;
    
    
    
    public function rules() {
        return [
            [['CID', 'NAME','LNAME','PNAME','SEX','DX','RISKGROUP'], 'safe']
        ];
    }
    public function search($params = null) {
        $sql = "select * from ems_risk ";
       
        $models = \Yii::$app->db_hdc->createCommand($sql)->queryAll();
        $query = new ArrayQuery();
        $query->from($models);
      
        if ($this->load($params) && $this->validate()) {
             $query->andFilterWhere(['like', 'CID', $this->CID]);
               $query->andFilterWhere(['like', 'NAME', $this->NAME]);
             $query->andFilterWhere(['like', 'LNAME', $this->LNAME]);
             $query->andFilterWhere(['PNAME'=> $this->PNAME]);
             $query->andFilterWhere(['SEX'=> $this->SEX]);
             $query->andFilterWhere(['RISKGROUP'=> $this->RISKGROUP]);
             $query->andFilterWhere(['like','DX',$this->DX]);
             
            
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
