@extends('layouts.dashboard')

@section('title', $title)

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <button id="add-reservation-button" class="card-title btn btn-primary">
                        <i class="fa-solid fa-plus"></i> Add New Reservation
                    </button>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Reservation ID</th>
                                <th>Customer ID</th>
                                <th>Event Date</th>
                                <th>Reservation Date</th>
                                <th>Event Type</th>
                                <th>Venue</th>
                                <th>Number of Guests</th>
                                <th>Total Cost</th>
                                <th>Payment Status</th>
                                <th>Booking Status</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                        <tfoot>
                            <th>ID</th>
                            <th>Reservation ID</th>
                            <th>Customer ID</th>
                            <th>Event Date</th>
                            <th>Reservation Date</th>
                            <th>Event Type</th>
                            <th>Venue</th>
                            <th>Number of Guests</th>
                            <th>Total Cost</th>
                            <th>Payment Status</th>
                            <th>Booking Status</th>
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
    <script id="custom-script">
        $(document).ready(function() {
            $("#table").DataTable({
                responsive: true,
                lengthChange: false,
                autoWidth: false,
                buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#table_wrapper .col-md-6:eq(0)');
        });
    </script>
@endpush
