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

    /**
     * @SWG\Get(
     *     path="/item_get",
     *     summary="淘宝客商品查询",
     *     tags={"淘宝客相关接口"},
     *     description="淘宝客商品查询",
     *     operationId="item_get",
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
     *     @SWG\Parameter(
     *         name="itemloc",
     *         in="path",
     *         description="所在地",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="sort",
     *         in="path",
     *         description="排序_des（降序），排序_asc（升序），销量（total_sales），淘客佣金比率（tk_rate）， 累计推广量（tk_total_sales），总支出佣金（tk_total_commi）",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="is_tmall",
     *         in="path",
     *         description="是否商城商品，设置为true表示该商品是属于淘宝商城商品，设置为false或不设置表示不判断这个属性",
     *         required=false,
     *         type="boolean",
     *     ),
     *     @SWG\Parameter(
     *         name="is_overseas",
     *         in="path",
     *         description="是否海外商品，设置为true表示该商品是属于海外商品，设置为false或不设置表示不判断这个属性",
     *         required=false,
     *         type="boolean",
     *     ),
     *     @SWG\Parameter(
     *         name="start_price",
     *         in="path",
     *         description="折扣价范围下限，单位：元",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="end_price",
     *         in="path",
     *         description="折扣价范围上限，单位：元",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="start_tk_rate",
     *         in="path",
     *         description="淘客佣金比率上限，如：1234表示12.34%",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="end_tk_rate",
     *         in="path",
     *         description="淘客佣金比率下限，如：1234表示12.34%",
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
    public function itemGet()
    {
        $input = request()->all();
        $input['limit'] = request('limit',8);
        $input['page'] = request('page',1);
        return ApiReturn::handle('SUCCESS',$this->tbkApi->itemGet($input),$input['limit'],$input['page']);
    }

    /**
     * @SWG\Get(
     *     path="/recommend_get",
     *     summary="淘宝客商品关联推荐查询",
     *     tags={"淘宝客相关接口"},
     *     description="淘宝客商品关联推荐查询",
     *     operationId="recommend_get",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="limit",
     *         in="path",
     *         description="每页显示的条数,默认8条",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="num_iid",
     *         in="path",
     *         description="商品Id",
     *         required=true,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="platform",
     *         in="path",
     *         description="链接形式：1：PC，2：无线，默认：１",
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
    public function recommendGet()
    {
        $input = request()->all();
        $input['limit'] = request('limit',8);
        if (!isset($input['num_iid'])){
            return ApiReturn::handle('PARAMETER_LOST');
        }
        return ApiReturn::handle('SUCCESS',$this->tbkApi->recommendGet($input),$input['limit']);
    }

    /**
     * @SWG\Get(
     *     path="/item_info_get",
     *     summary="淘宝客商品详情（简版）",
     *     tags={"淘宝客相关接口"},
     *     description="淘宝客商品详情（简版）",
     *     operationId="item_info_get",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="ip",
     *         in="path",
     *         description="ip地址，影响邮费获取，如果不传或者传入不准确，邮费无法精准提供,
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="num_iid",
     *         in="path",
     *         description="商品ID串，用,分割，最大40个",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="platform",
     *         in="path",
     *         description="链接形式：1：PC，2：无线，默认：１",
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
    public function itemInfoGet()
    {
        $input = request()->all();
        $input['item_id'] = request('num_iid','');
        if (!isset($input['item_id'])){
            return ApiReturn::handle('PARAMETER_LOST');
        }
        return ApiReturn::handle('SUCCESS',$this->tbkApi->show($input));
    }

    /**
     * @SWG\Get(
     *     path="/shop_get",
     *     summary="淘宝客店铺查询",
     *     tags={"淘宝客相关接口"},
     *     description="淘宝客店铺查询",
     *     operationId="shop_get",
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
     *         name="keyword",
     *         in="path",
     *         description="搜索关键词",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="is_tmall",
     *         in="path",
     *         description="商品筛选-是否天猫商品。true表示属于天猫商品，false或不设置表示不限",
     *         required=false,
     *         type="boolean",
     *     ),
     *     @SWG\Parameter(
     *         name="sort",
     *         in="path",
     *         description="排序_des（降序），排序_asc（升序），销量（total_sales），淘客佣金比率（tk_rate）， 累计推广量（tk_total_sales），总支出佣金（tk_total_commi），价格（price）",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="start_credit",
     *         in="path",
     *         description="信用等级下限，1~20",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="end_credit",
     *         in="path",
     *         description="信用等级上限，1~20",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="start_commission_rate",
     *         in="path",
     *         description="淘客佣金比率下限，1~10000",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="end_commission_rate",
     *         in="path",
     *         description="淘客佣金比率上限，1~10000",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="start_total_action",
     *         in="path",
     *         description="店铺商品总数下限",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="end_total_action",
     *         in="path",
     *         description="店铺商品总数上限",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="start_auction_count",
     *         in="path",
     *         description="累计推广商品下限",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="end_auction_count",
     *         in="path",
     *         description="累计推广商品上限",
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
    public function shopGet()
    {
        $input = request()->all();
        $input['limit'] = request('limit',8);
        $input['page'] = request('page',1);
        if (!isset($input['keyword'])){
            return ApiReturn::handle('PARAMETER_LOST');
        }
        return ApiReturn::handle('SUCCESS',$this->tbkApi->shopGet($input),$input['limit'],$input['page']);
    }

    /**
     * @SWG\Get(
     *     path="/shop_recommend_get",
     *     summary="淘宝客店铺关联推荐查询",
     *     tags={"淘宝客相关接口"},
     *     description="淘宝客店铺关联推荐查询",
     *     operationId="shop_recommend_get",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="user_id",
     *         in="path",
     *         description="卖家Id",
     *         required=true,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="limit",
     *         in="path",
     *         description="返回数量，默认8，最大值40",
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
    public function shopRecommendGet()
    {
        $input = request()->all();
        $input['limit'] = request('limit',8);
        if (!isset($input['user_id'])){
            return ApiReturn::handle('PARAMETER_LOST');
        }
        return ApiReturn::handle('SUCCESS',$this->tbkApi->shopRecommendGet($input),$input['limit']);
    }

    /**
     * @SWG\Get(
     *     path="/favorites_item_get",
     *     summary="获取淘宝联盟选品库的宝贝信息",
     *     tags={"淘宝客相关接口"},
     *     description="获取淘宝联盟选品库的宝贝信息",
     *     operationId="favorites_item_get",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="favorites_id",
     *         in="path",
     *         description="选品库的id",
     *         required=true,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="unid",
     *         in="path",
     *         description="自定义输入串，英文和数字组成，长度不能大于12个字符，区分不同的推广渠道",
     *         required=false,
     *         type="string",
     *     ),
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
    public function favoritesItemGet()
    {
        $input = request()->all();
        $input['limit'] = request('limit',8);
        $input['page'] = request('page',1);
        if (!isset($input['favorites_id'])){
            return ApiReturn::handle('PARAMETER_LOST');
        }
        return ApiReturn::handle('SUCCESS',$this->tbkApi->favoritesItemGet($input),$input['limit'],$input['page']);
    }

    /**
     * @SWG\Get(
     *     path="/uatm_favorites_get",
     *     summary="获取淘宝联盟选品库列表",
     *     tags={"淘宝客相关接口"},
     *     description="获取淘宝联盟选品库列表",
     *     operationId="uatm_favorites_get",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="type",
     *         in="path",
     *         description="默认值-1；选品库类型，1：普通选品组，2：高佣选品组，-1，同时输出所有类型的选品组",
     *         required=true,
     *         type="integer",
     *     ),
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
    public function uatmFavoritesGet()
    {
        $input = request()->all();
        $input['limit'] = request('limit',8);
        $input['page'] = request('page',1);
        if (!isset($input['type'])){
            return ApiReturn::handle('PARAMETER_LOST');
        }
        return ApiReturn::handle('SUCCESS',$this->tbkApi->uatmFavoritesGet($input),$input['limit'],$input['page']);
    }

    /**
     * @SWG\Get(
     *     path="/uatm_favorites_get",
     *     summary="获取淘宝联盟选品库列表",
     *     tags={"淘宝客相关接口"},
     *     description="获取淘宝联盟选品库列表",
     *     operationId="uatm_favorites_get",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="start_time",
     *         in="path",
     *         description="最早开团时间",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="end_time",
     *         in="path",
     *         description="最晚开团时间",
     *         required=true,
     *         type="string",
     *     ),
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
    public function juTqgGet()
    {
        $input = request()->all();
        $input['limit'] = request('limit',8);
        $input['page'] = request('page',1);
        if (!isset($input['start_time']) || !isset($input['end_time'])){
            return ApiReturn::handle('PARAMETER_LOST');
        }
        return ApiReturn::handle('SUCCESS',$this->tbkApi->juTqgGet($input),$input['limit'],$input['page']);
    }

    /**
     * @SWG\Get(
     *     path="/item_guess_like",
     *     summary="淘宝客商品猜你喜欢",
     *     tags={"淘宝客相关接口"},
     *     description="淘宝客商品猜你喜欢",
     *     operationId="item_guess_like",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="user_nick",
     *         in="path",
     *         description="用户昵称，from cookie : _nk_或者tracknick ; from百川sdk : nick",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="user_id",
     *         in="path",
     *         description="用户数字ID，from cookie : unb",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="os",
     *         in="path",
     *         description="系统类型，ios, android, other",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="idfa",
     *         in="path",
     *         description="os广告跟踪id",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="imei",
     *         in="path",
     *         description="android设备imei",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="apnm",
     *         in="path",
     *         description="应用包名",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="net",
     *         in="path",
     *         description="联网方式，wifi, cell, unknown",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="imei_md5",
     *         in="path",
     *         description="android设备imeiMD5值，32位小写",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="mn",
     *         in="path",
     *         description="设备型号",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="limit",
     *         in="path",
     *         description="页大小",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="page",
     *         in="path",
     *         description="第几页",
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
    public function itemGuessLike()
    {
        $input = request()->all();
        $input['limit'] = request('limit',8);
        $input['page'] = request('page',1);
        if (!isset($input['net']) || !isset($input['os'])){
            return ApiReturn::handle('PARAMETER_LOST');
        }
        return ApiReturn::handle('SUCCESS',$this->tbkApi->itemGuessLike($input));
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
