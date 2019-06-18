<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DownloadGood extends Model
{
    protected $table = 'h5goods';

    const CREATED_AT = 'create_time';

    const UPDATED_AT = 'update_time';

    protected $guarded = [
        'create_time','update_time'
    ];
}
