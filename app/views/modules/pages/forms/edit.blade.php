{{ Form::model($page,array('url'=>slink::createAuthLink('pages/update/'.$page->id),'class'=>'smart-form','id'=>'page-form','role'=>'form','method'=>'post')) }}
	<div class="row margin-top-10">
		<section class="col col-6">
			<div class="well">
				<header>Для создания страницы заполните форму:</header>
				<fieldset>
					<section>
						<label class="label">Название</label>
						<label class="input"> <i class="icon-append fa fa-list-alt"></i>
							{{ Form::text('name',NULL) }}
						</label>
					</section>
				@if(Allow::valid_access('languages') && !empty($languages))
					<section>
						<label class="label">Язык:</label>
						<label class="select">
							<select class="lang-change" name="language" autocomplete="off">
							@foreach($languages as $language)
								<option value="{{$language['code']}}">{{$language['name']}}</option>
							@endforeach
							</select> <i></i>
						</label>
					</section>
				@endif
				@if(Allow::valid_access('templates'))
					<section>
						<label class="label">Шаблон:</label>
						<label class="select">
							<select class="lang-change" name="template" autocomplete="off">
								<option value="default">default</option>
							@foreach($templates as $template)
								 <option value="{{$template->id}}">{{$template->name}}</option>
							@endforeach
							</select> <i></i>
						</label>
					</section>
				@endif
					<section>
						<label class="label">Содержание</label>
						<label class="textarea">
							{{ Form::textarea('content',NULL,array('class'=>'redactor-no-filter')) }}
						</label>
					</section>
					@if(Page::count() && Request::segment(3) == 'create')
					<section class="pull-right">
						<label class="toggle">
							<input type="checkbox" name="in_menu" value="1">
							<i data-swchon-text="да" data-swchoff-text="нет"></i>Показывать в меню: 
						</label>
					</section>
					@endif
				</fieldset>
				<footer>
					<a class="btn btn-default no-margin regular-10 uppercase pull-left btn-spinner" href="{{URL::previous()}}">
						<i class="fa fa-arrow-left hidden"></i> <span class="btn-response-text">Назад</span>
					</a>
					<button type="submit" autocomplete="off" class="btn btn-success no-margin regular-10 uppercase btn-form-submit">
						<i class="fa fa-spinner fa-spin hidden"></i> <span class="btn-response-text">Сохранить</span>
					</button>
				</footer>
			</div>
		</section>
	@if(Allow::enabled_module('seo'))
		<section class="col col-6">
			<div class="well">
				@include('modules.seo.pages')
			</div>
		</section>
	@endif
	</div>
{{ Form::close() }}