<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\TestimoniController;
use App\Http\Controllers\ReviewController;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function() {
    Route::post('login', [AuthController::class, 'login'])->name('login');
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
        'orders' => OrderController::class
    ]);
});
