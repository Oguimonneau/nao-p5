var mapTaxref,
    mapObservation,
    france = {lat: 48.862725 , lng: 2.287592};

var locations = [
    {zone: 'fr',lat: '46.2276380', lng: '2.2137490'},
    {zone: 'gf',lat: '3.9338890', lng: '-53.1257820'},
    {zone: 'mar',lat: '14.6415280', lng: '-61.0241740'},
    {zone: 'gua',lat: '16.2650000', lng: '-61.5510000'},
    {zone: 'sm',lat: '18.0708298', lng: '-63.0500809'},
    {zone: 'sb',lat: '17.9000000', lng: '-62.8333330'},
    {zone: 'spm',lat: '46.8852000', lng: '-56.0315900'},
    {zone: 'may',lat: '-12.8275000', lng: '45.1662440'},
    {zone: 'epa',lat: '-22.366662 ', lng: '40.352893'},
    {zone: 'reu',lat: '-21.1151410', lng: '55.5363840'},
    {zone: 'sa',lat: '-50.6921774', lng: '166.07991289999995'},
    {zone: 'ta',lat: '-84.65780901813524', lng: '127.27249145507812'},
    {zone: 'taaf',lat: '-49.280366', lng: '69.3485571'},
    {zone: 'pf',lat: '-17.6797420', lng: '-149.4068430'},
    {zone: 'nc',lat: '-20.9043050', lng: '165.6180420'},
    {zone: 'wf',lat: '-14.2938000', lng: '-178.1165000'},
    {zone: 'cli',lat: '10.2833333', lng: '-109.2166667'}
];

function findElement(arr, propName, propValue)
{
    for (var i = 0; i < arr.length; i++)
    {
        if (arr[i][propName] == propValue)
        {
            return arr[i];
        }
    }
}

// var markersArray = [];

function initMap()
{
    // Taxref's current state map
    mapTaxref = new google.maps.Map(document.getElementById('mapTaxref'), {
        center: {lat: 27.955591 , lng: 11.975098}, // Map centered on France
        zoom: 2 // Zoom is defined on "continent"
    });

    // Get XML markers Element values to be sent on map
    var status = document.documentElement.getElementsByTagName('state');

    Array.prototype.forEach.call(status, function(stateElem) {
        // Get Observation's attributes value
        var zone = stateElem.getAttribute('zone'),
            lib = stateElem.getAttribute('lib');

        // Get marker position
        var location = new google.maps.LatLng(
            parseFloat(findElement(locations, 'zone', zone)['lat']),
            parseFloat(findElement(locations, 'zone', zone)['lng'])
        );

        var marker = new google.maps.Circle({
            strokeColor: '#FF0000',
            strokeOpacity: 0,
            strokeWeight: 2,
            fillColor: '#FF0000',
            fillOpacity: 0.35,
            map: mapTaxref,
            center: location,
            radius: 400000
        });

        // markersArray.push(marker);
    });

    // Observations' map management
    mapObservation = new google.maps.Map(document.getElementById('mapObservation'), {
        center: france,
        zoom: 5
    });

    // Get XML markers Element values to be sent on map
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
            parseFloat(lat),
            parseFloat(lng)
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
