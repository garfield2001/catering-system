@extends('layouts.dashboard')

@section('title', $title)

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title text-info">Click each row for more actions!</h3>
                </div>
                <div class="card-header">
                    <div class="row">
                        <div class="col-9">
                            <button id="add-reservation-button" class="card-title btn btn-primary">
                                <i class="fa-solid fa-plus"></i> Add New Reservation
                            </button>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Category Name</th>
                                <th>Package Name</th>
                                <th>Package Price</th>
                                <th>Dish Name</th>
                                <th>Dish Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dishes as $dish) 
                                <tr class="dish-row" data-toggle="tooltip" title="Edit or Delete this Row">
                                    <td>{{ $dish->id }}</td>
                                    <td>{{ $dish->package->category->name }}</td>
                                    <td>{{ $dish->package->name }}</td>
                                    <td>{{ $dish->package->price ?? 'No Price' }}</td>
                                    <td>{{ $dish->name }}</td>
                                    <td>{{ $dish->price ?? 'No Price' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Category Name</th>
                                <th>Package Name</th>
                                <th>Package Price</th>
                                <th>Dish Name</th>
                                <th>Dish Price</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
@endsection

@push('scripts')
    <script id="custom-script"></script>
@endpush
