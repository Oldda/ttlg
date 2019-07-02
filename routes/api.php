<?php
//测试
Route::get('test','TestController@test');
//天天乐购app路由
Route::group(['namespace'=>'ClientApi'],function (){
    Route::get('/index','IndexController@index'); //首页
    Route::get('/list','IndexController@list'); //首页2
    Route::get('/theme','IndexController@theme'); //主题页
    Route::get('/guide','IndexController@guideImg'); //引导图
    Route::get('/start_img','IndexController@startImg'); //启动图
	Route::get('/variable','IndexController@variables'); //系统变量
    Route::get('/count/{cat_id}',function($cat_id){ //仅供产品选品使用
        header("Content-type: text/html; charset=utf-8");
        include "../sdks/taobao/TopSdk.php";
        $c = new \TopClient;
        $c->appkey = '27570650';
        $c->secretKey = 'fa163386f944c080bd16bf8dd3e9fba8';
        $c->format = 'json';
        $req = new \TbkDgMaterialOptionalRequest;
        $req->setAdzoneId("482302086");
        $req->setCat($cat_id);
        $req->setHasCoupon("true");
        $resp = $c->execute($req);
        $count = $resp->total_results??'可能没有该分类，获取数量失败';
        echo $count;
    });

    /**
     * 淘宝客系列api数据返回
     */
    //淘宝客商品查询
    Route::get('item_get','TbkController@itemGet');
    //淘宝客商品关联推荐查询
    Route::get('recommend_get','TbkController@recommendGet');
    //淘宝客商品详情（简版）
    Route::get('item_info_get','TbkController@itemInfoGet');
    //淘宝客店铺查询
    Route::get('shop_get','TbkController@shopGet');
    //淘宝客店铺关联推荐查询
    Route::get('shop_recommend_get','TbkController@shopRecommendGet');
    //获取淘宝联盟选品库的宝贝信息
    Route::get('favorites_item_get','TbkController@favoritesItemGet');
    //获取淘宝联盟选品库列表
    Route::get('uatm_favorites_get','TbkController@uatmFavoritesGet');
    //淘抢购Api
    Route::get('ju_tqg_get','TbkController@juTqgGet');
    //链接解析api
    Route::get('click_extract','TbkController@clickExtract');
    //淘宝客商品猜你喜欢
    Route::get('item_guess_like','TbkController@itemGuessLike');
    //好券清单API【导购】
    Route::get('coupon_get','TbkController@couponGet');
    //阿里妈妈推广券信息查询
    Route::get('tbk_coupon_get','TbkController@tbkCouponGet');
    //淘宝客淘口令
    Route::get('tpwd_create','TbkController@tpwdCreate');
    //淘宝客物料下行-导购
    Route::get('optimus_material','TbkController@optimusMaterial');
    //通用物料搜索API（导购）
    Route::get('material_optional','TbkController@materialOptional');


    /**
     * 商品路由
     */
    Route::get('/product/search','ProductController@search');
    Route::get('/product/show','ProductController@show');
    Route::get('product_detail','TbkController@getDetail'); //h5页面商品详情
    Route::get('get_coupon_from_item','ProductController@getCouponFromItemId');
    /**
     * 用户路由
     */
    Route::resource('/user','UserController');
    Route::post('/login','UserController@login');

    /**
     * 分类路由
     */
    Route::get('cat_list','CateController@list'); //列表
    /**
     * APK版本资源
     */
    Route::get('/apk','ApkController@getApk');
});
//登录中间件路由
Route::group(['namespace'=>'ClientApi','middleware'=>'login'],function (){
    Route::post('feedback','FeedbackController@store');//添加反馈
    Route::get('logout','UserController@logout');//登出
    Route::post('user/bind_phone','UserController@bindPhone');//用户绑定手机号
    Route::get('sms','IndexController@sms'); //发送短信
});
