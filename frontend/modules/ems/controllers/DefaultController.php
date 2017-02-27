<?php

namespace frontend\modules\ems\controllers;

use yii\web\Controller;

use frontend\modules\ems\models\PersonCid;

/**
 * Default controller for the `ems` module
 */
class DefaultController extends Controller
{
    
    public function actionIndex()
    {
        $searchModel = new PersonCid();
       
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    
        ]);        
        
    }
}
