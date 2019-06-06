<?php

namespace App\Http\Controllers\ClientApi;

use App\Facades\ApiReturn;
use App\Models\Apk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApkController extends Controller
{
    private $limit = 20;

    /**
     * @SWG\Get(
     *     path="/apk",
     *     summary="获取apk资源",
     *     tags={"APK相关接口"},
     *     description="获取最新apk版本或者历史版本",
     *     operationId="apk_resource",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="situation",
     *         in="path",
     *         description="new:最新版本(默认)，history:历史版本",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="limit",
     *         in="path",
     *         description="每页显示的条数,默认20条,获取历史版本使用",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="page",
     *         in="path",
     *         description="页码，默认为第1页，获取历史版本使用",
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
    public function getApk()
    {
        $situation = request('situation','new');
        $apk = null;
        switch ($situation){
            case 'new':
                $apk = (new Apk())->orderBy('create_time','desc')->first();
                break;
            case 'history':
                $limit = request('limit',$this->limit);
                $apk = (new Apk())->orderBy('create_time','desc')->paginate($limit);
                break;
            default:
                return ApiReturn::handle('PARAMETER_ERROR');
                break;
        }
        if (!$apk){
            return ApiReturn::handle('NOT_FOUND_ERROR');
        }
        return ApiReturn::handle('SUCCESS',$apk);
    }
}
