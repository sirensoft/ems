<?php
$this->title = "EPID";
$this->params['breadcrumbs'][] = "ข้อมูลโรคทางระบาดวิทยา";
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use frontend\modules\epid\models\GisEms;

//GIS
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
<div class="epid-default-index">
    <div class="map panel panel-default" id="map" style="width: 100%;height: 75vh;">
        <?php
        
        $raw = GisEms::find()->where(['PROV_CODE'=>'75'])->asArray()->all();
        $tambon_json = [];
        foreach ($raw as $value) {
            $tambon_json[] = [
                'type' => 'Feature',
                'properties' => [
                    'TAM_NAMT' => "ต." . $value['TAM_NAMT'],
                ],
                'geometry' => [
                    'type' => 'MultiPolygon',
                    'coordinates' => json_decode($value['COORDINATES']),
                ]
            ];
        }
        $tambon_json = json_encode($tambon_json);
        //print_r($tambon_json);
        
        ?>
        
    </div>
    <div class="grid">
    <?php
    $sql = "SELECT t.code506last id,concat(t.code506last,'-',t.groupname506) val FROM t_surveil t GROUP BY t.code506last";
    $raw = \Yii::$app->db_hdc->createCommand($sql)->queryAll();
    $items =  ArrayHelper::map($raw, 'id', 'val');
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
            [
                'attribute'=>'code506last',
                'label'=>'โรค',
                'filter'=>$items,
                'value'=>function($model){
                    return $model->code506last."-".$model->groupname506;
                }
            ],
            
            //'groupname506:text:ชื่อโรค'
        ]
    ]);
    ?>
    </div>
</div>
<?php
$js=<<<JS
   L.mapbox.accessToken = 'pk.eyJ1IjoibHRjIiwiYSI6ImNpeWUya3NkcTAwdTEyd214N3R0MWt0dmoifQ.q7C6rPbI2hphy4yMIMW82w';
   var map = L.mapbox.map('map', 'mapbox.streets').setView([16,100], 9);
   var baseLayers = {
	"แผนที่ถนน": L.mapbox.tileLayer('mapbox.streets'),  
        "แผนที่ถนนละเอียด":L.tileLayer('//{s}.tile.osm.org/{z}/{x}/{y}.png').addTo(map),
        "แผนที่ดาวเทียม": L.mapbox.tileLayer('mapbox.satellite'),
    };

 var _group2 = L.layerGroup().addTo(map);
  var tam_layer=L.geoJson($tambon_json,{
        //style:style,
        onEachFeature:function(feature,layer){         
            layer.bindPopup(feature.properties.TAM_NAMT);
            //layer.bindLabel(feature.properties.TAM_NAMT);
            layer.on({
                    //mouseover: highlightFeatureTamLayer,
                    //mouseout: resetHighlightTamLayer,
                    //click: zoomToFeature
                });
         },
         
       }).addTo(_group2);
   map.fitBounds(tam_layer.getBounds());
 
        
 var overlays = {      
     "ขอบเขตตำบล":_group2
 };
  L.control.layers(baseLayers,overlays).addTo(map);
      
JS;
$this->registerJs($js);
