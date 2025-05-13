@extends('layouts.admin')
@section('content')

<!-- Add Font Awesome CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

<div class="container">
    <h2 class="mt-2">Category Management</h2>

    <div class="row">
        <div class="col-md-6 p-3">
            <!-- Search and Filter Form -->
            <form action="{{ route('admin.product.category.index') }}" method="GET" class="mb-4">
                <div class="row g-2">
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Search categories..." value="{{ $search ?? '' }}">
                            <button class="btn btn-outline-secondary" type="submit">Search</button>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select name="per_page" class="form-select" onchange="this.form.submit()">
                            <option value="10" {{ ($perPage ?? 10) == 10 ? 'selected' : '' }}>10 per page</option>
                            <option value="25" {{ ($perPage ?? 10) == 25 ? 'selected' : '' }}>25 per page</option>
                            <option value="50" {{ ($perPage ?? 10) == 50 ? 'selected' : '' }}>50 per page</option>
                            <option value="100" {{ ($perPage ?? 10) == 100 ? 'selected' : '' }}>100 per page</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('admin.product.category.index') }}" class="btn btn-outline-secondary">Reset</a>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>
                                <a href="{{ route('admin.product.category.index', [
                                    'sort_by' => 'id',
                                    'sort_direction' => ($sortBy == 'id' && $sortDirection == 'asc') ? 'desc' : 'asc',
                                    'per_page' => $perPage,
                                    'search' => $search
                                ]) }}" class="text-decoration-none text-dark">
                                    ID
                                    @if($sortBy == 'id')
                                        <i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }}"></i>
                                    @else
                                        <i class="fas fa-sort"></i>
                                    @endif
                                </a>
                            </th>
                            <th>
                                <a href="{{ route('admin.product.category.index', [
                                    'sort_by' => 'name',
                                    'sort_direction' => ($sortBy == 'name' && $sortDirection == 'asc') ? 'desc' : 'asc',
                                    'per_page' => $perPage,
                                    'search' => $search
                                ]) }}" class="text-decoration-none text-dark">
                                    Name
                                    @if($sortBy == 'name')
                                        <i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }}"></i>
                                    @else
                                        <i class="fas fa-sort"></i>
                                    @endif
                                </a>
                            </th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->name }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.product.category.edit', $category->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                    <button type="button" class="btn btn-sm btn-danger delete-category-btn"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteCategoryModal"
                                        data-category-id="{{ $category->id }}"
                                        data-category-name="{{ $category->name }}">
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center">No categories found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Controls -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    Showing {{ $categories->firstItem() ?? 0 }} to {{ $categories->lastItem() ?? 0 }} of {{ $categories->total() }} categories
                </div>
                <div>
                    {{ $categories->appends([
                        'search' => $search,
                        'per_page' => $perPage,
                        'sort_by' => $sortBy,
                        'sort_direction' => $sortDirection
                    ])->links() }}
                </div>
            </div>

        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title mb-0">Add New Category</h3>
                </div>
                <div class="card-body">
                    @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <strong>{{ $message }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    @if ($message = Session::get('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        <strong>{{ $message }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <form method="post" action="{{ route('admin.product.category.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="category_name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="category_name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="category_description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="category_description" name="description" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="category_image" class="form-label">Image</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="category_image" name="image">
                            <div class="form-text">Supported formats: JPEG, PNG, JPG, GIF. Max size: 2MB.</div>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Add Category</button>
                        </div>
                    </form>
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
