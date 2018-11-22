<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'admin', 'as' => 'api.admin.', 'namespace' => 'Api\Admin', 'middleware' => ['cors']], function () {
    Route::post('login', 'LoginController@login')->name('login');
    Route::group(['middleware' => ['verify.admin']], function () {
        Route::apiResource('categories', 'CategoryController');
        Route::apiResource('users', 'UserController');
        Route::apiResource('shops', 'ShopController');
        Route::apiResource('products', 'ProductController');
        Route::apiResource('coupons', 'CouponController');
        Route::apiResource('payments', 'PaymentMethodController');
        Route::apiResource('orders', 'OrderController');
        Route::apiResource('ratings', 'RatingController');
        Route::apiResource('comments', 'CommentController');
        Route::apiResource('promotions', 'PromotionController');
        Route::apiResource('managers', 'ManagerController');
    });

});
Route::group(['as' => 'api.', 'namespace' => 'Api\User', 'middleware' => ['cors']], function () {
    Route::apiResource('categories', 'CategoryController');
    Route::post('login', 'LoginController@login');
    Route::post('register', 'LoginController@register');
    Route::apiResource('products', 'ProductController');
    Route::apiResource('promotions', 'PromotionController');
    Route::group(['middleware' => 'auth:api'], function () {
        Route::apiResource('orders', 'OrderController');
        Route::put('orders/{id}/cancel', 'OrderController@cancel');
        Route::apiResource('ratings', 'RatingController');
        Route::apiResource('comments', 'CommentController');
        Route::apiResource('uploads', 'UploadImageController');
    });


});
