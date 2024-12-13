@extends('layouts.app')

@section('content')

<div class="container mt-4">
    @if (Session::has('success'))
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>Success!</strong> {{ session('success') }}
    </div>
    @endif

    @if (Session::has('error'))
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>Error!</strong> {{ session('error') }}
    </div>
    @endif

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title">Edit User</h5>
                <a href="{{ route('users.index') }}" class="btn btn-bg-orange btn-sm">Back</a>
            </div>
        </div>
        <div class="card-body">
            <form class="row g-3" id="userForm" enctype="multipart/form-data" method="post"
                action="{{ route('users.store') }}" novalidate>
                @csrf
                <div class="col-md-6">
                    <label for="firstName" class="form-label">First Name</label>
                    <input type="text" class="form-control @error('firstName') is-invalid @enderror" id="firstName"
                        name="firstName" placeholder="First Name" value="{{ $user->firstName }}" required>
                    @error('firstName')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="lastName" class="form-label">Last Name</label>
                    <input type="text" class="form-control @error('lastName') is-invalid @enderror" id="lastName"
                        name="lastName" placeholder="Last Name" value="{{ $user->lastName }}" required>
                    @error('lastName')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="col-md-12 text-center">
                    <button type="submit" class="btn btn-bg-blue mt-3">Submit</button>
                    <button type="reset" class="btn btn-bg-orange mt-3">Reset</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
