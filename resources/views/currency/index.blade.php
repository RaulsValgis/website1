@extends('auth.layouts')

@section('content')
<style>
    #currency-chart-container {
        width: 100%; /* Adjust width as needed */
        margin: 0 auto; /* Center the chart container */
    }

    #currency-line-chart-container {
        width: 100%; /* Adjust width as needed */
        margin: 0 auto; /* Center the chart container */
    }

    /* Ensure the canvas fills its parent container */
    canvas {
        width: 90%;
        height: 90%;
    }
</style>

<div id="currency-chart-container">
    <canvas id="currency-chart"></canvas>
</div>
<div id="currency-line-chart-container">
    <canvas id="currency-line-chart"></canvas>
</div>

<script>















    const top10Currencies = ['USD', 'EUR', 'JPY', 'GBP', 'AUD', 'CAD', 'CHF', 'CNY', 'SEK', 'NZD'];
    const url = `https://exchange-rate-api1.p.rapidapi.com/latest?base=USD&symbols=${top10Currencies.join(',')}`;
    const options = {
        method: 'GET',
        headers: {
            'X-RapidAPI-Key': '0adea46058msh1f3aaaf0ee6d382p1855fcjsnc4ac19517b10',
            'X-RapidAPI-Host': 'exchange-rate-api1.p.rapidapi.com'
        }
    };


    let chart;
    let lineChart;














    async function fetchData() {
        try {
            const response  = await fetch(url, options);
            const result    = await response.json();

            const currencies        = Object.keys(result.rates);
            const currencyValues    = Object.values(result.rates);

            if (chart) {
                chart.destroy();
            }

            const randomColors = currencies.map(() => getRandomColor());

            const ctx   = document.getElementById('currency-chart').getContext('2d');
            chart       = new Chart(ctx, {
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

    fetchData();

    // Fetch data every 30 seconds
    // Ja es uzlieku, ātri beidzas api limit
    // setInterval(fetchData, 30000);













    function getRandomColor() {
        const letters = '0123456789ABCDEF';
        let color = '#';
        for (let i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }













    async function fetchLineChartData() {
        const startDate = '2019-01-01';
        const endDate = '2019-12-31';

        const conversionUrl = `https://currency-conversion-and-exchange-rates.p.rapidapi.com/timeseries?start_date=${startDate}&end_date=${endDate}&from=USD&to=EUR`;

        const conversionOptions = {
            method: 'GET',
            headers: {
                'X-RapidAPI-Key': '0adea46058msh1f3aaaf0ee6d382p1855fcjsnc4ac19517b10',
                'X-RapidAPI-Host': 'currency-conversion-and-exchange-rates.p.rapidapi.com'
            }
        };

        try {
            const lineChartResponse = await fetch(conversionUrl, conversionOptions);
            const lineChartResult = await lineChartResponse.json();

            const dates = Object.keys(lineChartResult.rates);
            const values = Object.values(lineChartResult.rates);

            console.log('dates ',dates);
            console.log('values ',values)

            const data = dates.map((date, index) => ({
                date: date,
                value: values[index]
            }));

            const lineChartCtx = document.getElementById('currency-line-chart').getContext('2d');

            const lineChart = new Chart(lineChartCtx, {
                type: 'line',
                data: {
                    labels: data.map(item => item.date),
                    datasets: [{
                        label: 'Values',
                        data: data.map(item => item.value),
                        backgroundColor: 'rgba(1, 192, 192, 1)',
                        borderColor: 'rgba(1, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Time Period'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Rates'
                            },
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
                        },
                        tooltip: {
                            callbacks: {
                                label: (context) => {
                                    const item = data[context.dataIndex];
                                    return `Date: ${item.date}, Value: ${item.value}`;
                                }
                            }
                        }
                    },
                }
            });
        } catch (error) {
            console.error('Error fetching or rendering chart:', error);
        }
    }

// Call the function to fetch and display the chart
fetchLineChartData();










</script>

@endsection