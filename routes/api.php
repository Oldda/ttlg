<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
//app首页
Route::group(['namespace'=>'ClientApi'],function (){
    Route::get('/{limit?}/{page?}','IndexController@index');
});

Route::get('test',function (){
    header("Content-type: text/html; charset=utf-8");
    include "../sdks/taobao/TopSdk.php";
    $c = new TopClient;
    $c->appkey = '27570650';
    $c->secretKey = 'fa163386f944c080bd16bf8dd3e9fba8';
    $req = new TbkItemGuessLikeRequest;
    $req->setAdzoneId("44658379");
    $req->setUserNick("abc");
    $req->setUserId("123456");
    $req->setOs("ios");
    $req->setIdfa("65A509BA-227C-49AC-91EC-DE6817E63B10");
    $req->setImei("641221321098757");
    $req->setImeiMd5("115d1f360c48b490c3f02fc3e7111111");
    $req->setIp("106.11.34.15");
    $req->setUa("Mozilla/5.0");
    $req->setApnm("com.xxx");
    $req->setNet("wifi");
    $req->setMn("iPhone7%2C2");
    $req->setPageNo("1");
    $req->setPageSize("20");
    $resp = $c->execute($req);
    print_r($resp);
});
Route::get('test2',function(){
    header("Content-type: text/html; charset=utf-8");
    include "../sdks/taobao/TopSdk.php";
    $appkey = "27570650"; // 可替换为您的沙箱环境应用的AppKey
    $secret = "fa163386f944c080bd16bf8dd3e9fba8"; // 可替换为您的沙箱环境应用的AppSecret
    $c = new TopClient;
    $c->appkey = $appkey;
    $c->secretKey = $secret;
    $c->format = 'json';
    $req = new TbkUatmFavoritesGetRequest;
    $req->setPageNo("1");
    $req->setPageSize("20");
    $req->setFields("favorites_title,favorites_id,type");
    $req->setType("1");
    $resp = $c->execute($req);
    print_r($resp);
});
