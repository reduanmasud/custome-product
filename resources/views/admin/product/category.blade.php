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
                                    <form action="{{ route('admin.product.category.destroy', $category->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this category?')">Delete</button>
                                    </form>
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



<!-- No additional scripts needed -->
@endsection
