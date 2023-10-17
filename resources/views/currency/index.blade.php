@extends('auth.layouts')

@section('content')

<div id="currency-chart-container">
    <canvas id="currency-chart"></canvas>
</div>

<script>
    const top10Currencies = ['USD', 'EUR', 'JPY', 'GBP', 'AUD', 'CAD', 'CHF', 'CNY', 'SEK', 'NZD'];

    const url = 'https://exchange-rates-api2.p.rapidapi.com/latest?from=EUR&to=USD,JPY,GBP,AUD,CAD,CHF,CNY,SEK,NZD';
    const options = {
        method: 'GET',
        headers: {
            'X-RapidAPI-Key': '0adea46058msh1f3aaaf0ee6d382p1855fcjsnc4ac19517b10',
            'X-RapidAPI-Host': 'exchange-rates-api2.p.rapidapi.com'
        }
    };

    let chart; // Variable to store the Chart instance

    async function fetchData() {
        try {
            const response = await fetch(url, options);
            const result = await response.json();

            // Assuming the response contains the exchange rates
            const currencies = Object.keys(result.rates);
            const currencyValues = Object.values(result.rates);

            // Destroy the previous Chart instance if it exists
            if (chart) {
                chart.destroy();
            }

            // Generate random colors for each country
            const randomColors = currencies.map(() => getRandomColor());

            // Create the chart
            const ctx = document.getElementById('currency-chart').getContext('2d');
            chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: currencies,
                    datasets: [{
                        label: 'Currency Values',
                        data: currencyValues,
                        backgroundColor: randomColors,
                        borderColor: 'rgba(1, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                            labels: {
                                fontColor: 'black',
                                fontSize: 12,
                                boxWidth: 15
                            }
                        }
                    }
                }
            });
        } catch (error) {
            console.error(error);
        }
    }

    // Initial fetch
    fetchData();

    // Fetch data every 30 seconds
    setInterval(fetchData, 30000);

    function getRandomColor() {
        const letters = '0123456789ABCDEF';
        let color = '#';
        for (let i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }
</script>

@endsection