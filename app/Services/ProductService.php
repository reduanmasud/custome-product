<?php

namespace App\Services;

use App\Interfaces\Services\FileUploadServiceInterface;
use App\Interfaces\Services\ProductServiceInterface;
use App\Models\Product;
use App\Models\ProductVariation;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductService implements ProductServiceInterface
{
    /**
     * @var FileUploadServiceInterface
     */
    protected $fileUploadService;

    /**
     * ProductService constructor.
     *
     * @param FileUploadServiceInterface $fileUploadService
     */
    public function __construct(FileUploadServiceInterface $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * Get all products
     *
     * @return Collection
     */
    public function getAllProducts(): Collection
    {
        return Product::all();
    }

    /**
     * Get product by ID
     *
     * @param int $id
     * @return Product|null
     */
    public function getProductById(int $id): ?Product
    {
        return Product::find($id);
    }

    /**
     * Create a new product
     *
     * @param Request $request
     * @return Product
     */
    public function createProduct(Request $request): Product
    {
        $fileName = $this->fileUploadService->upload(
            $request->file('product_mockup'),
            'product_upload'
        );

        return Product::create([
            'name' => $request->product_name,
            'description' => $request->product_description,
            'category_id' => $request->product_category,
            'price' => $request->product_price,
            'mockup' => $fileName,
        ]);
    }

    /**
     * Create a new product from admin panel
     *
     * @param Request $request
     * @return Product
     */
    public function createProductFromAdmin(Request $request): Product
    {
        $categoryId = $request->category_id ?? 1;

        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $categoryId,
            'available' => $request->available ?? 1,
        ]);

        if ($request->has('product_image')) {
            foreach ($request->product_image as $key => $image) {
                $imgUrl = $this->fileUploadService->upload($image, 'product_upload');
                
                $product->variations()->create([
                    'color' => $request->color[$key] ?? null,
                    'image_url' => $imgUrl,
                ]);
            }
        }

        return $product;
    }

    /**
     * Update a product
     *
     * @param int $id
     * @param Request $request
     * @return bool
     */
    public function updateProduct(int $id, Request $request): bool
    {
        $product = $this->getProductById($id);
        
        if (!$product) {
            return false;
        }

        $data = [
            'name' => $request->name ?? $product->name,
            'description' => $request->description ?? $product->description,
            'price' => $request->price ?? $product->price,
            'category_id' => $request->category_id ?? $product->category_id,
            'available' => $request->has('available') ? $request->available : $product->available,
        ];

        if ($request->hasFile('mockup')) {
            // Delete old mockup if exists
            if ($product->mockup) {
                $this->fileUploadService->delete('product_upload/' . $product->mockup);
            }
            
            $data['mockup'] = $this->fileUploadService->upload(
                $request->file('mockup'),
                'product_upload'
            );
        }

        return $product->update($data);
    }

    /**
     * Delete a product
     *
     * @param int $id
     * @return bool
     */
    public function deleteProduct(int $id): bool
    {
        $product = $this->getProductById($id);
        
        if (!$product) {
            return false;
        }

        // Delete product variations
        foreach ($product->variations as $variation) {
            if ($variation->image_url) {
                $this->fileUploadService->delete('product_upload/' . $variation->image_url);
            }
            $variation->delete();
        }

        // Delete product mockup
        if ($product->mockup) {
            $this->fileUploadService->delete('product_upload/' . $product->mockup);
        }

        return $product->delete();
    }

    /**
     * Handle file upload for product
     *
     * @param mixed $file
     * @param string $directory
     * @return string
     */
    public function handleFileUpload($file, string $directory = 'product_upload'): string
    {
        return $this->fileUploadService->upload($file, $directory);
    }

    /**
     * Handle base64 image upload
     *
     * @param string $base64String
     * @param string $extension
     * @return string
     */
    public function handleBase64Upload(string $base64String, string $extension = 'jpg'): string
    {
        return $this->fileUploadService->uploadBase64($base64String, 'product_upload', $extension);
    }
}
