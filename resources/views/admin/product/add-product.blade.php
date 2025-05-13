@extends('layouts.admin')
@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Add New Product</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="{{ route('admin.product.all') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Products
                </a>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <h5><i class="fas fa-exclamation-triangle"></i> Please fix the following errors:</h5>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> <strong>{{ $message }}</strong>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-plus-circle me-1"></i>
            Product Information
        </div>
        <div class="card-body">
            <form action="{{ route('admin.product.store') }}" method="post" enctype="multipart/form-data" id="productForm">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Product Name <span class="text-danger">*</span></label>
                            <input type="text" value="{{ old('name') }}" name="name" class="form-control @error('name') is-invalid @enderror"
                                id="name" placeholder="Enter product name" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="sku" class="form-label">SKU <span class="text-danger">*</span></label>
                            <input type="text" value="{{ old('sku') }}" name="sku" class="form-control @error('sku') is-invalid @enderror"
                                id="sku" placeholder="Enter unique SKU" required>
                            @error('sku')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Product Description <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description"
                        rows="4" placeholder="Enter detailed product description" required>{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="price" class="form-label">Price <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" step="0.01" min="0" name="price" value="{{ old('price') }}"
                                    class="form-control @error('price') is-invalid @enderror"
                                    id="price" placeholder="0.00" required>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="inventory" class="form-label">Inventory <span class="text-danger">*</span></label>
                            <input type="number" min="0" value="{{ old('inventory') }}" name="inventory"
                                class="form-control @error('inventory') is-invalid @enderror"
                                id="inventory" placeholder="Enter quantity in stock" required>
                            @error('inventory')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Primary Category <span class="text-danger">*</span></label>
                            <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                                <option value="">Select a Primary Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <div class="mt-3">
                                <label class="form-label">Additional Categories</label>
                                <div class="border rounded p-3">
                                    <div class="row">
                                        @foreach ($categories as $category)
                                            <div class="col-md-4 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="additional_categories[]"
                                                        value="{{ $category->id }}" id="category_{{ $category->id }}"
                                                        {{ (is_array(old('additional_categories')) && in_array($category->id, old('additional_categories'))) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="category_{{ $category->id }}">
                                                        {{ $category->name }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <small class="text-muted">Select additional categories that this product belongs to</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="available" name="available" value="1"
                            {{ old('available', '1') == '1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="available">Product is available for purchase</label>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-images me-1"></i>
                        Product Variations
                        <button type="button" id="add_variation" class="btn btn-sm btn-primary float-end">
                            <i class="fas fa-plus"></i> Add Variation
                        </button>
                    </div>
                    <div class="card-body">
                        <div id="variation-container">
                            <div class="alert alert-info" id="no-variations" {{ old('product_image') ? 'style=display:none;' : '' }}>
                                <i class="fas fa-info-circle"></i> Click "Add Variation" to add product images and color variations.
                            </div>
                            <div id="variation">
                                @if(old('product_image'))
                                    @foreach(old('product_image') as $key => $value)
                                        <div class="variation-item mb-3">
                                            <div class="card">
                                                <div class="card-header d-flex justify-content-between align-items-center">
                                                    <span>Variation {{ $key + 1 }}</span>
                                                    <button type="button" class="btn btn-sm btn-danger remove-variation">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label">Color (Optional)</label>
                                                                <input type="color" name="color[]" class="form-control form-control-color"
                                                                    value="{{ old('color.'.$key, '#000000') }}" title="Choose color">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label">Image <span class="text-danger">*</span></label>
                                                                <input type="file" class="form-control @error('product_image.'.$key) is-invalid @enderror"
                                                                    name="product_image[]" accept="image/*" required>
                                                                @error('product_image.'.$key)
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="image-preview mt-2"></div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="{{ route('admin.product.all') }}" class="btn btn-secondary me-md-2">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Product
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Add variation
            $('#add_variation').click(function() {
                var count_var = $('#variation').children('.variation-item').length;
                var html = `
                <div class="variation-item mb-3">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span>Variation ${count_var+1}</span>
                            <button type="button" class="btn btn-sm btn-danger remove-variation">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Color (Optional)</label>
                                        <input type="color" name="color[]" class="form-control form-control-color"
                                            value="#000000" title="Choose color">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Image <span class="text-danger">*</span></label>
                                        <input type="file" class="form-control variation-image"
                                            name="product_image[]" accept="image/*" required>
                                    </div>
                                </div>
                            </div>
                            <div class="image-preview mt-2"></div>
                        </div>
                    </div>
                </div>
                `;
                $('#variation').append(html);
                $('#no-variations').hide();

                // Initialize the new file input
                initFilePreview($('#variation .variation-item:last-child .variation-image'));
            });

            // Remove variation
            $(document).on('click', '.remove-variation', function() {
                $(this).closest('.variation-item').remove();

                // Show the info message if no variations are left
                if ($('#variation').children('.variation-item').length === 0) {
                    $('#no-variations').show();
                }

                // Renumber the variations
                $('.variation-item').each(function(index) {
                    $(this).find('.card-header span').text('Variation ' + (index + 1));
                });
            });

            // Initialize file preview for existing file inputs
            function initFilePreview(fileInput) {
                fileInput.change(function() {
                    var file = this.files[0];
                    var preview = $(this).closest('.card-body').find('.image-preview');

                    if (file) {
                        var reader = new FileReader();

                        reader.onload = function(e) {
                            preview.html(`
                                <div class="text-center">
                                    <img src="${e.target.result}" class="img-thumbnail" style="max-height: 150px;">
                                </div>
                            `);
                        }

                        reader.readAsDataURL(file);
                    } else {
                        preview.empty();
                    }
                });
            }

            // Initialize all existing file inputs
            $('.variation-image').each(function() {
                initFilePreview($(this));
            });

            // Generate SKU if empty
            $('#name').on('blur', function() {
                if ($('#sku').val() === '') {
                    var name = $(this).val().trim();
                    if (name) {
                        // Create a simple SKU from the name
                        var sku = name.replace(/[^a-zA-Z0-9]/g, '-').substring(0, 10).toUpperCase();
                        sku += '-' + Math.floor(Math.random() * 10000);
                        $('#sku').val(sku);
                    }
                }
            });

            // Form validation
            $('#productForm').submit(function(e) {
                var variationCount = $('#variation').children('.variation-item').length;

                if (variationCount === 0) {
                    e.preventDefault();
                    alert('Please add at least one product variation with an image.');
                    return false;
                }

                return true;
            });
        });
    </script>
@endsection
