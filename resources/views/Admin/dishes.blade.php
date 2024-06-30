@extends('layouts.dashboard')

@section('title', $title)
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="row">
                    <div class="card-header">
                        <h3 class="card-title">Dishes</h3>
                    </div>
                    <div class="card-header col-4">
                        <p class="card-title text-info">Click each row for more actions!</p>
                    </div>
                </div>
                <div class="card-header">
                    <button id="add-dish-button" class="card-title btn btn-primary">
                        <i class="fa-solid fa-plus"></i> Add New Dish
                    </button>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Group</th>
                                <th>Package</th>
                                <th>Name</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($childDishes as $dish)
                                <tr data-dish-id="{{ $dish->id }}"
                                    data-dish-group="{{ optional($dish->parentDish)->name }}"
                                    data-dish-package="{{ optional($dish->package)->name }}"
                                    data-dish-name="{{ $dish->name }}" data-dish-price="{{ $dish->price }}"
                                    class="dish-row" data-toggle="tooltip" title="more actions">
                                    <td>{{ $dish->id }}</td>
                                    <td>{{ optional($dish->parentDish)->name ?? 'No Group' }}</td>
                                    <td>{{ optional($dish->package)->name ?? 'No Package' }}
                                        {{ optional($dish->package->category)->name }}</td>
                                    <td>{{ $dish->name }}</td>
                                    <td>{{ $dish->price ?? 'No Price' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Group</th>
                                <th>Package</th>
                                <th>Name</th>
                                <th>Price</th>
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
            var table = $("#table").DataTable({
                responsive: true,
                lengthChange: false,
                autoWidth: false,
                buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#table_wrapper .col-md-6:eq(0)');

            // Handle Add Dish button click with SweetAlert2
            $('#add-dish-button').click(function(event) {
                event.preventDefault();

                Swal.fire({
                    title: '<span style="color: #007bff; font-weight: bold;">Add New Dish</span>',
                    html: `
                        <form id="add-dish-form" method="POST" action="{{ route('dishes.store') }}">
                            @csrf
                            <div class="form-group">
                                <label for="add-dish-group">Group Dish:</label>
                                <select class="form-control" id="add-dish-group" name="parent_id">
                                    <option value="">Select Group</option>
                                    @foreach ($parentDishes as $dish)
                                        <option value="{{ $dish->id }}"> {{ $dish->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="add-dish-package">Package:</label>
                                <select class="form-control" id="add-dish-package" name="package_id">
                                    <option value="">Select Package</option>
                                    @foreach ($packages as $package)
                                        <option value="{{ $package->id }}">{{ $package->name }} / {{ $package->category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="add-dish-name">Dish Name:</label>
                                <input type="text" class="form-control" id="add-dish-name" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="add-dish-price">Price:</label>
                                <input type="number" class="form-control" id="add-dish-price" name="price" required>
                            </div>
                        </form>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Add',
                    cancelButtonText: 'Cancel',
                    icon: 'info',
                    preConfirm: () => {
                        const name = Swal.getPopup().querySelector('#add-dish-name').value;
                        if (!name) {
                            Swal.showValidationMessage(`Please enter a dish name`);
                        }
                        return {
                            name: name
                        }
                    },
                    didOpen: () => {
                        document.getElementById('add-dish-name').focus();
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Submit the form via AJAX
                        $.ajax({
                            url: "{{ route('dishes.store') }}",
                            method: "POST",
                            data: $("#add-dish-form").serialize(),
                            success: function(data) {
                                loadContent(window.location.href);
                                // Remove "No data available in table" row
                                /* if ($("#table tbody tr td").hasClass(
                                                                                                                    "dataTables_empty")) {
                                                                                                                $("#table tbody tr").remove();
                                                                                                            }
                                                                                                            // Reupdate row
                                                                                                            var newRow = `
                                <tr data-dish-id="${data.dish.id}"
                                    data-dish-group="${data.dish.parent_id.name}"
                                    data-dish-package="${data.dish.package.name}"
                                    data-dish-name="${data.dish.name}" data-dish-price="${data.dish.price}"
                                    class="dish-row" data-toggle="tooltip" title="more actions">
                                    <td>${data.dish.id}</td>
                                    <td>${data.dish.parent_id.name}</td>
                                    <td>${data.dish.package.name}</td>
                                    <td>${data.dish.name}</td>
                                    <td>${data.dish.price}</td>
                                </tr>
                            `;
                                                                                                            $('#table tbody').append(newRow); */

                                toastr.success('Dish added successfully.');
                            },
                            error: function(xhr, status, error) {
                                // Handle error response (if needed)
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Failed to add package. Please try again later.',
                                    icon: 'error'
                                });
                            }
                        });
                    }
                });
            });

            // Event delegation for dish row clicks
            $('#table').on('click', '.dish-row', function(event) {
                event.preventDefault();

                var dishId = $(this).data('dish-id');
                var dishGroup = $(this).data('dish-group');
                var dishPackage = $(this).data('dish-package');
                var dishName = $(this).data('dish-name');
                var dishPrice = $(this).data('dish-price');

                Swal.fire({
                    title: `Edit <span style="color: #64B5F6;">${dishName}</span>?`,
                    html: `
                    <form id="edit-dish-form-${dishId}" method="POST" action="/admin/dishes/${dishId}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" id="edit-dish-id" name="id" value="${dishId}">
                        <div class="form-group">
                            <label for="edit-dish-group">Group Dish:</label>
                            <select class="form-control" id="edit-dish-group" name="parent_id">
                                <option value="">Select Group</option>
                                @foreach ($parentDishes as $parentDish)
                                    <option value="{{ $parentDish->id }}"
                                        ${dishGroup === '{{ $parentDish->name }}' ? 'selected' : ''}>
                                        {{ $parentDish->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit-dish-package">Package:</label>
                            <select class="form-control" id="edit-dish-package" name="package_id">
                                <option value="">Select Package</option>
                                @foreach ($packages as $package)
                                    <option value="{{ $package->id }}"
                                        @foreach ($dishes as $dish)
                                            {{ $package->id == optional($dish->package)->id ? 'selected' : ' ' }} @endforeach>
                                        {{ $package->name }} / {{ $package->category->name }}    
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit-dish-name">Dish Name:</label>
                            <input type="text" class="form-control" id="edit-dish-name" name="name" value="${dishName}" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-dish-price">Price:</label>
                            <input type="number" class="form-control" id="edit-dish-price" name="price" value="${dishPrice}">
                        </div>
                    </form>
                    `,
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: `Edit`,
                    denyButtonText: `Delete`,
                    icon: 'warning',
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: `Edit`,
                    denyButtonText: `Delete`,
                    icon: 'warning',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/admin/dishes/${dishId}`,
                            method: "PUT",
                            data: $("#edit-dish-form-" + dishId).serialize(),
                            success: function(data) {
                                // Reload content
                                loadContent(window.location.href);
                                toastr.success('Dish updated successfully.');
                            },
                            error: function(xhr, status, error) {
                                // Handle error
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Failed to edit dish. Please try again later.',
                                    icon: 'error'
                                });
                            }
                        });
                    } else if (result.isDenied) {
                        Swal.fire({
                            title: `Are you sure you want to delete the dish "${dishName}"?`,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Yes, delete it!',
                            cancelButtonText: 'Cancel',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Submit the delete request via AJAX
                                $.ajax({
                                    url: `/admin/dishes/${dishId}`,
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                                            .attr('content')
                                    },
                                    method: 'DELETE',
                                    success: function(data) {
                                        // Reload content
                                        loadContent(window.location.href);
                                        toastr.success(
                                            'Dish deleted successfully.');

                                        // Check if table is empty
                                        if ($('#table tbody tr').length === 0) {
                                            var noDataRow = `
                                                <tr class="no-data">
                                                    <td colspan="2" class="text-center">No data available in table</td>
                                                </tr>
                                            `;
                                            $('#table tbody').append(noDataRow);
                                        }
                                    },
                                    error: function(xhr, status, error) {
                                        // Handle error
                                        Swal.fire({
                                            title: 'Error!',
                                            text: 'Failed to delete dish. Please try again later.',
                                            icon: 'error'
                                        });
                                    }
                                });
                            }
                        });
                    }
                });
            });


            // Initial binding of hover effects
            $('#table').on('mouseenter mouseleave', '.dish-row', function(event) {
                if (event.type === 'mouseenter') {
                    $(this).css('cursor', 'pointer');
                } else {
                    $(this).css('cursor', 'default');
                }
            });

        });
    </script>
@endpush
