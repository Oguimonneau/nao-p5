
function initMap() {
    var map = new google.maps.Map(document.getElementById('map'), {});
    var geocoder = new google.maps.Geocoder;
    var infoWindow = new google.maps.InfoWindow({map: map});

    // Try HTML5 geolocation.
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
                var pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude,
                };
                $(appbundle_observation_latitude).val(pos.lat) ;
                $(appbundle_observation_longitude).val(pos.lng);
                infoWindow.setPosition(pos);
                map.setCenter(pos);
                geocodeLatLng(geocoder, map, infoWindow);
                var legend = document.getElementById('legend');
                legend.innerHTML = '<strong>Votre position</strong> </br>Latitude : ' + pos.lat + ' - Longitude : ' + pos.lng;
            },
            function() {
                handleLocationError(true, infoWindow, map.getCenter());
            });
    } else {
        // Browser doesn't support Geolocation
        handleLocationError(false, infoWindow, map.getCenter());
    }
}