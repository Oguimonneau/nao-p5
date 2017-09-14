// Localize on map Observation to update
function initMap() {
    var map = new google.maps.Map(document.getElementById('map'), {});
    var geocoder = new google.maps.Geocoder;

    // Try HTML5 geolocation.
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude,
            };
            geocodeLatLng(geocoder, map);
            var legend = document.getElementById('legend');
            // legend.innerHTML = '<strong>Votre position</strong> </br>Latitude : ' + pos.lat + ' - Longitude : ' + pos.lng;
        },
            function() {
                handleLocationError(true, map.getCenter());
            });
    } else {
        // Browser doesn't support Geolocation
        handleLocationError(false, map.getCenter());
    }
}

function geocodeLatLng(geocoder, map, infowindow) {
    var lat = document.getElementById('appbundle_observation_latitude').value;
    var lng = document.getElementById('appbundle_observation_longitude').value;
    var latlng = {lat: parseFloat(lat), lng: parseFloat(lng)};

    geocoder.geocode({'location': latlng}, function(results, status) {
        if (status === 'OK') {
            if (results[1]) {
                map.setCenter(latlng);
                map.setZoom(11);
                var marker = new google.maps.Marker({
                    position: latlng,
                    map: map
                });
            } else {
                window.alert('Aucun résultat');
            }

        } else {
            window.alert('Erreur de Géolocalisation : ' + status);
        }
    });
}