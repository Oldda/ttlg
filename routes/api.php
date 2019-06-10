<?php
//天天乐购app路由
Route::group(['namespace'=>'ClientApi'],function (){
    Route::get('/index','IndexController@index'); //首页
    Route::get('/theme','IndexController@theme'); //主题页
    Route::get('/guide','IndexController@guideImg'); //引导图
    Route::get('/start_img','IndexController@startImg'); //启动图
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
    Route::get('/apk','ApkController@getApk');
});
//登录中间件路由
Route::group(['namespace'=>'ClientApi','middleware'=>'login'],function (){
    Route::post('feedback','FeedbackController@store');
});
