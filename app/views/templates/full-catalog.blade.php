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
				<div>
				@if(isset($content))
					{{ $category_content }}
				@endif
				@if(isset($content))
					{{ $content }}
				@endif
				</div>
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
				<div class="pop-offers">
				@if(isset($products) && $products->count())
					<h3 class="margin-bottom-40 regular-20">Список продукции</h3>
				@endif
				@include('templates.catalog')
				@if(isset($products) && $products->count() == 0)
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