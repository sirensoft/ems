<?php
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
?>

<div class="panel panel-danger" style="margin-bottom: 10px">
    <div class="panel-heading">
        ค้นหาผ้ป่วยด้วยเลข 13 หลัก ชื่อ
    </div>  
    <div class="panel-body">

    <?php
    $form = ActiveForm::begin([
                'action' => ['/ems/default/index'],
                'method' => 'get',
    ]);
    ?>

    <div class="input-group">
        
        <?=  Html::textInput('search',$search, ['class'=>'form-control','placeholder'=>'เลข 13 หลัก'])?>
        <span class="input-group-btn">
            <button class="btn btn-default alignment" type="submit">
                <i class="glyphicon glyphicon-search"></i> ค้นหา
            </button>
        </span>
    </div>
    <?php ActiveForm::end(); ?>
    </div>
</div>




