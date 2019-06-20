<?php

namespace App\Listeners;

use App\Events\UserBrowseEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserBrowseListener implements ShouldQueue
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
     * @param  UserBrowseEvent  $event
     * @return void
     */
    public function handle(UserBrowseEvent $event)
    {
        //存储浏览日志
        dd($event->user_id2);
    }
}
