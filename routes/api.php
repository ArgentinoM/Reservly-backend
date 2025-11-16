<?php

use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\FavoritServiceController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ServiceRatingController;
use App\Http\Controllers\ServicesController;
use Illuminate\Support\Facades\Route;


Route::post('auth/register', [AuthController::class, 'register']);
Route::post('auth/login', [AuthController::class, 'login'])->name('login');

Route::middleware("jwt.auth")->group(function () {
    // Auth
    Route::get('auth/verify', [AuthController::class, 'status']);
    Route::get('auth/logout', [AuthController::class, 'logout']);

    // Categories
    Route::get('categories', [CategoriesController::class, 'showAll']);

    //Services
    Route::get('services', [ServicesController::class, 'index']);
    Route::get('services/{service_id}', [ServicesController::class, 'searchById']);

    Route::middleware('seller')->group(function () {
        Route::post('serviceStore', [ServicesController::class, 'store']);
        Route::patch('serviceUpdate/{service_id}', [ServicesController::class, 'update']);
        Route::delete('serviceDelete/{services_id}', [ServicesController::class, 'delete']);
        Route::post('cancelDeleteServcices/{service_id}', [ServicesController::class, 'cancelDelete']);
    });


    // Review
    Route::get('review/{service_id}', [ReviewController::class, 'index']);
    Route::post('storeReview', [ReviewController::class, 'store']);
    Route::patch('updateReview/{review_id}', [ReviewController::class, 'update']);
    Route::delete('deleteReview/{review_id}', [ReviewController::class, 'delete']);

    // Service Rating
    Route::get('rating/{service}', [ServiceRatingController::class, 'index']);

    // Favorite
    Route::get('favoriteService', [FavoritServiceController::class, 'index']);
    Route::post('favoriteStore', [FavoritServiceController::class, 'store']);
    Route::delete('favoriteDelete/{service_id}', [FavoritServiceController::class, 'delete']);

    // Payments
    Route::post('payment_intents', [PaymentsController::class, 'createPaymentIntent']);
    Route::post('payment_intents/{payment_id}/cancel', [PaymentsController::class, 'cancelPaymentIntent']);
});
