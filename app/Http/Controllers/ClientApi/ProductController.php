<?php

namespace App\Http\Controllers\ClientApi;

use App\Events\UserBrowseEvent;
use App\Facades\ApiReturn;
use App\Repositories\TbkServices\ProductService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    private $productService;
    private $limit = 8;
    private $page = 1;

    public function __construct(ProductService $productService)
    {
        parent::__construct();
        $this->productService = $productService;
    }

    /**
     * @SWG\Get(
     *     path="/product/search",
     *     summary="搜索产品",
     *     tags={"商品相关接口"},
     *     description="搜索产品",
     *     operationId="account_index",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="imei",
     *         in="header",
     *         description="设备号",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="operating_system",
     *         in="header",
     *         description="操作系统",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="phone_type",
     *         in="header",
     *         description="机型-型号",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="start_dsr",
     *         in="path",
     *         description="商品筛选(特定媒体支持)-店铺dsr评分。筛选大于等于当前设置的店铺dsr评分的商品0-50000之间",
     *         required=false,
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
     *     @SWG\Parameter(
     *         name="platform",
     *         in="path",
     *         description="链接形式：1：PC，2：无线，默认：１",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="end_tk_rate",
     *         in="path",
     *         description="商品筛选-淘客佣金比率上限。如：1234表示12.34%",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="start_tk_rate",
     *         in="path",
     *         description="商品筛选-淘客佣金比率下限。如：1234表示12.34%",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="end_price",
     *         in="path",
     *         description="商品筛选-折扣价范围上限。单位：元",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="start_price",
     *         in="path",
     *         description="商品筛选-折扣价范围下限。单位：元",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="is_overseas",
     *         in="path",
     *         description="商品筛选-是否海外商品。true表示属于海外商品，false或不设置表示不限",
     *         required=false,
     *         type="boolean",
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
     *         name="itemloc",
     *         in="path",
     *         description="商品筛选-所在地 如 杭州",
     *         required=false,
     *         type="string",
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
     *         name="has_coupon",
     *         in="path",
     *         description="优惠券筛选-是否有优惠券。true表示该商品有优惠券，false或不设置表示不限",
     *         required=false,
     *         type="boolean",
     *     ),
     *     @SWG\Parameter(
     *         name="need_free_shipment",
     *         in="path",
     *         description="商品筛选-是否包邮。true表示包邮，false或不设置表示不限",
     *         required=false,
     *         type="boolean",
     *     ),
     *     @SWG\Parameter(
     *         name="need_prepay",
     *         in="path",
     *         description="商品筛选-是否加入消费者保障。true表示加入，false或不设置表示不限",
     *         required=false,
     *         type="boolean",
     *     ),
     *     @SWG\Parameter(
     *         name="include_pay_rate_30",
     *         in="path",
     *         description="商品筛选(特定媒体支持)-成交转化是否高于行业均值。True表示大于等于，false或不设置表示不限",
     *         required=false,
     *         type="boolean",
     *     ),
     *     @SWG\Parameter(
     *         name="include_good_rate",
     *         in="path",
     *         description="商品筛选-好评率是否高于行业均值。True表示大于等于，false或不设置表示不限",
     *         required=false,
     *         type="boolean",
     *     ),
     *     @SWG\Parameter(
     *         name="include_rfd_rate",
     *         in="path",
     *         description="品筛选(特定媒体支持)-退款率是否低于行业均值。True表示大于等于，false或不设置表示不限",
     *         required=false,
     *         type="boolean",
     *     ),
     *     @SWG\Parameter(
     *         name="npx_level",
     *         in="path",
     *         description="商品筛选-牛皮癣程度。取值：1不限，2无，3轻微,默认2",
     *         required=false,
     *         type="boolean",
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
    public function search()
    {
        $input = request()->all();
        $input['limit'] = request('limit',$this->limit);
        $input['page'] = request('page',$this->page);
        $data = $this->productService->search($input);
        if (isset($input['cat'])){
            event(new UserBrowseEvent(
                request()->header('imei',''),
                '分类页',
                \request('cat',''),
                request()->url(),
                request()->header('operating_system',''),
                request()->header('phone_type','')
            ));
        }
        if (isset($input['keyword'])){
            event(new UserBrowseEvent(
                request()->header('imei',''),
                '搜索页',
                \request('keyword',''),
                request()->url(),
                request()->header('operating_system',''),
                request()->header('phone_type','')
            ));
        }
        return ApiReturn::handle('SUCCESS',$data,$input['limit'],$input['page']);
    }

    /**
     * @SWG\Get(
     *     path="/product/show",
     *     summary="商品详情",
     *     tags={"商品相关接口"},
     *     description="商品详情",
     *     operationId="account_index",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="imei",
     *         in="header",
     *         description="设备号",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="operating_system",
     *         in="header",
     *         description="操作系统",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="phone_type",
     *         in="header",
     *         description="机型-型号",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="item_id",
     *         in="path",
     *         description="商品id",
     *         required=true,
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
    public function show()
    {
        $input = request()->all();
        $input['item_id'] = request('item_id','');
        if (empty($input['item_id'])){
            return ApiReturn::handle('PARAMETER_LOST');
        }
        $data = $this->productService->getDetail($input['item_id']);
        $data['base'] = $this->productService->show($input);
        event(new UserBrowseEvent(
            request()->header('imei',''),
            '详情页',
            $data['base']->num_iid.'_'.$data['base']->title,
            request()->url(),
            request()->header('operating_system',''),
            request()->header('phone_type','')
        ));
        return ApiReturn::handle('SUCCESS',$data);
    }

    /**
     * @SWG\Get(
     *     path="/get_coupon_from_item",
     *     summary="通过商品id搜券的信息和商品信息",
     *     tags={"商品相关接口"},
     *     description="通过商品id搜券的信息和商品信息",
     *     operationId="get_coupon_from_item",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="paste",
     *         in="path",
     *         description="粘贴板里商品的内容，建议判断是否合法内容，不是所有粘贴板内容都请求服务器",
     *         required=true,
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
    public function getCouponFromItemId()
    {
        //解析粘贴板的内容
        $str = request('paste','');
        if ($str === ''){
            return ApiReturn::handle('PARAMETER_LOST');
        }
        if (strpos($str,'https://') === false){
            return ApiReturn::handle('PARAMETER_ERROR');
        }
        //获取短连接
        $start = stripos($str,'https://');
        $end = stripos($str,'点击链接');
        $url = substr($str,$start,$end-$start);
        //获取链接页面内容
        $out = file_get_contents($url);
        $startC = stripos($out,"&id=");
        $endC = stripos($out,"&sourceType=");
        //获取商品id
        $item_id = substr($out,$startC + 4,$endC - $startC - 4);
        if ((int)$item_id <= 1){
            return ApiReturn::handle('PARAMETER_ERROR');
        }
        //获取商品信息
        $product = $this->productService->show(['item_id'=>$item_id]);
        if (get_object_vars($product) === []){
            return ApiReturn::handle('NOT_FOUND_ERROR');
        }
        //搜索物料
        $detail = $this->productService->search([
            'keyword' => $product->title
        ]);
        if ($detail != []){
            foreach ($detail as $value){
                if ($value->item_id == $item_id){
                    return ApiReturn::handle('SUCCESS',$value);
                }
            }
        }
        return ApiReturn::handle('COUPON_MISSING');
    }
}
