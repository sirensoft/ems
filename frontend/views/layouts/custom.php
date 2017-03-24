<?php

use yii\helpers\Html;
use frontend\assets\CustomAsset;

/* @var $this \yii\web\View */
/* @var $content string */
CustomAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
            /* Always set the map height explicitly to define the size of the div
             * element that contains the map. */
            #map {
                height: 100%;
                //margin: 10px;
            }
            /* Optional: Makes the sample page fill the window. */
            html, body {
                height: 100%;
                margin: 0;
                padding: 0;
            }
        </style>


        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
            <?php $this->beginBody() ?>
        
        <?= $content ?>
       

<?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>