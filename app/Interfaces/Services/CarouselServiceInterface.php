<?php

namespace App\Interfaces\Services;

use App\Models\Carousel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface CarouselServiceInterface
{
    /**
     * Get all carousel items
     *
     * @return Collection
     */
    public function getAllCarousels(): Collection;

    /**
     * Get carousel by ID
     *
     * @param mixed $id
     * @return Carousel|null
     */
    public function getCarouselById($id): ?Carousel;

    /**
     * Create or update a carousel item
     *
     * @param Request $request
     * @return Carousel
     */
    public function createOrUpdateCarousel(Request $request): Carousel;

    /**
     * Delete a carousel item
     *
     * @param mixed $id
     * @return bool
     */
    public function deleteCarousel($id): bool;

    /**
     * Handle file upload for carousel
     *
     * @param mixed $file
     * @param string $directory
     * @return string
     */
    public function handleFileUpload($file, string $directory = 'carousel'): string;
}
