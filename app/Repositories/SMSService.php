<?php
namespace App\Repositories;

use App\Facades\ApiReturn;
use App\Models\SMSLog;
use Overtrue\EasySms\EasySms;

class SMSService
{
    //发送短信
    public function sms($phone)
    {
        //添加记录
        $last = (new SMSLog())->where('phone',$phone)->orderBy('create_time','desc')->first();
        if ($last && strtotime($last->create_time) >= time() - 60){
            return ApiReturn::handle('SMS_SEND_NEED_WAIT');
        }
        //发送
        $config = config('sms');
        $easySms = new EasySms($config);
        $str = mt_rand(10000,99999);
        try{
            $result = $easySms->send($phone,[
                'template' => 'SMS_149417711',//'SMS_169103731',
                'data' => ['code'=>$str] //[$str,5]
            ]);
        }catch (\Exception $exception){
            return $exception->getExceptions();
        }
        foreach ($result as $value){
            if ($value['status'] === 'success'){
                SMSLog::create([
                    'phone' => $phone,
                    'code' => $str,
                    'expired_at' => time() + 300,//5分钟失效
                ]);
                return ApiReturn::handle('SUCCESS');
            }
        }
        //发送短信失败
        return ApiReturn::handle('SMS_SEND_FAILED');
    }

    public function check($phone,$verify_code)
    {
        //验证短信验证码
        $sms_log = (new SMSLog())
            ->where('phone',$phone)
            ->orderBy('create_time','desc')
            ->first();
        if (!$sms_log){
            return ApiReturn::handle('SMS_CODE_LOST');
        }
        if ($sms_log->code !== $verify_code){
            return ApiReturn::handle('SMS_CODE_ERROR');
        }
        if ($sms_log->expired_at < time()){
            return ApiReturn::handle('SMS_CODE_EXPIRED');
        }
        //是否被使用
        if ($sms_log->is_used !== 0){
            return ApiReturn::handle('SMS_HAS_BENN_USED');
        }
        //验证码使用
        $sms_log->is_used = 1;
        $sms_log->save();
        return ApiReturn::handle('SUCCESS');
    }
}