@extends('auth.layouts')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js"></script>

    

<style>
    
    #currency-chart-container {
        width: 100%; 
        margin: 0 auto; 
    }

    #currency-line-chart-container {
        width: 100%; 
        margin: 0 auto; 
    }

    canvas {
        width: 90%;
        height: 90%;
    }

    #calendar {
        width: 100%
    }
</style>

<div id="currency-chart-container">
    <canvas id="currency-chart"></canvas>
</div>
<div id="currency-line-chart-container">
    <canvas id="currency-line-chart"></canvas>
</div>
<div class="row">
    <div class="col-6">
        <div id="calendar"></div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label for="startDateInput">{{ __('Start Date:') }}</label>
            <input type="date" id="startDateInput" class="form-control">
        </div>
        <div class="form-group">
            <label for="endDateInput">{{ __('End Date:') }}</label>
            <input type="date" id="endDateInput" class="form-control">
        </div>
        <button type="button" class="btn btn-primary" onclick="FetchCustomTimeframe()">{{ __('Submit') }}</button>
        <br>
        <br>
            {{ __('Sort By Last:') }}<br>
        <button type="button" class="btn btn-primary" onclick="FetchDay()" >{{ __('Day') }}</button>
        <button type="button" class="btn btn-primary" onclick="FetchWeek()" >{{ __('Week') }}</button>
        <button type="button" class="btn btn-primary" onclick="FetchMonth()" >{{ __('Month') }}</button>
        <button type="button" class="btn btn-primary" onclick="FetchYear()" >{{ __('Year') }}</button>
        <br>
        <br>
        <div class="calendar" id="calendar-info" >
            <input type="text" id="calendar-text-start" readonly />
            <input type="text" id="calendar-text-end" readonly />
            <button type="button" class="btn btn-primary" onclick="FetchFrame()" >{{ __('Submit') }}</button>
        </div>
    </div>   
</div>

@include('partials.break')

