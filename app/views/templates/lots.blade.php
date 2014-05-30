@if(isset($lots) && $lots->count())
	<ul class="pop-offers-list list-unstyled">
	@foreach($lots as $lot)
		<li class="pop-offers-item">
			<div class="pop-item-expires">
				<a href="{{ slink::createLink('auction/'.BaseController::stringTranslite($lot->title).'-'.$lot->id) }}">{{ $lot->title }}</a>
				<div class="">
					{{ Str::words(strip_tags($lot->description),50,' ...') }}
				</div>
				<div class="status">
				@if($lot->type_lot == 2)
					<div class="line">
						<span class="txt-color-red"><strong><span class="fa fa-clock-o"></span> {{ myDateTime::daysLeftFull($lot->created_at,$lot->auction_period) }} </strong></span> до окончания
					</div>
					<div class="line">
						<strong>1 предмет</strong> доступен
					</div>
					<div class="line last">
						<strong>10 пользователей</strong> сделали ставки
					</div>
				@else
					<div class="line">
						<strong>Дата:</strong> {{ myDateTime::swapDotDateWithoutTime($lot->created_at) }}
					</div>
				@endif
				@if(isset($lot->owner->name))
				<div class="line">
						<strong>Выставыл: </strong> {{ $lot->owner->name }}
					</div>
				</div>
				@endif
			</div>
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
		</li>
	@endforeach
	</ul>
@endif