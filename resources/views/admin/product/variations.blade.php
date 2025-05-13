@extends('layouts.admin')
@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Manage Variations: {{ $product->name }}</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="{{ route('admin.product.edit', $product->id) }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-edit"></i> Edit Product
                </a>
                <a href="{{ route('admin.product.show', $product->id) }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-eye"></i> View Product
                </a>
                <a href="{{ route('admin.product.all') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Products
                </a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle me-1"></i>
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-circle me-1"></i>
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-info-circle me-1"></i>
            Product Information
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>SKU:</strong> {{ $product->sku ?? 'Not set' }}</p>
                    <p><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
                    <p><strong>Category:</strong> {{ $product->category->name }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Inventory:</strong> {{ $product->inventory ?? 'Not set' }}</p>
                    <p><strong>Status:</strong> 
                        @if($product->available)
                            <span class="badge bg-success">Available</span>
                        @else
                            <span class="badge bg-danger">Unavailable</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-images me-1"></i>
                Current Variations ({{ $product->variations->count() }})
            </div>
            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addVariationModal">
                <i class="fas fa-plus"></i> Add New Variation
            </button>
        </div>
        <div class="card-body">
            @if($product->variations->isEmpty())
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> No variations found for this product.
                </div>
            @else
                <form action="{{ route('admin.product.variations.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Color</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="variations-table">
                                @foreach($product->variations as $index => $variation)
                                    <tr data-id="{{ $variation->id }}">
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            @if($variation->image_url)
                                                <img src="{{ asset('product_upload/' . $variation->image_url) }}" 
                                                    alt="Variation {{ $index + 1 }}" 
                                                    class="img-thumbnail" style="max-height: 80px;">
                                            @else
                                                <span class="text-muted">No image</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <input type="color" name="colors[{{ $variation->id }}]" 
                                                    class="form-control form-control-color me-2" 
                                                    value="{{ $variation->color ?? '#000000' }}" title="Choose color">
                                                <span>{{ $variation->color ?? 'No color' }}</span>
                                            </div>
                                        </td>
                                        <td>{{ $variation->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-sm btn-primary variation-edit" 
                                                    data-bs-toggle="modal" data-bs-target="#editVariationModal" 
                                                    data-id="{{ $variation->id }}"
                                                    data-color="{{ $variation->color ?? '#000000' }}"
                                                    data-image="{{ $variation->image_url ? asset('product_upload/' . $variation->image_url) : '' }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-danger variation-delete" 
                                                    data-bs-toggle="modal" data-bs-target="#deleteVariationModal" 
                                                    data-id="{{ $variation->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Changes
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>

    <!-- Add Variation Modal -->
    <div class="modal fade" id="addVariationModal" tabindex="-1" aria-labelledby="addVariationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.product.variations.store', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addVariationModalLabel">Add New Variation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="color" class="form-label">Color</label>
                            <input type="color" class="form-control form-control-color w-100" id="color" name="color" value="#000000">
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Image <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                        </div>
                        <div id="imagePreview" class="mt-2 text-center"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Variation</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Variation Modal -->
    <div class="modal fade" id="editVariationModal" tabindex="-1" aria-labelledby="editVariationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.product.variations.update-single', $product->id) }}" method="POST" enctype="multipart/form-data" id="editVariationForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="variation_id" id="edit_variation_id">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editVariationModalLabel">Edit Variation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_color" class="form-label">Color</label>
                            <input type="color" class="form-control form-control-color w-100" id="edit_color" name="color" value="#000000">
                        </div>
                        <div class="mb-3">
                            <label for="edit_image" class="form-label">Replace Image</label>
                            <input type="file" class="form-control" id="edit_image" name="image" accept="image/*">
                            <small class="text-muted">Leave empty to keep current image</small>
                        </div>
                        <div id="editImagePreview" class="mt-2 text-center">
                            <img id="currentImage" src="" alt="Current Image" class="img-thumbnail" style="max-height: 150px; display: none;">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Variation</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Variation Modal -->
    <div class="modal fade" id="deleteVariationModal" tabindex="-1" aria-labelledby="deleteVariationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.product.variations.delete', $product->id) }}" method="POST" id="deleteVariationForm">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="variation_id" id="delete_variation_id">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="deleteVariationModalLabel">Confirm Delete</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this variation?</p>
                        <p class="text-danger"><i class="fas fa-exclamation-triangle"></i> This action cannot be undone.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete Variation</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Image preview for add variation
            $('#image').change(function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#imagePreview').html(`<img src="${e.target.result}" class="img-thumbnail" style="max-height: 150px;">`);
                    }
                    reader.readAsDataURL(file);
                }
            });
            
            // Image preview for edit variation
            $('#edit_image').change(function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#currentImage').attr('src', e.target.result).show();
                    }
                    reader.readAsDataURL(file);
                }
            });
            
            // Set up edit variation modal
            $('.variation-edit').click(function() {
                const id = $(this).data('id');
                const color = $(this).data('color');
                const image = $(this).data('image');
                
                $('#edit_variation_id').val(id);
                $('#edit_color').val(color);
                
                if (image) {
                    $('#currentImage').attr('src', image).show();
                } else {
                    $('#currentImage').hide();
                }
            });
            
            // Set up delete variation modal
            $('.variation-delete').click(function() {
                const id = $(this).data('id');
                $('#delete_variation_id').val(id);
            });
            
            // Make variations sortable
            $('#variations-table').sortable({
                items: 'tr',
                cursor: 'move',
                axis: 'y',
                update: function() {
                    let positions = [];
                    $('#variations-table tr').each(function(index) {
                        positions.push({
                            id: $(this).data('id'),
                            position: index + 1
                        });
                    });
                    
                    // Update row numbers
                    $('#variations-table tr').each(function(index) {
                        $(this).find('td:first').text(index + 1);
                    });
                    
                    // Send positions to server
                    $.ajax({
                        url: '{{ route("admin.product.variations.reorder", $product->id) }}',
                        method: 'POST',
                        data: {
                            positions: positions,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            console.log('Variations reordered successfully');
                        }
                    });
                }
            });
        });
    </script>
@endsection
