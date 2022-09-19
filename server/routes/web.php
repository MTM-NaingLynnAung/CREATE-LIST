<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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


// Route::middleware('auth:sanctum')->group(function (){
//     Route::resource('category', CategoryController::class);
//     Route::resource('user', UserController::class);
// });

Route::get('/', function(){
  return view('welcome');
});

Route::post('login', [UserController::class, 'login']);
Route::post('logout', [UserController::class, 'logout']);
Route::get('logout', [UserController::class, 'logout']);



