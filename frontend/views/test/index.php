


<?php
$this->registerJsFile('//maps.googleapis.com/maps/api/js?key=AIzaSyDtrQxIgZGCXrChaNgCc0yCFCAyTFEmHU8&language=th&region=TH&libraries=geometry,places', ['position' => $this::POS_HEAD]);
?>


<div id="map" style="height: 80vh"></div>

<?php

$this->registerJs($this->render('map1.js'));

