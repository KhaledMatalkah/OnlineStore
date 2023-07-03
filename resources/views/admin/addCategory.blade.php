@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Add Category</h2>

        <form class="add-category-form" action="{{ route('categories.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">Category Name:</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>

            <button style="margin-top: 20px;" type="submit" class="btn btn-primary">Add Category</button>
        </form>
    </div>

    <div class="container">
        <h1>Categories</h1>
        <ul class="category-list">
            @foreach ($categories as $category)
                <li class="category-item">
                    <div class="category-circle">
                        <span class="category-name">{{ $category->name }}</span>
                        <form action="{{ route('categories.delete', $category->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            {{-- <button class="delete-category" data-category-id="{{ $category->id }}">Delete</button> --}}

                            <button class="delete-category" type="submit" data-category-id="{{ $category->id }}">X</button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Delete Category function
            function showNotification(type, message) {
                toastr[type](message);
            }

            // Delete Category function
            function deleteCategory(categoryId, categoryItem) {
                $.ajax({
                    url: "/categories/" + categoryId,
                    method: "DELETE",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.hasOwnProperty('error')) {
                            toastr.error(response.error, 'Error');
                        } else {
                            toastr.success(response.success);
                            categoryItem.remove();
                        }
                    },
                    error: function(xhr, status, error) {
                        var errorMessage = xhr.responseJSON.error;
                        // Show error notification
                        showNotification('error', errorMessage);
                    }
                });
            }

            // Attach click event to delete buttons
            $(document).on('click', '.delete-category', function(e) {
                e.preventDefault();
                var categoryId = $(this).data('category-id');
                var categoryItem = $(this).closest('.category-item');
                deleteCategory(categoryId, categoryItem);
            });

            // Add Category form submission
            $('.add-category-form').submit(function(e) {
                e.preventDefault();

                var form = $(this);
                var url = form.attr('action');
                var data = form.serialize();

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: data,
                    success: function(response) {
                        // Clear the input field
                        form.find('#name').val('');

                        // Append the new category to the category list
                        var newCategory = $(
                            '<li class="category-item"><div class="category-circle"><span class="category-name">' +
                            response.name +
                            '</span></div><button class="delete-category" data-category-id="' +
                            response.id + '">X</button></li>');
                        $('.category-list').append(newCategory);

                        toastr.success('Category added successfully');
                        reloadCategories();
                    },
                    error: function(xhr, status, error) {
                        var errorMessage = 'An error occurred while adding the category';
                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            errorMessage = xhr.responseJSON.error;
                        }
                        toastr.error(errorMessage);
                    }
                });
            });

            function reloadCategories() {
                $.ajax({
                    url: "{{ route('category.add') }}",
                    method: "GET",
                    success: function(response) {
                        $('.category-list').html($(response).find('.category-list').html());
                    },
                    error: function(xhr, status, error) {
                        toastr.error('An error occurred while reloading the categories');
                    }
                });
            }

            // Reload categories when page loads
            reloadCategories();
        });
    </script>
@endsection
