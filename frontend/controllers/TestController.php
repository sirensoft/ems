<?php

namespace frontend\controllers;

class TestController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $this->layout = 'custom';
        return $this->render('index');
    }
    public function actionTab(){
        return $this->render('tab');
    }
    public function actionTab2(){
        return $this->render('tab2');
    }

}
