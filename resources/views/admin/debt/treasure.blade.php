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
            <h4 class="card-title mb-0">Treasure Management</h4>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addTreasureModal">
                Add New Treasure
            </button>
        </div>

        <div class="card-body">
            <!-- Table with stripped rows -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th>S.No</th>
                            <th>Tenure</th>
                            <th>Rate</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($treasure as $treasureData)
                        <tr>
                            <th>{{ $treasureData->id }}</th>
                            <td>
                                <input type="text" class="form-control" id="tenure{{ $treasureData->id }}"
                                    value="{{ $treasureData->tenure ?? '-' }}" data-id="{{ $treasureData->id }}"
                                    data-field="tenure">
                            </td>
                            <td>
                                <input type="text" class="form-control" id="rate{{ $treasureData->id }}"
                                    value="{{ $treasureData->rate ?? '-' }}" data-id="{{ $treasureData->id }}"
                                    data-field="rate">
                            </td>
                            <td>
                                <button type="button" class="btn btn-info btn-sm"
                                    onclick="updateTreasure({{ $treasureData->id }})">
                                    Save
                                </button>
                                <!-- Delete Button -->
                                <button type="button" class="btn btn-danger btn-sm"
                                    onclick="deleteTreasure({{ $treasureData->id }})">
                                    Delete
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-end custom-pagination">
                    {{-- {!! $treasure->links() !!} --}}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Add Treasure -->
<div class="modal fade" id="addTreasureModal" tabindex="-1" aria-labelledby="addTreasureModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTreasureModalLabel">Add New Treasure</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addTreasureForm" method="POST" action="{{ route('treasure.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="tenure" class="form-label">Tenure</label>
                        <input type="text" class="form-control" id="tenure" name="tenure" required>
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
    // Function to update treasure details inline
    function updateTreasure(treasureId) {
        var tenure = $('#tenure' + treasureId).val();
        var rate = $('#rate' + treasureId).val();

        $.ajax({
            url: '/treasure/' + treasureId,  // Correct URL for the treasure update
            type: 'PUT',
            data: {
                _token: '{{ csrf_token() }}',
                tenure: tenure,
                rate: rate
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Updated!',
                        text: 'The treasure has been updated successfully.',
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
                    text: 'An error occurred while updating the treasure.',
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        });
    }

    // Function to delete treasure
    function deleteTreasure(treasureId) {
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
                    url: '/treasure/' + treasureId,  // Correct URL for deleting treasure
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: 'The treasure has been deleted successfully.',
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload();  // Reload the page to reflect the changes
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops!',
                                text: 'An error occurred while deleting the treasure.',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops!',
                            text: 'An error occurred while deleting the treasure.',
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