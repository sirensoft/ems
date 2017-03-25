<?php

namespace common\components;

class MyHelper extends \yii\base\Component {
    
    public static function getRole() {
        if (!\Yii::$app->user->isGuest) {
            return \Yii::$app->user->identity->role;
        } else {
            return "?";
        }
    }
}

