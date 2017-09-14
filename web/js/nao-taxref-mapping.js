//===============================================
// 
// Javascript management for Taxref's description
// 
// =====================
// 
// View in app/Resources/views/taxref/detail.html.twig
// XML views in app/Resources/views/taxref/xml
// 
//===============================================

var mapHabitat,
    mapObservation;

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

var taxrefStatus = [
    {code: 'P', label: 'Présent (indigène ou indeterminé)'},
    {code: 'B', label: 'Occasionnel'},
    {code: 'E', label: 'Endémique'},
    {code: 'S', label: 'Subendémique'},
    {code: 'C', label: 'Cryptogène'},
    {code: 'I', label: 'Introduit'},
    {code: 'G', label: 'Introduit envahissant'},
    {code: 'M', label: 'Introduit non établi(dont domestique)'},
    {code: 'D', label: 'Douteux'},
    {code: 'A', label: 'Absent'},
    {code: 'W', label: 'Disparu'},
    {code: 'E', label: 'Eteint'},
    {code: 'Y', label: 'Introduit éteint/disparu'},
    {code: 'Z', label: 'Endémique éteint'},
    {code: 'Q', label: 'Mentionné par erreur'}
];

// Find attribut in an array's line (paired with locations and taxrefStatus)
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

// Get XML informations from app/Resources/views/taxref/xml/taxrefInformations.xml.twig
var infos;

$.ajax({
    'url': xmlTaxrefInfosRoute,
    'type': 'GET',
    'dataType': 'xml',
    'success': function(data)
    {
        infos = data;
    }
});


// Google Map API management
function initMap()
{
    // Taxref's current state map
    mapHabitat = new google.maps.Map(document.getElementById('mapHabitat'), {
        center: {lat: 27.955591 , lng: 11.975098}, // Map centered
        zoom: 2 // Zoom is defined on "world"
    });

    // Observations' map management
    mapObservation = new google.maps.Map(document.getElementById('mapObservation'), {
        center: {lat: 46.2276380 , lng: 2.2137490}, // Map centered on France
        zoom: 5 // Zoom is defined on "country"
    });


    // Wait for Ajax to complete to add markers on the map
    $(document).ajaxComplete(function() {
        // Habitats' markers management
        // Get XML markers Element values to be sent on map
        var status = infos.documentElement.getElementsByTagName('state');

        Array.prototype.forEach.call(status, function(stateElem) {
            // Get Taxref's habitats' attributes value
            var zone = stateElem.getAttribute('zone'),
                lib = stateElem.getAttribute('lib');

            // Get marker position
            var location = new google.maps.LatLng(
                parseFloat(findElement(locations, 'zone', zone)['lat']),
                parseFloat(findElement(locations, 'zone', zone)['lng'])
            );

            var contentString = '<div id="marker-info">'+
                    '<h4>Statut de cette espèce :</h4>'+
                    '<p>' + findElement(taxrefStatus, 'code', lib)['label'] + '</p>'+
                '</div>';

            var infowindow = new google.maps.InfoWindow({
              content: contentString,
              position: location
            });

            var marker = new google.maps.Circle({
                strokeColor: '#FF0000',
                strokeOpacity: 0,
                strokeWeight: 2,
                fillColor: '#FF0000',
                fillOpacity: 0.35,
                map: mapHabitat,
                center: location,
                radius: 400000
            });
            // Show informations on marker click
            marker.addListener('click', function() {
              infowindow.open(mapHabitat, marker);
            });
        });

        // Observations' markers management
        // Get XML markers Element values to be sent on map
        var markers = infos.getElementsByTagName('marker');

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
        });
    });
}
