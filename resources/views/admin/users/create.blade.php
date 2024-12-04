@extends('layouts.app')

@section('content')


<div class="div container">
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">User Form</h4>
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('users.index') }}" class="btn btn-facebook">Back</a>
                    </div>
                    <form class="forms-sample" method="POST" action="{{ route('users.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="firstName">First Name</label>
                            <input type="text" class="form-control" id="firstName" placeholder="First Name"
                                name="firstName" required>
                        </div>
                        <div class="form-group">
                            <label for="lastName">Last Name</label>
                            <input type="text" class="form-control" id="lastName" placeholder="Last Name"
                                name="lastName" required>
                        </div>
                        <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
