<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>商品详情</title>
    <link rel="stylesheet" href="http://localhost/ttlg/public/static/css/swiper.min.css">
    <link rel="stylesheet" href={{public_path('static/css/demo.css')}}>
    <script src={{public_path('static/js/jquery-2.1.4.min.js')}}></script>
    <script src={{public_path('static/js/swiper.min.js')}}></script>
</head>
<body>
<script>document.querySelector('html').style.fontSize = (document.body.clientWidth / 375 * 16 + 'px');
    window.addEventListener('resize', function () {
        window.location.reload();
    })
</script>
<header>
    更多优惠请下载
    <span class="shou">天天乐购</span>
</header>
<div class="content">
    <div class="c-box">
        <div class="box">
            <div class="c-header">
                <img src="./static/img/天猫.png" alt="">
                <span>情梳万缕旗舰店</span>
            </div>
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <img src={{public_path('static/img/1.jpg')}} alt=""></div>
                    <div class="swiper-slide">
                        <img src="./img/1.jpg" alt="">
                    </div>
                    <div class="swiper-slide">
                        <img src="./img/1.jpg" alt="">
                    </div>
                </div>
                <div class="swiper-pagination"></div>
            </div>
            <div class="c-content dddd">
                <div class="top">
                    <span>包邮</span>
                    <span>小ck情书包百搭款链条包蝴蝶结</span>
                </div>
                <div class="bottom">
                    <span>用券后</span>
                    <span>￥29</span>
                    <span>现价￥119</span>
                    <span>已售5.49万件</span>
                </div>
            </div>
        </div>
    </div>
    <div class="detail">
        <span class="line"></span>
        <span class="text">宝贝详情</span>
        <span class="line"></span>
    </div>
    <div class="c-img">
        <div class="i-content">
            <div class="i-left">
                <div>
                    <span>
                        立省
                        <span class="sss">3</span>
                        元
                    </span>
                    <span>
                        使用期限：6月21日~6月23日
                    </span>
                </div>
            </div>
            <div class="i-right">
                <span class="shou">领券购买</span>
            </div>
        </div>
    </div>
    <div class="c-img er">
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

