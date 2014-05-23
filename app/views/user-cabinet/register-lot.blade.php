@extends('templates.dashboard')
@section('style')
<link rel="stylesheet" href="{{slink::path('css/redactor.css')}}" />
@stop
@section('content')
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		@include('user-cabinet.forms.catalog.register-lot-form')
	</div>
</div>
@stop
@section('scripts')
	{{HTML::script('js/account/user.js')}}
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
	<script src="{{slink::path('js/vendor/dropzone.min.js')}}"></script>
@stop