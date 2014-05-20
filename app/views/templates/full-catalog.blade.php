<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
 <head>
	@include('templates.default.head')
	@yield('style')
</head>
<body>
	<!--[if lt IE 7]>
		<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
	<![endif]-->
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
	@include('templates.default.header')
	<main class="row content max-width-class" role="main">
		@include('templates.default-sidebar')
		<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 main-cont">
			<section class="popular margin-bottom-40">
				<h2 class="margin-bottom-40 regular-24">
				@if($parent_category = Category::getParentCategory(CategoryGroup::findorFail(1)->id,Request::segment(2)))
					{{ $parent_category->title }} ::
				@endif
				@if($category = Category::find(getItemIDforURL(Request::segment(2))))
					{{ $category->title }}
				@endif
				</h2>
				<div class="pop-filters">
					<div class="sort inline-block">
						Сортировать
						<select class="form-control inline-block">
							<option>по названию</option>
							<option>по цене</option>
						</select>
					</div>
					<div class="pages inline-block">
						Страница
						<select class="form-control inline-block">
							<option>25</option>
						</select>
						из 1000
					</div>
					<div class="look-btns inline-block">
						<button class="look-btn"><span class="fa fa-bars"></span></button>
						<button class="look-btn"><span class="fa fa-list"></span></button>
						<button class="look-btn"><span class="fa fa-th-large"></span></button>
					</div>
				</div>
				@if(isset($content))
					{{ $content }}
				@endif
				<div class="pop-offers">
				@if(isset($products) && $products->count())
					<h3 class="margin-bottom-40 regular-20">Список продукции</h3>
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
				@else
					<h3 class="margin-bottom-40 regular-20">Список продукции пуст</h3>
				@endif
				</div>
			</section>
		</div>
	</main>
	@include('templates.default.footer')
	@include('templates.default.scripts')
	@yield('scripts')
</body>
</html>