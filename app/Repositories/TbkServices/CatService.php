<?php
namespace App\Repositories\TbkServices;

use App\Models\Category;

class CatService
{
    public function list()
    {
        return (new Category())->with('allChildrenCategorys')->where('parent_cid',0)->where('status',1)->orderBy('sort','asc')->get();
    }
}