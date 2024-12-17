<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Failed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Spatie\Activitylog\Models\Activity;

class LogFailedLogin
{
    
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Failed $event): void
    {
        
        $user = $event->user;
        
        if($event->guard != 'member'){
            $username = $event->credentials['username'];
        }
        else{
            $username = $event->credentials['cnic_no'];
        }
        
        activity()
            ->causedBy($user)
            ->withProperties(['username' => $username])
            ->log('Failed login attempt');
    }
}
