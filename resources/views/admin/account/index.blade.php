@extends('layouts.app')

@section('content')
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                timer: 2000,
                showConfirmButton: false
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops!',
                text: '{{ session('error') }}',
                timer: 2000,
                showConfirmButton: false
            });
        </script>
    @endif

    <div class="container">
        <div class="card border-0 shadow mt-5">
            <div class="card-header text-white d-flex justify-content-between align-items-center" style="background-color: #EAD9F1;">
                <h4 class="card-title mb-0">Account Balance Management</h4>
                <form id="deleteAllForm" method="POST" action="{{ route('accounts.deleteAll') }}" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete All</button>
                </form>
            </div>

            <div class="card-body">
                <!-- Admin Input for Amount -->
                <form id="generateAmountForm" method="POST" action="{{ route('accounts.generate') }}">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="amount" class="form-label"><b>Amount</b></label>
                            <input type="number" class="form-control" id="amount" name="amount" required placeholder="Enter amount">
                        </div>
                        <div class="col-md-6 align-self-end">
                            <button type="submit" class="btn btn-primary w-100">Generate for All Users</button>
                        </div>
                    </div>
                </form>

                <!-- Display Table -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th>S.No</th>
                                <th>User ID</th>
                                <th>Amount</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($accounts as $index => $account)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $account->userId }}</td>
                                    <td>
                                        <input type="number" class="form-control" id="amount{{ $account->id }}" value="{{ $account->amount }}" data-id="{{ $account->id }}">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-info btn-sm" onclick="updateAccountAmount({{ $account->id }})">Save</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function updateAccountAmount(accountId) {
            const amount = document.getElementById(`amount${accountId}`).value;

            $.ajax({
                url: `/accounts/${accountId}/update`,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    amount: amount
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Updated!',
                            text: 'The amount has been updated successfully.',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload(); // Reload the page to reflect changes
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops!',
                            text: response.error,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops!',
                        text: 'An error occurred while updating the amount.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            });
        }
    </script>
@endsection
