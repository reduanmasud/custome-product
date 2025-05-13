<?php

namespace App\Services;

use App\Interfaces\Repositories\CategoryRepositoryInterface;
use App\Interfaces\Services\CategoryServiceInterface;
use App\Interfaces\Services\FileUploadServiceInterface;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class CategoryService implements CategoryServiceInterface
{
    /**
     * @var FileUploadServiceInterface
     */
    protected $fileUploadService;

    /**
     * @var CategoryRepositoryInterface
     */
    protected $categoryRepository;

    /**
     * CategoryService constructor.
     *
     * @param FileUploadServiceInterface $fileUploadService
     * @param CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(
        FileUploadServiceInterface $fileUploadService,
        CategoryRepositoryInterface $categoryRepository
    ) {
        $this->fileUploadService = $fileUploadService;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Get all categories
     *
     * @return Collection
     */
    public function getAllCategories(): Collection
    {
        return $this->categoryRepository->getAll();
    }

    /**
     * Get category by ID
     *
     * @param mixed $id
     * @return Category|null
     */
    public function getCategoryById($id): ?Category
    {
        return $this->categoryRepository->getById($id);
    }

    /**
     * Create a new category
     *
     * @param Request $request
     * @return Category
     */
    public function createCategory(Request $request): Category
    {
        $data = [
            'name' => $request->name,
            'description' => $request->description,
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $this->fileUploadService->upload(
                $request->file('image'),
                'category_images'
            );
        }

        return $this->categoryRepository->create($data);
    }

    /**
     * Update a category
     *
     * @param mixed $id
     * @param Request $request
     * @return bool
     */
    public function updateCategory($id, Request $request): bool
    {
        $category = $this->categoryRepository->getById($id);

        if (!$category) {
            return false;
        }

        $data = [
            'name' => $request->name ?? $category->name,
            'description' => $request->description ?? $category->description,
        ];

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($category->image) {
                $this->fileUploadService->delete('category_images/' . $category->image);
            }

            $data['image'] = $this->fileUploadService->upload(
                $request->file('image'),
                'category_images'
            );
        }

        return $this->categoryRepository->update($id, $data);
    }

    /**
     * Delete a category
     *
     * @param mixed $id
     * @return bool
     */
    public function deleteCategory($id): bool
    {
        $category = $this->categoryRepository->getById($id);

        if (!$category) {
            return false;
        }

        // Check if category has products
        if ($this->categoryRepository->hasProducts($id)) {
            return false;
        }

        // Delete category image
        if ($category->image) {
            $this->fileUploadService->delete('category_images/' . $category->image);
        }

        return $this->categoryRepository->delete($id);
    }
}
