
<?php

use kartik\grid\GridView;
?>

<?php

$gridColumns = [
       [
            'attribute' => 'labtest',
            'label' => 'รหัส'
        ],
            [
            'attribute' => 'tlname',
            'label' => 'รายการ'
        ],
            [
            'attribute' => 'labresult',
            'label' => 'Result'
        ],
];

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'responsiveWrap' => false,
    //'filterModel' => $searchModel,
    'autoXlFormat' => true,
    'export' => [
        'fontAwesome' => true,
        'showConfirmAlert' => false,
        'target' => GridView::TARGET_BLANK
    ],
    'columns' => $gridColumns,
    'resizableColumns' => true,
        //'resizeStorageKey' => Yii::$app->user->id . '-' . date("m"),
]);
?>