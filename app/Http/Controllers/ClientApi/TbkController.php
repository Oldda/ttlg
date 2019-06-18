<?php

namespace App\Http\Controllers\ClientApi;

use App\Facades\ApiReturn;
use App\Repositories\TbkServices\ProductService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TbkController extends Controller
{
    private $tbkApi;

    public function __construct(ProductService $tbkApi)
    {
        $this->tbkApi = $tbkApi;
    }

    //淘宝客商品查询
    public function itemGet()
    {
        return ApiReturn::handle('SUCCESS',$this->tbkApi->itemGet());
    }
}
