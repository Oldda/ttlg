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
    private $limit = 8;
    private $page = 1;
    public function __construct(CatService $catService, BannerService $bannerService, ChannelService $channelService, ProductService $productService)
    {
        parent::__construct();
        $this->catService = $catService;
        $this->bannerService = $bannerService;
        $this->channelService = $channelService;
        $this->productService = $productService;
    }

    /**
     * @SWG\Get(
     *     path="/index",
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
    public function index()
    {
        $input = [
            'limit' => request('limit',$this->limit),
            'page'  => request('page',$this->page)
        ];
        $data = array();
        $data['cat'] = $this->catService->list(); //分类
        $data['banner'] = $this->bannerService->list(1); //banner图
        $data['channel'] = $this->channelService->list();//频道
        $data['productList'] = $this->productService->search($input);
        return ApiReturn::handle('SUCCESS',$data,$input['limit'],$input['page']);
    }

    /**
     * @SWG\Get(
     *     path="/theme",
     *     summary="618主题页",
     *     tags={"首页相关接口"},
     *     description="618主题活动页面数据",
     *     operationId="theme_index",
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
    public function theme()
    {
        $input = [
            'limit' => request('limit',$this->limit),
            'page' => request('limit',$this->page),
            'sort' => 'total_sales_des',
            'keyword' => '618',
            'has_coupon' => 'true'
        ];
        $data = array(
            'banner' => $this->bannerService->list(2), //banner图
            'productList' => $this->productService->search($input)
        );

        return ApiReturn::handle('SUCCESS',$data,$input['limit'],$input['page']);
    }
}
