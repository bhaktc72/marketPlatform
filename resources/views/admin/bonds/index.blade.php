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
            <h4 class="card-title mb-0">Bond Management</h4>
            <div>
                <!-- Button to trigger upload modal -->
                <button type="button" class="btn btn-light btn-sm d-flex align-items-center" data-bs-toggle="modal"
                    data-bs-target="#uploadBondModal">
                    <i class="bi bi-upload me-2"></i>
                    <span>Upload Bonds</span>
                </button>

                <!-- Export Bonds Button -->
                <a href="{{ route('bonds.export') }}" class="btn btn-light btn-sm d-flex align-items-center mt-3">
                    <i class="bi bi-download me-2"></i>
                    <span>Export Bonds</span>
                </a>
            </div>
        </div>

        <div class="card-body">
            <!-- Table with stripped rows -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th>S.No</th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Code</th>
                            <th>Issuer</th>
                            <th>Currency</th>
                            <th>Maturity</th>
                            <th>Face Value</th>
                            <th>Coupon</th>
                            <th>Frequency</th>
                            <th>Day Count</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bonds as $bondsData)
                        <tr>
                            <th>{{ ($bonds->currentPage() - 1) * $bonds->perPage() + $loop->index + 1 }}</th>
                            <td>{{ $bondsData->id }}</td>
                            <td contenteditable="true" onblur="updateBond(this, '{{ $bondsData->id }}', 'name')">
                                {{ $bondsData->name }}
                            </td>
                            <td contenteditable="true" onblur="updateBond(this, '{{ $bondsData->id }}', 'code')">
                                {{ $bondsData->code }}
                            </td>
                            <td>{{ $bondsData->issuer }}</td>
                            <td>{{ $bondsData->currency }}</td>
                            <td>{{ $bondsData->maturity }}</td>
                            <td>{{ $bondsData->face_value }}</td>
                            <td>{{ $bondsData->coupon }}</td>
                            <td>{{ $bondsData->frequency }}</td>
                            <td>{{ $bondsData->day_count }}</td>
                            <td>{{ $bondsData->price }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-end custom-pagination">
                    {!! $bonds->links() !!}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Upload Modal -->
<div class="modal fade" id="uploadBondModal" tabindex="-1" aria-labelledby="uploadBondModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('bonds.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadBondModalLabel">Upload Bond Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="bondFile" class="form-label">Choose Excel File</label>
                        <input type="file" class="form-control" name="bondFile" id="bondFile" accept=".xlsx, .xls, .csv"
                            required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Upload</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function updateBond(element, bondId, field) {
        const newValue = element.textContent.trim();

        fetch(`{{ url('bonds/update') }}/${bondId}`, {
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
                    text: 'The bond data has been updated.',
                    timer: 2000,
                    showConfirmButton: false
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Update Failed',
                    text: data.message || 'An error occurred while updating the bond data.',
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