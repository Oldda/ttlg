<?php
namespace App\Facades;

use App\Interfaces\ApiReturnInterface;
use Illuminate\Support\Facades\Facade;


class ApiReturn extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ApiReturnInterface::class;
    }
}