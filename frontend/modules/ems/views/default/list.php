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
            'class' => 'yii\grid\SerialColumn',
        ],
        [
            'label'=>' ',
            'format' => 'raw',
            'value' => function($model) {
                return Html::a('<i class="glyphicon glyphicon-zoom-in"></i>', ['/ems/default/view', 'cid' =>$model['CID']]);
            },
            'filter'=>FALSE
        ],
        'CID',
        'PNAME:text:คำนำหน้า',
        'NAME:text:ชื่อ',
        'LNAME:text:นามสกุล',
        'SEX:text:เพศ',
        'AGE:integer:อายุ(ปี)',
        'DIS:ntext:โรค',
        'LAT','LON'
        
    ]
]);

?>
    </div>
</div>

