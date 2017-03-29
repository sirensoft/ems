<?php
$this->title = "CVD";


use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\tabs\TabsX;
use yii\helpers\Html;

$title_cvd = "ค้นหากลุ่มเสี่ยงต่อการเกิดโรคหัวใจและหลอดเลือด";
if(isset($_GET['PersonCid']['search'])){
  $title_cvd =  "ค้นหาจากฐานข้อมูล";
}


?>

<ul class="breadcrumb">
    <li>
        <a href="/ems/frontend/web/index.php">หน้าหลัก</a>
    </li>
    <li class="active" id="title-cvd"><?=$title_cvd?></li>
</ul>


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
     
$(function() {
   $('a[data-toggle]').on('click',function(e){
        var title ='';
        var txt = $(e.target).text();
        if(txt=='กลุ่มเสี่ยง'){
            title = 'ค้นหากลุ่มเสี่ยงต่อการเกิดโรคหัวใจและหลอดเลือด';
        }
        if(txt=='กลุ่มป่วย'){
            title = 'ข้อมูลผู้ป่วยโรคหัวใจและหลอดเลือด';
        }
        if(txt=='ค้นหา'){
            title = 'ค้นหาจากฐานข้อมูล'
        }
        console.log(txt);
        $("#title-cvd").text(title);
   }); 
});
JS;
 $this->registerJs($js, yii\web\View::POS_END);  


