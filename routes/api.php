<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\AuthController;

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

// Route for member login
Route::post('login', [AuthenticationController::class, 'login_member']);
Route::get('logout', [AuthenticationController::class, 'logout_member']);

// Route for checkout
Route::get('checkout', [CheckoutController::class, 'index']);
Route::get('checkout/{checkout}', [CheckoutController::class, 'show']);

// Route profile
Route::get('person', [AuthenticationController::class, 'person']);

Route::get('search', [ProdukController::class, 'search']);

Route::group(['middleware' => ['auth:api', 'role:admin']], function () {
    // Routes that only Admin can access
    Route::get('dashboard', [DashboardController::class, 'show']);
    Route::delete('members', [DashboardController::class, 'destroy']);
});

Route::group(['middleware' => ['role:member']], function () {
    // Routes that only Members can access
    Route::get('carts', [CartController::class, 'index']);
    Route::post('carts', [CartController::class, 'store']);
    Route::delete('carts/{cart}', [CartController::class, 'destroy']);
    Route::get('carts/{cart}', [CartController::class, 'show']);
    Route::post('checkout', [CheckoutController::class, 'store']);
});

// Routes for admin login and member registration using API middleware
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function() {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('admin', [AuthController::class, 'login_admin']);
});

// Routes using api middleware
Route::group([
    'middleware' => 'api'
], function() {
    Route::resources([
        'categories' => CategoryController::class,
        'subcategories' => SubCategoryController::class,
        'produks' => ProdukController::class,
        /* 'members' => MemberController::class, */
    ]);
});
