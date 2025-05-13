<?php

namespace App\View\Components\Admin;

use Illuminate\View\Component;

class RoleBadge extends Component
{
    /**
     * The role name.
     *
     * @var string
     */
    public $role;

    /**
     * The size of the badge.
     *
     * @var string
     */
    public $size;

    /**
     * Create a new component instance.
     *
     * @param  string  $role
     * @param  string  $size
     * @return void
     */
    public function __construct($role = '', $size = 'md')
    {
        $this->role = $role;
        $this->size = $size;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.role-badge');
    }
}
