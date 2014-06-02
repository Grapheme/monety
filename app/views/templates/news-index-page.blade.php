@if(isset($news) && $news->count())
<ul class="news-list list-unstyled regular-12 margin-bottom-10">
	@foreach($news as $new)
	<li class="news-item margin-bottom-10">
		<div class="news-date reg-color-lighter margin-bottom-5">{{ myDateTime::SwapDotDateWithoutTime($new->date_publication,TRUE) }}</div>
		<div class="news-text">
			<a href="{{slink::createLink('news/'.$new->seo_url)}}">{{$new->title}}</a>
		</div>
	</li>
	 @endforeach
</ul>
<div class="under-info">
	<a href="{{ slink::createLink('news') }}"><i class="fa fa-calendar"></i> Архив новостей</a>
	<a href="#"><i class="fa fa-pencil"></i> Подписка на новости</a>
</div>
@endif