<!DOCTYPE html>
<html>
<body>

	<head>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDuN8fFIhB9Aa1p3DuW0zGODGv2pzfVmxM&callback=myMap"></script>
    </head>
    <script>
        var myMap;
        var myLatlng = new google.maps.LatLng(42.6601502,27.718631);
        function initialize() {
            var mapOptions = {
                zoom: 15,
                center: myLatlng,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                scrollwheel: true
            }
            myMap = new google.maps.Map(document.getElementById('map'), mapOptions);
            var marker = new google.maps.Marker({
                position: myLatlng,
                map: myMap,
                title: 'Restaurant "Ruja"',
                icon: 'http://www.google.com/intl/en_us/mapfiles/ms/micons/red-dot.png'
            });
        }
        google.maps.event.addDomListener(window, 'load', initialize);
    </script>
    <h3 style="color:gold;">Нашият адрес: </h3>
    <div id="map" style="width:400px; height: 400px;">

    </div>


</body>
</html>



