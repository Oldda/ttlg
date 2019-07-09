<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'cat';

    const CREATED_AT = 'create_time';

    const UPDATED_AT = 'update_time';

    protected $guarded = [
        'create_time','update_time'
    ];

    public function childCategory() {
        return $this->hasMany('App\Models\Category', 'parent_cid', 'id');
    }

    public function allChildrenCategorys()
    {
        return $this->childCategory()->where('status',1)->with('allChildrenCategorys');
    }

    /**
     * 访问器-七牛雲圖片
     *
     * @param  string  $value
     * @return string
     */
    public function getImgAttribute($value)
    {
        return 'http://img.wukehui.cn'.$value;
    }
}
