@extends('layouts.admin')
@section('content')
<!-- Add Font Awesome CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin./') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.product.category.index') }}">Categories</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $category->name }}</li>
                </ol>
            </nav>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <strong>{{ session('success') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <strong>{{ session('error') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="m-0">Category Details</h4>
                    <a href="{{ route('admin.product.category.index') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-arrow-left"></i> Back to Categories
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        @if($category->image)
                            <div class="col-md-4">
                                <img src="{{ asset('category_images/' . $category->image) }}" alt="{{ $category->name }}" class="img-fluid rounded mb-3">
                            </div>
                        @endif
                        <div class="col-md-{{ $category->image ? '8' : '12' }}">
                            <h3>{{ $category->name }}</h3>
                            <p class="text-muted">
                                <strong>ID:</strong> {{ $category->id }} |
                                <strong>Created:</strong> {{ $category->created_at->format('M d, Y') }} |
                                <strong>Last Updated:</strong> {{ $category->updated_at->format('M d, Y') }}
                            </p>

                            @if($category->description)
                                <div class="mb-4">
                                    <h5><i class="fas fa-info-circle"></i> Description</h5>
                                    <p>{{ $category->description }}</p>
                                </div>
                            @endif

                            <div class="mb-4">
                                <h5><i class="fas fa-box"></i> Products in this Category</h5>
                                @if($category->products && $category->products->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Name</th>
                                                    <th>Price</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($category->products as $product)
                                                    <tr>
                                                        <td>{{ $product->id }}</td>
                                                        <td>{{ $product->name }}</td>
                                                        <td>${{ number_format($product->price, 2) }}</td>
                                                        <td>
                                                            <div class="btn-group" role="group">
                                                                <a href="{{ route('admin.product.show', $product->id) }}" class="btn btn-sm btn-info">
                                                                    <i class="fas fa-eye"></i> View
                                                                </a>
                                                                <a href="{{ route('admin.product.edit', $product->id) }}" class="btn btn-sm btn-primary">
                                                                    <i class="fas fa-edit"></i> Edit
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <p class="text-muted mt-2">
                                        <i class="fas fa-info-circle"></i> Total products: {{ $category->products->count() }}
                                    </p>
                                @else
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle"></i> No products in this category.
                                    </div>
                                @endif
                            </div>

                            <div class="d-flex gap-2 mt-4">
                                <a href="{{ route('admin.product.category.edit', $category->id) }}" class="btn btn-primary">
                                    <i class="fas fa-edit"></i> Edit Category
                                </a>
                                <button type="button" class="btn btn-danger delete-category-btn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteCategoryModal"
                                    data-category-id="{{ $category->id }}"
                                    data-category-name="{{ $category->name }}">
                                    <i class="fas fa-trash-alt"></i> Delete Category
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Delete Category Modal -->
<div class="modal fade" id="deleteCategoryModal" tabindex="-1" aria-labelledby="deleteCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteCategoryModalLabel">Delete Category</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i> Warning: This action cannot be undone.
                </div>

                <p>Are you sure you want to delete the category: <strong id="categoryNameToDelete"></strong>?</p>

                <div id="categoryHasProducts" class="d-none">
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i> This category has associated products.
                    </div>

                    <div class="form-group mb-3">
                        <label for="productAction" class="form-label">What would you like to do with the associated products?</label>
                        <select class="form-select" id="productAction" name="product_action">
                            <option value="reassign">Reassign to another category</option>
                            <option value="delete">Delete all associated products</option>
                        </select>
                    </div>

                    <div id="reassignCategoryContainer">
                        <div class="form-group">
                            <label for="reassignCategory" class="form-label">Select category to reassign products to:</label>
                            <select class="form-select" id="reassignCategory" name="reassign_category_id">
                                <!-- Will be populated via JavaScript -->
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteCategoryForm" action="" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="product_action" id="productActionInput" value="">
                    <input type="hidden" name="reassign_category_id" id="reassignCategoryInput" value="">
                    <button type="submit" class="btn btn-danger">Delete Category</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for Delete Category Modal -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get all delete category buttons
        const deleteButtons = document.querySelectorAll('.delete-category-btn');

        // Add click event listener to each button
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const categoryId = this.getAttribute('data-category-id');
                const categoryName = this.getAttribute('data-category-name');

                // Set the category name in the modal
                document.getElementById('categoryNameToDelete').textContent = categoryName;

                // Set the form action
                document.getElementById('deleteCategoryForm').action = "{{ route('admin.product.category.destroy', '') }}/" + categoryId;

                // Check if category has products
                fetch(`/admin/api/category/${categoryId}/has-products`)
                    .then(response => response.json())
                    .then(data => {
                        const hasProductsContainer = document.getElementById('categoryHasProducts');

                        if (data.hasProducts) {
                            hasProductsContainer.classList.remove('d-none');

                            // Populate reassign category dropdown
                            const reassignSelect = document.getElementById('reassignCategory');
                            reassignSelect.innerHTML = ''; // Clear existing options

                            data.availableCategories.forEach(category => {
                                if (category.id != categoryId) {
                                    const option = document.createElement('option');
                                    option.value = category.id;
                                    option.textContent = category.name;
                                    reassignSelect.appendChild(option);
                                }
                            });

                            // Set up event listeners for product action
                            const productAction = document.getElementById('productAction');
                            const reassignContainer = document.getElementById('reassignCategoryContainer');

                            productAction.addEventListener('change', function() {
                                if (this.value === 'reassign') {
                                    reassignContainer.classList.remove('d-none');
                                } else {
                                    reassignContainer.classList.add('d-none');
                                }

                                // Update hidden input
                                document.getElementById('productActionInput').value = this.value;
                            });

                            // Set initial values
                            productAction.dispatchEvent(new Event('change'));

                            // Update hidden input when reassign category changes
                            document.getElementById('reassignCategory').addEventListener('change', function() {
                                document.getElementById('reassignCategoryInput').value = this.value;
                            });

                            // Trigger change event to set initial value
                            document.getElementById('reassignCategory').dispatchEvent(new Event('change'));
                        } else {
                            hasProductsContainer.classList.add('d-none');
                        }
                    })
                    .catch(error => {
                        console.error('Error checking if category has products:', error);
                    });
            });
        });
    });
</script>
@endsection
