<?php

namespace App\Services;

use App\Interfaces\Services\CarouselServiceInterface;
use App\Interfaces\Services\FileUploadServiceInterface;
use App\Models\Carousel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class CarouselService implements CarouselServiceInterface
{
    /**
     * @var FileUploadServiceInterface
     */
    protected $fileUploadService;

    /**
     * CarouselService constructor.
     *
     * @param FileUploadServiceInterface $fileUploadService
     */
    public function __construct(FileUploadServiceInterface $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * Get all carousel items
     *
     * @return Collection
     */
    public function getAllCarousels(): Collection
    {
        return Carousel::all();
    }

    /**
     * Get carousel by ID
     *
     * @param int $id
     * @return Carousel|null
     */
    public function getCarouselById(int $id): ?Carousel
    {
        return Carousel::find($id);
    }

    /**
     * Create or update a carousel item
     *
     * @param Request $request
     * @return Carousel
     */
    public function createOrUpdateCarousel(Request $request): Carousel
    {
        $carousel = Carousel::find($request->id);
        
        if (!$carousel) {
            $carousel = new Carousel();
        }

        $carousel->title = $request->title;
        $carousel->description = $request->description;
        $carousel->button_text = $request->button_text;
        $carousel->button_link = $request->button_link;
        
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($carousel->image) {
                $this->fileUploadService->delete('carousel/' . $carousel->image);
            }
            
            $carousel->image = $this->fileUploadService->upload(
                $request->file('image'),
                'carousel'
            );
        }

        $carousel->save();
        
        return $carousel;
    }

    /**
     * Delete a carousel item
     *
     * @param int $id
     * @return bool
     */
    public function deleteCarousel(int $id): bool
    {
        $carousel = $this->getCarouselById($id);
        
        if (!$carousel) {
            return false;
        }

        // Delete carousel image
        if ($carousel->image) {
            $this->fileUploadService->delete('carousel/' . $carousel->image);
        }

        return $carousel->delete();
    }

    /**
     * Handle file upload for carousel
     *
     * @param mixed $file
     * @param string $directory
     * @return string
     */
    public function handleFileUpload($file, string $directory = 'carousel'): string
    {
        return $this->fileUploadService->upload($file, $directory);
    }
}
