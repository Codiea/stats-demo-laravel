@extends('layout')


@section('content')
    <!-- Dashboard Analytics Start -->
    <section id="dashboard-analytics">
        <div class="row match-height">
            <!-- Greetings Card starts -->
            <div class="col-lg-6 col-md-12 col-sm-12">
                <div class="card card-congratulations">
                    <div class="card-body text-center">
                        <img src="/assets/images/elements/decore-left.png" class="congratulations-img-left"
                            alt="card-img-left" />
                        <img src="/assets/images/elements/decore-right.png" class="congratulations-img-right"
                            alt="card-img-right" />
                        <div class="avatar avatar-xl bg-primary shadow">
                            <div class="avatar-content">
                                <i data-feather="award" class="font-large-1"></i>
                            </div>
                        </div>
                        <div class="text-center">
                            <h1 class="mb-1 text-white">Congratulations John,</h1>
                            <p class="card-text m-auto w-75">
                                You have done <strong id="john_percent">...</strong> more sales this year.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Greetings Card ends -->

            <!-- Subscribers Chart Card starts -->
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-header flex-column align-items-start pb-0">
                        <div class="avatar bg-light-primary p-50 m-0">
                            <div class="avatar-content">
                                <i data-feather="users" class="font-medium-5"></i>
                            </div>
                        </div>
                        <h2 id="sub_count" class="font-weight-bolder mt-1">...</h2>
                        <p class="card-text">Subscribers Gained</p>
                    </div>
                    <div id="gained-chart"></div>
                </div>
            </div>
            <!-- Subscribers Chart Card ends -->

            <!-- Orders Chart Card starts -->
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-header flex-column align-items-start pb-0">
                        <div class="avatar bg-light-warning p-50 m-0">
                            <div class="avatar-content">
                                <i data-feather="package" class="font-medium-5"></i>
                            </div>
                        </div>
                        <h2 id="sales_count" class="font-weight-bolder mt-1">...</h2>
                        <p class="card-text">Orders Received</p>
                    </div>
                    <div id="order-chart"></div>
                </div>
            </div>
            <!-- Orders Chart Card ends -->
        </div>

        <div class="row match-height">



            <div class="col-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between pb-0">
                        <h4 class="card-title">Revenue Growth</h4>

                    </div>
                    <div class="card-body">
                        <div class="row">

                            <div class="col-sm-12 col-12 d-flex justify-content-center">
                                <div id="growth-trackers-chart"></div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-1">
                            <div class="text-center">
                                <p class="card-text mb-50 text-primary font-weight-bold">2022</p>
                                <span id="last_year_revenue" class="font-large-1 font-weight-bold">..</span>
                            </div>
                            <div class="text-center">
                                <p class="card-text mb-50 text-primary font-weight-bold">2023</p>
                                <span id="curr_year_revenue" class="font-large-1 font-weight-bold">..</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="card">
                    <div
                        class="card-header d-flex justify-content-between align-items-sm-center align-items-start flex-sm-row flex-column">
                        <div class="header-left">
                            <h4 class="card-title">Total Revenue</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="revenue-chart" class="bar-chart-ex chartjs" data-height="400"></canvas>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- Dashboard Analytics end -->
@endsection



@section('scripts')
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script>
        $(document).ready(function() {

            // Enable pusher logging - don't include this in production
            Pusher.logToConsole = true;



            function getStats() {
                $("#sub_count").text("...")
                $("#sales_count").text("...")
                $("#last_year_revenue").text("...")
                $("#curr_year_revenue").text("...")
                $("#john_percent").text("...")
                $.ajax({
                        url: "/stats",
                        type: "GET"
                    })
                    .then(function(r) {
                        const data = r
                        console.log(r)
                        $("#sub_count").text(data.sub_count)
                        $("#sales_count").text(data.sales_count)
                        $("#last_year_revenue").text("$" + data.revenue_increase.last_year)
                        $("#curr_year_revenue").text("$" + data.revenue_increase.curr_year)
                        $("#john_percent").text(data.revenue_increase.increase_percent + "%")
                        renderTotalRevenueChart(data)
                        renderGrowthChart(parseInt(data.revenue_increase.increase_percent))


                    })
            }

            function renderTotalRevenueChart(r) {
                var ctx = document.getElementById("revenue-chart");
                var mybarChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: r.revenue_comparisons.labels,
                        datasets: r.revenue_comparisons.datasets
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });
            }

            function renderGrowthChart(val) {
                let $textHeadingColor = '#5e5873';
                let $white = '#fff';
                let $strokeColor = '#ebe9f1';
                let options = {
                    chart: {
                        height: 270,
                        type: 'radialBar'
                    },
                    plotOptions: {
                        radialBar: {
                            size: 150,
                            offsetY: 20,
                            startAngle: -150,
                            endAngle: 150,
                            hollow: {
                                size: '65%'
                            },
                            track: {
                                background: $white,
                                strokeWidth: '100%'
                            },
                            dataLabels: {
                                name: {
                                    offsetY: -5,
                                    color: $textHeadingColor,
                                    fontSize: '1rem'
                                },
                                value: {
                                    offsetY: 15,
                                    color: $textHeadingColor,
                                    fontSize: '1.714rem'
                                }
                            }
                        }
                    },
                    colors: [window.colors.solid.danger],
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shade: 'dark',
                            type: 'horizontal',
                            shadeIntensity: 0.5,
                            gradientToColors: [window.colors.solid.primary],
                            inverseColors: true,
                            opacityFrom: 1,
                            opacityTo: 1,
                            stops: [0, 100]
                        }
                    },
                    stroke: {
                        dashArray: 8
                    },
                    series: [val],
                    labels: ['Revenue Growth']
                };
                $("#growth-trackers-chart").hide();
                growthTrackerChart = new ApexCharts(document.querySelector("#growth-trackers-chart"), options);
                growthTrackerChart.render();
                $("#growth-trackers-chart").show();
            }


            getStats()

            let pusher = new Pusher('d694c8082cc165f1ec9a', {
                cluster: 'ap1'
            });

            let channel = pusher.subscribe('sales-channel');
            channel.bind('add-sales-event', function(data) {
                getStats()
            });


        })
    </script>
@endsection()
