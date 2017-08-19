$('.js-datepicker').datepicker({
    language: "fr",
    format: "dd-mm-yyyy",
    todayHighlight: true,
    endDate:"d",
    todayBtn: true,
    autoclose: true,
});


function initMap() {
    var map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: -34.397, lng: 150.644},
        zoom: 15
    });
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
            //infoWindow.setContent(pos);
            map.setCenter(pos);
            geocodeLatLng(geocoder, map, infoWindow);
        }, function() {
            handleLocationError(true, infoWindow, map.getCenter());
        });
    } else {
        // Browser doesn't support Geolocation
        handleLocationError(false, infoWindow, map.getCenter());
    }
}

function handleLocationError(browserHasGeolocation, infoWindow, pos) {
    infoWindow.setPosition(pos);
    infoWindow.setContent(browserHasGeolocation ?
        'Error: The Geolocation service failed.' :
        'Error: Your browser doesn\'t support geolocation.');
}

function geocodeLatLng(geocoder, map, infowindow) {
    //var input = document.getElementById('latlng').value;
    //var latlngStr = input.split(',', 2);
    var lat = document.getElementById('appbundle_observation_latitude').value;
    var lng = document.getElementById('appbundle_observation_longitude').value;
    var latlng = {lat: parseFloat(lat), lng: parseFloat(lng)};
    geocoder.geocode({'location': latlng}, function(results, status) {
        $(appbundle_observation_commune).val(results[1].formatted_address);
        if (status === 'OK') {
            if (results[1]) {
                map.setZoom(11);
                var marker = new google.maps.Marker({
                    position: latlng,
                    map: map
                });
                infowindow.setContent(results[1].formatted_address);
                infowindow.open(map, marker);
            } else {
                window.alert('No results found');
            }
        } else {
            window.alert('Geocoder failed due to: ' + status);
        }
    });
}