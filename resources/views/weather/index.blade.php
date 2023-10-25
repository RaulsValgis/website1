@extends('auth.layouts')

@section('content')
<style>

    .size {
        font-size: 200%;
    }



</style>

<div class="row">
    <div class="col-6">
        <!-- chart -->
        <h1 class="size">{{ __('Todays Forecast') }}</h1>
        <canvas id="hourlyChart" width="500" height="300"></canvas>
    </div>
    <div class="col-6">
        <!-- data -->
        <h1 class="size">{{ __('5-Day Forecast') }}</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>{{ __('Day') }}</th>
                    <th>{{ __('Date') }}</th>
                    <th>{{ __('Weather') }}</th>
                    <th>{{ __('Temperature') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($translatedDailyForecasts as $forecast)
                    <tr>
                        <td>{{ $forecast['day'] }}</td>
                        <td>{{ $forecast['date'] }}</td>
                        <td><img src="https://openweathermap.org/img/wn/{{ $forecast['icon'] }}.png" alt="Weather Icon">   {{ $forecast['description'] }}</td>
                        <td>
                            {{ number_format($forecast['temp_min'], 1) }}°C - {{ number_format($forecast['temp_max'], 1) }}°C
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>







<script>


    
    var labels = @json($labels); // Assuming this array contains time data
    var windSpeedData = @json($windSpeedData); // An array of wind speed data

    var labelsWithWindSpeed = labels.map(function (time, index) {
        return time + '\n (' + windSpeedData[index] + ' m/s)';
    });

    var ctx = document.getElementById('hourlyChart').getContext('2d');
    var hourlyChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labelsWithWindSpeed,
            datasets: [
                {
                    label:  '{{ __('Temperature (°C)') }}' ,
                    data: @json($data),
                    borderColor: 'blue',
                    borderWidth: 1,
                },
            ],
        },
        options: {
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                },
            },
            scales: {
                y: {
                    beginAtZero: true,
                },
            },
            tooltips: {
                callbacks: {
                    label: function (tooltipItem) {
                        // Split the label into time and wind speed
                        var labelParts = tooltipItem.label.split('\n');
                        var time = labelParts[0];
                        var windSpeed = labelParts[1];

                        // Apply custom CSS to make the time label bold
                        var timeLabel = '<span style="font-weight: bold;">' + time + '</span>';

                        // You can now use 'time' and 'windSpeed' separately if needed
                        return timeLabel + '\n (' + windSpeed + ' m/s)';
                    },
                },
            },
        },
    });
        




</script>







@endsection