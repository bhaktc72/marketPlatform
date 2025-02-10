@extends('user.layouts.app')

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

        .status-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .status-buy {
            background-color: green;
        }

        .status-sell {
            background-color: red;
        }
    </style>

    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-header bg-gradient-primary text-white">
                <h5 class="card-title text-center" style="color: black"><strong>Order Book</strong></h5>
            </div>
            <div class="card-body">
                <!-- Buy Orders Section -->
                <h6 class="text-success"><strong>Buy Orders</strong></h6>
                @foreach (['buyOrders' => 'Generic Bonds', 'stateBuyOrders' => 'State Bonds', 'centralBuyOrders' => 'Central Bonds'] as $key => $label)
                    <h6 class="mt-3 text-primary">{{ $label }}</h6>
                    @forelse ($$key as $order)
                        <div class="order-card d-flex align-items-center justify-content-between mb-2">
                            <div class="d-flex align-items-center">
                                <span class="status-dot status-buy"></span>
                                <div>
                                    <div class="fw-bold">Buy &nbsp; <span>{{ $order->bond_id }}</span></div>
                                    <div>Ordered Price - ₹ {{ number_format($order->price, 2) }}</div>
                                    <div>Quantity - {{ $order->quantity }}</div>
                                </div>
                            </div>
                            <div>
                                <button class="btn btn-outline-secondary btn-action btn-action-modify" onclick="modifyOrder({{ $order->id }}, 'buy', '{{ $order->bond_type }}')">Modify</button>
                                <button class="btn btn-outline-secondary btn-action btn-action-cancel" onclick="cancelOrder({{ $order->id }}, 'buy', '{{ $order->bond_type }}')">Cancel</button>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">No {{ $label }} buy orders.</p>
                    @endforelse
                @endforeach

                <!-- Sell Orders Section -->
                <h6 class="text-danger mt-4"><strong>Sell Orders</strong></h6>
                @foreach (['sellOrders' => 'Generic Bonds', 'stateSellOrders' => 'State Bonds', 'centralSellOrders' => 'Central Bonds'] as $key => $label)
                    <h6 class="mt-3 text-primary">{{ $label }}</h6>
                    @forelse ($$key as $order)
                        <div class="order-card d-flex align-items-center justify-content-between mb-2">
                            <div class="d-flex align-items-center">
                                <span class="status-dot status-sell"></span>
                                <div>
                                    <div class="fw-bold">Sell &nbsp; <span>{{ $order->bond_id }}</span></div>
                                    <div>Ordered Price - ₹ {{ number_format($order->price, 2) }}</div>
                                    <div>Quantity - {{ $order->quantity }}</div>
                                </div>
                            </div>
                            <div>
                                <button class="btn btn-outline-secondary btn-action btn-action-modify" onclick="modifyOrder({{ $order->id }}, 'sell', '{{ $order->bond_type }}')">Modify</button>
                                <button class="btn btn-outline-secondary btn-action btn-action-cancel" onclick="cancelOrder({{ $order->id }}, 'sell', '{{ $order->bond_type }}')">Cancel</button>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">No {{ $label }} sell orders.</p>
                    @endforelse
                @endforeach
            </div>
        </div>
    </div>

    <script>
        function modifyOrder(orderId, type, bondType) {
            const newPrice = prompt('Enter the new price:');
            const newQuantity = prompt('Enter the new quantity:');

            if (newPrice && newQuantity) {
                // Check if type and bondType are valid
                if (!type || !bondType) {
                    console.error('Missing type or bondType');
                    return;
                }

                const csrfToken = document.querySelector('meta[name="csrf-token"]');

                if (!csrfToken) {
                    console.error('CSRF token not found on the page.');
                    return; // Prevent further execution if CSRF token is missing
                }

                // Construct the URL with valid type and bondType
                const url = `/orders/modify/${type}/${bondType}/${orderId}`;

                fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
                        },
                        body: JSON.stringify({
                            price: newPrice,
                            quantity: newQuantity,
                        }),
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`Server returned ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        alert(data.message);
                        location.reload(); // Reload the page to reflect changes
                    })
                    .catch(error => {
                        console.error('Error modifying order:', error);
                    });
            }
        }



        function cancelOrder(orderId, type, bondType) {
            if (confirm('Are you sure you want to cancel this order?')) {
                fetch(`/orders/cancel/${type}/${bondType}/${orderId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        alert(data.message);
                        location.reload(); // Reload the page to reflect changes
                    })
                    .catch(error => console.error('Error canceling order:', error));
            }
        }
    </script>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
@endsection
