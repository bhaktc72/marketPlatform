@extends('user.layouts.app')

@section('content')
    <div class="content bg-white p-4 rounded-3 shadow-sm flex-grow-1">
        <h2 class="text-center">Government Bonds</h2>

        <!-- Cards for different bond types -->
        <div class="">
            <div class="col">
                <div class="card h-100 border shadow-lg">
                    <div class="card-body p-4">
                        <table class="table mt-3">
                            <thead>
                                <tr>
                                    <th scope="col">ISIN</th>
                                    <th scope="col">Out Standing Stock</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($govtBonds as $bond)
                                    <tr>
                                        <td>{{ $bond->isin ?? '' }}</td>
                                        <td>{{ $bond->outStandingStock ?? '' }}</td>
                                        <td>
                                            <a href="{{ route('bonds.govtBondDetails', $bond->id) }}" class="btn btn-primary">View</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
