<?php

namespace App\Http\Controllers\ClientApi;

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
     *         name="item_id",
     *         in="path",
     *         description="商品id",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *        name="coupon_id",
     *         in="path",
     *         description="优惠券id",
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
        $item_id = request('item_id','');
        $coupon_id = request('coupon_id','');
        if (empty($item_id) || empty($coupon_id)){
            return ApiReturn::handle('PARAMETER_LOST');
        }
        $data = $this->productService->show($item_id);
        $data->coupon = $this->productService->coupon($item_id,$coupon_id);
        return ApiReturn::handle('SUCCESS',$data);
    }
}
