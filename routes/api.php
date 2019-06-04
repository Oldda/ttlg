<?php
//天天乐购app路由
Route::group(['namespace'=>'ClientApi'],function (){
    Route::get('/index/{limit?}/{page?}','IndexController@index'); //首页
    /**
     * 商品路由
     */
    Route::get('/product/search/{keyword}/{limit?}/{page?}','ProductController@search');
    Route::get('/product/{num_iid}','ProductController@show');
});
