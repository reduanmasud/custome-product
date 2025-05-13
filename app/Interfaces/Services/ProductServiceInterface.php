<?php

namespace App\Interfaces\Services;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductServiceInterface
{
    /**
     * Get all products
     *
     * @return Collection
     */
    public function getAllProducts(): Collection;

    /**
     * Get product by ID
     *
     * @param mixed $id
     * @return Product|null
     */
    public function getProductById($id): ?Product;

    /**
     * Create a new product
     *
     * @param Request $request
     * @return Product
     */
    public function createProduct(Request $request): Product;

    /**
     * Create a new product from admin panel
     *
     * @param Request $request
     * @return Product
     */
    public function createProductFromAdmin(Request $request): Product;

    /**
     * Update a product
     *
     * @param mixed $id
     * @param Request $request
     * @return bool
     */
    public function updateProduct($id, Request $request): bool;

    /**
     * Delete a product
     *
     * @param mixed $id
     * @return bool
     */
    public function deleteProduct($id): bool;

    /**
     * Handle file upload for product
     *
     * @param mixed $file
     * @param string $directory
     * @return string
     */
    public function handleFileUpload($file, string $directory = 'product_upload'): string;

    /**
     * Handle base64 image upload
     *
     * @param string $base64String
     * @param string $extension
     * @return string
     */
    public function handleBase64Upload(string $base64String, string $extension = 'jpg'): string;

    /**
     * Get paginated products
     *
     * @param int $perPage
     * @param int $page
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getPaginatedProducts(int $perPage = 15, int $page = 1, array $filters = []): LengthAwarePaginator;
}
