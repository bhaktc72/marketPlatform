@extends('layouts.app')

@section('content')
{{-- Message --}}


<div class="col-lg-6 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">User Management</h4>
            <a href="{{ route('users.create') }}" class="btn btn-sm btn-primary text-right">Create User</a>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>UserID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $userData)

                    <tr>
                        <td>{{ $userData->id }}</td>
                        <td>{{ $userData->userID }}</td>
                        <td>{{ $userData->firstName }}</td>
                        <td>{{ $userData->lastName }}</td>
                        <td>{{ $userData->status }}</td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection