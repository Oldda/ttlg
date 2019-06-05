<?php
namespace App\Repositories\TbkServices;

use App\Facades\ApiReturn;
use App\Models\LoginInfo;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserService
{
    public function login($request)
    {
        switch ($request->login_type){
            case 1://第三方授权登录
                $user = (new User())->whereHas('loginInfos',function($query)use($request){
                    $query->where('auth_token',$request->auth_token);
                })->first();
                if (!$user){ //创建用户
                    //头像和昵称不能为空
                    if (!$request->nickname || !$request->thumbnail){
                        return ApiReturn::handle('PARAMETER_LOST');
                    }
                    return $this->store([
                        'nickname' => $request->nickname,
                        'thumbnail'=> $request->thumbnail
                    ],[
                        'auth_platform' => $request->auth_platform,
                        'auth_token' => $request->auth_token
                    ]);
                }else{//用户存在
                    return ApiReturn::handle('SUCCESS',$user);
                }
                break;
            case 2://手机号直接登录
                break;
            default:
                return false;
                break;
        }
    }

    //添加用户
    private function store($userInfo, $loginInfo)
    {
        //添加用户
        DB::beginTransaction();
        try{
            $user = User::create($userInfo);
            $loginInfo['user_id'] = $user->id;
            LoginInfo::create($loginInfo);
            DB::commit();
            return ApiReturn::handle('SUCCESS',$user);
        }catch (\Exception $exception){
            DB::rollBack();
            return ApiReturn::handle('ADD_SOURCE_ERROR');
        }
    }
}