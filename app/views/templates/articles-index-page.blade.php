@if(isset($articles) && $articles->count())
<ul class="artcl-list list-unstyled regular-12 margin-bottom-10">
	@foreach($articles as $article)
	<li class="artcl-item margin-bottom-10">
		<a href="{{ slink::createLink('articles/'.$article->seo_url) }}">{{$article->title}}</a>
	</li>
	@endforeach
</ul>
<div class="under-info">
	<a href="{{ slink::createLink('articles') }}"><i class="fa fa-list-ul"></i> Все публикации</a>
</div>
@endif