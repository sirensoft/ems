

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
                    <td><?= $model['PNAME']; ?><?= $model['NAME']; ?> <?= $model['LNAME']; ?>   </td>
                </tr>
                <tr>
                    <td>พิกัด</td>
                    <td><?= $model['LAT']; ?>,<?= $model['LON']; ?></td>
                </tr>

                <tr>
                    <td>label</td>
                    <td>data</td>
                </tr>


            </tbody>
        </table>
    </div>
</div>
<?php
$q= "หมู่ที่ ".$model['MOO']." ตำบล".$model['TMB']." อำเภอ".$model['AMP'];

if(!empty($model['LAT']) AND !empty($model['LON']) AND $model['LAT']>0){
  $q =   $model['LAT'].",".$model['LON'];
}

$route = "//maps.google.com?q=".$q;
$js=<<<JS
      $('#btn_map').click(function(e){
          var win = window.open('$route', 'win', 'left=100,top=60,menubar=no,location=no,resizable=yes,width=820px,height=560px');
      });  
JS;
$this->registerJs($js);




