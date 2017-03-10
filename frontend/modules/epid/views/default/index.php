<?php
$this->title = "EPID";
$this->params['breadcrumbs'][] = "ข้อมูลโรคทางระบาดวิทยา";
use kartik\grid\GridView;
?>
<div class="epid-default-index">
    <?php
    
    echo GridView::widget([
        'panel'=>[
            'before'=>''
        ],
        'dataProvider'=>$dataProvider,
        'filterModel'=>$searchModel,
        'columns'=>[
            'hospcode',
            'pid',
            'fname',
            'lname',
            'illdate',
            'ill_areacode',
            'code506last:text:รหัสโรค',
            'groupname506:text:ชื่อโรค'
        ]
    ]);
    ?>
</div>
