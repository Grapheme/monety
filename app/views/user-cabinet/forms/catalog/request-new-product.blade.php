{{ Form::open(array('url'=>slink::createAuthLink('register-lot/request-new-product/store'),'role'=>'form','class'=>'smart-form','id'=>'request-product-form','method'=>'post','files' => true)) }}
	{{ Form::hidden('sort',0) }}
	{{ Form::hidden('price',0) }}
	{{ Form::hidden('catalog_id',$catalogs->first()->id) }}
	{{ Form::hidden('category_group_id',$category_groups->first()->id) }}
	{{ Form::hidden('template','product') }}
	<header>Для добавления продукта в каталог заполните форму:</header>
	<fieldset>
		<ul class="nav nav-tabs bordered" id="myTab1">
			<li class="active">
				<a data-toggle="tab" href="#data">Данные</a>
			</li>
		@if(!empty($data_fields) || !empty($productsExtendedAttributes))
			<li>
				<a data-toggle="tab" href="#advanced">Дополнительные данные</a>
			</li>
		@endif
			<li>
				<a data-toggle="tab" href="#options">Опции</a>
			</li>
		@if(Allow::valid_access('downloads'))
			<li>
				<a data-toggle="tab" href="#images">Изображения</a>
			</li>
		@endif
		</ul>
		<div class="tab-content margin-top-important-10" id="productTabContent">
			<div id="data" class="tab-pane fade active in">
				<section>
					<label class="label">Название</label>
					<label class="input">
						{{ Form::text('title','') }}
					</label>
				</section>
			@if(Allow::valid_access('downloads'))
				<section>
					<label class="label">Основное изображение</label>
					<label class="input input-file" for="file">
						<div class="button"><input type="file" onchange="this.parentNode.nextSibling.value = this.value" name="file">Выбрать</div><input type="text" readonly="" placeholder="Выбирите файл">
					</label>
				</section>
			@endif
				<section>
					<label class="label">Описание</label>
					<label class="textarea">
						{{ Form::textarea('description','',array('class'=>'redactor')) }}
					</label>
				</section>
			</div>
			<div id="advanced" class="tab-pane fade">
		@if(!empty($data_fields))
			@foreach($data_fields as $field)
				<section>
				@if(!empty($field->name))
					@if($field->type == 'input')
						<label class="label">{{ $field->label }}</label>
						<label class="input">
							{{ Form::text('attribute['.$field->name.']',NULL) }}
						</label>
					@elseif($field->type == 'textarea')
						<label class="label">{{ $field->label }}</label>
						<label class="textarea">
							{{ Form::textarea('attribute['.$field->name.']',NULL,array('class'=>'redactor')) }}
						</label>
					@elseif($field->type == 'checkbox')
						<div class="row">
							<div class="col col-10">
								<label class="checkbox">
									<input type="checkbox" name="{{ 'attribute['.$field->name.']' }}">
									<i></i>{{ $field->label }}
								</label>
							</div>
						</div>
					@endif
				@endif
				</section>
			@endforeach
		@endif
		@if(!empty($productsExtendedAttributes))
			@foreach($productsExtendedAttributes as $attrName => $attributes)
				<section>
					<?php $productAttr = array();?>
					<label class="label">{{ $attrName }}</label>
					<label class="select">
						@foreach($attributes as $attribute)
							<?php $productAttr[$attribute->title] = $attribute->title;?>
						@endforeach
						{{ Form::select('attribute['.$attrName.']', $productAttr,NULL, array('autocomplete'=>'off')) }} <i></i>
					</label>
				</section>
			@endforeach
		@endif
			</div>
			<div id="options" class="tab-pane fade">
			@if(!empty($categories))
				<section>
					<label class="label">Категория:</label>
					<label class="select">
						<select class="select2" name="categories" autocomplete="off">
						@foreach($categories as $category_title => $category)
							<optgroup label="{{ $category_title }}">
							@if(!empty($category['sub_categories']))
								@foreach($category['sub_categories'] as $sub_category)
								<option value="{{ $sub_category['id'] }}">{{ $sub_category['title'] }}</option>
								@endforeach
							@endif
							</optgroup>
						@endforeach
						</select>
					</label>
				</section>
			@else
				{{ Form::hidden('category',0) }}
			@endif
				<section>
					<label class="label">Теги</label>
					<label class="input">
						{{ Form::text('tags','') }}
					</label>
					<div class="note">разделяются запятой</div>
				</section>
			</div>
		@if(Allow::valid_access('downloads'))
			<div id="images" class="tab-pane fade">
				<div action="{{ slink::createAuthLink('register-lot/new-catalog-product/upload-product-photo') }}" class="dropzone dz-clickable" id="ProductImageDropZone"></div>
			</div>
		@endif
		</div>
	</fieldset>
	<fieldset>
		<div class="row">
			<div class="alert alert-warning fade in">
				<i class="fa-fw fa fa-warning"></i>
				<strong>Внимание!</strong> Товар появится в каталоге после проверки его администрацией сайта
			</div>
		</div>
	</fieldset>
	<footer>
		<a class="btn btn-default no-margin regular-10 uppercase pull-left btn-spinner" href="{{URL::previous()}}">
			<i class="fa fa-arrow-left hidden"></i> <span class="btn-response-text">Назад</span>
		</a>
		<button type="submit" autocomplete="off" class="btn btn-success no-margin regular-10 uppercase btn-form-submit">
			<i class="fa fa-spinner fa-spin hidden"></i> <span class="btn-response-text">Создать</span>
		</button>
	</footer>
{{ Form::close() }}