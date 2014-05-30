@if(isset($products) && $products->count())
	<ul class="pop-offers-list list-unstyled">
	@foreach($products as $product)
		<li class="pop-offers-item">
		@if(!empty($product->image))
			<a class="item-ava" href="{{ slink::createLink('product/'.$product->seo_url.'-'.$product->id) }}">
				<img src="{{url('image/catalog-product-thumbnail/'.$product->id)}}" alt="{{ $product->title }}" class="avatar bordered circle">
			</a>
		@endif
			<div class="pop-item-expires">
				<a href="{{ slink::createLink('product/'.$product->seo_url.'-'.$product->id) }}">{{ $product->title }}</a>
				<div class="">
					{{ Str::words(strip_tags($product->description),50,' ...') }}
				</div>
				<div class="status">
					<div class="line">
						Выставлено на аукцион: <strong>{{ $product->in_auction }}</strong> {{ Plural::items($product->in_auction) }}
					</div>
					<div class="line last">
						В магазине: <strong>{{ $product->in_shop }}</strong> {{ Plural::items($product->in_shop) }}
					</div>
				</div>
			</div>
			<div class="pop-item-action">
			@if(AuthAccount::isUserLoggined())
				<a class="btn btn-success btn-xs" href="{{ slink::createAuthLink('register-lot?product_id='.$product->id) }}">Продать монеты</a>
			@endif
			</div>
		</li>
	@endforeach
	</ul>
	{{ $products->links() }}
@endif