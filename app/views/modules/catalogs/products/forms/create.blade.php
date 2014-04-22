{{ Form::open(array('url'=>slink::createAuthLink('catalogs/products/store'),'role'=>'form','class'=>'smart-form','id'=>'catalog-product-form','method'=>'post','files' => true)) }}
	<div class="row margin-top-10">
		<section class="col col-6">
			<div class="well">
				<header>Для создания продукта заполните форму:</header>
				<fieldset>
				@if(!empty($data_fields))
					@foreach($data_fields as $field)
						<section>
						@if(!empty($field->name))
							@if($field->type == 'input')
								<label class="label">{{ $field->label }}</label>
								<label class="input">
									{{ Form::text($field->name,NULL) }}
								</label>
							@elseif($field->type == 'textarea')
								<label class="label">{{ $field->label }}</label>
								<label class="textarea">
									{{ Form::textarea($field->name,NULL,array('class'=>'redactor')) }}
								</label>
							@elseif($field->type == 'file')
								@if(Allow::valid_access('downloads'))
								<label class="label">{{ $field->label }}</label>
								<label class="input input-file" for="{{ $field->name }}">
									<div class="button"><input type="file" onchange="this.parentNode.nextSibling.value = this.value" name="{{ $field->name }}">Выбрать</div><input type="text" readonly="" placeholder="Выбирите файл">
								</label>
								@endif
							@elseif($field->type == 'checkbox')
								<div class="row">
									<div class="col col-10">
										<label class="checkbox">
											<input type="checkbox" name="{{ $field->name }}">
											<i></i>{{ $field->label }}
										</label>
									</div>
								</div>
							@endif
						@endif
						</section>
					@endforeach
				@else
					<section>
						<div class="alert alert-danger alert-block padding-10"><i class="fa-fw fa fa-warning"></i> Отсутствуют информационные поля</div>
					</section>
				@endif
				@if($catalogs->count() > 1)
					<section>
						<label class="label">Каталог продукции:</label>
						<label class="select">
							@foreach($catalogs as $catalog)
								<?php $catalogList[$catalog->id] = $catalog->title;?>
							@endforeach
							{{ Form::select('catalog_id', $catalogList,NULL, array('autocomplete'=>'off')) }} <i></i>
						</label>
					</section>
				@else
					{{ Form::hidden('catalog_id',$catalogs->first()->id) }}
				@endif
				@if($category_groups->count() > 1)
					<section>
						<label class="label">Группа категорий:</label>
						<label class="select">
							@foreach($category_groups as $category_group)
								<?php $categoryGroupList[$category_group->id] = $category_group->title;?>
							@endforeach
							{{ Form::select('category_group_id', $categoryGroupList,NULL, array('autocomplete'=>'off')) }} <i></i>
						</label>
					</section>
				@elseif($category_groups->count() == 1)
					{{ Form::hidden('category_group_id',$category_groups->first()->id) }}
				@else
					{{ Form::hidden('category_group_id',0) }}
				@endif
					<section>
						<label class="label">Теги</label>
						<label class="input">
							{{ Form::text('tags','') }}
						</label>
						<div class="note">разделяются запятой</div>
					</section>
				</fieldset>
				<footer>
					<a class="btn btn-default no-margin regular-10 uppercase pull-left btn-spinner" href="{{URL::previous()}}">
						<i class="fa fa-arrow-left hidden"></i> <span class="btn-response-text">Назад</span>
					</a>
					<button type="submit" autocomplete="off" class="btn btn-success no-margin regular-10 uppercase btn-form-submit">
						<i class="fa fa-spinner fa-spin hidden"></i> <span class="btn-response-text">Создать</span>
					</button>
				</footer>
			</div>
		</section>
	@if(Allow::enabled_module('seo'))
		<section class="col col-6">
			<div class="well">
				@include('modules.seo.catalog-product')
			</div>
		</section>
	@endif
	</div>
{{ Form::close() }}