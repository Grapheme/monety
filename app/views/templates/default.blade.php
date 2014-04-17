<!DOCTYPE html>
<html lang="en-us">
<head>
	@include('templates.default.head')
	@yield('style')
</head>
<body>
	<!--[if IE 7]><h1>Your browser is out of date, please update your browser by going to www.microsoft.com/download</h1><![endif]-->
	@include('templates.default.header')
	<div id="main" role="main">
		<div id="content" class="container">
		@yield('content')
		@if(isset($content))
			{{ $content }}
		@endif
		</div>
		@include('templates.default.footer')
	</div>
	@include('templates.default.scripts')
	@yield('scripts')
</body>
</html>