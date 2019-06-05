<?php
return [
    //公共返回
    'API_URL_NOT_FOUND' => [
        'status' => false,
        'response_code' => 100,
        'msg' => '接口地址错误'
    ],
    'NOT_FOUND_ERROR' => [
        'status' => false,
        'response_code' => 101,
        'msg' => '获取资源失败'
    ],
    'ADD_SOURCE_ERROR' => [
        'status' => false,
        'response_code' => 102,
        'msg' => '添加资源错误'
    ],
    'UPDATE_SOURCE_ERROR' => [
        'status' => false,
        'response_code' => 103,
        'msg' => '更新资源错误'
    ],
    'DELETE_SOURCE_ERROR' => [
        'status' => false,
        'response_code' => 104,
        'msg' => '删除资源错误'
    ],
    'PARAMETER_LOST' => [
        'status' => false,
        'response_code' => 105,
        'msg' => '缺少必要参数'
    ],
    'METHOD_NOT_ALLOWED' => [
        'status' => false,
        'response_code' => 106,
        'msg' => '请求方式错误'
    ],
    'SUCCESS' => [
        'status' => true,
        'response_code' => 200,
        'msg' => '请求成功！'
    ],
];