<?php

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\InformasiController;
use App\Http\Controllers\TestimoniController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\AuthenticationController;

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

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
 */

Route::post('login', [AuthenticationController::class, 'login_member']);
Route::get('logout', [AuthenticationController::class, 'logout_member'])->middleware(['auth:sanctum']);
Route::get('person', [AuthenticationController::class, 'person'])->middleware(['auth:sanctum']);


//paypal
/* Route::get('payment', [PaymentController::class ,'index']);
Route::get('charge', [PaymentController::class ,'charge']);
Route::get('success', [PaymentController::class ,'success']);
Route::get('error', [PaymentController::class ,'error']);
 */

/* Route::get('categories', [CategoryController::class, 'index'])->middleware(['auth:sanctum']);
Route::get('categories/{category}', [CategoryController::class, 'show'])->middleware(['auth:sanctum']);

 */
// routes/api.php
// routes/api.php





Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function() {
    Route::post('register', [AuthController::class, 'register'])->name('login');
     Route::post('admin', [AuthController::class, 'login']);

    /*    Route::post('login', [AuthController::class, 'login_member'])->name('login'); */
    //Login Member Nganggo WEB udu sek API
    
    //logout
    /*    Route::post('logout', [AuthController::class, 'logout']); */
   /*  Route::post('logout', [AuthController::class, 'logout_member']); */
});
 
Route::group([
    'middleware' => 'api'
], function(){
    Route::resources([
        'categories' => CategoryController::class, 
        'subcategories' => SubCategoryController::class,
        'sliders' => SliderController::class,
        'produks' => ProdukController::class,
        'members' => MemberController::class,
        'testimonis' => TestimoniController::class,
        'reviews' => ReviewController::class,
        'informasi' => InformasiController::class,
        'carts' => CartController::class,
        'orders' => OrderController::class
    ]);

    Route::get('order/dikonfirmasi', [OrderController::class, 'dikonfirmasi']);
    Route::get('order/dikemas', [OrderController::class, 'dikemas']);
    Route::get('order/dikirim', [OrderController::class, 'dikirim']);
    Route::get('order/diterima', [OrderController::class, 'diterima']);
    Route::get('order/selesai', [OrderController::class, 'selesai']);
    Route::post('order/ubah_status/{order}', [OrderController::class, 'ubah_status']);
    
    Route::get('reports', [ReportController::class, 'index']);
});

