@props([
    'id' => '',
    'viewRoute' => '',
    'editRoute' => '',
    'deleteRoute' => '',
    'viewPermission' => '',
    'editPermission' => '',
    'deletePermission' => '',
    'deleteConfirmMessage' => 'Are you sure you want to delete this item?',
    'size' => 'btn-sm',
])

<div class="btn-group" role="group">
    @if($viewRoute && $viewPermission)
        @can($viewPermission)
        <a href="{{ $viewRoute }}" class="btn btn-info {{ $size }}" title="View">
            <i class="fas fa-eye"></i>
        </a>
        @endcan
    @endif
    
    @if($editRoute && $editPermission)
        @can($editPermission)
        <a href="{{ $editRoute }}" class="btn btn-primary {{ $size }}" title="Edit">
            <i class="fas fa-edit"></i>
        </a>
        @endcan
    @endif
    
    @if($deleteRoute && $deletePermission)
        @can($deletePermission)
        <form action="{{ $deleteRoute }}" method="POST" class="d-inline delete-form" data-confirm="{{ $deleteConfirmMessage }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger {{ $size }}" title="Delete">
                <i class="fas fa-trash"></i>
            </button>
        </form>
        @endcan
    @endif
</div>

@once
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteForms = document.querySelectorAll('.delete-form');
        
        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const confirmMessage = this.getAttribute('data-confirm');
                
                if (confirm(confirmMessage)) {
                    this.submit();
                }
            });
        });
    });
</script>
@endpush
@endonce
