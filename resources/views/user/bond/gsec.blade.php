@extends('layouts.user')

@section('content')
    <div class="content bg-white p-4 rounded-3 shadow-sm flex-grow-1">
        <h2 class="text-center">G-Secs</h2>

        <!-- Cards for different bond types -->
        <div class="">
            <!-- G-Secs Card -->

            <div class="col">
                <div class="card h-100 border shadow-lg">
                    <div class="card-body p-4">
                        <table class="table mt-3">
                            <tbody>
                                <tr>
                                    <th scope="row">Bond Name</th>
                                    <th scope="row">Bond Price</th>
                                </tr>
                                <tr>
                                    <td>1 Year G-Sec</td>
                                    <td>5.5%</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection
