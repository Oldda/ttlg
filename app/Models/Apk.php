<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Apk extends Model
{
    protected $table = 'appversion';

    const CREATED_AT = 'create_time';

    protected $guarded = [
        'create_time'
    ];
    protected $hidden = [
        'id','create_time'
    ];
}
