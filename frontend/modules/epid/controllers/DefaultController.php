<?php

namespace frontend\modules\epid\controllers;

use yii\web\Controller;
use frontend\modules\epid\models\GisEms;
use frontend\modules\epid\models\Tsurveil;
use yii\data\ActiveDataProvider;
use frontend\modules\epid\models\TsurvielSearch;

class DefaultController extends Controller {

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex($disease=NULL) {
        
        $searchModel = new TsurvielSearch('75','2016-10-01','2017-09-30');
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);        

        return $this->render('index', [
                    'searchModel'=>$searchModel,
                    'dataProvider' => $dataProvider,
                    'disease'=>$disease
        ]);
    }

}
