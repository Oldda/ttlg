<?php
//天天乐购app路由
Route::group(['namespace'=>'ClientApi'],function (){
    Route::get('/index','IndexController@index'); //首页
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
});
//登录中间件路由
Route::group(['namespace'=>'ClientApi','middleware'=>'login'],function (){
    Route::post('feedback','FeedbackController@store');
});
