<?php

namespace App\Services;

use App\Interfaces\Repositories\ProductRepositoryInterface;
use App\Interfaces\Services\FileUploadServiceInterface;
use App\Interfaces\Services\ProductServiceInterface;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductService implements ProductServiceInterface
{
    /**
     * @var FileUploadServiceInterface
     */
    protected $fileUploadService;

    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * ProductService constructor.
     *
     * @param FileUploadServiceInterface $fileUploadService
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(
        FileUploadServiceInterface $fileUploadService,
        ProductRepositoryInterface $productRepository
    ) {
        $this->fileUploadService = $fileUploadService;
        $this->productRepository = $productRepository;
    }

    /**
     * Get all products
     *
     * @return Collection
     */
    public function getAllProducts(): Collection
    {
        return $this->productRepository->getAll();
    }

    /**
     * Get product by ID
     *
     * @param mixed $id
     * @return Product|null
     */
    public function getProductById($id): ?Product
    {
        return $this->productRepository->getById($id);
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

        return $this->productRepository->create([
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

        $product = $this->productRepository->create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $categoryId,
            'available' => $request->available ?? 1,
            'sku' => $request->sku,
            'inventory' => $request->inventory,
        ]);

        if ($request->has('product_image')) {
            foreach ($request->product_image as $key => $image) {
                $imgUrl = $this->fileUploadService->upload($image, 'product_upload');

                $this->productRepository->addVariation($product->id, [
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
     * @param mixed $id
     * @param Request $request
     * @return bool
     */
    public function updateProduct($id, Request $request): bool
    {
        $product = $this->productRepository->getWithVariations($id);

        if (!$product) {
            return false;
        }

        $data = [
            'name' => $request->name ?? $product->name,
            'description' => $request->description ?? $product->description,
            'price' => $request->price ?? $product->price,
            'category_id' => $request->category_id ?? $product->category_id,
            'available' => $request->has('available') ? $request->available : $product->available,
            'sku' => $request->sku ?? $product->sku,
            'inventory' => $request->inventory ?? $product->inventory,
        ];

        if ($request->hasFile('mockup')) {
            // Delete old mockup if exists
            if ($product->mockup) {
                $this->fileUploadService->delete("product_upload/{$product->mockup}");
            }

            $data['mockup'] = $this->fileUploadService->upload(
                $request->file('mockup'),
                'product_upload'
            );
        }

        // Handle existing variations
        if ($request->has('existing_color')) {
            foreach ($request->existing_color as $variationId => $color) {
                $variation = $product->variations->find($variationId);

                if ($variation) {
                    $variationData = ['color' => $color];

                    // Check if there's a new image for this variation
                    if ($request->hasFile("existing_image.$variationId")) {
                        // Delete old image if exists
                        if ($variation->image_url) {
                            $this->fileUploadService->delete("product_upload/{$variation->image_url}");
                        }

                        // Upload new image
                        $variationData['image_url'] = $this->fileUploadService->upload(
                            $request->file("existing_image.$variationId"),
                            'product_upload'
                        );
                    }

                    // Update the variation
                    $variation->update($variationData);
                }
            }
        }

        // Handle variation deletion
        if ($request->has('delete_variations')) {
            foreach ($request->delete_variations as $variationId) {
                $variation = $product->variations->find($variationId);

                if ($variation) {
                    // Delete image file
                    if ($variation->image_url) {
                        $this->fileUploadService->delete("product_upload/{$variation->image_url}");
                    }

                    // Delete variation record
                    $variation->delete();
                }
            }
        }

        // Handle new product variations if any
        if ($request->has('product_image')) {
            foreach ($request->product_image as $key => $image) {
                $imgUrl = $this->fileUploadService->upload($image, 'product_upload');

                $this->productRepository->addVariation($product->id, [
                    'color' => $request->color[$key] ?? null,
                    'image_url' => $imgUrl,
                ]);
            }
        }

        return $this->productRepository->update($id, $data);
    }

    /**
     * Delete a product
     *
     * @param mixed $id
     * @return bool
     */
    public function deleteProduct($id): bool
    {
        $product = $this->productRepository->getWithVariations($id);

        if (!$product) {
            return false;
        }

        // Delete product variations
        foreach ($product->variations as $variation) {
            if ($variation->image_url) {
                $this->fileUploadService->delete("product_upload/{$variation->image_url}");
            }
            $variation->delete();
        }

        // Delete product mockup
        if ($product->mockup) {
            $this->fileUploadService->delete("product_upload/{$product->mockup}");
        }

        return $this->productRepository->delete($id);
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

    /**
     * Get paginated products
     *
     * @param int $perPage
     * @param int $page
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getPaginatedProducts(int $perPage = 15, int $page = 1, array $filters = []): LengthAwarePaginator
    {
        return $this->productRepository->getPaginated($perPage, $page, $filters);
    }
}
