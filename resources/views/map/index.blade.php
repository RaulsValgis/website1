@extends('auth.layouts')

@section('content')
<style> 
    
    .diff { 
        padding-top: 2px; 
        padding-bottom: 2px; 
    } 

    .diff2 { 
        border-style: solid; 
        border-radius: 20px;
        padding-left: 10px; 
    } 
    

    </style>

    <div class="row">
        <div class="col-9">
            <div id="map" style="height: 800px; width: 100%;"></div>
        </div>
        <div class="col-3">
            <div class="input diff">
                <input class="diff2" type="text" id="country" placeholder="{{ __('Country') }}" autocomplete="off">
            </div>
            <div class="input diff">
                <input class="diff2" type="text" id="city" placeholder="{{ __('City') }}" autocomplete="off">
            </div>
            <div class="input diff">
                <input class="diff2" type="text" id="street" placeholder="{{ __('Street') }}" autocomplete="off">
            </div>
            <div class="input diff">
                <button type="button" class="btn btn-primary" onclick="findLocation()">{{ __('Find Location') }}</button>
            </div>
            <div class="address">
                <select id="address-list" class="js-example-basic-single" style="width: 100%">

                </select>
            </div>
            <div id="length-info" class="length-info">
                {{ __('Total Length') }}: <span id="length-value">0.00 km</span>
            </div>
            <div id="ab-length-info" class="length-info">
                {{ __('A to B Length') }}: <span id="ab-length-value">0.00 km</span>
            </div>
            <br>
            <div id="area-info" class="area-info">
                {{ __('Total Area') }}: <span id="area-value">0.00 km²</span>
            </div>
        </div>
    </div>


<script>





    var map = L.map('map').setView([57.54108, 25.42751], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {}).addTo(map);

    var markerCluster = L.markerClusterGroup();

    const markers = [];
    
    var polyline;

    let lastMarkerCoordinates = null;








    function calculatePolygonArea(coordinates) {
        const polygon = L.polygon(coordinates);
        const area = turf.area(polygon.toGeoJSON());
        return area / 1000000; 
    }







    function calculateAndDisplayArea() {
        const area = calculatePolygonArea(markers);
        document.getElementById('area-value').innerText = area.toFixed(2) + 'km²';
    }








    function createPolyline(coordinates) {
        if (polyline) {
            map.removeLayer(polyline);
        }

        polyline = L.polyline(coordinates, { color: 'red', width: '2' }).addTo(map);

        const length = calculatePolylineLength(coordinates);
        
        document.getElementById('length-value').innerText = length.toFixed(2) + ' km';
    }












    function calculatePolylineLength(coordinates) {
        let length = 0;

        for (let i = 0; i < coordinates.length - 1; i++) {
            const latlng1 = L.latLng(coordinates[i]);
            const latlng2 = L.latLng(coordinates[i + 1]);
            length += latlng1.distanceTo(latlng2);
        }

        return length / 1000;
    }











    function createPopupContent(country, city, street) {
      return `<b>{{ __('Location') }}:</b><br>
            {{ __('Country') }}: ${country}<br>
            {{ __('City') }}: ${city}<br>
            {{ __('Street') }}: ${street}
            `;
    }











    function createCustomMarkerIcon() {
    return L.icon({
        iconUrl:        'https://icon-library.com/images/waypoint-icon/waypoint-icon-0.jpg', 
        iconSize:       [32, 40], 
        iconAnchor:     [16, 32],  
        popupAnchor:    [0, -32] 
        });
    }











    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });
















    async function findLocation() {
        const country           = document.getElementById('country').value;
        const city              = document.getElementById('city').value;
        const street            = document.getElementById('street').value;

        var country2            = encodeURIComponent(document.getElementById('country').value);
        var city2               = encodeURIComponent(document.getElementById('city').value);
        var street2             = encodeURIComponent(document.getElementById('street').value);

        const apiUrl            = `/find-location?country=${encodeURIComponent(country)}&city=${encodeURIComponent(city)}&street=${encodeURIComponent(street)}`;
        let nominatimUrl        = `https://nominatim.openstreetmap.org/search?country=${country2}&city=${city2}&street=${street2}&format=json`;

        let locationResponse    = await fetch(nominatimUrl);
        let locationData        = await locationResponse.json();


        if (locationData.length > 0) {
                let lat = locationData[0].lat;
                let lon = locationData[0].lon;

                var marker = L.marker([lat, lon], {
                    icon: createCustomMarkerIcon()
                })
                    .bindPopup(createPopupContent(country, city, street))
                    .addTo(markerCluster);

                map.flyTo([lat, lon], 18, {
                    duration: 2,  
                    easeLinearity: 0.5  
                });
                

                marker.openPopup();

                markers.push([lat, lon]);
                createPolyline(markers);

                const area = calculatePolygonArea(markers);
                document.getElementById('area-value').innerText = area.toFixed(2) + ' sq km';

                if (lastMarkerCoordinates) {
                    const latlng1   = L.latLng(lastMarkerCoordinates);
                    const latlng2   = L.latLng([lat, lon]);
                    const abLength  = latlng1.distanceTo(latlng2) / 1000;
                    document.getElementById('ab-length-value').innerText = abLength.toFixed(2) + ' km';
                }

                lastMarkerCoordinates = [lat, lon];

                var url = "{{ route('map.save') }}";

                var data = {
                    country:    country2,
                    city:       city2,
                    street:     street2
                };

                let response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(data)
                });

                if (!response.ok) {
                    let text = await response.text();
                    throw new Error(text || 'Network response was not ok');
                }

                let saveData = await response.json();
                console.log('Data saved successfully:', saveData);
            } else {
                console.error('Location not found');
            }

            fetch(apiUrl)
                .then(response  => response.json())
                .then(data      => {
                    const addressList = $('#address-list');
                    addressList.empty();

                    const completeAddressArray = [];

                    if (data && data.data.length > 0) {
                        data.data.forEach(item      => {
                            const completeAddress   = {
                                display_name: item.display_name,
                                lat: item.lat,
                                lon: item.lon,
                            };

                            completeAddressArray.push(completeAddress);

                            addressList.append(new Option(item.display_name, item.display_name));

                            console.log('Complete Address Details:', item);
                        });
                    } else {
                        addressList.append(new Option(__('No Results Found'), ""));
                    }

                    console.log('Complete Address Details Array:', completeAddressArray);

                    addressList.trigger('change');
                })
                .catch(error => console.error('Error:', error));
            }
    markerCluster.addTo(map);










</script>

    @endsection