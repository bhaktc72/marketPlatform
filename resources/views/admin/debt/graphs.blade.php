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
            <h4 class="card-title mb-0">Market Graph Management</h4>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addgraphsModal">
                Add New Graph
            </button>
        </div>

        <div class="card-body">
            <!-- Table with stripped rows -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th>S.No</th>
                            <th>Graph</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($graphs as $graphsData)
                        <tr>
                            <th>{{ $graphsData->id }}</th>
                            <td>
                                @if ($graphsData->graphImage)
                                <img src="{{ url('graphImage/' . basename($graphsData->graphImage)) }}"
                                    alt="Graph Image" style="width: 100px; height: auto; border-radius: 5px;">
                                @else
                                <span></span>
                                @endif
                            </td>

                            <script>
                                function showImage(element) {
                                    event.preventDefault();
                                    var image = element.querySelector('img');
                                    var overlay = document.createElement('div');
                                    overlay.classList.add('overlay');
                                    overlay.onclick = function() {
                                        overlay.remove();
                                    }
                                    document.body.appendChild(overlay);
                                    var img = document.createElement('img');
                                    img.src = image.src;
                                    img.classList.add('popup-image');
                                    document.body.appendChild(img);
                                }
                            </script>

                            <style>
                                .overlay {
                                    position: fixed;
                                    top: 0;
                                    left: 0;
                                    width: 100vw;
                                    height: 100vh;
                                    background-color: rgba(0, 0, 0, 0.5);
                                    z-index: 9999;
                                }

                                .popup-image {
                                    position: fixed;
                                    top: 50%;
                                    left: 50%;
                                    transform: translate(-50%, -50%);
                                    max-width: 100vw;
                                    max-height: 100vh;
                                    z-index: 99999;
                                }
                            </style>
                            <td>
                                <!-- Delete Button -->
                                <button type="button" class="btn btn-danger btn-sm"
                                    onclick="deletegraphs({{ $graphsData->id }})">
                                    Delete
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-end custom-pagination">
                    {{-- {!! $graphs->links() !!} --}}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Add Graph -->
<div class="modal fade" id="addgraphsModal" tabindex="-1" aria-labelledby="addgraphsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addgraphsModalLabel">Add New Graph</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addgraphsForm" method="POST" action="{{ route('marketGraph.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="graphImage" class="form-label">Upload Graph Image</label>
                        <input type="file" class="form-control" id="graphImage" name="graphImage" accept="image/*"
                            required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Function to delete graph
    function deletegraphs(graphsId) {
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
                    url: '/marketGraph/' + graphsId,  // Correct URL for deleting graphs
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
