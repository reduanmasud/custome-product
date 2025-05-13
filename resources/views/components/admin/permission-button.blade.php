@can($permission)
<a href="{{ $route }}" class="btn {{ $class }} {{ $size }}">
    @if($icon)
    <i class="fas fa-{{ $icon }} fa-sm {{ $class == 'btn-primary' ? 'text-white-50' : '' }} me-1"></i>
    @endif
    {{ $label }}
</a>
@endcan