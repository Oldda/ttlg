<?php

namespace App\Http\Controllers\ClientApi;

use App\Events\UserBrowseEvent;
use App\Facades\ApiReturn;
use App\Models\Guide;
use App\Models\StartImg;
use App\Models\Theme;
use App\Models\WebVariable;
use App\Repositories\SMSService;
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
    private $sms;
    private $limit = 8;
    private $page = 1;
    public function __construct(CatService $catService, BannerService $bannerService, ChannelService $channelService, ProductService $productService,SMSService $sms)
    {
        parent::__construct();
        $this->catService = $catService;
        $this->bannerService = $bannerService;
        $this->channelService = $channelService;
        $this->productService = $productService;
        $this->sms = $sms;
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
		$cats = [
			'50010850','50000436','50012354','50010540','50006842','1801',
			'50003949','50002766','50006843','50011740','1625','50010788','302910',
			'1705','50002768','50003820','50009146'
		];
		$chose = array_rand($cats,10);
		$str = '';
		for($i=0;$i<10;$i++){
			if($i != 9){
				$str .= $cats[$chose[$i]].',';
			}else{
				$str .= $cats[$chose[$i]];
			}
		}
        $input = [
            'limit' => request('limit',$this->limit),
            'page'  => request('page',$this->page),
			'sort'  => 'total_sales_desc',
			'has_coupon' => 'true',
			'is_tmall' => 'true',
			'need_free_shipment' => 'true',
			'need_prepay' => 'true',
			'include_pay_rate_30' => 'true',
			'include_good_rate' => 'true',
			'start_price' => '9',
			'end_price' => '100',
			'cat' => '16,30,50008165,1801,21,50002766,50006843,50010788,50011740,35',
			'npx_level' => 2,
//            'material_id' => 3756
        ];
        $data = array();
        $data['cat'] = $this->catService->list(); //分类
        $data['banner'] = $this->bannerService->list('index'); //banner图
        $data['channel'] = $this->channelService->list('index',1);//频道
        $data['productList'] = $this->productService->search($input);
        return ApiReturn::handle('SUCCESS',$data,$input['limit'],$input['page']);
    }
    /**
     * @SWG\Get(
     *     path="/list",
     *     summary="app首页整合数据 material版",
     *     tags={"首页相关接口"},
     *     description="app首页整合数据 material版",
     *     operationId="list",
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
    public function list()
    {
        $input = [
            'limit' => request('limit',$this->limit),
            'page'  => request('page',$this->page),
            'sort'  => 'total_sales_desc',
            'has_coupon' => 'true',
            'is_tmall' => 'true',
            'need_free_shipment' => 'true',
            'need_prepay' => 'true',
            'include_pay_rate_30' => 'true',
            'include_good_rate' => 'true',
            'start_price' => '9',
            'end_price' => '100',
            'cat' => '16,30,50008165,1801,21,50002766,50006843,50010788,50011740,35',
            'npx_level' => 2,
            'material_id' => 3756
        ];
        $data = array();
        $data['cat'] = $this->catService->list(1); //获取热门推荐
        $data['banner'] = $this->bannerService->list('index'); //获取轮播图列表
        $data['king_kong'] = $this->channelService->list('index',2);//获取金刚展示位列表
        $data['channel'] = $this->channelService->list('index',1);//获取频道主题列表
        $data['productList'] = $this->productService->search($input);
        event(new UserBrowseEvent(
            request()->header('imei',''),
            '首页',
            '无',
            request()->url(),
            request()->header('operating_system',''),
            request()->header('phone_type','')
        ));
        return ApiReturn::handle('SUCCESS',$data,$input['limit'],$input['page']);
    }
    /**
     * @SWG\Get(
     *     path="/theme",
     *     summary="活动，主题页面数据",
     *     tags={"首页相关接口"},
     *     description="活动，主题页面数据",
     *     operationId="theme_index",
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
        $input = request()->except(['limit','page','template']);
        if (count($input) > 1){
            unset($input['theme_id']);
            $json = request()->except(['theme_id','template']);
        }
        $data = array(
            'banner' => $this->bannerService->list($theme->banner_position_keyword)->first()??new \StdClass(), //banner图
            'channel' => $this->channelService->list($theme->channel_position_keyword,1)??[],
            'productList' => $this->productService->search($json)
        );
        event(new UserBrowseEvent(
            request()->header('imei',''),
            '主题页',
            $theme->title,
            request()->url(),
            request()->header('operating_system',''),
            request()->header('phone_type','')
        ));
        return ApiReturn::handle('SUCCESS',$data,$json['limit'],$json['page']);
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
	
	/**
     * @SWG\Get(
     *     path="/variables",
     *     summary="系统变量",
     *     tags={"首页相关接口"},
     *     description="系统变量",
     *     operationId="index_variables",
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
	 public function variables()
	 {
		 $data = (new WebVariable())->first();
		 if(!$data){
			 return ApiReturn::handle('NOT_FOUND_ERROR');
		 }
		 return ApiReturn::handle('SUCCESS',$data);
	 }
    /**
     * @SWG\Get(
     *     path="/sms",
     *     summary="发送短信",
     *     tags={"首页相关接口"},
     *     description="发送短信",
     *     operationId="sms",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="login-token",
     *         in="header",
     *         description="登录token",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="phone",
     *         in="path",
     *         description="要发送的手机号",
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
    public function sms()
    {
        return $this->sms->sms(request('phone'));
    }
}
