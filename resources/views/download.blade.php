<!DOCTYPE html>
<html>
<script>
	// function ismobile(){
	// 	var u = navigator.userAgent, app = navigator.appVersion;
	// 	if(/AppleWebKit.*Mobile/i.test(navigator.userAgent) || (/MIDP|SymbianOS|NOKIA|SAMSUNG|LG|NEC|TCL|Alcatel|BIRD|DBTEL|Dopod|PHILIPS|HAIER|LENOVO|MOT-|Nokia|SonyEricsson|SIE-|Amoi|ZTE/.test(navigator.userAgent))){
	// 		if(window.location.href.indexOf("?mobile")<0){
	// 			try{
	// 				if(/iPhone|mac|iPod|iPad/i.test(navigator.userAgent)){
	// 					return '0';
	// 				}else{
	// 					return '1';
	// 				}
	// 			}catch(e){}
	// 		}
	// 	}else if( u.indexOf('iPad') > -1){
	// 		return '0';
	// 	}else{
	// 		return '1';
	// 	}
	// };
	// const client = ismobile();
	// if (client != 1){
	// 	alert('暂不支持IOS版本，敬请期待');
	// }

	function download (url){
		var browser = {
			versions: function () {
				var u = navigator.userAgent, app = navigator.appVersion;
				return {         //移动终端浏览器版本信息
					trident: u.indexOf('Trident') > -1, //IE内核
					presto: u.indexOf('Presto') > -1, //opera内核
					webKit: u.indexOf('AppleWebKit') > -1, //苹果、谷歌内核
					gecko: u.indexOf('Gecko') > -1 && u.indexOf('KHTML') == -1, //火狐内核
					mobile: !!u.match(/AppleWebKit.*Mobile.*/), //是否为移动终端
					ios: !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/), //ios终端
					android: u.indexOf('Android') > -1 || u.indexOf('Linux') > -1, //android终端或uc浏览器
					iPhone: u.indexOf('iPhone') > -1, //是否为iPhone或者QQHD浏览器
					iPad: u.indexOf('iPad') > -1, //是否iPad
					webApp: u.indexOf('Safari') == -1 //是否web应该程序，没有头部与底部
				};
			}(),
			language: (navigator.browserLanguage || navigator.language).toLowerCase()
		}
		if (browser.versions.mobile) {//判断是否是移动设备打开
			var ua = navigator.userAgent.toLowerCase();//获取判断用的对象
			if (ua.match(/MicroMessenger/i) == "micromessenger") {
				//在微信中打开
				if(browser.versions.android){
					window.open(url);
				}
				if(browser.versions.ios){
					alert('暂不支持IOS版本，敬请期待')
				} 
			}else if(browser.versions.ios) {
				//在IOS浏览器打开
				alert('暂不支持IOS版本，敬请期待')
			}else if(browser.versions.android){
				//在安卓浏览器打开
				window.open(url);
			}
		} else {
				//否则就是PC浏览器打开
				window.open(url);
		}
	}
	
</script>
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
				<a><img onclick="download('{{$img->link}}')" src="{{$img->img}}" alt="{{$img->title}}"/></a>
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
								<p><em style="font-size: 12px;">￥{{$good->now_price}}</em><s style="font-size: 12px;">淘宝价￥{{$good->tb_price}}</s>
								<span style="display:block">已售{{$good->sale_num}}件</span>
							</p>
							</div>
							<div class="sale">
								<img src="static/img/sale_bg.jpg"/>
								<div class="sale-mc justify">
									<div class="num">￥{{$good->coupon_quota}}</div>
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
