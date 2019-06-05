<?php
//天天乐购app路由
Route::group(['namespace'=>'ClientApi'],function (){
    Route::get('/index/{limit?}/{page?}','IndexController@index'); //首页
    /**
     * 商品路由
     */
    Route::get('/product/search/{keyword}','ProductController@search');
    Route::get('/product/show/{item_id}/{coupon_id}','ProductController@show');
});
