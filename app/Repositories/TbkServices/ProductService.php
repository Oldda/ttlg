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
    //淘宝客商品查询
    public function itemGet($input)
    {
        $req = new \TbkItemGetRequest;
        $req->setFields("num_iid,title,pict_url,small_images,reserve_price,zk_final_price,user_type,provcity,item_url,seller_id,volume,nick");
        if (isset($input['keyword'])){
            $req->setQ($input['keyword']);
        }
        if (isset($input['platform'])){
            $req->setPlatform($input['platform']);
        }
        if (isset($input['cat'])){
            $req->setCat($input['cat']);
        }
        if (isset($input['itemloc'])){
            $req->setItemloc($input['itemloc']);
        }
        if (isset($input['sort'])){
            $req->setSort($input['sort']);
        }
        if (isset($input['is_tmall'])){
            $req->setIsTmall($input['is_tmall']);
        }
        if (isset($input['is_overseas'])){
            $req->setIsOverseas($input['is_overseas']);
        }
        if (isset($input['start_price'])){
            $req->setStartPrice($input['start_price']);
        }
        if (isset($input['end_price'])){
            $req->setEndPrice($input['end_price']);
        }
        if (isset($input['start_tk_rate'])){
            $req->setStartTkRate($input['start_tk_rate']);
        }
        if (isset($input['end_tk_rate'])){
            $req->setEndTkRate($input['end_tk_rate']);
        }
        $req->setPageNo($input['limit']);
        $req->setPageSize($input['page']);
        $resp = $this->client->execute($req);
        return $resp->results->n_tbk_item[0]??$resp;
    }
    // 淘宝客商品关联推荐查询
    public function recommendGet($input)
    {
        $req = new \TbkItemRecommendGetRequest;
        $req->setFields("num_iid,title,pict_url,small_images,reserve_price,zk_final_price,user_type,provcity,item_url");
        $req->setNumIid($input['num_iid']);
        $req->setCount($input['limit']);
        if (isset($input['platform'])){
            $req->setPlatform($input['platform']);
        }
        $resp = $this->client->execute($req);
        return $resp->results->n_tbk_item??[];
    }
    //淘宝客商品详情（简版）
    public function show($input)
    {
        $req = new \TbkItemInfoGetRequest;
        $req->setNumIids($input['item_id']);
        if (isset($input['platform'])){
            $req->setPlatform($input['platform']);
        }
        if (isset($input['ip'])){
            $req->setIp($input['ip']);
        }else{
            $req->setIp($_SERVER['REMOTE_ADDR']);
        }

        $resp = $this->client->execute($req);
        return $resp->results->n_tbk_item[0]??new \stdClass();
    }
    //淘宝客店铺查询
    public function shopGet($input)
    {
        $req = new \TbkShopGetRequest;
        $req->setFields("user_id,shop_title,shop_type,seller_nick,pict_url,shop_url");
        $req->setQ($input['keyword']);
        $req->setPageNo($input['page']);
        $req->setPageSize($input['limit']);
        if (isset($input['sort'])){
            $req->setSort($input['sort']);
        }
        if (isset($input['platform'])){
            $req->setPlatform($input['platform']);
        }
        if (isset($input['is_tmall'])){
            $req->setIsTmall($input['is_tmall']);
        }
        if (isset($input['start_credit'])){
            $req->setStartCredit($input['start_credit']);
        }
        if (isset($input['end_credit'])){
            $req->setEndCredit($input['end_credit']);
        }
        if (isset($input['start_commission_rate'])){
            $req->setStartCommissionRate($input['start_commission_rate']);
        }
        if (isset($input['end_commission_rate'])){
            $req->setEndCommissionRate($input['end_commission_rate']);
        }
        if (isset($input['start_total_action'])){
            $req->setStartTotalAction($input['start_total_action']);
        }
        if (isset($input['end_total_action'])){
            $req->setEndTotalAction($input['end_total_action']);
        }
        if (isset($input['start_auction_count'])){
            $req->setStartAuctionCount($input['start_auction_count']);
        }
        if (isset($input['end_auction_count'])){
            $req->setEndAuctionCount($input['end_auction_count']);
        }
        $resp = $this->client->execute($req);
        return $resp->results->n_tbk_shop??[];
    }
    // 淘宝客店铺关联推荐查询
    public function shopRecommendGet($input)
    {
        $req = new \TbkShopRecommendGetRequest;
        $req->setFields("user_id,shop_title,shop_type,seller_nick,pict_url,shop_url");
        $req->setUserId($input['user_id']);
        $req->setCount($input['limit']);
        if (isset($input['platform'])){
            $req->setPlatform($input['platform']);
        }
        $resp = $this->client->execute($req);
        return $resp->results->n_tbk_shop??[];
    }
    //获取淘宝联盟选品库的宝贝信息
    public function favoritesItemGet($input)
    {
        $req = new \TbkUatmFavoritesItemGetRequest;
        if (isset($input['platform'])){
            $req->setPlatform($input['platform']);
        }
        $req->setPageSize($input['limit']);
        $req->setAdzoneId(config('tbk.adzone_id'));
        if (isset($input['unid'])){
            $req->setUnid($input['unid']);
        }
        $req->setFavoritesId($input['favorites_id']);
        $req->setPageNo($input['page']);
        $req->setFields("num_iid,title,pict_url,small_images,reserve_price,zk_final_price,user_type,provcity,item_url,seller_id,volume,nick,shop_title,zk_final_price_wap,event_start_time,event_end_time,tk_rate,status,type");
        $resp = $this->client->execute($req);
        return $resp->results->uatm_tbk_item??[];
    }
    //获取淘宝联盟选品库列表
    public function uatmFavoritesGet($input)
    {
        $req = new \TbkUatmFavoritesGetRequest;
        $req->setPageNo($input['page']);
        $req->setPageSize($input['limit']);
        $req->setFields("favorites_title,favorites_id,type");
        $req->setType($input['type']);
        $resp = $this->client->execute($req);
        return $resp->results->tbk_favorites??[];
    }
    // 淘抢购api
    public function juTqgGet($input)
    {
        $req = new \TbkJuTqgGetRequest;
        $req->setAdzoneId(config('tbk.adzone_id'));
        $req->setFields("click_url,pic_url,reserve_price,zk_final_price,total_amount,sold_num,title,category_name,start_time,end_time");
        $req->setStartTime($input['start_time']);
        $req->setEndTime($input['end_time']);
        $req->setPageNo($input['page']);
        $req->setPageSize($input['limit']);
        $resp = $this->client->execute($req);
        return $resp->results->results??[];
    }
    //链接解析api
    public function clickExtract($url)
    {
        return '接口不开放!';
    }
    //淘宝客商品猜你喜欢
    public function itemGuessLike($input)
    {
        return '暂未开放！';
    }
    //好券清单API【导购】
    public function couponGet($input)
    {
        $req = new \TbkDgItemCouponGetRequest;
        $req->setAdzoneId(config('tbk.adzone_id'));
        if (isset($input['platform'])){
            $req->setPlatform($input['platform']);
        }
        if (isset($input['cat'])){
            $req->setCat($input['cat']);
        }
        if (isset($input['keyword'])){
            $req->setQ($input['keyword']);
        }
        $req->setPageSize($input['limit']);
        $req->setPageNo($input['page']);
        $resp = $this->client->execute($req);
        return $resp->results->tbk_coupon??[];
    }
    //阿里妈妈推广券信息查询
    public function coupon($input)
    {
        $req = new \TbkCouponGetRequest;
        if(isset($input['me'])){
            $req->setMe($input['me']);
        }
        if (isset($input['item_id'])){
            $req->setItemId($input['item_id']); //商品id
        }
        if (isset($input['activity_id'])){
            $req->setActivityId($input['activity_id']);
        }
        $resp = $this->client->execute($req);
        return $resp->data??new \stdClass();
    }
    //淘宝客淘口令
    public function tpwdCreate($input)
    {
        $req = new \TbkTpwdCreateRequest;
        if (isset($input['user_id'])){
            $req->setUserId($input['user_id']);
        }

        $req->setText($input['text']);
        $req->setUrl($input['url']);
        if (isset($input['logo'])){
            $req->setLogo($input['logo']);
        }
        if (isset($input['ext'])){
            $req->setExt($input['ext']);
        }
        $resp = $this->client->execute($req);
        return $resp->data??new \stdClass();
    }
    //淘客媒体内容输出
    //淘宝客新用户订单API--导购
    //淘宝客新用户订单API--社交
    //淘宝客物料下行-导购
    public function optimusMaterial($input)
    {
        $req = new \TbkDgOptimusMaterialRequest;
        $req->setAdzoneId(config('tbk.adzone_id'));
        $req->setPageSize($input['limit']);
        $req->setPageNo($input['page']);
        $req->setMaterialId($input['material_id']);
        if (isset($input['device_value'])){
            $req->setDeviceValue($input['device_value']);
        }
        if (isset($input['device_encrypt'])){
            $req->setDeviceEncrypt($input['device_encrypt']);
        }
        if (isset($input['device_type'])){
            $req->setDeviceType($input['device_type']);
        }
        if (isset($input['content_id'])){
            $req->setContentId($input['content_id']);
        }
        if (isset($input['content_source'])){
            $req->setContentSource($input['content_source']);
        }
        if (isset($input['item_id'])){
            $req->setItemId($input['item_id']);
        }
        $resp = $this->client->execute($req);
        return $resp->result_list->map_data??[];
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
        if (isset($input['material_id'])){
            $req->setMaterialId($input['material_id']);
        }
        if (isset($input['has_coupon'])){
            $req->setHasCoupon($input['has_coupon']);
        }else{
            $req->setHasCoupon('true');
        }
        $req->setAdzoneId(config('tbk.adzone_id'));
        $resp = $this->client->execute($req);
        return $resp->result_list->map_data??[];
    }

    // 拉新活动汇总API--导购
    //拉新活动汇总API--社交
    //淘客媒体内容效果输出
    //淘宝客擎天柱通用物料API - 社交
    //淘礼金创建
    //淘宝联盟官方活动推广API-媒体
    //淘宝联盟官方活动推广API-工具
    //处罚订单查询 -导购-私域用户管理专用
    //导购淘礼金实例维度报表
    
    //补充接口淘宝产品详情
    public function getDetail($item_id)
    {
        $url = "http://h5api.m.taobao.com/h5/mtop.taobao.detail.getdetail/6.0/?data=%7B%22itemNumId%22%3A%22".$item_id."%22%7D";
        $data = $this->curlGet($url);
        if (empty($data) || is_null($data)){
            return new \stdClass();
        }
        return $data['data']??new \stdClass();
    }

    public function curlGet($url)
    {
        $headerArray =array("Content-type:application/json;","Accept:application/json");
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch,CURLOPT_HTTPHEADER,$headerArray);
        $output = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($output,true);
        return $output;
    }
}