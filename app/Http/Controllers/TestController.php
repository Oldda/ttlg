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
        //其他的逻辑-加入监听
        event(new UserBrowseEvent(3,4,5));
    }
}
