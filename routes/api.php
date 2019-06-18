<?php
//天天乐购app路由
Route::group(['namespace'=>'ClientApi'],function (){
    Route::get('/index','IndexController@index'); //首页
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

    Route::get('item_get','TbkController@itemGet');
    //好券清单API【导购】
    Route::get('coupon_get','TbkController@couponGet');
    //淘宝客物料下行-导购
    Route::get('optimus_material','TbkController@optimusMaterial');
    /**
     * 商品路由
     */
    Route::get('/product/search','ProductController@search');
    Route::get('/product/show','ProductController@show');
    /**
     * 用户路由
     */
    Route::resource('/user','UserController');
    Route::post('/login','UserController@login');

    /**
     * APK版本资源
     */
    Route::get('/apk','ApkController@getApk');
});
//登录中间件路由
Route::group(['namespace'=>'ClientApi','middleware'=>'login'],function (){
    Route::post('feedback','FeedbackController@store');
    Route::get('logout','UserController@logout');
});
