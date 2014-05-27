@if(isset($products) && $products->count())
	@if($products->count() < $products_count)
		<div class="row">
			<div class="alert alert-warning fade in">
				<i class="fa-fw fa fa-warning"></i>
				<strong>Внимание!</strong> Отобрано {{ $products->count() }} результов из {{ $products_count }} возможных. Измените условия поиска для более точного результата
			</div>
		</div>
	@endif
	<div class="row">
		<div class="pull-right">
			<a href="{{ slink::createAuthLink('register-lot/new-catalog-product') }}" class="btn btn-link no-padding no-margin">Не нашли свою монету в каталоге?</a>
		</div>
	</div>
	<ul class="pop-offers-list list-unstyled">
	@foreach($products as $product)
		<li class="pop-offers-item">
		@if(!empty($product->image))
			<a class="item-ava" href="{{ slink::createLink('product/'.$product->seo_url.'-'.$product->id) }}">
				<img src="{{url('image/catalog-product-thumbnail/'.$product->id)}}" alt="{{ $product->title }}" class="avatar bordered circle">
			</a>
		@endif
			<div class="pop-item-expires">
				<a class="no-margin" href="{{ slink::createLink('product/'.$product->seo_url.'-'.$product->id) }}">{{ $product->title }}</a>
			@if($product->categories->count())
				<div class="line">
				@foreach($product->categories as $category)
					@if(!empty($category['link2']))
					<a href="{{ url($category['link1']) }}">{{ $category['name1'] }}</a> :: <a href="{{ url($category['link2']) }}">{{ $category['name2'] }}</a>
					@else
					<a href="{{ url($category['link1']) }}">{{ $category['name1'] }}</a>
					@endif
				@endforeach
				</div>
			@endif
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
			<div class="pop-item-action">
				<div class="regular-14">
				@if($product->publication == 1)
					<button class="btn btn-link register-lot-choice-product" data-product="{{ $product->id }}">Да, это моя монета</button>
				@else
					<div class="alert alert-info fade in">
						<i class="fa-fw fa fa-info"></i>
						Находится на модерации
					</div>
				@endif
				</div>
			</div>
		</li>
	@endforeach
	</ul>
@endif