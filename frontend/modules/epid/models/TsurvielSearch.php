<?php

namespace frontend\modules\epid\models;


use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\epid\models\Tsurveil;

class TsurvielSearch extends Tsurveil {
    public function rules()
    {
        return [           
            [['hospcode','fname','lname','code506last'], 'safe'],
        ];
    }
     /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }
    
 
    public function search($params){
        $query = Tsurveil::find();
        $query->andWhere(['like','ill_areacode','75']);
       
        $dataProvider = new ActiveDataProvider([
            'query' => $query
           
        ]);
        $this->load($params);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
   
        $query->andFilterWhere([
            'hospcode'=>  $this->hospcode,
            'code506last'=>  $this->code506last
        ]);
        $query->andFilterWhere(['like', 'fname', $this->fname])
            ->andFilterWhere(['like', 'lname', $this->lname]);
           
        return $dataProvider;
    }
    
}
