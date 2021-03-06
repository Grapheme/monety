@extends('templates.dashboard')
@section('style')
<link rel="stylesheet" href="{{slink::path('css/redactor.css')}}" />
<link rel="stylesheet" href="{{slink::path('theme/css/smart-form.css')}}" />
<link rel="stylesheet" href="{{slink::path('theme/css/select2.css')}}" />
<link rel="stylesheet" href="{{slink::path('theme/css/dropzone.css')}}" />
@stop
@section('content')
<section class="form-example">
	<div id="div-register-lot-form">
		@include('user-cabinet.forms.catalog.register-lot-form')
	</div>
	<div id="register-lot-other-actions" style="display: none;">
		<div class="alert alert-info fade in">
			<i class="fa-fw fa fa-info"></i>
			<strong id="register-lot-response-text"></strong>
			<ul>
			@if(Input::has('product_id'))
				<li><a href="{{ slink::createAuthLink('register-lot?product_id='.Input::get('product_id')) }}"> Выставить еще лот</a></li>
			@else
				<li><a href="{{ slink::createAuthLink('register-lot') }}"> Выставить еще лот</a></li>
			@endif
				<li><a href="javascript:void(0);"> К списку выставленных лотов</a></li>
				<li><a href="javascript:void(0);"> Перейти на страницу лота</a></li>
				<li><a href="{{ slink::createAuthLink('register-lot/new-catalog-product') }}"> Добавить в каталог новый товар </a></li>
			</ul>
		</div>
	</div>
</section>
@stop
@section('scripts')
	{{HTML::script('js/account/user.js')}}
	<script src="{{slink::path('js/vendor/dropzone.min.js')}}"></script>
	<script src="{{slink::path('js/vendor/select2.min.js')}}"></script>
	<script type="text/javascript">
		if(typeof pageSetUp === 'function'){pageSetUp();}
		if(typeof runFormValidation === 'function'){
			loadScript("{{asset('js/vendor/jquery-form.min.js');}}",runFormValidation);
		}else{
			loadScript("{{asset('js/vendor/jquery-form.min.js');}}");
		};
		window.onbeforeunload = function(){
			if(BASIC.inputChanged === true){
				return "Покинуть страницу? Все не сохраненные данные будут утеряны! Продолжить?";
			}else{
				return null;
			}
		};
	</script>
	<script src="{{slink::path('js/vendor/redactor.min.js')}}"></script>
	<script src="{{slink::path('js/system/redactor-config.js')}}"></script>
@stop