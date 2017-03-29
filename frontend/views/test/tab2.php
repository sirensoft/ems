<?php

use yii\bootstrap\Tabs;
$this->params['breadcrumbs'][] = "ค้นหากลุ่มเสี่ยงต่อการเกิดโรคหัวใจและหลอดเลือด";
echo Tabs::widget([
    'items' => [
        [
           'label' => 'one',
           'url' => ['test/tab'],
        ],
        [
            'label' => 'two',
            'active' => true,
            
        ],
    ]
]);
