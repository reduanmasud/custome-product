<?php

namespace App\Interfaces\Repositories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductRepositoryInterface
{
    /**
     * Get all products
     *
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * Get product by ID
     *
     * @param mixed $id
     * @return Product|null
     */
    public function getById($id): ?Product;

    /**
     * Create a new product
     *
     * @param array $data
     * @return Product
     */
    public function create(array $data): Product;

    /**
     * Update a product
     *
     * @param mixed $id
     * @param array $data
     * @return bool
     */
    public function update($id, array $data): bool;

    /**
     * Delete a product
     *
     * @param mixed $id
     * @return bool
     */
    public function delete($id): bool;

    /**
     * Get products by category ID
     *
     * @param mixed $categoryId
     * @return Collection
     */
    public function getByCategoryId($categoryId): Collection;

    /**
     * Search products by name or description
     *
     * @param string $query
     * @return Collection
     */
    public function search(string $query): Collection;

    /**
     * Get product with variations
     *
     * @param mixed $id
     * @return Product|null
     */
    public function getWithVariations($id): ?Product;

    /**
     * Add variation to product
     *
     * @param mixed $productId
     * @param array $variationData
     * @return mixed
     */
    public function addVariation($productId, array $variationData);

    /**
     * Get paginated products
     *
     * @param int $perPage
     * @param int $page
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getPaginated(int $perPage = 15, int $page = 1, array $filters = []): LengthAwarePaginator;
}
