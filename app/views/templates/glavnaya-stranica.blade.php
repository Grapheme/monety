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
		<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
<section class="ending-aucs margin-bottom-40">
	<h2 class="margin-bottom-40 regular-24">Завершающиеся аукционы — купить лот, выставить лот</h2>
	<ul class="lots-list list-unstyled row">
	@for ($i=0;$i<8;$i++)
		<li class="lots-item col-xs-6 col-sm-6 col-md-6 col-lg-6 margin-bottom-20">
			<div class="row">
				<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
					<a class="img-cont text-center" href="#">
						<img src="http://goldprice.org/buying-gold/uploaded_images/Australian-Lunar-Gold-Coin-Series-768203.jpg" alt="">
					</a>
				</div>
				<div class="lots-desc col-xs-8 col-sm-8 col-md-8 col-lg-8 regular-14 relative">
					<a href="#">1/2 копейки 1899 1909 1912 1913 спб древняя спарта</a>
					<div class="margin-top-5">
						<span class="fa fa-credit-card"></span> <span>225 руб</span>
					</div>
					<div class="bottom-left">
						<span class="fa fa-clock-o margin-right-5"></span> 11:25:12
					</div>
				</div>
			</div>
		</li>
	@endfor
	</ul>
</section>
			@yield('content')
			@if(isset($content))
				{{ $content }}
			@endif
<section class="coin-store margin-bottom-40">
	<h2 class="margin-bottom-40 regular-24">Магазин монет — купля(продажа) монет, банкнот, альбомов для монет</h2>
	<ul class="lots-list list-unstyled row">
	@for ($i=0;$i<8;$i++)
		<li class="lots-item col-xs-6 col-sm-6 col-md-6 col-lg-6 margin-bottom-20">
			<div class="row">
				<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
					<a class="img-cont" href="#">
						<img src="http://goldprice.org/buying-gold/uploaded_images/Australian-Lunar-Gold-Coin-Series-768203.jpg" alt="">
					</a>
				</div>
				<div class="lots-desc col-xs-8 col-sm-8 col-md-8 col-lg-8 regular-14 relative">
					<a href="#">1/2 копейки 1899 1909 1912 1913 спб древняя спарта</a>
					<div class="margin-top-5">
						<span class="fa fa-credit-card"></span> <span>225 руб</span>
					</div>
				</div>
			</div>
		</li>
	@endfor
	</ul>
