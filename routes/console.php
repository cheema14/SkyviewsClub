<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Artisan::command('freeTables',function(){
    \App\Models\TableTop::query()->update(['status' => 'free']);
    $this->info('Table tops status updated to "free" for all rows.');
})->purpose('Set the table tops to free to make orders');

Artisan::command('empty:tables {tables*}', function ($tables) {
    
    DB::statement('SET FOREIGN_KEY_CHECKS=0');
    
    foreach ($tables as $table) {
        \DB::table($table)->truncate();
    }
    

    DB::statement('SET FOREIGN_KEY_CHECKS=1');
    
    $this->info('Tables truncated successfully.');
})->describe('Truncate specified tables');