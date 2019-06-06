<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginLog extends Model
{
    protected $table = 'login_log';

    const CREATED_AT = 'create_time';

    const UPDATED_AT = 'update_time';

    protected $guarded = [
        'create_time','update_time'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }
}
