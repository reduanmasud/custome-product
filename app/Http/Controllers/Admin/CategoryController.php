<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Interfaces\Services\CategoryServiceInterface;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * @var CategoryServiceInterface
     */
    protected $categoryService;

    /**
     * CategoryController constructor.
     *
     * @param CategoryServiceInterface $categoryService
     */
    public function __construct(CategoryServiceInterface $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the categories.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Get pagination parameters from request
        $perPage = $request->input('per_page', 10); // Default 10 items per page
        $search = $request->input('search');
        $sortBy = $request->input('sort_by', 'id');
        $sortDirection = $request->input('sort_direction', 'desc');

        // Prepare options for pagination
        $options = [
            'search' => $search,
            'sort_by' => $sortBy,
            'sort_direction' => $sortDirection,
        ];

        // Get paginated categories
        $categories = $this->categoryService->getPaginatedCategories($perPage, $options);

        return view('admin.product.category', [
            'categories' => $categories,
            'search' => $search,
            'perPage' => $perPage,
            'sortBy' => $sortBy,
            'sortDirection' => $sortDirection
        ]);
    }

    /**
     * Store a newly created category in storage.
     *
     * @param  \App\Http\Requests\Admin\StoreCategoryRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreCategoryRequest $request)
    {
        $category = $this->categoryService->createCategory($request);

        if (!$category) {
            return back()->with('error', 'Failed to create category. Please try again.');
        }

        return back()->with('success', 'Category successfully added');
    }

    /**
     * Display the specified category.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        // Get category with its products
        $category = $this->categoryService->getCategoryWithProducts($id);

        if (!$category) {
            abort(404);
        }

        return view('admin.product.category-show', ['category' => $category]);
    }

    /**
     * Show the form for editing the specified category.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $category = $this->categoryService->getCategoryById($id);

        if (!$category) {
            abort(404);
        }

        return view('admin.product.category-edit', ['category' => $category]);
    }

    /**
     * Update the specified category in storage.
     *
     * @param  \App\Http\Requests\Admin\UpdateCategoryRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateCategoryRequest $request, $id)
    {
        $result = $this->categoryService->updateCategory($id, $request);

        if (!$result) {
            return back()->with('error', 'Failed to update category. Please try again.');
        }

        return redirect()->route('admin.product.category.index')->with('success', 'Category successfully updated');
    }

    /**
     * Remove the specified category from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $result = $this->categoryService->deleteCategory($id);

        if (!$result) {
            return back()->with('error', 'Cannot delete category with associated products');
        }

        return redirect()->route('admin.product.category.index')->with('success', 'Category successfully deleted');
    }
}
