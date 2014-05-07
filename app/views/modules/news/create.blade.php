@extends('templates.'.AuthAccount::getStartPage())
@section('style')
<link rel="stylesheet" href="{{slink::path('css/redactor.css')}}" />
@stop
@section('content')
	@include('modules.news.forms.create')
@stop
@section('scripts')
	{{HTML::script('js/modules/news.js')}}
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
	<script src="{{slink::path('js/vendor/jquery.ui.datepicker-ru.js')}}"></script>
	<script type="text/javascript">
		$(function(){
			$("#date_publication").datepicker({
				dateFormat: 'dd.mm.yyyy',
				prevText: '<i class="fa fa-chevron-left"></i>',
				nextText: '<i class="fa fa-chevron-right"></i>',
			});
		});
	</script>
@stop