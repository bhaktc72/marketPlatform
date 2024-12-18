@extends('layouts.user')

@section('content')
    <title>Bond Purchase Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .back-arrow {
            font-size: 1.5rem;
            cursor: pointer;
        }

        .buy-btn {
            background-color: #28a745;
            color: #fff;
            width: 100%;
        }

        .input-box {
            background-color: #e0e0e0;
            border: none;
            height: 40px;
            width: 100%;
            border-radius: 5px;
            padding: 5px 10px;
        }

        .custom-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }
    </style>

    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-header bg-gradient-primary text-white">
                <h5 class="card-title text-center" style="color: black"><strong>Buy</strong></h5>
            </div>
            <div class="card-body">
                <!-- Back Arrow -->
                <div class="row mb-3">
                    <div class="col-1">
                        <span class="back-arrow">&larr;</span>
                    </div>
                    <div class="col-11 text-end fw-bold">Current Trading Price - 100.40</div>
                </div>

                <!-- Bond Details -->
                <div class="row mb-3">
                    <div class="col-12 fw-bold">IS4835TU84N5</div>
                </div>

                <!-- Input Fields -->
                <div class="row mb-3 align-items-center">
                    <div class="col-4 fw-bold">Bond Qty -</div>
                    <div class="col-8">
                        <input type="text" class="input-box" placeholder="Enter quantity">
                    </div>
                </div>

                <div class="row mb-4 align-items-center">
                    <div class="col-4 fw-bold">Set Price Limit -</div>
                    <div class="col-8">
                        <input type="text" class="input-box" placeholder="Enter price limit">
                    </div>
                </div>

                <!-- Buy Button -->
                <div class="row">
                    <div class="col-12 text-center">
                        <button class="btn buy-btn">Buy</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
@endsection