</section>

 <article class="catalog row margin-bottom-40">
                    <section class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <h2 class="regular-20"><span class="fa fa-th-large"></span> Каталог товаров</h2>
                        <h3>Украшения из золота: <a href="#">687</a></h3>
                        <div>
                            Гарнитуры 19, Браслеты 39, Булавки и Броши 5,
                            Кулоны и Колье 57, Серьги 126, Кольца 243,
                            Пуссеты 29, Подвески 107, Мужские кольца 5, Брелоки 11, Цепочки 11
                        </div>
                        <h3>Украшения из серебра: <a href="#">359</a></h3>
                        Кольца 91, Серьги 42, Подвески 48, Браслеты 34, Колье 20, Брелоки 9
                    </section>
                    <section class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                        <h2 class="regular-20"><span class="fa fa-files-o"></span> Объявления</h2>
                        <ul class="news-list list-unstyled regular-12 margin-bottom-10">
                            <li class="news-item margin-bottom-10">
                                <div class="news-date reg-color-lighter margin-bottom-5">
                                    02.04.2014, Анатолий
                                </div>
                                <div class="news-text">
                                    <a href="#">4 Светодиодные линейки для ювелиров.</a>
                                </div>
                                <div class="news-town">
                                    город: Москва
                                </div>
                            </li>
                            <li class="news-item margin-bottom-10">
                                <div class="news-date reg-color-lighter margin-bottom-5">
                                    02.04.2014, Анатолий
                                </div>
                                <div class="news-text">
                                    <a href="#">Ювелирное производство</a>
                                </div>
                                <div class="news-town">
                                    город: Москва
                                </div>
                            </li>
                            <li class="news-item margin-bottom-10">
                                <div class="news-date reg-color-lighter margin-bottom-5">
                                    02.04.2014, Анатолий
                                </div>
                                <div class="news-text">
                                    <a href="#">Продается франшиза Danish Fashion Jewelry</a>
                                </div>
                                <div class="news-town">
                                    город: Москва
                                </div>
                            </li>
                            <li class="news-item margin-bottom-10">
                                <div class="news-date reg-color-lighter margin-bottom-5">
                                    02.04.2014, Анатолий
                                </div>
                                <div class="news-text">
                                    <a href="#">Продается франшиза Spinning Jewelery</a>
                                </div>
                                <div class="news-town">
                                    город: Москва
                                </div>
                            </li>
                        </ul>
                    </section>
                    <section class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                        <h2 class="regular-20"><span class="fa fa-comments-o "></span> Обсуждения</h2>
                        <ul class="news-list list-unstyled regular-12 margin-bottom-10">
                            <li class="news-item margin-bottom-10">
                                <div class="news-date reg-color-lighter margin-bottom-5">
                                    02.04.2014, Анатолий
                                </div>
                                <div class="news-text">
                                    <a href="#">Яндекс отключил ссылочное ранжирование</a>
                                </div>
                            </li>
                            <li class="news-item margin-bottom-10">
                                <div class="news-date reg-color-lighter margin-bottom-5">
                                    02.04.2014, Анатолий
                                </div>
                                <div class="news-text">
                                    <a href="#">Как создать свой сайт-визитку</a>
                                </div>
                            </li>
                            <li class="news-item margin-bottom-10">
                                <div class="news-date reg-color-lighter margin-bottom-5">
                                    02.04.2014, Анатолий
                                </div>
                                <div class="news-text">
                                    <a href="#">Хочу снять крышку с процессора. Как и стоит ли?</a>
                                </div>
                            </li>
                            <li class="news-item margin-bottom-10">
                                <div class="news-date reg-color-lighter margin-bottom-5">
                                    02.04.2014, Анатолий
                                </div>
                                <div class="news-text">
                                    <a href="#">Продается франшиза Spinning Jewelery</a>
                                </div>
                            </li>
                        </ul>
                    </section>
                </article>

