<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function view($id)
    {
        $products = Product::where('customer_id',$id)->paginate();
        return response($products, 200);
    }
}
