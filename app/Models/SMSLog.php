<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SMSLog extends Model
{
    protected $table = 'sms_log';

    const CREATED_AT = 'create_time';

    protected $guarded = [
        'create_time','update_time'
    ];
    protected $hidden = [
        'id','create_time','update_time'
    ];
}
