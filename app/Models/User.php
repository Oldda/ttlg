<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'user';

    const CREATED_AT = 'create_time';

    const UPDATED_AT = 'update_time';

    protected $guarded = [
        'create_time','update_time'
    ];

    protected $hidden = [
        'id','create_time','update_time'
    ];

    /**
     * 修改器-昵称
     *
     * @param  string  $value
     * @return string
     */
    public function setNicknameAttribute($value)
    {
        $this->attributes['nickname'] = base64_encode($value);
    }
    /**
     * 访问器-昵称
     *
     * @param  string  $value
     * @return string
     */
    public function getNicknameAttribute($value)
    {
        return base64_decode($value);
    }

    //和登录信息的关联关系
    public function loginInfos()
    {
        return $this->hasMany('App\Models\LoginInfo','user_id');
    }
    //和反馈信息的关联关系
    public function feedbacks()
    {
        return $this->hasMany('App\Models\Feedback','user_id');
    }
    //和登录日志的关联关系
    public function loginLogs()
    {
        return $this->hasMany('App\Models\LoginLog','user_id');
    }
}
