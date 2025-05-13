<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
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

        // Text search filters
        if ($request->filled('search')) {
            $filters['search'] = $request->input('search');
        }

        if ($request->filled('sku')) {
            $filters['sku'] = $request->input('sku');
        }

        // Category filter
        if ($request->filled('category_id')) {
            $filters['category_id'] = $request->input('category_id');
        }

        // Price range filters
        if ($request->filled('price_min')) {
            $filters['price_min'] = $request->input('price_min');
        }

        if ($request->filled('price_max')) {
            $filters['price_max'] = $request->input('price_max');
        }

        // Status filters
        if ($request->filled('available')) {
            $filters['available'] = $request->input('available');
        }

        if ($request->filled('inventory_status')) {
            $filters['inventory_status'] = $request->input('inventory_status');
        }

        // Sorting
        if ($request->filled('sort')) {
            $filters['sort'] = $request->input('sort');
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
     * @param  \App\Http\Requests\Admin\StoreProductRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreProductRequest $request)
    {
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
     * @param  \App\Http\Requests\Admin\UpdateProductRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateProductRequest $request, $id)
    {
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
        // Check if product exists
        $product = $this->productService->getProductById($id);

        if (!$product) {
            return redirect()->route('admin.product.index')->with('error', 'Product not found');
        }

        // Check if product has associated orders
        if ($product->orders()->count() > 0) {
            return redirect()->route('admin.product.index')->with('error', 'Cannot delete product with associated orders');
        }

        // Delete the product
        $result = $this->productService->deleteProduct($id);

        if (!$result) {
            return redirect()->route('admin.product.index')->with('error', 'Failed to delete product');
        }

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

    /**
     * Display the variations for a specific product.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function variations($id)
    {
        $product = $this->productService->getProductById($id);

        if (!$product) {
            abort(404);
        }

        return view('admin.product.variations', ['product' => $product]);
    }

    /**
     * Store a new variation for a product.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeVariation(Request $request, $id)
    {
        $request->validate([
            'color' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = $this->productService->getProductById($id);

        if (!$product) {
            return redirect()->route('admin.product.all')->with('error', 'Product not found');
        }

        $imgUrl = $this->productService->handleFileUpload($request->file('image'), 'product_upload');

        $this->productService->addVariation($id, [
            'color' => $request->color,
            'image_url' => $imgUrl,
        ]);

        return redirect()->route('admin.product.variations', $id)->with('success', 'Variation added successfully');
    }

    /**
     * Update multiple variations for a product.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateVariations(Request $request, $id)
    {
        $product = $this->productService->getProductById($id);

        if (!$product) {
            return redirect()->route('admin.product.all')->with('error', 'Product not found');
        }

        if ($request->has('colors')) {
            foreach ($request->colors as $variationId => $color) {
                $variation = $product->variations()->find($variationId);

                if ($variation) {
                    $variation->update(['color' => $color]);
                }
            }
        }

        return redirect()->route('admin.product.variations', $id)->with('success', 'Variations updated successfully');
    }

    /**
     * Update a single variation for a product.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateSingleVariation(Request $request, $id)
    {
        $request->validate([
            'variation_id' => 'required|exists:product_variations,id',
            'color' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = $this->productService->getProductById($id);

        if (!$product) {
            return redirect()->route('admin.product.all')->with('error', 'Product not found');
        }

        $variation = $product->variations()->find($request->variation_id);

        if (!$variation) {
            return redirect()->route('admin.product.variations', $id)->with('error', 'Variation not found');
        }

        $data = ['color' => $request->color];

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($variation->image_url) {
                $this->productService->deleteFile("product_upload/{$variation->image_url}");
            }

            // Upload new image
            $data['image_url'] = $this->productService->handleFileUpload($request->file('image'), 'product_upload');
        }

        $variation->update($data);

        return redirect()->route('admin.product.variations', $id)->with('success', 'Variation updated successfully');
    }

    /**
     * Delete a variation for a product.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteVariation(Request $request, $id)
    {
        $request->validate([
            'variation_id' => 'required|exists:product_variations,id',
        ]);

        $product = $this->productService->getProductById($id);

        if (!$product) {
            return redirect()->route('admin.product.all')->with('error', 'Product not found');
        }

        $variation = $product->variations()->find($request->variation_id);

        if (!$variation) {
            return redirect()->route('admin.product.variations', $id)->with('error', 'Variation not found');
        }

        // Delete image file
        if ($variation->image_url) {
            $this->productService->deleteFile("product_upload/{$variation->image_url}");
        }

        // Delete variation record
        $variation->delete();

        return redirect()->route('admin.product.variations', $id)->with('success', 'Variation deleted successfully');
    }

    /**
     * Reorder variations for a product.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function reorderVariations(Request $request, $id)
    {
        $request->validate([
            'positions' => 'required|array',
            'positions.*.id' => 'required|exists:product_variations,id',
            'positions.*.position' => 'required|integer|min:1',
        ]);

        $product = $this->productService->getProductById($id);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        foreach ($request->positions as $position) {
            $variation = $product->variations()->find($position['id']);

            if ($variation) {
                $variation->update(['position' => $position['position']]);
            }
        }

        return response()->json(['success' => true]);
    }
}
