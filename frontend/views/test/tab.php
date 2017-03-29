<?php

use yii\bootstrap\Tabs;
$this->params['breadcrumbs'][] = "ค้นหากลุ่มเสี่ยงต่อการเกิดโรคหัวใจและหลอดเลือด1111";
echo Tabs::widget([
    'items' => [
        [
            'label' => 'one',
            'content' => $this->render('_tab',[
                'data'=>'ทดสอบ.....'
            ]),
            'active' => true,
            
        ],
        [
            'label' => 'two',
            'url' => ['test/tab2'],
        ],
    ]
]);
