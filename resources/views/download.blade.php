<!DOCTYPE html>
<html>
<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "https://hm.baidu.com/hm.js?ed37aa0def56eb5a89ba3cf187f34623";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>
<head>
    <meta charset="utf-8">
    <title>省钱大作战-618</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="author" content="youku.com">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no" />
    <link rel="stylesheet" href="http://static.youku.com/v1.0.128/index/css/yk_mobile.css"/>
    <link href="static/css/reset.css" rel="stylesheet" type="text/css"/>
    <link href="static/css/style.css" rel="stylesheet" type="text/css"/>
    <script src="//h5.sinaimg.cn/upload/100/1325/2018/09/14/flexible.js"></script>
</head>
<body>
<div class="wrap">
    <header class="header">
	@if(count($imgs)>0)
		@foreach ($imgs as $img)
			@if($img->cate == 1)
				<a href="{{$img->link}}"><img src="{{$img->img}}" alt="{{$img->title}}"/></a>
			@endif
		@endforeach
	@endif
	</header>
    <section class="main">
        <ul>
			@if(count($goods)>0)
				@foreach($goods as $good)
					<li>
						<div class="list">
							<a href="{{$good->coupon_link}}"><img src="{{$good->img}}"/></a>
							<div class="name">{{$good->goods_name}}</div>
							<div class="price justify">
								<p><em>￥{{$good->now_price}}</em><s>淘宝价￥{{$good->tb_price}}</s></p>
								<span>已售{{$good->sale_num}}件</span>
							</div>
							<div class="sale">
								<img src="static/img/sale_bg.jpg"/>
								<div class="sale-mc justify">
									<div class="num">{{$good->coupon_quota}}</div>
									<div class="info justify">
										<p class="message center">
											<span>优惠券</span>
											<em>{{date('m-d',strtotime($good->start_time))}}至{{date('m-d',strtotime($good->end_time))}}</em>
										</p>
										<p class="btn"><a href="{{$good->coupon_link}}"><img src="static/img/button.jpg"/></a></p>
									</div>
								</div>
							</div>
						</div>
					</li>
				@endforeach
			@endif
        </ul>
    </section>
    <footer class="footer">
	@if(count($imgs)>0)
		@foreach ($imgs as $img)
			@if($img->cate == 2)
				<a href="{{$img->link}}"><img src="{{$img->img}}" alt="{{$img->title}}"/></a>
			@endif
		@endforeach
	@endif
	</footer>
</div>
</body>
</html>
