<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaypalController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\ProductSizeController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\DeliveryChargeController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware(['api'])->group(function () {
    Route::post('register', [UserController::class, 'register']);
    Route::post('verify-otp', [UserController::class, 'verifyOtp']);
    Route::post('resend-otp', [UserController::class, 'resendOTP']);
    Route::post('login', [AuthController::class, 'login']);
});

Route::middleware(['api'])->group(function () {
    // Your routes here...
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::middleware(['api'])->group(function () {
    Route::prefix('user')->group(function () {
        Route::get('/profile', [UserController::class, 'getUserProfile']);
        Route::post('/change-password', [UserController::class, 'changePassword']);
        Route::post('/update-address-phone', [UserController::class, 'updateUserAddressAndPhone']);   
        Route::post('/update-profile-picture', [UserController::class, 'updateUserProfilePicture']);     
        Route::get('/cart-items', [UserController::class, 'getUserCartItems']);   
        Route::get('/user-orders', [UserController::class, 'getUserOrderList']);
    });
});

Route::middleware(['api'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::put('/create', [AdminController::class, 'create']);
        Route::get('/admin-list', [AdminController::class, 'getAdminList']);
        Route::get('/profile', [AdminController::class, 'getAdminProfile']);
        Route::get('/user-profile/{userId}', [UserController::class, 'getUserProfileByID']);
        Route::get('/user-list', [UserController::class, 'getUserList']);
        Route::put('/remove', [AdminController::class, 'remove']);
    });
});

Route::middleware(['api'])->group(function () {
    Route::prefix('super-admin')->group(function () {
        Route::post('/create', [SuperAdminController::class, 'create']);
        Route::get('/verify', [SuperAdminController::class, 'verifyPassword']);
        Route::get('/profile', [SuperAdminController::class, 'getSuperAdminProfile']);
    });
});



Route::middleware(['api'])->group(function () {
    Route::prefix('order')->group(function () {
        Route::get('/delivered-list', [OrderController::class, 'getDeliveredOrderList']);
        Route::get('/pending-list', [OrderController::class, 'getPendingOrderList']);
        Route::get('/all-list', [OrderController::class, 'getOrderList']);
        
        Route::post('/place', [OrderController::class, 'placeOrder']);
        Route::post('/delivered/{orderId}', [OrderController::class, 'deliverOrder']);
    });
});



Route::middleware(['api'])->group(function () {
    /*
     * Route::resource method automatically detects: index, show, create, store, edit, update, destroy
     * POST /products: store()
     * GET /products: index()
     * GET /products/{id}: show()
     * PUT /products/{id} or PATCH /products/{id}: update()
     * DELETE /products/{id}: destroy()
     * 
     * Run the Command to Find Routs: php artisan route:list
     * 
     */
    Route::resource('products', ProductController::class);
    
    Route::prefix('products')->group(function () {
        Route::get('/{id}/images', [ProductController::class, 'getProductImages']);
        Route::get('/{id}/sizes', [ProductController::class, 'getProductSizes']);
        Route::get('/{id}/discounts', [ProductController::class, 'getProductDiscounts']);

        Route::get('/random', [ProductController::class, 'getAllProductsRandomOrder']);
        Route::get('/category/{category}', [ProductController::class, 'getProductsByCategory']);
        Route::get('/subcategory/{subCategory}', [ProductController::class, 'getProductsBySubCategory']);
        Route::get('/category/{category}/random', [ProductController::class, 'getProductsByCategoryRandomOrder']);
        Route::get('/subcategory/{subCategory}/random', [ProductController::class, 'getProductsBySubCategoryRandomOrder']);
        Route::put('/{id}/restore', [ProductController::class, 'restoreProduct']);

    });

    Route::resource('discounts', DiscountController::class); // Create, Read by ID, Update, Delete
    Route::resource('product-sizes', ProductSizeController::class); // Create, Read by ID, Update
    Route::resource('product-images', ProductImageController::class); // Create, Read by ID, Delete

});


Route::middleware(['api'])->group(function () {
    Route::prefix('messages')->group(function () {
        Route::post('/send-to-user', [MessageController::class, 'sendToUser']);
        Route::post('/send-to-admin', [MessageController::class, 'sendToAdmin']);
        Route::get('/receive-user-side', [MessageController::class, 'receiveUserSide']);
        Route::get('/receive-admin-side/{userID}', [MessageController::class, 'receiveAdminSide']);
        Route::delete('/{id}', [MessageController::class, 'delete']);
    });
});


Route::middleware(['api'])->group(function () {
    Route::get('paypal/payment/{processId}',[PaypalController::class,'payment']);
    Route::resource('offers', OfferController::class);
    Route::patch('/offers/undelete/{id}', [OfferController::class, 'undeleteOffer']);
});

Route::middleware(['api'])->group(function () {   // Create, Read by ID, Update, Delete
    Route::resource('cart', CartController::class)->only(['store', 'index', 'update', 'destroy']);
});

Route::middleware('api')->group(function () {
    Route::prefix('delivery')->group(function () {
    Route::get('charge', [DeliveryChargeController::class, 'index']);
    Route::put('charge', [DeliveryChargeController::class, 'update']);
    });
});


Route::fallback(function () {
    return response()->json([
        'message' => 'Unauthorized. Please login first.',
        // Optionally include a link to the login page
    ], 401);
});