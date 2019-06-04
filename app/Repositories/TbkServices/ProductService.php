<?php
namespace App\Repositories\TbkServices;

use App\Facades\ApiReturn;

class ProductService
{
    private $appkey = null;
    private $secret = null;
    private $format = 'json';

    public function __construct()
    {
        header("Content-type: text/html; charset=utf-8");
        include "../sdks/taobao/TopSdk.php";
        $this->appkey = config('tbk.key');
        $this->secret = config('tbk.secret');
    }

    //淘宝客物料下行-导购
    public function list($limit=8,$page=1)
    {
        $c = new \TopClient;
        $c->appkey = $this->appkey;
        $c->secretKey = $this->secret;
        $c->format = $this->format;
        $req = new \TbkDgOptimusMaterialRequest;
        $req->setPageSize($limit);
        $req->setAdzoneId("482302086");
        $req->setPageNo($page);
        $req->setMaterialId('3756');
        $resp = $c->execute($req);
        return $resp;
    }

    //通用物料搜索API（导购
    public function search($keyword,$limit=8,$page=1)
    {
        $c = new \TopClient;
        $c->appkey = $this->appkey;
        $c->secretKey = $this->secret;
        $c->format = $this->format;
        $req = new \TbkDgMaterialOptionalRequest;
        $req->setPageSize($limit);
        $req->setPageNo("$page");
        $req->setPlatform('2');
        $req->setQ($keyword);
        $req->setAdzoneId("482302086");
        $resp = $c->execute($req);
        return ApiReturn::handle('SUCCESS',$resp);
    }

    //淘宝客商品详情（简版）
    public function show($num_iid)
    {
        $c = new \TopClient;
        $c->appkey = $this->appkey;
        $c->secretKey = $this->secret;
        $c->format = $this->format;
        $req = new \TbkItemInfoGetRequest;
        $req->setNumIids($num_iid);
        $req->setPlatform("2");
        $req->setIp($_SERVER['REMOTE_ADDR']);
        $resp = $c->execute($req);
        return ApiReturn::handle('SUCCESS',$resp);
    }
}