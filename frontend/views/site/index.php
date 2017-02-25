<?php



$this->title = 'EMS';
$this->registerCssFile('./lib-gis/leaflet.css', ['async' => false, 'defer' => true]);
$this->registerJsFile('./lib-gis/leaflet.js', ['position' => $this::POS_HEAD]);

?>
<div class="panel panel-info">
    
    <div class="panel-body" >
        <div id="map" style="width: 100%;height: 80vh;"></div>   
    </div>


</div>
<?php
$js=<<<JS
  var cities = new L.LayerGroup();

	L.marker([39.61, -105.02]).bindPopup('This is Littleton, CO.').addTo(cities),
	L.marker([39.74, -104.99]).bindPopup('This is Denver, CO.').addTo(cities),
	L.marker([39.73, -104.8]).bindPopup('This is Aurora, CO.').addTo(cities),
	L.marker([39.77, -105.23]).bindPopup('This is Golden, CO.').addTo(cities);


	var mbAttr = 'utehn',
	mbUrl = 'https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibHRjIiwiYSI6ImNpeWUya3NkcTAwdTEyd214N3R0MWt0dmoifQ.q7C6rPbI2hphy4yMIMW82w';

	var grayscale   = L.tileLayer(mbUrl, {id: 'mapbox.light', attribution: mbAttr})
        ,streets  = L.tileLayer(mbUrl, {id: 'mapbox.streets',   attribution: mbAttr})
        ,satellite = L.tileLayer(mbUrl, {id: 'mapbox.satellite',   attribution: mbAttr});

	var map = L.map('map', {
		center: [16, 100],
		zoom: 10,
		layers: [streets, cities]
	});

	var baseLayers = {
		
		"ถนน": streets,
                "ดาวเทียม":satellite,
	};

	var overlays = {
		"Cities": cities
	};

	L.control.layers(baseLayers, overlays).addTo(map);
JS;
$this->registerJs($js);


?>
