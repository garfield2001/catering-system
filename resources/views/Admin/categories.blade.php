@extends('layouts.dashboard')

@section('title', $title)

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <button id="add-category-button" class="card-title btn btn-outline-primary btn-lg">
                        <i class="fa-solid fa-plus"></i> Add New Category
                    </button>
                </div>
                <div class="card-body">
                    <table id="table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Category Name</th>
                                <th>Category Description</th>
                                <th>Actions <i class="fa-solid fa-arrow-down"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr data-category-id="{{ $category->id }}">
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->description }}</td>
                                    <td>
                                        <button class="btn  btn-outline-primary edit-category"
                                            data-category-id="{{ $category->id }}"
                                            data-category-name="{{ $category->name }}"
                                            data-category-description="{{ $category->description }}">
                                            <i class="fa-solid fa-pen-to-square"></i> Edit
                                        </button>
                                        <button class="btn btn-outline-danger delete-category"
                                            data-category-id="{{ $category->id }}"
                                            data-category-name="{{ $category->name }}"
                                            data-category-description="{{ $category->description }}">
                                            <i class="fa-solid fa-trash"></i> Delete
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Category Description</th>
                                <th>Actions <i class="fa-solid fa-arrow-up"></i></th>
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

            $('#add-category-button').click(function(event) {
                event.preventDefault();

                Swal.fire({
                    title: '<span style="color: #007bff; font-weight: bold;">Add New Category</span>',
                    html: `
                        <form id="add-category-form" method="POST" action="{{ route('categories.store') }}">
                            @csrf
                            <div class="form-group">
                                <label for="add-category-name">Name:</label>
                                <input type="text" class="form-control" id="add-category-name" name="name" placeholder="Category Name" required>
                            </div>
                            <div class="form-group">
                                <label for="add-category-description">Description:</label>
                                <textarea class="form-control" id="add-category-description" name="description" placeholder="Category Description" required></textarea>
                            </div>
                        </form>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Add!',
                    confirmButtonColor: '#28a745',
                    cancelButtonText: 'Cancel',
                    icon: 'info',
                    preConfirm: () => {
                        const name = Swal.getPopup().querySelector('#add-category-name').value;
                        const description = Swal.getPopup().querySelector(
                            '#add-category-description').value;
                        if (!name) {
                            Swal.showValidationMessage(`Please enter a Category Name!`);
                        } else if (!description) {
                            Swal.showValidationMessage(`Please enter a Category Description!`);
                        }
                        return {
                            name: name,
                            description: description
                        }
                    },
                    didOpen: () => {
                        const $editCategoryName = $('#add-category-name');
                        const $editCategoryDescription = $('#add-category-description');

                        $editCategoryName.focus();

                        $editCategoryDescription.keydown(function(e) {
                            if (e.key === 'Enter') {
                                e.preventDefault();
                                Swal.getConfirmButton().click();
                            }
                        });
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('categories.store') }}",
                            method: "POST",
                            data: $("#add-category-form").serialize(),
                            success: function(data) {
                                const newRowData = [
                                    data.category.id,
                                    data.category.name,
                                    data.category.description,
                                    '<button class="btn btn-outline-primary edit-category" ' +
                                    'data-category-id="' + data.category.id + '" ' +
                                    'data-category-name="' + data.category.name +
                                    '" ' +
                                    'data-category-description="' + data.category
                                    .description + '">' +
                                    '<i class="fa-solid fa-pen-to-square"></i> Edit</button>' +
                                    ' <button class="btn btn-outline-danger delete-category" ' +
                                    'data-category-id="' + data.category.id + '" ' +
                                    'data-category-name="' + data.category.name +
                                    '" ' +
                                    'data-category-description="' + data.category
                                    .description + '">' +
                                    '<i class="fa-solid fa-trash"></i> Delete</button>'
                                ];

                                const table = $('#table').DataTable();

                                const newRow = table.row.add(newRowData).draw().node();

                                $(newRow).attr('data-category-id', data.category.id);

                                toastr.success('Category added successfully.');
                            },

                            error: function() {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Failed to add category. Please try again later.',
                                    icon: 'error'
                                });
                            }
                        });
                    }
                });
            });

            $('#table').on('click', '.edit-category, .delete-category', function(event) {
                event.preventDefault();

                const categoryId = $(this).data('category-id');
                const categoryName = $(this).data('category-name');
                const categoryDescription = $(this).data('category-description');

                /**
                 * *Check which class the clicked element has */
                if ($(this).hasClass('edit-category')) {
                    Swal.fire({
                        title: `Edit Category: <span style="color: #007BFF; font-weight:bold">${categoryName}</span>`,
                        html: `
                            <form id="edit-category-form-${categoryId}" method="POST" action="/admin/categories/${categoryId}">
                                @csrf
                                @method('PUT')
                                <input type="hidden" id="edit-category-id" name="id" value="${categoryId}">
                                <div class="form-group">
                                    <label for="edit-category-name">Category Name:</label>
                                    <input type="text" class="form-control" id="edit-category-name" placeholder="${categoryName}" name="name" required>
                                </div>
                                <div class="form-group">
                                    <label for="edit-category-description">Category Description:</label>
                                    <textarea class="form-control" id="edit-category-description" name="description" placeholder="${categoryDescription}" required></textarea>
                                </div>
                            </form>
                        `,
                        showCancelButton: true,
                        confirmButtonText: `Update!`,
                        confirmButtonColor: '#28a745',
                        icon: 'warning',
                        preConfirm: () => {
                            const name = Swal.getPopup().querySelector('#edit-category-name')
                                .value;
                            const description = Swal.getPopup().querySelector(
                                '#edit-category-description').value;
                            if (!name) {
                                Swal.showValidationMessage(`Please enter a Category Name!`);
                            } else if (!description) {
                                Swal.showValidationMessage(
                                    `Please enter a Category Description!`);
                            }
                            return {
                                name: name,
                                description: description
                            }
                        },
                        didOpen: () => {
                            const $editCategoryName = $('#edit-category-name');
                            const $editCategoryDescription = $('#edit-category-description');

                            $editCategoryName.focus();

                            $editCategoryDescription.keydown(function(e) {
                                if (e.key === 'Enter') {
                                    e.preventDefault();
                                    Swal.getConfirmButton().click();
                                }
                            });
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Handle Edit Category button click with SweetAlert2
                            $.ajax({
                                url: "/admin/categories/" +
                                    categoryId, // Corrected URL construction
                                method: "PUT",
                                data: $("#edit-category-form-" + categoryId).serialize(),
                                success: function(data) {
                                    // update row
                                    const updatedRow = [
                                        data.category.id,
                                        data.category.name,
                                        data.category.description,
                                        `
                                            <button class="btn btn-outline-primary edit-category" data-category-id="${data.category.id}"
                                                data-category-name="${data.category.name}"
                                                data-category-description="${data.category.description}">
                                                <i class="fa-solid fa-pen-to-square"></i> Edit</button>
                                            <button class="btn btn-outline-danger delete-category" data-category-id="${data.category.id}"
                                                data-category-name="${data.category.name}"
                                                data-category-description="${data.category.description}">
                                                <i class="fa-solid fa-trash"></i> Delete</button>
                                        `
                                    ];

                                    $('#table').DataTable().row($(
                                        'tr[data-category-id="' + data.category
                                        .id + '"]')).data(updatedRow).draw();

                                    toastr.success('Category updated successfully.');
                                },
                                error: function() {
                                    Swal.fire({
                                        title: 'Error!',
                                        text: 'Failed to edit category. Please try again later.',
                                        icon: 'error'
                                    });
                                }
                            });
                        } else if (
                            result.dismiss === Swal.DismissReason.cancel ||
                            result.dismiss === Swal.DismissReason.esc ||
                            result.dismiss === Swal.DismissReason.backdrop
                        ) {
                            toastr.info('Cancelled!');
                        }
                    })
                } else if ($(this).hasClass('delete-category')) {
                    Swal.fire({
                        title: `Delete <span style="color: #ff0000;">${categoryName}</span>?`,
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!',
                        showClass: {
                            popup: ''
                        },
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: `/admin/categories/${categoryId}`,
                                method: 'DELETE',
                                data: {
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function(response) {
                                    const table = $('#table').DataTable();
                                    table.row($('tr[data-category-id="' + categoryId +
                                        '"]')).remove().draw();
                                    toastr.success(response.message);
                                },
                                error: function() {
                                    Swal.fire({
                                        title: 'Error!',
                                        text: 'Failed to delete category. Please try again later.',
                                        icon: 'error'
                                    });
                                }
                            });
                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                            toastr.info('Cancelled!');
                        }
                    });
                }
            });
        });
    </script>
@endpush
