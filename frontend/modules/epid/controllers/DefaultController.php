<?php

namespace frontend\modules\epid\controllers;

use yii\web\Controller;
use frontend\modules\epid\models\GisEms;
use frontend\modules\epid\models\Tsurveil;
use yii\data\ActiveDataProvider;
use frontend\modules\epid\models\TsurvielSearch;
use common\components\AppController;

class DefaultController extends AppController {

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex($disease=NULL) {
        $this->permitRole([1,2]);
        $searchModel = new TsurvielSearch('75','2016-10-01','2017-09-30');
        $searchModel->code506last = $disease;
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);        

        return $this->render('index', [
                    'searchModel'=>$searchModel,
                    'dataProvider' => $dataProvider,
                    'disease'=>$disease
        ]);
    }

}
