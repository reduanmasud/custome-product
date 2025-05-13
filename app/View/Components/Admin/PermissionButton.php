<?php

namespace App\View\Components\Admin;

use Illuminate\View\Component;

class PermissionButton extends Component
{
    /**
     * The permission required to see the button.
     *
     * @var string
     */
    public $permission;

    /**
     * The route for the button.
     *
     * @var string
     */
    public $route;

    /**
     * The icon for the button.
     *
     * @var string
     */
    public $icon;

    /**
     * The label for the button.
     *
     * @var string
     */
    public $label;

    /**
     * The CSS class for the button.
     *
     * @var string
     */
    public $class;

    /**
     * The size class for the button.
     *
     * @var string
     */
    public $size;

    /**
     * Create a new component instance.
     *
     * @param  string  $permission
     * @param  string  $route
     * @param  string  $icon
     * @param  string  $label
     * @param  string  $class
     * @param  string  $size
     * @return void
     */
    public function __construct($permission = '', $route = '', $icon = '', $label = '', $class = 'btn-primary', $size = 'btn-sm')
    {
        $this->permission = $permission;
        $this->route = $route;
        $this->icon = $icon;
        $this->label = $label;
        $this->class = $class;
        $this->size = $size;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.permission-button');
    }
}
