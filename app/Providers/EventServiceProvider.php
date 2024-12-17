<?php

namespace App\Providers;

use App\Events\ChangeTableTopEvent;
use App\Events\DiscountedMembershipFeeEvent;
use App\Events\PrintKitchenReceiptEvent;
use App\Events\PrintUpdatedKitchenReceiptEvent;
use App\Events\UpdateMemberArrearEvent;
use App\Events\UpdateMemberBillEvent;
use App\Listeners\ChangeTableTopListener;
use App\Listeners\DiscountedMembershipFeeListener;
use App\Listeners\LogAuthenticated;
use App\Listeners\LogFailedLogin;
use App\Listeners\LogLogout;
use App\Listeners\PrintKitchenReceiptListener;
use App\Listeners\PrintUpdatedKitchenReceiptListener;
use App\Listeners\UpdateMemberArrearListener;
use App\Listeners\UpdateMemberBillListener;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        // When printing the kitchen receipt
        PrintKitchenReceiptEvent::class => [
            PrintKitchenReceiptListener::class,
        ],

        // When printing updated kitchen receipt
        PrintUpdatedKitchenReceiptEvent::class => [
            PrintUpdatedKitchenReceiptListener::class,
        ],

        // Handling of table top (restaurant table) statuses
        ChangeTableTopEvent::class => [
            ChangeTableTopListener::class,
        ],

        // Handling logs of Login,Logout and Failed login attempts
        Login::class => [
            LogAuthenticated::class,
        ],
        Logout::class => [
            LogLogout::class,
        ],
        Failed::class => [
            LogFailedLogin::class,
        ],

        // Whenenver a new payment or arrear has been added into the system
        // The event would update the member`s bill as per the situation
        UpdateMemberBillEvent::class => [
            UpdateMemberBillListener::class,
        ],
        UpdateMemberArrearEvent::class => [
            UpdateMemberArrearListener::class,
        ],
        DiscountedMembershipFeeEvent::class => [
            DiscountedMembershipFeeListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
