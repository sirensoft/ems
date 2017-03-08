<?php

use common\components\MyHelper;

$this->title = "รายละเอียด";
$this->params['breadcrumbs'][] = "รายละเอียด";

use yii\widgets\ListView;
use yii\widgets\DetailView;


echo ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_item',
    'layout' => '{items}'
]);

/*
echo "<hr>";
$model = $dataProvider->getModels();
echo DetailView::widget([
    'model'=>$model[0]
]);*/


