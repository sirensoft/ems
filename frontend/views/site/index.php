<?php
$this->title = 'EMS';

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

$this->params['breadcrumbs'][] = "ที่ตั้งหน่วยบริการ";

?>
<div class="panel panel-info">
    
    <div class="panel-body" >
        <div id="map" style="width: 100%;height: 70vh;"></div>   
    </div>


</div>

<?php
// รพ
$sql = " SELECT t.hcode hospcode,hh.hosname,t.lat,t.lon FROM geojson  t 
LEFT JOIN chospital hh on hh.hoscode = t.hcode
WHERE t.hcode in (
 SELECT h.hoscode FROM chospital h WHERE h.provcode in (SELECT s.prov FROM sys_ems_config s)
) ";
$raw = \Yii::$app->db_hdc->createCommand($sql)->queryAll();

 $hos_json = [];
        foreach ($raw as $value) {
            $hos_json[] = [
                'type' => 'Feature',
                'properties' => [
                    'HOSP' => $value['hospcode'] . '-' . str_replace('โรงพยาบาลส่งเสริมสุขภาพตำบล','รพ.สต.',$value['hosname']),
                   
                    'SEARCH_TEXT' =>str_replace('โรงพยาบาลส่งเสริมสุขภาพตำบล','รพ.สต.',$value['hosname']),
                    
                ],
                'geometry' => [
                    'type' => 'Point',
                    'coordinates' => [$value['lon'] * 1, $value['lat'] * 1],
                ]
            ];
        }
   $hos_json = json_encode($hos_json);
   // จบ รพ.
   
   /// ตำบล
   $sql = " select * from gis_ems ";
   $raw = \Yii::$app->db_hdc->createCommand($sql)->queryAll();
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
     // จบตำบล

?>
<?php
$js=<<<JS
  L.mapbox.accessToken = 'pk.eyJ1IjoibHRjIiwiYSI6ImNpeWUya3NkcTAwdTEyd214N3R0MWt0dmoifQ.q7C6rPbI2hphy4yMIMW82w';
  var map = L.mapbox.map('map', 'mapbox.streets').setView([16,100], 9);
        
 var lc = L.control.locate({
         position: 'topright',
         locateOptions: {
               maxZoom: 16
         },
        icon:'fa fa-street-view'
      }).addTo(map);
        
var baseLayers = {
	"แผนที่ถนน": L.mapbox.tileLayer('mapbox.streets').addTo(map),  
        "แผนที่ถนนละเอียด":L.tileLayer('//{s}.tile.osm.org/{z}/{x}/{y}.png'),
        "แผนที่ดาวเทียม": L.mapbox.tileLayer('mapbox.satellite'),
       
        
        
        
    };
 var _group1 = L.layerGroup().addTo(map);
 var _group2 = L.layerGroup().addTo(map);

        
 
 var ic_y   =L.mapbox.marker.icon({'marker-color': '#ffff00'});//y
 var ic_b = L.mapbox.marker.icon({'marker-color': '#0000FF'});//b
 var ic_r = L.mapbox.marker.icon({'marker-color': '#ff0033'});//r
 var ic_w = L.mapbox.marker.icon({'marker-color': '#FFFFFF'});//w
 var ic_g = L.mapbox.marker.icon({'marker-color': '#27e16c'});//bk
 
 var ic_m = L.ExtraMarkers.icon({
    icon: 'fa-plus',
    markerColor: 'green',
    shape: 'square',
    prefix: 'fa'
  });
        
 var hos_layer =L.geoJson($hos_json,{                
            
           onEachFeature:function(feature,layer){  
        
                layer.setIcon(ic_m);                      
                var lat = feature.geometry.coordinates[1] ;
                var lon = feature.geometry.coordinates[0] ;
                var ll = lat+','+lon;
        
                layer.bindPopup(feature.properties.HOSP+'<hr>'+'<a href=//www.google.co.th/maps?q='+ll+' target=_blank>ระยะทาง</a>');
                            
               
           },        
           
    }).addTo(_group1);
        
 
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
        
     
        
 //map.fitBounds(hos_layer.getBounds());
        
 var overlays = { 
     "หน่วยบริการ": _group1,
     "ขอบเขตตำบล":_group2
 };
        
        
L.control.layers(baseLayers,overlays).addTo(map);
        
        

    var searchControl = new L.Control.Search({
		layer: hos_layer,
		propertyName: 'SEARCH_TEXT',
		circleLocation: false,
		
    });
    searchControl.on('search:locationfound', function(e) {
				
		if(e.layer._popup)e.layer.openPopup();
    }).on('search:collapsed', function(e) {
		hos_layer.eachLayer(function(layer) {	
			hos_layer.resetStyle(layer);
		});	
    });
    map.addControl( searchControl );  
        
        
        
  // other function    
    function style(feature) {
        return {
            fillColor: '#4169E1',
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
            color: '#B5E61D',
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
 
        
  
JS;
$this->registerJs($js);


?>
