<?php
$this->title = "ค้นหา";
$this->params['breadcrumbs'][] = "ค้นหาผู้ป่วย";

use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\tabs\TabsX;
use yii\helpers\Html;
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

<?php
echo TabsX::widget([
    'items' => [
        [
            'label' => 'รายชื่อค้นหา',
            'content' => $this->render('person', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]),
        ],
        [
            'label' => 'รายชื่อทะเบียน',
            'content' => '',
        ]
    ]
]);
?>
<div id="map" style="height: 450px"></div>

<?php

$this->registerJsFile('//maps.googleapis.com/maps/api/js?key=AIzaSyDtrQxIgZGCXrChaNgCc0yCFCAyTFEmHU8', [
    'async' => TRUE,
    'defer' => TRUE,
    'position' => \yii\web\View::POS_BEGIN
    ]);
?>

<?php
$js =<<<JS
  

       var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 16, lng: 100},
          zoom: 8
        });
        var myLatLng = {lat: 16, lng: 100};
        
        var marker = new google.maps.Marker({
          position: myLatLng,
          map: map,
          title: 'Hello World!',
          draggable: true,
        });
   

      
      
        
          
        
      
JS;
$this->registerJs($js);

?>

