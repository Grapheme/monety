@if(isset($news) && $news->count())
	<ul class="pop-offers-list list-unstyled">
	@foreach($news as $new)
		<li class="pop-offers-item">
		@if(!empty($new->thumbnail_image))
			<img src="{{ slink::path('image/news-thumbnail/'.$new->id) }}" alt="{{ $new->title }}" />
		@endif
			<div class="pop-item-expires">
				<a href="{{ slink::createLink('news/'.$new->seo_url) }}">{{ $new->title }}</a>
				<div class="">
					{{$new->preview}}
				</div>
			</div>
		</li>
	@endforeach
	</ul>
	{{ $news->links() }}
@endif