<?php

use kartik\grid\GridView;
use yii\helpers\Html;
?>
<div class="panel panel-default">
    
    <div class="panel-body">
<?php
echo GridView::widget([
    'responsiveWrap' => false,
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        
        [
            'format'=>'raw',
            
            
            'label'=>'#',
            'value'=>function($model){
                $img = './images/men.png';
                if($model['SEX']=='2')$img='./images/women.png';
                $link = Html::img($img, ['width'=>'30','height'=>'30']);
                return Html::a($link, ['/ems/default/view', 'cid' =>$model['CID']]);
            }
        ],
        //'DGROUP',
        [
            'attribute'=>'DGROUP',
            'format'=>'raw',
            'label'=>'กลุ่ม',
            'filter'=>['1'=>'CVD'],
            'value'=>function($model){                
                $img_cvd = './images/heart.png';               
                $icon = Html::img($img_cvd, ['width'=>'30','height'=>'30']);
                
                if($model['DGROUP']=='1'){
                    return $icon;
                }
            }
        ],
      
        'CID',
        'PNAME:text:คำนำ',
        'NAME:text:ชื่อ',
        'LNAME:text:นามสกุล',
        //'SEX:text:เพศ',
        [
            'attribute'=>'SEX',
            'label'=>'เพศ',
            'filter'=>['1'=>'ชาย','2'=>'หญิง'],
            'value'=>function($model){
                $sex = "หญิง";
                if($model['SEX']=='1'){
                    $sex = 'ชาย';
                }
                return $sex;
            }
        ],
        'AGE:integer:อายุ(ปี)',
        //'DIS:ntext:โรค',
         [
             'attribute'=>'DIS',             
             'label'=>'โรค',
             'class' => 'kartik\grid\DataColumn',
            'noWrap' => false,
            //the line below has solved the issue
            'contentOptions' => ['style'=>'max-width: 30%; overflow: auto; word-wrap: break-word;']
             
         ],
        //'LAT','LON'
        
    ]
]);

?>
    </div>
</div>

