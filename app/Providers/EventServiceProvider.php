<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\PostEvent' => [
            'App\Listeners\PostEventListeners',
            'App\Listeners\SidebarEventListeners',
        ],
        'App\Events\MenuEvent' => [
            'App\Listeners\MenuEventListeners',
        ],
        'App\Events\SidebarEvent' => [
            'App\Listeners\SidebarEventListeners',
        ],
        'App\Events\SeriesEvent' => [
            'App\Listeners\SeriesEventListeners',
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
