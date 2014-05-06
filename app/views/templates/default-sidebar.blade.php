<?
	$catalogTranslit = BaseController::stringTranslite(Catalog::findOrFail(1)->title);
	$categoryGroup = CategoryGroup::findorFail(1);
	$sub_categories_ids = array(0,0);
	if(!is_null(Request::segment(2))):
		$sub_categories_ids[0] = getItemIDforURL(Request::segment(2));
		if($parent_category = Category::getParentCategory($categoryGroup->id,Request::segment(2))):
			$sub_categories_ids[1] = $parent_category->id;
		endif;
	endif;
	
//	print_r($sub_categories_ids);exit;
	
?>

<aside class="aside col-xs-2 col-sm-2 col-md-2 col-lg-2">
	<h2 class="aside-header">{{ $categoryGroup->title }}</h2>
	<ul class="aside-list list-unstyled">
	@foreach(Category::getCategories($categoryGroup->id) as $categories)
		<li class="aside-item">
			<a href="{{ url($catalogTranslit.'/'.$categories->seo_url.'-'.$categories->id) }}">
			@if(!is_null(Request::segment(2)) && in_array($categories->id,$sub_categories_ids))
				<i class="fa fa-folder-open-o"></i>
			@else
				<i class="fa fa-folder-o"></i>
			@endif
				{{ $categories->title }}
			</a>
		@if(!is_null(Request::segment(2)) && in_array($categories->id,$sub_categories_ids))
			<ul class="aside-list list-unstyled margin-left-10">
			@foreach(Category::getCategories($categoryGroup->id,Request::segment(2)) as $sub_categories)
			<li class="aside-item">
				<a href="{{ url($catalogTranslit.'/'.$sub_categories->seo_url.'-'.$sub_categories->id) }}">
					{{ in_array($sub_categories->id,$sub_categories_ids) ? '<i class="fa fa-check-circle-o"></i>' : '<i class="fa fa-circle-o"></i>' }} {{ $sub_categories->title }}
				</a>
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