@if(isset($news) && $news->count())
<ul class="news-list list-unstyled regular-12 margin-bottom-10">
	@foreach($news as $new)
	<li class="news-item margin-bottom-10">
		<div class="news-date reg-color-lighter margin-bottom-5">{{ myDateTime::SwapDotDateWithTime($new->created_at) }}</div>
		<div class="news-text">
			<a href="{{slink::createLink('news/'.$new->seo_url)}}">{{$new->title}}</a>
		</div>
	 </li>
	 @endforeach
</ul>
<footer>
	<div class="margin-bottom-10">
		 <a class="reg-color-light regular-12" href="{{ url('news') }}"><span class="fa fa-calendar"></span> Архив новостей</a>
	</div>
	<div>
		 <a class="reg-color-light regular-12" href="#"><span class="fa fa-pencil-square-o"></span> Подписка на новости</a>
	</div>
 </footer>
 @endif