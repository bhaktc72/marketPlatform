@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card border-0 shadow mt-5">
        <div class="card-header text-white d-flex justify-content-between align-items-center" style="background-color: #EAD9F1;">
            <h4 class="card-title mb-0">User Management</h4>
            <!-- Button to trigger the modal -->
            <button type="button" class="btn btn-light btn-sm d-flex align-items-center" data-bs-toggle="modal"
                data-bs-target="#createUserModal">
                <i class="bi bi-plus-circle me-2"></i>
                <span>Add User</span>
            </button>
        </div>

        <div class="card-body">
            <!-- Table with stripped rows -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th>S.No</th>
                            <th>User ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $userData)
                        <tr>
                            <th>{{ ($data->currentPage() - 1) * $data->perPage() + $loop->index + 1 }}</th>
                            <td>{{ $userData->userId }}</td>
                            <td contenteditable="true" onblur="updateUser(this, '{{ $userData->id }}', 'firstName')">
                                {{ $userData->firstName }}
                            </td>
                            <td contenteditable="true" onblur="updateUser(this, '{{ $userData->id }}', 'lastName')">
                                {{ $userData->lastName }}
                            </td>
                            <td>
                                <a href="{{ route('users.delete', $userData->id) }}" class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash3"></i> Delete
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-end custom-pagination">
                    {!! $data->links() !!}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create User Modal -->
<div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="modal-header bg-secondary text-white">
                    <h5 class="modal-title" id="createUserModalLabel">Add New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="firstName" class="form-label">First Name</label>
                        <input type="text" name="firstName" id="firstName" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="lastName" class="form-label">Last Name</label>
                        <input type="text" name="lastName" id="lastName" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add User</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function updateUser(element, userId, field) {
        const newValue = element.textContent.trim();

        fetch(`{{ url('users/update') }}/${userId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ field, value: newValue })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Updated Successfully!',
                    text: 'The user data has been updated.',
                    timer: 2000,
                    showConfirmButton: false
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Update Failed',
                    text: data.message || 'An error occurred while updating the user data.',
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while updating. Please try again.',
                timer: 2000,
                showConfirmButton: false
            });
        });
    }
</script>
