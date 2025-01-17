<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid ">
                <div class="border-end">
                    <a class="navbar-brand" href="#">Trade Panel</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
                <div class="d-flex me-5 pe-5">
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page"
                                    href="{{ route('user.home') }}">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('bonds.userIndex') }}">Bonds</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('bonds.orderBook') }}">Order Book</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('bonds.myOrders') }}">My Orders</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Markets</a>
                            </li>

                        </ul>

                    </div>
                </div>
            </div>
            <div class="text-end text-nowrap pe-2">
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button class="btn btn-danger text-white" type="submit">
                        <i class="fa fa-sign-out"></i>
                    </button>
                </form>
                <span class="text-light">UserID: {{ Auth::user()->userId ?? 'UserID' }}</span> <br>
                <span class="text-light"> Account Balance: </span><span class="text-success fw-bold"> ₹10,000</span>
            </div>
        </nav>
    </header>
    <main>
        @yield('content')
    </main>
    <footer>
        <!-- place footer here -->
    </footer>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>
</body>

</html>
