<?php

namespace App\Repositories;

use App\Interfaces\Repositories\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

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

    /**
     * Get paginated products
     *
     * @param int $perPage
     * @param int $page
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getPaginated(int $perPage = 15, int $page = 1, array $filters = []): LengthAwarePaginator
    {
        $query = Product::with(['category', 'variations']);

        // Apply filters if any
        if (!empty($filters)) {
            // Search by name or description
            if (isset($filters['search']) && !empty($filters['search'])) {
                $search = $filters['search'];
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                });
            }

            // Search by SKU
            if (isset($filters['sku']) && !empty($filters['sku'])) {
                $query->where('sku', 'like', "%{$filters['sku']}%");
            }

            // Filter by category
            if (isset($filters['category_id']) && !empty($filters['category_id'])) {
                $query->where('category_id', $filters['category_id']);
            }

            // Filter by price range
            if (isset($filters['price_min']) && is_numeric($filters['price_min'])) {
                $query->where('price', '>=', $filters['price_min']);
            }

            if (isset($filters['price_max']) && is_numeric($filters['price_max'])) {
                $query->where('price', '<=', $filters['price_max']);
            }

            // Filter by availability
            if (isset($filters['available']) && in_array($filters['available'], ['0', '1'])) {
                $query->where('available', $filters['available']);
            }

            // Filter by inventory status
            if (isset($filters['inventory_status']) && !empty($filters['inventory_status'])) {
                switch ($filters['inventory_status']) {
                    case 'in_stock':
                        $query->where('inventory', '>', 0);
                        break;
                    case 'out_of_stock':
                        $query->where('inventory', '=', 0);
                        break;
                    case 'low_stock':
                        $query->where('inventory', '>', 0)
                              ->where('inventory', '<=', 5);
                        break;
                }
            }

            // Apply sorting
            if (isset($filters['sort']) && !empty($filters['sort'])) {
                switch ($filters['sort']) {
                    case 'name_asc':
                        $query->orderBy('name', 'asc');
                        break;
                    case 'name_desc':
                        $query->orderBy('name', 'desc');
                        break;
                    case 'price_asc':
                        $query->orderBy('price', 'asc');
                        break;
                    case 'price_desc':
                        $query->orderBy('price', 'desc');
                        break;
                    case 'newest':
                        $query->orderBy('created_at', 'desc');
                        break;
                    case 'oldest':
                        $query->orderBy('created_at', 'asc');
                        break;
                }
            } else {
                // Default sorting
                $query->orderBy('id', 'desc');
            }
        } else {
            // Default sorting if no filters
            $query->orderBy('id', 'desc');
        }

        return $query->paginate($perPage, ['*'], 'page', $page);
    }
}
