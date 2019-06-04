<?php
namespace App\Tools;


use App\Interfaces\ApiReturnInterface;

class ApiReturn implements ApiReturnInterface
{
    //定义接口返回格式
    public function handle($mark,$data=[])
    {
        $config = config('api_response');
        if( array_key_exists ($mark,$config)){
            if (!is_null($data)){
                $config[$mark]['data'] = $data;
                return response()->json($config[$mark],200);
            }
            return response()->json($config[$mark]);
        }
        return response()->json(['status'=>false,'response_code'=>10000,'msg'=>'未知错误！']);
    }
}
