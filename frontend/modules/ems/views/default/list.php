<?php

use yii2mod\query\ArrayQuery;
use yii\data\ArrayDataProvider;
use kartik\grid\GridView;

$sql = " SELECT * from ems_person ";

 $raw = \Yii::$app->db_hdc->createCommand($sql)->queryAll();
 $dataProvider = new ArrayDataProvider([
     'allModels'=>$raw,
     'pagination' => [
                'pageSize' => 25
            ]
 ]);
 
 echo GridView::widget([
     'responsiveWrap' => false,
     'dataProvider'=>$dataProvider
 ]);



