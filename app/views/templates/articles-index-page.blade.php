@if(isset($articles) && $articles->count())
<ul class="artcl-list list-unstyled regular-12 margin-bottom-10">
	@foreach($articles as $article)
	<li class="artcl-item margin-bottom-10">
		<a href="{{slink::createLink('articles/'.$article->seo_url)}}">{{$article->title}}</a>
	</li>
	@endforeach
</ul>
<footer class="margin-bottom-10">
	<a href="{{ url('articles') }}" class="reg-color-light regular-12"><span class="fa fa-list-ul"></span> Все публикации</a>
</footer>
 @endif