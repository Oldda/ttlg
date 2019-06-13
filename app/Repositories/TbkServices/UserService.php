<?php
namespace App\Repositories\TbkServices;

use App\Facades\ApiReturn;
use App\Models\LoginInfo;
use App\Models\LoginLog;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserService
{
    public function login($request)
    {
        $user = null;
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
					$union = $request->union_auth_token??'';
                    return $this->store([
                        'nickname' => $request->nickname,
                        'thumbnail'=> $request->thumbnail
                    ],[
                        'auth_platform' => $request->auth_platform,
                        'auth_token' => $request->auth_token,
						'union_auth_token' => $union
                    ]);
                }
                break;
            case 2:
                break;
            default:
                return false;
                break;
        }
        //初始化登录token
        $user->login_token = $this->generateToken($request,$user->id);
        //返回user
        return ApiReturn::handle('SUCCESS',$user);
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
    
    //登录日志
    public function generateToken($request,$user_id)
    {
        $data = array(
            'client' => $request->header('client')??1,
            'clientinfo' => $request->header('client_info')??'',
            'location' => $request->header('location')??'',
            'expire_at' => time() + 60 * 60 * 24 * 365,//一年之后失效
            'user_id' => $user_id,
            'other' => $request->header('other')??''
        );
        $data['token'] = encrypt(json_encode($data));
        LoginLog::create($data);
        return $data['token'];
    }
}