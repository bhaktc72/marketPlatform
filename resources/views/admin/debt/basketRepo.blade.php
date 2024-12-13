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
            <h4 class="card-title mb-0">Basket Repo Management</h4>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addBasketRepoModal">
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
                            <th>Basket</th>
                            <th>WAR</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($basket as $basketData)
                        <tr>
                            <th>{{ $basketData->id }}</th>
                            <td>
                                <input type="text" class="form-control" id="basketName{{ $basketData->id }}"
                                    value="{{ $basketData->basketName ?? '-' }}" data-id="{{ $basketData->id }}"
                                    data-field="basketName">
                            </td>
                            <td>
                                <input type="text" class="form-control" id="war{{ $basketData->id }}"
                                    value="{{ $basketData->war ?? '-' }}" data-id="{{ $basketData->id }}"
                                    data-field="war">
                            </td>
                            <td>
                                <button type="button" class="btn btn-info btn-sm"
                                    onclick="updateBasket({{ $basketData->id }})">
                                    Save
                                </button>
                                <!-- Delete Button -->
                                <button type="button" class="btn btn-danger btn-sm"
                                    onclick="deleteBasket({{ $basketData->id }})">
                                    Delete
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-end custom-pagination">
                    {{-- {!! $basket->links() !!} --}}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Add Basket -->
<div class="modal fade" id="addBasketRepoModal" tabindex="-1" aria-labelledby="addBasketRepoModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addBasketRepoModalLabel">Add New Record</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addBasketForm" method="POST" action="{{ route('basketRepo.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="basketName" class="form-label">Basket Name</label>
                        <input type="text" class="form-control" id="basketName" name="basketName" required>
                    </div>
                    <div class="mb-3">
                        <label for="war" class="form-label">WAR</label>
                        <input type="text" class="form-control" id="war" name="war" required>
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
    function updateBasket(basketId) {
        var basketName = $('#basketName' + basketId).val();
        var war = $('#war' + basketId).val();

        $.ajax({
            url: '/basketRepo/' + basketId,  // Correct URL for the basket update
            type: 'PUT',
            data: {
                _token: '{{ csrf_token() }}',
                basketName: basketName,
                war: war
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

    // Function to delete basket
    function deleteBasket(basketId) {
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
                    url: '/basketRepo/' + basketId,  // Correct URL for deleting basket
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