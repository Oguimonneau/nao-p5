function initMap() {

        var lat = document.getElementById('lat').value;
        var long = document.getElementById('long').value;

    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 4,
        center: uluru
    });
    var marker = new google.maps.Marker({
        position: lat,long,
        map: map
    });
}

</script>