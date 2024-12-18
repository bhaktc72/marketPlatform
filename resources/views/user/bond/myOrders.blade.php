@extends('layouts.user')

@section('content')
    <title>Order List</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .order-card {
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 10px;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .order-info {
            display: flex;
            align-items: center;
        }

        .order-info span {
            margin-right: 10px;
        }

        .badge-success {
            background-color: #28a745;
        }

        .badge-danger {
            background-color: #dc3545;
        }

        .order-status {
            display: flex;
            align-items: center;
        }

        .order-status .badge {
            margin-left: 10px;
        }
    </style>

    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-header bg-gradient-primary text-white">
                <h5 class="card-title text-center" style="color: black"><strong>My Order</strong></h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="order-card">
                            <div class="order-info">
                                <span class="badge badge-success">Buy</span>
                                <span>IS4835TU84N5</span>
                                <span>Ordered Price - ₹ 100.40</span>
                            </div>
                            <div class="order-status">
                                <span>10:15 AM</span>
                                <span class="badge badge-success">Successful</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="order-card">
                            <div class="order-info">
                                <span class="badge badge-danger">Sell</span>
                                <span>IS4835TU84N5</span>
                                <span>Ordered Price - ₹ 103.50</span>
                            </div>
                            <div class="order-status">
                                <span>12:15 PM</span>
                                <span class="badge badge-success">Successful</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection
