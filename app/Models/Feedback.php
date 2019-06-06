<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedback';

    const CREATED_AT = 'create_time';

    const UPDATED_AT = 'update_time';

    protected $guarded = [
        'create_time','update_time'
    ];

    //和用户表的关联关系
    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }
}
