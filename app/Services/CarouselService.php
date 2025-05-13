<?php

namespace App\Services;

use App\Interfaces\Repositories\CarouselRepositoryInterface;
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
     * @var CarouselRepositoryInterface
     */
    protected $carouselRepository;

    /**
     * CarouselService constructor.
     *
     * @param FileUploadServiceInterface $fileUploadService
     * @param CarouselRepositoryInterface $carouselRepository
     */
    public function __construct(
        FileUploadServiceInterface $fileUploadService,
        CarouselRepositoryInterface $carouselRepository
    ) {
        $this->fileUploadService = $fileUploadService;
        $this->carouselRepository = $carouselRepository;
    }

    /**
     * Get all carousel items
     *
     * @return Collection
     */
    public function getAllCarousels(): Collection
    {
        return $this->carouselRepository->getAll();
    }

    /**
     * Get carousel by ID
     *
     * @param mixed $id
     * @return Carousel|null
     */
    public function getCarouselById($id): ?Carousel
    {
        return $this->carouselRepository->getById($id);
    }

    /**
     * Create or update a carousel item
     *
     * @param Request $request
     * @return Carousel
     */
    public function createOrUpdateCarousel(Request $request): Carousel
    {
        $carousel = null;
        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'button_text' => $request->button_text,
            'button_link' => $request->button_link,
        ];

        if ($request->id) {
            $carousel = $this->carouselRepository->getById($request->id);
        }

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($carousel && $carousel->image) {
                $this->fileUploadService->delete('carousel/' . $carousel->image);
            }

            $data['image'] = $this->fileUploadService->upload(
                $request->file('image'),
                'carousel'
            );
        }

        if ($carousel) {
            $this->carouselRepository->update($carousel->id, $data);
            return $this->carouselRepository->getById($carousel->id);
        } else {
            return $this->carouselRepository->create($data);
        }
    }

    /**
     * Delete a carousel item
     *
     * @param mixed $id
     * @return bool
     */
    public function deleteCarousel($id): bool
    {
        $carousel = $this->carouselRepository->getById($id);

        if (!$carousel) {
            return false;
        }

        // Delete carousel image
        if ($carousel->image) {
            $this->fileUploadService->delete('carousel/' . $carousel->image);
        }

        return $this->carouselRepository->delete($id);
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
