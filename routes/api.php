<?php

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
use App\Http\Controllers\DashboardController;

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
//Route Login member 
Route::post('login', [AuthenticationController::class, 'login_member']);
Route::get('logout', [AuthenticationController::class, 'logout_member'])->middleware(['auth:sanctum']);
//Route profile
Route::get('person', [AuthenticationController::class, 'person'])->middleware(['auth:sanctum']);
//Route dashboard
Route::get('dashboard', [DashboardController::class, 'show']);
// route pencarian endpoint lebih fleksibel
Route::get('search', [ProdukController::class, 'search']);
//carts
Route::get('carts', [CartController::class, 'index']);
Route::post('carts', [CartController::class, 'store']);

//informasi checkout
Route::get('informasi', [InformasiController::class, 'index']);
Route::get('informasi', [InformasiController::class, 'store']);

/* Route::put('produks', [ProdukController::class, 'update']); */

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function() {
    Route::post('register', [AuthController::class, 'register'])->name('login');
    Route::post('admin', [AuthController::class, 'login']);
});

Route::group([
    'middleware' => 'api'
], function() {
    Route::resources([
        'categories' => CategoryController::class,
        'subcategories' => SubCategoryController::class, 
        'sliders' => SliderController::class,
        'produks' => ProdukController::class,
        'members' => MemberController::class,
        'testimonis' => TestimoniController::class,
        'reviews' => ReviewController::class,
        /* 'informasi' => InformasiController::class, */
/*         'carts' => CartController::class,
 */        'orders' => OrderController::class
    ]);
});
