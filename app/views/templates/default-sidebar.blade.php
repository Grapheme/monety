<?php
	$catalogTranslit = BaseController::stringTranslite(Catalog::findOrFail(1)->title);
	$categoryGroup = CategoryGroup::findorFail(1);
	$isCatalog = FALSE;
	$catalogValidNames = Catalog::getCatalogsTranslitNames();
	if(in_array(Request::segment(1),$catalogValidNames)):
		$isCatalog = TRUE;
	endif;
	if($isCatalog && !is_null(Request::segment(2))):
		$url_category = Request::segment(2);
		if(Request::segment(1) == 'product'):
			$product_id = getItemIDforURL($url_category);
			if(!Session::has('products.active_category_url')):
				if($first_product_category = Product::find($product_id)->categories()->first()):
					$url_category = $first_product_category->seo_url.'-'.$first_product_category->id;
					Session::put('products.active_category_url',$url_category);
				endif;
			else:
				$url_category = Session::get('products.active_category_url');
			endif;
		endif;
		$sub_categories_ids = array(0,0);
		$sub_categories_ids[0] = getItemIDforURL($url_category);
		if($parent_category = Category::getParentCategory($categoryGroup->id,$url_category)):
			$sub_categories_ids[1] = $parent_category->id;
		endif;
		if(Request::segment(1) == 'product' && isset($product_id)):
			$prdIDs = Category::where('publication',1)->find($sub_categories_ids[0])->products()->where('product_id',$product_id)->lists('product_id');
			if(!in_array($product_id,$prdIDs)):
				if($first_product_category = Product::find($product_id)->categories()->first()):
					$url_category = $first_product_category->seo_url.'-'.$first_product_category->id;
					Session::put('products.active_category_url',$url_category);
				endif;
				$sub_categories_ids = array(0,0);
				$sub_categories_ids[0] = getItemIDforURL($url_category);
				if($parent_category = Category::getParentCategory($categoryGroup->id,$url_category)):
					$sub_categories_ids[1] = $parent_category->id;
				endif;
			endif;
		endif;
	endif;
?>

<aside class="aside col-xs-2 col-sm-2 col-md-2 col-lg-2">
	<h2 class="aside-header">{{ $categoryGroup->title }}</h2>
	<ul class="aside-list list-unstyled">
	@foreach(Category::getCategories($categoryGroup->id) as $categories)
		<li class="aside-item">
			<a href="{{ url($catalogTranslit.'/'.$categories->seo_url.'-'.$categories->id) }}">{{ $categories->title }}</a>
		@if($isCatalog && !is_null($url_category) && in_array($categories->id,$sub_categories_ids))
			<ul class="aside-list list-unstyled margin-left-10">
			@foreach(Category::getCategories($categoryGroup->id,$url_category) as $sub_categories)
			<li class="aside-item">
				<a href="{{ url($catalogTranslit.'/'.$sub_categories->seo_url.'-'.$sub_categories->id) }}">{{ $sub_categories->title }}</a>
			</li>
			@endforeach
			</ul>
		@endif
		</li>
	@endforeach
	</ul>
	<h2 class="aside-header">Каталог монет</h2>
	<ul class="aside-list list-unstyled">
		<li class="aside-item"><a href="#">Наборы монет</a></li>
		<li class="aside-item"><a href="#">Банкноты</a></li>
		<li class="aside-item"><a href="#">Подарочные наборы</a></li>
		<li class="aside-item"><a href="#">Аксессуары</a></li>
		<li class="aside-item"><a href="#">Металлоискатели</a></li>
		<li class="aside-item"><a href="#">Программа нумизмата</a></li>
		<li class="aside-item"><a href="#">Приложния для смартфона</a></li>
	</ul>
	<h2 class="aside-header">Аукцион монет</h2>
	<ul class="aside-list list-unstyled">
		<li class="aside-item"><a href="#">Аукцион монет</a></li>
		<li class="aside-item"><a href="#">Правила аукциона</a></li>
	</ul>
	<h2 class="aside-header">Нумизмату</h2>
	<ul class="aside-list list-unstyled">
		<li class="aside-item"><a href="#">Главная</a></li>
		<li class="aside-item"><a href="#">Новости нумизматики</a></li>
		<li class="aside-item"><a href="#">Канал новостей</a></li>
		<li class="aside-item"><a href="#">Библиотека нумизмата</a></li>
		<li class="aside-item"><a href="#">Клуб Нумизмат</a></li>
		<li class="aside-item"><a href="#">Регистрация</a></li>
		<li class="aside-item"><a href="#">Форум нумизматов</a></li>
		<li class="aside-item"><a href="#">Архив форума</a></li>
		<li class="aside-item"><a href="#">Черный список</a></li>
		<li class="aside-item"><a href="#">Форум кладоискателей</a></li>
		<li class="aside-item"><a href="#">Объявления пользователей</a></li>
		<li class="aside-item"><a href="#">Нужны монеты</a></li>
		<li class="aside-item"><a href="#">New ценник на монеты</a></li>
		<li class="aside-item"><a href="#">Стоимость монет</a></li>
		<li class="aside-item"><a href="#">Нумизматический чат</a></li>
		<li class="aside-item"><a href="#">Распознавание монет</a></li>
		<li class="aside-item"><a href="#">Юбилейные монеты</a></li>
		<li class="aside-item"><a href="#">Монета, история</a></li>
		<li class="aside-item"><a href="#">Подписка</a></li>
		<li class="aside-item"><a href="#">Видео для нумизматов</a></li>
		<li class="aside-item"><a href="#">Игровой раздел</a></li>
		<li class="aside-item"><a href="#">Антиквариат</a></li>
		<li class="aside-item"><a href="#">Золотой червонец</a></li>
		<li class="aside-item"><a href="#">Антикварное обозрение</a></li>
	</ul>
</aside>