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
		<div class="special-offers">
			<h2 class="margin-bottom-20 regular-24 text-center txt-color-white">Специальные предложения</h2>
			<ul class="offers-list list-unstyled no-margin text-center">
			@for($i=0;$i<5;$i++)
				<li class="offers-item display-inline margin-bottom-20">
					<div class="offers-head margin-bottom-10">
						<a href="#" class="typical-link display-inline width-130">1/2 копейки 1899 1909 1912 1913 спб пол коп</a>
					</div>
					<div class="offers-body">
						<figure class="ava">
							<a href="#"><img class="circle" src="http://upload.wikimedia.org/wikipedia/commons/c/c5/Abraham_Lincoln_$1_Presidential_Coin_obverse_sketch.jpg" alt=""></a>
						</figure>
					</div>
				</li>
			@endfor
			</ul>
		</div>
		@include('templates.default-sidebar')
		<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 main-cont">
			@yield('content')
			@if(isset($content))
				{{ $content }}
			@endif
		</div>
	</main>
	@include('templates.default.footer')
	@include('templates.default.scripts')
	@yield('scripts')
</body>
</html>