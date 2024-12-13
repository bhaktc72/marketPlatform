@extends('layouts.app')

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <!-- Dashboard Header -->
            <div class="row">
                <div class="col-md-12 text-center mb-4">
                    <h2 class="text-success">Stock Market Dashboard</h2>
                    <h4>Welcome to the Admin Panel. Manage the market sessions below.</h4>
                </div>
            </div>

            <!-- Market Overview -->
            <div class="row row-cols-1 row-cols-md-3">
                <div class="col">
                    <div class="card shadow">
                        <div class="card-header bg-gradient-success text-white">
                            <h5 class="card-title">Market Overview</h5>
                        </div>
                        <div class="card-body text-center">
                            <h3 class="text-primary" id="sensexValue">Loading...</h3>
                            <h5>Nifty: 16,800</h5>
                            <p class="text-muted">Market Status: <span class="text-success">Bullish</span></p>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card shadow">
                        <div class="card-header bg-gradient-info text-white">
                            <h5 class="card-title">Top Gainers</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled">
                                <li><strong>Reliance:</strong> ₹2,500 (+2.5%)</li>
                                <li><strong>Tata Motors:</strong> ₹460 (+3.8%)</li>
                                <li><strong>HDFC Bank:</strong> ₹1,600 (+1.2%)</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card shadow">
                        <div class="card-header bg-gradient-danger text-white">
                            <h5 class="card-title">Top Losers</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled">
                                <li><strong>ICICI Bank:</strong> ₹700 (-1.8%)</li>
                                <li><strong>Axis Bank:</strong> ₹820 (-2.0%)</li>
                                <li><strong>Tech Mahindra:</strong> ₹1,100 (-2.5%)</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Trading Session -->
            @role('Admin')
                <div class="row justify-content-center mt-5">
                    <div class="col-md-6 text-center mb-5">
                        <h3 class="mb-3">You can manage Session from here</h3>
                        <div class="d-flex justify-content-center mt-4">
                            <!-- Start Button (Green) -->
                            <button class="btn btn-success me-3" id="startButton">Start Session</button>
                            <!-- End Button (Red) -->
                            <button class="btn btn-danger" id="endButton">End Session</button>
                        </div>
                    </div>
                </div>
            @endrole

        </div>
        <!-- content-wrapper ends -->

        <!-- partial:partials/_footer.html -->
        <footer class="footer">
            <div class="container-fluid d-flex justify-content-between">
                <span class="text-muted d-block text-end text-sm-start d-sm-inline-block">Copyright ©
                    Bhakt Chotaliya & Kevil Gandhi 2024-25</span>
            </div>
        </footer>
        <!-- partial -->
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Fetch live data using AJAX
        // Fetch live data using AJAX
        function fetchLiveData() {
            fetch('/stock-data')
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        // Extract the latest stock value, for example, Apple (AAPL)
                        const timeSeries = data.data;
                        const latestData = Object.values(timeSeries)[0]; // Get the most recent entry
                        const latestClose = latestData['4. close'];

                        // Update the stock value (e.g., Sensex or Apple stock price)
                        document.getElementById('sensexValue').textContent = `₹${latestClose}`;
                    } else {
                        console.error('Error fetching live stock data:', data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        // Call the fetchLiveData function when the page is loaded
        window.onload = function() {
            fetchLiveData();
        };

        // Chart.js code for market trends (keep as it is)
        var ctx = document.getElementById('marketTrendChart').getContext('2d');
        var marketTrendChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'Sensex',
                    data: [55000, 55500, 56000, 56500, 57000, 57500, 58000],
                    borderColor: 'rgba(0, 123, 255, 1)',
                    fill: false,
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return '₹' + tooltipItem.raw;
                            }
                        }
                    }
                }
            }
        });
    </script>
@endpush
