@extends('user.layouts.app')

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

    <div class="container mt-4 mb-4">
        <div class="card shadow">
            <div class="card-header bg-gradient-primary text-white">
                <h5 class="card-title text-center" style="color: black"><strong>SDL Bond Details</strong></h5>
            </div>
            <div class="card-body">
                <!-- Top Section -->
                <div class="row mb-3">
                    <div class="col-md-6 fw-bold">{{ $stateBond->isin }}</div>
                    <div class="col-md-6 text-end fw-bold">Last Traded Price - ₹ {{ $stateBond->price ?? 'N/A' }}</div>
                </div>

                <!-- Main Content Section -->
                <div class="row">
                    <!-- Left Side -->
                    <div class="col-md-6 border-right">
                        <p><strong>Maturity Date:</strong> {{ $stateBond->maturity_date }}</p>
                        <p><strong>Coupon Rate:</strong> {{ $stateBond->coupon_rate }}%</p>
                        <p><strong>Face Value:</strong> ₹ {{ $stateBond->face_value }}</p>
                        <p><strong>Issue Date:</strong> {{ $stateBond->issue_date }}</p>
                        <p><strong>Coupon Frequency:</strong> {{ $stateBond->coupon_frequency }} years</p>
                        <p><strong>Residual Maturity:</strong> {{ $stateBond->residual_maturity }} years</p>
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
                        <button class="btn buy-btn w-50" data-bs-toggle="modal" data-bs-target="#tradeModal" data-type="buy">Buy</button>
                    </div>
                    <div class="col-md-6 text-center">
                        <button class="btn sell-btn w-50" data-bs-toggle="modal" data-bs-target="#tradeModal" data-type="sell">Sell</button>
                    </div>
                </div>

                <!-- Prices and Quantities Section -->
                <div class="row mt-3 text-center">
                    <div class="col-md-6">
                        <p><strong>Bid Price</strong></p>
                        <p>₹ {{ $stateBond->bid_price ?? 'N/A' }}</p>
                        <p><strong>Qty</strong>: {{ $stateBond->bid_qty ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Ask Price</strong></p>
                        <p>₹ {{ $stateBond->ask_price ?? 'N/A' }}</p>
                        <p><strong>Qty</strong>: {{ $stateBond->ask_qty ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Buy/Sell Modal -->
    <div class="modal fade" id="tradeModal" tabindex="-1" aria-labelledby="tradeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tradeModalLabel">Trade Bond</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="tradeForm">
                        <input type="hidden" id="bond_id" name="bond_id" value="{{ $stateBond->id }}">
                        <input type="hidden" id="trade_type" name="trade_type">

                        <div class="mb-3">
                            <label class="form-label">Bond Name</label>
                            <input type="text" class="form-control" id="bond_name" name="bond_name" value="{{ $stateBond->isin }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Price (₹)</label>
                            <input type="number" class="form-control" id="trade_price" name="trade_price" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="trade_quantity" name="trade_quantity" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Submit Order</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            console.log("DOM fully loaded and parsed");

            let tradeModal = document.getElementById("tradeModal");

            if (tradeModal) {
                tradeModal.addEventListener("show.bs.modal", function(event) {
                    console.log("Modal show event triggered");
                    let button = event.relatedTarget;
                    let tradeType = button.getAttribute("data-type");

                    document.getElementById("trade_type").value = tradeType;
                    document.getElementById("tradeModalLabel").textContent = tradeType === "buy" ? "Buy Bond" : "Sell Bond";
                });
            }

            let tradeForm = document.getElementById("tradeForm");
            if (tradeForm) {
                tradeForm.addEventListener("submit", function(event) {
                    console.log("Form submit event triggered");
                    event.preventDefault();

                    let formData = new FormData(this);
                    let jsonObject = {};
                    formData.forEach((value, key) => jsonObject[key] = value);

                    console.log("Form data:", jsonObject);

                    fetch("{{ route('execute.trade') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: JSON.stringify(jsonObject)
                        })
                        .then(response => {
                            console.log("Response received");
                            return response.json();
                        })
                        .then(data => {
                            console.log("Response data:", data);
                            alert(data.message);
                            location.reload();
                        })
                        .catch(error => {
                            console.error("Error:", error);
                            alert("An error occurred. Please check the console.");
                        });
                });
            }
        });
    </script>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
@endsection
