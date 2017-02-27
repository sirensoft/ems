<?php

use common\components\MyHelper;

$this->title = "รายละเอียด";
$this->params['breadcrumbs'][] = "รายละเอียด";

use yii\widgets\ListView;


echo ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_item',
    'layout' => '{items}'
]);



