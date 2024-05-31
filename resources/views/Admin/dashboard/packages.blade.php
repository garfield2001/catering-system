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
                    <button id="add-package-button" class="card-title btn btn-primary">
                        <i class="fa-solid fa-plus"></i> Add New</button>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Category</th>
                                <th>Package Name</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($packages as $package)
                                <tr data-package-id="{{ $package->id }}" data-package-name="{{ $package->name }}"
                                    data-package-category="{{ $package->category->name }}"class="package-row"
                                    data-package-price="{{ $package->price }}" data-toggle="tooltip" title="more actions">
                                    <td>{{ $package->id }}</td>
                                    <td>{{ $package->category->name }}</td>
                                    <td>{{ $package->name }}</td>
                                    <td>{{ $package->price ? '₱ ' . $package->price : 'No Price' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Package Name</th>
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
            $("#table").DataTable({
                responsive: true,
                lengthChange: false,
                autoWidth: false,
                buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#table_wrapper .col-md-6:eq(0)');

            // Handle row hover effect
            $('.package-row').hover(
                function() {
                    $(this).css('cursor', 'pointer');
                },
                function() {
                    $(this).css('cursor', 'default');
                }
            );

            // Handle Add Package button click with SweetAlert2
            $('#add-package-button').click(function(event) {
                event.preventDefault();

                Swal.fire({
                    title: '<span style="color: #007bff; font-weight: bold;">Add New Package</span>',
                    html: `
                            <form id="add-package-form" method="POST" action="{{ route('packages.store') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="add-package-name" style="text-align: left;">Package Name:</label>
                                    <input type="text" class="form-control" id="add-package-name" name="name" required>
                                </div>
                                <div class="form-group">
                                    <label for="add-package-category" style="text-align: left;">Category:</label>
                                    <select class="form-control" id="add-package-category" name="category_id" required>
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="add-package-price" style="text-align: left;">Price:</label>
                                    <input type="number" class="form-control" id="add-package-price" name="price" required>
                                </div>
                            </form>
                        `,
                    showCancelButton: true,
                    confirmButtonText: 'Add',
                    cancelButtonText: 'Cancel',
                    icon: 'info',
                    preConfirm: () => {
                        const name = Swal.getPopup().querySelector('#add-package-name')
                            .value;
                        if (!name) {
                            Swal.showValidationMessage(`Please enter a package name`);
                        }
                        return {
                            name: name
                        }
                    },
                    didOpen: () => {
                        // Set focus to the input field
                        document.getElementById('add-package-name').focus();
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Submit the form via AJAX
                        $.ajax({
                            url: "{{ route('packages.store') }}",
                            method: "POST",
                            data: $("#add-package-form").serialize(),
                            success: function(data) {
                                // Reload content
                                loadContent(window.location.href);

                                toastr.success('Package added successfully.');
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

            $('.package-row').click(function(event) {
                event.preventDefault();

                var packageId = $(this).data('package-id');
                var packageName = $(this).data('package-name');
                var packageCategory = $(this).data('package-category');
                var categoryPrice = $(this).data('package-price');

                Swal.fire({
                    title: `Edit or Delete`,
                    title: `Edit or Delete <span style="color: #64B5F6;">${packageName}</span>?`,
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: `Edit`,
                    denyButtonText: `Delete`,
                    icon: 'warning',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Handle Edit Package button click with SweetAlert2
                        event.preventDefault();

                        var packageId = $(this).data('package-id');
                        var packageName = $(this).data('package-name');
                        var packageCategory = $(this).data('package-category');
                        var packagePrice = $(this).data('package-price');

                        Swal.fire({
                            title: '<span style="color: #007bff; font-weight: bold;">Edit Package</span>',
                            html: `
                                <form id="edit-package-form-${packageId}" method="POST" action="/admin/packages/${packageId}">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="_method" value="PUT">
                                    <input type="hidden" id="edit-package-id" name="id" value="${packageId}">
                                    <div class="form-group">
                                        <label for="edit-package-name">Package Name:</label>
                                        <input type="text" class="form-control" id="edit-package-name" name="name" value="${packageName}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="edit-package-category">Category:</label>
                                        <select class="form-control" id="edit-package-category" name="categoryId" required>
                                            <option value="">Select Category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}" 
                                                    @foreach ($packages as $package)
                                                        {{ $category->id == $package->category->id ? 'selected' : '' }} @endforeach>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="edit-package-price">Price:</label>
                                        <input type="number" class="form-control" id="edit-package-price" name="price" value="${packagePrice}" required>
                                    </div>
                                </form>
                            `,
                            showCancelButton: true,
                            confirmButtonText: 'Update',
                            cancelButtonText: 'Cancel',
                            icon: 'warning',
                            preConfirm: () => {
                                const name = Swal.getPopup().querySelector(
                                    '#edit-package-name').value;
                                const categoryId = Swal.getPopup().querySelector(
                                    '#edit-package-category').value;
                                const price = Swal.getPopup().querySelector(
                                        '#edit-package-price')
                                    .value;
                                if (!name || !categoryId || !price) {
                                    Swal.showValidationMessage(
                                        `Please enter package name, select a category, and provide a price`
                                    );
                                }
                                return {
                                    name: name,
                                    category_id: categoryId,
                                    price: price
                                };
                            },
                            didOpen: () => {
                                document.getElementById('edit-package-name').focus();
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Submit the form via AJAX
                                $.ajax({
                                    url: `/admin/packages/${packageId}`,
                                    method: "PUT",
                                    data: $("#edit-package-form-" + packageId)
                                        .serialize(),
                                    success: function(data) {
                                        // Reload content
                                        loadContent(window.location.href);
                                        toastr.success(
                                            'Package updated successfully.');
                                    },
                                    error: function(xhr, status, error) {
                                        // Handle error
                                        Swal.fire({
                                            title: 'Error!',
                                            text: 'Failed to edit package. Please try again later.',
                                            icon: 'error'
                                        });
                                    }
                                });
                            }
                        });
                    } else if (result.isDenied) {
                        // Handle delete button click with SweetAlert2

                        event.preventDefault(); // Prevent the form from submitting immediately
                        var packageId = $(this).data('package-id');
                        var packageName = $(this).data('package-name');
                        var form = $('#delete-form-' + packageId);

                        Swal.fire({
                            title: `Delete <span style="color: #ff0000;">${packageName}</span>?`,
                            text: "You won't be able to revert this!",
                            icon: 'error',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, delete it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Submit the delete request via AJAX
                                $.ajax({
                                    url: `/admin/packages/${packageId}`,
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                                            .attr('content')
                                    },
                                    method: 'DELETE',
                                    success: function(data) {
                                        // Reload content
                                        loadContent(window.location.href);
                                        toastr.success(
                                            'Package deleted successfully.');
                                    },
                                    error: function(xhr, status, error) {
                                        // Handle error
                                        Swal.fire({
                                            title: 'Error!',
                                            text: 'Failed to delete package. Please try again later.',
                                            icon: 'error'
                                        });
                                    }
                                });
                            }
                        });
                    }
                })
            });
        });
    </script>
@endpush
