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
            <h4 class="card-title mb-0">NDS Call Management</h4>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addNdsCallsModal">
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
                            <th>Rate</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($nds as $ndsData)
                        <tr>
                            <th>{{ $ndsData->id }}</th>
                            <td>
                                <input type="text" class="form-control" id="name{{ $ndsData->id }}"
                                    value="{{ $ndsData->name ?? '-' }}" data-id="{{ $ndsData->id }}" data-field="name">
                            </td>
                            <td>
                                <input type="text" class="form-control" id="rate{{ $ndsData->id }}"
                                    value="{{ $ndsData->rate ?? '-' }}" data-id="{{ $ndsData->id }}" data-field="rate">
                            </td>
                            <td>
                                <button type="button" class="btn btn-info btn-sm"
                                    onclick="updateNdsCalls({{ $ndsData->id }})">
                                    Save
                                </button>
                                <!-- Delete Button -->
                                <button type="button" class="btn btn-danger btn-sm"
                                    onclick="deleteNdsCalls({{ $ndsData->id }})">
                                    Delete
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Add NDS Call -->
<div class="modal fade" id="addNdsCallsModal" tabindex="-1" aria-labelledby="addNdsCallsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addNdsCallsModalLabel">Add New Record</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addNdsCallsForm" method="POST" action="{{ route('ndsCalls.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="rate" class="form-label">Rate</label>
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
    // Function to update NDS Calls inline
    function updateNdsCalls(ndsId) {
        var name = $('#name' + ndsId).val();
        var rate = $('#rate' + ndsId).val();

        // Perform AJAX request to update the NDS Call
        $.ajax({
            url: '/ndsCalls/' + ndsId,  // Ensure this is the correct URL for the update
            type: 'PUT',
            data: {
                _token: '{{ csrf_token() }}',  // CSRF token to ensure security
                name: name,
                rate: rate
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Updated!',
                        text: 'The NDS Call has been updated successfully.',
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
                    text: 'An error occurred while updating the NDS Call. Please check the fields or server.',
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        });
    }

    // Function to delete NDS Call
    function deleteNdsCalls(ndsId) {
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
                    url: '/ndsCalls/' + ndsId,  // Correct URL for deleting NDS Call
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: 'The NDS Call has been deleted successfully.',
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload();  // Reload the page to reflect the changes
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops!',
                                text: 'An error occurred while deleting the NDS Call.',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops!',
                            text: 'An error occurred while deleting the NDS Call.',
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