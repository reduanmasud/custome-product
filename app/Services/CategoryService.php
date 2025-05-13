<?php

namespace App\Services;

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
     * CategoryService constructor.
     *
     * @param FileUploadServiceInterface $fileUploadService
     */
    public function __construct(FileUploadServiceInterface $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * Get all categories
     *
     * @return Collection
     */
    public function getAllCategories(): Collection
    {
        return Category::all();
    }

    /**
     * Get category by ID
     *
     * @param int $id
     * @return Category|null
     */
    public function getCategoryById(int $id): ?Category
    {
        return Category::find($id);
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

        return Category::create($data);
    }

    /**
     * Update a category
     *
     * @param int $id
     * @param Request $request
     * @return bool
     */
    public function updateCategory(int $id, Request $request): bool
    {
        $category = $this->getCategoryById($id);
        
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

        return $category->update($data);
    }

    /**
     * Delete a category
     *
     * @param int $id
     * @return bool
     */
    public function deleteCategory(int $id): bool
    {
        $category = $this->getCategoryById($id);
        
        if (!$category) {
            return false;
        }

        // Check if category has products
        if ($category->products()->count() > 0) {
            return false;
        }

        // Delete category image
        if ($category->image) {
            $this->fileUploadService->delete('category_images/' . $category->image);
        }

        return $category->delete();
    }
}
