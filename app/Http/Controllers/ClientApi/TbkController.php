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

    /**
     * @SWG\Get(
     *     path="/optimus_material",
     *     summary="淘宝客物料下行-导购",
     *     tags={"淘宝客相关接口"},
     *     description="淘宝客物料下行-导购",
     *     operationId="optimus_material",
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
     *         name="material_id",
     *         in="path",
     *         description="官方的物料Id(详细物料id见：https://tbk.bbs.taobao.com/detail.html?appId=45301&postId=8576096)",
     *         required=true,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="device_value",
     *         in="path",
     *         description="智能匹配-设备号加密后的值（MD5加密需32位小写）",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="device_encrypt",
     *         in="path",
     *         description="智能匹配-设备号加密类型：MD5",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="device_type",
     *         in="path",
     *         description="智能匹配-设备号类型：IMEI，或者IDFA，或者UTDID（UTDID不支持MD5加密）",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="content_id",
     *         in="path",
     *         description="内容专用-内容详情ID",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="content_source",
     *         in="path",
     *         description="内容专用-内容渠道信息",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="item_id",
     *         in="path",
     *         description="商品ID，用于相似商品推荐",
     *         required=false,
     *         type="integer",
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
    public function optimusMaterial()
    {
        $input = request()->all();
        $input['limit'] = request('limit',8);
        $input['page'] = request('page',1);
        if (!isset($input['material_id'])){
            return ApiReturn::handle('PARAMETER_LOST');
        }
        return ApiReturn::handle('SUCCESS',$this->tbkApi->optimusMaterial($input),$input['limit'],$input['page']);
    }
}
