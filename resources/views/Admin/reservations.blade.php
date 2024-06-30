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
                                <th>Reference Number</th>
                                <th>Customer Name</th>
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
                            @foreach ($reservations as $reservation)
                                <tr data-reservation-id="{{ $reservation->id }}"
                                    data-reservation-reference-number="{{ $reservation->reference_number }}"
                                    data-reservation-customer-name="{{ $reservation->customer->first_name }} {{ $reservation->customer->last_name }}"
                                    data-reservation-event-date="{{ $reservation->event_date }}"
                                    data-reservation-reservation-date="{{ $reservation->reservation_date }}"
                                    data-reservation-event-type="{{ $reservation->event_type }}"
                                    data-reservation-venue="{{ $reservation->venue }}"
                                    data-reservation-number-of-guests="{{ $reservation->number_of_guests }}"
                                    data-reservation-total-cost="{{ $reservation->total_cost }}"
                                    data-reservation-payment-status="{{ $reservation->payment_status }}"
                                    data-reservation-booking-status="{{ $reservation->booking_status }}"
                                    class="reservation-row" data-toggle="tooltip" title="Edit or Delete this Row">
                                    <td>{{ $reservation->id }}</td>
                                    <td>{{ $reservation->reference_number }}</td>
                                    <td>{{ $reservation->customer->first_name }} {{ $reservation->customer->last_name }}
                                    </td>
                                    <td>{{ $reservation->event_date }}</td>
                                    <td>{{ $reservation->reservation_date }}</td>
                                    <td>{{ $reservation->event_type }}</td>
                                    <td>{{ $reservation->venue }}</td>
                                    <td>{{ $reservation->number_of_guests }}</td>
                                    <td>{{ $reservation->total_cost }}</td>
                                    <td>{{ $reservation->payment_status }}</td>
                                    <td>{{ $reservation->booking_status }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Reference Number</th>
                                <th>Customer Name</th>
                                <th>Event Date</th>
                                <th>Reservation Date</th>
                                <th>Event Type</th>
                                <th>Venue</th>
                                <th>Number of Guests</th>
                                <th>Total Cost</th>
                                <th>Payment Status</th>
                                <th>Booking Status</th>
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
