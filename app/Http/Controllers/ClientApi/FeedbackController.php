<?php

namespace App\Http\Controllers\ClientApi;

use App\Facades\ApiReturn;
use App\Http\Requests\FeedbackPost;
use App\Models\Feedback;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FeedbackController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @SWG\Post(
     *     path="/feedback",
     *     summary="提交意见反馈",
     *     tags={"反馈相关接口"},
     *     description="提交意见反馈",
     *     operationId="feedback_store",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="login-token",
     *         in="header",
     *         description="登录token",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="content",
     *         in="formData",
     *         description="意见反馈内容",
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
    public function store(FeedbackPost $request)
    {
        $add = Feedback::create([
            'user_id' => $this->user_id,
            'content' => $request->content
        ]);
        if (!$add){
            return ApiReturn::handle('ADD_SOURCE_ERROR');
        }
        return ApiReturn::handle('SUCCESS',$add);
    }
}
