@extends('user.layouts.app')

@section('content')
    <title>Order List</title>
    <style>
        .order-section {
            margin-bottom: 20px;
        }

        .order-card {
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 10px;
            padding: 15px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        .order-header {
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 15px;
        }

        .order-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }

        .order-info span {
            font-size: 14px;
        }

        .badge-buy {
            background-color: #28a745;
            color: #fff;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .badge-sell {
            background-color: #dc3545;
            color: #fff;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .badge-status {
            padding: 5px 10px;
            border-radius: 5px;
            color: #fff;
        }

        .badge-success {
            background-color: #28a745;
        }

        .badge-failed {
            background-color: #dc3545;
        }

        .collapsible {
            cursor: pointer;
            background-color: #f8f9fa;
            border: none;
            padding: 10px;
            text-align: left;
            font-size: 16px;
            font-weight: bold;
            width: 100%;
            margin-bottom: 10px;
        }

        .collapsible:after {
            content: '\002B';
            /* Unicode plus symbol */
            float: right;
        }

        .collapsible.active:after {
            content: '\2212';
            /* Unicode minus symbol */
        }

        .content {
            padding: 0 15px;
            display: none;
            overflow: hidden;
        }
    </style>

    <div class="container mt-4">
        <h4 class="text-center mb-4">My Orders</h4>

        <!-- Buy Orders Section -->
        {{-- <div class="order-section">
            <button class="collapsible">Buy Orders</button>
            <div class="content">
                @forelse ($buyOrders as $order)
                    <div class="order-card">
                        <div class="order-info">
                            <span><strong>Bond ID:</strong> {{ $order->bond_id }}</span>
                            <span><strong>Price:</strong> ₹ {{ $order->price }}</span>
                            <span><strong>Qty:</strong> {{ $order->quantity }}</span>
                        </div>
                        <div class="order-info">
                            <span><strong>Time:</strong> {{ $order->created_at->format('h:i A') }}</span>
                            <span><span class="badge badge-status badge-success">{{ $order->status }}</span></span>
                        </div>
                    </div>
                @empty
                    <p>No Buy Orders available.</p>
                @endforelse
            </div>
        </div> --}}

        <!-- Sell Orders Section -->
        {{-- <div class="order-section">
            <button class="collapsible">Sell Orders</button>
            <div class="content">
                @forelse ($sellOrders as $order)
                    <div class="order-card">
                        <div class="order-info">
                            <span><strong>Bond ID:</strong> {{ $order->bond_id }}</span>
                            <span><strong>Price:</strong> ₹ {{ $order->price }}</span>
                            <span><strong>Qty:</strong> {{ $order->quantity }}</span>
                        </div>
                        <div class="order-info">
                            <span><strong>Time:</strong> {{ $order->created_at->format('h:i A') }}</span>
                            <span><span class="badge badge-status badge-success">{{ $order->status }}</span></span>
                        </div>
                    </div>
                @empty
                    <p>No Sell Orders available.</p>
                @endforelse
            </div>
        </div> --}}

        <!-- State Buy Orders Section -->
        <div class="order-section">
            <button class="collapsible">State Buy Orders</button>
            <div class="content">
                @forelse ($stateBuyOrders as $order)
                    <div class="order-card">
                        <div class="order-info">
                            <span><strong>Bond ID:</strong> {{ $order->bond_id }}</span>
                            <span><strong>Price:</strong> ₹ {{ $order->price }}</span>
                            <span><strong>Qty:</strong> {{ $order->quantity }}</span>
                        </div>
                        <div class="order-info">
                            <span><strong>Time:</strong> {{ $order->created_at->format('h:i A') }}</span>
                            <span><span class="badge badge-status badge-success">{{ $order->status }}</span></span>
                        </div>
                    </div>
                @empty
                    <p>No State Buy Orders available.</p>
                @endforelse
            </div>
        </div>

        <!-- Add more collapsible sections for centralBuyOrders, stateSellOrders, centralSellOrders -->
    </div>

    <script>
        const collapsibles = document.querySelectorAll('.collapsible');
        collapsibles.forEach((collapsible) => {
            collapsible.addEventListener('click', function() {
                this.classList.toggle('active');
                const content = this.nextElementSibling;
                if (content.style.display === 'block') {
                    content.style.display = 'none';
                } else {
                    content.style.display = 'block';
                }
            });
        });
    </script>
@endsection
