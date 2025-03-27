<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


use App\Http\Controllers\ActorController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\FilmActorController;
use App\Http\Controllers\FilmCategoryController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\AuthController;


// Actor Routes
Route::get('actors', [ActorController::class, 'index']);
Route::post('actors', [ActorController::class, 'store']);
Route::get('actors/{actor}', [ActorController::class, 'show']);
Route::put('actors/{actor}', [ActorController::class, 'update']);
Route::delete('actors/{actor}', [ActorController::class, 'destroy']);

Route::get('addresses', [AddressController::class, 'index']);
Route::post('addresses', [AddressController::class, 'store']);
Route::get('addresses/{address}', [AddressController::class, 'show']);
Route::put('addresses/{address}', [AddressController::class, 'update']);
Route::delete('addresses/{address}', [AddressController::class, 'destroy']);

// Category Routes
Route::get('categories', [CategoryController::class, 'index']);
Route::post('categories', [CategoryController::class, 'store']);
Route::get('categories/{category}', [CategoryController::class, 'show']);
Route::put('categories/{category}', [CategoryController::class, 'update']);
Route::delete('categories/{category}', [CategoryController::class, 'destroy']);

// City Routes
Route::get('cities', [CityController::class, 'index']);
Route::post('cities', [CityController::class, 'store']);
Route::get('cities/{city}', [CityController::class, 'show']);
Route::put('cities/{city}', [CityController::class, 'update']);
Route::delete('cities/{city}', [CityController::class, 'destroy']);

// Country Routes
Route::get('countries', [CountryController::class, 'index']);
Route::post('countries', [CountryController::class, 'store']);
Route::get('countries/{country}', [CountryController::class, 'show']);
Route::put('countries/{country}', [CountryController::class, 'update']);
Route::delete('countries/{country}', [CountryController::class, 'destroy']);

// Customer Routes
Route::get('customers', [CustomerController::class, 'index']);
Route::post('customers', [CustomerController::class, 'store']);
Route::get('customers/{customer}', [CustomerController::class, 'show']);
Route::put('customers/{customer}', [CustomerController::class, 'update']);
Route::delete('customers/{customer}', [CustomerController::class, 'destroy']);

// Film Routes
Route::get('films', [FilmController::class, 'index']);
Route::post('films', [FilmController::class, 'store']);
Route::get('films/{film}', [FilmController::class, 'show']);
Route::put('films/{film}', [FilmController::class, 'update']);
Route::delete('films/{film}', [FilmController::class, 'destroy']);

// FilmActor Routes
Route::get('film_actors', [FilmActorController::class, 'index']);
Route::post('film_actors', [FilmActorController::class, 'store']);
Route::get('film_actors/{filmActor}', [FilmActorController::class, 'show']);
Route::put('film_actors/{filmActor}', [FilmActorController::class, 'update']);
Route::delete('film_actors/{filmActor}', [FilmActorController::class, 'destroy']);

// FilmCategory Routes
Route::get('film_categories', [FilmCategoryController::class, 'index']);
Route::post('film_categories', [FilmCategoryController::class, 'store']);
Route::get('film_categories/{filmCategory}', [FilmCategoryController::class, 'show']);
Route::put('film_categories/{filmCategory}', [FilmCategoryController::class, 'update']);
Route::delete('film_categories/{filmCategory}', [FilmCategoryController::class, 'destroy']);

// Inventory Routes
Route::get('inventory', [InventoryController::class, 'index']);
Route::post('inventory', [InventoryController::class, 'store']);
Route::get('inventory/{inventory}', [InventoryController::class, 'show']);
Route::put('inventory/{inventory}', [InventoryController::class, 'update']);
Route::delete('inventory/{inventory}', [InventoryController::class, 'destroy']);

// Language Routes
Route::get('languages', [LanguageController::class, 'index']);
Route::post('languages', [LanguageController::class, 'store']);
Route::get('languages/{language}', [LanguageController::class, 'show']);
Route::put('languages/{language}', [LanguageController::class, 'update']);
Route::delete('languages/{language}', [LanguageController::class, 'destroy']);

// Payment Routes
Route::get('payments', [PaymentController::class, 'index']);
Route::post('payments', [PaymentController::class, 'store']);
Route::get('payments/{payment}', [PaymentController::class, 'show']);
Route::put('payments/{payment}', [PaymentController::class, 'update']);
Route::delete('payments/{payment}', [PaymentController::class, 'destroy']);

// Rental Routes
Route::get('rentals', [RentalController::class, 'index']);
Route::post('rentals', [RentalController::class, 'store']);
Route::get('rentals/{rental}', [RentalController::class, 'show']);
Route::put('rentals/{rental}', [RentalController::class, 'update']);
Route::delete('rentals/{rental}', [RentalController::class, 'destroy']);

// Staff Routes
Route::get('staff', [StaffController::class, 'index']);
Route::post('staff', [StaffController::class, 'store']);
Route::get('staff/{staff}', [StaffController::class, 'show']);
Route::put('staff/{staff}', [StaffController::class, 'update']);
Route::delete('staff/{staff}', [StaffController::class, 'destroy']);

// Store Routes
Route::get('stores', [StoreController::class, 'index']);
Route::post('stores', [StoreController::class, 'store']);
Route::get('stores/{store}', [StoreController::class, 'show']);
Route::put('stores/{store}', [StoreController::class, 'update']);
Route::delete('stores/{store}', [StoreController::class, 'destroy']);

Route::post('/login-step1', [AuthController::class, 'loginStep1']);
Route::post('/login-step2', [AuthController::class, 'loginStep2']);