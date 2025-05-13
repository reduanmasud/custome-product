<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\Services\CarouselServiceInterface;
use Illuminate\Http\Request;

class CarouselController extends Controller
{
    /**
     * @var CarouselServiceInterface
     */
    protected $carouselService;

    /**
     * CarouselController constructor.
     *
     * @param CarouselServiceInterface $carouselService
     */
    public function __construct(CarouselServiceInterface $carouselService)
    {
        $this->carouselService = $carouselService;
    }

    /**
     * Display a listing of the carousel items.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $carousels = $this->carouselService->getAllCarousels();
        return view('admin.carousel', ['carousels' => $carousels]);
    }

    /**
     * Store a newly created or update an existing carousel item in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'button_text' => 'nullable|string|max:50',
            'button_link' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $this->carouselService->createOrUpdateCarousel($request);

        return back()->with('success', 'Carousel item successfully saved');
    }

    /**
     * Remove the specified carousel item from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $this->carouselService->deleteCarousel($id);
        
        return redirect()->route('admin.carousel')->with('success', 'Carousel item successfully deleted');
    }
}
