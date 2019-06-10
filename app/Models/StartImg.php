<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StartImg extends Model
{
    protected $table = 'start_img';

    const CREATED_AT = 'create_time';

    protected $guarded = [
        'create_time','update_time'
    ];
    protected $hidden = [
        'id','create_time','update_time'
    ];
}
