<?php

namespace App\Interfaces\Services;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

interface CategoryServiceInterface
{
    /**
     * Get all categories
     *
     * @return Collection
     */
    public function getAllCategories(): Collection;

    /**
     * Get paginated categories
     *
     * @param int $perPage
     * @param array $options
     * @return LengthAwarePaginator
     */
    public function getPaginatedCategories(int $perPage = 15, array $options = []): LengthAwarePaginator;

    /**
     * Get category by ID
     *
     * @param mixed $id
     * @return Category|null
     */
    public function getCategoryById($id): ?Category;

    /**
     * Get category with its products
     *
     * @param mixed $id
     * @return Category|null
     */
    public function getCategoryWithProducts($id): ?Category;

    /**
     * Create a new category
     *
     * @param Request $request
     * @return Category
     */
    public function createCategory(Request $request): Category;

    /**
     * Update a category
     *
     * @param mixed $id
     * @param Request $request
     * @return bool
     */
    public function updateCategory($id, Request $request): bool;

    /**
     * Delete a category
     *
     * @param mixed $id
     * @return bool
     */
    public function deleteCategory($id): bool;

    /**
     * Check if a category has products
     *
     * @param mixed $id
     * @return bool
     */
    public function categoryHasProducts($id): bool;

    /**
     * Delete a category and all its products
     *
     * @param mixed $id
     * @return bool
     */
    public function deleteCategoryWithProducts($id): bool;

    /**
     * Reassign products to another category and delete the original category
     *
     * @param mixed $id
     * @param mixed $newCategoryId
     * @return bool
     */
    public function reassignProductsAndDeleteCategory($id, $newCategoryId): bool;
}
