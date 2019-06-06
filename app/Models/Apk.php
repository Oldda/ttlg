<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Apk extends Model
{
    protected $table = 'appversion';

    const CREATED_AT = 'create_time';

    protected $guarded = [
        'create_time','update_time'
    ];
    protected $hidden = [
        'id','create_time','update_time'
    ];

    /**
     * 访问器-下载路径拼接
     *
     * @param  string  $value
     * @return string
     */
    public function getDownloadurlAttribute($value)
    {
        return request()->server('SERVER_NAME').$value;
    }
}
