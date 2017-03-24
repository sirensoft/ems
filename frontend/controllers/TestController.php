<?php

namespace frontend\controllers;

class TestController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $this->layout = 'custom';
        return $this->render('index');
    }

}
