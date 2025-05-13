@props([
    'user' => null,
    'size' => 'md',
])

@if($user)
    <div class="user-roles">
        @foreach($user->roles as $role)
            <x-admin.components.role-badge :role="$role->name" :size="$size" />
        @endforeach
    </div>
@endif
