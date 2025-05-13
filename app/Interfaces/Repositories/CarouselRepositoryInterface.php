<?php

namespace App\Interfaces\Repositories;

use App\Models\Carousel;
use Illuminate\Database\Eloquent\Collection;

interface CarouselRepositoryInterface
{
    /**
     * Get all carousel items
     *
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * Get carousel item by ID
     *
     * @param mixed $id
     * @return Carousel|null
     */
    public function getById($id): ?Carousel;

    /**
     * Create a new carousel item
     *
     * @param array $data
     * @return Carousel
     */
    public function create(array $data): Carousel;

    /**
     * Update a carousel item
     *
     * @param mixed $id
     * @param array $data
     * @return bool
     */
    public function update($id, array $data): bool;

    /**
     * Delete a carousel item
     *
     * @param mixed $id
     * @return bool
     */
    public function delete($id): bool;

    /**
     * Get active carousel items
     *
     * @return Collection
     */
    public function getActive(): Collection;
}
