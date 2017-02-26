<?php
$this->title = 'EMS';
//$this->registerCssFile('./lib-gis/leaflet.css', ['async' => false, 'defer' => true]);
//$this->registerJsFile('./lib-gis/leaflet.js', ['position' => $this::POS_HEAD]);
use frontend\assets\MapAsset;
MapAsset::register($this);

?>
<div class="panel panel-info">
    
    <div class="panel-body" >
        <div id="map" style="width: 100%;height: 80vh;"></div>   
    </div>


</div>
<?php
$js=<<<JS
  L.mapbox.accessToken = 'pk.eyJ1IjoibHRjIiwiYSI6ImNpeWUya3NkcTAwdTEyd214N3R0MWt0dmoifQ.q7C6rPbI2hphy4yMIMW82w';
  var map = L.mapbox.map('map', 'mapbox.streets').setView([16,100], 9);
JS;
$this->registerJs($js);


?>
