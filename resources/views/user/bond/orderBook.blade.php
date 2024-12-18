@extends('layouts.user')

@section('content')
    <title>Order List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .order-card {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 10px 15px;
            margin-bottom: 10px;
        }

        .status-dot {
            height: 10px;
            width: 10px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 5px;
        }

        .status-buy {
            background-color: green;
        }

        .status-sell {
            background-color: red;
        }

        .btn-action {
            width: 80px;
        }

        .btn-action-cancel:hover {
            background-color: red;
            color: white;

        }

        .btn-action-modify:hover {
            background-color: green;
            color: white;

        }

        .fw-bold {
            font-weight: bold;
        }
    </style>

    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-header bg-gradient-primary text-white">
                <h5 class="card-title text-center" style="color: black"><strong>Order Book</strong></h5>
            </div>
            <div class="card-body">
                <!-- Order 1 - Buy -->
                <div class="order-card d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <span class="status-dot status-buy"></span>
                        <div>
                            <div class="fw-bold">Buy &nbsp; <span>IS4835TU84N5</span></div>
                            <div>Ordered Price - ₹ 100.40</div>
                        </div>
                    </div>
                    <div>
                        <button class="btn btn-outline-secondary btn-action btn-action-modify">Modify</button>
                        <button class="btn btn-outline-secondary btn-action btn-action-cancel">Cancel</button>
                    </div>
                </div>

                <!-- Order 2 - Sell -->
                <div class="order-card d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <span class="status-dot status-sell"></span>
                        <div>
                            <div class="fw-bold">Sell &nbsp; <span>IS4835TU8489</span></div>
                            <div>Ordered Price - ₹ 101.40</div>
                        </div>
                    </div>
                    <div>
                        <button class="btn btn-outline-secondary btn-action btn-action-modify">Modify</button>
                        <button class="btn btn-outline-secondary btn-action btn-action-cancel">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
@endsection
