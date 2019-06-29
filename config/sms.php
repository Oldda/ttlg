<?php
return [
    // HTTP 请求的超时时间（秒）
    'timeout' => 5.0,
    // 默认发送配置
    'default' => [
        // 网关调用策略，默认：顺序调用
        'strategy' => \Overtrue\EasySms\Strategies\OrderStrategy::class,
        // 默认可用的发送网关
        'gateways' => [
            'aliyun',
            //'yuntongxun',
        ],
    ],
    // 可用的网关配置
    'gateways' => [
//        'yuntongxun' => [
//            'app_id' => '8a216da8645fab0e01646dbc618a08c3',
//            'account_sid' => '8a48b551495b42ea01495ef2f33501ce',
//            'account_token' => '4550a18c0ef048c68ceab9e174f86910',
//            'is_sub_account' => false,
//        ],
        'aliyun' => [
            'access_key_id' => 'LTAIB0aokppPwwxW',//'LTAI8YZZPx7Ars8S',
            'access_key_secret' => 'ZKZCmKYXAKOxvM6xQbsKx2Ft1iEqT6',//'bA4IlZObJZSd6xgeDEJO0iocBEu7jT',
            'sign_name' => '蜜传消息'//'天天乐购',
        ],
    ],
];
