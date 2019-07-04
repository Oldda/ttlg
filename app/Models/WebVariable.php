<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebVariable extends Model
{
    protected $table = 'us';

    const CREATED_AT = 'create_time';

    protected $guarded = [
        'create_time'
    ];
    protected $hidden = [
        'id','create_time'
    ];
}
