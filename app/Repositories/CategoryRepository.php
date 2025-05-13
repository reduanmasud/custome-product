<?php

namespace App\Repositories;

use App\Interfaces\Repositories\CategoryRepositoryInterface;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoryRepository implements CategoryRepositoryInterface
{
    /**
     * Get all categories
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Category::all();
    }

    /**
     * Get paginated categories
     *
     * @param int $perPage
     * @param array $columns
     * @param array $options
     * @return LengthAwarePaginator
     */
    public function getPaginated(int $perPage = 15, array $columns = ['*'], array $options = []): LengthAwarePaginator
    {
        $query = Category::query();

        // Apply sorting if specified in options
        if (isset($options['sort_by']) && isset($options['sort_direction'])) {
            $query->orderBy($options['sort_by'], $options['sort_direction']);
        } else {
            // Default sorting by id descending (newest first)
            $query->orderBy('id', 'desc');
        }

        // Apply search filter if specified
        if (isset($options['search']) && !empty($options['search'])) {
            $searchTerm = $options['search'];
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }

        return $query->paginate($perPage, $columns, 'page', $options['page'] ?? null);
    }

    /**
     * Get category by ID
     *
     * @param mixed $id
     * @return Category|null
     */
    public function getById($id): ?Category
    {
        return Category::find($id);
    }

    /**
     * Create a new category
     *
     * @param array $data
     * @return Category
     */
    public function create(array $data): Category
    {
        return Category::create($data);
    }

    /**
     * Update a category
     *
     * @param mixed $id
     * @param array $data
     * @return bool
     */
    public function update($id, array $data): bool
    {
        $category = $this->getById($id);

        if (!$category) {
            return false;
        }

        return $category->update($data);
    }

    /**
     * Delete a category
     *
     * @param mixed $id
     * @return bool
     */
    public function delete($id): bool
    {
        $category = $this->getById($id);

        if (!$category) {
            return false;
        }

        return $category->delete();
    }

    /**
     * Get category with products
     *
     * @param mixed $id
     * @return Category|null
     */
    public function getWithProducts($id): ?Category
    {
        return Category::with('products')->find($id);
    }

    /**
     * Check if category has products
     *
     * @param mixed $id
     * @return bool
     */
    public function hasProducts($id): bool
    {
        $category = $this->getById($id);

        if (!$category) {
            return false;
        }

        return $category->products()->count() > 0;
    }
}
