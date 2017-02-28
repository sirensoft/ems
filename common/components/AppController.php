<?php

namespace common\components;


class AppController extends \yii\web\Controller {

    public function init() {
        parent::init();
    }
    
   

    protected function overclock($memory = '2048M') {
        //ini_set('max_execution_time', 15 * 60);
        set_time_limit(0);
        ini_set('memory_limit', $memory);
    }

    protected function exec_sql($sql,$con) {
        $affect_row = $con->createCommand($sql)->execute();
        return $affect_row;
    }

    protected function doLogin() {
        if (\Yii::$app->user->isGuest) {
            $this->redirect(['site/login']);
        }
    }

    protected function getRole() {
        if (!\Yii::$app->user->isGuest) {
            return \Yii::$app->user->identity->role;
        } else {
            return "?";
        }
    }

    public function permitRole($role = []) {

        $r = $this->getRole();

        if (empty($role)) {
            throw new \yii\web\ForbiddenHttpException("ไม่ได้รับอนุญาต");
        }
        if (!in_array($r, $role)) {
            throw new \yii\web\ForbiddenHttpException("ไม่ได้รับอนุญาต");
        }
      
        
        
    }

    
    protected function query_all($sql,$con){
        return $con->createCommand($sql)->queryAll();
    }

}
