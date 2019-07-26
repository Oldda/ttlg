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
        if ($ip != '127.0.0.1' && $ip != '0.0.0.0'){
            $location = $this->getPosition($ip);
        }
        $user = (new User())->find($user_id);
        $user->location = $location;
        $user->last_ip = $ip;
        $user->nickname = '1234';
        $user->save();
    }

    //根据ip获取方位
    public function getPosition($ip)
    {
        $url="http://api.map.baidu.com/location/ip?ak=7IMM5SGRsCfTPg6MQ8h1lgatiQxEVr6M&ip=".$ip;  // 百度地图地址
        $ipinfo=json_decode(file_get_contents($url));
        if($ipinfo->status!='0'){
            return false;
        }
        $city = $ipinfo->content->address_detail->province.$ipinfo->content->address_detail->city;
        return $city;
    }
}
