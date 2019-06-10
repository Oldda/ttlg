<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guide extends Model
{
    protected $table = 'guide';

    const CREATED_AT = 'create_time';

    protected $guarded = [
        'create_time','update_time'
    ];
    protected $hidden = [
        'id','create_time','update_time'
    ];
}
