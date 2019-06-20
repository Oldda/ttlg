<?php

namespace App\Http\Controllers;

use App\Events\UserBrowseEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class TestController extends Controller
{
    //首页
    public function test()
    {

        //参数 imei 设备号 browse_page ，browse_info，request_time，request_url，operating_system操作系统，phone_type手机型号
        event(new UserBrowseEvent('ox12344ezd','首页','','http://www.test.cn','andriod','小米4C'));
    }
}
