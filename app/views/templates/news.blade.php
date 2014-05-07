@extends('templates.default')
@section('style')
<link rel="stylesheet" href="{{ slink::path('css/fancybox.css') }}" />
@stop
@section('content')
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
			<h2>{{$news->title}}</h2>
			<p><span class="glyphicon glyphicon-time"></span> {{ myDateTime::SwapDotDateWithTime($news->created_at) }}</p>
		@if($news->thumbnail_image && $news->original_image)
			<div>
				<a class="fancybox" data-fancybox-type="image" href="{{ url('image/news/'.$news->id) }}">
					<img src="{{ url('image/news-thumbnail/'.$news->id) }}" alt="{{ $news->title }}" />
				</a>
			</div>
		@endif
			<div>
				{{ sPage::content_render($news->content) }}
			</div>
		</div>
	</div>
@stop
@section('scripts')
<script src="{{ slink::path('js/vendor/jquery.fancybox.pack.js') }}"></script>
<script type="text/javascript">
	$(".fancybox").fancybox({type : "image",padding: 15,helpers: {overlay: {locked: false}}});
</script>
@stop