<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', function () {
    return view('welcome');
});

// Route::group(['middleware' => 'web'], function ($router) {
//     Route::get('/', function () {
//         $user = User::create([
//             'name' => 'name',
//             'email' => 'uru@gmail.com',
//             'password' => Hash::make('12312312'),
//         ]);
//         return $user;
//     });
// });
