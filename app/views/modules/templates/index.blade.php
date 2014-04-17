@extends('templates.'.AuthAccount::getStartPage())
@section('content')
@if(Allow::valid_action_permission('templates','create'))
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="pull-right margin-bottom-25 margin-top-10 ">
			<a class="btn btn-primary" href="{{slink::createAuthLink('templates/create')}}">Добавить шаблон</a>
		</div>
	</div>
</div>
@endif;
@if($templates->count())
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th class="col-lg-10 text-center">Название шаблона</th>
					<th class="col-lg-10 text-center">Путь к шаблону</th>
					<th class="col-lg-1 text-center"></th>
				</tr>
			</thead>
			<tbody>
			@foreach($templates as $template)
				<tr>
					<td>{{ $template->name }}</td>
					<td>{{ $template->name }}</td>
					<td>
						@if(Allow::valid_action_permission('templates','edit'))
							<a class="btn btn-labeled btn-success pull-left margin-right-10" href="{{slink::createAuthLink('templates/edit/'.$template->id)}}">
								<span class="btn-label"><i class="fa fa-edit"></i></span> Ред.
							</a>
						@endif
						@if(Allow::valid_action_permission('templates','delete'))
							<form method="POST" action="{{slink::createAuthLink('templates/destroy/'.$template->id)}}">
								<button type="button" class="btn btn-labeled btn-danger remove-template">
									<span class="btn-label"><i class="fa fa-trash-o"></i></span> Удал.
								</button>
							</form>
						@endif
						</td>
					<td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>
</div>
@else
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="ajax-notifications custom">
			<div class="alert alert-transparent">
				<h4>Список пуст</h4>
				В данном разделе находятся шаблоны
				<p><br><i class="regular-color-light fa fa-th-list fa-3x"></i></p>
			</div>
		</div>
	</div>
</div>
@endif;
@stop
@section('scripts')
<script>
	$.fn.ajax_delete = function(){
		$(this).each(function(){
			$_tr = $(this);
			$_form = $(this).find('.ajax_delete');
			$_form.on('submit', function(event){
				event.preventDefault();
				$.ajax({
					url: $_form.attr('action'),
					data: $_form.serialize(),
					type: 'post'
				}).fail(function(data){
					console.log(data);
				}).done(function(data){
					$_tr.fadeOut();
					console.log(data);
				});
			});
		});
	}
	$('.news-item').ajax_delete();
</script>
@stop