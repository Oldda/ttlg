<?php

namespace App\Http\Controllers\ClientApi;

use App\Facades\ApiReturn;
use App\Repositories\TbkServices\BannerService;
use App\Repositories\TbkServices\CatService;
use App\Repositories\TbkServices\ChannelService;
use App\Repositories\TbkServices\ProductService;
use Illuminate\Http\Request;
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

    public function index($limit=8,$page=1)
    {
        $data = array();
        $data['cat'] = $this->catService->list(); //分类
        $data['banner'] = $this->bannerService->list(); //banner图
        $data['channel'] = $this->channelService->list();//频道
        $data['productList'] = $this->productService->list($limit,$page);
        return ApiReturn::handle('SUCCESS',$data);
    }

    public function search()
    {

    }
}
