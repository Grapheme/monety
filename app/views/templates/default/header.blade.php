<header>
	<div class="row max-width-class margin-auto">
		@if(Request::is('/'))
			<h1 class="col-xs-3 col-sm-3 col-md-3 col-lg-3 text-center">monety.pro</h1>
		@else
			<a href="{{url('/');}}"><h1 class="col-xs-3 col-sm-3 col-md-3 col-lg-3 text-center">monety.pro</h1></a>
		@endif
		<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 margin-top-5">
			<form class="search-form" role="form">
				<input type="text" class="search-input" placeholder="Что ищем?">
			<button class="search-btn"><i class="fa fa-search"></i></button>
			</form>
			<div class="head-actions margin-top-10 margin-bottom-10 text-center">
				<button type="button" class="header-btn blue-btn">Купить монеты</button>
				<button type="button" class="header-btn yel-btn">Продать монеты</button>
			</div>
		</div>
		<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
			<div class="best-good">
				<div class="best-good-capt text-center">
					<span class="fa fa-trophy regular-14 margin-right-5"></span> <span class="semibold-14 uppercase">Товар дня</span>
				</div>
				<div class="row margin-top-5 margin-bottom-10">
					<div class="col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-lg-offset-2 col-xs-4 col-sm-4 col-md-4 col-lg-4">
						<figure class="ava">
							<a href="#">
								<img class="circle" src="http://upload.wikimedia.org/wikipedia/commons/c/c5/Abraham_Lincoln_$1_Presidential_Coin_obverse_sketch.jpg" alt="">
							</a>
						</figure>
					</div>
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 regular-12">
						<a href="#">1/2 копейки 1899 1909 1912 1913 спб</a>
						<div class="margin-top-5">
							<span class="fa fa-credit-card"></span> <span>225 руб</span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
		@if(AuthAccount::isUserLoggined())
			<div class="cart text-center">
				<div class="cart-capt">
					<span class="fa fa-shopping-cart regular-14 margin-right-5"></span> <span class="semibold-14 uppercase">Корзина</span>
				</div>
				<div class="cart-cont regular-12">
					<a href="#">5</a> товаров на сумму <span>2500 руб</span>
				</div>
			</div>
		@endif
			<div class="reg text-center margin-top-10">
				<div class="reg-capt">
					<span class="fa fa-user regular-14 margin-right-5"></span> <span class="semibold-14 uppercase">Личный кабинет</span>
				</div>
				<div class="reg-cont regular-12 margin-top-5">
				@if(Auth::guest())
					<a href="{{ url('login') }}" class="margin-right-10">Вход</a>
					<a href="{{ url('login') }}">Регистрация</a>
				@else
					@if(AuthAccount::isUserLoggined())
						<a href="{{ slink::createAuthLink('register-lot') }}" class="margin-right-10">Выставить товар</a>
					@endif
					<a href="{{ slink::createAuthLink() }}" class="margin-right-10">{{ (AuthAccount::isAdminLoggined())?'Администрирование':'Кабинет' }}</a>
					<span id="logout"><a href="{{ url('logout') }}">Выход</a></span>
				@endif
				</div>
			</div>
		</div>
	</div>
	<nav class="main-nav" role="navigation">
		<ul class="nav-list list-unstyled max-width-class text-center">
			<li class="nav-item"><a href="{{ url('news') }}">Новости</a>
			<li class="nav-item"><a href="#">Выставки</a>
			<li class="nav-item"><a href="#">Бизнес</a>
			<li class="nav-item"><a href="{{ url('articles') }}">Публикации</a>
			<li class="nav-item"><a href="#">Карьера</a>
			<li class="nav-item"><a href="#">Организации</a>
			<li class="nav-item"><a href="#">Продукция</a>
			<li class="nav-item"><a href="#">Интерактив</a>
			<li class="nav-item"><a href="#">Справка</a>
			<li class="nav-item"><a href="#">Надзор</a>
		</ul>
	</nav>
	<div>
        <ul class="sub-nav list-unstyled max-width-class">
            <li class="sub-nav-item cat-items"><a href="{{ url('katalog-izdeliiy') }}">Каталог<br>изделий</a>
            <li class="sub-nav-item cat-org"><a href="#">Каталог<br>организаций</a>
            <li class="sub-nav-item forum"><a href="#">Форум<br>ювелиров</a>
            <li class="sub-nav-item rating"><a href="#">Рейтинг<br>сайтов</a>
            <li class="sub-nav-item black-list"><a href="#">Черный<br>список</a>
            <li class="sub-nav-item jew"><a href="#">Ювелирные<br>выставки</a>
            <li class="sub-nav-item masters"><a href="#">Ювелирные<br>мастерские</a>
        </ul>
    </div>
</header>