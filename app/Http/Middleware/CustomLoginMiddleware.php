<?php

namespace App\Http\Middleware;

use App\Facades\ApiReturn;
use App\Models\LoginLog;
use Closure;

class CustomLoginMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->header('login-token');
        //token丢失
        if (is_null($token) || empty($token)){
            return ApiReturn::handle('TOKEN_LOST');
        }
        try{
            $data = json_decode(decrypt($token),true);
        }catch (\Exception $exception){
            return ApiReturn::handle('TOKEN_ERROR');
        }
        if(empty($data['user_id'])){
            return ApiReturn::handle('TOKEN_ERROR');
        }
        $login_log = (new LoginLog())
            ->where('user_id',$data['user_id'])
            ->orderBy('create_time','desc')
            ->first();
        if (!$login_log || $login_log->token != $token){
            return ApiReturn::handle('TOKEN_ERROR');
        }
        //token失效
        if ($login_log->expire_at < time() || $data['expire_at'] < time()){
            return ApiReturn::handle('TOKEN_EXPIRED');
        }
        //更新token
//        if ($login_log->expire_at - time() <= 600){
//            $login_log->expired_at = time() + 60 * 60;
//            $login_log->save();
//        }
        $request->attributes->add(['user_id'=>$data['user_id']]);//添加参数
        return $next($request);
    }
}
