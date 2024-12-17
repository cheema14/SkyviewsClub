<?php

use Spatie\Health\Http\Controllers\HealthCheckResultsController;

// use Spatie\Health\Http\Controllers\HealthCheckResultsController;
// Route::get('health', HealthCheckResultsController::class);
// dd('central');
// Route::get('/central',[TenantController::class,'index'])->name('central.index');
// Route::redirect('/', '/login');
Route::get('/', function(){
    return 'central login';
});