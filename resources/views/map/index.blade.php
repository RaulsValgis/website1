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

        </div>
    </div>

<script>
    var map = L.map('map').setView([57.54108, 25.42751], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {}).addTo(map);
    var currentMarker = null;

    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });

    async function findLocation() {
        const country = document.getElementById('country').value;
        const city = document.getElementById('city').value;
        const street = document.getElementById('street').value;

        var country2 = encodeURIComponent(document.getElementById('country').value);
        var city2 = encodeURIComponent(document.getElementById('city').value);
        var street2 = encodeURIComponent(document.getElementById('street').value);

        // Construct the query URL for the new Laravel route
        const apiUrl = `/find-location?country=${encodeURIComponent(country)}&city=${encodeURIComponent(city)}&street=${encodeURIComponent(street)}`;
        let nominatimUrl = `https://nominatim.openstreetmap.org/search?country=${country2}&city=${city2}&street=${street2}&format=json`;

        let locationResponse = await fetch(nominatimUrl);
        let locationData = await locationResponse.json();

        if (locationData.length > 0) {
                let lat = locationData[0].lat;
                let lon = locationData[0].lon;
                if (currentMarker) {
                    map.removeLayer(currentMarker);
                }

                currentMarker = L.marker([lat, lon]).addTo(map);
                map.setView([lat, lon], 20);

                var url = "{{ route('map.save') }}";

                var data = {
                    country: country2,
                    city: city2,
                    street: street2
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
        // Make AJAX request to the Laravel route
        fetch(apiUrl)
            .then(response => response.json())
            .then(data => {
                const addressList = $('#address-list');
                addressList.empty();

                if (data && data.data.length > 0) {
                    data.data.forEach(item => {
                        addressList.append(new Option(item.display_name, item.display_name));
                    });
                } else {
                    addressList.append(new Option('No results found.', ''));
                }

                // Refresh Select2 to reflect the updated options
                addressList.trigger('change');

            })
            .catch(error => console.error('Error:', error));
    }
</script>

@endsection
