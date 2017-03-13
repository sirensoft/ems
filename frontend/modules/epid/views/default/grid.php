 <div class="grid">
    <?php
    use yii\helpers\ArrayHelper;
    use kartik\grid\GridView;
    use yii\helpers\Html;
    /*$sql = "SELECT t.code506last id,concat(t.code506last,'-',t.groupname506) val FROM t_surveil t GROUP BY t.code506last";
    $raw = \Yii::$app->db_hdc->createCommand($sql)->queryAll();
    $items =  ArrayHelper::map($raw, 'id', 'val');*/
    echo GridView::widget([
        'panel'=>[
            'before'=>''
        ],
	'responsiveWrap' => false,
        'dataProvider'=>$dataProvider,
        'filterModel'=>$searchModel,
        'columns'=>[
            ['class' => 'yii\grid\SerialColumn'],
            //'hospcode',
            //'pid',
            
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
                        return "<a href=# onclick=\"g_map($lat,$lon)\">$icon<a>";
                    }
                     return $icon2;
                }
            ],
            [
                'attribute'=>'code506last',
                'label'=>'โรค',
                'filter'=>FALSE,
                'value'=>function($model){
                    return $model->code506last."-".$model->groupname506;
                }
            ],
            'fname:text:ชื่อ',
            'lname:text:นามสกุล',
            'illdate:date:ป่วย',
           
            
            'LAT','LON',
             'ill_areacode:text:รหัสพื้นที่',
            
            //'groupname506:text:ชื่อโรค'
        ]
    ]);
    ?>
    </div>