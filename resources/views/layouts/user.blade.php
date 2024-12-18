<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Panel Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="d-flex bg-light">
    <!-- Sidebar -->
    <div class="sidebar bg-dark text-white p-3" style="width: 250px; height: 100vh;">
        <div class="logo text-center fs-4 fw-bold mb-4">Trade Panel</div>
        <ul class="list-unstyled">
            <li><a href="{{ route('user.home') }}" class="text-white text-decoration-none d-block p-2 rounded-3 mb-2">Dashboard</a></li>
            <li><a href="{{ route('bonds.userIndex') }}" class="text-white text-decoration-none d-block p-2 rounded-3 mb-2">Bonds</a></li>
            <li><a href="{{ route('bonds.orderBook') }}" class="text-white text-decoration-none d-block p-2 rounded-3 mb-2">Order Book</a></li>
            <li><a href="{{ route('bonds.myOrders') }}" class="text-white text-decoration-none d-block p-2 rounded-3 mb-2">My Orders</a></li>
            <li><a href="#" class="text-white text-decoration-none d-block p-2 rounded-3 mb-2">Markets</a></li>
            <li>
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button class="btn btn-danger text-white w-100 p-2 rounded-3" type="submit">Logout</button>
                </form>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content ms-250 w-100 p-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center bg-white p-3 rounded-3 shadow-sm mb-4">
            <div class="title fs-3 fw-bold text-dark">Dashboard</div>
            <div class="d-flex flex-column align-items-end">
                <div class="user-info mb-1">
                    <span class="fw-semibold text-muted">User ID:</span>
                    <span class="text-primary">{{ Auth::user()->userId }}</span>
                </div>
                <div class="user-info text-muted mb-1">
                    <strong>Account Balance:</strong>
                    <span class="text-success fw-bold">₹10,000</span>
                </div>
                {{-- <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button class="btn btn-danger text-white rounded-3" type="submit">Logout</button>
                </form> --}}
            </div>
        </div>

        <!-- Content Section -->
        @yield('content')

        <!-- Footer -->
        <div class="footer text-muted text-center mb-3" style="bottom: 0; position: absolute; width: 80%;">
            &copy; Designed by Bhakt Chotaliya & Kevil Gandhi All rights reserved.
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
