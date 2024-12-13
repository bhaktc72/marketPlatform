<nav class="sidebar sidebar-offcanvas" id="sidebar" style="background-color: #EAD9F1;">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <a href="#" class="nav-link">
                <div class="nav-profile-image">
                    {{-- <img src="assets/images/faces/face1.jpg" alt="profile">
                    <span class="login-status online"></span> --}}
                    <!--change to offline or busy as needed-->
                </div>
                <div class="nav-profile-text d-flex flex-column">
                    <span class="font-weight-bold mb-2">Bhakt Chotaliya</span>
                    <span class="text-secondary text-small">Market Manager</span>
                </div>
                <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('home') }}">
                <span class="menu-title">Dashboard</span>
                <i class="mdi mdi-home menu-icon"></i>
            </a>
        </li>

        @role('Admin')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('users.index') }}">
                    <span class="menu-title">User</span>
                    <i class="mdi mdi-account-circle menu-icon"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('bonds.index') }}">
                    <span class="menu-title">Bond Management</span>
                    <i class="mdi mdi-file-document menu-icon"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#marketManagement" aria-expanded="false" aria-controls="marketManagement">
                    <span class="menu-title">Debt Market Management</span>
                    <i class="menu-arrow"></i>
                    <i class="mdi mdi-chart-line menu-icon"></i>
                </a>
                <div class="collapse" id="marketManagement">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('policies.index') }}">Policy</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('treasure.index') }}">Treasury Bills</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('ndsCalls.index') }}">NDS Calls</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('basketRepo.index') }}">Basket Repo</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('treps.index') }}">Treps</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('mibor.index') }}">MIBOR OIS</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('marketGraph.index') }}">Market Graph</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#fxManagement" data-bs-toggle="collapse" aria-expanded="false" aria-controls="fxManagement">
                    <span class="menu-title">FX Management</span>
                    <i class="menu-arrow"></i>
                    <i class="mdi mdi-chart-line menu-icon"></i>
                </a>
                <div class="collapse" id="fxManagement">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('foreignExchange.index') }}">Exchange Rates</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('forwardPremium.index') }}">Forward Premium</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('equityMarket.index') }}">
                    <span class="menu-title">Equity Market</span>
                    <i class="mdi mdi-chart-line menu-icon"></i>
                </a>
            </li>
        @endrole

        

    </ul>
</nav>
