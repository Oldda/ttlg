<?php

namespace App\Http\Controllers\ClientApi;

use App\Facades\ApiReturn;
use App\Repositories\TbkServices\ProductService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * @SWG\Get(
     *     path="/product/search/{keyword}/{limit}/{page}",
     *     summary="搜索产品",
     *     tags={"商品相关接口"},
     *     description="搜索产品",
     *     operationId="account_index",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="keyword",
     *         in="path",
     *         description="搜索关键词",
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
    public function search($keyword='', $limit=8, $page=1)
    {
        if (!empty($keyword)){
            $data = $this->productService->search($keyword,$limit,$page);
            return ApiReturn::handle('SUCCESS',$data);
        }
        return ApiReturn::handle('PARAMETER_LOST');
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
