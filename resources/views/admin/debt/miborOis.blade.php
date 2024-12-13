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
            <h4 class="card-title mb-0">MIBOR OIS Management</h4>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addMiborModal">
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
                            <th>Timeline</th>
                            <th>Rate</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($mibor as $miborData)
                        <tr>
                            <th>{{ $miborData->id }}</th>
                            <td>
                                <input type="text" class="form-control" id="timeline{{ $miborData->id }}"
                                    value="{{ $miborData->timeline ?? '-' }}" data-id="{{ $miborData->id }}"
                                    data-field="timeline">
                            </td>
                            <td>
                                <input type="text" class="form-control" id="rate{{ $miborData->id }}"
                                    value="{{ $miborData->rate ?? '-' }}" data-id="{{ $miborData->id }}"
                                    data-field="rate">
                            </td>
                            <td>
                                <button type="button" class="btn btn-info btn-sm"
                                    onclick="updateMibor({{ $miborData->id }})">
                                    Save
                                </button>
                                <!-- Delete Button -->
                                <button type="button" class="btn btn-danger btn-sm"
                                    onclick="deleteMibor({{ $miborData->id }})">
                                    Delete
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-end custom-pagination">
                    {{-- {!! $mibor->links() !!} --}}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Add mibor -->
<div class="modal fade" id="addMiborModal" tabindex="-1" aria-labelledby="addMiborModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMiborModalLabel">Add New Record</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addMiborForm" method="POST" action="{{ route('mibor.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="timeline" class="form-label">Timeline</label>
                        <input type="text" class="form-control" id="timeline" name="timeline" required>
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
    function updateMibor(miborId) {
        var timeline = $('#timeline' + miborId).val();
        var rate = $('#rate' + miborId).val();

        $.ajax({
            url: '/mibor/' + miborId,  // Correct URL for the mibor update
            type: 'PUT',
            data: {
                _token: '{{ csrf_token() }}',
                timeline: timeline,
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

    // Function to delete mibor
    function deleteMibor(miborId) {
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
                    url: '/mibor/' + miborId,  // Correct URL for deleting mibor
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
