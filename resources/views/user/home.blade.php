@extends('user.layouts.app')

@section('content')
    <div class="container">
        <div class="row mt-5">
            <div class="col">
                <div class="card shadow">
                    <div class="card-body text-center">
                        <i class="fa fa-bank fs-1 mb-2"></i>
                        <h3 class="card-title ">Bonds</h3>
                        <h5>5</h5>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card shadow">
                    <div class="card-body text-center">
                        <i class="fa fa-list-alt fs-1 mb-2"></i>
                        <h3 class="card-title ">Orders</h3>
                        <h5>5</h5>
                    </div>
                </div>
            </div>
            {{-- <div class="col">
                <div class="card">
                    <div class="card-body">

                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body">

                    </div>
                </div>
            </div> --}}
        </div>
    </div>
@endsection
