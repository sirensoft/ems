
<?php

use kartik\grid\GridView;
?>

<div class="row">
    <div class="col-md-6">
        <p class="text-green">วันที่รับบริการ : <?=$dateserv?> เวลา : <?=$timeserv?> </p>
    <p class="text-green">อาการสำคัญ : <?=$cc?></p>
    <p class="text-green">สัญญาณชีพ : BP = <?=$sbp.':'.$dbp.' ,T='.$btemp.' ,P='.$pr.' ,R='.$rr?></p>
    </div>
   
    <div class="col-md-6">
        <p> <?= 'หน่วยบริการ  :'.$hospcode.' '.$hospname?></p>
    </div>

</div>
<div class="row">
    <div class="col-lg-12">
    <?php
    $gridColumns = [
            [
            'attribute' => 'diagcode',
            'label' => 'รหัสโรค'
        ],
            [
            'attribute' => 'diagename',
            'label' => 'ชื่อโรค'
        ],
            [
            'attribute' => 'diagtype',
            'label' => 'ประเภทวินิจฉัย'
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
    </div>
</div>