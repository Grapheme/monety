@extends('templates.dashboard')
@section('style')
<link rel="stylesheet" href="{{slink::path('css/redactor.css')}}" />
<link rel="stylesheet" href="{{slink::path('theme/css/smart-form.css')}}" />
<link rel="stylesheet" href="{{slink::path('theme/css/select2.css')}}" />
<link rel="stylesheet" href="{{slink::path('theme/css/smartNotification.css')}}" />
<link rel="stylesheet" href="{{slink::path('theme/css/dropzone.css')}}" />
@stop
@section('content')
<section class="form-example">
	@include('user-cabinet.forms.catalog.register-lot-form')
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
		}
	</script>
	<script src="{{slink::path('js/vendor/redactor.min.js')}}"></script>
	<script src="{{slink::path('js/system/redactor-config.js')}}"></script>
@stop