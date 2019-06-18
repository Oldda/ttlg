<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DownloadImg extends Model
{
    protected $table = 'h5img';

    const CREATED_AT = 'create_time';

    const UPDATED_AT = 'update_time';

    protected $guarded = [
        'create_time','update_time'
    ];
}
