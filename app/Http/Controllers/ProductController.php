<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariation;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function admin_index()
    {
        $products = Product::all();
        return view('admin.product.index', ['products'=> $products]);
    }

    public function admin_add_product()
    {
        return view('admin.product.add-product');
    }

    public function index()
    {
        return view("product.index");
    }

    public function add_product_page()
    {
        $this->authorize('only_admin');
        $categories = Category::all();
        return view('product.add',['categories' => $categories]);
    }

    public function admin_store(Request $request)
    {
        $request->validate([

        ]);




        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            //'available' => $request->available,
        ]);

        $variations = [];

        foreach ($request->product_image as $key => $image) {

            $variation = new ProductVariation();
            $color = $request->color[$key];
            $img_url = time().".".$image->extension();
            $image->move(public_path('product_upload'), $img_url);

            $variation->color = $color;
            $variation->image_url =  $img_url;

            array_push($variations, $variation);
        }

        dump($variations);
        // foreach($variations as $variation)
        // {
        //     $product->variations->save($variation);
        // }
        $product->variations()->saveMany($variations);
        return back()->with("success", "Product Successfully added");
    }


    public function store(Request $request)
    {

        //dd($request);
        $request->validate([
            'product_name' => ['required', 'string', 'max:255'],
            'product_description' => ['required', 'string'],
            'product_price'=>['required'],
            'product_category'=> ['required'],
            'product_mockup' => ['required']
        ]);

        // if($request->product_category == 0) $request->product_category = null;
        //dd();
        $fileName = time().'.'.$request->file('product_mockup')->extension();
        $request->file('product_mockup')->move(public_path('product_upload'), $fileName);



        $product = Product::create([
            'name' => $request->product_name,
            'description' => $request->product_description,
            'category'=>$request->product_category,
            'price'=>$request->product_price,
            'mockup' => $fileName,
        ]);

        //dd($product);

        return back()
            ->with('success',"Data Succussfully Added");

    }


    public function single($id)
    {
        $product = Product::find($id);
        if($product == null)
        {
            abort(404);
        } else {
            return view('product.single',['product' => $product]);
        }

    }


    public function personalized($id)
    {
        $product = Product::find($id);
        if($product == null)
        {
            abort(404);
        } else {
            return view('product.personalized',['product' => $product]);
        }
    }

    public function buyProductPage($id)
    {
        $product = Product::find($id);
        if($product == null)
        {
            abort(404);
        } else {
            return view('product.buy',['product' => $product]);
        }
    }
}
