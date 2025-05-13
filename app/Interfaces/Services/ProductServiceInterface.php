<?php

namespace App\Interfaces\Services;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

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
     * @param int $id
     * @return Product|null
     */
    public function getProductById(int $id): ?Product;

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
     * @param int $id
     * @param Request $request
     * @return bool
     */
    public function updateProduct(int $id, Request $request): bool;

    /**
     * Delete a product
     *
     * @param int $id
     * @return bool
     */
    public function deleteProduct(int $id): bool;

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
}
