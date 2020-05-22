function initMap() {
    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 12.8,
      center: {lat: -2.4506291, lng: -54.7009228}
    });
    var geocoder = new google.maps.Geocoder();
    document.getElementById('search-address').addEventListener('click', function() {
      geocodeAddress(geocoder, map);
    });
  }
  var markers = [];
  function geocodeAddress(geocoder, resultsMap) {
    var address = document.getElementById('address').value;
    function setMapOnAll(map) {
    for (var i = 0; i < markers.length; i++) {
      markers[i].setMap(map);
    }
  }
    setMapOnAll(null);
    markers = [];
    geocoder.geocode({'address': address}, function(results, status) {
      if (status === 'OK') {
        markers.forEach(function(marker) {
        marker.setMap(null);
      });
        resultsMap.setCenter(results[0].geometry.location);
        var marker = new google.maps.Marker({
          map: resultsMap,
          position: results[0].geometry.location
        });
        markers.push(marker);
        var formattedAddress = results[0].formatted_address;
        document.getElementById('endereco-formatado').value = formattedAddress;
        var addressComponentsLat = results[0].geometry.location.lat();
            document.getElementById('latitude').value =  addressComponentsLat;
        var addressComponentsLng = results[0].geometry.location.lng();
            document.getElementById('longitude').value = addressComponentsLng;
      } else {
        alert('Geocode was not successful for the following reason: ' + status);
      }
    })
    google.maps.event.addListener(map, 'click', function(event) {
      geocoder.geocode({
        'latLng': event.latLng
      }, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
          if (results[0]) {
            markers.forEach(function(marker) {
              marker.setMap(null);
            });
          }
        }
      });
    });
  }