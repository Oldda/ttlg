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
        $input = request()->all();
        $input['limit'] = request('limit',8);
        $input['page'] = request('page',1);
        return ApiReturn::handle('SUCCESS',$this->tbkApi->itemGet($input),$input['limit'],$input['page']);
    }

    /**
     * @SWG\Get(
     *     path="/coupon_get",
     *     summary="好券清单API【导购】",
     *     tags={"淘宝客相关接口"},
     *     description="好券清单API【导购】",
     *     operationId="coupon_get",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="limit",
     *         in="path",
     *         description="每页显示的条数,默认8条",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="page",
     *         in="path",
     *         description="页码，默认为第1页",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="platform",
     *         in="path",
     *         description="链接形式：1：PC，2：无线，默认：１",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="cat",
     *         in="path",
     *         description="类目的id,多个用','分割",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="keyword",
     *         in="path",
     *         description="搜索关键词",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="SUCCESS"
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="详见错误附件",
     *     )
     * )
     */
    public function couponGet()
    {
        $input = request()->all();
        $input['limit'] = request('limit',8);
        $input['page'] = request('page',1);
        return ApiReturn::handle('SUCCESS',$this->tbkApi->couponGet($input),$input['limit'],$input['page']);
    }
}
