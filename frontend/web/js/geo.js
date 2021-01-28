var messageError = 'Your location\'s not found.<br /> Please try to find your location in the list.'

function getLocation () {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition)
    } else {
        showMessage(messageError)
    }
}

function showPosition (position) {
    var data = makeQuery(position.coords.latitude, position.coords.longitude)
    if (data != null && data.country == 'AU') {
        var message = '<p class="text-center">Is your current location:<br /> <strong>' + data.suburb + ', ' + data.state + '</strong>?</p>'
        if (data.suburb_id) {
            message += '<div class="text-center location-confirm"><a href="/location?suburb=' + data.suburb_id + '">Yes</a></div>'
        } else {
            message = 'We are not in this area yet.'
        }
        showMessage(message)
    } else {
        showMessage(messageError)
    }
}

function makeQuery (lat, lon) {
    var response = null
    $.ajax({
        url: 'https://maps.googleapis.com/maps/api/geocode/json?latlng=' + lat + ',' + lon + '&language=en&result_type=locality&key=' + key,
        //url:'https://maps.googleapis.com/maps/api/geocode/json?latlng=-37.739128, 144.997150&result_type=locality&key=AIzaSyAdb-hbS3lu3mWtnAELNt8ZaejMPvw3cFE',
        type: 'POST',
        async: false,
        dataType: 'json',
        success: function (data) {
            if (data.status == 'OK') {
                response = {
                    'suburb': (typeof data.results[0].address_components[0].long_name != 'undefined') ? data.results[0].address_components[0].long_name : '',
                    'state': (typeof data.results[0].address_components[2].short_name != 'undefined') ? data.results[0].address_components[2].short_name : '',
                    'country': (typeof data.results[0].address_components[3].short_name != 'undefined') ? data.results[0].address_components[3].short_name : '',
                }
            }
        }
    })

    if (response != null && response.country == 'AU') {
        $.ajax({
            url: 'site/check-suburb',
            data: {n: response.suburb, s: response.state, _csrf: yii.getCsrfToken()},
            type: 'POST',
            async: false,
            dataType: 'json',
            success: function (data) {
                if (data) {
                    response.suburb_id = data.suburb_id
                }
            }
        })
    }
    return response
}

/* Google places */
function initialize () {
    var location = new google.maps.places.Autocomplete(
      (document.getElementById('location-search')), {
          types: ['(cities)'],
          componentRestrictions: {
              country: 'AU',
          }
      })

    location.addListener('place_changed', function (e) {
        var place = location.getPlace()
        if (!place.geometry) {
            //window.alert('No details available for input: \'' + place.name + '\'');
            showMessage('No details available for input: \'' + place.name + '\'');
            return true;
        }
        var state = null
        place.address_components.map(function (el) {
            if (el.types[0] == 'administrative_area_level_1') {
                state = el.short_name
            }
        })

        if (!state && !place.name) {
            showMessage('We are not in this area yet.')
        } else {
            $.ajax({
                type: 'post',
                async: false,
                url: 'site/location',
                data: {n: place.name, s: state, _csrf: yii.getCsrfToken()},
                success: function (data) {
                    if (data.suburb_id) {
                        window.location.href = '/location?suburb=' + parseInt(data.suburb_id)
                        return true
                    } else {
                        showMessage('We are not in this area yet.')
                    }
                }
            });
        }
    })
}

function showMessage (message) {
    $('#modal-window .modal-body').html('<p>' + message + '</p>')
    $('#modal-window').modal('show')
}

