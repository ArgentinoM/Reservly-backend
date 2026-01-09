<?php

use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\FavoritServiceController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SellerDashboardController;
use App\Http\Controllers\ServiceRatingController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\StripeWebhookController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::post('auth/register', [AuthController::class, 'register']);
Route::post('auth/login', [AuthController::class, 'login'])->name('login');

Route::post('stripe/webhook', [StripeWebhookController::class, 'handle']);

Route::middleware("jwt.auth")->group(function () {
    // Auth
    Route::get('auth/verify', [AuthController::class, 'status']);
    Route::get('auth/logout', [AuthController::class, 'logout']);
    Route::patch('users', [UserController::class, 'update']);

    // Categories
    Route::get('categories', [CategoriesController::class, 'showAll']);

    //Services
    Route::get('services', [ServicesController::class, 'index']);
    Route::get('services/{service_id}', [ServicesController::class, 'searchById']);

    Route::middleware('seller')->group(function () {
        Route::post('services', [ServicesController::class, 'store']);
        Route::post('services/{service_id}', [ServicesController::class, 'update']);
        Route::delete('services/{services_id}', [ServicesController::class, 'delete']);
        Route::post('cancelDelete/{service_id}', [ServicesController::class, 'cancelDelete']);
    });


    // Review
    Route::get('service/{service}/reviews', [ReviewController::class, 'index']);
    Route::post('service/{service}/reviews', [ReviewController::class, 'store']);
    Route::patch('reviews/{review}', [ReviewController::class, 'update']);
    Route::delete('reviews/{review}', [ReviewController::class, 'destroy']);

    // Service Rating
    Route::get('rating/{service}', [ServiceRatingController::class, 'index']);

    // Favorite
    Route::get('favorites', [FavoritServiceController::class, 'index']);
    Route::post('favorites', [FavoritServiceController::class, 'store']);
    Route::delete('favorites/{service_id}', [FavoritServiceController::class, 'delete']);

    // Payments
    Route::post('payment_intents', [PaymentsController::class, 'createPaymentIntent']);
    Route::post('payment_intents/{reservation_id}/continue', [PaymentsController::class, 'continuePaymentIntent']);
    Route::post('payment_intents/{payment_id}/cancel', [PaymentsController::class, 'cancelPaymentIntent']);

    // Reservations
    Route::get('reservations', [ReservationController::class, 'index']);
    Route::get('reservations/{id}/status', [ReservationController::class, 'status']);
    Route::get('reservations/{service_id}', [ReservationController::class, 'byService']);
    Route::post('reservations/{id}/cancel', [ReservationController::class, 'cancelPaymentIntent']);

    // DashboarSelle
    Route::get('seller/dashboard/summary', [SellerDashboardController::class, 'summary']);
    Route::get('seller/dashboard/sales-by-month', [SellerDashboardController::class, 'salesByMonth']);
    Route::get('seller/dashboard/revenue-by-month', [SellerDashboardController::class, 'revenueByMonth']);
    Route::get('seller/dashboard/top-services', [SellerDashboardController::class, 'topServices']);
});
