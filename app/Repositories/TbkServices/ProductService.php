<?php
namespace App\Repositories\TbkServices;

use App\Facades\ApiReturn;

class ProductService
{
    private $format = 'json';
    private $client = null;

    public function __construct()
    {
        header("Content-type: text/html; charset=utf-8");
        include "../sdks/taobao/TopSdk.php";
        $this->client = new \TopClient;
        $this->client->appkey = config('tbk.key');
        $this->client->secretKey = config('tbk.secret');
        $this->client->format = $this->format;
    }

    //淘宝客物料下行-导购
    public function list($limit=8,$page=1)
    {
        $req = new \TbkDgOptimusMaterialRequest;
        $req->setPageSize($limit);
        $req->setAdzoneId("482302086");
        $req->setPageNo($page);
        $req->setMaterialId('3756');
        $resp = $this->client->execute($req);
        return $resp->result_list->map_data??$resp;
    }

    //通用物料搜索API（导购）
    public function search($keyword,$limit=8,$page=1)
    {
        $req = new \TbkDgMaterialOptionalRequest;
        $req->setPageSize($limit);
        $req->setPageNo("$page");
        $req->setPlatform('2');
        if (!empty($keyword)){
            $req->setQ($keyword);
        }else{
            $req->setCat(config('tbk.cat'));
        }
        $req->setHasCoupon("true");
        $req->setAdzoneId("482302086");
        $resp = $this->client->execute($req);
        return $resp->result_list->map_data??$resp;
    }

    //淘宝客商品详情（简版）
    public function show($item_id)
    {
        $req = new \TbkItemInfoGetRequest;
        $req->setNumIids($item_id);
        $req->setPlatform("2");
        $req->setIp($_SERVER['REMOTE_ADDR']);
        $resp = $this->client->execute($req);
        return $resp->results->n_tbk_item[0]??$resp;
    }

    //阿里妈妈推广券信息查询
    public function coupon($item_id,$coupon_id)
    {
        $req = new \TbkCouponGetRequest;
//        $req->setMe("nfr%2BYTo2k1PX18gaNN%2BIPkIG2PadNYbBnwEsv6mRavWieOoOE3L9OdmbDSSyHbGxBAXjHpLKvZbL1320ML%2BCF5FRtW7N7yJ056Lgym4X01A%3D");
        $req->setItemId($item_id); //商品id
        $req->setActivityId($coupon_id);
        $resp = $this->client->execute($req);
        return $resp->data??$resp;
    }
}