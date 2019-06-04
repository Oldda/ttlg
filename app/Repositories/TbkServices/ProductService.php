<?php
namespace App\Repositories\TbkServices;

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

    //获取淘宝联盟选品库的宝贝信息
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
}