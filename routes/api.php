<?php

use App\Http\Controllers\Api\V1\MemberApiController as MemberApiController;
use App\Http\Controllers\Api\V1\MemberBookingApiController;
use App\Http\Controllers\Api\V1\OrderApiController;
use App\Http\Controllers\Api\V1\ServingOfficerController;
use App\Http\Controllers\Api\V1\SyncApiController;
use App\Http\Controllers\Api\V1\UpdateOrderApiController;
use App\Http\Controllers\Api\V1\UserApiController as UserApiController;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;




// Route::post('/user/login', [UserApiController::class, 'login'])->name('user-login');
// Route::post('/member/login', [MemberApiController::class, 'login'])->name('member-login');
// Route::get('/user/sync', SyncApiController::class);

Route::middleware([
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::post('/user/login', [UserApiController::class, 'login'])->name('user-login');
    Route::post('/member/login', [MemberApiController::class, 'login'])->name('member-login');
    Route::post('/user/sync', SyncApiController::class);
});


Route::prefix('v1')
    ->as('api.')
    ->namespace('Api\V1\Admin')
    ->middleware([
        'CheckMultipleLogin',
        InitializeTenancyByDomain::class,
        PreventAccessFromCentralDomains::class,
])->group(function () {
    // Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin'], function () {

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


    Route::post('/member/room-booking', [MemberApiController::class, 'room_booking'])->middleware(['auth:sanctum', 'abilities:book-room']);
    Route::get('/member/room-list', [MemberApiController::class, 'room_list'])->middleware(['auth:sanctum', 'abilities:book-room']);
    Route::post('/member/get-latest-bill', [MemberApiController::class, 'get_latest_bill'])->middleware(['auth:sanctum', 'abilities:get-latest-bill']);
    Route::post('/member/get-latest-profile', [MemberApiController::class, 'get_latest_profile'])->middleware(['auth:sanctum', 'abilities:get-latest-profile']);
    Route::post('/user/save-serving-officer', [ServingOfficerController::class, 'saveOfficer'])->middleware(['auth:sanctum', 'abilities:place-orders']);

    // Member Feedback

    Route::post('/member/save-member-feedback', [MemberApiController::class, 'save_member_feedback'])->middleware(['auth:sanctum', 'abilities:save-member-feedback']);
    Route::post('/member/get-member-feedback', [MemberApiController::class, 'get_member_feedback'])->middleware(['auth:sanctum', 'abilities:save-member-feedback']);

    // Member - get available dates - minimum for 2 months (current and next)
    Route::post('/member/get-available-dates', [MemberApiController::class, 'get_available_dates'])->middleware(['auth:sanctum', 'abilities:get-available-dates']);

    // Member - get booked dates - minimum for 2 months (current and next)
    Route::post('/member/get-booked-dates', [MemberApiController::class, 'get_booked_dates'])->middleware(['auth:sanctum', 'abilities:get-booked-dates']);

    // Get all bookings of a particular member
    Route::post('/member/get-my-bookings', [MemberBookingApiController::class, 'get_my_bookings'])->middleware(['auth:sanctum', 'abilities:get-available-dates']);
});
