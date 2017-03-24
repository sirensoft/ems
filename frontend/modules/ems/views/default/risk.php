<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
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
     
        [
            'attribute'=>'RISKGROUP',
            'format'=>'raw',
            'label'=>'ระดับ',
            'filter'=>FALSE,
            'value'=>function($model){
                if($model['RISKGROUP']=='5'){
                    return "อันตราย";
                }  else {
                    return "สูง";
                }
            },
            'contentOptions' => function($model){
                if($model['RISKGROUP']=='5'){
                 return ['style' => "color:white;background-color:red;",'class' => 'text-center'];
                }else{
                 return ['style' => "color:black;background-color:orange;",'class' => 'text-center'];   
                }
            }
        ],
        [
            'label'=>'',
            'format'=>'raw',
            'value'=>function($model){
                 $img = './images/map-marker-ok.png';  
                 $img2 = './images/map_ic.png'; 
                 $icon = Html::img($img, ['width'=>'32','height'=>'32']);
                 $icon2 = Html::img($img2, ['width'=>'30','height'=>'30']);    
                if(!empty($model['LAT']) or !empty($model['LON'])){
                    $lat = $model['LAT'];
                    $lon = $model['LON']; 
                    $name = $model['PNAME'].$model['NAME']." ".$model['LNAME']."(".$model['AGE']."ปี)";
                    return "<a href=# onclick=\"g_map($lat,$lon,'$name')\">$icon<a>";
                }
                 return $icon2;
            }
        ],
        [
            'attribute'=>'DX',
            'label'=>'วินิจฉัย',
            'contentOptions'=>[
                'class'=>'text-center'
            ]
        ],       
        'CID:text:เลขบัตร',
        //'PNAME:text:คำนำ',
        //'NAME:text:ชื่อ',
         [
             'attribute'=>'NAME',
             'label'=>'ชื่อ',
             'value'=>function($model){
                return $model['PNAME'].$model['NAME'];
             }
         ],
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
        'TMB:text:ตำบล','MOO:text:หมู่','HOUSE:text:บลท.'        
        //'DIS:ntext:โรค',
        
        /*[
             'attribute'=>'DIS',             
             'label'=>'โรค',
             'class' => 'kartik\grid\DataColumn',
            'noWrap' => false,
            //the line below has solved the issue
            'contentOptions' => ['style'=>'max-width: 30%; overflow: auto; word-wrap: break-word;']
             
         ],*/
        //'LAT','LON'
        
    ]
]);

?>
    </div>
</div>

<?php
$route_gmap = Url::toRoute(['/ems/default/gmap']);
$js = <<<JS
   function g_map(lat,lon,name){
         //console.log(lat+','+lon);
        var ll = lat+','+lon;
        var win = window.open('$route_gmap&lat='+lat+'&lon='+lon+'&name='+name, 'win', 'left=100,top=60,menubar=no,location=no,resizable=yes,width=820px,height=560px');
      
        }      
JS;
$this->registerJs($js,  yii\web\View::POS_HEAD);

