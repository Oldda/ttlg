<?php
namespace App\Repositories\TbkServices;


use App\Models\Channel;

class ChannelService
{
    //频道主题列表
    public function list($position,$cate)
    {
        return (new Channel())
            ->where('status',1)
            ->where('position',$position)
            ->where('cate',$cate)
            ->whereDate('start_time','<=',date('Y-m-d'))
            ->whereDate('end_time','>=',date('Y-m-d'))
            ->orderBy('sort','asc')
            ->get();
    }
}