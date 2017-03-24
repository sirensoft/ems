


<?php
$this->registerJsFile('//maps.googleapis.com/maps/api/js?key=AIzaSyDtrQxIgZGCXrChaNgCc0yCFCAyTFEmHU8&language=th&region=TH&libraries=geometry,places,drawing', ['position' => $this::POS_HEAD]);
?>


<div id="map" ></div>

<?php
$js=<<<JS

var div_map = document.getElementById('map');
var pCenter = new google.maps.LatLng($lat, $lon);

var map = new google.maps.Map(div_map, {
    center: pCenter,
    zoom: 12
});

createMarkerLatLng(pCenter, '<p>$name</p>' + '<a href=//maps.google.com?q=16,10>ระยะทาง</a>');


var cityCircle = new google.maps.Circle({
    strokeColor: 'red',
    strokeOpacity: 0.5,
    strokeWeight: 1,
    fillColor: '#00ff00',
    fillOpacity: 0.18,
    map: map,
    center: pCenter,
    radius: 10000
});


var request = {
    location: pCenter,
    radius: 10000,
    types: ['hospital']
};

var service = new google.maps.places.PlacesService(map);
service.nearbySearch(request, callback);

function callback(results, status) {
    if (status == google.maps.places.PlacesServiceStatus.OK) {
        for (var i = 0; i < results.length; i++) {
            console.log(i);
            if (!results[i].name.search("โรงพยาบาล") || !results[i].name.search("Hospital"))
                createMarker(results[i]);
        }
    }
}

var infoWindow = new google.maps.InfoWindow();
var hos_icon = {
    url: "//cdn3.iconfinder.com/data/icons/medical-2-1/512/map_marker-256.png", // url
    scaledSize: new google.maps.Size(32, 32), // scaled size
    origin: new google.maps.Point(0, 0), // origin
    anchor: new google.maps.Point(0, 0) // anchor
};
function createMarker(place) {

    var marker = new google.maps.Marker({
        icon: hos_icon,
        map: map,
        position: place.geometry.location
    });

    google.maps.event.addListener(marker, 'click', function () {
        infoWindow.setContent(place.name);
        infoWindow.open(map, this);
    });
}

function createMarkerLatLng(latlng, info) {

    var marker = new google.maps.Marker({
        map: map,
        position: latlng
    });

    google.maps.event.addListener(marker, 'click', function () {
        infoWindow.setContent(info);
        infoWindow.open(map, this);
    });
}

        
JS;

$this->registerJs($js);

