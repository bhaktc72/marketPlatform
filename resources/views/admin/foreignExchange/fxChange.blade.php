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
            <h4 class="card-title mb-0">Foreign Exchange Management</h4>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addFxModel">
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
                        @foreach ($foreignExchange as $foreignExchangeData)
                        <tr>
                            <th>{{ $foreignExchangeData->id }}</th>
                            <td>
                                <input type="text" class="form-control" id="name{{ $foreignExchangeData->id }}"
                                    value="{{ $foreignExchangeData->name ?? '-' }}"
                                    data-id="{{ $foreignExchangeData->id }}" data-field="name">
                            </td>
                            <td>
                                <input type="text" class="form-control" id="rate{{ $foreignExchangeData->id }}"
                                    value="{{ $foreignExchangeData->rate ?? '-' }}"
                                    data-id="{{ $foreignExchangeData->id }}" data-field="rate">
                            </td>
                            <td>
                                <button type="button" class="btn btn-info btn-sm"
                                    onclick="updateforeignExchange({{ $foreignExchangeData->id }})">
                                    Save
                                </button>
                                <!-- Delete Button -->
                                <button type="button" class="btn btn-danger btn-sm"
                                    onclick="deleteforeignExchange({{ $foreignExchangeData->id }})">
                                    Delete
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-end custom-pagination">
                    {{-- {!! $foreignExchangeData->links() !!} --}}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Add foreignExchange -->
<div class="modal fade" id="addFxModel" tabindex="-1" aria-labelledby="addFxModelLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addFxModelLabel">Add New Record</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addforeignExchangeForm" method="POST" action="{{ route('foreignExchange.store') }}">
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
    // Function to update baket details inline
    function updateforeignExchange(foreignExchangeId) {
        var name = $('#name' + foreignExchangeId).val();
        var rate = $('#rate' + foreignExchangeId).val();

        $.ajax({
            url: '/foreignExchange/' + foreignExchangeId,  // Correct URL for the foreignExchange update
            type: 'PUT',
            data: {
                _token: '{{ csrf_token() }}',
                name: name,
                rate: rate
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

    // Function to delete foreignExchange
    function deleteforeignExchange(foreignExchangeId) {
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
                    url: '/foreignExchange/' + foreignExchangeId,  // Correct URL for deleting foreignExchange
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