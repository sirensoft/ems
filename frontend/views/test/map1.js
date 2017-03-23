var div_map = document.getElementById('map');

var map = new google.maps.Map(div_map, {
    center: {lat: 16, lng: 100},
    zoom: 12
});
var infoWindow = new google.maps.InfoWindow();

var a = new google.maps.LatLng(16, 100);
var b = new google.maps.LatLng(16, 100.1);


console.log(google.maps.geometry.spherical.computeDistanceBetween(a, b));


var request = {
    location: new google.maps.LatLng(16, 100),
    radius: 10000,
    types: ['hospital']
};

var service = new google.maps.places.PlacesService(map);
service.nearbySearch(request, callback);

function callback(results, status) {
    if (status == google.maps.places.PlacesServiceStatus.OK) {
        for (var i = 0; i < results.length; i++) {
            createMarker(results[i]);
        }
    }
}

function createMarker(place) {
   
    var marker = new google.maps.Marker({
        map: map,
        position: place.geometry.location
    });

    google.maps.event.addListener(marker, 'click', function () {
        infoWindow.setContent(place.name);
        infoWindow.open(map,this);
    });
}
