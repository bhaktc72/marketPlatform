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
                <h4 class="card-title mb-0">State Government Bond Management</h4>
                <div>
                    <!-- Button to trigger upload modal -->
                    <button type="button" class="btn btn-light btn-sm d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#uploadStateBondModal">
                        <i class="bi bi-upload me-2"></i>
                        <span>Upload Bonds</span>
                    </button>

                    <!-- Export Bonds Button -->
                    <a href="{{ route('stateBonds.export') }}" class="btn btn-light btn-sm d-flex align-items-center mt-3">
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
                                <th>ISIN</th>
                                <th>State Government</th>
                                <th>Nomenclature</th>
                                <th>Date of Issue</th>
                                <th>Date of Maturity</th>
                                <th>Outstanding Stocks (Rs. Crore)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($stateBonds as $stateBondsData)
                                <tr>
                                    <th>{{ ($stateBonds->currentPage() - 1) * $stateBonds->perPage() + $loop->index + 1 }}</th>
                                    <td>{{ $stateBondsData->id }}</td>
                                    <td contenteditable="true" onblur="updateBond(this, '{{ $stateBondsData->id }}', 'isin')">
                                        {{ $stateBondsData->isin }}
                                    </td>
                                    <td>{{ $stateBondsData->stateGovt }}</td>
                                    <td contenteditable="true" onblur="updateBond(this, '{{ $stateBondsData->id }}', 'nomenclature')">
                                        {{ $stateBondsData->nomenclature }}
                                    </td>
                                    <td>{{ date('d-m-Y', strtotime($stateBondsData->dateofIssue)) }}</td>
                                    <td>{{ date('d-m-Y', strtotime($stateBondsData->dateOfMaturity)) }}</td>
                                    <td>{{ $stateBondsData->outStandingStock }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end custom-pagination">
                        {!! $stateBonds->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Upload Modal -->
    <div class="modal fade" id="uploadStateBondModal" tabindex="-1" aria-labelledby="uploadStateBondModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('stateBonds.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="uploadStateBondModalLabel">Upload Bond Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="bondFile" class="form-label">Choose Excel File</label>
                            <input type="file" class="form-control" name="bondFile" id="bondFile" accept=".xlsx, .xls, .csv" required>
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

        fetch(`{{ url('stateBonds/update') }}/${bondId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    field,
                    value: newValue
                })
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
