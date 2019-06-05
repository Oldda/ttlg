<?php
namespace App\Tools;


use App\Interfaces\ApiReturnInterface;

class ApiReturn implements ApiReturnInterface
{
    //定义接口返回格式
    public function handle($mark,$data=[],$limit=null,$page=null)
    {
        $config = config('api_response');
        $returnTime = date('Y-m-d H:i:s');
        if( array_key_exists ($mark,$config)){
            $config[$mark]['response_time'] = $returnTime;
            if (!is_null($data)){
                if (!is_null($limit) && !is_null($page)){
                    $config[$mark]['limit'] = $limit;
                    $config[$mark]['page'] = $page;
                }
                $config[$mark]['data'] = $data;
                return response()->json($config[$mark],200);
            }
            return response()->json($config[$mark]);
        }
        return response()->json(['status'=>false,'response_code'=>10000,'msg'=>'未知错误！','response_time'=>$returnTime]);
    }
}
