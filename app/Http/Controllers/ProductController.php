<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

    function base64_to_jpeg($base64_string, $output_file) {
        // open the output file for writing
        $ifp = fopen( $output_file, 'wb' );

        // split the string on commas
        // $data[ 0 ] == "data:image/png;base64"
        // $data[ 1 ] == <actual base64 string>
        $data = explode( ',', $base64_string );

        // we could add validation here with ensuring count( $data ) > 1
        fwrite( $ifp, base64_decode( $data[ 1 ] ) );

        // clean up the file resource
        fclose( $ifp );

        return $output_file;
    }


    public function orders()
    {
        $orders = Order::all();
        return view('admin.orders',['orders'=>$orders]);
    }


    public function product_category()
    {
        $this->authorize('only_admin');

        $categories = Category::all();
        return view('admin.product.category',['categories' => $categories]);
    }


    public function confirm_buy(Request $request)
    {
        $request->validate([
            'address'       => 'required',
            'quantity'      => 'required',
            'product_id'    => 'required',
            'variation_id'  => 'required',
            'image_editted' => 'required',
            'bkash_number'  => 'required',
            'trx_id'        => 'required',
        ]);
        $product = Product::find($request->product_id);
        $productVariation = ProductVariation::find($request->variation_id);

        $price = $product->price * $request->quantity + 100;
        $image_64 = $request->image_editted; //your base64 encoded data

        $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf

        $replace = substr($image_64, 0, strpos($image_64, ',')+1);

        // find substring fro replace here eg: data:image/png;base64,

        $image = str_replace($replace, '', $image_64);

        $image = str_replace(' ', '+', $image);

        $imageName = time().rand(1,1000).'.'.$extension;
        $imageFile = base64_decode($image);
        Storage::disk('public')->put($imageName, $imageFile);
        // dd($imageFile);
        // $imageFile->move(public_path('/edited', $imageName));

        $filePath = Storage::url("public/$imageName");

        Order::create([
            'product_id'            => $product->id,
            'product_variation_id'  => $productVariation->id,
            'quantity'              => $request->quantity,
            'total_price'           => $price,
            'file'                  => $filePath,
            'bkash_number'          => $request->bkash_number,
            'trx_id'                => $request->trx_id,
            'status'                => 0,
            'user_id'               => Auth::user()->id,
        ]);

        return back()->with('success', "Order confirmed.");

    }

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


        if($request->category_id == null)
            $category_id = 1;
        else
            $category_id = $request->category_id;


        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $category_id,
            //'available' => $request->available,
        ]);

        $variations = [];

        foreach ($request->product_image as $key => $image) {

            $variation = new ProductVariation();
            $color = $request->color[$key];
            $img_url = time().rand(1,100).".".$image->extension();
            $image->move(public_path('product_upload'), $img_url);

            $variation->color = $color;
            $variation->image_url =  $img_url;

            array_push($variations, $variation);
        }


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


    public function single($id, $var_id = null)
    {
        $product = Product::find($id);
        if($product == null)
        {
            abort(404);
        } else {
            return view('product.single',[
                'product' => $product,
                'variation' => $var_id,
            ]);
        }

    }

    public function single_cat($id, $var_id=null)
    {
        $product = Product::find($id) ;
        if($product == null)
        {
            abort(404);
        } else {
            return view('product.single',[
                'product' => $product,
                'variation' => $var_id,
            ]);
        }
    }

    public function personalized($id, $var_id = null)
    {
        $product = Product::find($id);
        if($product == null)
        {
            abort(404);
        } else {
            return view('product.personalized',[
                'product' => $product,
                'variation' => $var_id,
            ]);
        }
    }

    public function buyProductPage($id,$var_id = null)
    {
        $product = Product::find($id);
        if($product == null)
        {
            abort(404);
        } else {
            return view('product.buy',['product' => $product, 'variation' => $var_id]);
        }
    }
}
