@extends('layouts.user')

@section('content')
    <div class="content bg-white p-4 rounded-3 shadow-sm flex-grow-1">
        <h2 class="text-center">Explore Bonds</h2>

        <!-- Cards for different bond types -->
        <div class="row row-cols-1 row-cols-md-3 g-4 mb-5">
            <!-- G-Secs Card -->
            <div class="col">
                <a href="{{ route('bonds.gSec') }}" class="btn">
                    <div class="card h-100 border shadow-lg">
                        <div class="card-body p-4">
                            <i class="bi bi-shield-check fs-2 text-primary"></i>
                            <h5 class="card-title text-center">G-Secs</h5>
                            <p class="card-text text-center">Government Securities that are safe and reliable for investment.</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- SDL Card -->
            <div class="col">
                <a href="#" class="btn">
                    <a href="{{ route('bonds.sdl') }}" class="btn">
                        <div class="card h-100 border shadow-lg">
                            <div class="card-body p-4">
                                <i class="bi bi-clipboard fs-2 text-primary"></i>
                                <h5 class="card-title text-center">SDL</h5>
                                <p class="card-text text-center">State Development Loans for long-term investment opportunities.</p>
                            </div>
                        </div>
                    </a>
            </div>

            <!-- Government Bonds Card -->
            <div class="col">
                <a href="#" class="btn">
                    <a href="{{ route('bonds.govtBond') }}" class="btn">
                        <div class="card h-100 border shadow-lg">
                            <div class="card-body p-4">
                                <i class="bi bi-building fs-2 text-primary"></i>
                                <h5 class="card-title text-center">Government Bonds</h5>
                                <p class="card-text text-center">Secure bonds offered by the government with attractive yields.</p>
                            </div>
                        </div>
                    </a>
            </div>
        </div>
    </div>
@endsection
