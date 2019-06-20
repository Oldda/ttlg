<?php

namespace App\Http\Controllers;

use App\Events\UserBrowseEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class TestController extends Controller
{
    public function test()
    {
        event(new UserBrowseEvent(3,4,5));
    }
}
