var mapTaxref,
    mapObservation,
    france = {lat: 48.862725 , lng: 2.287592},
    taxrefCoordinates,
    observationCoordinates = [];

function initMap()
{
    mapTaxref = new google.maps.Map(document.getElementById('mapTaxref'), {
        center: france, // Map centered on France
        zoom: 5 // Zoom is defined on "continent"
    });

    var marker = new google.maps.Marker({
        position: france,
        map: mapTaxref 
    });

    mapObservation = new google.maps.Map(document.getElementById('mapObservation'), {
        center: {lat: -34.397, lng: 150.644},
        zoom: 8
    });
}
