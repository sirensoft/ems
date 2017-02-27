<?php

namespace frontend\modules\ems\controllers;

use yii\web\Controller;

/**
 * Default controller for the `ems` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex($search=NULL)
    {
        return $this->render('index',[
            'search'=>$search
        ]);
    }
}
