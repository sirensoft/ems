<?php
$this->title = "ค้นหา";
$this->params['breadcrumbs'][] = "ค้นหาผู้ป่วย";

use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\tabs\TabsX;
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

            <?= $form->field($searchModel, 'search')->textInput(['placeholder' => '13หลัก/ชื่อ/นามสกุล'])->label(FALSE) ?>
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
            'label' => 'รายชื่อ',
            'content' => $this->render('person', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]),
        ],
        [
            'label' => 'แผนที่',
            'content' => $this->render('map', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]),
        ]
    ]
]);
