<?php
namespace App\Repositories\TbkServices;

use App\Events\UserLocationEvent;
use App\Facades\ApiReturn;
use App\Models\LoginInfo;
use App\Models\LoginLog;
use App\Models\User;
use App\Repositories\SMSService;
use Illuminate\Support\Facades\DB;

class UserService extends SMSService
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
                    $user = $this->store([
                        'nickname' => $request->nickname,
                        'thumbnail'=> $request->thumbnail,
                        'last_ip' => $this->getIp(),
                    ],[
                        'auth_platform' => $request->auth_platform,
                        'auth_token' => $request->auth_token,
						'union_auth_token' => $union
                    ]);
                    if (!$user){
                        return ApiReturn::handle('ADD_SOURCE_ERROR');
                    }
                }
                break;
            case 2:
                //todo...
                break;
            default:
                //todo...
                return false;
                break;
        }
        $user->phone_is_bind = true;
        //是否绑定了手机号
//        if (!isset($user->phone) || $user->phone === null){
//            $user->phone_is_bind = false; //暂时取消绑定手机判定
//        }
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
            event(new UserLocationEvent($user->id,$user->last_ip));
            return $user;
        }catch (\Exception $exception){
            DB::rollBack();
            return false;
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

    //绑定手机号
    public function bindPhone($request,$user_id)
    {
        //验证手机验证码
        $result = $this->check($request->phone,$request->verify_code);
        if (json_decode($result->getContent(),true)['status'] !== true){
            return $result;
        }
        //插入数据
        $user = (new User())->find($user_id);
        $user->phone = $request->phone;
        $user->save();
        return ApiReturn::handle('SUCCESS',$user);
    }

    //获取ip-赵林正提供
    public function getIp()
    {
        static $ip = NULL;
        if ($ip !== NULL)
            return $ip;
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $pos = array_search('unknown', $arr);
            if (false !== $pos)
                unset($arr[$pos]);
            $ip = trim($arr[0]);
        }
        else if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } else if (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        //IP地址合法验证
        $ip = (false !== ip2long($ip)) ? $ip : '0.0.0.0';
        return $ip;
    }
}