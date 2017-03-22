<?php

namespace frontend\modules\ems\controllers;

use yii\web\Controller;

use frontend\modules\ems\models\PersonCid;
use frontend\modules\ems\models\PersonList;
use frontend\modules\ems\models\PersonView;

/**
 * Default controller for the `ems` module
 */
class DefaultController extends Controller
{
    
    public function actionIndex()
    {
        $searchModel = new PersonCid();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        
        $personList = new PersonList(1);
        //$personList->DGROUP = 1;
         $dataProviderList = $personList->search(\Yii::$app->request->queryParams);
        
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'personList'=>$personList,
                    'dataProviderList'=>$dataProviderList
                    
        ]);        
        
    }
    public function actionView($cid=null){
        $searchModel = new PersonView();
        $dataProvider = $searchModel->search($cid);
        return $this->render('view',[
            'dataProvider'=>$dataProvider
        ]);
    }
}
