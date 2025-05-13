<?php

namespace App\View\Components\Admin;

use Illuminate\View\Component;
use App\Models\User;

class UserRoles extends Component
{
    /**
     * The user instance.
     *
     * @var \App\Models\User
     */
    public $user;

    /**
     * The size of the badges.
     *
     * @var string
     */
    public $size;

    /**
     * Create a new component instance.
     *
     * @param  \App\Models\User|null  $user
     * @param  string  $size
     * @return void
     */
    public function __construct($user = null, $size = 'md')
    {
        $this->user = $user;
        $this->size = $size;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.user-roles');
    }
}
