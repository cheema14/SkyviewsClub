<?php

namespace App\Providers;

use App\Events\ChangeTableTopEvent;
use App\Events\PrintKitchenReceiptEvent;
use App\Events\PrintUpdatedKitchenReceiptEvent;
use App\Listeners\ChangeTableTopListener;
use App\Listeners\PrintKitchenReceiptListener;
use App\Listeners\PrintUpdatedKitchenReceiptListener;
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
