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
            <h4 class="card-title mb-0">Policy Management</h4>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addPolicyModal">
                Add New Policy
            </button>
        </div>

        <div class="card-body">
            <!-- Table with stripped rows -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th>S.No</th>
                            <th>Policy Name</th>
                            <th>Policy Rate</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($policy as $policyData)
                        <tr>
                            <th>{{ $policyData->id }}</th>
                            <td>
                                <input type="text" class="form-control" id="policy_name_{{ $policyData->id }}"
                                    value="{{ $policyData->policy_facilities ?? '-' }}" data-id="{{ $policyData->id }}"
                                    data-field="policy_facilities">
                            </td>
                            <td>
                                <input type="text" class="form-control" id="policy_rate_{{ $policyData->id }}"
                                    value="{{ $policyData->policy_rate ?? '-' }}" data-id="{{ $policyData->id }}"
                                    data-field="policy_rate">
                            </td>
                            <td>
                                <button type="button" class="btn btn-info btn-sm"
                                    onclick="updatePolicy({{ $policyData->id }})">
                                    Save
                                </button>
                                <!-- Delete Button -->
                                <button type="button" class="btn btn-danger btn-sm"
                                    onclick="deletePolicy({{ $policyData->id }})">
                                    Delete
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-end custom-pagination">
                    {{-- {!! $policy->links() !!} --}}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Add Policy -->
<div class="modal fade" id="addPolicyModal" tabindex="-1" aria-labelledby="addPolicyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPolicyModalLabel">Add New Policy</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addPolicyForm" method="POST" action="{{ route('policies.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="policy_facilities" class="form-label">Policy Name</label>
                        <input type="text" class="form-control" id="policy_facilities" name="policy_facilities"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="policy_rate" class="form-label">Policy Rate</label>
                        <input type="text" class="form-control" id="policy_rate" name="policy_rate" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Function to update policy details inline
    function updatePolicy(policyId) {
    var policyName = $('#policy_name_' + policyId).val();
    var policyRate = $('#policy_rate_' + policyId).val();

    $.ajax({
    url: '/policies/' + policyId,
    type: 'PUT',
    data: {
    _token: '{{ csrf_token() }}',
    policy_facilities: policyName,
    policy_rate: policyRate
    },
    success: function(response) {
    Swal.close(); // Close the loading spinner
    if (response.success) {
    Swal.fire({
    icon: 'success',
    title: 'Updated!',
    text: 'The policy has been updated successfully.',
    timer: 2000,
    showConfirmButton: false
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
    Swal.close(); // Close the loading spinner
    console.log(error);
    Swal.fire({
    icon: 'error',
    title: 'Oops!',
    text: 'An error occurred while updating the policy.',
    timer: 2000,
    showConfirmButton: false
    });
    }
    });
    }
</script>


<script>
    function deletePolicy(policyId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // AJAX request to delete the policy
            $.ajax({
                url: '/policies/' + policyId,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: 'The policy has been deleted successfully.',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload(); // Reload the page to reflect the changes
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops!',
                            text: 'An error occurred while deleting the policy.',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops!',
                        text: 'An error occurred while deleting the policy.',
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
