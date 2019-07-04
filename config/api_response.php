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
    'TOKEN_LOST' => [
        'status' => false,
        'response_code' => 107,
        'msg' => 'token丢失'
    ],
    'TOKEN_ERROR' => [
        'status' => false,
        'response_code' => 108,
        'msg' => 'token错误'
    ],
    'PARAMETER_ERROR' => [
        'status' => false,
        'response_code' => 109,
        'msg' => '参数错误'
    ],
    'SUCCESS' => [
        'status' => true,
        'response_code' => 200,
        'msg' => '请求成功！'
    ],
    'JSON_ERROR' => [
        'status' => false,
        'response_code' => 201,
        'msg' => 'json参数解析错误！'
    ],
    'SMS_SEND_NEED_WAIT' => [
        'status' => false,
        'response_code' => 202,
        'msg' => '发送频率限制，请等待！'
    ],
    'SMS_CODE_LOST' => [
        'status' => false,
        'response_code' => 203,
        'msg' => '未获得短信验证码，请发送后验证！'
    ],
    'SMS_CODE_ERROR' => [
        'status' => false,
        'response_code' => 204,
        'msg' => '验证码错误！'
    ],
    'SMS_CODE_EXPIRED' => [
        'status' => false,
        'response_code' => 205,
        'msg' => '验证码失效，请重发！'
    ],
    'SMS_HAS_BENN_USED' => [
        'status' => false,
        'response_code' => 206,
        'msg' => '该验证码已被使用！'
    ],
    //主题相关
    'THEME_ALREADY_DOWN' => [
        'status' => false,
        'response_code' => 1001,
        'msg' => '主题已下架，不可使用！'
    ],
    //淘宝API相关
    'COUPON_GET_ERROR' => [
        'status' => false,
        'response_code' => 2001,
        'msg' => '券信息获取失败，请检查券id参数！'
    ],
    'COUPON_MISSING' => [
        'status' => false,
        'response_code' => 2002,
        'msg' => '券信息未找到！'
    ],
    //用户相关

];