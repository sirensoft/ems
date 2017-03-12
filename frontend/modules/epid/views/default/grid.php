 <div class="grid">
    <?php
    use yii\helpers\ArrayHelper;
    use kartik\grid\GridView;
    $sql = "SELECT t.code506last id,concat(t.code506last,'-',t.groupname506) val FROM t_surveil t GROUP BY t.code506last";
    $raw = \Yii::$app->db_hdc->createCommand($sql)->queryAll();
    $items =  ArrayHelper::map($raw, 'id', 'val');
    echo GridView::widget([
        'panel'=>[
            'before'=>''
        ],
	'responsiveWrap' => false,
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
                'filter'=>FALSE,
                'value'=>function($model){
                    return $model->code506last."-".$model->groupname506;
                }
            ],
            
            //'groupname506:text:ชื่อโรค'
        ]
    ]);
    ?>
    </div>