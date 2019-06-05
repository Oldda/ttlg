<?php

namespace App\Http\Controllers\ClientApi;

use App\Facades\ApiReturn;
use App\Repositories\TbkServices\BannerService;
use App\Repositories\TbkServices\CatService;
use App\Repositories\TbkServices\ChannelService;
use App\Repositories\TbkServices\ProductService;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    private $bannerService;
    private $catService;
    private $channelService;
    private $productService;
    public function __construct(CatService $catService, BannerService $bannerService, ChannelService $channelService, ProductService $productService)
    {
        $this->catService = $catService;
        $this->bannerService = $bannerService;
        $this->channelService = $channelService;
        $this->productService = $productService;
    }

    /**
     * @SWG\Get(
     *     path="/index/{limit}/{page}",
     *     summary="app首页整合数据",
     *     tags={"首页相关接口"},
     *     description="app首页整合数据，分类，轮播，频道，产品列表",
     *     operationId="account_index",
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
    public function index($limit=8,$page=1)
    {
        $data = array();
        $data['cat'] = $this->catService->list(); //分类
        $data['banner'] = $this->bannerService->list(); //banner图
        $data['channel'] = $this->channelService->list();//频道
        $data['productList'] = $this->productService->search('',$limit,$page);
        return ApiReturn::handle('SUCCESS',$data,$limit,$page);
    }
}
