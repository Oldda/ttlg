<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <title>商品详情</title>
        <link rel="stylesheet" href="{{asset('static/css/swiper.min.css')}}">
        <link rel="stylesheet" href={{asset('static/css/demo.css')}}>
        <script src={{asset('static/js/jquery-2.1.4.min.js')}}></script>
        <script src={{asset('static/js/swiper.min.js')}}></script>
        <style>
            *{
                -webkit-overflow-scrolling: touch;
            }
        </style>   
    <title>Document</title>
</head>
<script>document.querySelector('html').style.fontSize = (document.body.clientWidth / 375 * 16 + 'px');
    window.addEventListener('resize', function () {
        window.location.reload();
    })
</script>
<header style="text-indent: 0rem;height:0px;">
    <a href="{{$apk['downloadurl']}}" style="display:block;height:36.44px;"><img src="{{asset('static/img/12.jpg')}}" alt="" style="width: 100%; height: auto; margin-left: 0px;"></a>
{{--        更多优惠请下载--}}
{{--    <span class="shou" onclick="javascript:window.open('{{$apk->downloadurl}}')">天天乐购</span>--}}
</header>
<div class="content">
    <div class="c-box">
        <div class="box">
            <div class="c-header">
                <img src="{{$product['seller']['shopIcon']??''}}" alt="">
                <span style="font-size:14px;font-weight:normal;">{{$product['base']['nick']}}</span>
            </div>
            <div class="swiper-container">
                    <div class="swiper-wrapper">
                        @foreach($product['base']['small_images']['string'] as $img)
                            <div class="swiper-slide">
                                <img src={{$img}} alt="">
                            </div>
                        @endforeach
{{--                        <div class="swiper-slide">--}}
{{--                            <img src="./img/1.jpg" alt="">--}}
{{--                        </div>--}}
{{--                        <div class="swiper-slide">--}}
{{--                            <img src="./img/1.jpg" alt="">--}}
{{--                        </div>--}}
                    </div>
                    <div class="swiper-pagination"></div>
            </div>
            <div class="c-content dddd">
                <div class="top">
                    {{isset($product['base']['free_shipment'])?"<span>包邮</span>":''}}
                    <span style="background:none;font-size:15px;margin:0px;display:inline-block;padding:5px 7px 0px 13px;">{{$product['base']['title']}}</span>
                </div>
                <div class="bottom" style="line-height:25px;">
                    <span style="font-size:12px;position:relative;top:-2px;margin-left:0.7875rem;">用券后</span>
                    <span style="margin-left:-10px;font-size:18px;">￥{{$product['base']['zk_final_price'] - $coupon['coupon_amount']}}</span>
                    <span style="margin-left:7px;position:relative;top:-1.7px;">现价￥{{$product['base']['zk_final_price']}}</span>
                    <span style="font-size:13px;color:#999;">已售{{$product['base']['volume'] < 10000 ? $product['base']['volume'] : round($product['base']['volume'] / 10000, 2) . '万'}}件</span>
                </div>
            </div>
        </div>
    </div>
    <div class="detail">
        <span class="line"></span>
        <span class="text" style="font-size:14px;">宝贝详情</span>
        <span class="line"></span>
    </div>
    <div style="margin: 0px;padding: 0px;text-align: center;text-indent: 0px;">
        @foreach($pics as $data)
            @if(isset($data['params']['picUrl']))
                <img src="{{$data['params']['picUrl']}}" alt="" style="margin: 0px;padding: 0px; width: 100%; height: 100%;vertical-align:top; display:block;">
            @endif
        @endforeach
    </div>
    <div class="c-img" style="background-image: none;height: 0px;width: 100%;">
        <div class="i-content" style="position: fixed;bottom:0;z-index: 100000;">
            <div class="i-left">
                <div>
                    <span>
{{--                        券剩余{{$coupon->coupon_amount}}--}}
                        立省
                        <span class="sss">{{$coupon['coupon_amount']}}</span>
                        元
                    </span>
                    <span style="font-size: 8px;">
                        使用期限：{{$coupon['coupon_start_time']}}~{{$coupon['coupon_end_time']}}
                    </span>
                </div>
            </div>
            <div class="i-right">
                <span class="shou" onclick="javascript:window.location.href='{{(strpos($coupon['coupon_share_url'],'https://') !== false) ? $coupon['coupon_share_url'] : 'https://'.$coupon['coupon_share_url']}}'">领券购买</span>
            </div>
        </div>
    </div>
    <div class="detail">
        <span class="line"></span>
        <span class="text">
            用券说明
        </span>
        <span class="line"></span>
    </div>
    <div class="header">
        <div class="h-content">
            <div class="a">
                02
                <div class="detail">
                    <span class="line"></span>
                    <span class="text">如何领取优惠券</span>
                    <span class="line"></span>
                </div>
            </div>
            <div class="text">
                <div>第一步</div>
                <div>通过今日精选、商品分类，搜索关键字找到自己喜欢的商品</div>
            </div>
            <div class="bg-img yi-img">

            </div>
            <div class="text">
                <div>第二步</div>
                <div>
                    点击商品进入详情页，然后点击
                    <span class="btn-b">立即领券</span>
                    会自动跳转到淘宝对应的商品页面
                </div>
            </div>
            <div class="bg-img er-img">

            </div>
            <div class="text">
                <div>第三步</div>
                <div>在淘宝商品页面点击
                    <span class="btn-b">立即购买</span>
                    选好商品后点击
                    <span class="btn-b">确认</span>
                    在确认订单页面就可以看到领取的优惠券生效
                </div>
            </div>
            <div class="bg-img san-img">
            </div>
        </div>
    </div>
</div>
</body>
<script>
    var mySwiper = new Swiper('.swiper-container', {
        pagination : '.swiper-pagination',
    })
</script>
</html>