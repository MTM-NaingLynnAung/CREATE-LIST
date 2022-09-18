<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->group(function (){
//     Route::apiResource('user', UserController::class);
// });
Route::middleware('auth:sanctum')->group(function (){
    Route::apiResource('category', CategoryController::class);
    
    Route::post('logout', [UserController::class, 'logout']);
    Route::get('user', [AuthController::class, 'user']);
});

// Route::middleware('auth:sanctum')->get('/user', function(Request $request){
//     return $request->user();
// });

Route::post('register',[UserController::class, 'store']);
Route::post('login', [UserController::class, 'login']);
Route::apiResource('product', ProductController::class);
Route::post('product-update/{id}', [ProductController::class, 'update']);
Route::get('all', [CategoryController::class, 'all']);
