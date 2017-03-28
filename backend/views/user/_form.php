<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

  

    <?= $form->field($model, 'password_hash')->textInput(['maxlength' => true]) ?>

  

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    

    <?= $form->field($model, 'role')->dropDownList([
        '1'=>'1-แพทย์/พยาบาล',
        '2'=>'2-พนักงานขับรถ',
        '9'=>'9-ผู้ดูแลระบบ'
    ]) ?>

    <?= $form->field($model, 'fullname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'officer')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'hospcode')->textInput(['maxlength' => true]) ?>

  

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
