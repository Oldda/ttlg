<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta name="referrer" content="never">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    data_used:[
        apk_download_url:'http://pub.wukehui.cn'.{{$apk->downloadurl}}
        seller_logo: <img src="{{$product['seller']['shopIcon']}}" alt="shopIcon">
        seller_title:{{$product['base']->nick}}

        @foreach($product['base']->small_images->string as $img)
            <img src="{{$img}}" alt="">
        @endforeach
        product_is_baoyou:{{$product['base']->free_shipment??''}}
        product_title:{{$product['base']->title}}
        product_price_before_coupon:{{$product['base']->zk_final_price}}
        product_price_after_coupon: {{$product['base']->zk_final_price - $coupon->coupon_amount}}
        product_selled_in_30:{{$product['base']->volume}}
        product_desc_images:{{$product['item']['tmallDescUrl']}}

        coupon_amount: {{$coupon->coupon_amount}}
        coupon_start_time:{{$coupon->coupon_start_time}}
        coupon_end_time:{{$coupon->coupon_end_time}}
        coupon_get_url:{{$coupon->coupon_share_url}}
        <a href="{{$coupon->coupon_share_url}}">立即领券</a>

        @foreach($pics as $data)
            @if(isset($data['params']['picUrl']))
                <img src="{{$data['params']['picUrl']}}" alt="">
            @endif
        @endforeach
    ]
</body>
</html>