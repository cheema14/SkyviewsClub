<?php

use App\Http\Controllers\Api\V1\MemberApiController as MemberApiController;
use App\Http\Controllers\Api\V1\OrderApiController;
use App\Http\Controllers\Api\V1\ServingOfficerController;
use App\Http\Controllers\Api\V1\SyncApiController;
use App\Http\Controllers\Api\V1\UpdateOrderApiController;
use App\Http\Controllers\Api\V1\UserApiController as UserApiController;

Route::post('/user/login', [UserApiController::class, 'login'])->name('user-login');
Route::post('/member/login', [MemberApiController::class, 'login'])->name('member-login');
Route::get('/user/sync', SyncApiController::class);

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin'], function () {

    Route::post('/user/place-order', [OrderApiController::class, 'placeOrder'])->middleware(['auth:sanctum', 'abilities:place-orders']);

    Route::post('/user/update-order', [UpdateOrderApiController::class, 'index'])->middleware(['auth:sanctum']);

    Route::post('/logout', [MemberApiController::class, 'logout']);
    Route::post('/member/search', [MemberApiController::class, 'search'])->middleware(['auth:sanctum', 'abilities:member-search']);
    Route::get('/member/menus', [MemberApiController::class, 'menus'])->middleware(['auth:sanctum', 'abilities:list-menus']);
    Route::post('/member/change-password', [MemberApiController::class, 'change_password'])->middleware(['auth:sanctum', 'abilities:change-password']);
    Route::post('/member/update-profile', [MemberApiController::class, 'update_profile'])->middleware(['auth:sanctum', 'abilities:update-profile']);
    Route::post('/user/orders', [UserApiController::class, 'userOrders'])->middleware('auth:sanctum');
    Route::post('/update/order-status', [UpdateOrderApiController::class, 'updateOrderStatus'])->middleware('auth:sanctum');

    Route::post('/user/save-serving-officer', [ServingOfficerController::class, 'saveOfficer'])->middleware(['auth:sanctum', 'abilities:place-orders']);
});
