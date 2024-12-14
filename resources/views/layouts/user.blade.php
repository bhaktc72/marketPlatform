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
            <li><a href="{{ route('bonds.index') }}" class="text-white text-decoration-none d-block p-2 rounded-3 mb-2">Bonds</a></li>
            <li><a href="#" class="text-white text-decoration-none d-block p-2 rounded-3 mb-2">Order Book</a></li>
            <li><a href="#" class="text-white text-decoration-none d-block p-2 rounded-3 mb-2">My Orders</a></li>
            <li><a href="#" class="text-white text-decoration-none d-block p-2 rounded-3 mb-2">Markets</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content ms-250 w-100 p-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center bg-white p-3 rounded-3 shadow-sm mb-4">
            <div class="title fs-3 fw-bold text-dark">Dashboard</div>
            <div class="d-flex justify-content-end">
                <div class="user-info text-muted me-3"> <strong>UserId: </strong>{{ Auth::user()->userId }} </div>
                <br>
                <div class="user-info text-muted"> <strong>Account Balance: </strong>10000</div>
            </div>
        </div>

        <!-- Content Section -->
        @yield('content')

        <!-- Footer -->
        <div class="footer text-muted text-center mt-5">
            &copy; Designed by Bhakt Chotaliya & Kevil Gandhi All rights reserved.
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
