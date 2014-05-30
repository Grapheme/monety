@extends('templates.default')
@section('style')
<link rel="stylesheet" href="{{ slink::path('css/fancybox.css') }}">
@stop
@section('content')
	@if($lot->publication == 0)
	<article class="row">
		<div class="alert alert-warning fade in">
			<i class="fa-fw fa fa-warning"></i>
			<strong>Внимание!</strong> Лот не опубликован
		</div>
	</article>
	@endif
	<article class="news row margin-bottom-40">
		<section class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
			<h2 class="regular-20">{{ $lot->title }}</h2>
			<div class="status">
			@if($lot->type_lot == 2)
				<div class="line">
					<span class="txt-color-red"><strong><span class="fa fa-clock-o"></span> {{ myDateTime::daysLeftFull($lot->created_at,$lot->auction_period) }} </strong></span> до окончания
				</div>
				<div class="line">
					<strong>{{ $lot->quantity }}</strong> {{ Plural::itemsAvailable($lot->quantity) }}
				</div>
				<div class="line last">
					<strong>10 пользователей</strong> сделали ставки
				</div>
			@else
				<div class="line">
					<strong>Дата:</strong> {{ myDateTime::swapDotDateWithoutTime($lot->created_at) }}
				</div>
			@endif
			</div>
			@if(isset($lot->owner->name))
			<div class="line">
				<strong>Выставыл: </strong> {{ $lot->owner->name }}
			</div>
			@endif
		</section>
	@if(!empty($lot->attributes))
		<section class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
			<h3 class="regular-20">Свойства лота</h3>
			<ul class="news-list list-unstyled regular-12 margin-bottom-10">
			@foreach($lot->attributes as $attrLable => $attrValue)
				<li class="news-item margin-bottom-10">
					<div class="news-text">
						{{ $attrLable }}: {{ $attrValue }}
					</div>
				 </li>
			@endforeach
			</ul>
		</section>
	@endif
	@if(!empty($lot->images))
		<section class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
			<h3 class="regular-20">Изображения товара</h3>
			<ul class="artcl-list list-unstyled regular-12 margin-bottom-10">
			@foreach($lot->images as $image)
				<li class="news-item margin-bottom-10">
					<a class="fancybox" rel="group" data-fancybox-type="image" href="{{ url('image/slider-image/'.$image->id) }}">
						<img alt="{{ $image->title }}" src="{{ url('image/slider-image-thumbnail/'.$image->id) }}">
					</a>
				</li>
			@endforeach
			</ul>
		</section>
	@endif
	</article>
	<article class="row margin-top-20">
		<section class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
			{{ sPage::content_render($lot->description) }}
		</section>
		<section class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
			@if($lot->type_lot == 1)
			<div class="pop-item-price">
				<div class="txt-color-red regular-18 margin-bottom-10">{{ number_format($lot->shop_price,2,'.',' ') }} руб</div>
				<div class="regular-14">с доставкой<br>{{ number_format($lot->shop_price,2,'.',' ') }} руб</div>
				@if(AuthAccount::isUserLoggined())
				<button class="btn btn-success btn-xs">Купить</button>
				@endif
			</div>
			@elseif($lot->type_lot == 2 && $lot->auction_blitc_price > 0)
			<div class="pop-item-price">
				<div class="txt-color-red regular-18 margin-bottom-10">{{ number_format($lot->auction_blitc_price,2,'.',' ') }} руб</div>
				<div class="regular-14">с доставкой<br>{{ number_format($lot->auction_blitc_price,2,'.',' ') }} руб</div>
				@if(AuthAccount::isUserLoggined())
				<button class="btn btn-success btn-xs">Купить по блиц-цене</button>
				<button class="btn btn-success btn-xs">Сделать ставку</button>
				@endif
			</div>
			@endif
		</section>
	</article>
@stop
@section('scripts')
<script src="{{ slink::path('js/vendor/jquery.fancybox.pack.js') }}"></script>
<script type="text/javascript">
	$(".fancybox").fancybox({type : "image",padding: 15,helpers: {overlay: {locked: false}}});
</script>
@stop