<article class="other row margin-bottom-40">
                    <section class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <h2 class="regular-20"><span class="fa fa-video-camera"></span> Видео</h2>
                        <ul class="videos list-unstyled row">
                            <li class="video-item col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="video-screen">
                                    <img src="http://itua.info/wp-content/uploads/2013/12/youtube-logo.png" alt="">
                                </div>
                                <div class="news-date reg-color-lighter margin-bottom-5">
                                    02.04.2014
                                </div>
                                <div class="news-text">
                                    <a href="#">Новая классификация продавцов ювелирного магазина</a>
                                </div>
                            </li>
                            <li class="video-item col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="video-screen">
                                    <img src="http://itua.info/wp-content/uploads/2013/12/youtube-logo.png" alt="">
                                </div>
                                <div class="news-date reg-color-lighter margin-bottom-5">
                                    02.04.2014
                                </div>
                                <div class="news-text">
                                    <a href="#">Розыгрыш кольца с бриллиантом 31.12.2013</a>
                                </div>
                            </li>
                            <li class="video-item col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="video-screen">
                                    <img src="http://itua.info/wp-content/uploads/2013/12/youtube-logo.png" alt="">
                                </div>
                                <div class="news-date reg-color-lighter margin-bottom-5">
                                    02.04.2014
                                </div>
                                <div class="news-text">
                                    <a href="#">Новая классификация продавцов ювелирного магазина</a>
                                </div>
                            </li>
                            <li class="video-item col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="video-screen">
                                    <img src="http://itua.info/wp-content/uploads/2013/12/youtube-logo.png" alt="">
                                </div>
                                <div class="news-date reg-color-lighter margin-bottom-5">
                                    02.04.2014
                                </div>
                                <div class="news-text">
                                    <a href="#">Розыгрыш кольца с бриллиантом 31.12.2013</a>
                                </div>
                            </li>
                        </ul>
                    </section>
                    <section class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                        <h2 class="regular-20 margin-bottom-15"><span class="fa fa-book"></span> Книги</h2>
                        <ul class="list-unstyled">
                            <li class="book-item margin-bottom-20">
                                <div class="book-head row">
                                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                        <img class="book-pict" src="http://tobiasmastgrave.files.wordpress.com/2011/10/necronomicon-by-richard-a-poppe.jpg" alt="">
                                    </div>
                                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 regular-10">
                                        <div class="book-name margin-top-10">
                                            Некрономикон
                                        </div>
                                        <div class="book-author">
                                            Абдул Аль-Хазред
                                        </div>
                                    </div>
                                </div>
                                <div class="margin-top-5 regular-12">
                                    <a href="#">4 Светолиодные линейки для ювелиров</a>
                                </div>
                            </li>
                            <li class="book-item margin-bottom-20">
                                <div class="book-head row">
                                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                        <img class="book-pict" src="http://tobiasmastgrave.files.wordpress.com/2011/10/necronomicon-by-richard-a-poppe.jpg" alt="">
                                    </div>
                                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 regular-10">
                                        <div class="book-name margin-top-10">
                                            Некрономикон
                                        </div>
                                        <div class="book-author">
                                            Абдул Аль-Хазред
                                        </div>
                                    </div>
                                </div>
                                <div class="margin-top-5 regular-12">
                                    <a href="#">4 Светолиодные линейки для ювелиров</a>
                                </div>
                            </li>
                            <li class="book-item margin-bottom-20">
                                <div class="book-head row">
                                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                        <img class="book-pict" src="http://tobiasmastgrave.files.wordpress.com/2011/10/necronomicon-by-richard-a-poppe.jpg" alt="">
                                    </div>
                                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 regular-10">
                                        <div class="book-name margin-top-10">
                                            Некрономикон
                                        </div>
                                        <div class="book-author">
                                            Абдул Аль-Хазред
                                        </div>
                                    </div>
                                </div>
                                <div class="margin-top-5 regular-12">
                                    <a href="#">4 Светолиодные линейки для ювелиров</a>
                                </div>
                            </li>
                        </ul>
                    </section>
                    <section class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                        <h2 class="regular-20"><span class="fa fa-edit"></span> Блоги</h2>
                        <ul class="news-list list-unstyled regular-12 margin-bottom-10">
                            <li class="news-item margin-bottom-10">
                                <div class="news-date reg-color-lighter margin-bottom-5">
                                    02.04.2014, Анатолий
                                </div>
                                <div class="news-text">
                                    <a href="#">Яндекс отключил ссылочное ранжирование</a>
                                </div>
                            </li>
                            <li class="news-item margin-bottom-10">
                                <div class="news-date reg-color-lighter margin-bottom-5">
                                    02.04.2014, Анатолий
                                </div>
                                <div class="news-text">
                                    <a href="#">Яндекс отключил ссылочное ранжирование</a>
                                </div>
                            </li>
                            <li class="news-item margin-bottom-10">
                                <div class="news-date reg-color-lighter margin-bottom-5">
                                    02.04.2014, Анатолий
                                </div>
                                <div class="news-text">
                                    <a href="#">Яндекс отключил ссылочное ранжирование</a>
                                </div>
                            </li>
                            <li class="news-item margin-bottom-10">
                                <div class="news-date reg-color-lighter margin-bottom-5">
                                    02.04.2014, Анатолий
                                </div>
                                <div class="news-text">
                                    <a href="#">Яндекс отключил ссылочное ранжирование</a>
                                </div>
                            </li>
                            <li class="news-item margin-bottom-10">
                                <div class="news-date reg-color-lighter margin-bottom-5">
                                    02.04.2014, Анатолий
                                </div>
                                <div class="news-text">
                                    <a href="#">Яндекс отключил ссылочное ранжирование</a>
                                </div>
                            </li>
                            <li class="news-item margin-bottom-10">
                                <div class="news-date reg-color-lighter margin-bottom-5">
                                    02.04.2014, Анатолий
                                </div>
                                <div class="news-text">
                                    <a href="#">Яндекс отключил ссылочное ранжирование</a>
                                </div>
                            </li>
                        </ul>
                    </section>
                </article>

		</div>
	</main>
	@include('templates.default.footer')
	@include('templates.default.scripts')
	@yield('scripts')
</body>
</html>