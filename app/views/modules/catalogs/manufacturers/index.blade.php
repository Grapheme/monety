@extends('templates.'.AuthAccount::getStartPage())
@section('content')
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="pull-right margin-bottom-25 margin-top-10 ">
			@if(Allow::valid_action_permission('catalogs','create'))
				<a class="btn btn-primary" href="{{slink::createAuthLink('catalogs/manufacturers/create')}}">Добавить производителя</a>
			@endif
			</div>
		</div>
	</div>
	@if($manufacturers->count())
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th class="text-center">Изображения</th>
						<th class="text-center">Название</th>
					@if(Allow::valid_action_permission('catalogs','publication'))
						<th class="text-center">Публикация</th>
					@endif
						<th></th>
					</tr>
				</thead>
				<tbody>
				@foreach($manufacturers as $manufacturer)
					<tr>
						<td class="wigth-120">
						@if(!empty($manufacturer->logo))
							<figure class="avatar-container">
								<img src="{{url('image/catalog-manufacturer/'.$manufacturer->id)}}" alt="{{ $manufacturer->title }}" class="avatar bordered circle">
							</figure>
						@endif
						</td>
						<td><a href="{{slink::createLink('manufacturer/'.$manufacturer->seo_url)}}" target="_blank">{{ $manufacturer->title }}</a></td>
						@if(Allow::valid_action_permission('catalogs','publication'))
						<td class="wigth-100">
							<div class="smart-form">
								<label class="toggle pull-left">
									<input type="checkbox" name="publication" disabled="" checked="" value="1">
									<i data-swchon-text="да" data-swchoff-text="нет"></i>
								</label>
							</div>
						</td>
						@endif
						<td class="wigth-250">
						@if(Allow::valid_action_permission('catalogs','edit'))
							<a class="btn btn-labeled btn-success pull-left margin-right-10" href="{{slink::createAuthLink('catalogs/manufacturers/edit/'.$manufacturer->id)}}">
								<span class="btn-label"><i class="fa fa-edit"></i></span> Ред.
							</a>
						@endif
						@if(Allow::valid_action_permission('catalogs','delete'))
							<form method="POST" action="{{slink::createAuthLink('catalogs/manufacturers/destroy/'.$manufacturer->id)}}">
								<button type="button" class="btn btn-labeled btn-danger remove-catalog-manufacturer">
									<span class="btn-label"><i class="fa fa-trash-o"></i></span> Удал.
								</button>
							</form>
						@endif
						</td>
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
					В данном разделе находятся виды производители продукций
					<p><br><i class="regular-color-light fa fa-th-list fa-3x"></i></p>
				</div>
			</div>
		</div>
	</div>
	@endif
@stop
@section('scripts')
	<script src="{{slink::path('js/modules/catalogs.js')}}"></script>
	<script type="text/javascript">
		if(typeof pageSetUp === 'function'){pageSetUp();}
		if(typeof runFormValidation === 'function'){
			loadScript("{{asset('js/vendor/jquery-form.min.js');}}",runFormValidation);
		}else{
			loadScript("{{asset('js/vendor/jquery-form.min.js');}}");
		}
	</script>
@stop