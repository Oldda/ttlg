<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Apk extends Model
{
    protected $table = 'appversion';

    const CREATED_AT = 'create_time';

    const UPDATED_AT = 'update_time';

    protected $guarded = [
        'create_time','update_time'
    ];
}
