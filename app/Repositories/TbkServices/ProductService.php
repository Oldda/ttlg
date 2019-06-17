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
        $req->setAdzoneId(config('tbk.adzone_id'));
        $req->setPageNo($page);
        $req->setMaterialId('3756');
        $resp = $this->client->execute($req);
        return $resp->result_list->map_data??$resp;
    }

    //通用物料搜索API（导购）
    public function search($input)
    {
        $req = new \TbkDgMaterialOptionalRequest;
        if (isset($input['start_dsr'])){
            $req->setStartDsr($input['start_dsr']);
        }
        if (isset($input['platform'])){
            $req->setPlatform($input['platform']);
        }
        if (isset($input['end_tk_rate'])){
            $req->setEndTkRate($input['end_tk_rate']);
        }
        if (isset($input['start_dsr'])){
            $req->setStartTkRate($input['start_dsr']);
        }
        if (isset($input['end_price'])){
            $req->setEndPrice($input['end_price']);
        }
        if (isset($input['start_price'])){
            $req->setStartPrice($input['start_price']);
        }
        if (isset($input['is_overseas'])){
            $req->setIsOverseas($input['is_overseas']);
        }
        if (isset($input['is_tmall'])){
            $req->setIsTmall($input['is_tmall']);
        }
        if (isset($input['sort'])){
            $req->setSort($input['sort']);
        }
        if (isset($input['itemloc'])){
            $req->setItemloc($input['itemloc']);
        }
        if (isset($input['need_free_shipment'])){
            $req->setNeedFreeShipment($input['need_free_shipment']);
        }
        if (isset($input['need_prepay'])){
            $req->setNeedPrepay($input['need_prepay']);
        }
        if (isset($input['include_pay_rate_30'])){
            $req->setIncludePayRate30($input['include_pay_rate_30']);
        }
        if (isset($input['include_good_rate'])){
            $req->setIncludeGoodRate($input['include_good_rate']);
        }
        if (isset($input['include_rfd_rate'])){
            $req->setIncludeRfdRate($input['include_rfd_rate']);
        }
        if (isset($input['npx_level'])){
            $req->setNpxLevel($input['npx_level']);
        }
        if (isset($input['keyword'])){
            $req->setQ($input['keyword']);
        }
        if (isset($input['cat'])){
            $req->setCat($input['cat']);
        }
        if (!isset($input['keyword']) && !isset($input['cat'])){
            $req->setCat(config('tbk.cat'));
        }
        if (isset($input['limit'])){
            $req->setPageSize($input['limit']);
        }
        if (isset($input['page'])){
            $req->setPageNo($input['page']);
        }
        if (isset($input['has_coupon'])){
            $req->setHasCoupon($input['has_coupon']);
        }else{
			$req->setHasCoupon('true');
		}
        $req->setAdzoneId(config('tbk.adzone_id'));
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