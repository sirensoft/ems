<?php
$this->title = "ค้นหา";
$this->params['breadcrumbs'][] = "ค้นหาผู้ป่วย";

use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\tabs\TabsX;
use yii\helpers\Html;
?>


<?php
echo TabsX::widget([
    'items' => [
        [
            'label' => 'รายชื่อทะเบียน',
            'content' => $this->render('list',[
                'searchModel' => $personList,
                'dataProvider' => $dataProviderList,
            ]),
            'active'=>  !isset($_GET['PersonCid']['search'])
            
        ],
        [
            'label' => 'รายชื่อค้นหา',
            'content' => $this->render('person', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]),
            'active'=>  isset($_GET['PersonCid']['search'])
            
        ],
        
    ]
]);
?>



