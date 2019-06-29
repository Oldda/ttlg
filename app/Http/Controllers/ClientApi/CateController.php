<?php

namespace App\Http\Controllers\ClientApi;

use App\Facades\ApiReturn;
use App\Repositories\TbkServices\CatService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CateController extends Controller
{
    private $catService;
    public function __construct(CatService $catService)
    {
        $this->catService = $catService;
    }

    /**
     * @SWG\Get(
     *     path="/cat_list",
     *     summary="获取全部分类以及子分类",
     *     tags={"分类相关接口"},
     *     description="获取全部分类以及子分类",
     *     operationId="cat_list",
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
        return ApiReturn::handle('SUCCESS',$this->catService->list());
    }
}
