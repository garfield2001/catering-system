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
                    <button id="add-category-button" class="card-title btn btn-primary">
                        <i class="fa-solid fa-plus"></i> Add New Category
                    </button>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Category Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr data-category-id="{{ $category->id }}" data-category-name="{{ $category->name }}"
                                    class="category-row">
                                    <td data-toggle="tooltip" title="Edit or Delete this Row">
                                        {{ $category->id }}</td>
                                    <td data-toggle="tooltip" title="Edit or Delete {{ $category->name }}">
                                        {{ $category->name }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
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
                buttons: ["copy", "csv", "excel", "pdf", "print", "colvis", ]
            }).buttons().container().appendTo('#table_wrapper .col-md-6:eq(0)');

            // Handle row hover effect  
            $('.category-row').hover(
                function() {
                    $(this).css('cursor', 'pointer');
                },
                function() {
                    $(this).css('cursor', 'default');
                }
            );

            // Handle Add Category button click with SweetAlert2
            $('#add-category-button').click(function(event) {
                event.preventDefault();

                Swal.fire({
                    title: '<span style="color: #007bff; font-weight: bold;">Add New Category</span>',
                    html: `
                        <form id="add-category-form" method="POST" action="{{ route('categories.store') }}">
                            @csrf
                            <div class="form-group">
                                <label for="add-category-name" style="text-align: left;">Name:</label>
                                <input type="text" class="form-control" id="add-category-name" name="name"  required>
                            </div>
                        </form>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Add',
                    cancelButtonText: 'Cancel',
                    icon: 'info',
                    preConfirm: () => {
                        const name = Swal.getPopup().querySelector('#add-category-name')
                            .value;
                        if (!name) {
                            Swal.showValidationMessage(`Please enter a Category Name`);
                        }
                        return {
                            name: name
                        }
                    },
                    didOpen: () => {
                        // Set focus to the input field
                        document.getElementById('add-category-name').focus();
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Submit the form via AJAX
                        $.ajax({
                            url: "{{ route('categories.store') }}",
                            method: "POST",
                            data: $("#add-category-form").serialize(),
                            success: function(data) {
                                // Reload content
                                loadContent(window.location.href);

                                toastr.success('Category added successfully.');
                            },
                            error: function(xhr, status, error) {
                                // Handle error
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

            $('.category-row').click(function(event) {
                event.preventDefault();

                var categoryId = $(this).data('category-id');
                var categoryName = $(this).data('category-name');

                Swal.fire({
                    title: `Edit <span style="color: #64B5F6;">${categoryName}</span>? `,
                    html: `
                        <form id="edit-category-form-${categoryId}" method="POST" action="/admin/categories/${categoryId}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" id="edit-category-id" name="id" value="${categoryId}">
                            <div class="form-group">
                                <label for="edit-category-name">Category Name:</label>
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="_method" value="PUT">
                                <input type="text" class="form-control" id="edit-category-name" name="name" value="${categoryName}" required>
                            </div>
                        </form>
                    `,
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: `Edit`,
                    denyButtonText: `Delete?`,
                    icon: 'warning',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Handle Edit Category button click with SweetAlert2
                        $.ajax({
                            url: "/admin/categories/" +
                                categoryId, // Corrected URL construction
                            method: "PUT",
                            data: $("#edit-category-form-" +
                                categoryId).serialize(),
                            success: function(data) {
                                toastr.success(
                                    'Category updated successfully.'
                                );
                                // Reload content
                                loadContent(window.location.href);
                            },
                            error: function(xhr, status,
                                error) {
                                // Handle error
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Failed to edit category. Please try again later.',
                                    icon: 'error'
                                });
                            }
                        });

                    } else if (result.isDenied) {
                        // Handle delete button click with SweetAlert2
                        Swal.fire({
                            title: `Delete <span style="color: #ff0000;">${categoryName}</span>?`,
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
                                    url: `/admin/categories/${categoryId}`,
                                    headers: {
                                        'X-CSRF-TOKEN': $(
                                            'meta[name="csrf-token"]'
                                        ).attr('content')
                                    },
                                    method: 'DELETE',
                                    success: function(data) {
                                        // Reload content
                                        loadContent(window.location
                                            .href);
                                        toastr.success(
                                            'Category deleted successfully.'
                                        );
                                    },
                                    error: function(xhr, status,
                                        error) {
                                        // Handle error
                                        Swal.fire({
                                            title: 'Error!',
                                            text: 'Failed to delete category. Please try again later.',
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
