<?php
$this->title = "EPID";
$this->params['breadcrumbs'][] = "ข้อมูลโรคทางระบาดวิทยา";


use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\tabs\TabsX;
use miloschuman\highcharts\HighchartsAsset;
HighchartsAsset::register($this)->withScripts(['modules/exporting', 'modules/drilldown']);

use frontend\modules\epid\models\GisEms;

//GIS
$css = <<<CSS
   .info {
            padding: 6px 8px;
            font: 14px/16px Arial, Helvetica, sans-serif;
            background: white;
            background: rgba(255, 255, 255, 0.8);
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
        }
        .legend {
            text-align: left;
            line-height: 18px;
            color: #555;
        }
        .legend i {
            width: 18px;
            height: 18px;
            float: left;
            margin-right: 8px;
            opacity: 0.7;
       .alignment {
            margin-top:10px;
        }
CSS;
$this->registerCss($css);

$this->registerCssFile('//api.mapbox.com/mapbox.js/v3.0.1/mapbox.css', ['async' => false, 'defer' => true]);
$this->registerJsFile('//api.mapbox.com/mapbox.js/v3.0.1/mapbox.js', ['position' => $this::POS_HEAD]);
$this->registerCssFile('//api.mapbox.com/mapbox.js/plugins/leaflet-locatecontrol/v0.43.0/L.Control.Locate.mapbox.css', ['async' => false, 'defer' => true]);
$this->registerJsFile('//api.mapbox.com/mapbox.js/plugins/leaflet-locatecontrol/v0.43.0/L.Control.Locate.min.js', ['position' => $this::POS_HEAD]);
$this->registerCssFile('//api.mapbox.com/mapbox.js/plugins/leaflet-locatecontrol/v0.43.0/css/font-awesome.min.css', ['async' => false, 'defer' => true]);
$this->registerCssFile('./lib-gis/leaflet-search.min.css', ['async' => false, 'defer' => true]);
$this->registerCssFile('./lib-gis/leaflet.label.css', ['async' => false, 'defer' => true]);
$this->registerJsFile('./lib-gis/leaflet-search.min.js', ['position' => $this::POS_HEAD]);
$this->registerJsFile('./lib-gis/leaflet.label.js', ['position' => $this::POS_HEAD]);

$this->registerCssFile('./lib-gis/marker/css/leaflet.extra-markers.min.css', ['async' => false, 'defer' => true]);
$this->registerJsFile('./lib-gis/marker/js/leaflet.extra-markers.min.js', ['position' => $this::POS_HEAD]);
//end GIS
?>

<div style="margin-bottom: 5px">
    <?php
    ActiveForm::begin([
        'method' => 'get',
        'action' => Url::to(['/epid/default/index']),
    ]);
    ?>

    <?php
    $sql = " SELECT t.group506code CODE506,CONCAT(t.group506code,'-',t.group506name) DIS from cdisease506 t ";
    $rawData = Yii::$app->db_hdc->createCommand($sql)->queryAll();
    $items = ArrayHelper::map($rawData, 'CODE506', 'DIS');
    ?>
    <div class="input-group">
        <?= Html::dropDownList('disease', $disease, $items, ['prompt' => '--- โรค ---', 'class' => 'form-control']); ?>
        <span class="input-group-btn">
            <?= Html::submitButton('<i class="glyphicon glyphicon-search"></i> ตกลง', ['class' => 'btn btn-default alignment']); ?>
        </span>
    </div>
    <?php
    ActiveForm::end();
    ?>
</div>

<div id="tab">
    <?php
    echo TabsX::widget([
        'items' => [
            [
                'label' => 'แผนที่',
                'content' => '<div class="panel panel-default" id="map" style="height: 75vh; "></div>'
            ],
            [
                'label'=>'แผนภูมิ',
                'content'=>'<div class="panel panel-default" id="chart" style="height: 75vh; "></div>'
            ],
            [
                'label'=>'รายชื่อ',
                'content'=>$this->render('grid',[
                    'dataProvider'=>$dataProvider,
                    'searchModel'=>$searchModel
                ])
                
            ]
        ]
    ]);
    ?>
</div>



<?php
$raw = GisEms::find()->where(['PROV_CODE' => '75'])->asArray()->all();
$tambon_json = [];
foreach ($raw as $value) {
    $tambon_json[] = [
        'type' => 'Feature',
        'properties' => [
            'TAM_NAMT' => "ต." . $value['TAM_NAMT'],
            'TAM_CODE' => $value['PROV_CODE'] . $value['AMP_CODE'] . $value['TAM_CODE'],
            'COLOR' => call_user_func(function()use($value, $disease) {
                        if (empty($disease)) {
                            return '#00ff7f';
                        }
                        if ($value['TAM_CODE'] % 5 == 0) {
                            return '#ff4444';
                        }
                        if ($value['TAM_CODE'] % 3 == 0) {
                            return '#ffff66';
                        }
                        return '#00ff7f';
                    })
        ],
        'geometry' => [
            'type' => 'MultiPolygon',
            'coordinates' => json_decode($value['COORDINATES']),
        ]
    ];
}
$tambon_json = json_encode($tambon_json);
?>



<?php
$js = <<<JS
   L.mapbox.accessToken = 'pk.eyJ1IjoibHRjIiwiYSI6ImNpeWUya3NkcTAwdTEyd214N3R0MWt0dmoifQ.q7C6rPbI2hphy4yMIMW82w';
   var map = L.mapbox.map('map', 'mapbox.streets').setView([16,100], 9);
   var baseLayers = {
	"แผนที่ถนน": L.mapbox.tileLayer('mapbox.streets'),  
        "แผนที่ถนนละเอียด":L.tileLayer('//{s}.tile.osm.org/{z}/{x}/{y}.png').addTo(map),
        "แผนที่ดาวเทียม": L.mapbox.tileLayer('mapbox.satellite'),
    };

 var _group2 = L.layerGroup().addTo(map);
  var tam_layer=L.geoJson($tambon_json,{
        style:style,
        onEachFeature:function(feature,layer){         
            layer.bindPopup(feature.properties.TAM_NAMT);
            //layer.bindLabel(feature.properties.TAM_NAMT);
            layer.on({
                    mouseover: highlightFeatureTamLayer,
                    mouseout: resetHighlightTamLayer,
                    click: zoomToFeature
                });
         },
         
       }).addTo(_group2);
   map.fitBounds(tam_layer.getBounds());
 
        
 var overlays = {      
     "ขอบเขตตำบล":_group2
 };
  L.control.layers(baseLayers,overlays).addTo(map);
        
   // other function    
    function style(feature) {
        return {
            fillColor: feature.properties.COLOR,
            weight: 2,
            opacity: 1,
            color: 'white',
            dashArray: '3',
            fillOpacity: 0.7
        }
    } 
        
    function highlightFeatureTamLayer(e) {
        var layer = e.target;
        layer.setStyle({
            weight: 5,
            color: '#FFFF00',
            dashArray: '',
            fillOpacity: 0.7
        });
        if (!L.Browser.ie && !L.Browser.opera) {
            layer.bringToFront();
        }
        
    }
    function resetHighlightTamLayer(e) {
        tam_layer.resetStyle(e.target);
        
    }
    function zoomToFeature(e) {
        map.fitBounds(e.target.getBounds());
    }
    // end other
        
    // legend
    var legend = L.control({position: 'bottomleft'});
    legend.onAdd = function (map) {
        var div = L.DomUtil.create('div', 'info legend');
        var labels = ['<b>คำอธิบาย</b>'];
        labels.push('<i style="background:#ff4444"></i>>= 1000 ต่อแสน ปชก.');
        //labels.push('<i style="background:#FFA500"></i>>= 100 ต่อแสน ปชก.');
        labels.push('<i style="background:#ffff66"></i>> 0 ต่อแสน ปชก.');
        labels.push('<i style="background:#00ff7f"></i>ไม่พบผู้ป่วย');
        div.innerHTML = labels.join('<br>');
        return div;
    };
    legend.addTo(map);
    //end legend
      
JS;
$this->registerJs($js);

$js2 = <<<JS
   Highcharts.chart('chart', {
    chart: {
        type: 'line'
    },
    title: {
        text: 'ปี 2560'
    },
    subtitle: {
        text: 'แฟ้ม SURVIEL'
    },
    xAxis: {
        categories: ['มค', 'กพ', 'มีค', 'เมษ', 'พค', 'มิย', 'กค', 'สค', 'กย', 'ตค', 'พย', 'ธค']
    },
    yAxis: {
        title: {
            text: 'อัตรา (ต่อแสน)'
        }
    },
    plotOptions: {
        line: {
            dataLabels: {
                enabled: true
            },
            enableMouseTracking: false
        }
    },
    series: [{
            name: '2559',
        data: [7.0, 6.9, 9.5, 14.5, 18.4, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
    }, {
        name: '2560',
        data: [3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8]
    }]
});
        
    $("#map").width('100%');
    $("#chart").width('100%');
JS;
$this->registerJs($js2);







