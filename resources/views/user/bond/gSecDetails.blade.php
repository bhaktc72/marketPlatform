@extends('layouts.user')

@section('content')
    <title>Bond Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .buy-btn {
            background-color: #28a745;
            color: #fff;
        }

        .sell-btn {
            background-color: #dc3545;
            color: #fff;
        }

        .custom-table {
            width: 100%;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 8px;
        }

        .border-right {
            border-right: 1px solid #ddd;
        }
    </style>

    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-header bg-gradient-primary text-white">
                <h5 class="card-title text-center" style="color: black"><strong>Goverment Securities Bond Details</strong></h5>
            </div>
            <div class="card-body">
                <!-- Top Section -->
                <div class="row mb-3">
                    <div class="col-md-6 fw-bold">IS4835TU84N5</div>
                    <div class="col-md-6 text-end fw-bold">Last Traded Price - ₹ 100.40</div>
                </div>

                <!-- Main Content Section -->
                <div class="row">
                    <!-- Left Side -->
                    <div class="col-md-6 border-right">
                        <p><strong>Maturity Date:</strong> 25-11-2024</p>
                        <p><strong>Coupon Rate:</strong> 6.07%</p>
                        <p><strong>Face Value:</strong> 10</p>
                        <p><strong>Issue Date:</strong> 10</p>
                        <p><strong>Coupon Frequency:</strong> 10</p>
                        <p><strong>Residual Maturity:</strong> 10</p>
                    </div>

                    <!-- Right Side -->
                    <div class="col-md-6">
                        <p><strong>YTM at LTP:</strong> [Calculation]</p>
                        <p><strong>Duration:</strong> [Calculation]</p>
                        <p><strong>M - Duration:</strong> [Calculation]</p>
                        <p><strong>Convexity:</strong> [Calculation]</p>
                        <p><strong>Accrued Interest:</strong> [Calculation]</p>
                        <p><strong>PV01:</strong> [Calculation]</p>
                    </div>
                </div>

                <!-- Buttons Section -->
                <div class="row mt-3">
                    <div class="col-md-6 text-center">
                        <button class="btn buy-btn w-50">Buy</button>
                    </div>
                    <div class="col-md-6 text-center">
                        <button class="btn sell-btn w-50">Sell</button>
                    </div>
                </div>

                <!-- Prices and Quantities Section -->
                <div class="row mt-3 text-center">
                    <div class="col-md-6">
                        <p><strong>Bid Price</strong></p>
                        <p>₹ 100.40</p>
                        <p><strong>Qty</strong>: 50</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Ask Price</strong></p>
                        <p>₹ 101.60</p>
                        <p><strong>Qty</strong>: 50</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
@endsection
