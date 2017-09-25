// Localize on map Observation to update
function initMap() {
    // Get observation's localization
    var lat = document.getElementById('appbundle_observation_latitude').value;
    var lng = document.getElementById('appbundle_observation_longitude').value;
    var latlng = {lat: parseFloat(lat), lng: parseFloat(lng)};

    // Taxref's current state map
    var map = new google.maps.Map(document.getElementById('map'), {
        center: latlng,
        zoom: 11 // Zoom is defined on "world"
    });

    var marker = new google.maps.Marker({
        position: latlng,
        map: map
    });
}
