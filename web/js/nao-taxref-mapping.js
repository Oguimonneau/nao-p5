var mapTaxref,
    mapObservation,
    france = {lat: 48.862725 , lng: 2.287592};

    // var markersArray = [];

function initMap()
{
    // Taxref's current state map
    mapTaxref = new google.maps.Map(document.getElementById('mapTaxref'), {
        center: france, // Map centered on France
        zoom: 5 // Zoom is defined on "continent"
    });

    var marker = new google.maps.Marker({
        position: france,
        map: mapTaxref 
    });


    // Observations' map management
    mapObservation = new google.maps.Map(document.getElementById('mapObservation'), {
        center: france,
        zoom: 5
    });

    // Get XML Element values to be sent on map
    var markers = document.documentElement.getElementsByTagName('marker');


    Array.prototype.forEach.call(markers, function(markerElem) {
        // Get Observation's attributes value
        var id = markerElem.getAttribute('id'),
        lat = markerElem.getAttribute('lat'),
        lng = markerElem.getAttribute('lng'),
        com = markerElem.getAttribute('com'),
        note = markerElem.getAttribute('note');

        // Get marker position
        var location = new google.maps.LatLng(
            parseFloat(markerElem.getAttribute('lat')),
            parseFloat(markerElem.getAttribute('lng'))
        );

        var marker = new google.maps.Circle({
            strokeColor: '#FF0000',
            strokeOpacity: 0,
            strokeWeight: 2,
            fillColor: '#FF0000',
            fillOpacity: 0.35,
            map: mapObservation,
            center: location,
            radius: 25000
        });

        // markersArray.push(marker);
    });

    // // Add a marker clusterer to manage the markers
    // var markerCluster = new MarkerClusterer(mapObservation, markersArray,
    //         {imagePath: '../../images/markerclusterer/m'});
}
