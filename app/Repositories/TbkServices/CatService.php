<?php
namespace App\Repositories\TbkServices;

use App\Models\Category;

class CatService
{
    public function list()
    {
        return (new Category())->where('parent_cid',0)->where('status',1)->get();
    }
}