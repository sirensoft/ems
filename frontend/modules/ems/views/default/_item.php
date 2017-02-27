

<?php

use kartik\tabs\TabsX;
use yii\helpers\Html;
?>  
<button class="btn btn-success" id="btn_map"><i class="glyphicon glyphicon-map-marker"></i> เส้นทาง</button>
<button class="btn btn-danger" id="btn_pt"><i class="glyphicon glyphicon-alert"></i> เจ็บป่วย</button>
<div class="panel panel-default" style="margin-top: 10px">
    <div class="panel-body">
        <table class="table table-bordered table-hover">

            <tbody>

                <tr>
                    <td>เลข 13 หลัก</td>
                    <td><?= $model['CID']; ?></td>
                </tr>
                <tr>
                    <td>ชื่อ-สกุล</td>
                    <td><?= $model['PNAME']; ?><?= $model['NAME']; ?> <?= $model['LNAME']; ?>  (<?= $model['AGE'] ?>ปี) </td>
                </tr>
                <tr>
                    <td>เกิด</td>
                    <td><?= \Yii::$app->formatter->asDate($model['BIRTH']) ?> </td>
                </tr>

                <tr>
                    <td>ที่อยู่</td>
                    <td>
                        <?= $model['HOUSE'] ?> 
                        หมู่ <?= $model['MOO'] ?> ต.<?= $model['TMB'] ?>
                        อ.<?= $model['AMP'] ?> จ.<?= $model['PROV'] ?>
                    </td>
                </tr>




            </tbody>
        </table>
    </div>
</div>
<?php
$q = "ตำบล" . $model['TMB'] . " อำเภอ" . $model['AMP'] . " จังหวัด" . $model['PROV'];

if (!empty($model['LAT']) AND ! empty($model['LON']) AND $model['LAT'] > 0) {
    $q = $model['LAT'] . "," . $model['LON'];
}

$route = "//maps.google.com?q=" . $q;
$js = <<<JS
      $('#btn_map').click(function(e){
          var win = window.open('$route', 'win', 'left=100,top=60,menubar=no,location=no,resizable=yes,width=820px,height=560px');
      });  
JS;
$this->registerJs($js);




