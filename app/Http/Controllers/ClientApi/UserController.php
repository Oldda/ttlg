<?php

namespace App\Http\Controllers\ClientApi;

use App\Facades\ApiReturn;
use App\Http\Requests\UserLoginPost;
use App\Repositories\TbkServices\UserService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    private $userService=null;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        echo 1;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * @SWG\Post(
     *     path="/login",
     *     summary="用户登录",
     *     tags={"用户相关接口"},
     *     description="用户登录接口，包含三方授权登录",
     *     operationId="user_login",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="client",
     *         in="header",
     *         description="登录终端1安卓",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="clientinfo",
     *         in="header",
     *         description="终端信息",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="location",
     *         in="header",
     *         description="登录地点",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="other",
     *         in="header",
     *         description="其他信息",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="login_type",
     *         in="formData",
     *         description="暂支持1第三方授权登录",
     *         required=true,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="auth_platform",
     *         in="formData",
     *         description="1淘宝授权",
     *         required=true,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="auth_token",
     *         in="formData",
     *         description="授权凭证",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="nickname",
     *         in="formData",
     *         description="昵称-第三方登录不能为空",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="thumbnail",
     *         in="formData",
     *         description="用户头像url-第三方登录不能为空",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="phone",
     *         in="formData",
     *         description="用户手机号",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="email",
     *         in="formData",
     *         description="邮箱地址",
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
    public function login(UserLoginPost $request)
    {
        return $this->userService->login($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
