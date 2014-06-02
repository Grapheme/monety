@extends('templates.default')
@section('style')
<link rel="stylesheet" href="{{ slink::path('css/fancybox.css') }}" />
<link rel="stylesheet" href="{{slink::path('theme/css/smart-form.css')}}" />
@stop
@section('content')
	<section class="ending-aucs margin-bottom-40">
		<h2 class="margin-bottom-40 regular-24">Завершающиеся аукционы — купить лот, выставить лот</h2>
		<ul class="lots-list list-limited list-unstyled row">
		@for($i=0;$i<8;$i++)
			<li class="lots-item col-xs-6 col-sm-6 col-md-6 col-lg-6 margin-bottom-20">
			<div class="row">
				<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
					<a class="img-cont text-center" href="#">
						<img src="http://goldprice.org/buying-gold/uploaded_images/Australian-Lunar-Gold-Coin-Series-768203.jpg" alt="">
					</a>
				</div>
				<div class="lots-desc col-xs-8 col-sm-8 col-md-8 col-lg-8 regular-14 relative">
					<a href="#">1/2 копейки 1899 1909 1912 1913 спб древняя спарта</a>
					<div class="margin-top-5">
						<span class="fa fa-credit-card"></span> <span>225 руб</span>
					</div>
					<div class="bottom-left">
						<span class="cat-time"><span class="fa fa-clock-o margin-right-5"></span> 11:25:12</span>
						<div class="buy-btns">
							<a href="#" class="to-cart">В корзину</a>
							<a href="#" class="quick-buy">Быстрая покупка</a>
						</div>
					</div>
				</div>
			</div>
			</li>
		@endfor
		</ul>
	</section>
	<section class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
		<div class="news-block">
			<p class="regular-24">{{$news->title}}</p>
			<p class="txt-color-orange regular-14"><i class="fa fa-calendar"></i> {{ myDateTime::SwapDotDateWithoutTime($news->date_publication,TRUE) }} | События</p>
			<div class="news-announce clearfix margin-bottom-15">
			@if($news->thumbnail_image && $news->original_image)
				<div class="news-photo">
					<a class="fancybox" data-fancybox-type="image" href="{{ url('image/news/'.$news->id) }}">
						<img src="{{ slink::createLink('image/news-thumbnail/'.$news->id) }}" alt="{{ $news->title }}" />
					</a>
				</div>
			@endif
				<div class="news-announce-text">{{$news->preview}}</div>
			</div>
			<div class="news-content regular-14 margin-bottom-40">
				{{ sPage::content_render($news->content) }}
			</div>
			<div class="social-block clearfix">
				<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
					<div class="social">
						<a href="#" class="thumbs-up"><i class="fa fa-thumbs-up"></i>123</a>
						<a href="#" class="thumbs-down"><i class="fa fa-thumbs-down"></i>312</a>
					</div>
					<div class="pluso" data-background="transparent" data-options="small,square,line,horizontal,nocounter,theme=04" data-services="vkontakte,odnoklassniki,facebook,twitter,google,moimir,livejournal"></div>
				</div>
				<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
					<h2 class="regular-18">Популярные публикации</h2>
					<p><a href="#" class="regular-16">Алмазы зародились на дне древнего океана?</a></p>
					<p><a href="#" class="regular-16">Предметы украшения интерьера. Модное веяние 2014 года.</a></p>
					<p><a href="#" class="regular-16">«Кто у нас продает?» или 4 типа продавца-консультанта ювелирного салона</a></p>
				</div>
			</div>
			<div class="margin-bottom-40 regular-18">
				<strong>Оставить комментарий к записи:</strong> <i class="light-font">Упрощено таможенное декларирование драгметаллов, драгкамней и сырья</i>
			</div>
			<div class="comment">
				<p><a href="#">Username</a> | 12.02.2004</p>
				<p>Компания является крупнейшим производителем ювелирных изделий в мире и объединяет такие бренды, как Cartier и Van Cleef & Arpels, Jaeger-LeCoultre, 
				Piaget, IWC, Baume Mercier, Vacheron Constantin, Officine Panerai, A.Lange Sohne, Montblanc, Montegrappa, Alfred Dunhill, Chloe и Lancel. Концерн Tiffany & Co., 
				который удерживает вторую строчку лидерства в отрасли, по итогам третьего квартала 2013 финансового года увеличил чистую прибыль на рекордные 50  %, до $94,6 млн., 
				или $0,73 на акцию. При этом выручка компании увеличилась до $922 млн., что на      7  % больше показателя за аналогичный период 2012 года.</p>
			</div>
			<div class="comment-leave">
			@if(Auth::guest())
				<p>Вы не авторизованы. <a href="{{ slink::createLink('login') }}">Вход</a> | <a href="{{ slink::createLink('login') }}">Регистрация</a></p>
			@endif
				@include('templates.send-comment-form')
			</div>
		</div>
	</section>
	<section class="col-xs-3 col-sm-3 col-md-3 col-lg-3 margin-bottom-40 left-info-block">
		<h2 class="regular-20"><span class="fa fa-rss "></span> Лента новостей</h2>
		{{ sPage::content_render('[news path="news-index-page" limit="3" field="date_publication" direction="desc"]') }}
		<h2 class="regular-20"><span class="fa fa-pencil "></span> Статьи</h2>
		{{ sPage::content_render('[articles path="articles-index-page" limit="3" field="created_at" direction="desc"]') }}
	</section>
	<div class="clearfix"></div>
	<section class="ending-aucs margin-bottom-40">
	<h2 class="margin-bottom-40 regular-24">Завершающиеся аукционы — купить лот, выставить лот</h2>
		<ul class="lots-list list-unstyled row">
		@for ($i=0;$i<8;$i++)
			<li class="lots-item col-xs-6 col-sm-6 col-md-6 col-lg-6 margin-bottom-20">
				<div class="row">
					<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
						<a class="img-cont text-center" href="#">
							<img src="http://goldprice.org/buying-gold/uploaded_images/Australian-Lunar-Gold-Coin-Series-768203.jpg" alt="">
						</a>
					</div>
					<div class="lots-desc col-xs-8 col-sm-8 col-md-8 col-lg-8 regular-14 relative">
						<a href="#">1/2 копейки 1899 1909 1912 1913 спб древняя спарта</a>
						<div class="margin-top-5">
							<span class="fa fa-credit-card"></span> <span>225 руб</span>
						</div>
						<div class="bottom-left">
							<span class="cat-time"><span class="fa fa-clock-o margin-right-5"></span> 11:25:12</span>
							<div class="buy-btns">
								<a href="#" class="to-cart">В корзину</a>
								<a href="#" class="quick-buy">Быстрая покупка</a>
							</div>
						</div>
					</div>
				</div>
			</li>
		@endfor
		</ul>
	</section>
@stop
@section('scripts')
{{HTML::script('js/vendor/jquery.fancybox.pack.js')}}
@if(AuthAccount::isUserLoggined())
{{HTML::script('js/account/user.js')}}
@endif
<script type="text/javascript">
	$(".fancybox").fancybox({type : "image",padding: 15,helpers: {overlay: {locked: false}}});
	@if(AuthAccount::isUserLoggined())
		if(typeof pageSetUp === 'function'){pageSetUp();}
		if(typeof runFormValidation === 'function'){
			loadScript("{{asset('js/vendor/jquery-form.min.js');}}",runFormValidation);
		}else{
			loadScript("{{asset('js/vendor/jquery-form.min.js');}}");
		};
	@endif
</script>
@stop