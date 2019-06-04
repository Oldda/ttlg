<?php

namespace App\Providers;

use App\Interfaces\ApiReturnInterface;
use App\Tools\ApiReturn;
use Illuminate\Support\ServiceProvider;

class CustomProvider extends ServiceProvider
{
    protected $defer = true;
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //API接口返回格式
        $this->app->singleton(ApiReturnInterface::class,ApiReturn::class);
    }

    public function provides()
    {
        return [
            ApiReturnInterface::class,
        ];
    }
}
