<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Namshi\JOSE\Signer\OpenSSL\RSA;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $customer = Customer::all();
        return response($customer);
    }

    public function store(Request $request)
    {
        if (is_numeric($request->Email)) {
            $validator = Validator::make($request->all(), [
                'First_Name' => 'required|string|min:2|max:100',
                'Last_Name' => 'required|string|min:2|max:100',
                'Email' => 'required|regex:/^0[6-9][0-9]/|digits:10|unique:users',
                'Password' => 'required|string|min:6|max:10',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'First_Name' => 'required|string|min:2|max:100',
                'Last_Name' => 'required|string|min:2|max:100',
                'Email' => 'required|string|email|max:100|unique:users',
                'Password' => 'required|string|min:6|max:10',
            ]);
        }

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = Customer::create([
            'name' => $request->First_Name . ' ' . $request->Last_Name,
            'email' => $request->Email,
            'password' => Hash::make($request->Password),
        ]);

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user,
        ], 201);
    }

    public function update(Request $request)
    {
        $customer = Customer::find($request->id);
        if ($customer == null) {

            echo "sorry not found  user";
        } else {
            $customer->update([
                'id' => $request->id,
                'name' => $request->First_Name . ' ' . $request->Last_Name,
                'email' => $request->Email,
                'password' => Hash::make($request->Password),
            ]);
        }
        return response()->json([
            'message' => 'User successfully Update',
        ], 201);
    }

    public function user_profile($id)
    {
        $customer = Customer::find($id);
        return response()->json([
            'messagr'=>'User Information',
           'user'=> $customer
        ]);
    }

    public function delete($id)
    {
        $customer = Customer::find($id);
        if ($customer==null) {

            echo "Sorry Not Found User";
        }
        else{
            $customer->delete();
            return response()->json([
                'messagr'=>'User Delete Successfully',
               'user'=> $customer->name
            ]);
        }
    }
}
