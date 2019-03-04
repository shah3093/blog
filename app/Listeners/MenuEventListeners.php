<?php

namespace App\Listeners;

use App\Events\MenuEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Cache;

class MenuEventListeners
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  MenuEvent  $event
     * @return void
     */
    public function handle(MenuEvent $event)
    {
        Cache::forget('menus');
    }
}
