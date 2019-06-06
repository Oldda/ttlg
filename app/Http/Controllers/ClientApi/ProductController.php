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
     *         name="keyword",
     *         in="path",
     *         description="搜索关键词",
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
    public function search()
    {
        $limit = request('limit',$this->limit);
        $page = request('page',$this->page);
        $keyword = request('keyword','');
        $cat = request('cat','');
        $data = $this->productService->search($keyword,$cat,$limit,$page);
        return ApiReturn::handle('SUCCESS',$data,$limit,$page);
    }

    /**
     * @SWG\Get(
     *     path="/product/show/{item_id}/{coupon_id}",
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
    public function show($item_id,$coupon_id)
    {
        $data = $this->productService->show($item_id);
        $data->coupon = $this->productService->coupon($item_id,$coupon_id);
        return ApiReturn::handle('SUCCESS',$data);
    }
}
