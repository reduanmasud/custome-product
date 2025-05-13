<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\Services\CategoryServiceInterface;
use App\Interfaces\Services\ProductServiceInterface;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * @var ProductServiceInterface
     */
    protected $productService;

    /**
     * @var CategoryServiceInterface
     */
    protected $categoryService;

    /**
     * ProductController constructor.
     *
     * @param ProductServiceInterface $productService
     * @param CategoryServiceInterface $categoryService
     */
    public function __construct(
        ProductServiceInterface $productService,
        CategoryServiceInterface $categoryService
    ) {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the products.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 15);
        $page = $request->input('page', 1);

        // Build filters array from request
        $filters = [];

        if ($request->filled('search')) {
            $filters['search'] = $request->input('search');
        }

        if ($request->filled('category_id')) {
            $filters['category_id'] = $request->input('category_id');
        }

        if ($request->filled('price_min')) {
            $filters['price_min'] = $request->input('price_min');
        }

        if ($request->filled('price_max')) {
            $filters['price_max'] = $request->input('price_max');
        }

        if ($request->has('available')) {
            $filters['available'] = $request->input('available');
        }

        $products = $this->productService->getPaginatedProducts($perPage, $page, $filters);
        $categories = $this->categoryService->getAllCategories();

        return view('admin.product.index', [
            'products' => $products,
            'categories' => $categories,
            'filters' => $filters,
            'perPage' => $perPage
        ]);
    }

    /**
     * Show the form for creating a new product.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $categories = $this->categoryService->getAllCategories();
        return view('admin.product.add-product', ['categories' => $categories]);
    }

    /**
     * Store a newly created product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'product_image.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'color.*' => 'nullable|string|max:50',
        ]);

        $this->productService->createProductFromAdmin($request);

        return back()->with('success', 'Product successfully added');
    }

    /**
     * Display the specified product.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $product = $this->productService->getProductById($id);

        if (!$product) {
            abort(404);
        }

        return view('admin.product.show', ['product' => $product]);
    }

    /**
     * Show the form for editing the specified product.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $product = $this->productService->getProductById($id);

        if (!$product) {
            abort(404);
        }

        $categories = $this->categoryService->getAllCategories();

        return view('admin.product.edit', [
            'product' => $product,
            'categories' => $categories
        ]);
    }

    /**
     * Update the specified product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'available' => 'nullable|boolean',
            'product_image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'color.*' => 'nullable|string|max:50',
        ]);

        $this->productService->updateProduct($id, $request);

        return redirect()->route('admin.product.index')->with('success', 'Product successfully updated');
    }

    /**
     * Remove the specified product from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $this->productService->deleteProduct($id);

        return redirect()->route('admin.product.index')->with('success', 'Product successfully deleted');
    }

    /**
     * Display a listing of the categories.
     *
     * @return \Illuminate\View\View
     */
    public function categories()
    {
        $categories = $this->categoryService->getAllCategories();
        return view('admin.product.category', ['categories' => $categories]);
    }
}
