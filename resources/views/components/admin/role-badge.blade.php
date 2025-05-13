@php
    $roleColors = [
        'super-admin' => 'danger',
        'admin' => 'primary',
        'manager' => 'success',
        'user' => 'secondary',
        'default' => 'info'
    ];
    
    $color = $roleColors[$role] ?? $roleColors['default'];
    $sizeClass = $size === 'sm' ? 'badge-sm' : '';
@endphp

<span class="badge bg-{{ $color }} {{ $sizeClass }}">
    {{ ucfirst($role) }}
</span>
