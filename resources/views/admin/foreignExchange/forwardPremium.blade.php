@extends('layouts.app')

@section('content')

@if(session('success'))
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

@if(session('error'))
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
        <div class="card-header text-white d-flex justify-content-between align-items-center"
            style="background-color: #EAD9F1;">
            <h4 class="card-title mb-0">Forward Premium Management</h4>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addFpModel">
                Add New Record
            </button>
        </div>

        <div class="card-body">
            <!-- Table with stripped rows -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th>S.No</th>
                            <th>Name</th>
                            <th>Rate in Percentage</th>
                            <th>Rate</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($forwardPremium as $forwardPremiumData)
                        <tr>
                            <th>{{ $forwardPremiumData->id }}</th>
                            <td>
                                <input type="text" class="form-control" id="tenor{{ $forwardPremiumData->id }}"
                                    value="{{ $forwardPremiumData->tenor ?? '-' }}"
                                    data-id="{{ $forwardPremiumData->id }}" data-field="tenor">
                            </td>
                            <td>
                                <input type="text" class="form-control" id="rate{{ $forwardPremiumData->id }}"
                                    value="{{ $forwardPremiumData->rate ?? '-' }}"
                                    data-id="{{ $forwardPremiumData->id }}" data-field="rate">
                            </td>
                            <td>
                                <button type="button" class="btn btn-info btn-sm"
                                    onclick="updateforwardPremium({{ $forwardPremiumData->id }})">
                                    Save
                                </button>
                                <!-- Delete Button -->
                                <button type="button" class="btn btn-danger btn-sm"
                                    onclick="deleteforwardPremium({{ $forwardPremiumData->id }})">
                                    Delete
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-end custom-pagination">
                    {{-- {!! $forwardPremiumData->links() !!} --}}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Add forwardPremium -->
<div class="modal fade" id="addFpModel" tabindex="-1" aria-labelledby="addFpModelLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addFpModelLabel">Add New Record</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addfPForm" method="POST" action="{{ route('forwardPremium.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="tenor" class="form-label">Tenor</label>
                        <input type="text" class="form-control" id="tenor" name="tenor" required>
                    </div>
                    <div class="mb-3">
                        <label for="rate_percentage" class="form-label">Rate in Percentage</label>
                        <input type="text" class="form-control" id="rate_percentage" name="rate_percentage" required>
                    </div>
                    <div class="mb-3">
                        <label for="rate" class="form-label">Rate RS</label>
                        <input type="text" class="form-control" id="rate" name="rate" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Function to update baket details inline
    function updateforwardPremium(forwardPremiumId) {
        var tenor = $('#tenor' + forwardPremiumId).val();
        var rate_percentage = $('#rate_percentage' + forwardPremiumId).val();
        var rate = $('#rate' + forwardPremiumId).val();

        $.ajax({
            url: '/forwardPremium/' + forwardPremiumId,  // Correct URL for the forwardPremium update
            type: 'PUT',
            data: {
                _token: '{{ csrf_token() }}',
                tenor: tenor,
                rate: rate
                rate_percentage: rate_percentage
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Updated!',
                        text: 'The record has been updated successfully.',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();  // Reload the page to reflect the changes
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
                    text: 'An error occurred while updating the record.',
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        });
    }

    // Function to delete forwardPremium
    function deleteforwardPremium(forwardPremiumId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/forwardPremium/' + forwardPremiumId,  // Correct URL for deleting forwardPremium
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: 'The record has been deleted successfully.',
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload();  // Reload the page to reflect the changes
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops!',
                                text: 'An error occurred while deleting the record.',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops!',
                            text: 'An error occurred while deleting the record.',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                });
            }
        });
    }
</script>

@endsection