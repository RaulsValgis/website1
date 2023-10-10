@extends('auth.layouts')

@section('content')
    <div class="row">
        <div class="col-10">
            <div id="map" style="height: 800px; width: 100%;"></div>
        </div>
        <div class="col-2">
            <div class="input">
                <input type="text" id="country" placeholder="Enter country">
            </div>
            <div class="input">
                <input type="text" id="city" placeholder="Enter city">
            </div>
            <div class="input">
                <input type="text" id="street" placeholder="Enter street">
            </div>
            <div class="input">
                <button onclick="findLocation()">Find Location</button>
            </div>
        </div> 
    </div>


















<script>



    var map = L.map('map').setView([57.54108, 25.42751], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    }).addTo(map);







        //Outside of the function: variable to hold the current marker
    var currentMarker = null;

    function findLocation() {
        var country = encodeURIComponent(document.getElementById('country').value);
        var city = encodeURIComponent(document.getElementById('city').value);
        var street = encodeURIComponent(document.getElementById('street').value);

        var query = `${street}, ${city}, ${country}`;
        var url = `https://nominatim.openstreetmap.org/search?format=json&q=${query}`;

        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data && data.length > 0) {
                    var location = data[0];
                    var latitude = parseFloat(location.lat);
                    var longitude = parseFloat(location.lon);

                    var decodedStreet = decodeURIComponent(street);
                    
                    map.setView([latitude, longitude], 20);
                    
                    // Remove the old marker if it exists
                    if (currentMarker) {
                        map.removeLayer(currentMarker);
                    }

                    // Add a new marker to the location and store its reference in currentMarker
                    currentMarker = L.marker([latitude, longitude]).addTo(map).bindPopup(`Location: ${decodedStreet}, ${city}, ${country}`).openPopup();
                    
                } else {
                    alert('Location not found.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while fetching the location.');
            });
    }



</script>

















@endsection

