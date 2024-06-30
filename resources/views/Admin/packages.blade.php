@extends('layouts.dashboard')

@section('title', $title)


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <button id="add-package-button" class="card-title btn btn-outline-primary">
                        <i class="fa-solid fa-plus"></i> Add New Package
                    </button>
                </div>
                <div class="card-body">
                    <table id="table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Category</th>
                                <th>Package Name</th>
                                <th>Price</th>
                                <th>Actions <i class="fa-solid fa-arrow-down"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($packages as $package)
                                <tr data-package-id="{{ $package->id }}">
                                    <td>{{ $package->id }}</td>
                                    <td>{{ $package->category->name }}</td>
                                    <td>{{ $package->name }}</td>
                                    <td>{{ $package->price ? '₱ ' . $package->price : 'No Price' }}</td>
                                    <td>
                                        <button class="btn btn-outline-primary edit-package"
                                            data-package-id="{{ $package->id }}" data-package-name="{{ $package->name }}"
                                            data-package-category="{{ optional($package->categor)->name }}"
                                            data-package-price="{{ $package->price }}">
                                            <i class="fa-solid fa-pen-to-square"></i> Edit
                                        </button>
                                        <button class="btn btn-outline-danger delete-package"
                                            data-package-id="{{ $package->id }}" data-package-name="{{ $package->name }}"
                                            data-package-category="{{ optional($package->category)->name }}"
                                            data-package-price="{{ $package->price }}">
                                            <i class="fa-solid fa-trash"></i> Delete
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Package Name</th>
                                <th>Price</th>
                                <th>Actions <i class="fa-solid fa-arrow-down"></i></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script id="custom-script">
        $(document).ready(function() {
            $("#table").DataTable({
                responsive: true,
                lengthChange: false,
                autoWidth: false,
                buttons: [{
                        extend: "copy",
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    }, {
                        extend: "csv",
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    }, {
                        extend: "excel",
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    }, {
                        extend: "pdf",
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    }, {
                        extend: "print",
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    "colvis",
                ]
            }).buttons().container().appendTo('#table_wrapper .col-md-6:eq(0)');

            $('#add-package-button').click(function(event) {
                event.preventDefault();

                Swal.fire({
                    title: '<span style="color: #007bff; font-weight: bold;">Add New Package</span>',
                    html: `
                        <form id="add-package-form" method="POST" action="{{ route('packages.store') }}">
                            @csrf
                            <div class="form-group">
                                <label for="add-package-name">Name:</label>
                                <input type="text" class="form-control" id="add-package-name" name="name" placeholder="Package Name" required>
                            </div>
                            <div class="form-group">
                                <label for="add-package-category">Category:</label>
                                <select class="form-control" id="add-package-category" name="category_id" required>
                                    <option value="" disabled selected>Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="add-package-price">Price:</label>
                                <input type="number" class="form-control" id="add-package-price" name="price" placeholder="Package Price" required>
                                <p class="text-info">Leave blank if the package has no price</p>
                            </div>
                        </form>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Add',
                    cancelButtonText: 'Cancel',
                    icon: 'info',
                    preConfirm: () => {
                        const package = Swal.getPopup().querySelector('#add-package-category')
                            .value;
                        const category = Swal.getPopup().querySelector('#add-package-category')
                            .value;
                        if (!package) {
                            Swal.showValidationMessage(`Please enter a package name.`);
                        } else if (!category) {
                            Swal.showValidationMessage(`Please select a category.`);
                        }
                        return {
                            package: package,
                            category: category
                        };
                    },
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Submit the form via AJAX
                        $.ajax({
                            url: "{{ route('packages.store') }}",
                            method: "POST",
                            data: $("#add-package-form").serialize(),
                            success: function(data) {
                                const newRowData = [
                                    data.package.id,
                                    data.package.category.name,
                                    data.package.name,
                                    data.package.price,
                                    '<button class="btn btn-outline-primary edit-package" ' +
                                    'data-package-id="' + data.package.id + '" ' +
                                    'data-package-category="' + data.package
                                    .category.name + '" ' +
                                    'data-package-name="' + data.package.name +
                                    '" ' +
                                    'data-package-price="' + data.package.price +
                                    '<i class="fa-solid fa-pen-to-square"></i> Edit</button>' +
                                    '<button class="btn btn-outline-primary delete-package" ' +
                                    'data-package-id="' + data.package.id + '" ' +
                                    'data-package-category="' + data.package
                                    .category.name + '" ' +
                                    'data-package-name="' + data.package.name +
                                    '" ' +
                                    'data-package-price="' + data.package.price +
                                    '<i class="fa-solid fa-trash"></i> Delete</button>'
                                ];

                                const table = $('#table').DataTable();

                                const newRow = table.row.add(newRowData).draw().node();

                                $(newRow).attr('data-package-id', data.package.id);

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

            // Event delegation for package row clicks
            $('#table').on('click', '.package-row', function(event) {
                event.preventDefault();

                var packageId = $(this).data('package-id');
                var packageName = $(this).data('package-name');
                var packageCategory = $(this).data('package-category');
                var packagePrice = $(this).data('package-price');

                Swal.fire({
                    title: `Edit <span style="color: #007bff; font-weight: bold;"> ${packageName}</span>?`,
                    html: `
                        <form id="edit-package-form-${packageId}" method="POST" action="/admin/packages/${packageId}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" id="edit-package-id" name="id" value="${packageId}">
                            <div class="form-group">
                                <label for="edit-package-category">Category:</label>
                                <select class="form-control" id="edit-package-category" name="category_id" required>
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            ${packageCategory === '{{ $category->name }}' ? 'selected' : ''}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="edit-package-name">Package Name:</label>
                                <input type="text" class="form-control" id="edit-package-name" name="name" value="${packageName}" required>
                            </div>
                            <div class="form-group">
                                <label for="edit-package-price">Price:</label>
                                <input type="number" class="form-control" id="edit-package-price" name="price" value="${packagePrice}" required>
                                <p class="text-info">Leave blank if the package has no price</p>
                            </div>
                        </form>
                    `,
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: `Edit`,
                    denyButtonText: `Delete`,
                    icon: 'warning',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Handle Edit Package button click with SweetAlert2
                        $.ajax({
                            url: `/admin/packages/${packageId}`,
                            method: "PUT",
                            data: $(`#edit-package-form-${packageId}`).serialize(),
                            success: function(data) {
                                // Reload content
                                loadContent(window.location.href);
                                /* var updatedRow = `
                                <tr data-package-id="${data.package.id}" data-package-name="${data.package.name}"
                                    data-package-category="${data.package.category.name}"class="package-row"
                                    data-package-price="${data.package.price}" data-toggle="tooltip" title="more actions">
                                    <td>${data.package.id}</td>
                                    <td>${data.package.category.name}</td>
                                    <td>${data.package.name}</td>
                                    <td>${data.package.price}</td>
                                </tr>
                            `;
                                                                                                                                            $('#table tbody tr[data-package-id="' + data.package
                                                                                                                                                .id + '"]').replaceWith(updatedRow); */
                                toastr.success('Package updated successfully.');
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
                    } else if (result.isDenied) {
                        // Handle delete button click with SweetAlert2
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



                                        $('#table tbody tr[data-package-id="' +
                                            packageId + '"]').remove();
                                        toastr.success(
                                            'Package deleted successfully.'
                                        );
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
                });
            });

            // Initial binding of hover effects
            $('#table').on('mouseenter mouseleave', '.package-row', function(event) {
                if (event.type === 'mouseenter') {
                    $(this).css('cursor', 'pointer');
                } else {
                    $(this).css('cursor', 'default');
                }
            });
        });
    </script>
@endpush
