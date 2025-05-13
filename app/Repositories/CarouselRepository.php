<?php

namespace App\Repositories;

use App\Interfaces\Repositories\CarouselRepositoryInterface;
use App\Models\Carousel;
use Illuminate\Database\Eloquent\Collection;

class CarouselRepository implements CarouselRepositoryInterface
{
    /**
     * Get all carousel items
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Carousel::all();
    }

    /**
     * Get carousel item by ID
     *
     * @param mixed $id
     * @return Carousel|null
     */
    public function getById($id): ?Carousel
    {
        return Carousel::find($id);
    }

    /**
     * Create a new carousel item
     *
     * @param array $data
     * @return Carousel
     */
    public function create(array $data): Carousel
    {
        return Carousel::create($data);
    }

    /**
     * Update a carousel item
     *
     * @param mixed $id
     * @param array $data
     * @return bool
     */
    public function update($id, array $data): bool
    {
        $carousel = $this->getById($id);
        
        if (!$carousel) {
            return false;
        }
        
        return $carousel->update($data);
    }

    /**
     * Delete a carousel item
     *
     * @param mixed $id
     * @return bool
     */
    public function delete($id): bool
    {
        $carousel = $this->getById($id);
        
        if (!$carousel) {
            return false;
        }
        
        return $carousel->delete();
    }

    /**
     * Get active carousel items
     *
     * @return Collection
     */
    public function getActive(): Collection
    {
        return Carousel::where('active', true)->orderBy('order')->get();
    }
}
