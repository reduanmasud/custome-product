<?php

namespace App\Http\Controllers;

use App\Models\Carousel;
use Illuminate\Http\Request;

class CarouselController extends Controller
{

    public function index()
    {
        $carousel = Carousel::all();
        return view('admin.carousel',['carousels' => $carousel]);
    }


    public function store(Request $request)
    {

        for ($i=1; $i < 4; $i++) {
            if($request->link[$i])
            {
                $carousel = Carousel::find($i);
                if($carousel) {
                    $carousel->link = $request->link[$i];
                    if($request->image[$i] == null)
                    {
                        $image = null;
                    }
                    else
                    {
                        $files = $request->file();
                        $image = time().'.'.$files['image'][$i]->extension();
                        $files['image'][$i]->move(public_path('carousel'), $image);
                    }
                    $carousel->image_url = $image;
                    $carousel->save();
                }
                else
                {
                    if($request->image[$i] == null)
                    {
                        $image = null;
                    }
                    else
                    {
                        $files = $request->file();
                        $image = time().'.'.$files['image'][$i]->extension();
                        $files['image'][$i]->move(public_path('carousel'), $image);
                    }

                    Carousel::create([
                        'link' => $request->link[$i],
                        'image_url' => $image,
                    ]);
                }
            }
        }

        return back()->with('success', "Successfully Update");


    }
}
