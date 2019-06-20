<?php

namespace App\Listeners;

use App\Events\UserBrowseEvent;
use App\Models\Statistic;
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
        Statistic::create([
            'imei' => $event->imei,
            'browse_page' => $event->browse_page,
            'browse_info' => $event->browse_info,
            'request_time' => time(),
            'request_url' => $event->request_url,
            'operating_system' => $event->operating_system,
            'phone_type' => $event->phone_type
        ]);
        return true;
    }
}
