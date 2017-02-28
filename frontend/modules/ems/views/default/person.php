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
use yii\widgets\ActiveForm;




?>
<div class="panel panel-info" >

    <div class="panel-body">

        <?php
        $form = ActiveForm::begin([
                    'action' => ['/ems/default/index'],
                    'method' => 'get',
        ]);
        ?>

        <div class="input-group">

            <?= $form->field($searchModel, 'search')->textInput(['placeholder' => 'เลขบัตร/ชื่อ/นามสกุล'])->label(FALSE) ?>
            <span class="input-group-btn">
                <button class="btn btn-default alignment" type="submit">
                    <i class="glyphicon glyphicon-search"></i> ค้นหา
                </button>
            </span>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>



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
                
            ]
        ]);
        ?>
    </div>

</div>




