<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class ProductController extends Controller
{
    public function __construct()
    {
         $this->middleware('auth');
    }

    public function index()
    {
        // $products = Product::all();
        // return response($products);
        $products = Product::paginate();
    return response($products, 200);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        // $imageName = $request->file('Image')->getClientOriginalName();
        $product =   Product::create([
            'Name'=>$request->Name,
            'Image'=>$request->Image,
            'Description'=>$request->Description,

        ]);
        // $imageName = $request->photo->getClientOriginalName();
        $product_id = Product::latest()->first()->id;
        $request->Image->move(public_path('Attachments/' . $product_id), 'main.jpg');
        return response($product);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $Product = Product::find($id);
        if ($Product==null) {

            echo "sorry not found product";
        }
        else{
            $Product->delete();
            return response('Product delete successfully.');
        }
    }

    public function assign(Request $request)
    {
        $product = Product::find($request->id);
        if ($product == null) {

            echo "sorry not found  user";
        } else {
            $product->update([
                'customer_id'=>$request->customer_id
            ]);
        }
    }
}
