@if($user)
    <div class="user-roles">
        @foreach($user->roles as $role)
            <x-admin.role-badge :role="$role->name" :size="$size" />
        @endforeach
    </div>
@endif
