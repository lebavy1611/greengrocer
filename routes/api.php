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
Route::group(['prefix' => 'admin', 'as' => 'api.admin.', 'namespace' => 'Api\Admin'], function () {
    Route::post('login', 'LoginController@login')->name('login');
    Route::group(['middleware' => ['verify.admin']], function () {
        Route::apiResource('categories', 'CategoryController');
        Route::apiResource('users', 'UserController');
        Route::apiResource('shops', 'ShopController');
        Route::apiResource('products', 'ProductController');
        Route::get('products/perpage/{perPage}', 'ProductController@indexPerPage');
        Route::apiResource('coupons', 'CouponController');
        Route::apiResource('payments', 'PaymentMethodController');
        Route::apiResource('orders', 'OrderController');
        Route::get('orders/perpage/{perPage}', 'OrderController@indexPerPage');
        Route::apiResource('ratings', 'RatingController');
        Route::apiResource('comments', 'CommentController');
        Route::apiResource('promotions', 'PromotionController');
        Route::apiResource('managers', 'ManagerController');
        Route::apiResource('resources', 'ResourceController');
        Route::get('manager-logined', 'ManagerController@getManagerLogin')->name('getManagerLogined');
        Route::apiResource('statistics', 'StatisticController');
        Route::apiResource('process-statuses', 'ProcessStatusController');
    });

});
Route::group(['as' => 'api.', 'namespace' => 'Api\User'], function () {
    Route::apiResource('categories', 'CategoryController');
    Route::post('login', 'LoginController@login');
    Route::post('register', 'LoginController@register');
    Route::apiResource('products', 'ProductController');
    Route::apiResource('promotions', 'PromotionController');
    Route::post('ordersNologin', 'OrderControllerNoLogin@store');
    Route::get('check-coupon', 'CouponController@checkCodeCoupon');
    Route::get('coupons', 'CouponController@index');
    Route::group(['middleware' => 'verify.user'], function () {
        Route::apiResource('orders', 'OrderController');
        Route::put('orders/{id}/cancel', 'OrderController@cancel');
        Route::apiResource('ratings', 'RatingController');
        Route::apiResource('comments', 'CommentController');
        Route::apiResource('uploads', 'UploadImageController');
        Route::get('userInfor', 'UserController@show');
        Route::put('editUserInfor', 'UserController@update');
    });
});

