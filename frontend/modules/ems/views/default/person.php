<?php


$css = <<< CSS
.alignment
{
    margin-top:10px;
}
CSS;
$this->registerCss($css);

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
                'CID:text:เลข13หลัก',
                'PNAME:text:คำนำหน้า',
                'NAME:text:ชื่อ',
                'LNAME:text:นามสกุล',
                [
                    'attribute'=>'SEX',
                    'label'=>'เพศ',
                     'value'=>function($model){
                        $sex='หญิง';
                        if($model['SEX']==1)$sex='ชาย';
                        return $sex;
                     }
                ],
                'age_y:integer:อายุ(ปี)',
                [
                'label'=>' ',
                'format' => 'raw',
                'value' => function($model) {
                   return Html::a('<i class="glyphicon glyphicon-zoom-in"></i>', ['/ems/default/view', 'cid' =>$model['CID']]);
                },
                'filter'=>FALSE
        ],
            ]
        ]);
        ?>
    </div>

</div>




