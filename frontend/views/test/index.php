


<?php
$this->registerJsFile('//maps.googleapis.com/maps/api/js?key=AIzaSyDtrQxIgZGCXrChaNgCc0yCFCAyTFEmHU8&language=th&region=TH&libraries=geometry', ['position' => $this::POS_HEAD]);
?>


<div id="map" style="height: 80vh"></div>

<?php

$js=<<<JS
            var div_map = document.getElementById('map');
            var map = new google.maps.Map(div_map, {
                center: {lat: 16, lng: 100},
                zoom: 12
            });
            var infoWindow = new google.maps.InfoWindow({map: map});

            var a = new google.maps.LatLng(16, 100);
            var b = new google.maps.LatLng(16, 100.1);


            console.log(google.maps.geometry.spherical.computeDistanceBetween(a, b));



            // Try HTML5 geolocation.
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    var pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };

                    infoWindow.setPosition(pos);
                    infoWindow.setContent('Location found.');
                    map.setCenter(pos);
                }, function () {
                    handleLocationError(true, infoWindow, map.getCenter());
                });
            } else {
                // Browser doesn't support Geolocation
                handleLocationError(false, infoWindow, map.getCenter());
            }
           

            function handleLocationError(browserHasGeolocation, infoWindow, pos) {
                infoWindow.setPosition(pos);
                infoWindow.setContent(browserHasGeolocation ?
                        'Error: The Geolocation service failed.' :
                        'Error: Your browser doesn\'t support geolocation.');
            }

JS;

$this->registerJs($js);

