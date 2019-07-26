<?php

namespace App\Listeners;

use App\Events\UserLocationEvent;
use App\Models\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserLocationListener implements ShouldQueue
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
     * @param  UserLocationEvent  $event
     * @return void
     */
    public function handle(UserLocationEvent $event)
    {
        $user_id = $event->user_id;
        $ip = $event->ip;
        $location = '本地';
        if ($ip !== '127.0.0.1'){
            $location = $this->getPosition($ip);
        }
        if ($location && !empty($location)){
            $user = (new User())->find($user_id);
            $user->location = $location;
            $user->save();
        }
    }

    //根据ip获取方位
    private function getPosition($ip)
    {
        $url="http://ip.taobao.com/service/getIpInfo.php?ip=".$ip;
        $ipinfo=json_decode(file_get_contents($url));
        if($ipinfo->code=='1'){
            return false;
        }
        $city = $ipinfo->data->region.$ipinfo->data->city;
        return $city;
    }
}
