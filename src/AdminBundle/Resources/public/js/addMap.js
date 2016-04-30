$(document).ready(function () {

    newFields = "<div><label class='control-label' for='searchTextField'>ابحث عن مكانك </label><br><input id='searchTextField' type='text' size='50'></div><br><div id='map_canvas'  style='height: 400px ;width:100%;'></div><br>";
    parent = $('.LatField').parent().parent();
    parent.prepend(newFields);
    if ($('#map_canvas').length > 0) {
        initialize();

    }


    if ($('#location-map-div').length > 0) {
        initialize_location($('#location-map-div').attr('data-lat'), $('#location-map-div').attr('data-lng'));
    }
});

function initialize_location(lat, lng) {
    var latlng = new google.maps.LatLng(lat, lng);
    var mapOptions = {
        center: latlng,
        zoom: 10,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    var map = new google.maps.Map(document.getElementById('location-map-div'),
            mapOptions);
            
    var marker = new google.maps.Marker({
        position: latlng,
        map: map,
        animation: google.maps.Animation.DROP,
        title: 'the desired location'
    });
}

function initialize() {

    lat = 31.2015325;
    lng = 29.9010548;
    if (document.getElementsByClassName('LatField')[0].value && document.getElementsByClassName('LngField')[0].value) {
        lng = document.getElementsByClassName('LngField')[0].value;
        lat = document.getElementsByClassName('LatField')[0].value;
    }
    var latlng = new google.maps.LatLng(lat, lng);
    var mapOptions = {
        center: latlng,
        zoom: 13,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    var map = new google.maps.Map(document.getElementById('map_canvas'),
            mapOptions);

    var input = document.getElementById('searchTextField');
    var autocomplete = new google.maps.places.Autocomplete(input);

    autocomplete.bindTo('bounds', map);

    var infowindow = new google.maps.InfoWindow();
    var marker = new google.maps.Marker({
        position: latlng,
        map: map,
        animation: google.maps.Animation.DROP,
        title: 'the desired location'
    });


    google.maps.event.addListener(map, 'click', function (event) {
        infowindow.close();
        var currentLat = event.latLng.lat();
        var currentLng = event.latLng.lng();

        var newPosition = "<strong>Lat : </strong>" + currentLat + "<br><strong>Lng : </strong>" + currentLng;

        document.getElementsByClassName('LatField')[0].setAttribute("value", currentLat);
        document.getElementsByClassName('LngField')[0].setAttribute("value", currentLng);

        infowindow.setContent(newPosition);
        infowindow.open(map, marker);

        marker.setPosition(event.latLng);

    });



    google.maps.event.addListener(autocomplete, 'place_changed', function () {
        infowindow.close();
        var place = autocomplete.getPlace();
        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
        } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);  // Why 17? Because it looks good.
        }

        var image = new google.maps.MarkerImage(
                place.icon,
                new google.maps.Size(71, 71),
                new google.maps.Point(0, 0),
                new google.maps.Point(17, 34),
                new google.maps.Size(35, 35));
        marker.setIcon(image);
        marker.setPosition(place.geometry.location);

        var address = '';
        if (place.address_components) {
            address = [(place.address_components[0] &&
                        place.address_components[0].short_name || ''),
                (place.address_components[1] &&
                        place.address_components[1].short_name || ''),
                (place.address_components[2] &&
                        place.address_components[2].short_name || '')
            ].join(' ');
        }

        //get marker position
        var location = place.geometry.location.toString();
        var locations = location.split(',');
        var currentLat = locations['0'].replace("(", "");
        var currentLng = locations['1'].replace(")", "");
        document.getElementsByClassName('LatField')[0].setAttribute("value", currentLat);
        document.getElementsByClassName('LngField')[0].setAttribute("value", currentLng);
        infowindow.setContent('<div><strong>Place name : ' + place.name + '</strong><br> Address : ' + address + '<br>Lat : ' + currentLat + '<br>Lat : ' + currentLng);
        infowindow.open(map, marker);
    });


}
//google.maps.event.addDomListener(window, 'load', initialize);
