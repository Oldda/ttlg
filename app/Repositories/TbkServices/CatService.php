<?php
namespace App\Repositories\TbkServices;

use App\Models\Category;

class CatService
{
    public function list($type=0)
    {
        return (new Category())
            ->with('allChildrenCategorys')
            ->where('parent_cid',0)
            ->where('status',1)
            ->where('type',$type)
            ->orderBy('sort','asc')
            ->get();
    }
}