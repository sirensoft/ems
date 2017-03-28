<?php
$this->title = "CVD";


use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\tabs\TabsX;
use yii\helpers\Html;
?>


<?php
echo TabsX::widget([
    'items' => [
        [
            'label'=>'กลุ่มเสี่ยง',
            'content' => $this->render('risk',[
                'searchModel' => $personRisk,
                'dataProvider' => $dataProviderRisk,
            ]),
            
        ],
        [
            'label' => 'กลุ่มป่วย',
            'content' => $this->render('list',[
                'searchModel' => $personList,
                'dataProvider' => $dataProviderList,
            ]),
            //'active'=>  !isset($_GET['PersonCid']['search'])
            
        ],
        
        [
            'label' => 'ค้นหา',
            'content' => $this->render('person', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]),
            'active'=>  isset($_GET['PersonCid']['search'])
            
        ],
        
    ]
]);
?>

<?php

$js = <<<JS
        
JS;


