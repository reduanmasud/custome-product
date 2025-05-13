<?php

namespace App\Repositories;

use App\Interfaces\Repositories\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository implements ProductRepositoryInterface
{
    /**
     * Get all products
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Product::all();
    }

    /**
     * Get product by ID
     *
     * @param mixed $id
     * @return Product|null
     */
    public function getById($id): ?Product
    {
        return Product::find($id);
    }

    /**
     * Create a new product
     *
     * @param array $data
     * @return Product
     */
    public function create(array $data): Product
    {
        return Product::create($data);
    }

    /**
     * Update a product
     *
     * @param mixed $id
     * @param array $data
     * @return bool
     */
    public function update($id, array $data): bool
    {
        $product = $this->getById($id);
        
        if (!$product) {
            return false;
        }
        
        return $product->update($data);
    }

    /**
     * Delete a product
     *
     * @param mixed $id
     * @return bool
     */
    public function delete($id): bool
    {
        $product = $this->getById($id);
        
        if (!$product) {
            return false;
        }
        
        return $product->delete();
    }

    /**
     * Get products by category ID
     *
     * @param mixed $categoryId
     * @return Collection
     */
    public function getByCategoryId($categoryId): Collection
    {
        return Product::where('category_id', $categoryId)->get();
    }

    /**
     * Search products by name or description
     *
     * @param string $query
     * @return Collection
     */
    public function search(string $query): Collection
    {
        return Product::where('name', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->get();
    }

    /**
     * Get product with variations
     *
     * @param mixed $id
     * @return Product|null
     */
    public function getWithVariations($id): ?Product
    {
        return Product::with('variations')->find($id);
    }

    /**
     * Add variation to product
     *
     * @param mixed $productId
     * @param array $variationData
     * @return mixed
     */
    public function addVariation($productId, array $variationData)
    {
        $product = $this->getById($productId);
        
        if (!$product) {
            return null;
        }
        
        return $product->variations()->create($variationData);
    }
}
