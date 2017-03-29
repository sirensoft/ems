<?php

namespace frontend\modules\ems\controllers;

use yii\web\Controller;
use frontend\modules\ems\models\PersonCid;
use frontend\modules\ems\models\PersonList;
use frontend\modules\ems\models\PersonView;
use frontend\modules\ems\models\PersonRisk;
use common\components\AppController;

/**
 * Default controller for the `ems` module
 */
class DefaultController extends AppController {

    public function actionIndex() {
        $this->permitRole([1,2]);
        $searchModel = new PersonCid();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        $personList = new PersonList(1);
        //$personList->DGROUP = 1;
        $dataProviderList = $personList->search(\Yii::$app->request->queryParams);

        $personRisk = new PersonRisk();
        $dataProviderRisk = $personRisk->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'personList' => $personList,
                    'dataProviderList' => $dataProviderList,
                    'personRisk'=>$personRisk,
                    'dataProviderRisk'=>$dataProviderRisk
        ]);
    }
    
  

    public function actionView($cid = null) {
        $searchModel = new PersonView();
        $dataProvider = $searchModel->search($cid);
        return $this->render('view', [
                    'dataProvider' => $dataProvider
        ]);
    }

    public function actionGmap($lat, $lon, $name) {
        $this->layout = 'custom';
        return $this->render('gmap', [
                    'lat' => $lat,
                    'lon' => $lon,
                    'name' => $name
        ]);
    }

}