<script >


    var startDate;
    var endDate;
    var calendar;
    var calendarEl;
    let selectingStartDate = true; 
    var backgroundEvent = null;
    var formattedDate;
    

    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM Content Loaded');  
        calendarEl = document.getElementById('calendar');

        calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: [],
            selectable: true,
            select: function(info) {
                var selectedDate = info.start;

                

                formattedDate = formatLocalDate(selectedDate);

                if (selectingStartDate) {
                    const endDateInput = document.getElementById("calendar-text-end");
                    if (endDateInput.value && formattedDate > endDateInput.value) {
                        endDateInput.value = '';
                    }
                    document.getElementById("calendar-text-start").value = formattedDate;
                } else {
                    const startDateValue = document.getElementById("calendar-text-start").value;
                    if (startDateValue && formattedDate < startDateValue) {
                        document.getElementById("calendar-text-start").value = formattedDate;
                    } else {
                        document.getElementById("calendar-text-end").value = formattedDate;
                    }
                }
                selectingStartDate = !selectingStartDate;
            }
        });

        calendar.render();
        
        FetchYear();
    });






    function FetchFrame() {
        startDate = document.getElementById("calendar-text-start").value;
        endDate = document.getElementById("calendar-text-end").value;

        var endDateObj = new Date(endDate);
        endDateObj.setDate(endDateObj.getDate());
        endDate = endDateObj.toISOString().slice(0, 10);

        

        if (backgroundEvent !== null ) {
            backgroundEvent.remove();
        }


        var event = {
            //title: '',
            start: startDate, 
            end: endDate ,
            display: 'background', 
            backgroundColor: 'lightblue' 
        };

        //calendar.addEvent(event);

        backgroundEvent = calendar.addEvent(event);

        calendar.render();

        console.log("Start Date: " + startDate);
        console.log("End Date: " + endDate);

        fetchLineChartData(startDate, endDate);
    }
    


    



    function FetchCustomTimeframe() {
        var startInput = document.getElementById('startDateInput');
        var endInput = document.getElementById('endDateInput');

        startDate = startInput.value;
        endDate = endInput.value;

        fetchLineChartData(startDate, endDate);
    }









    function FetchDay() {
        var yesterday = new Date();
        yesterday.setDate(yesterday.getDate() );
        var yyyy = yesterday.getFullYear();
        var mm = String(yesterday.getMonth() + 1).padStart(2, '0');
        var dd = String(yesterday.getDate()).padStart(2, '0');
        startDate = endDate = `${yyyy}-${mm}-${dd}`;

        const conversionUrl = `https://currency-conversion-and-exchange-rates.p.rapidapi.com/timeseries?start_date=${startDate}&end_date=${endDate}&from=USD&to=EUR`;

        calendar.destroy();

        calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridDay', 
            defaultDate: startDate, 
            events: []
        });

        calendar.render();

        fetchLineChartData(startDate, endDate);
    }




    function FetchWeek() {
        var yesterday = new Date();
        yesterday.setDate(yesterday.getDate() ); 

        var startDate = new Date(yesterday);
        startDate.setDate(startDate.getDate() - 6); 

        var yyyyStart = startDate.getFullYear();
        var mmStart = String(startDate.getMonth() + 1).padStart(2, '0');
        var ddStart = String(startDate.getDate()).padStart(2, '0');

        var yyyyEnd = yesterday.getFullYear();
        var mmEnd = String(yesterday.getMonth() + 1).padStart(2, '0');
        var ddEnd = String(yesterday.getDate()).padStart(2, '0');

        startDate = `${yyyyStart}-${mmStart}-${ddStart}`;
        var endDate = `${yyyyEnd}-${mmEnd}-${ddEnd}`; 

        calendar.destroy();

        calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth', 
            initialDate: startDate, 
            events: []
        });

        calendar.render();

        fetchLineChartData(startDate, endDate);
    }







    function FetchMonth() {
        var yesterday = new Date();
        yesterday.setDate(yesterday.getDate());

        var startDate = new Date(yesterday);
        startDate.setDate(startDate.getDate() - 30);

        var yyyyStart = startDate.getFullYear();
        var mmStart = String(startDate.getMonth() + 1).padStart(2, '0');
        var ddStart = String(startDate.getDate()).padStart(2, '0');

        var yyyyEnd = yesterday.getFullYear();
        var mmEnd = String(yesterday.getMonth() + 1).padStart(2, '0');
        var ddEnd = String(yesterday.getDate()).padStart(2, '0');

        startDate = `${yyyyStart}-${mmStart}-${ddStart}`;
        var endDate = `${yyyyEnd}-${mmEnd}-${ddEnd}`; 

        calendar.destroy();

        calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            initialDate: startDate,
            events: []
        });

        calendar.render();

        fetchLineChartData(startDate, endDate);
    }









    
    function FetchYear() {
        var yesterday = new Date();
        yesterday.setDate(yesterday.getDate()); 

        var startDate = new Date(yesterday);
        startDate.setDate(startDate.getDate() - 365); 

        var yyyyStart = startDate.getFullYear();
        var mmStart = String(startDate.getMonth() + 1).padStart(2, '0');
        var ddStart = String(startDate.getDate()).padStart(2, '0');

        var yyyyEnd = yesterday.getFullYear();
        var mmEnd = String(yesterday.getMonth() + 1).padStart(2, '0');
        var ddEnd = String(yesterday.getDate()).padStart(2, '0');

        startDate = `${yyyyStart}-${mmStart}-${ddStart}`;
        var endDate = `${yyyyEnd}-${mmEnd}-${ddEnd}`; 

        calendar.destroy();

        calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            initialDate: startDate,
            events: [],
            selectable: true,  
            select: function(info) {
                var selectedDate = info.start;

                formattedDate = formatLocalDate(selectedDate);

                if (selectingStartDate) {
                    const endDateInput = document.getElementById("calendar-text-end");
                    if (endDateInput.value && formattedDate > endDateInput.value) {
                        endDateInput.value = '';
                    }
                    document.getElementById("calendar-text-start").value = formattedDate;
                } else {
                    const startDateValue = document.getElementById("calendar-text-start").value;
                    if (startDateValue && formattedDate < startDateValue) {
                        document.getElementById("calendar-text-start").value = formattedDate;
                    } else {
                        document.getElementById("calendar-text-end").value = formattedDate;
                    }
                }
                selectingStartDate = !selectingStartDate;
            }
        });

        calendar.render();

        fetchLineChartData(startDate, endDate);
    }











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













    async function fetchLineChartData(startDate, endDate) {
        const conversionUrl = `https://currency-conversion-and-exchange-rates.p.rapidapi.com/timeseries?start_date=${startDate}&end_date=${endDate}&from=USD&to=EUR`;

        const conversionOptions = {
            method: 'GET',
            headers: {
                'X-RapidAPI-Key': '0adea46058msh1f3aaaf0ee6d382p1855fcjsnc4ac19517b10',
                'X-RapidAPI-Host': 'currency-conversion-and-exchange-rates.p.rapidapi.com'
            }
        };

        try {
            if (lineChart) {
                lineChart.destroy();
            }
            const lineChartResponse = await fetch(conversionUrl, conversionOptions);
            const lineChartResult   = await lineChartResponse.json();

            if (lineChartResult.rates) {
                const originalData = Object.entries(lineChartResult.rates).map(([date, rates]) => ({
                    date,
                    value: rates.USD 
                }));

                const data = [...originalData];
                data.sort((a, b) => new Date(a.date) - new Date(b.date));

                const dates     = data.map(item => item.date);
                const values    = data.map(item => item.value);

                const lineChartCtx = document.getElementById('currency-line-chart').getContext('2d');

                lineChart = new Chart(lineChartCtx, {
                    type: 'line',
                    data: {
                        labels: dates, 
                        datasets: [{
                            label: 'USD to EUR Exchange Rate',
                            data: values, 
                            backgroundColor: 'rgba(1, 192, 192, 0.2)',
                            borderColor: 'rgba(1, 192, 192, 1)',
                            borderWidth: 1,
                            fill: true,
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
                                    text: '1 EUR to USD'
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
                                        const item = originalData[context.dataIndex];
                                        return `Date: ${item.date}, Value: ${item.value}`;
                                    }
                                }
                            }
                        }
                    }
                });
            } else {
                console.error('No exchange rate data found in the API response.');
            }
        } catch (error) {
            console.error('Error fetching or rendering chart:', error);
        }
    }

fetchLineChartData(startDate, endDate);




    function formatLocalDate(date) {
        var day = ("0" + date.getDate()).slice(-2);
        var month = ("0" + (date.getMonth() + 1)).slice(-2);
        var year = date.getFullYear();

        return year + "-" + month + "-" + day;
    }








</script>

@endsection