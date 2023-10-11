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

<div class="container">
    <div class="row">
        <div class="col-10">
            <div id="map" style="height: 800px; width: 100%;"></div>
        </div>
        <div class="col-2">
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
        </div> 
    </div>
</div>

<script>
    var map = L.map('map').setView([57.54108, 25.42751], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {}).addTo(map);
    var currentMarker = null;

    async function findLocation() {
        var country = encodeURIComponent(document.getElementById('country').value);
        var city = encodeURIComponent(document.getElementById('city').value);
        var street = encodeURIComponent(document.getElementById('street').value);

        // Use Nominatim API to get the latitude and longitude
        let nominatimUrl = `https://nominatim.openstreetmap.org/search?country=${country}&city=${city}&street=${street}&format=json`;

        try {
            let locationResponse = await fetch(nominatimUrl);
            let locationData = await locationResponse.json();

            if (locationData.length > 0) {
                let lat = locationData[0].lat;
                let lon = locationData[0].lon;

                if (currentMarker) {
                    map.removeLayer(currentMarker);  // Remove the previous marker
                }

                currentMarker = L.marker([lat, lon]).addTo(map);
                map.setView([lat, lon], 30);

                var url = "{{ route('map.save') }}";

                var data = {
                    country: country,
                    city: city,
                    street: street
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
        } catch (error) {
            console.error('Error:', error);
        }
    }
</script>
@endsection