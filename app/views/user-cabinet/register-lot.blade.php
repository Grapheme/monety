@extends('templates.dashboard')
@section('style')
<link rel="stylesheet" href="{{slink::path('css/redactor.css')}}" />
<link rel="stylesheet" href="{{slink::path('theme/css/smart-form.css')}}" />
<link rel="stylesheet" href="{{slink::path('theme/css/select2.css')}}" />
@stop
@section('content')
<div class="row">
	 <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 main-cont">
	 	<section class="form-example">
			@include('user-cabinet.forms.catalog.register-lot-form')
		</section>
	</div>
</div>
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
		}
	</script>
	<script src="{{slink::path('js/vendor/redactor.min.js')}}"></script>
	<script src="{{slink::path('js/system/redactor-config.js')}}"></script>
@stop