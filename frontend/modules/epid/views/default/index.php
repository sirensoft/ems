<?php
$this->title = "EPID";
$this->params['breadcrumbs'][] = "ข้อมูลโรคทางระบาดวิทยา";
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
?>
<div class="epid-default-index">
    <?php
    $sql = "SELECT t.code506last id,concat(t.code506last,'-',t.groupname506) val FROM t_surveil t GROUP BY t.code506last";
    $raw = \Yii::$app->db_hdc->createCommand($sql)->queryAll();
    $items =  ArrayHelper::map($raw, 'id', 'val');
    echo GridView::widget([
        'panel'=>[
            'before'=>''
        ],
        'dataProvider'=>$dataProvider,
        'filterModel'=>$searchModel,
        'columns'=>[
            'hospcode',
            'pid',
            'fname',
            'lname',
            'illdate',
            'ill_areacode',
            [
                'attribute'=>'code506last',
                'label'=>'โรค',
                'filter'=>$items,
                'value'=>function($model){
                    return $model->code506last."-".$model->groupname506;
                }
            ],
            
            //'groupname506:text:ชื่อโรค'
        ]
    ]);
    ?>
</div>
