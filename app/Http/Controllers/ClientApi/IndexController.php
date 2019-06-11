<?php

namespace App\Http\Controllers\ClientApi;

use App\Facades\ApiReturn;
use App\Models\Guide;
use App\Models\StartImg;
use App\Models\Theme;
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
            'page'  => request('page',$this->page),
        ];
        $data = array();
        $data['cat'] = $this->catService->list(); //分类
        $data['banner'] = $this->bannerService->list('index'); //banner图
        $data['channel'] = $this->channelService->list('index');//频道
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
     *         name="theme_id",
     *         in="path",
     *         description="主题的id",
     *         required=true,
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
        $theme_id = request('theme_id','');
        $limit = request('limit',8);
        $page = request('page',1);
        if (empty($theme_id)){
            return ApiReturn::handle('PARAMETER_LOST');
        }
        $theme = (new Theme())->find($theme_id);
        if (!$theme){
            return ApiReturn::handle('NOT_FOUND_ERROR');
        }
        if ($theme->status != 1){
            return ApiReturn::handle('THEME_ALREADY_DOWN');
        }
        $json = json_decode($theme->select_rule,true);
        if (!$json){
            return ApiReturn::handle('JSON_ERROR');
        }
        $json['limit'] = $limit;
        $json['page'] = $page;
        $data = array(
            'banner' => $this->bannerService->list($theme->banner_position_keyword)->first()??'', //banner图
            'channel' => $this->channelService->list($theme->channel_position_keyword)??'',
            'productList' => $this->productService->search($json)
        );
        return ApiReturn::handle('SUCCESS',$data);
    }

    /**
     * @SWG\Get(
     *     path="/guide",
     *     summary="引导图",
     *     tags={"首页相关接口"},
     *     description="引导图",
     *     operationId="guide_index",
     *     produces={"application/json"},
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
    public function guideImg()
    {
        $data = (new Guide())->where('status',1)->where('cate',2)->orderBy('sort','desc')->get();
        return ApiReturn::handle('SUCCESS',$data);
    }

    /**
     * @SWG\Get(
     *     path="/start_img",
     *     summary="启动图",
     *     tags={"首页相关接口"},
     *     description="启动图",
     *     operationId="start_img_index",
     *     produces={"application/json"},
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
    public function startImg()
    {
        $data = (new Guide())->where('status',1)->where('cate',1)->orderBy('sort','desc')->first();
        return ApiReturn::handle('SUCCESS',$data);
    }
}
