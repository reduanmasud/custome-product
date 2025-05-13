<?php

namespace App\Interfaces\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface CategoryRepositoryInterface
{
    /**
     * Get all categories
     *
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * Get paginated categories
     *
     * @param int $perPage
     * @param array $columns
     * @param array $options
     * @return LengthAwarePaginator
     */
    public function getPaginated(int $perPage = 15, array $columns = ['*'], array $options = []): LengthAwarePaginator;

    /**
     * Get category by ID
     *
     * @param mixed $id
     * @return Category|null
     */
    public function getById($id): ?Category;

    /**
     * Get category with its products
     *
     * @param mixed $id
     * @return Category|null
     */
    public function getWithProducts($id): ?Category;

    /**
     * Create a new category
     *
     * @param array $data
     * @return Category
     */
    public function create(array $data): Category;

    /**
     * Update a category
     *
     * @param mixed $id
     * @param array $data
     * @return bool
     */
    public function update($id, array $data): bool;

    /**
     * Delete a category
     *
     * @param mixed $id
     * @return bool
     */
    public function delete($id): bool;

    /**
     * Check if category has products
     *
     * @param mixed $id
     * @return bool
     */
    public function hasProducts($id): bool;
}
