<?php

namespace App\View\Components\Admin;

use Illuminate\View\Component;

class ActionButtons extends Component
{
    /**
     * The ID of the item.
     *
     * @var string
     */
    public $id;

    /**
     * The view route.
     *
     * @var string
     */
    public $viewRoute;

    /**
     * The edit route.
     *
     * @var string
     */
    public $editRoute;

    /**
     * The delete route.
     *
     * @var string
     */
    public $deleteRoute;

    /**
     * The permission required to view.
     *
     * @var string
     */
    public $viewPermission;

    /**
     * The permission required to edit.
     *
     * @var string
     */
    public $editPermission;

    /**
     * The permission required to delete.
     *
     * @var string
     */
    public $deletePermission;

    /**
     * The confirmation message for delete.
     *
     * @var string
     */
    public $deleteConfirmMessage;

    /**
     * The size of the buttons.
     *
     * @var string
     */
    public $size;

    /**
     * Create a new component instance.
     *
     * @param  string  $id
     * @param  string  $viewRoute
     * @param  string  $editRoute
     * @param  string  $deleteRoute
     * @param  string  $viewPermission
     * @param  string  $editPermission
     * @param  string  $deletePermission
     * @param  string  $deleteConfirmMessage
     * @param  string  $size
     * @return void
     */
    public function __construct(
        $id = '',
        $viewRoute = '',
        $editRoute = '',
        $deleteRoute = '',
        $viewPermission = '',
        $editPermission = '',
        $deletePermission = '',
        $deleteConfirmMessage = 'Are you sure you want to delete this item?',
        $size = 'btn-sm'
    ) {
        $this->id = $id;
        $this->viewRoute = $viewRoute;
        $this->editRoute = $editRoute;
        $this->deleteRoute = $deleteRoute;
        $this->viewPermission = $viewPermission;
        $this->editPermission = $editPermission;
        $this->deletePermission = $deletePermission;
        $this->deleteConfirmMessage = $deleteConfirmMessage;
        $this->size = $size;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.action-buttons');
    }
}
