<?php
namespace App\Repositories\TbkServices;


use App\Models\Channel;

class ChannelService
{
    public function list($position)
    {
        return (new Channel())
            ->where('status',1)
            ->where('position',$position)
            ->whereDate('start_time','<=',date('Y-m-d'))
            ->whereDate('end_time','>=',date('Y-m-d'))
            ->orderBy('sort','asc')
            ->get();
    }
}