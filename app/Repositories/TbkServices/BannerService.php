<?php
namespace App\Repositories\TbkServices;

use App\Models\Banner;

class BannerService
{
    public function list()
    {
        return (new Banner())
            ->where('status',1)
            ->whereDate('start_time','<=',date('Y-m-d'))
            ->whereDate('end_time','>=',date('Y-m-d'))
            ->orderBy('sort','desc')
            ->get();
    }
}