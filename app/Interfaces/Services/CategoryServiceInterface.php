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
}
