@if(isset($products) && $products->count())
	<ul class="pop-offers-list list-unstyled">
	@foreach($products as $product)
		<li class="pop-offers-item">
		@if(!empty($product->image))
			<a class="item-ava" href="#">
				<img src="{{url('image/catalog-product-thumbnail/'.$product->id)}}" alt="{{ $product->title }}" class="avatar bordered circle">
			</a>
		@endif
			<div class="pop-item-expires">
				<a href="{{ slink::createLink('product/'.$product->seo_url.'-'.$product->id) }}">{{ $product->title }}</a>
				<div class="status">
					<div class="line">
						<span class="txt-color-red"><strong><span class="fa fa-clock-o"></span> 10 дней</strong></span> до окончания
					</div>
					<div class="line">
						<strong>1 предмет</strong> доступен
					</div>
					<div class="line last">
						<strong>10 пользователей</strong> сделали ставки
					</div>
				</div>
			</div>
			<div class="pop-item-price">
				<div class="txt-color-red regular-18 margin-bottom-10">85 301.17руб</div>
				<div class="regular-14">с доставкой<br>92 200.00 руб</div>
			</div>
		</li>
	@endforeach
	</ul>
	{{ $products->links() }}
@endif