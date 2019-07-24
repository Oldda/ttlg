<?php

namespace App\Http\Controllers\ClientApi;

use App\Events\UserBrowseEvent;
use App\Facades\ApiReturn;
use App\Http\Requests\StatisticPostRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StatisticsController extends Controller
{
    //token，url链接，商品标题
    /**
     * @SWG\Post(
     *     path="/click_coupon_url_count",
     *     summary="点击领券链接额外统计",
     *     tags={"统计相关接口"},
     *     description="点击领券链接额外统计",
     *     operationId="click_coupon_url_count",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="login-token",
     *         in="header",
     *         description="登录状态token",
     *         required=true,
     *         type="string",
     *     ),
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
     *         name="coupon_share_url",
     *         in="formData",
     *         description="领券的链接",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="title",
     *         in="formData",
     *         description="商品的标题",
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
    public function clickCouponUrlCount(StatisticPostRequest $request)
    {
        event(new UserBrowseEvent(
            request()->header('imei',''),
            '领券按钮点击',
            '用户id:'.$this->user_id.'_标题内容：'.request('title','无'),
            request('coupon_share_url',''),
            request()->header('operating_system',''),
            request()->header('phone_type','')
        ));
        return ApiReturn::handle('SUCCESS');
    }
}
